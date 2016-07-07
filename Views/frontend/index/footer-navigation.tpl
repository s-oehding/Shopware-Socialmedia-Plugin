{extends file="parent:frontend/index/footer-navigation.tpl"}

{block name="frontend_index_footer_column_newsletter" append}
{if $socialFooter}

	<div class="footer--column  is--last block icon-wrapper">
		<div class="column--headline">{s name="sFooterSocialHead"}Socialmedia{/s}</div>
		<div class="column--content js--collapse-target">
			<hr>
			<ul class="navigation--list block-group" role="menubar">
				{if $fbUrl}
				    <li class="navigation--entry" role="menuitem">
				        <a href="{$fbUrl}" title="" class="btn">
				            <i class="fa fa-facebook" aria-hidden="true"></i>
				        </a>
				    </li>
			    {/if}
				{if $twUrl}
				    <li class="navigation--entry" role="menuitem">
				        <a href="{$twUrl}" title="" class="btn">
				            <i class="fa fa-twitter" aria-hidden="true"></i>
				        </a>
				    </li>
			    {/if}
				{if $gpUrl}
				    <li class="navigation--entry" role="menuitem">
				        <a href="{$gpUrl}" title="" class="btn">
				            <i class="fa fa-google-plus" aria-hidden="true"></i>
				        </a>
				    </li>
			    {/if}
				{if $ytUrl}
				    <li class="navigation--entry" role="menuitem">
				        <a href="{$ytUrl}" title="" class="btn">
				            <i class="fa fa-youtube" aria-hidden="true"></i>
				        </a>
				    </li>
			    {/if}
			</ul>
		</div>
	</div>
{/if}
{/block}