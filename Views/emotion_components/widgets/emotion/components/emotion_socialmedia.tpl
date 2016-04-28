<div class="sm-wrapper {if $Data.additional_styles}panel has--border{/if}">
	<div class="icon-wrapper">
		{if $Data.facebook_active}
		  <a href="{$Data.fbUrl}" class="sm facebook {if $Data.icons_round} is--round {/if}">
		    <i class="fa fa-circle fa-stack-2x"></i>
		    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
		  </a>
		{/if}
		{if $Data.google_active}
		  <a href="{$Data.gpUrl}" class="sm gplus {if $Data.icons_round} is--round {/if}">
		    <i class="fa fa-circle fa-stack-2x"></i>
		    <i class="fa fa-google-plus fa-stack-1x fa-inverse"></i>  
		  </a>
		{/if}
		{if $Data.twitter_active}
		  <a href="{$Data.twUrl}" class="sm twitter {if $Data.icons_round} is--round {/if}">
		    <i class="fa fa-circle fa-stack-2x"></i>
		    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>   
		  </a>
		{/if}
		{if $Data.youtube_active}
		  <a href="{$Data.ytUrl}" class="sm youtube {if $Data.icons_round} is--round {/if}">
		    <i class="fa fa-circle fa-stack-2x"></i>
		    <i class="fa fa-youtube fa-stack-1x fa-inverse"></i>   
		  </a>
		{/if}
	</div>
</div>