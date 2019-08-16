<?php
	$mod_lang_output = array_merge($lang_output, 
			array(
			
			//General
			'MODULE_NAME'							=>	'<i class=\'fa fa-bullhorn icon_info icon_color\'></i>&nbsp;Announcements Manager',
			'MODULE_DESCR'							=>	'Notices manager',
			'FORM_BUTTON_UPDATE'					=>	'Update',
			'FORM_HELP_LEAVE_EMPTY'					=>	'Blank if empty',
			'FORM_HELP_CRT_MAX'						=>	'Max crts.',
			'FORM_LABEL_LANGUAGE'					=>	'Language',
			'FORM_LABEL_SEX'						=>	'Sex',
			'FORM_VALUE_CHOOSE'						=> 	'Choose',
			'FORM_VALUE_SEX_1'						=>	'Male',
			'FORM_VALUE_SEX_2'						=>	'Female',
				
			//Admin --	Tables
			'TABLE_HEADER_TITLE' 					=> 	'Title',
			'TABLE_HEADER_AUTHOR' 					=> 	'Author',
			'TABLE_HEADER_DATE-CREA'				=> 	'Date of creation',
			'TABLE_HEADER_DATE-START'				=> 	'Start',
			'TABLE_HEADER_DATE-END'					=> 	'End',
			'TABLE_HEADER_ACTION'					=> 	'Actions',
			'TABLE_HEADER_CATEGORY'					=>	'Category',
			'TABLE_HEADER_AUTHOR_GROUP'				=>	'Group',
			'TABLE_HEADER_DESCRIPTION'				=>	'Description',
				
			//Admin -- Forms
			'FORM_LABEL_CATEGORY'					=>	'Category',
			'FORM_LABEL_ANNONCE_CATEGORY'			=>	'Category',
			'FORM_LABEL_CODE'						=>	'Code',
			'FORM_LABEL_TITLE'						=>	'Title',
			'FORM_LABEL_ANNONCE_AUTHOR'				=>	'Author',
			'FORM_LABEL_HEADER'						=>	'Header',
			'FORM_LABEL_ANNONCE_HEADER'				=>	'Short description',
			'FORM_LABEL_ANNONCE_TAGS'				=>	'Key words',
			'FORM_LABEL_ANNONCE_CONTENT'			=>	'Main content',
			'FORM_LABEL_ANNONCE_TITLE'				=>	'Title',
			'FORM_LABEL_LABEL'						=>	'Label',
			'FORM_LABEL_DATE-PUB'					=>	'Date of publication',
			'FORM_LABEL_DATE-CREA'					=>	'Date of creation',
			'FORM_LABEL_ANNONCE_THUMBNAIL'			=>	'Thunbnail',
			'FORM_LABEL_FIRST-NAME'					=>	'First name',
			'FORM_LABEL_LAST-NAME'					=>	'Last name',
			'FORM_LABEL_GROUP'						=>	'Group',
			'FORM_LABEL_AUTHOR_GROUP'				=>	'Author group',
			'FORM_LABEL_DESCRIPTION'				=>	'Description',
			'FORM_LABEL_ANNONCE_IMG_HEADER'			=>	'Head image',
			'FORM_LABEL_ADD_ANNONCE'				=>	'Add a notice',
			'FORM_BUTTON_ADD_ANNONCE'				=>	'Insert notice',
			'FORM_BUTTON_ADD_ANNONCE_AUTHOR'		=>	'Insert author',
			'FORM_BUTTON_ADD_CATEGORY'				=>	'Insert category',
			'FORM_BUTTON_ADD_AUTHOR_GROUP'			=>	'Insert group',
			'FORM_BUTTON_UPDATE_AUTHOR_GROUP'		=>	'Update group',
			'FORM_BUTTON_UPDATE_ANNONCE'			=>	'Update notice',
					
				
			//Admin -- Headers
			'PAGE_HEADER_ADD_ANNONCE'				=>	'New notice',
			'PAGE_HEADER_ADD_ANNONCE_CATEGORY'		=>	'New category',
			'PAGE_HEADER_ADD_AUTHOR_GROUP'			=>	'New group',
			'PAGE_HEADER_ADD_ANNONCE_AUTHOR'		=>	'New author',
			'PAGE_HEADER_UPDATE_AUTHORS_GROUP'		=>	'Update group',
			'PAGE_HEADER_UPDATE_ANNONCE'			=>	'Update notice',
			'PAGE_HEADER_UPDATE_ANNONCE_CATEGORY'	=>	'Update category',
			'PAGE_HEADER_UPDATE_ANNONCE_AUTHOR'		=>	'Update author',
			'PAGE_HEADER_LIST_ANNONCE'				=>	'Display notices',
			'PAGE_HEADER_LIST_ANNONCE_CATEGORIES'	=>	'Display categories',
			'PAGE_HEADER_LIST_ANNONCE_COMMENTS'		=>	'Show comments',
			'PAGE_HEADER_LIST_ANNONCE_AUTHORS'		=>	'Display authors',
			'PAGE_HEADER_LIST_AUTHOR_GROUPS'		=>	'Display groups',
			
			'PAGE_LINK_ADD_ANNONCE_AUTHOR_GROUP'	=>	'Insert group',
			'PAGE_LINK_ADD_ANNONCE_AUTHOR'			=>	'Insert author',
			
			//Admin -- Dashboard
			
						
			//Main page display
			"ANNONCE_SIDE_BOX_TITLE" 				=> 	"Notices",
			"ANNONCE_BOX_LINK"						=> 	"View all notices",
			"ANNONCE_BOX_LINK_ALL"					=> 	"See all notices",
			"ANNONCE_PAGE_TITLE"					=> 	"Notices area",
			"ANNONCE_PAGE_HEADER"					=> 	"FUNDONG Council :: Notice board",
			"ANNONCE_PAGE_CAT_HEADER"				=> 	"FUNDONG Council :: Notices by category",
			"ANNONCE_PAGE_BACK"						=> 	"Back to notices",
			"ANNONCE_PJ"							=> 	"Attachment",
			"ANNONCE_RBOX_CAT_TITLE"				=>	"Categories",
			"ANNONCE_LOCATION"						=>	"Place",
			"NO_ANNONCE"							=>	"No notice to be displayed",
			"NO_ANNONCE_CATEGORY"					=>	"No category to be displayed",
			
			//Annonce
			"ANNONCE_SIDE_BOX_TITLE" 				=> 	"Our notice board",
			"ANNONCE_BOX_TITLE" 					=> 	"Top notices",
			"ANNONCE_BOX_LINK_ALL"					=> 	"See all notices",
			"ANNONCE_PAGE_TITLE"					=> 	"DigiTown notice board",
			"ANNONCE_PAGE_HEADER"					=> 	"DT :: The notice board",
			"ANNONCE_PAGE_CAT_HEADER"				=> 	"DT :: Notices by category ",
			"ANNONCE_PAGE_BACK"						=> 	"&raquo;Back to the notice board",
			"ANNONCE_PJ"							=> 	"Attachment",
			'ANNONCE_CAT_SIDE_BOX_TITLE'			=>	'Notices by category'
		)
	);
	
	//Dashboard
	$db_annonce_output	=	array(
			//Dashboard
			'ANNONCE_ADMIN_MODULE_TITLE'			=>	'Announcement module',
			'ANNONCE_ADMIN_MODULE_DESCR'			=>	'<h5>Notices management module.</h5><p>Easily publish your announcements and communique in your website by using our online wysiwyg editor',
			'ANNONCE_ADMIN_DB_ICON'					=>	'<i class="fa fa-bullhorn text-info icon_13"> </i>',
			'ANNONCE_ADMIN_DB_IMG'					=>	'db_annonce_manager.jpg'
	);