<?php

/**
 * Shopware 5 Plugin
 * Copyright © SO-DSGN
 */

class Shopware_Plugins_Backend_SoSocialmedia_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
    public function getInfo()
    {
        return array(
            'version' => $this->getVersion(),
            'label' => $this->getLabel(),
            'author' => 'Soeren Oehding',
            'supplier' => 'SO_DSGN',
            'description' => 'Bietet die Möglichkeit verschiedene Socialmedia Kanäle in Ihren Shop einzubuinden. Desweiteren stehen Ihnen Socialmedia Buttons als Widget in den Einkaufswelten zur Verfrügung.',
            'support' => 'Shopware Forum',
            'link' => 'https://so-dsgn.de'
        );
    }

    public function getLabel()
    {
        return 'SO_DSGN Socialmedia';
    }

    public function getVersion()
    {
        return "1.0.0";
    }

    public function install()
    {
        $this->createPluginConfig();
        $this->createWidgetConfig();
        // Subscribe the needed event for less merge and compression
        $this->subscribeEvents();

        return array('success' => true, 'invalidateCache' => array('theme'));
    }


    /**
     * Registers all necessary events and hooks.
     */
    private function subscribeEvents()
    {
        // Subscribe the needed event for less merge and compression
        $this->subscribeEvent(
        'Theme_Compiler_Collect_Plugin_Less',
        'addLessFiles'
        );

        $this->subscribeEvent(
           'Shopware_Controllers_Widgets_Emotion_AddElement',
           'onEmotionAddElement'
        );

        $this->subscribeEvent(
            'Enlight_Controller_Action_PostDispatchSecure_Frontend',
            'onPostDispatchFrontend'
        );
    }

    /**
     * Provide the file collection for less
     *
     * @param Enlight_Event_EventArgs $args
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function addLessFiles(Enlight_Event_EventArgs $args)
    {
        $less = new \Shopware\Components\Theme\LessDefinition(
        //configuration
        array(
                'base_color' => $this->Config()->get('base_color'),
                'fb_color' => $this->Config()->get('fb_color'),
                'gp_color' => $this->Config()->get('gp_color'),
                'tw_color' => $this->Config()->get('tw_color'),
                'yt_color' => $this->Config()->get('yt_color')
            ),

            //less files to compile
            array(
                __DIR__ . '/Views/frontend/_public/src/less/all.less'
            ),

            //import directory
            __DIR__
        );

        return new Doctrine\Common\Collections\ArrayCollection(array($less));
    }


    public function onEmotionAddElement(Enlight_Event_EventArgs $arguments)
    {
        $controller = $arguments->getSubject();
        $config = $this->Config();
        $view = $controller->View();
        $data = $arguments->getReturn();
               
        $view->addTemplateDir($this->Path() . 'Views/');
        $data['fbUrl'] = $config->fb_url;
        $data['twUrl'] = $config->tw_url;
        $data['gpUrl'] = $config->gp_url;
        $data['ytUrl'] = $config->yt_url;
        return $data;
        
    }

    /**
    * Event listener method
    *
    * @param Enlight_Controller_ActionEventArgs $args
    */
    public function onPostDispatchFrontend(Enlight_Controller_ActionEventArgs $args)
    {
        $request = $args->getSubject()->Request();
        $view = $args->getSubject()->View();
        if ($request->isXmlHttpRequest()) {
            return;
        }
        $config = $this->Config();

        if($config->fontawesome_add){
            $view->addTemplateDir($this->Path() . 'Views/');
        }
    }


    public function uninstall()
    {
        return true;
    }



    /**
     * Create the Plugin Settings Form
     */
    function createPluginConfig()
    {
        $form = $this->Form();
        $parent = $this->Forms()->findOneBy(array('name' => 'Interface'));
        $form->setParent($parent);

        $form->setElement('checkbox', 'fontawesome_add', array(
            'label' => 'Fontawesome Icons über CDN einbinden?',
            'value' => true,
            'scope' => \Shopware\Models\Config\Element::SCOPE_SHOP
        ));

        $form->setElement('text', 'base_color', array(
            'scope' => Shopware\Models\Config\Element::SCOPE_SHOP, 
            'label' => 'Social Media Icon Grundfarbe',
            'value' => '@brand-secondary',
            'description' => 'Social Media Icon Grundfarbe'
        ));

        $form->setElement('text', 'fb_url', array(
            'scope' => Shopware\Models\Config\Element::SCOPE_SHOP, 
            'label' => 'Facebook URL',
            'value' => '#',
            'description' => 'Facebook URL'
        ));

        $form->setElement('text', 'fb_color', array(
            'scope' => Shopware\Models\Config\Element::SCOPE_SHOP, 
            'label' => 'Facebook Farbe Hover',
            'value' => '#3b5998',
            'description' => 'Facebook Farbe Hover'
        ));

        $form->setElement('text', 'tw_url', array(
            'scope' => Shopware\Models\Config\Element::SCOPE_SHOP, 
            'label' => 'Twitter URL',
            'value' => '#',
            'description' => 'Twitter URL'
        ));

        $form->setElement('text', 'tw_color', array(
            'scope' => Shopware\Models\Config\Element::SCOPE_SHOP, 
            'label' => 'Twitter Farbe Hover',
            'value' => '#00aced',
            'description' => 'Twitter Farbe Hover'
        ));

        $form->setElement('text', 'gp_url', array(
            'scope' => Shopware\Models\Config\Element::SCOPE_SHOP, 
            'label' => 'GooglePlus URL',
            'value' => '#',
            'description' => 'GooglePlus URL'
        ));

        $form->setElement('text', 'gp_color', array(
            'scope' => Shopware\Models\Config\Element::SCOPE_SHOP, 
            'label' => 'GooglePlus Farbe Hover',
            'value' => '#dd4b39',
            'description' => 'GooglePlus Farbe Hover'
        ));

        $form->setElement('text', 'yt_url', array(
            'scope' => Shopware\Models\Config\Element::SCOPE_SHOP, 
            'label' => 'YouTube URL',
            'value' => '#',
            'description' => 'YouTube URL'
        ));

        $form->setElement('text', 'yt_color', array(
            'scope' => Shopware\Models\Config\Element::SCOPE_SHOP, 
            'label' => 'Youtube Farbe Hover',
            'value' => '#bb0000',
            'description' => 'Youtube Farbe Hover'
        ));
    }

    /**
     * Create the Widget Settings Form
     */
    function createWidgetConfig() {
        // Add the emotion Komponent
        $component = $this->createEmotionComponent(
            array(
                'name' => 'Social Media Widget',
                'template' => 'emotion_socialmedia',
                'description' => 'Bindet Socialmedia Buttons als Widget in den Einkaufswelten ein. Die URLs werden in der Pluginkonfiguration hinterlegt (Pluginmanager)'
            )
        );
        $component->createCheckboxField(
            array(
                'name' => 'additional_styles',
                'fieldLabel' => 'Border Box',
                'supportText' => 'Zusätzliche Styles hinzufügen?',
                'helpTitle' => 'Border Box',
                'helpText' => 'Hier können sie dem widget einen optischen Rand verpassen um es optisch an das SW5 Responsive Theme anzupassen',
                'defaultValue' => true
            )   
        );
        $component->createCheckboxField(
            array(
                'name' => 'icons_round',
                'fieldLabel' => 'Runde Icons',
                'supportText' => 'Icons rund oder Eckig?',
                'helpTitle' => 'Runde Icons',
                'helpText' => 'Hier legen sie die Form der Socialmedia Icons fest: Rund oder Eckig',
                'defaultValue' => true
            )   
        );
        // Facebook
        $component->createCheckboxField(
            array(
                'name' => 'facebook_active',
                'fieldLabel' => 'Facebook',
                'supportText' => 'Facebook Button anzeigen',
                'defaultValue' => false
            )
        );

        // Google Plus
        $component->createCheckboxField(
            array(
                'name' => 'google_active',
                'fieldLabel' => 'GooglePlus',
                'supportText' => 'GooglePlus Button anzeigen',
                'defaultValue' => false
            )
        );

        // Twitter
        $component->createCheckboxField(
            array(
                'name' => 'twitter_active',
                'fieldLabel' => 'Twitter',
                'supportText' => 'Twitter Button anzeigen',
                'defaultValue' => false
            )
        );

        // Youtube
        $component->createCheckboxField(
            array(
                'name' => 'youtube_active',
                'fieldLabel' => 'YouTube',
                'supportText' => 'YouTube Button anzeigen',
                'defaultValue' => false
            )
        );
    }
}
