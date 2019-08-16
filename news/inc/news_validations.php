<?php
	//Ajouter une rubrique
	$btn_newsCatInsert	= 	$_POST[btn_newsCatInsert];
	$selLang			= 	$_POST[selLang];
	$txt_newsCatLib 	= 	addslashes($_POST[txt_newsCatLib]);
	$ta_newsCatDescr	= 	addslashes($_POST[ta_newsCatDescr]);
	$txt_newsCatCode	= 	$_POST[txt_newsCatCode];
	
	if(isset($btn_newsCatInsert)){
		if(empty($txt_newsCatCode))
			$news_cat_insert_err_msg 	= 	$mod_lang_output['NEWSCAT_CODE_MANDATORY'];
		elseif(empty($txt_newsCatLib))
			$news_cat_insert_err_msg 	= 	$mod_lang_output['NEWSCAT_LABEL_MANDATORY'];
		elseif($news->chk_entry($news->tbl_newsCat, "news_cat_lib", $txt_newsCatLib))
			$news_cat_insert_err_msg 	= 	$mod_lang_output['NEWSCAT_EXISTS'];
		elseif($news->set_news_cat($txt_newsCatCode, $txt_newsCatLib, $ta_newsCatDescr, $selLang)){
			$news_cat_insert_cfrm_msg 	= 	$mod_lang_output['NEWSCAT_SUCCESS'];
			$system->set_log('NEWS CATEGORY CREATED - ('.$txt_newsCatLib.')');
		}
	}
?>
<?php 
	//ajouter un auteur
	$txtNom				= 	strtoupper(addslashes($_POST[txtNom]));
	$txtPrenom			= 	ucwords(addslashes($_POST[txtPrenom]));
	$selSex				= 	$_POST[selSex];
	$selGroup			= 	$_POST[selGroup];
	$btn_authorInsert	= 	$_POST[btn_authorInsert];
	
	if(isset($btn_authorInsert)){
		if($selSex == "NULL"){
			$err_newsAuthorInsert	= "Sorry!<br />You must choose a sex for the author.";
		}
		elseif((empty($txtNom)) && (empty($txtPrenom))){
			$err_newsAuthorInsert = "Error!<br />You must provide a first or last name for the author";
		}
		elseif($news->chk_entry_trice($news->tbl_newsAuth, $news->fld_newsAuthLastName, $news->fld_newsAuthFirstName, $news->fld_newsAuthCatId, $txtNom, $txtPrenom, $selGroup))
			$err_newsAuthorInsert	= "Sorry!<br />This author exists already";
		elseif($news->set_news_author($txtNom, $txtPrenom, $selSex, $selGroup)){
			$cfrm_newsAuthorInsert	= "Congratulations!<br />Author created successfully.";
			$system->set_log('NEWS AUTHOR CREATED - ('.$txt_newsNom.')');
		}
	}
?>
<?php
	//Modifier une rubrique
	$btn_newsCatUpd		= $_POST[btn_newsCatUpd];
	$hd_newsCatCodeUpd	= $_POST['hd_newsCatCodeUpd'];
	$selLangUpd			= $_POST[selLangUpd];
	$txt_newsCatLibUpd 	= addslashes($_POST[txt_newsCatLibUpd]);
	$ta_newsCatDescrUpd	= addslashes($_POST[ta_newsCatDescrUpd]);
	$txt_newsCatCodeUpd	= $_POST[txt_newsCatCodeUpd];
	
	if(isset($btn_newsCatUpd)){
		/*if(empty($txt_newsCatCodeUpd))
			$news_cat_update_err_msg 	= "Sorry!<br />Category code is mandatory";*/
		if(empty($txt_newsCatLibUpd))
			$news_cat_update_err_msg 	= $mod_lang_output['NEWSCAT_LABEL_MANDATORY'];
		/*
		elseif($news->chk_entry($news->tbl_newsCat, "news_cat_lib", $txt_newsCatLib))
			$news_cat_update_err_msg 	= "Sorry!<br />This category exists already.";*/
		elseif($news->update_news_cat($hd_newsCatCodeUpd, $txt_newsCatLibUpd, $ta_newsCatDescrUpd, $selLangUpd)){
			$news_cat_update_cfrm_msg 	= $mod_lang_output['NEWSCAT_UPDATE_SUCCESS'];
			$news->set_xml_news("../modules/news/xml/news.xml");
			$system->set_log('NEWS CATEGORY UPDATED - ('.$txt_newsCatLibUpd.')');
			//Maj le flux RSS:
			$myRss->makeRSS("../modules/news/rss/news.xml");
		}
	}
