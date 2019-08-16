<?php
	$mod_lang_output = array_merge($lang_output,
			array(
			
			//General
			'MODULE_NAME'							=>	'<i class=\'fa fa-flag-o icon_info icon_color\'></i>&nbsp;Banners Manager',
			'MODULE_DESCR'							=>	'Banners manager',
			'FORM_BUTTON_UPDATE'					=>	'Update',
			'FORM_HELP_LEAVE_EMPTY'					=>	'Leave blank if empty',
			'FORM_HELP_CRT_MAX'						=>	'Max char.',
			'FORM_LABEL_LANGUAGE'					=>	'Language',
			'FORM_LABEL_SEX'						=>	'Sex',
			'FORM_VALUE_CHOOSE'						=> 	'Choose',
			'FORM_VALUE_SEX_1'						=>	'Male',
			'FORM_VALUE_SEX_2'						=>	'Female',
				
			//Admin --	Tables
			'TABLE_HEADER_TITLE' 					=> 	'Title',
			'TABLE_HEADER_AUTHOR' 					=> 	'Author',
			'TABLE_HEADER_DATE-CREA'				=> 	'Date created',
			'TABLE_HEADER_DATE-START'				=> 	'Start',
			'TABLE_HEADER_DATE-END'					=> 	'End',
			'TABLE_HEADER_ACTION'					=> 	'Actions',
			'TABLE_HEADER_CATEGORY'					=>	'Category',
			'TABLE_HEADER_AUTHOR_GROUP'				=>	'Group',
			'TABLE_HEADER_DESCRIPTION'				=>	'Description',
			'TABLE_HEADER_BANNER_POSITION'			=>	'Position on page',
				
			//Admin -- Forms
			'FORM_LABEL_CATEGORY'					=>	'Category',
			'FORM_LABEL_BANNER_CATEGORY'			=>	'Category',
			'FORM_LABEL_CODE'						=>	'Code',
			'FORM_LABEL_TITLE'						=>	'Title',
			'FORM_LABEL_BANNER_POSITION'			=>	'Position on page',
			'FORM_LABEL_BANNER_PAGE'				=>	'Banner\'s page',
			'FORM_LABEL_BANNER_HEADER'				=>	'Header',
			'FORM_LABEL_BANNER_TAGS'				=>	'Key words',
			'FORM_LABEL_BANNER_CONTENT'				=>	'Main content',
			'FORM_LABEL_BANNER_TITLE'				=>	'Title',
			'FORM_LABEL_LABEL'						=>	'Label',
			'FORM_LABEL_DATE-PUB'					=>	'Publication date',
			'FORM_LABEL_DATE-CREA'					=>	'Creation date',
			'FORM_LABEL_BANNER_THUMBNAIL'			=>	'Thumbnail',
			'FORM_LABEL_FIRST-NAME'					=>	'Last name',
			'FORM_LABEL_LAST-NAME'					=>	'First name',
			'FORM_LABEL_GROUP'						=>	'Group',
			'FORM_LABEL_AUTHOR_GROUP'				=>	'Author\'s group',
			'FORM_LABEL_DESCRIPTION'				=>	'Description',
			'FORM_LABEL_BANNER_IMG_HEADER'			=>	'Header\'s picture',
			'FORM_LABEL_BANNER_EXP-DATE'			=>	'Expiration date',
			'FORM_LABEL_EXP-DATE'					=>	'Expiration date',
			'FORM_LABEL_ADD_BANNER'					=>	'Insert a banner',
			'FORM_BUTTON_ADD_BANNER'				=>	'Insert a banner',
			'FORM_BUTTON_ADD_BANNER_AUTHOR'			=>	'New author',
			'FORM_BUTTON_ADD_CATEGORY'				=>	'New banner category',
			'FORM_BUTTON_ADD_AUTHOR_GROUP'			=>	'New author\'s group',
			'FORM_BUTTON_UPDATE_AUTHOR_GROUP'		=>	'Update author\'s group',
			'FORM_BUTTON_UPDATE_BANNER'				=>	'Update the banner',
				
			//Admin -- Headers
			'PAGE_HEADER_ADD_BANNER'				=>	'Insert a banner',
			'PAGE_HEADER_ADD_BANNER_CATEGORY'		=>	'New banner\'s category',
			'PAGE_HEADER_ADD_AUTHOR_GROUP'			=>	'New author\'s group',
			'PAGE_HEADER_ADD_BANNER_AUTHOR'			=>	'Insert an author',
			'PAGE_HEADER_UPDATE_AUTHORS_GROUP'		=>	'Update author\'s group',
			'PAGE_HEADER_UPDATE_BANNER'				=>	'Update the banner',
			'PAGE_HEADER_UPDATE_BANNER_CATEGORY'	=>	'Update the category',
			'PAGE_HEADER_UPDATE_BANNER_AUTHOR'		=>	'Update an author',
			'PAGE_HEADER_LIST_BANNERS'				=>	'List banners',
			'PAGE_HEADER_LIST_BANNER_CATEGORIES'	=>	'Display categories',
			'PAGE_HEADER_LIST_BANNER_COMMENTS'		=>	'Display comments',
			'PAGE_HEADER_LIST_BANNER_AUTHORS'		=>	'List authors',
			'PAGE_HEADER_LIST_AUTHOR_GROUPS'		=>	'Display authors groups',
			
			'PAGE_LINK_ADD_BANNER_AUTHOR_GROUP'		=>	'New authors group',
			'PAGE_LINK_ADD_BANNER_AUTHOR'			=>	'New author',

			//Admin menu
			"BANNER_ADMIN_MENU_DISPLAY"				=>	"Display banners",
			"BANNER_ADMIN_MENU_CREATE"				=>	"Add a banner",
			"BANNER_ADMIN_MENU_CAT_DISPLAY"			=>	"Show categories",
			"BANNER_ADMIN_MENU_CAT_CREATE"			=>	"Add category",
			
			//Main page display
			"BANNER_RBOX_TITLE" 					=> 	"Banners",
			"BANNER_BOX_TITLE" 						=> 	"Top banners",
			"BANNER_BOX_LINK"						=> 	"&raquo;Go to banners page",
			"BANNER_BOX_LINK_ALL"					=> 	"All banners",
			"BANNER_PAGE_TITLE"						=> 	"Banners area",
			"BANNER_PAGE_HEADER"					=> 	"FUNDONG Council :: Banners",
			"BANNER_PAGE_CAT_HEADER"				=> 	"FUNDONG Council :: Banners by category",
			"BANNER_PAGE_BACK"						=> 	"Back to banners",
			"BANNER_PJ"								=> 	"Attachments",
			"BANNER_RBOX_CAT_TITLE"					=>	"Bammers by category",
			"BANNER_LOCATION"						=>	"Location",
			"NO_BANNER"								=>	"No banner to be displayed",
			"NO_BANNER_CATEGORY"					=>	"No category",
			
			//Validations
			'BANNER_ERROR_SAME_POSITION'			=>	'Sorry!<br />Can not add another banner at the same position on the same page!',
			'BANNER_SUCCESS'						=>	'Congratulations!<br />Banner successfully inserted!',
			'BANNER_ERROR'							=>	'Sorry!<br />Error while inserting a website banner!',
			'BANNER_UPDATE_SUCCESS'					=>	'Congratulations!<br />Banner successfully updated!',
			'BANNER_DELETE_SUCCESS'					=>	'Congratulations!<br />Banner sucessfully deleted!',
			'BANNER_HIDDEN_SUCCESS'					=>	'Congratulations!<br />Banner successfully set hidden',
			'BANNER_VISIBLE_SUCCESS'				=>	'Congratulations!<br />Banner is now visible to the website visitors!'					
			)
			
	);
	
	//Dashboard
	$db_banner_output	=	array(
			//Dashboard
			'BANNER_ADMIN_MODULE_TITLE'				=>	'Banner module',
			'BANNER_ADMIN_MODULE_DESCR'				=>	'<h5>Banners management module.</h5><p>D&eacute;finissez les pages d\'affichage des banni&egrave;res, ainsi que leurs formats dans l\'ensemble de votre site web.</p>',
			'BANNER_ADMIN_DB_ICON'					=>	'<i class="fa fa-hat text-info icon_13"> </i>',
			'BANNER_ADMIN_DB_IMG'					=>	'db_banner_manager.jpg'
	);