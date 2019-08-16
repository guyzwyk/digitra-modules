<?php
	require('library/event.inc.php');
	$myEvent			       =   new cwd_event();
	$myEvent->limit            =   $_REQUEST['limite']; // For pagination
	
	$pageEvent		           =   $myPage->get_pages_modules_links("event", $_SESSION["LANG"]); //$thewu32_modLink[annonce];
	$pageMaster                =   $myPage->set_mod_page_master($pageEvent); //Vers la page du module annonce dans la langue choisie mais sans la balise <a></a>
	$link_to_pageMaster        =   $myPage->get_mod_link($myPage->set_mod_pages($pageEvent), $mod_lang_output['EVENT_BOX_LINK_ALL']); // Lien vers la page master
	$link_back_to_pageMaster   =   "<a href=\"".$pageMaster."\">".$mod_lang_output["EVENT_PAGE_BACK"]."</a>";
	
	$eventLast			   = 	$myEvent->dt_pageBox($mod_lang_output["EVENT_BOX_TITLE"], $myEvent->load_top_event(4, $pageEvent, 'top_event', $_SESSION["LANG"]), $link_to_pageMaster, 'fa fa-calendar');
	
	//::::::::::::::::::::::::: Calendar settings :::::::::::::::::::::::::
	$myCal		       		=	new CALENDAR($myEvent->get_year($myEvent->get_date()), $myEvent->get_month($myEvent->get_date()));
	
	//Initialize months
	$myCal->months			=	$myCal->arr_get_months($_SESSION['LANG']);
	
	//Initialize weekdays
	$myCal->weekdays		=	$myCal->arr_get_weedays($_SESSION['LANG']);
	
	//Show or hide week days
	$myCal->weekNumbers		=	false;
	
	//Cells width and height
	$myCal->trWidth			=	''; //'0.01em';
	$myCal->trHeight		=	''; //'0.01em';
	
	//Fonts sizes
	//Units:
	$myCal->sizeUnit		=	'em';
	//Title
	$myCal->tFontSize		=	'0.9';
	//Days
	$myCal->dFontSize		=	'0.9';
	//Headings
	$myCal->hFontSize		=	'0.9';
	//Weeks
	$myCal->wFontSize		=	'0.9';
	
	//Font colors
	$myCal->hilightColor	=	'#cdfdc6';
	$myCal->hBGColor		=	'#009966';
	$myCal->tBGColor		=	'#06d995';
	$myCal->tdBorderColor	=	'#009933';
	$myCal->saFontColor		=	'#003399';
	
	//Calendar borders
	$myCal->calBorder		=	'1';
	
	//::::::::::::::::::::::::: Calendar processing :::::::::::::::::::::::::
	$arrEvents				=	$myEvent->calendar_get_events($myEvent->get_datetime());

	if(is_array($arrEvents)){
		foreach($arrEvents as $calEvent){
			$myCal->viewEvent($calEvent['DAY-START'], $calEvent['DAY-END'], $myCal->hilightColor, $calEvent['TITLE']);
		}
	}
