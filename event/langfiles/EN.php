<?php
	$mod_lang_output = array_merge($lang_output,
			array(
			//General
			'MODULE_NAME'						=>	'<i class=\'fa fa-calendar icon_info icon_color\'></i>&nbsp;Event Manager',
			'MODULE_DESCR'						=>	'Events manager',
			'FORM_BUTTON_UPDATE'				=>	'Update',
			'FORM_HELP_LEAVE_EMPTY'				=>	'Leave blank if empty',
			'FORM_LABEL_LANGUAGE'				=>	'Language',

			//Event module
			"EVENT_ADMIN_MODULE_TITLE"			=>	"Event module",
			"EVENT_ADMIN_MODULE_DESCR"			=>	"<h5>Events management module.</h5><p>Create and modify on going or up coming events to be automatically displayed in your website",
			
			//Admin --	Tables
			'TABLE_HEADER_TITLE' 				=> 	'Title',
			'TABLE_HEADER_AUTHOR' 				=> 	'Author',
			'TABLE_HEADER_DATE-CREA'			=> 	'Created',
			'TABLE_HEADER_DATE-START'			=> 	'Start',
			'TABLE_HEADER_DATE-END'				=> 	'End',
			'TABLE_HEADER_ACTION'				=> 	'Actions',
			'TABLE_HEADER_CATEGORY'				=>	'Category',
			
			//Admin -- Forms
			'FORM_LABEL_CATEGORY'				=>	'Category',
			'FORM_LABEL_CODE'					=>	'Code',
			'FORM_LABEL_TITLE'					=>	'Title',
			'FORM_LABEL_DESCRIPTION'			=>	'Description',
			'FORM_LABEL_VENUE'					=>	'Location',
			'FORM_LABEL_TITLE'					=>	'Title',
			'FORM_LABEL_LABEL'					=>	'Label',
			'FORM_LABEL_DATE-START'				=>	'Date start',
			'FORM_LABEL_DATE-END'				=>	'Date dend',
			'FORM_LABEL_URL'					=>	'Link',
			'FORM_LABEL_ADD_EVENT'				=>	'Insert event',
			'FORM_BUTTON_ADD_EVENT'				=>	'Insert',
			'FORM_BUTTON_ADD_CATEGORY'			=>	'Insert category',
			
			//Admin -- Headers
			'PAGE_HEADER_ADD_EVENT'				=>	'Insert an event',
			'PAGE_HEADER_ADD_EVENT_CATEGORY'	=>	'Add a new category',
			'PAGE_HEADER_UPDATE_EVENT'			=>	'Update an event',
			'PAGE_HEADER_UPDATE_EVENT_CATEGORY'	=>	'Update the category',
			'PAGE_HEADER_LIST_EVENTS'			=>	'List events',
			'PAGE_HEADER_LIST_EVENTS_CATEGORIES'=>	'List categories',

			//Main page display
			"EVENT_SIDE_BOX_TITLE" 				=> 	"Events",
			"EVENT_CAT_SIDE_BOX_TITLE"			=>	"Events by category",
			"EVENT_BOX_TITLE" 					=> 	"Top events",
			"EVENT_HOME_TITLE"                  =>  "Minister's agenda",
			"EVENT_BOX_LINK"					=> 	"&raquo;Go to Events",
			"EVENT_BOX_LINK_ALL"				=> 	"See all events",
			"EVENT_PAGE_TITLE"					=> 	"Events area",
			"EVENT_PAGE_HEADER"					=> 	"North-West Region :: Events area",
			"EVENT_PAGE_CAT_HEADER"				=> 	"North-West Region :: Events area by category",
			"EVENT_PAGE_BACK"					=> 	"Back to events",
			"EVENT_PJ"							=> 	"Attachment",
			"EVENT_RBOX_CAT_TITLE"				=>	"Events by category",
			"EVENT_STARTS"						=>	"Event starts",
			"EVENT_ENDS"						=>	"Event ends",
			"EVENT_LOCATION"					=>	"Location",
			"NO_EVENT"							=>	"No event to be displayed",
			"EVENT_CAT_ERR"						=>	"No category",
			"EVENT_PAGE_ATC"                    =>  "Add this event to your calendar",
					
			//Admin validations
			"EVENT_CAT_EMPTY_ERROR"				=>	"Sorry!<br />You must define a category.",
			"EVENT_CODE_EXISTS"					=>	"Sorry!<br />The chosen code already exists.<br />Please try with another one.",
			"EVENT_CAT_EXIST"					=>	"Sorry!<br />The entered category exists already.<br />Please choose another one.",
			"EVENT_CAT_SUCCESS"					=>	"Congratulations!<br />Category successfully created.",
			"EVENT_CAT_LABEL_EMPTY_REQUIRED"	=>	"Sorry!<br />The category label should not be empty.",
			"EVENT_CAT_UPDATE_SUCCESS"			=>	"Congratulations!<br />Category successfully updated.",
			"EVENT_MANDATORY_FIELDS_ERROR"		=>	"Error!<br />Fill <strong>all</strong> the mandatory fields.",
			"EVENT_TITLE_EXISTS_ERROR"			=>	"Sorry<br />The title you entered exists in our database already.<br />Please try to use another title for this new event.",
			"EVENT_EXISTS_ERROR"				=>	"Sorry!<br />This event exists in our database already.",
			"EVENT_DATE_START_ERROR"			=>	"Sorry!<br />Starting date is incorrect!<br />Please try with a valid date!",
			"EVENT_DATE_END_ERROR"				=>	"Sorry!<br />Ending date is incorrect!<br />Please try with a valid date!",
			"EVENT_DATES_ERROR"					=>	"Sorry!<br />Ending and starting date are not in good order!<br />Please try with a valid dates!",
			"EVENT_CREATE_SUCCESS"				=>	"Congratulations!<br />Event successfully created.",
			"EVENT_UPDATE_SUCCESS"				=>	"Congratulations!<br />Event successfully updated.",
			"EVENT_DELETE_SUCCESS"				=>	"Congratulations!<br />Event successfully deleted.",
			"EVENT_SET_HIDDEN_SUCCESS"			=>	"Congratulations!<br />The event has been set hidden. The visitors will not have access to it.",
			"EVENT_SET_VISIBLE_SUCCESS"			=>	"Congratulations!<br />The event has been set visible. The visitors will now have access to it.",
			"EVENT_CAT_DELETE_SUCCESS"			=>	"Congratulations!<br />Category successfully deleted.",
			"EVENT_CAT_VISIBLE_SUCCESS"			=>	"Congratulations!<br />Category set visible.<br />Therefore, all the events grouped in that category shall be visible in the website",
			"EVENT_CAT_HIDDEN_SUCCESS"			=>	"Congratulations!<br />Category set hidden.<br />Therefore, all the events grouped in that category shall not be visible in the website",

			//Admin menu
			"EVENT_ADMIN_MENU_DISPLAY"				=>	"Display events",
			"EVENT_ADMIN_MENU_CREATE"				=>	"Add an event",
			"EVENT_ADMIN_MENU_CAT_DISPLAY"			=>	"Show categories",
			"EVENT_ADMIN_MENU_CAT_CREATE"			=>	"Add category",
		)
	);