<!-- EVENTS WIDGET : begin -->
<div class="widget events-widget">
	<div class="widget-inner">
		<h3 class="widget-title m-has-ico"><i class="widget-ico tp tp-calendar-full"></i>{$s_eventSideBoxTitle}</h3>
		<div class="widget-content">
			<ul class="event-list">
			{foreach from=$s_arr_eventLast item=i}
				<!-- EVENT : begin -->
				<li class="event m-has-date">
					<div class="event-inner">
						<div class="event-date" title="{$i.EVENT_START}">
							<span class="event-month">Jun</span>
							<span class="event-day">3</span>
						</div>
						<h4 class="event-title"><a href="{$i.EVENT_URL}">{$i.EVENT_TITLE}</a></h4>
					</div>
				</li>
				<!-- EVENT : end -->
			{/foreach}
			</ul>
			<p class="show-all-btn">{$s_eventPages}</p>
		</div>
	</div>
</div>
<!-- EVENTS WIDGET : end -->