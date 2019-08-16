<!-- EVENT LIST PAGE : begin -->
<div class="event-list-page event-page">

	{foreach from=$s_arr_eventCats item=i}
		<!-- GROUP TITLE : begin -->
		<h2 class="group-title">{$i.EVENT_START|date_format}</h2>
		<!-- GROUP TITLE : end -->
		<!-- EVENT : begin -->
		<article class="event">
			<div class="event-inner c-content-box m-no-padding">
				<!-- EVENT IMAGE : begin --> <!--
				<div class="event-image">
					<a href="{$i.EVENT_URL}"><img src="images/event-01-cropped.jpg" alt=""></a>
				</div> -->
				<!-- EVENT IMAGE : end -->
				<!-- EVENT CORE : begin -->
				<div class="event-core">
					<!-- EVENT TITLE : begin -->
					<h2 class="event-title"><a href="{$i.EVENT_URL}">{$i.EVENT_TITLE}</a></h2>
					<!-- EVENT TITLE : end -->
					<!-- EVENT INFO : begin -->
					<ul class="event-info">
						<li class="event-date">
							<i class="ico tp tp-calendar-full"></i><strong>From</strong> {$i.EVENT_START|date_format} <strong>To</strong> {$i.EVENT_END|date_format}
						</li>
						<li class="event-time">
							<i class="ico tp tp-clock2"></i>{$i.EVENT_START|date_format:"%H:%M"}
						</li>
						<li class="event-location">
							<i class="ico tp tp-map-marker"></i>{$i.EVENT_LOCATION}
						</li>
					</ul>
					<!-- EVENT INFO : end -->
	
				</div>
				<!-- EVENT CORE : end -->
				</div>
		</article>
		<!-- EVENT : end -->
		
	{foreachelse}
		<p>No event to be displayed now</p>
	{/foreach}
	
</div>
<!-- EVENT LIST PAGE : end -->