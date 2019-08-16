{include file='header.tpl'}
<div id="body_leftCol">
		{$s_pageSecondaryMenu}
		{$s_newsCat}
		{$s_newsLast}
		{$s_annonceLast}
		{$s_bannerLeft}
	</div>
	<div id="body_mainCol">
		{$s_bannerTop}
  		<div id="page_navBar"><p>{$s_pagePathWay}</p></div>
  		<h1>{$s_pageTitle}</h1>
		{$s_pageContent}
		{if isset($smarty.get.view)}
			{$s_bannerBottom}
		{/if}
		<div class="clearBoth"></div>
  	</div>
	<div class="clearBoth"></div>
</div>
{include file='footer.tpl'}