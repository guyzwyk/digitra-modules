{include file='header.tpl'}
<!-- Body starts -->
		<div class="page_body page_grid">
			<div class="section group">

				<div class="col span_9_of_12">
					<div class="pageRow pageInner">
						{$s_bannerTop}
						{$s_pagePathWay}
						<h1>{$s_pageTitle}</h1>
						{eval assign='scriptPage' var=$s_pageContent|extractBetween:$s_pageLang}
						{$scriptPage}
						{$s_userLoginForm}
						{if isset($smarty.get.view)}
							{$s_bannerBottom}
						{/if}
						<div class="clearBoth"></div>
					</div>
				</div>
				<div class="col span_3_of_12 page_sideCol">
					<div class="pageRow">
						{$s_modSecondaryMenu}
						{$s_annonceLast}
						{$s_newsLast}
						{include file='useful_links.tpl'}
						{$s_bannerRight}
					</div>
				</div>
				<div class="clrBoth"></div>

			</div>
		</div>
<!--  // End of body -->
{include file='footer.tpl'}