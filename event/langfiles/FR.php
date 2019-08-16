<?php
	$mod_lang_output = array_merge($lang_output,
			array(
			//General
			'MODULE_NAME'						=>	'<i class=\'fa fa-calendar icon_info icon_color\'></i>&nbsp;Event Manager',
			'MODULE_DESCR'						=>	'Gestionnaire des &eacute;v&eacute;nements',
			'FORM_BUTTON_UPDATE'				=>	'Mettre &agrave; jour',
			'FORM_HELP_LEAVE_EMPTY'				=>	'Laisser vide si identique',
			'FORM_LABEL_LANGUAGE'				=>	'Langue',

			//Event module
			"EVENT_ADMIN_MODULE_TITLE"			=>	"Event module",
			"EVENT_ADMIN_MODULE_DESCR"			=>	"<h5>Module de gestion des &eacute;v&eacute;nements.</h5><p>Cr&eacute;ez et modifiez les &eacute;v&eacute;nements en cours ou &agrave; venir qui seront affich&eacute;s de fa&ccedil;on automatique dans votre site web...",
			
			//Admin --	Tables
			'TABLE_HEADER_TITLE' 				=> 	'Titre',
			'TABLE_HEADER_AUTHOR' 				=> 	'Auteur',
			'TABLE_HEADER_DATE-CREA'			=> 	'Cr&eacute;&eacute; le',
			'TABLE_HEADER_DATE-START'			=> 	'D&eacute;but',
			'TABLE_HEADER_DATE-END'				=> 	'Fin',
			'TABLE_HEADER_ACTION'				=> 	'Actions',
			'TABLE_HEADER_CATEGORY'				=>	'Cat&eacute;gorie',
			
			//Admin -- Forms
			'FORM_LABEL_CATEGORY'				=>	'Cat&eacute;gorie',
			'FORM_LABEL_CODE'					=>	'Code',
			'FORM_LABEL_TITLE'					=>	'Titre',
			'FORM_LABEL_DESCRIPTION'			=>	'Description',
			'FORM_LABEL_VENUE'					=>	'Lieu',
			'FORM_LABEL_TITLE'					=>	'Titre',
			'FORM_LABEL_LABEL'					=>	'Libell&eacute;',
			'FORM_LABEL_DATE-START'				=>	'Date de d&eacute;but',
			'FORM_LABEL_DATE-END'				=>	'Date de fin',
			'FORM_LABEL_URL'					=>	'Lien',
			'FORM_LABEL_ADD_EVENT'				=>	'Ajouter un &eacute;v&eacute;nement',
			'FORM_BUTTON_ADD_EVENT'				=>	'Ajouter un &eacute;v&eacute;nement',
			'FORM_BUTTON_ADD_CATEGORY'			=>	'Ajouter la cat&eacute;gorie',
			
			//Admin -- Headers
			'PAGE_HEADER_ADD_EVENT'				=>	'Ajouter un &eacute;v&eacute;nement',
			'PAGE_HEADER_ADD_EVENT_CATEGORY'	=>	'Ajouter une cat&eacute;gorie d\'&eacute;v&eacute;nement',
			'PAGE_HEADER_UPDATE_EVENT'			=>	'Modifier l\'&eacute;v&eacute;nement',
			'PAGE_HEADER_UPDATE_EVENT_CATEGORY'	=>	'Modifier la cat&eacute;gorie',
			'PAGE_HEADER_LIST_EVENTS'			=>	'Afficher les &eacute;v&eacute;nements',
			'PAGE_HEADER_LIST_EVENTS_CATEGORIES'=>	'Afficher les cat&eacute;gories d\'&eacute;v&eacute;nement',

			//Main page display
			"EVENT_SIDE_BOX_TITLE" 				=> 	"Ev&eacute;nements",
			"EVENT_CAT_SIDE_BOX_TITLE"			=>	"Ev&eacute;nements par cat&eacute;gories",
			"EVENT_BOX_TITLE" 					=> 	"Ev&eacute;nements les plus en vue",
			"EVENT_HOME_TITLE"                  =>  "Agenda mensuel d'OYILI",
			"EVENT_BOX_LINK"					=> 	"&raquo;Aller aux &eacute;v&egrave;nements",
			"EVENT_BOX_LINK_ALL"				=> 	"Tous les &eacute;v&eacute;nements",
			"EVENT_PAGE_TITLE"					=> 	"Espace Ev&eacute;nement",
			"EVENT_PAGE_HEADER"					=> 	"CABB :: Espace Ev&eacute;nements",
			"EVENT_PAGE_CAT_HEADER"				=> 	"CABB :: Espace Ev&eacute;nements par cat&eacute;gories",
			"EVENT_PAGE_BACK"					=> 	"Retour aux &eacute;v&eacute;nements",
			"EVENT_PJ"							=> 	"Pi&eacute;ce-jointe",
			"EVENT_RBOX_CAT_TITLE"				=>	"Ev&eacute;nements par cat&eacute;gories",
			"EVENT_STARTS"						=>	"L'&eacute;v&eacute;nement commence le",
			"EVENT_ENDS"						=>	"L'&eacute;v&eacute;nement prend fin le",
			"EVENT_LOCATION"					=>	"Lieu",
			"NO_EVENT"							=>	"Aucun &eacute;v&eacute;nement &agrave; afficher",
			"EVENT_CAT_ERR"						=>	"Aucune cat&eacute;gorie &agrave; afficher",
            "EVENT_PAGE_ATC"                    =>  "Ajouter cet &eacute;v&eacute;nement dans votre agenda",
					
			//Admin validations
			"EVENT_CAT_EMPTY_ERROR"				=>	"Erreur!<br />Vous devez pr&eacute;ciser une cat&eacute;gorie.",
			"EVENT_CODE_EXISTS"					=>	"Erreur!<br />Le code propos&eacute; existe d&eacute;j&agrave;.<br />Veuillez en proposer un autre svp.",
			"EVENT_CAT_EXIST"					=>	"Erreur!<br />Cette cat&eacute;gorie existe d&eacute;j&agrave;.<br />Veuillez en proposer une autre svp.",
			"EVENT_CAT_SUCCESS"					=>	"Bravo!<br />Cat&eacute;gorie cr&eacute;&eacute;e avec succ&egrave;s.",
			"EVENT_CAT_LABEL_EMPTY_REQUIRED"	=>	"Erreur!<br />Le libell&eacute; de la cat&eacute;gorie ne doit pas &ecirc;tre vide.",
			"EVENT_CAT_UPDATE_SUCCESS"			=>	"Bravo!<br />Cat&eacute;gorie mise &agrave; jour avec succ&egrave;s.",
			"EVENT_MANDATORY_FIELDS_ERROR"		=>	"Erreur!<br />Vous devez remplir <strong>tous les champs obligatoires</strong>.",
			"EVENT_TITLE_EXISTS_ERROR"			=>	"Erreur<br />Ce titre a d&eacute;j&egrave; &eacute;t&eacute; enregistr&eacute; dans notre base de donn&eacute;es.<br />Veuillez en proposer un autre svp.",
			"EVENT_EXISTS_ERROR"				=>	"Erreur!<br />Cet &eacute;v&egrave;nement a d&eacute;j&egrave; &eacute;t&eacute; enregistr&eacute; dans notre base de donn&eacute;es.",
			"EVENT_DATE_START_ERROR"			=>	"Erreur!<br />Date de d&eacute; incorrecte!<br />Veuillez reessayer svp!",
			"EVENT_DATE_END_ERROR"				=>	"Erreur!<br />Date de fin incorrecte!<br />Veuillez reessayer svp!",
			"EVENT_DATES_ERROR"					=>	"Erreur!<br />Les dates ne sont pas coh&eacute;rentes (dans le bon ordre)!<br />Veuillez reessayer svp.",
			"EVENT_CREATE_SUCCESS"				=>	"Bravo!<br />Ev&egrave;nement cr&eacute;&eacute; avec succ&egrave;s.",
			"EVENT_UPDATE_SUCCESS"				=>	"Bravo!<br />Ev&egrave;nement mis &agrave; jour avec succ&egrave;s.",
			"EVENT_SET_HIDDEN_SUCCESS"			=>	"Bravo!<br />Ev&egrave;nement masqu&eacute; avec succ&egrave;s. Les visiteurs du site ne pourront plus y avoir acc&egrave;s.",
			"EVENT_SET_VISIBLE_SUCCESS"			=>	"Bravo!<br />Ev&egrave;nement rendu visible pour les visiteurs du site.",
			"EVENT_CAT_DELETE_SUCCESS"			=>	"Bravo!<br />Cat&eacute;gorie supprim&eacute;e avec succ&egrave;s.",
			"EVENT_CAT_VISIBLE_SUCCESS"			=>	"Bravo!<br />Cat&eacute;gorie rendue visible.<br />Tous les &eacute;v&eacute;nements appartenant &agrave; cette cat&eacute;gorie seront accessibles aux visiteurs du site web.",
			"EVENT_CAT_HIDDEN_SUCCESS"			=>	"Bravo!<br />Cat&eacute;gorie masqu&eacute;e.<br />Tous les &eacute;v&eacute;nements appartenant &agrave; cette cat&eacute;gorie ne seront plus accessibles aux visiteurs du site web.",

			//Admin menu
			"EVENT_ADMIN_MENU_DISPLAY"				=>	"Afficher les &eacute;v&egrave;nements",
			"EVENT_ADMIN_MENU_CREATE"				=>	"Ins&eacute;rer un &eacute;v&egrave;nement",
			"EVENT_ADMIN_MENU_CAT_DISPLAY"			=>	"Cat&eacute;gories d'&eacute;v&egrave;nement",
			"EVENT_ADMIN_MENU_CAT_CREATE"			=>	"Ins&eacute;rer une cat&eacute;gorie",
		)
	);