?>

<?php
	//-----Inserer une news------------------//
	$txt_newsTitle 		= addslashes($_POST[txt_newsTitle]);
	$ta_newsHead 		= addslashes($_POST[ta_newsHead]);
	$sel_newsCat 		= addslashes($_POST[sel_newsCat]);
	$datePub			= $_POST[cmbYear]."-".$_POST[cmbMonth]."-".$_POST[cmbDay]." ".$_POST[cmbHour].":".$_POST[cmbMinute].":".$_POST[cmbSecond];
	$ta_newsContent		= addslashes($_POST[ta_newsContent]);
	$sel_newsAuthor		= $_POST[sel_newsAuthor];
	$btn_newsInsert		= $_POST[btn_newsInsert];
	$sel_newsLang		= $_POST[hdLang];
	$ta_newsTags		= addslashes($_POST[ta_newsTags]);
	
	//Gestion des imagettes et des images à la une
	$news_thumbImg			= new cwd_gallery("../modules/news/img/thumbs/", "../modules/news/img/img_pages/");
	$news_thumbImg2			= new cwd_gallery("../modules/news/img/thumbs/", "../modules/news/img/img_pages/");
	$news_headImg			= new cwd_gallery("../modules/news/img/heads/", "../modules/news/img/img_pages/");
	
	//Definition du repertoire d'envoi des images et des imagettes
	$news_thumbImg->set_fileDirectory("../img/img_pages/");
	$file_newsThumb_name	= $_FILES[file_newsThumb][name];
	$file_newsThumb_temp	= $_FILES[file_newsThumb][tmp_name];
	$file_newsThumb_size	= $_FILES[file_newsThumb][size];
	
	//Imagette intérieure:
	$news_thumbImg2->set_fileDirectory("../img/img_pages/");
	$file_newsThumb2_name	= $_FILES[file_newsThumb2][name];
	$file_newsThumb2_temp	= $_FILES[file_newsThumb2][tmp_name];
	$file_newsThumb2_size	= $_FILES[file_newsThumb2][size];
	
	//Idem pour les images à la une
	$news_headImg->set_fileDirectory("../modules/news/img/heads/");
	$file_newsHead_name		= $_FILES[file_newsHead][name];
	$file_newsHead_temp		= $_FILES[file_newsHead][tmp_name];
	$file_newsHead_size		= $_FILES[file_newsHead][size];
	
	//Procédure d'insertion
	if(isset($btn_newsInsert)){
		//Pr&eacute;alable pour les imagettes
		$news_thumbExt 	= $news_thumbImg->get_file_ext($file_newsThumb_name);
		$news_thumbType	= $news_thumbImg->fileImgType;
		
		//Creation des fichiers temporaires
		$news_thumbImg->set_fileTempName($file_newsThumb_temp);
		$news_thumbImg2->set_fileTempName($file_newsThumb2_temp);
		$news_headImg->set_fileTempName($file_newsHead_temp);
		
		if($sel_newsLang == 'NULL' OR $sel_newsLang == '')
		    $err_newsInsert = $mod_lang_output['FORM_ERROR_LANG'];
		elseif(empty($txt_newsTitle) || empty($ta_newsHead) || empty($ta_newsContent))
			$err_newsInsert = $mod_lang_output['NEWS_FIELDS_MANDATORY'];
		elseif(!checkdate($_POST[cmbMonth], $_POST[cmbDay], $_POST[cmbYear]))
			$err_newsInsert	= $mod_lang_output['NEWS_DATE_NOT_VALID'];
		elseif($news->chk_entry($news->tbl_news, "news_title", $txt_newsTitle))
			$err_newsInsert	= $mod_lang_output['NEWS_TITLE_EXISTS'];
		elseif($news->chk_entry($news->tbl_news, "news_content", $ta_newsContent))
			$err_newsInsert	= $mod_lang_output['NEWS_EXISTS'];
		elseif($file_newsHead_name == "")
			$err_newsInsert	= $mod_lang_output['NEWS_TOP_STORY_IMG'];
		
		elseif($file_newsThumb_name != ""){
			if(!in_array($news_thumbExt, $news_thumbType))
				$err_newsInsert	= $mod_lang_output['NEWS_FILE_TYPE_ERROR'];
			else{
				if($inserted = ($news->set_news($sel_newsCat, $txt_newsTitle, $ta_newsHead, $file_newsHead_name, $ta_newsContent, $datePub, $file_newsThumb_name, $sel_newsAuthor, $ta_newsTags, $sel_newsLang))){
					//NB: set_fileDirectory et fileSend sont des methodes de cwd_file_transact qu'etend la classe cwd_gallery()
					//Envoi de l'imagette 1:
					$news_thumbImg->set_fileDirectory("../modules/news/img/thumbs/");
					$file_newsThumb_name = "thumb80_".$inserted.".jpg";
					$news_thumbImg->fileSend($file_newsThumb_name);
					
					//Envoi de l'imagette 2:
					$news_thumbImg2->set_fileDirectory("../modules/news/img/thumbs/");
					$file_newsThumb2_name = "thumb120_".$inserted.".".$news_thumbExt;
					$news_thumbImg2->fileSend($file_newsThumb2_name);
					//MAJ des données dans la table
					$news->update_news_element($inserted, "news_thumb", $file_newsThumb_name); //On n'envoie pas la 2è imagette ds la BDD pour l'instant!
					
					//Envoi de l'image à la une
					//$news_headImg->set_fileDirectory("../img/img_articles/heads/"); :: déjà fait plus haut
					$news_headImg->fileSend($file_newsHead_name);
					
					//Creation de l'imagette1...
					$news_thumbImg->set_imgs_dir("../modules/news/img/thumbs/");
					$news_thumbImg->set_thumbs_dir("../modules/news/img/thumbs/");
					$news_thumbImg->create_thumbs($file_newsThumb_name, $news->imgThumb_1);
					//Creation de l'imagette2...
					$news_thumbImg2->set_imgs_dir("../modules/news/img/thumbs/");
					$news_thumbImg2->set_thumbs_dir("../modules/news/img/thumbs/");
					$news_thumbImg2->create_thumbs($file_newsThumb2_name, $news->imgThumb_2);
				}	
		
				$cfrm_newsInsert	=	$mod_lang_output['NEWS_INSERT_SUCCESS_THUMB'];
				$system->set_log('NEWS CREATED - ('.$txt_newsTitle.')');
				//Cr&eacute;er le Data Set Correspondant
				$news->set_xml_news("../modules/news/xml/news.xml");
				//Maj le flux RSS:
				$myRss->makeRSS("../modules/news/rss/news.xml");
			}
		}
		else{
			if(empty($file_newsThumb_name)){
				if($newsId = $news->set_news($sel_newsCat, $txt_newsTitle, $ta_newsHead, $file_newsHead_name, $ta_newsContent, $datePub, $news->news_thumbDefault, $sel_newsAuthor, $ta_newsTags, $sel_newsLang)){
					//Envoi de l'image à la une
					$news_headImg->fileSend($file_newsHead_name);					
					$cfrm_newsInsert 	=	$mod_lang_output['NEWS_INSERT_SUCCESS'];
					$system->set_log('NEWS CREATED - ('.$txt_newsTitle.') - NO THUMBS');
					//Cr&eacute;er le Data Set Correspondant
					$news->set_xml_news("../modules/news/xml/news.xml");
					//Maj le flux RSS:
					$myRss->makeRSS("../modules/news/rss/news.xml");
				}
			}
		}
	}