?>
<?php
	if(($_REQUEST['level'] 		== "front") && (!isset($_SESSION['CONNECTED']))){	
		$event_home_acc		 	=	$myEvent->load_incoming_events_accordion(4, $eventPageDetail, '', $_SESSION['LANG'], $mod_lang_output["NO_EVENT"]);
		$eventHome          	= 	$myEvent->load_top_event(3, $pageEvent, 'top_event', $_SESSION[LANG], $mod_lang_output["NO_EVENT"]);
	}
		
	elseif($_REQUEST['mod'] == 'event'){
		$modSecondaryMenu	= 	$myEvent->dt_pageBox($mod_lang_output['EVENT_CAT_SIDE_BOX_TITLE'], $myEvent->load_event_cat($pageEvent, $mod_lang_output['EVENT_CAT_ERR'], '', $_SESSION['LANG']), '');
			
		if($_REQUEST['level'] == 'inner'){
			$pageContent		.= 	$myEvent->load_event($pageEvent, '50', $mod_lang_output['LABEL_READ_MORE'], $_SESSION[LANG], $mod_lang_output['NO_EVENT']);
			//$eventLast		= 	$myEvent->cwdBoxed($mod_lang_output["EVENT_BOX_TITLE"], $myEvent->load_top_event(5, $eventPageDetail, '', $_SESSION[LANG], $mod_lang_output["NO_EVENT"]), '', "box_right");
			if(isset($_REQUEST[$myEvent->URI_event]) && ($_REQUEST['view'] == 'detail')){
				$tabEvents 		= 	$myEvent->get_event($_REQUEST[$myEvent->URI_event]);
				$rub			= 	$myEvent->get_event_cat_by_id("event_type_lib", $tabEvents[eventTYPEID]);
				$eventTitle 	= 	$tabEvents['eventNAME'];
				$eventDescr 	= 	$tabEvents['eventDESCR'];
				$eventLocation 	= 	$tabEvents['eventLOCATION'];
				$eventStart		= 	$tabEvents['eventSTART'];
				$eventEnd		= 	$tabEvents['eventEND'];
				$eventUrl		= 	$tabEvents['eventURL'];
					
				$pageHeader		= 	$mod_lang_output["EVENT_PAGE_HEADER"].' - '.stripslashes($eventTitle);
				$pageTitle		= 	stripslashes($eventTitle);//$mod_lang_output["EVENT_PAGE_TITLE"]; //$mod_lang_output["EVENT_PAGE_TITLE"];
				$pageAtc       	=   "<h2>".$mod_lang_output['EVENT_PAGE_ATC']."</h2>
									<span style=\"margin-left:20px;\" class=\"addtocalendar atc-style-icon atc-style-menu-wb\" id=\"atc_icon_calbw1\">
                                		<a class=\"atcb-link\" id=\"atc_icon_calbw1_link\"><img style=\"width:40px;\" src=\"plugins/addtocalendar/img/cal-bw-01.png\" /></a>
                                		<var class=\"atc_event\">
                                		    <var class=\"atc_date_start\">$eventStart</var>
                                		    <var class=\"atc_date_end\">$eventEnd</var>
                                		    <var class=\"atc_timezone\">Africa/Douala</var>
                                		    <var class=\"atc_title\">$eventTitle</var>
                                		    <var class=\"atc_description\">$eventDescr</var>
                                		    <var class=\"atc_location\">$eventLocation</var>
                                		    <var class=\"atc_organizer\">$pageName</var>
                                		    <var class=\"atc_organizer_email\">$pageEmail</var>
                                		</var>
                                    </span>";
					
				$pageContent   	=   "<div class=\"monthly_event\"> 
                                        <div class=\"title\">$eventTitle</div>
                                        <div class=\"descr\">$eventDescr</div>
                                        <div class=\"start\"><strong><u>".$mod_lang_output["EVENT_STARTS"]." :</u> </strong>".$myEvent->show_datetime_by_lang($eventStart, $pageLang)."</div>
                                        <div class=\"end\"><strong><u>".$mod_lang_output["EVENT_ENDS"]." :</u> </strong>".$myEvent->show_datetime_by_lang($eventEnd, $pageLang)."</div>
                                        <div class=\"location\"><strong><u>".$mod_lang_output["EVENT_LOCATION"]." :</u> </strong>$eventLocation</div>
                                        <div class=\"url\"><strong><u>URL :</u> </strong>$eventUrl</div>
                                        <p>&nbsp;</p>
                                    </div>
                                    $pageAtc
					                <p>&raquo; $link_back_to_pageMaster</p>";
					
				$pagePathWay	= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $eventTitle, "", "&raquo;", $_SESSION["LANG"]);
			}
			elseif(isset($_REQUEST[$myEvent->URI_eventCat])){
				$eventTitle			= 	$mod_lang_output["EVENT_PAGE_TITLE"]." : ".$myEvent->get_event_cat_by_id('event_type_lib', $_REQUEST[$myEvent->URI_eventCat]);
				$eventContent		= 	$myEvent->load_event_by_cat($pageEvent, $_REQUEST[$myEvent->URI_eventCat], 50, $mod_lang_output["LABEL_READ_MORE"], $_SESSION['LANG']);
				$pageHeader			= 	$mod_lang_output["EVENT_PAGE_HEADER"].' - '.strip_tags(stripslashes($eventTitle));
				$pageTitle			=	stripslashes($eventTitle);
					
				$pageContent		= 	$link_back_to_pageMaster.stripslashes($eventContent); //.$link_back_to_pageMaster;
					
				$arr_eventCats		=	$myEvent->arr_load_event_by_cat($eventPage, $_REQUEST[$myEvent->URI_eventCat], 20, $mod_lang_output["READ_MORE"], $_SESSION['LANG']);
				$pagePathWay		= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $eventTitle, "", "&raquo;", $_SESSION["LANG"]);
			}
		}
	}
?>
<?php
	$oSmarty->assign('s_eventBoxTitle', $mod_lang_output['EVENT_BOX_TITLE']);
	$oSmarty->assign('s_eventHomeTitle', $mod_lang_output['EVENT_HOME_TITLE']);
	$oSmarty->assign('s_eventSideBoxTitle', $mod_lang_output['EVENT_SIDE_BOX_TITLE']);
	$oSmarty->assign('s_eventCatSideBoxTitle', $mod_lang_output['EVENT_CAT_SIDE_BOX_TITLE']);
	$oSmarty->assign('s_arr_eventDetail', $arr_eventDetail);
	$oSmarty->assign('s_arr_eventAll', $arr_eventAll);
	$oSmarty->assign('s_arr_eventLast', $arr_eventLast);
	$oSmarty->assign('s_arr_eventCat', $arr_eventCat);
	$oSmarty->assign('s_arr_eventCats', $arr_eventCats);
	$oSmarty->assign('s_eventPages', $eventPages);
	$oSmarty->assign('s_eventPageBck', $eventPageBck);
	$oSmarty->assign('s_eventLast', stripslashes($eventLast));
	$oSmarty->assign('s_eventHome', stripslashes($eventHome));
	$oSmarty->assign('s_eventTop', stripslashes($eventTop));
	$oSmarty->assign('s_eventTopAccordion', stripslashes($event_home_acc));
	$oSmarty->assign('s_eventShowCal', $myCal->create());  //Rendu final du calendrier
	
	//Labels
	$oSmarty->assign('s_label_event_ends', $mod_lang_output["EVENT_ENDS"]);
	$oSmarty->assign('s_label_event_starts', $mod_lang_output["EVENT_STARTS"]);
	$oSmarty->assign('s_label_event_location', $mod_lang_output["EVENT_LOCATION"]);
	$oSmarty->assign('s_label_event_url', $mod_lang_output["EVENT_URL"]);
?>