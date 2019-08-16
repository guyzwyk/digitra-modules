<div style="margin:0.5em 0 1em 0;">
	<h3 class="hBoxTitle secondaryMenu" style="background-color:#0099cc;">{$s_eventCatSideBoxTitle}</h3>
	<div class="address">
		<ul class="sublinks">
		{foreach from=$s_arr_eventCat item=i}
			<li><img src="img/icon/diamond.gif" width="9" height="9" alt=" ">&nbsp;<a href="{$i.EVENT_CAT_URL}">{$i.EVENT_CAT_TITLE}</a> ({$i.EVENT_CAT_NB})</li>
		{/foreach}
		</ul>
	</div>
	<div class="clrBoth"></div>
</div>