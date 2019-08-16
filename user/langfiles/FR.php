<?php
	$mod_lang_output	=	array_merge($lang_output, 
	array(
			//General
			'MODULE_NAME'							=>	'<i class=\'fa fa-user icon_info icon_color\'></i>&nbsp;User Manager',
			'MODULE_DESCR'							=>	'Gestionnaire des utilisateurs',
			'FORM_BUTTON_UPDATE'					=>	'Mettre &agrave; jour',
			'FORM_HELP_LEAVE_EMPTY'					=>	'Laisser vide si identique',
			
			//Admin --	Tables
			'TABLE_HEADER_NAME' 					=> 	'Nom',
			'TABLE_HEADER_LOGIN' 					=> 	'Identifiant',
			'TABLE_HEADER_E-MAIL'					=> 	'E-mail',
			'TABLE_HEADER_STATUS'					=> 	'Cat&eacute;gorie',
			'TABLE_HEADER_REG-DATE'					=> 	'Date de cr&eacute;ation',
			'TABLE_HEADER_ACTION'					=> 	'Actions',
			'TABLE_HEADER_CATEGORY'					=>	'Cat&eacute;gorie',
			
			//Admin -- Forms
			'FORM_LABEL_CATEGORY'					=>	'Cat&eacute;gorie',
			'FORM_LABEL_USER-NAME'					=>	'Identifiant',
			'FORM_LABEL_PASSWORD'					=>	'Mot de passe',
			'FORM_LABEL_PASSWORD2'					=>	'Confirmez le mot de passe',
			'FORM_LABEL_E-MAIL'						=>	'E-mail',
			'FORM_LABEL_LAST-NAME'					=>	'Nom',
			'FORM_LABEL_FIRST-NAME'					=>	'Pr&eacute;nom',
			'FORM_LABEL_PHONE-NUMBER'				=>	'N&ordm; de t&eacute;l&eacute;phone',
			'FORM_LABEL_ACCOUNT_ACTIVATE'			=>	'Activer le compte',
			'FORM_VALUE_CATEGORY_1'					=>	'Administrateur',
			'FORM_VALUE_CATEGORY_2'					=>	'Editeur',
			'FORM_LABEL_ADD_USER'					=>	'Ajouter un compte utilisateur',
			'FORM_BUTTON_ADD_CATEGORY'				=>	'Ajouter la cat&eacute;gorie',
			'FORM_BUTTON_CONNECT'					=>	'Connexion',
			'FORM_HEADER_CONNECT'					=>	'Connexion &agrave; l\'espace membre',
			'FORM_BUTTON_ADD_USER'					=>	'Ajouter un utilisateur',
			
			//Admin -- Headers
			'PAGE_HEADER_ADD_USER'					=>	'Ajouter un utilisateur',
			'PAGE_HEADER_ADD_USER_CATEGORY'			=>	'Ajouter une cat&eacute;gorie d\'utilisateur',
			'PAGE_HEADER_UPDATE_USER'				=>	'Modifier l\'utilisateur',
			'PAGE_HEADER_UPDATE_USER_CATEGORY'		=>	'Modifier la cat&eacute;gorie',
			'PAGE_HEADER_LIST_USERS'				=>	'Afficher les utilisateurs',
			'PAGE_HEADER_LIST_USERS_CATEGORIES'		=>	'Afficher les cat&eacute;gories d\'utilisateurs',

			//Admin callouts
			'CALLOUT_INSERT_SUCCESS'				=>	'Bravo!<br />Vous avez cr&eacute;&eacute; un nouvel utilisateur pour la plateforme d\'administration du site web.',
			'CALLOUT_INSERT_ERROR'					=>	'D&eacute;sol&eacute;!<br />Une erreur est survenue au cours du processus de cr&eacute;ation d\'un nouvel utilisateur.',
			'CALLOUT_UPDATE_SUCCESS'				=>	'Bravo!<br />Compte mis &agrave; jour avec succ&egrave;s.',
			'CALLOUT_UPDATE_ERROR'					=>	'D&eacute;sol&eacute;!<br />Une erreur est survenue au cours du processus de la mise &agrave; jour d\'un compte utilisateur.',
			'CALLOUT_DELETE_SUCCESS'				=>	'Bravo!<br />Compte supprim&eacute; avec succ&egrave;s.',
			'CALLOUT_DELETE_ERROR'					=>	'D&eacute;sol&eacute;!<br />Une erreur est survenue au cours du processus de suppression d\'un compte.',
			'CALLOUT_HIDE'							=>	'Bravo.<br />Le compte a &eacute;t&eacute; d&eacute;sactiv&eacute; avec succ&egrave;s.',
			'CALLOUT_SHOW'							=>	'Bravo.<br />Le compte a &eacute;t&eacute; activ&eacute; avec succ&egrave;s.',
			'CALLOUT_CAT_HIDE'						=>	'Bravo.<br />Le type de compte a &eacute;t&eacute; d&eacute;sactiv&eacute; avec succ&egrave;s.',
			'CALLOUT_CAT_SHOW'						=>	'Bravo.<br />Le type de compte a &eacute;t&eacute; activ&eacute; avec succ&egrave;s.',
			'CALLOUT_CAT_DELETE_SUCCESS'			=>	'Bravo.<br />Le type de compte a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s.',
			'CALLOUT_CAT_DELETE_ERROR'				=>	'D&eacute;sol&eacute;.<br />Une erreur est survenue au cours du processus suppression d\'un type de compte utilisateur.',
	    
			//Main page display
			'USER_PAGE_HEADER'						=> 	'MINDDEVEL :: Acc&egrave;s &agrave; l\'espace d\'administration du site web',
			
			//Admin menu
			"USER_ADMIN_MENU_DISPLAY"				=>	"Afficher les utilisateurs",
			"USER_ADMIN_MENU_CREATE"				=>	"Ajouter un utilisateur",
			"USER_ADMIN_MENU_CAT_DISPLAY"			=>	"Afficher les profils",
			"USER_ADMIN_MENU_CAT_CREATE"			=>	"Ajouter un profil ",
			
			//Form validation msgs
			'USER_ERROR_MANDATORY_FIELDS'			=>	'Erreur!<br />Veuillez remplir <strong>tous</strong> les champs obligatoires svp.',
			'USER_ERROR_USER_ALREADY'				=>	'Erreur.<br />L\'identifiant choisi est d&eacute;j&agrave; utilis&eacute; Bien vouloir en choisir un autre svp',
			'USER_ERROR_PASSWORD_NOT_MATCH'			=>	'Erreur!<br />Les mots de passes saisis ne sont pas identiques.',
			'USER_ERROR_INVALID_EMAIL'				=>	'Erreur!<br />L\'adresse &eacute;lectronique saisie est incorrecte',
			'USER_MSG_SENT_TO'						=>	'Un e-mail a &eacute;t&eacute; envoy&eacute; &agrave; ',
			'USER_ACCOUNT_CREATED'					=>	'F&eacute;licitations.<br />Compte cr&eacute;&eacute; avec succ&egrave;s'			
		)
	);
	
	//Dashboard
	$db_user_output	=	array(
			//Dashboard
			'USER_ADMIN_MODULE_TITLE'				=>	'User module',
			'USER_ADMIN_MODULE_DESCR'				=>	'<h5>Users and administrators management module.</h5><p>Easily publish your announcements and communique in your website by using our online wysiwyg editor',
	);