?>

<?php 
	//Modifier un article
	$btn_newsUpdate			= 	$_POST[btn_newsUpdate];
	$txt_newsTitleUpdate 	= 	addslashes($_POST[txt_newsTitleUpdate]);
	$ta_newsHeadUpdate 		= 	addslashes($_POST[ta_newsHeadUpdate]);
	$sel_newsCatIdUpdate 	= 	$_POST[sel_newsCatIdUpdate];
	$date_pubUpdate			= 	$_POST[cmbYearUpd]."-".$_POST[cmbMonthUpd]."-".$_POST[cmbDayUpd]." ".$_POST[cmbHourUpd].":".$_POST[cmbMinuteUpd].":".$_POST[cmbSecondUpd];
	$hd_newsId				= 	$_POST[hd_newsId];
	$hd_newsHeadImg			= 	$_POST[hd_newsHeadImg];
	$hd_newsThumb			= 	$_POST[hd_newsThumb];
	$ta_newsContentUpdate	= 	addslashes($_POST[ta_newsContentUpdate]);
	$sel_newsAuthorIdUpdate	= 	$_POST[sel_newsAuthorIdUpdate];
	$ta_newsTagsUpdate		= 	addslashes($_POST[ta_newsTagsUpdate]);
	$sel_newsLangIdUpdate	= 	$_POST[sel_newsLangIdUpdate];
	
	//Gestion des imagettes et des images à la une
	$news_thumbUpdate		= new cwd_gallery("../modules/news/img/thumbs/", "../modules/news/img/img_articles/");
	$news_headImgUpdate		= new cwd_gallery("../modules/news/img/heads/", "../modules/news/img/img_articles/");
	
	//Definition du repertoire d'envoi des images et des imagettes
	$news_thumbUpdate->set_fileDirectory("../modules/news/img/thumbs/");
	$file_newsThumbUpdate_name	= $_FILES[file_newsThumbUpdate][name];
	$file_newsThumbUpdate_temp	= $_FILES[file_newsThumbUpdate][tmp_name];
	$file_newsThumbUpdate_size	= $_FILES[file_newsThumbUpdate][size];
	
	//Idem pour les images à la une
	$news_headImgUpdate->set_fileDirectory("../modules/news/img/heads/");
	$file_newsHeadImgUpdate_name		= $_FILES[file_newsHeadImgUpdate][name];
	$file_newsHeadImgUpdate_temp		= $_FILES[file_newsHeadImgUpdate][tmp_name];
	$file_newsHeadImgUpdate_size		= $_FILES[file_newsHeadImgUpdate][size];
	
	if(isset($btn_newsUpdate)){
		//
		$news_thumbExtUpdate 	= $news_thumbUpdate->get_file_ext($file_newsThumbUpdate_name);
		$news_thumbTypeUpdate	= $news_thumbUpdate->fileImgType;
	
		//Creation des fichiers temporaires
		$news_thumbUpdate->set_fileTempName($file_newsThumbUpdate_temp);
		$news_headImgUpdate->set_fileTempName($file_newsHeadImgUpdate_temp);
	
		if(empty($txt_newsTitleUpdate) || empty($ta_newsHeadUpdate) || empty($ta_newsContentUpdate))
			$err_newsUpdate 	=	$mod_lang_output['NEWS_FIELDS_MANDATORY'];
		elseif($news->update_news($hd_newsId,
				$date_pubUpdate,
				$txt_newsTitleUpdate,
				$ta_newsHeadUpdate,
				$ta_newsContentUpdate,
				$hd_newsHeadImg,
				$sel_newsCatIdUpdate,
				$hd_newsThumb,
				$sel_newsAuthorIdUpdate,
				$ta_newsTagsUpdate,
				$sel_newsLangIdUpdate)){
			if($file_newsHeadImgUpdate_name 	!= ""){ //Si l'on a choisi une autre image de une...
				$news->update_entry_by_id($news->tbl_news, $news->fld_newsId, "news_imgfile", $file_newsHeadImgUpdate_name, $hd_newsId);
				//NB: set_fileDirectory et fileSend sont des methodes de cwd_file_transact qu'etend la classe cwd_gallery()
				$news_headImgUpdate->set_fileDirectory("../modules/news/img/heads/");
				$news_headImgUpdate->fileSend($file_newsHeadImgUpdate_name);
			}
	
			if($file_newsThumbUpdate_name 	!= ""){ //Si on a choisi une autre imagette...
				//Renommer le fichier:
				$file_newsThumbUpdate_name = "thumb80_".$hd_newsId.".".$news_thumbExtUpdate;
				//MAJ de la BDD
				$news->update_entry_by_id($news->tbl_news, $news->fld_newsId, "news_thumb", $file_newsThumbUpdate_name, $hd_newsId);
				//NB: set_fileDirectory et fileSend sont des methodes de cwd_file_transact qu'etend la classe cwd_gallery()
				$news_thumbUpdate->set_fileDirectory("../modules/news/img/thumbs/");
				$news_thumbUpdate->fileSend($file_newsThumbUpdate_name);
	
				//Redimensionnement de l'imagette:
				$news_thumbUpdate->set_imgs_dir("../modules/news/img/thumbs/");
				$news_thumbUpdate->set_thumbs_dir("../modules/news/img/thumbs/");
				$news_thumbUpdate->create_thumbs($file_newsThumbUpdate_name, $news->imgThumb_1);
			}
	
			$cfrm_newsUpdate	=	$mod_lang_output['NEWS_UPDATE_SUCCESS'];
			$system->set_log('NEWS UPDATED - ('.$txt_newsTitleUpdate.')');
			//Cr&eacute;er le Data Set Correspondant
			$news->set_xml_news("../modules/news/xml/news.xml");
			//Maj le flux RSS:
			$myRss->makeRSS("../modules/news/rss/news.xml");
		}
	}
