{include file='header.tpl'}
<div class="pageGrid" id="page_body">
	<div class="section group">
       	<div class="page_leftCol col span_3_12">
	       	{$s_modSecondaryMenu}
			{$s_fileLast}
			{$s_annonceLast}
			{$s_newsLast}
			{$s_bannerLeft}
		</div>
		
		<div class="page_wideCol col span_9_12">
       		{$s_bannerTop}
	  		<div id="page_navBar">
	  			<div style="font-weight:bold;">
	  				{$s_pagePathWay}
	  			</div>
	  		</div>
	  		<div class="main_colContent">
	  		<h1>{$s_pageTitle}</h1>
	  			{eval assign='scriptPage' var=$s_pageContent|extractBetween:$s_pageLang}
				{$scriptPage}
	  			<div class="clearBoth"></div>
	  		</div>
       	</div>
          	
    </div>
</div>
{include file='footer.tpl'}	