<?php
	$mod_lang_output = array_merge($lang_output, 
			array(
			
			//General
			'MODULE_NAME'							=>	'<i class=\'fa fa-bullhorn icon_info icon_color\'></i>&nbsp;Announcements Manager',
			'MODULE_DESCR'							=>	'Gestionnaire des annonces',
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
				
			//Admin -- Forms
			'FORM_LABEL_CATEGORY'					=>	'Cat&eacute;gorie',
			'FORM_LABEL_ANNONCE_CATEGORY'			=>	'Rubrique',
			'FORM_LABEL_CODE'						=>	'Code',
			'FORM_LABEL_TITLE'						=>	'Titre',
			'FORM_LABEL_ANNONCE_AUTHOR'				=>	'Auteur',
			'FORM_LABEL_HEADER'						=>	'Chapeau',
			'FORM_LABEL_ANNONCE_HEADER'				=>	'Chapeau',
			'FORM_LABEL_ANNONCE_TAGS'				=>	'Mots-cl&eacute;s',
			'FORM_LABEL_ANNONCE_CONTENT'			=>	'Contenu principal',
			'FORM_LABEL_ANNONCE_TITLE'				=>	'Titre',
			'FORM_LABEL_LABEL'						=>	'Libell&eacute;',
			'FORM_LABEL_DATE-PUB'					=>	'Date de publication',
			'FORM_LABEL_DATE-CREA'					=>	'Date de cr&eacute;ation',
			'FORM_LABEL_ANNONCE_THUMBNAIL'			=>	'Imagette',
			'FORM_LABEL_FIRST-NAME'					=>	'Pr&eacute;nom',
			'FORM_LABEL_LAST-NAME'					=>	'Nom',
			'FORM_LABEL_GROUP'						=>	'Groupe',
			'FORM_LABEL_AUTHOR_GROUP'				=>	'Groupe d\'auteurs',
			'FORM_LABEL_DESCRIPTION'				=>	'Description',
			'FORM_LABEL_ANNONCE_IMG_HEADER'			=>	'Image d\'ent&ecirc;te',
			'FORM_LABEL_ADD_ANNONCE'				=>	'Ajouter un annonce',
			'FORM_BUTTON_ADD_ANNONCE'				=>	'Ajouter une annonce',
			'FORM_BUTTON_ADD_ANNONCE_AUTHOR'		=>	'Ajouter un auteur',
			'FORM_BUTTON_ADD_CATEGORY'				=>	'Ajouter la cat&eacute;gorie',
			'FORM_BUTTON_ADD_AUTHOR_GROUP'			=>	'Ajouter un groupe d\'auteurs',
			'FORM_BUTTON_UPDATE_AUTHOR_GROUP'		=>	'Modifier un groupe d\'auteurs',
			'FORM_BUTTON_UPDATE_ANNONCE'			=>	'Modifier l\'annonce',
				
			//Admin -- Headers
			'PAGE_HEADER_ADD_ANNONCE'				=>	'Ajouter une annonce',
			'PAGE_HEADER_ADD_ANNONCE_CATEGORY'		=>	'Ajouter une cat&eacute;gorie d\'annonce',
			'PAGE_HEADER_ADD_AUTHOR_GROUP'			=>	'Ajouter un groupe d\'auteur',
			'PAGE_HEADER_ADD_ANNONCE_AUTHOR'		=>	'Ajouter un auteur',
			'PAGE_HEADER_UPDATE_AUTHORS_GROUP'		=>	'Modifier un groupe d\'auteurs',
			'PAGE_HEADER_UPDATE_ANNONCE'			=>	'Modifier l\'annonce',
			'PAGE_HEADER_UPDATE_ANNONCE_CATEGORY'	=>	'Modifier une cat&eacute;gorie d\'annonce',
			'PAGE_HEADER_UPDATE_ANNONCE_AUTHOR'		=>	'Modifier un auteur',
			'PAGE_HEADER_LIST_ANNONCE'				=>	'Afficher les annonces',
			'PAGE_HEADER_LIST_ANNONCE_CATEGORIES'	=>	'Afficher les cat&eacute;gories',
			'PAGE_HEADER_LIST_ANNONCE_COMMENTS'		=>	'Afficher les commentaires',
			'PAGE_HEADER_LIST_ANNONCE_AUTHORS'		=>	'Afficher les auteurs',
			'PAGE_HEADER_LIST_AUTHOR_GROUPS'		=>	'Afficher les groupes d\'auteurs',
			
			'PAGE_LINK_ADD_ANNONCE_AUTHOR_GROUP'	=>	'Ajouter un groupe d\'auteur',
			'PAGE_LINK_ADD_ANNONCE_AUTHOR'			=>	'Ajouter un auteur',
			
			//Main page display
			"ANNONCE_SIDE_BOX_TITLE" 				=> 	"Annonces",
			"ANNONCE_BOX_LINK"						=> 	"&raquo;Aller &agrave; au babillard",
			"ANNONCE_BOX_LINK_ALL"					=> 	"Toutes les annonces",
			"ANNONCE_PAGE_TITLE"					=> 	"Espace Annonces",
			"ANNONCE_PAGE_HEADER"					=> 	"CABB :: Babillard",
			"ANNONCE_PAGE_CAT_HEADER"				=> 	"CABB :: Annonces par cat&eacute;gories",
			"ANNONCE_PAGE_BACK"						=> 	"Retour aux annonces",
			"ANNONCE_PJ"							=> 	"Pi&eacute;ce-jointe",
			"ANNONCE_RBOX_CAT_TITLE"				=>	"Annonces par cat&eacute;gories",
			"ANNONCE_LOCATION"						=>	"Lieu",
			"NO_ANNONCE"							=>	"Aucune annonce &agrave; afficher",
			"NO_ANNONCE_CATEGORY"					=>	"Aucune categorie d\'annonce &agrave; afficher",
			
			//Annonce
			"ANNONCE_SIDE_BOX_TITLE" 					=> 	"Le babillard du CABB",
			"ANNONCE_BOX_TITLE" 					=> 	"La une du babillard",
			"ANNONCE_BOX_LINK"						=> 	"&raquo;Toutes les annonces",
			"ANNONCE_BOX_LINK_ALL"					=> 	"Toutes les annonces",
			"ANNONCE_PAGE_TITLE"					=> 	"Le babillard du CABB",
			"ANNONCE_PAGE_HEADER"					=> 	"CABB :: Le babillard",
			"ANNONCE_PAGE_CAT_HEADER"				=> 	"CABB :: Annonces et communiqu&eacute;s par cat&eacute;gories",
			"ANNONCE_PAGE_BACK"						=> 	"&raquo;Retour au babillard",
			"ANNONCE_PJ"							=> 	"Pi&eacute;ce-jointe",
			'ANNONCE_CAT_SIDE_BOX_TITLE'			=>	'Annonces par cat&eacute;gories'
		)
	);
	
	//Dashboard
	$db_annonce_output	=	array(
			//Dashboard
			'ANNONCE_ADMIN_MODULE_TITLE'		=>	'Announcement module',
			'ANNONCE_ADMIN_MODULE_DESCR'		=>	'<h5>Module de gestion des annonces.</h5><p>Publiez des annonces et communiqu&eacute;s dans votre site web de la fa&ccedil;on la plus simple et intuitive',
			'ANNONCE_ADMIN_DB_ICON'				=>	'<i class="fa fa-bullhorn text-info icon_13"> </i>',
			'ANNONCE_ADMIN_DB_IMG'				=>	'db_annonce_manager.jpg'
	);