?>

<?php 
	//-----Inserer un groupe d'auteurs de news------------------//
	$btn_newsAuthorGroupInsert	= $_POST[btn_newsAuthorGroupInsert];
	$txt_newsAuthorGroupInsert	= $_POST[txt_newsAuthorGroupInsert];
	
	if(isset($btn_newsAuthorGroupInsert)){
		if($news->chk_entry($news->tbl_newsAuthCat, $news->fld_newsAuthCatLib, $txt_newsAuthorGroupInsert))
			$err_newsAuthorGroupInsert	=	$mod_lang_output['NEWS_AUTHOR_GROUP_EXISTS'];
		elseif(empty($txt_newsAuthorGroupInsert))
			$err_newsAuthorGroupInsert	=	$mod_lang_output['NEWS_AUTHOR_GROUP_EMPTY'];
		elseif($news->set_news_author_group($txt_newsAuthorGroupInsert)){
			$cfrm_newsAuthorGroupInsert	= 	$mod_lang_output['NEWS_AUTHOR_GROUP_SUCCESS'];
			$system->set_log('NEWS AUTHOR GROUP CREATED - ('.$txt_newsAuthorGroupInsert.')');
		}
	}
?>
<?php 
	//-----Modifier un groupe d'auteurs de news------------------//
	$btn_newsAuthorCatUpdate	= $_POST[btn_newsAuthorCatUpdate];
	$txt_newsAuthorCatUpdate	= $_POST[txt_newsAuthorCatUpdate];
	
	if(isset($btn_newsAuthorCatUpdate)){
		if(empty($txt_newsAuthorCatUpdate))
			$err_newsAuthorCatUpdate	=	$mod_lang_output['NEWS_AUTHOR_GROUP_EMPTY'];
		elseif($news->update_news_author_cat($_REQUEST[$news->URI_newsAuthCatVar], $txt_newsAuthorCatUpdate)){
			$cfrm_newsAuthorCatUpdate	= 	$mod_lang_output['NEWS_AUTHOR_GROUP_UPDATE_SUCCESS'];
			$system->set_log('NEWS AUTHOR GROUP UPDATED - ('.$txt_newsAuthorCatUpdate.')');
		}
	}
