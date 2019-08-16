{literal}
<script type="text/javascript">(function () {
            if (window.addtocalendar)if(typeof window.addtocalendar.start == "function")return;
            if (window.ifaddtocalendar == undefined) { window.ifaddtocalendar = 1;
                var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                s.type = 'text/javascript';s.charset = 'UTF-8';s.async = true;
                s.src = ('https:' == window.location.protocol ? 'https' : 'http')+'://addtocalendar.com/atc/1.5/atc.min.js';
                var h = d[g]('body')[0];h.appendChild(s); }})();
</script>
{/literal}

<div class="c-content-box">
	<div class="monthly_event"> 
		<div class="title">{$s_arr_eventDetail.EVENT_DETAIL_TITLE}</div>
		<div class="descr">{$s_arr_eventDetail.EVENT_DETAIL_DESCR}</div>
		<div class="start"><strong><u>{$s_label_event_starts} :</u></strong> {$s_arr_eventDetail.EVENT_DETAIL_START|date_format:"%d-%b-%Y"}</div>
		<div class="end"><strong><u>{$s_label_event_ends} :</u></strong> {$s_arr_eventDetail.EVENT_DETAIL_END|date_format:"%d-%b-%Y"}</div>
		<div class="location"><strong><u>{$s_label_event_location} :</u></strong> {$s_arr_eventDetail.EVENT_DETAIL_LOCATION}</div>
		<div class="url"><strong><u>URL :</u></strong> {$s_arr_eventDetail.EVENT_DETAIL_LINK}</div>
		
		<div>
			<span class="addtocalendar atc-style-icon atc-style-menu-wb" id="atc_icon_calbw1">
				<a class="atcb-link" id="atc_icon_calbw1_link"><img src="plugins/addtocalendar/img/cal-bw-01.png" width="32" /></a>
		        <var class="atc_event">
		            <var class="atc_date_start">{$s_arr_eventDetail.EVENT_DETAIL_START}</var>
		            <var class="atc_date_end">{$s_arr_eventDetail.EVENT_DETAIL_END}</var>
		            <var class="atc_timezone">Africa/Douala</var>
		            <var class="atc_title">{$s_arr_eventDetail.EVENT_DETAIL_TITLE}</var>
		            <var class="atc_description">{$s_arr_eventDetail.EVENT_DETAIL_DESCR}</var>
		            <var class="atc_location">{$s_arr_eventDetail.EVENT_DETAIL_LOCATION}</var>
		            <var class="atc_organizer">DigiSchool</var>
		            <var class="atc_organizer_email">contact@digischool.org</var>
		        </var>
		    </span>
		</div>
		
	</div>
	<p>{$s_eventPageBck}</p>
</div>