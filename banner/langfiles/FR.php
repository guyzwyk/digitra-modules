<?php
	$mod_lang_output = array_merge($lang_output,
			array(
			
			//General
			'MODULE_NAME'							=>	'<i class=\'fa fa-flag-o icon_info icon_color\'></i>&nbsp;Banners Manager',
			'MODULE_DESCR'							=>	'Gestionnaire des banni&egrave;res',
			'FORM_BUTTON_UPDATE'					=>	'Mettre &agrave; jour',
			'FORM_HELP_LEAVE_EMPTY'					=>	'Laisser vide si identique',
			'FORM_HELP_CRT_MAX'						=>	'Caract&egrave;res max.',
			'FORM_LABEL_LANGUAGE'					=>	'Langue',
			'FORM_LABEL_SEX'						=>	'Sexe',
			'FORM_VALUE_CHOOSE'						=> 	'Choisir',
			'FORM_VALUE_SEX_1'						=>	'Masculin',
			'FORM_VALUE_SEX_2'						=>	'Feminin',
			
			//Admin --	Tables
			'TABLE_HEADER_TITLE' 					=> 	'Titre',
			'TABLE_HEADER_AUTHOR' 					=> 	'Auteur',
			'TABLE_HEADER_DATE-CREA'				=> 	'Cr&eacute;&eacute; le',
			'TABLE_HEADER_DATE-START'				=> 	'D&eacute;but',
			'TABLE_HEADER_DATE-END'					=> 	'Fin',
			'TABLE_HEADER_ACTION'					=> 	'Actions',
			'TABLE_HEADER_CATEGORY'					=>	'Cat&eacute;gorie',
			'TABLE_HEADER_AUTHOR_GROUP'				=>	'Groupe',
			'TABLE_HEADER_DESCRIPTION'				=>	'Description',
			'TABLE_HEADER_BANNER_POSITION'			=>	'Position sur la page',
				
			//Admin -- Forms
			'FORM_LABEL_CATEGORY'					=>	'Cat&eacute;gorie',
			'FORM_LABEL_BANNER_CATEGORY'			=>	'Rubrique',
			'FORM_LABEL_CODE'						=>	'Code',
			'FORM_LABEL_TITLE'						=>	'Titre',
			'FORM_LABEL_BANNER_POSITION'			=>	'Position sur la page',
			'FORM_LABEL_BANNER_PAGE'				=>	'Page pour banni&egrave;re',
			'FORM_LABEL_BANNER_HEADER'				=>	'Chapeau',
			'FORM_LABEL_BANNER_TAGS'				=>	'Mots-cl&eacute;s',
			'FORM_LABEL_BANNER_CONTENT'				=>	'Contenu principal',
			'FORM_LABEL_BANNER_TITLE'				=>	'Titre',
			'FORM_LABEL_LABEL'						=>	'Libell&eacute;',
			'FORM_LABEL_DATE-PUB'					=>	'Date de publication',
			'FORM_LABEL_DATE-CREA'					=>	'Date de cr&eacute;ation',
			'FORM_LABEL_BANNER_THUMBNAIL'			=>	'Imagette',
			'FORM_LABEL_FIRST-NAME'					=>	'Pr&eacute;nom',
			'FORM_LABEL_LAST-NAME'					=>	'Nom',
			'FORM_LABEL_GROUP'						=>	'Groupe',
			'FORM_LABEL_AUTHOR_GROUP'				=>	'Groupe d\'auteurs',
			'FORM_LABEL_DESCRIPTION'				=>	'Description',
			'FORM_LABEL_BANNER_IMG_HEADER'			=>	'Image d\'ent&ecirc;te',
			'FORM_LABEL_BANNER_EXP-DATE'			=>	'Date d\'expiration de la banni&egrave;re',
			'FORM_LABEL_EXP-DATE'					=>	'Date d\'expiration',
			'FORM_LABEL_ADD_BANNER'					=>	'Ajouter un banni&egrave;re',
			'FORM_BUTTON_ADD_BANNER'				=>	'Ajouter une banni&egrave;re',
			'FORM_BUTTON_ADD_BANNER_AUTHOR'			=>	'Ajouter un auteur',
			'FORM_BUTTON_ADD_CATEGORY'				=>	'Ajouter la cat&eacute;gorie',
			'FORM_BUTTON_ADD_AUTHOR_GROUP'			=>	'Ajouter un groupe d\'auteurs',
			'FORM_BUTTON_UPDATE_AUTHOR_GROUP'		=>	'Modifier un groupe d\'auteurs',
			'FORM_BUTTON_UPDATE_BANNER'				=>	'Modifier la banni&egrave;re',
				
			//Admin -- Headers
			'PAGE_HEADER_ADD_BANNER'				=>	'Ajouter une banni&egrave;re',
			'PAGE_HEADER_ADD_BANNER_CATEGORY'		=>	'Ajouter une cat&eacute;gorie d\'banni&egrave;re',
			'PAGE_HEADER_ADD_AUTHOR_GROUP'			=>	'Ajouter un groupe d\'auteur',
			'PAGE_HEADER_ADD_BANNER_AUTHOR'			=>	'Ajouter un auteur',
			'PAGE_HEADER_UPDATE_AUTHORS_GROUP'		=>	'Modifier un groupe d\'auteurs',
			'PAGE_HEADER_UPDATE_BANNER'				=>	'Modifier la banni&egrave;re',
			'PAGE_HEADER_UPDATE_BANNER_CATEGORY'	=>	'Modifier une cat&eacute;gorie d\'banni&egrave;re',
			'PAGE_HEADER_UPDATE_BANNER_AUTHOR'		=>	'Modifier un auteur',
			'PAGE_HEADER_LIST_BANNERS'				=>	'Afficher les banni&egrave;res',
			'PAGE_HEADER_LIST_BANNER_CATEGORIES'	=>	'Afficher les cat&eacute;gories',
			'PAGE_HEADER_LIST_BANNER_COMMENTS'		=>	'Afficher les commentaires',
			'PAGE_HEADER_LIST_BANNER_AUTHORS'		=>	'Afficher les auteurs',
			'PAGE_HEADER_LIST_AUTHOR_GROUPS'		=>	'Afficher les groupes d\'auteurs',
			
			'PAGE_LINK_ADD_BANNER_AUTHOR_GROUP'		=>	'Ajouter un groupe d\'auteur',
			'PAGE_LINK_ADD_BANNER_AUTHOR'			=>	'Ajouter un auteur',

			//Admin menu
			"BANNER_ADMIN_MENU_DISPLAY"				=>	"Afficher les banni&egrave;res",
			"BANNER_ADMIN_MENU_CREATE"				=>	"Ajouter une banni&egrave;re",
			"BANNER_ADMIN_MENU_CAT_DISPLAY"			=>	"Types de banni&egrave;res",
			"BANNER_ADMIN_MENU_CAT_CREATE"			=>	"Ajouter un type",
			
			//Main page display
			"BANNER_RBOX_TITLE" 					=> 	"Annonces",
			"BANNER_BOX_TITLE" 						=> 	"Annonces r&eacute;centes",
			"BANNER_BOX_LINK"						=> 	"&raquo;Aller &agrave; au babillard",
			"BANNER_BOX_LINK_ALL"					=> 	"Toutes les banni&egrave;res",
			"BANNER_PAGE_TITLE"						=> 	"Espace Annonces",
			"BANNER_PAGE_HEADER"					=> 	"CABB :: Babillard",
			"BANNER_PAGE_CAT_HEADER"				=> 	"CABB :: Annonces par cat&eacute;gories",
			"BANNER_PAGE_BACK"						=> 	"Retour aux banni&egrave;res",
			"BANNER_PJ"								=> 	"Pi&eacute;ce-jointe",
			"BANNER_RBOX_CAT_TITLE"					=>	"Annonces par cat&eacute;gories",
			"BANNER_LOCATION"						=>	"Lieu",
			"NO_BANNER"								=>	"Aucune banni&egrave;re &agrave; afficher",
			"NO_BANNER_CATEGORY"					=>	"Aucune categorie de banni&egrave;re &agrave; afficher",
			
			//Validations
			'BANNER_ERROR_SAME_POSITION'			=>	'D&eacute;sol&eacute;!<br />Impossible d\'ajouter une banni&egrave;re &agrave; la m&ecirc;me position sur la m&ecirc;me page!',
			'BANNER_SUCCESS'						=>	'Bravo!<br />La banni&egrave;re a &eacute;t&eacute; ins&eacute;r&eacute;e avec succ&egrave;s!',
			'BANNER_ERROR'							=>	'D&eacute;sol&eacute;!<br />Erreur lors de la tentative d\'insertion d\'une banni&egrave;re!',
			'BANNER_UPDATE_SUCCESS'					=>	'Bravo!<br />La banni&egrave;re a &eacute;t&eacute; mise &agrave; jour avec succ&egrave;s!',
			'BANNER_DELETE_SUCCESS'					=>	'Bravo!<br />La banni&egrave;re a &eacute;t&eacute; supprim&eacute;e avec succ&egrave; Banner sucessfully deleted!',
			'BANNER_HIDDEN_SUCCESS'					=>	'Bravo!<br />La banni&egrave;re a &eacute;t&eacute; masqu&eacute;e avec succ&egrave;s.',
			'BANNER_VISIBLE_SUCCESS'				=>	'Bravo!<br />La banni&egrave;re est d&eacute;sormais visible pour les visiteurs du site web!'
			)
	);
	
	//Dashboard
	$db_banner_output	=	array(
			//Dashboard
			'BANNER_ADMIN_MODULE_TITLE'				=>	'Banner module',
			'BANNER_ADMIN_MODULE_DESCR'				=>	'<h5>Module de gestion des banni&egrave;res.</h5><p>D&eacute;finissez les pages d\'affichage des banni&egrave;res, ainsi que leurs formats dans l\'ensemble de votre site web.</p>',
			'BANNER_ADMIN_DB_ICON'					=>	'<i class="fa fa-hat text-info icon_13"> </i>',
			'BANNER_ADMIN_DB_IMG'					=>	'db_banner_manager.jpg'
	);