?>
<?php 
	//-----Modifier un auteur de news------------------//
	$btn_newsAuthorUpdate		= $_POST[btn_newsAuthorUpdate];
	$hd_newsAuthorIdUpdate		= $_POST[hd_newsAuthorIdUpdate];
	$txt_newsAuthorLastUpdate	= $_POST[txt_newsAuthorLastUpdate];
	$txt_newsAuthorFirstUpdate	= $_POST[txt_newsAuthorFirstUpdate];
	$sel_newsAuthorSexUpdate	= $_POST[sel_newsAuthorSexUpdate];
	$sel_newsAuthorCatUpdate	= $_POST[sel_newsAuthorCatUpdate];
	
	if(isset($btn_newsAuthorUpdate)){
		/*if(empty($txt_newsAuthorLastUpdate))
			$err_newsAuthorCatUpdate	=	"Vous devez remplir le champs de texte avant de valider svp!";
		elseif($news->update_news_author_cat($_REQUEST[$news->URI_newsAuthCatVar], $txt_newsAuthorCatUpdate))
			$cfrm_newsAuthorCatUpdate	= 	"Groupe mis &agrave; jour avec succ&egrave;s!";*/
		if($news->update_news_author($hd_newsAuthorIdUpdate, $txt_newsAuthorLastUpdate, $txt_newsAuthorFirstUpdate, $sel_newsAuthorSexUpdate, $sel_newsAuthorCatUpdate)){
			$cfrm_newsAuthorUpdate	= $mod_lang_output['NEWS_AUTHOR_UPDATE_SUCCESS'];
			$system->set_log('NEWS AUTHOR UPDATED - ('.$txt_newsAuthorLastUpdate.')');
		}
	}
?>

<?php
	//Actions sur les news et leurs rubriques
	$what 	= $_REQUEST[what];
	$action	= $_REQUEST[action];
	
	switch($action){
		case "newsDelete" : $system->set_log('NEWS DELETED - ('.$news->get_news_by_id($news->fld_newsTitle, $_REQUEST[$news->URI_newsVar]).')');
							$toDo 							=	$news->del_news($_REQUEST[$news->URI_newsVar]);
							$cfrm_newsDisplay				=	$mod_lang_output['NEWS_DELETE_SUCCESS'];
							//Cr&eacute;er le Data Set Correspondant
							$news->set_xml_news("../modules/news/xml/news.xml");
							//Maj le flux RSS:
							$myRss->makeRSS("../modules/news/rss/news.xml");
		break;
		case "newsPrivate": $toDo							=	$news->switch_news_state($_REQUEST[$news->URI_newsVar], "0");
							$cfrm_newsDisplay				=	$mod_lang_output['NEWS_HIDE_OK'];
							$system->set_log('NEWS SET INVISIBLE - ('.$news->get_news_by_id($news->fld_newsTitle, $_REQUEST[$news->URI_newsVar]).')');
							//Cr&eacute;er le Data Set Correspondant
							$news->set_xml_news("../modules/news/xml/news.xml");
							//Maj le flux RSS:
							$myRss->makeRSS("../modules/news/rss/news.xml");
		break;
		case "newsPublish":	$toDo							= 	$news->switch_news_state($_REQUEST[$news->URI_newsVar], "1");
							$cfrm_newsDisplay				= 	$mod_lang_output['NEWS_PUBLISH_OK'];
							$system->set_log('NEWS SET VISIBLE - ('.$news->get_news_by_id($news->fld_newsTitle, $_REQUEST[$news->URI_newsVar]).')');
							//Cr&eacute;er le Data Set Correspondant
							$news->set_xml_news("../modules/news/xml/news.xml");
							//Maj le flux RSS:
							$myRss->makeRSS("../modules/news/rss/news.xml");
		break;
		case "newsUpdate" : $tabUpd							=	$news->get_news($_REQUEST[$news->URI_newsVar]); //Ce tableau sera utilis pour remplir les champs du formulaire de modification
							$news_update = true;
		break;
		case "newsCatDelete" : 	$system->set_log('NEWS CATEGORY DELETED - ('.$news->get_news_cat_by_id($news->fld_newsCatLib, $_REQUEST[$news->URI_newsCatVar]).')');
								$toDo						= 	$news->del_news_cat($_REQUEST[$news->URI_newsCatVar]);
							   	$cfrm_newsCatDisplay		= 	$mod_lang_output['NEWSCAT_DELETE_SUCCESS'];
							  
		break;
		case "newsCatUpdate" : $tabCatUpd 					= 	$news->get_news_cat($_REQUEST[$news->URI_newsCatVar]);
							   $news_catUpdate				= 	true;
		break;
		case "news_authorCatUpdate" : $tab_newsAuthorCatUpd	= 	$news->get_news_author_cat($_REQUEST[$news->URI_newsAuthCatVar]);
								$news_authorCatUpdate		= 	true;
		break;
		case "news_authorUpdate"	: $tab_newsAuthorUpd	= 	$news->get_news_author($_REQUEST[$news->URI_newsAuthVar]);
								$news_authorUpdate			= 	true;
		break;
		case "newsCatPublish" : $toDo 						= 	$news->switch_news_cat_state($_REQUEST[$news->URI_newsCatVar], 1);
								$cfrm_newsCatDisplay		= 	$mod_lang_output['NEWSCAT_PUBLISH'];
		case "newsCatPrivate" : $toDo						= 	$news->switch_news_cat_state($_REQUEST[$news->URI_newsCatVar], 0);
								$cfrm_newsCatDisplay		= 	$mod_lang_output['NEWSCAT_HIDE'];
		break;
		case "news_commentPrivate": $toDo					= 	$news->switch_news_comment_state($_REQUEST[$news->URI_newsCommentVar], "0");
							$cfrm_newsCommentDisplay		= 	$mod_lang_output['NEWS_COMMENT_HIDE'];
		break;
		case "news_commentPublish":	$toDo					= 	$news->switch_news_comment_state($_REQUEST[$news->URI_newsCommentVar], "1");
							$cfrm_newsCommentDisplay		= 	$mod_lang_output['NEWS_COMMENT_PUBLISH'];
		break;
		case "news_commentDelete" : $toDo					= 	$news->del_news_comment($_REQUEST[$news->URI_newsCommentVar]);
							$cfrm_newsCommentCatDisplay		= 	$mod_lang_output['NEWS_COMMENT_DELETE'];
		break;
		case "news_authorDelete" : 	$system->set_log('NEWS AUTHOR DELETED - ('.$news->get_news_author_by_id($news->fld_newsAuthLastName, $_REQUEST[$news->URI_newsAuthVar]).')');
								$toDo						= 	$news->del_news_author($_REQUEST[$news->URI_newsAuthVar]);
								$cfrm_newsAuthorDisplay		= 	$mod_lang_output['NEWS_AUTHOR_DELETE_SUCCESS'];
		break;
		case "news_authorCatDelete" : 	$system->set_log('NEWS AUTHOR GROUP DELETED - ('.$news->get_news_author_cat_by_id($_REQUEST[$news->URI_newsAuthCatVar]).')');
								$toDo						= 	$news->del_news_author_cat($_REQUEST[$news->URI_newsAuthCatVar]);
								$cfrm_newsAuthorCatDisplay	= 	$mod_lang_update['NEWS_AUTHOR_GROUP_DELETE_SUCCESS'];
		break;
	}
?>