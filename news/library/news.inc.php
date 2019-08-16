<?php
	class cwd_news extends cwd_page{
		/*Directories set*/
		var $news_thumbDefault;
		var $news_headImgDefault;
		
		/*Tables set*/
		var $tbl_news;
		var $tbl_newsCat;
		var $tbl_newsAuth;
		var $tbl_newsAuthCat;
		var $tbl_newsHeadImg;
		var $tbl_newsComment;
		var $tbl_newsImg;
		
		/* Fields set*/
		var $fld_newsId;
		var $fld_newsCatId;
		var $fld_newsAuthId;
		var $fld_newsHeadImgId;
		var $fld_newsImgId;
		var $fld_newsCommentId;
		var $fld_newsAuthCatId;
		var $fld_newsLangId;
			
		var $fld_newsTitle;
		var $fld_newsDescr;
		var $fld_newsImg;
		var $fld_newsThumb;
		var $fld_newsDatePub;
		var $fld_newsTags;
		var $fld_newsCatLib;
		var $fld_newsAuthFirstName;
		var $fld_newsAuthLastName;
		var $fld_newsAuthSex;
		var $fld_newsAuthCatLib;
		var $fld_newsCatLang;
		var $fld_newsDisplay;
		
		/*The URI_vars* 
		NB : très utilisees dans les loaders*/
		var $URI_news			=	'pmId';
		var $URI_newsCat		=	'catId';
		var $URI_newsVar		=	'pmId';
		var $URI_newsCatVar 	= 	'catId';
		var $URI_newsCommentVar	= 	'ncmId';
		var $URI_newsAuthVar;
		var $URI_newsAuthCatVar;
		var $URI_separator		= 	'-';
		var $URI_catSeparator	=	';';
		
		var $mod_link			= 	'news.php';
		var $mod_linkDetail		= 	'news_detail.php';
		var $mod_linkCat		= 	'news_cat.php';
		var $mod_linkCatDetail	= 	'news_cat_detail.php';
		
		var	$imgThumb_1			= 	'80';
		var $imgThumb_2			=	'120';
		var	$img_homeWidth		=	'468';
		var $img_homeHeight		=	'180';
		
		//var $modDir				= 	'modules/news/';
		var $thumbDir			=	'modules/news/img/main/';
		var $mod_imgDir			= 	array();

		var $admin_modPage		= 	"news_manager.php";
		//Extra
		var $mod_linkComment	= 	'news_comment.php';
		//var $news_dsPath		=	'modules/news/spry/data/spry-news.xml';
		//---

        /*
         * Constructeur de la classe news
         * **/
        public function __construct(){
            global $thewu32_tblPref, $thewu32_modImgDir, $thewu32_appExt, $lang_output;
            $this->tbl_news     	= 	$thewu32_tblPref.'news';
            $this->tbl_newsCat		= 	$thewu32_tblPref.'news_category';
            $this->tbl_newsAuth		= 	$thewu32_tblPref.'news_authors';
            $this->tbl_newsAuthCat	= 	$thewu32_tblPref.'news_authors_group';
            $this->tbl_newsHeadImg	= 	$thewu32_tblPref.'news_img';
            $this->tbl_newsImg		= 	$thewu32_tblPref.'news_img';
            $this->tbl_newsComment	= 	$thewu32_tblPref.'news_comment';
            $this->modName			=	'news';

            $this->fld_newsId				= "news_id";
            $this->fld_newsCatId			= "news_cat_id";
            $this->fld_newsAuthId			= "naut_id";
            $this->fld_newsAuthCatId		= "naut_group_id";
            $this->fld_newsHeadImgId		= "nimg_id";
            $this->fld_newsImgId			= "nimg_id";
            $this->fld_newsCommentId		= "comment_id";
            $this->fld_newsLangId			= "lang_id";

            $this->fld_newsTitle			= "news_title";
            $this->fld_newsDescr			= "news_header";
            $this->fld_news_catLib			= "news_cat_lib";
            $this->fld_newsCatLib			= "news_cat_lib";
            $this->fld_newsDatePub 			= "news_date";
            $this->fld_newsTags				= "news_tags";
            $this->fld_newsImg				= "news_imgfile";
            $this->fld_newsThumb			= "news_thumb";
            $this->fld_newsAuthFirstName	= "naut_pnom";
            $this->fld_newsAuthLastName		= "naut_nom";
            $this->fld_newsAuthSex			= "naut_sexe";
            $this->fld_newsAuthCatLib		= "naut_group_lib";
            $this->fld_newsCatLang			= "lang";
            $this->fld_newsDisplay			= "display";

            $this->news_thumbDefault		= "news.jpg";
            $this->news_headImgDefault		= "header.jpg";
            $this->modDir					.= $this->modName;

            $this->mod_imgDir				= 	array('thumbs' => $this->modDir.'/img/thumbs/', 'heads' => $this->modDir.'/img/heads/', 'main' => $this->modDir.'/img/main/');
            $this->thewu32_appExt			=	$thewu32_appExt;

            $this->set_uri_news("pmId");
            $this->set_uri_news_author("nautId");
            $this->set_uri_news_author_cat("naut_catId");
            return $toRet = array("NEWS"=>($this->tbl_news), "NEWS_CAT" => ($this->tbl_newsCat), "NEWS_URI"=>($this->URI_newsVar));
        }

		function cwd_news(){
            self::__construct();
		}
		
		function admin_get_menu($level){
			switch($level){
				case "admin" : $toRet = "<div class=\"ADM_menu\">
											  <h1>Gestion des news</h1>
											  <ul class=\"ADM_menu_title\">
												<h2>Les News</h2>
												<li><a href=\"?what=newsDisplay\">Lister les news</a></li>
												<li><a href=\"?what=newsInsert\">Ins&eacute;rer une news</a></li>
												<!-- <li><a href=\"?what=news_commentDisplay\">Les r&eacute;actions aux news</a></li> -->
												<li><a href=\"?what=news_authorDisplay\">Les auteurs</a></li>
												<li><a href=\"?what=news_authorCatDisplay\">Les groupes</a></li>
											  </ul>
											  <ul>
												<h2>Les Rubriques</h2>
												<li><a href=\"?what=newsCatDisplay\">Afficher les rubriques</a></li>
												<li><a href=\"?what=newsCatInsert\">Ajouter une rubrique</a></li>
											  </ul>
											  <div class=\"ADM_menu_descr\"></div>
										  </div>";
				break;
				case "editor" : $toRet = "<div class=\"ADM_menu\">
											  <h1>Gestion des news</h1>
											  <ul class=\"ADM_menu_title\">
												<h2>Les News</h2>
												<li><a href=\"?what=newsDisplay\">Lister les news</a></li>
												<li><a href=\"?what=newsInsert\">Ins&eacute;rer une news</a></li>
												<li><a href=\"?what=news_commentDisplay\">Les r&eacute;actions aux news</a></li>
											  </ul>
											  <div class=\"ADM_menu_descr\"></div>
										  </div>";
				break;
			}
		return $toRet;				  
		}
		
			 /****************************************/	
			/* :::::::: All the getters ::::::::    */
		   /****************************************/		
		function get_news_db_infos(){
			$tblNews     = $this->tbl_news;
			$tbl_newsCat = $this->tbl_newsCat;
			return $toRet = array("NEWS"=>$tblNews, "NEWS_CAT"=>$tbl_newsCat);
		}
		
		/**
		 * @param int $new_newsId
		 * @return {array_assoc}
		 * 
		 * @desc Charger un enregistrement d'une news dans un tableau associatif.
		 * Exemple : sert a avoir tout l'enregistrement propre a un ID de news connu.*/
		function get_news($new_newsId){
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_news WHERE $this->fld_newsId = '$new_newsId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'extraire l'article".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = array();
				while($row = mysqli_fetch_array($result)){
					$toRet = array(
							 "ID"      	=> $row[0],
							 "DATE" 	=> $row[1],
							 "TITLE"   	=> $row[2],
							 "DESCR"	=> $row[3],
							 "CONTENT" 	=> $row[4],
							 "HEADIMG"	=> $row[5],
							 "CATID"   	=> $row[6],
							 "THUMB"	=> $row[7],
							 "AUTHOR"  	=> $row[8],
							 "LANG"		=> $row[9],
							 "DISPLAY"	=> $row[10],
							 "TAGS"		=> $row[11]);	
				}
				return $toRet;
			}
			else{
				return false;
			}
		}
		
		function get_news_cat($new_newsCatId){
		/**
		* @param 	:	int $new_newsCatId
		* @return 	:	{array_assoc}
		* 
		* @desc 	:	Obtenir un tableau associatif contenant en enregistrement de rubrique
		**/
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_newsCat WHERE $this->fld_newsCatId = '$new_newsCatId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'extraire la rubrique".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = array();
				while($row = mysqli_fetch_array($result)){
					$toRet = array(
							 "CATID"	=> 	$row[0],
							 "TITLE" 	=> 	$row[1],
							 "DESCR" 	=> 	$row[2],
							 "LANG"		=>	$row[3]);	
				}
				return $toRet;
			}
			else{
				return false;
			}
		}
		
		function get_news_author($new_newsAuthId){
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_newsAuth WHERE $this->fld_newsAuthId = '$new_newsAuthId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'extraire l'auteur.<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = array();
				while($row = mysqli_fetch_array($result)){
					$toRet = array(
							 "AUTH_ID"	=> 	$row[0],
							 "AUTH_LAST" 	=> 	$row[1],
							 "AUTH_FIRST" 	=> 	$row[2],
							 "AUTH_SEX"		=>	$row[3],
							 "AUTH_CAT_ID"	=>	$row[4]);	
				}
				return $toRet;
			}
			else{
				return false;
			}
		}
		
		function get_news_author_cat($new_newsAuthCatId){
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_newsAuthCat WHERE $this->fld_newsAuthCatId = '$new_newsAuthCatId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'extraire le groupe d'auteurs.<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = array();
				while($row = mysqli_fetch_array($result)){
					$toRet = array(
							 "ID"		=> 	$row[0],
							 "TITLE" 	=> 	$row[1]);	
				}
				return $toRet;
			}
			else{
				return false;
			}
		}
		
		function get_news_comment($new_newsCommentId){
		/**
		* @param 	:	int $new_newsCommentId
		* @return 	:	array_assoc()
		* 
		* @desc 	:	Obtenir un tableau associatif contenant un enregistrement de commentaire
		**/
		    //Article a afficher dans la page de lecture des articles
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_newsComment WHERE $this->fld_newsCommentId = '$new_newsCommentId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to get a comment record".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = array();
				while($row = mysqli_fetch_array($result)){
					$toRet = array(
							 "ID" 		=> $row[0],
							 "NID" 		=> $row[1],
							 "DATE" 	=> $row[2],
							 "AUTHOR"	=> $row[3],
							 "EMAIL"	=> $row[4],
							 "CONTENT"	=> $row[5],
							 "DISPLAY"	=> $row[6]);	
				}
				return $toRet;
			}
			else{
				return false;
			}
		}
		
		function get_news_id($condition="WHERE 1"){
		/**
		* @param 	: 	string $sql_condition
		* @return 	: Array()
		*
		* @desc 	: 	Renvoit un tableau d'Id des news selon la condition SQL $condition
		**/
			return $this->load_id($this->tbl_news, $this->fld_newsId, $condition);
		}
		
		function get_news_by_id($new_fldSrc, $new_newsId){
			return $this->get_field_by_id($this->tbl_news, $this->fld_newsId, $new_fldSrc, $new_newsId);
		}
		
		function get_news_cat_id($condition="WHERE 1"){
			/**
			* @param 	: 	string $sql_condition
			* @return 	: 	Array()
			*
			* @desc		: 	Renvoit un tableau d'Id des news selon la condition SQL $condition
			**/
				return $this->load_id($this->tbl_newsCat, $this->fld_newsCatId, $condition);
		}
		
		function get_news_comment_id($condition="WHERE 1"){
		/**
		* @param : 	string $sql_condition
		* @return : Array()
		*
		* @descr : 	Renvoit un tableau d'Id des commentaires selon la condition SQL $condition
		**/
			return $this->load_id($this->tbl_newsComment, $this->fld_newsCommentId, $condition);
		}
		
		function get_news_cat_by_id($new_fldSrc, $new_newsCatId){
			return $this->get_field_by_id($this->tbl_newsCat, $this->fld_newsCatId, $new_fldSrc, $new_newsCatId);
		}
		
		function get_cat_id_by_news_id($new_newsId){
			/**
			* @param : 	int new_newsId
			* @return : CATID
			*
			* @descr : 	Connaitre la categorie d'appartenance d'une news
			*/
		    global $thewu32_cLink;
				$query 	= "SELECT $this->fld_newsCatId FROM $this->tbl_news WHERE $this->fld_newsId='$new_newsId'";
				$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load cat ID knowing news ID<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					if($row = mysqli_fetch_row($result)){
						$toRet = $row[0];
					}
				}
				return $toRet;
			}
		
		function get_news_by_cat($new_newsCat){
		/**
		* @param : 	int new_newsCat
		* @return : array
		*
		* @descr : 	Charger un tableau d'id de news appartenant a la meme categorie
		*/
		    global $thewu32_cLink;
			$query 	= "SELECT $this->fld_newsId FROM $this->tbl_news WHERE $this->fld_newsCatId='$new_newsCat' AND display='1'";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news id from cat<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = array();
				while($row = mysqli_fetch_row($result)){
					array_push($toRet, $row[0]);
				}
			}
			return $toRet;
		}
			
		function get_news_id_by_cat($new_newsCatId){
			return $this->get_news_by_cat($new_newsCatId);
		}
		
		/*
		function cmb_getNewsCat($FORM_var="", $lang="FR"){
			$query 	= "SELECT $this->fld_newsCatId, news_cat_lib FROM $this->tbl_newsCat WHERE $this->fld_modLang = '$lang' ORDER BY news_cat_lib";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news categories.<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = "";
				//if($FORM_var	== )
				while($row = mysqli_fetch_array($result)){
					$selected = ($FORM_var == $row[0])?("SELECTED"):("");
					$toRet .= "<option value=\"$row[0]\"$selected>$row[1]</option>";
				}
			}
			else{
				$toRet = "<option>Aucune rubrique &agrave; afficher</option>";
			}
			return $toRet;
		}
		*/
		function admin_cmb_show_rub_by_lang($lang="FR", $FORM_var="", $CSS_class=""){
		    global $lang_output, $thewu32_cLink;
		    if($lang   !=  'XX')
		        $query 	=  "SELECT * FROM $this->tbl_newsCat WHERE $this->fld_modLang ='$lang' ORDER BY $this->fld_newsCatLib";
		        else
		            $query  =  "SELECT * FROM $this->tbl_newsCat ORDER BY $this->fld_newsCatLib";
		            
		            $result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news' categories.<br />".mysqli_connect_error());
		            if($total = mysqli_num_rows($result)){
		                $toRet = "";
		                //if($FORM_var	== )
		                while($row = mysqli_fetch_array($result)){
		                    $selected = ($FORM_var == $row[0])?("SELECTED"):("");
		                    $toRet .= "<option value=\"$row[0]\"$selected>$row[1] ($row[3])</option>";
		                }
		            }
		            else{
		                $toRet = "<option value=\"\">".$lang_output['ADMIN_COMBO_NO_DATA']."</option>";
		            }
		            return $toRet;
		}
		
		function cmb_get_news_author_cat($FORM_var=""){
		    global $thewu32_cLink;
			$query 	= "SELECT $this->fld_newsAuthCatId, $this->fld_newsAuthCatLib FROM $this->tbl_newsAuthCat ORDER BY $this->fld_newsAuthCatLib";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news authors groups.<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = "";
				//if($FORM_var	== )
				while($row = mysqli_fetch_array($result)){
					$selected = ($FORM_var == $row[0])?("SELECTED"):("");
					$toRet .= "<option value=\"$row[0]\"$selected>$row[1]</option>";
				}
			}
			else{
				$toRet = "<option>Aucun groupe &agrave; afficher</option>";
			}
			return $toRet;
		}
		
		function cmb_getNewsAuthors($FORM_var=""){
		    global $thewu32_cLink;
			$query 	= "SELECT $this->fld_newsAuthId, $this->fld_newsAuthLastName, $this->fld_newsAuthFirstName FROM $this->tbl_newsAuth ORDER BY $this->fld_newsAuthLastName";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news authors.<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = "";
				//if($FORM_var	== )
				while($row = mysqli_fetch_array($result)){
					$selected = ($FORM_var == $row[0])?("SELECTED"):("");
					$toRet .= "<option value=\"$row[0]\"$selected>".ucwords($row[2])." ".strtoupper($row[1]).", ".$this->get_news_author_cat_by_author_id($row[0])."</option>";
				}
			}
			else{
				$toRet = "<option>Aucune rubrique &agrave; afficher</option>";
			}
			return $toRet;
		}		
		
		function get_newsauthor_by_id($new_newsAuthId){
			$lName = strtoupper($this->get_field_by_id($this->tbl_newsAuth, $this->fld_newsAuthId, 'naut_nom', $new_newsAuthId));
			$fName = ucfirst($this->get_field_by_id($this->tbl_newsAuth, $this->fld_newsAuthId, 'naut_pnom', $new_newsAuthId));
			return $toRet = "$fName $lName";
		}
		
		//Pour la pagination en admin et en public
		function get_news_count(){
			return $this->count_in_tbl($this->tbl_news, "news_id");
		}
		function get_news_count_where($where){
			return $this->count_in_tbl_where($this->tbl_news, "news_id", $where);
		}
		
		function get_news_link($linkLib){
			return $toRet = "<a href=\"$this->mod_link\">$linkLib</a>";
		}
		/* :::::::: ---- GETTERS End ---- :::::::: */	


			 /****************************************/	
			/* :::::::: All the SETTERS ::::::::    */
		   /****************************************/	
		
		function set_uri_news($new_uriVar){
			return $this->URI_newsVar = $new_uriVar;
		}
		
		function set_uri_news_author($new_uriVar){
			return $this->URI_newsAuthVar = $new_uriVar;
		}
		
		function set_uri_news_author_cat($new_uriVar){
			return $this->URI_newsAuthCatVar = $new_uriVar;
		}
		
		function set_news($newsCat, $newsTitle, $newsHead, $news_headImg, $newsContent, $newsDate, $newsThumb, $newsAuthor, $newsTags, $newsLang="FR"){
		    global $thewu32_cLink;
			$query = "INSERT INTO $this->tbl_news VALUES('".$this->news_autoIncr()."', '$newsDate', '$newsTitle', '$newsHead', '$newsContent', '$news_headImg', '$newsCat', '$newsThumb', '$newsAuthor', '$newsLang', '1', '$newsTags')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to insert the recent news!<br />".mysqli_error($thewu32_cLink));
			if($result)
			    return mysqli_insert_id($thewu32_cLink);
			else
				return false;
		}
		
		/**
		 * @param int $new_newsCatId
		 * @param str $new_newsCatTitle
		 * @param str $new_newsCatDescr
		 * @param char $new_newsCatLang
		 * @return true/false
		 * 
		 * @desc Create a new news category
		 * **/
		function set_news_cat($new_newsCatId, $new_newsCatTitle, $new_newsCatDescr, $new_newsCatLang){
		    global $thewu32_cLink;
			$query = "INSERT INTO $this->tbl_newsCat VALUES('$new_newsCatId', '$new_newsCatTitle', '$new_newsCatDescr', '$new_newsCatLang')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to insert the news cat!<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}
		
		/**
		 * @param str $new_newsAuthorLastName
		 * @param str $new_newsAuthorFirstName
		 * @param char $new_newsAuthorSex
		 * @param int $new_newsAuthorGroup
		 * @return true/false
		 * 
		 * @desc Create a new news author 
		 * **/
		function set_news_author($new_newsAuthorLastName, $new_newsAuthorFirstName, $new_newsAuthorSex, $new_newsAuthorGroup){
		    global $thewu32_cLink;
			$query	= "INSERT INTO $this->tbl_newsAuth VALUES('', '$new_newsAuthorLastName', '$new_newsAuthorFirstName', '$new_newsAuthorSex', '$new_newsAuthorGroup')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to insert the author<br />".mysqli_error($thewu32_cLink));
			if($result)
				return true;
			else
				return false;
		}
		
		/**
		 * @param str $new_newsAuthorGroupLib
		 * @return true/false
		 * 
		 * @desc Create a new news group author 
		 * **/
		function set_news_author_group($new_newsAuthorGroupLib){
		    global $thewu32_cLink;
			$query	= "INSERT INTO $this->tbl_newsAuthCat VALUES('', '$new_newsAuthorGroupLib')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to insert the author group<br />".mysqli_error($thewu32_cLink));
			if($result)
				return true;
			else
				return false;
		}
		
		/*Rendre public/prive une rubrique*/
		function set_rub_state($new_newsCatId, $new_stateId){
			return $this->set_updated_1($this->tbl_newsCat, "display", $new_stateId, $this->fld_newsCatId, $new_newsCatId);
		}
		
		/*Rendre public/prive un article*/
		function set_news_state($new_newsId, $new_stateId){
			return $this->set_updated_1($this->tbl_news, "display", $new_stateId, $this->fld_newsId, $new_newsId);
		}
		
		/*Rendre public/prive une comment &agrave; un article*/
		function set_news_comment_state($new_newsCommentId, $new_stateId){
			return $this->set_updated_1($this->tbl_newsComment, "display", $new_stateId, $this->fld_newsCommentId, $new_newsCommentId);
		}
		
		function set_news_comment($new_commentEmail, $new_commentName, $newCommentContent, $new_commentArticle){
		    //Ajouter une comment ï¿½ l'article dont l'id est $new_commentArticle
		    global $thewu32_cLink;
			$datetime = date("Y-m-d")." ".date("G:h:i");
			$query = "INSERT INTO $this->tbl_newsComment VALUES('', '$new_commentArticle', '$datetime', '$new_commentName', '$new_commentEmail', '$newCommentContent', '1')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Erreur d'insertion de commentaire pour l'article nï¿½$new_commentArticle !<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}
		
		function set_member_news_comment($new_commentArticle, $new_commentUsrId, $newCommentContent){
		    //Ajouter une comment ï¿½ l'article dont l'id est $new_commentArticle
		    global $thewu32_cLink;
			$datetime = date("Y-m-d")." ".date("G:h:i");
			$query = "INSERT INTO $this->tbl_newsComment VALUES('', '$new_commentArticle', '$datetime', '$new_commentUsrId', '', '$newCommentContent', '1')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Erreur d'insertion de commentaire pour l'article nï¿½$new_commentArticle !<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}
		
		/*Supprimer un article*/
		function del_news($new_newsId){
			return $this->rem_entry($this->tbl_news, $this->fld_newsId, $new_newsId);
		}
		
		/*Supprimer un commentaire*/
		function del_news_comment($new_newsCommentId){
			return $this->rem_entry($this->tbl_newsComment, $this->fld_newsCommentId, $new_newsCommentId);
		}
		
		/**
		 * @param int $new_newsAuthorId
		 * @return true/false
		 * 
		 * @desc Supprimer un auteur
		 * */
		function del_news_author($new_newsAuthorId){
			return $this->rem_entry($this->tbl_newsAuth, $this->fld_newsAuthId, $new_newsAuthorId);
		}
		
		/**
		 * @param int $new_newsAuthorCatId
		 * @return true/false
		 * 
		 * @desc Supprimer une categorie d'auteurs
		 * */
		function del_news_author_cat($new_newsAuthorCatId){
			return $this->rem_entry($this->tbl_newsAuthCat, $this->fld_newsAuthCatId, $new_newsAuthorCatId);
		}
		
		function del_news_cat($new_newsCatId){
		/**
		 * @param int $new_newsCatId 
		 * @return true or false
		 *
		 * @ descr : 	Supprimer une rubrique : 
		 * 				Entraine une suppression en cascade dans les tables m�re et fille
		 */
			if(
				($this->rem_entry($this->tbl_newsCat, $this->fld_newsCatId, $new_newsCatId)) 
				&& 
				($this->rem_entry($this->tbl_news, $this->fld_newsCatId, $new_newsCatId))
			)
				return true;
			else 
				return false;
		}
				
		//Cr&eacute;ation du fichier de news au format xml
		function set_xml_news($xmlPath="xml/thewu32_news.xml"){
			$fileContent = $this->load_validXMLNews();
			if($this->write_in_file($xmlPath, $fileContent))
				return true;
			else
				return false;
		}
		
		function set_news_page_detail($new_pageDetail){
			return $this->mod_linkDetail = $new_pageDetail;
		}
		
		function set_news_page($newPage){
			return $this->mod_link = $newPage;
		}
		
		/* :::::::: ---- Setters End ---- :::::::: */	

		
			
			 /****************************************/	
			/* :::::::: All the LOADERS ::::::::    */
		   /****************************************/	
		
	function admin_load_news($nombre='10', $level="admin"){
			global $lang_output, $mod_lang_output, $thewu32_cLink;
			
			$limite = $_REQUEST[limite];
			
			//Recherche du nom de la page
			$path_parts = pathinfo($PHP_SELF);
			$page = $path_parts["basename"].'?what=newsDisplay';
			
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl($this->tbl_news, $this->fld_newsId);
			
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
				if(!$veriflimite) $limite = 0;
				
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
				
			$query 	= "SELECT * FROM $this->tbl_news ORDER BY $this->fld_newsDatePub DESC LIMIT ".$limite.",".$nombre;
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$num	= 0;
				$toRet 	= $nav_menu;
				$toRet 	.= "<table class=\"table table-bordered\">
							<tr>
								<th>&num;</th>
								<th>".$lang_output['TABLE_HEADER_CATEGORY']."</th>
								<th>".$lang_output['TABLE_HEADER_TITLE']."</th>
								<!-- <th>Auteur</th> -->
								<th>".$lang_output['TABLE_HEADER_PUB-DATE']."</th>
								<th>".$lang_output['TABLE_HEADER_ACTION']."</th>
							</tr>";
				while($row = mysqli_fetch_array($result)){
					$num++;
					
					//alterner les liens public / prive
					$stateImg 	= ($row[10] == 0) ? ("<img src=\"img/icons/disabled.gif\" />") : ("<img src=\"img/icons/enabled.gif\" />");
					$varUri		= ($row[10] == "0")?("newsPublish"):("newsPrivate");
					$stateAlt	= ($row[10] == "0")?($lang_output['TABLE_TOOLTIP_SHOW']):($lang_output['TABLE_TOOLTIP_HIDE']);
					//Obtenir les libelles des categories
					$categorie 	= $this->get_news_cat_by_id("news_cat_lib", $row[6]);
					$author		= $this->get_newsauthor_by_id($row[8]);
					//Convertir la date
					$date		= $this->datetime_en3($row[1]);
					//Alternet les css
					$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
					
					$toRet .="<tr class=\"$currentCls\">
								<th scope=\"row\">$num</th>
								<td>$categorie</td>
								<td>$row[2]</td>
								<!-- <td>$author</td> -->
								<td>$date</td>
								<td style=\"background:#FFF; text-align:center;\">
									<a title=\"".$lang_output['TABLE_TOOLTIP_UPDATE']."\" href=\"?what=newsUpdate&action=newsUpdate&$this->URI_newsVar=$row[0]\"><img src=\"img/icons/edit.gif\" /></a>
									<a title=\"".$lang_output['TABLE_TOOLTIP_DELETE']."\" href=\"?what=newsDisplay&action=newsDelete&$this->URI_newsVar=$row[0]\" onclick=\"return confirm('Sure you want to delete?')\"><img src=\"img/icons/delete.gif\" /></a>
									<a title=\"$stateAlt\" href=\"?what=newsDisplay&action=$varUri&$this->URI_newsVar=$row[0]&limite=$limite\">$stateImg</a>
								</td>
							  </tr>";
				}
				$toRet .= "</table>$nav_menu";
				
			}
			else{
				$toRet	= "Aucune news &agrave; afficher";
			}
			return $toRet;
		}
	
		function admin_load_news_cat(){
			global $lang_output, $mod_lang_output, $thewu32_cLink;
			
			$query 	= "SELECT * FROM $this->tbl_newsCat ORDER BY '$this->fld_newsCatId'";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news categories!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$num	= 0;
				$toRet 	= "<table class=\"table table-bordered\">
							<tr>
								<th>&num;</th>
								<th>".$mod_lang_output['TABLE_HEADER_CATEGORY']."</th>
								<th>".$mod_lang_output['TABLE_HEADER_DESCRIPTION']."</th>
								<th colspan=\"2\">".$mod_lang_output['TABLE_HEADER_ACTION']."</th>
							</tr>";
				while($row = mysqli_fetch_array($result)){
					$num++;
					//alterner les liens public / prive
					$state_txt	= ($row[3] == "0")?("Priv."):("Pub.");
					$state_img 	= (($row[3] == 0) ? ("<img src=\"img/icons/disabled.gif\" />") : ("<img src=\"img/icons/enabled.gif\" />"));
					
					$varUri		= ($row[3] == "0")?("newsCatPublish"):("newsCatPrivate");
					$linkTitle	= ($row[3] == "0")?("Display category"):("Hide category");
					//Alternet les css
					$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));				
					
					$toRet .="<tr class=\"$currentCls\">
								<th scope=\"row\">$num</td>
								<td>$row[1]</td>
								<td>$row[2]</td>
								<td style=\"text-align:center; background:#fff;\">
									<a title=\"".$lang_output['TABLE_TOOLTIP_UPDATE']."\" href=\"?what=newsCatDisplay&action=newsCatUpdate&$this->URI_newsCatVar=$row[0]\"><img src=\"img/icons/edit.gif\" /></a>&nbsp;
									<a title=\"".$lang_output['TABLE_TOOLTIP_DELETE']."\" href=\"?what=newsCatDisplay&action=newsCatDelete&$this->URI_newsCatVar=$row[0]\" onclick=\"return confirm('If delete the category, all the stories grouped in the said category shall be automatically deleted! Do you wish to proceed anyway?')\"><img src=\"img/icons/delete.gif\" /></a>&nbsp;
								</td>
									
							  </tr>";
				}
				$toRet .="</table>";
				
			}
			else{
				$toRet	= "There is no category";
			}
			return $toRet;
		}
		
		/**
		 * @param int $nombre
		 * @return {HTML table of authors for admini}
		 * 
		 * @desc load news author
		**/
		function admin_load_news_authors($nombre='10', $actionView='0'){
			global $lang_output, $mod_lang_output, $thewu32_cLink;
			
			$limite = $_REQUEST[limite];
			
			//Recherche du nom de la page
			$path_parts = pathinfo($PHP_SELF);
			$page = $path_parts["basename"].'?what=news_authorsDisplay';
			
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl($this->tbl_newsAuth, $this->fld_newsAuthId);
			
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
				if(!$veriflimite) $limite = 0;
				
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
				
			$query 	= "SELECT * FROM $this->tbl_newsAuth ORDER BY $this->fld_newsAuthLastName LIMIT ".$limite.",".$nombre;
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news authors info!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$num	= 0;
				$toRet 	= $nav_menu;
				if($actionView == '1')
					$action_th	=	"<th colspan=\"2\">".$lang_output['TABLE_HEADER_ACTION']."</th>";
				
				$toRet 	.= "<table class=\"table table-bordered\">
							<tr>
								<th>&num;</th>
								<th>".$lang_output['TABLE_HEADER_LAST-NAME']."</th>
								<th>".$lang_output['TABLE_HEADER_FIRST-NAME']."</th>
								<th>".$mod_lang_output['TABLE_HEADER_AUTHOR_GROUP']."</th>
								$action_th
							</tr>";
				while($row = mysqli_fetch_array($result)){
					$num++;
					//Obtenir les libelles des categories
					$news_authGroup	= $this->get_news_author_cat_by_author_id($row[0]);
					$news_authFirst	= ucwords($this->get_news_author_by_id($this->fld_newsAuthFirstName, $row[0]));
					$news_authLast	= strtoupper($this->get_news_author_by_id($this->fld_newsAuthLastName, $row[0]));
					
					//Alternet les css
					$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
					
					if($actionView == '1')
						$action_td 		= 	"<td class=\"table-action\">
												<a title=\"Update the author info\" href=\"?what=news_authorDisplay&action=news_authorUpdate&$this->URI_newsAuthVar=$row[0]\"><img src=\"img/icons/edit.gif\" /></a>
												<a title=\"Delete the author\" href=\"?what=news_authorDisplay&action=news_authorDelete&$this->URI_newsAuthVar=$row[0]&limite=$limite\" onclick=\"return confirm('Sure you want to delete?')\"><img src=\"img/icons/delete.gif\" /></a>
											</td>";
					
					$toRet .="<tr class=\"$currentCls\">
								<th scope=\"row\" align=\"center\">$num</th>
								<td>$news_authLast</td>
								<td>$news_authFirst</td>
								<td>$news_authGroup</td>
								$action_td
							  </tr>";
				}
				$toRet .= "</table>$nav_menu";
				
			}
			else{
				$toRet	= "Aucun auteur &agrave; afficher";
			}
			return $toRet;
		}
		
		/**
		 * @param int $nombre
		 * @return {HTML table of news authors groups for admini}
		 * 
		 * @desc load news author
		**/
		function admin_load_news_authors_cat($nombre='10'){
			global $mod_lang_output, $thewu32_cLink;
			
			$limite = $_REQUEST[limite];
			
			//Recherche du nom de la page
			$path_parts = pathinfo($PHP_SELF);
			$page = $path_parts["basename"].'?what=news_authorGroupDisplay';
			
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl($this->tbl_newsAuthCat, $this->fld_newsAuthCatId);
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
				if(!$veriflimite) $limite = 0;
				
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
				
			$query 	= "SELECT * FROM $this->tbl_newsAuthCat ORDER BY $this->fld_newsAuthCatLib LIMIT ".$limite.",".$nombre;
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news authors categories info!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$num	= 0;
				$toRet 	= $nav_menu;
				$toRet 	.= "<table class=\"table table-bordered\">
							<tr>
								<th>&num;</th>
								<th>".$mod_lang_output['TABLE_HEADER_AUTHOR_GROUP']."</th>
								<th colspan=\"2\">".$mod_lang_output['TABLE_HEADER_ACTION']."</th>
							</tr>";
				while($row = mysqli_fetch_array($result)){
					$num++;

					//Alternet les css
					$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
					
					$toRet .="<tr class=\"$currentCls\">
								<th scope=\"row\">$num</th>
								<td>$row[1]</td>
								<td class=\"table-action\">
									<a title=\"Update the author group info\" href=\"?what=news_authorCatDisplay&action=news_authorCatUpdate&$this->URI_newsAuthCatVar=$row[0]\"><img src=\"img/icons/edit.gif\" /></a>
									<a title=\"Delete the author group \" href=\"?what=news_authorCatDisplay&action=news_authorCatDelete&$this->URI_newsAuthCatVar=$row[0]&limite=$limite\" onclick=\"return confirm('Sure you want to delete?')\"><img src=\"img/icons/delete.gif\" /></a>
								</td>
							  </tr>";
				}
				$toRet .= "</table>$nav_menu";
				
			}
			else{
				$toRet	= "Aucun auteur &agrave; afficher";
			}
			return $toRet;
		}
		
		function admin_load_news_comment($nombre='50', $limit='0'){
		    global $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
			
			//Recherche du nom de la page
			$path_parts = pathinfo($PHP_SELF);
			$page = $path_parts["basename"];
			
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl($this->tbl_newsComment, $this->fld_newsCommentId);
			
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
				if(!$veriflimite) $limite = 0;
				
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
				
			$query 	= "SELECT * FROM $this->tbl_newsComment ORDER BY $this->fld_newsCommentId DESC LIMIT ".$limite.",".$nombre;
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news comment!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$num	= 0;
				$toRet 	= $nav_menu;
				$toRet 	.= "<table class=\"ADM_table\">
							<tr>
								<th>N&ordm;</th>
								<th>Titre</th>
								<th>Date</th>
								<th>Auteur</th>
								<th>Email</th>
								<th>R&eacute;action</th>
								<th colspan=\"2\">Actions</th>
							</tr>";
				while($row = mysqli_fetch_array($result)){
					$num++;
					//alterner les liens public / prive
					$state_txt	= ($row[6] == "0")?("Priv."):("Pub.");
					$state_img 	= (($row[6] == 0) ? ("<img src=\"img/icons/disabled.gif\" />") : ("<img src=\"img/icons/enabled.gif\" />"));
					$varUri		= ($row[6] == "0")?("news_commentPublish"):("news_commentPrivate");
					$linkTitle	= ($row[6] == "0")?("Publier la r&eacute;action"):("Masquer la r&eacute;action");
					//Convertir la date
					$date		= $this->datetime_fr3($row[2]);
					//Alternet les css
					$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
					//Obtenir le titre de l'article commente
					$tabComment	= $this->get_news_comment($row[0]);
					$title		= $this->get_news_by_id("news_title", $tabComment[NID]);
					
					$toRet .="<tr class=\"$currentCls\">
								<td align=\"center\">$num</td>
								<td>".$title."</td>
								<td>$date</td>
								<td>$row[3]</td>
								<td>$row[4]</td>
								<td>".utf8_encode(stripslashes($row[5]))."</td>
								<td align=\"center\">
									<a title=\"Supprimer la r&eacute;action\" href=\"?what=news_commentDisplay&action=news_commentDelete&$this->URI_newsCommentVar=$row[0]\" onclick=\"return confirm('La suppression de cette r&eacute;action sera irr&eacute;vocable!')\"><img src=\"img/icons/delete.gif\" /></a>
								</td>
								<td align=\"center\">
									<a title=\"$linkTitle\" href=\"?what=news_commentDisplay&action=$varUri&$this->URI_newsCommentVar=$row[0]\">$state_img</a>
								</td>
							  </tr>";
				}
				$toRet .= "</table>$nav_menu";
				
			}
			else{
				$toRet	= "Aucune news &agrave; afficher";
			}
			return $toRet;
		}
		
		/**
		 * Afficher les rubriques dans un combobox, toutes les rubriques (Utile pour l'espace d'admin).
		 *
		 * @param $FORM_var 	: La variable de formulaire, pour fixer la valeur choisie, en cas d'erreur dans le formulaire qui entrainerait le rechargement de la page
		 * @param $CSS_class 	: La classe CSS a utiliser pour enjoliver la presentation
		*/
		function admin_load_cmb_cat($FORM_var="", $CSS_class=""){
		    global $thewu32_cLink;
			$query 	= "SELECT * FROM $this->tbl_newsCat ORDER BY news_cat_lib";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news categories.<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = "";
				//if($FORM_var	== )
				while($row = mysqli_fetch_array($result)){
					$selected = ($FORM_var == $row[0])?("SELECTED"):("");
					$toRet .= "<option value=\"$row[0]\"$selected>$row[1]</option>";
				}
			}
			else{
				$toRet = "<option>Aucune rubrique &agrave; afficher</option>";
			}
			return $toRet;
		}
		
		//Retourner les donn&eacute;es d'une table de news au format xml
		function load_validXMLNews($order="DESC"){
		    global $thewu32_cLink;
			$query = "SELECT $this->fld_newsId, $this->fld_newsCatId, news_title, news_header, naut_id, $this->fld_newsDatePub, news_imgfile, news_content FROM $this->tbl_news ORDER BY $this->fld_newsId $order";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger les news pour un XML output!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$newsHeader = $this->insert_xmlIntro().$this->insert_xmlComment("G&eacute;n&eacute;r&eacute; par theWu32").'<news>';
				$newsItem = "";
				while($row = mysqli_fetch_row($result)){
					$descr = utf8_decode($this->chapo(strip_tags($row[3]), 150));
					$newsCategory		= $this->get_news_cat_by_id($this->fld_newsCatLib, $row[1]);
					$news_authorFirst	= ucwords($this->get_news_author_by_id($this->fld_newsAuthFirstName, $row[4]));
					$news_authorLast	= strtoupper($this->get_news_author_by_id($this->fld_newsAuthLastName, $row[4]));
					$news_authorGroup	= ucwords($this->get_news_author_cat_by_author_id($row[4]));/**/
					//Prevoir l'image
					$newsItem .= '<newsItem id="'.$row[0].'">
								  <category>'.$newsCategory.'</category>
								  <title><![CDATA['.utf8_decode($row[2]).']]></title>
								  <datepub>'.$row[5].'</datepub>
								  <author><![CDATA['.$news_authorFirst.' '.$news_authorLast.', '.$news_authorGroup.']]></author>
								  <description><![CDATA['.$descr.']]></description>
								  </newsItem>';
				}
				$newsFooter = '</news>';
				$toRet = $newsHeader.$newsItem.$newsFooter;
			}
			else{
				$toRet = false;
			}
			return $toRet;		 
		}
		
		//Retourner les donn&eacute;es d'une table de news au format xml
		function set_xml_ds_news($pageDest, $order="DESC"){
		    global $thewu32_cLink;
			$query = "SELECT $this->fld_newsId, $this->fld_newsCatId, news_title, news_header, naut_id, $this->fld_newsDatePub, news_imgfile, news_content, lang_id, news_thumb, news_tags FROM $this->tbl_news WHERE display='1' ORDER BY $this->fld_newsId $order";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger les news pour un XML output!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$newsHeader = $this->insert_xmlIntro().$this->insert_xmlComment("G&eacute;n&eacute;r&eacute; par theWu32").'<news>';
				$newsItem = "";
				while($row = mysqli_fetch_row($result)){
					$descr = utf8_decode($this->chapo(strip_tags($row[3]), 300));
					$newsCategory		= 	$this->get_news_cat_by_id($this->fld_newsCatLib, $row[1]);
					$news_authorFirst	= 	ucwords($this->get_news_author_by_id($this->fld_newsAuthFirstName, $row[4]));
					$news_authorLast	= 	strtoupper($this->get_news_author_by_id($this->fld_newsAuthLastName, $row[4]));
					$news_authorGroup	= 	ucwords($this->get_news_author_cat_by_author_id($row[4]));/**/
					$newsUrl			=	$pageDest.$this->URI_separator."detail".$this->URI_separator.$row[0].".html";
					//Prevoir l'image
					$newsItem .= '<item id="'.$row[0].'">
								  <cat id="'.$row[1].'"><![CDATA['.utf8_decode($newsCategory).']]></cat>
								  <title><![CDATA['.utf8_decode($row[2]).']]></title>
								  <date><![CDATA['.$this->datetime_fr($row[5]).']]></date>
								  <author><![CDATA['.$news_authorFirst.' '.$news_authorLast.', '.$news_authorGroup.']]></author>
								  <descr><![CDATA['.$descr.']]></descr>
								  <story><![CDATA['.$this->img_pathRestaure($row[7]).']]></story>
								  <img><![CDATA['.$row[6].']]></img>
								  <thumb><![CDATA['.$row[9].']]></thumb>
								  <tags><![CDATA['.$row[10].']]></tags>
								  <url>'.$newsUrl.'</url>
								  <lang><![CDATA['.$row[8].']]></lang>
								  </item>';
				}
				$newsFooter = '</news>';
				$toRet = $newsHeader.$newsItem.$newsFooter;
			}
			else{
				$toRet = false;
			}
			return $toRet;
		}
		
		function create_ds_news($pageDest){
			return $this->create_file($this->news_dsPath, $this->set_xml_ds_news($pageDest));
		}
		
		function get_news_author_by_id($new_newsAuthorFld, $new_newsAuthorId){
			return $this->get_field_by_id($this->tbl_newsAuth, $this->fld_newsAuthId, $new_newsAuthorFld, $new_newsAuthorId);
		}
		
		function get_news_author_cat_by_id($new_newsAuthorCatId){
			return $this->get_field_by_id($this->tbl_newsAuthCat, $this->fld_newsAuthCatId, $this->fld_newsAuthCatLib, $new_newsAuthorCatId);	
		}
		
		/**
		 * @param int $new_newsAuthorId
		 * @return string author group name
		 *  
		 * @desc Get the author group knowing the author id*/
		function get_news_author_cat_by_author_id($new_newsAuthorId){
			$news_authorCatId	= $this->get_news_author_by_id($this->fld_newsAuthCatId, $new_newsAuthorId);
			return $this->get_news_author_cat_by_id($news_authorCatId);
		}
		
		function load_headline($nombre='1', $lang="FR", $link="news_detail.php", $linkTxt="En savoir plus", $width= '180'){
		    global $thewu32_cLink;
		 	$query 		= 	"SELECT * FROM $this->tbl_news WHERE display='1' and lang_id='$lang' ORDER BY $this->fld_newsDatePub DESC limit 0, $nombre";
		  	$result		=	mysqli_query($thewu32_cLink, $query) or die("Unable to load headlines!.<br />".mysqli_connect_error());
		  	if($total	= 	mysqli_num_rows($result)){
		  		while($row = mysqli_fetch_row($result)){
		  			//if head img is define or not...
		  			
		  			$headImg = (($row[5] != "") ? ("<div class=\"img_box_atLeft\" style=\"border: 0;\"><a href=\"$link&$this->URI_newsVar=$row[0]\" title=\"$row[2]\"><img style=\"width:".$width."px;\" class=\"head border\" src=\"modules/news/img/heads/$row[5]\" /></a></div>") : (""));
		  			$toRet .= "<h2>$row[2]</h2>
								$headImg
								<p style=\"font-weight: bold;\">$row[3]</p>
								<p>
									<span style=\"font-weight: bold;\">".$this->datetime_to_datefr2($row[1])."</span> - ".$this->chapo($row[4], 200)."&nbsp;</br /></br />
									<a href=\"$link"."-"."$row[0].html\">$linkTxt&nbsp;&raquo;</a>
								</p>		  							
								<div class=\"clrBoth\"></div>";
		  		}
		  	}
		  	else{
		  		$toRet = "<p>Aucun &eacute;l&eacute;ment &agrave; afficher</p><div class=\"clrBoth\"></div>";	
		  	}
		  	return $toRet."<div class=\"clrBoth\"></div>";
		}
		
		/*function load_news_home($start='1', $nombre='2', $newsLang='FR', $newsMore='Lire&nbsp;la&nbsp;suite', $newsCls="newsHome"){
		 	$query 		= 	"SELECT * FROM $this->tbl_news WHERE display='1' AND lang_id='$newsLang' ORDER BY $this->fld_newsDatePub DESC limit $start, $nombre";
		  	$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
		  	if($total	= 	mysqli_num_rows($result)){
		  		while($row = mysqli_fetch_row($result)){
		  			$toRet .= "<div class=\"$newsCls\">
									<div class=\"title\" style=\"font-family:georgia; font-size:135%;\">$row[2]</div>
									<div class=\"descr\">
										<a href=\"$this->mod_linkDetail&$this->URI_newsVar=$row[0]\" title=\"$row[2]\">
											<img align=\"left\" src=\"modules/news/img/thumbs/$row[7]\" alt=\"$row[2]\" title=\"$row[2]\" style=\"margin-right:5px; width: 60px; height: 60px; border:#ccc solid 1px;\" />
										</a>
										".$this->chapo($row[3], 140)."<br /><strong>".$this->datetime_fr3($row[1])."</strong>  
										<!-- <a title=\"$row[2]\" href=\"$this->mod_linkDetail&$this->URI_newsVar=$row[0]\">
											<br />$newsMore&nbsp;&raquo; -->
											<a title=\"$row[2]\" href=\"$this->mod_linkDetail"."-"."$row[0].html\">
											<br />$newsMore&nbsp;&raquo;
										</a>
									</div>
									<div class=\"clrBoth\"></div>
								</div>";
		  		}
		  	}
		  	else{
		  		$toRet = "<p>Aucun &eacute;l&eacute;ment &agrave; afficher</p>";	
		  	}
		  	return $toRet."<div class=\"clrBoth\"></div>";
		} */
		
		/*function load_news_home($pageDest, $start='1', $nombre='2', $newsLang='FR', $newsMore='Lire&nbsp;la&nbsp;suite', $newsCls="newsHome"){
			$query 		= 	"SELECT * FROM $this->tbl_news WHERE display='1' AND lang_id='$newsLang' ORDER BY $this->fld_newsDatePub DESC limit $start, $nombre";
			$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
			if($total	= 	mysqli_num_rows($result)){
				while($row = mysqli_fetch_row($result)){
					$toRet .= "<div class=\"$newsCls\">
					<div class=\"title\" style=\"font-family:georgia; font-size:135%;\">$row[2]</div>
					<div class=\"descr\">
					<a href=\"$pageDest,".$row[0].",newsdetail.html\" title=\"$row[2]\">
					<img align=\"left\" src=\"modules/news/img/thumbs/$row[7]\" alt=\"$row[2]\" title=\"$row[2]\" style=\"margin-right:5px; width: 60px; height: 60px; border:#ccc solid 1px;\" />
					</a><strong>".$this->datetime_fr3($row[1])."</strong><br />
					".$this->chapo($row[3], 70)."
					<a title=\"$row[2]\" href=\"$pageDest,".$row[0].",newsdetail.html\">
					&nbsp;&nbsp;&raquo;$newsMore
					<!-- <a title=\"$row[2]\" href=\"$this->mod_linkDetail"."-"."$row[0].html\">
					<br />$newsMore&nbsp;&raquo; -->
					</a>
					</div>
					<div class=\"clrBoth\"></div>
					</div>";
				}
				}
				else{
				$toRet = "<p>Aucun &eacute;l&eacute;ment &agrave; afficher</p>";
		}
		return $toRet."<div class=\"clrBoth\"></div>";
		}
		*/
		function load_news_home($pageDest, $start='1', $nombre='2', $newsLang='FR', $newsMore='Lire&nbsp;la&nbsp;suite', $newsCls="newsHome", $cssAlt="atLeft"){
		    global $thewu32_cLink;
		 	$query 		= 	"SELECT * FROM $this->tbl_news WHERE display='1' AND (lang_id='$newsLang' OR lang_id='XX') ORDER BY $this->fld_newsDatePub DESC limit $start, $nombre";
		  	$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
		  	if($total	= 	mysqli_num_rows($result)){
		  		$i	= 0;
		  		while($row = mysqli_fetch_row($result)){
		  			$i++;
		  			$cssAlt = ((($i % 2) != 0) ? ('') : (' '.$cssAlt)); //$css particuli�re
		  			$toRet .= "<div class=\"$newsCls$cssAlt\">
		  							<div class=\"front_thumbs\">
		  								<img class=\"borderedbox\" style=\"width:60px;\" align=\"left\" src=\"modules/news/img/thumbs/thumb80_".$row[0].".jpg"."\" alt=\"$row[2]\" title=\"$row[2]\" />
		  								$row[2]<br />
		  								<!-- <span class=\"front_link;\"><a title=\"$row[2]\" href=\"$this->mod_linkDetail&$this->URI_newsVar=$row[0]\">$newsMore&nbsp;&raquo;</a></span> -->
										<span class=\"front_link;\"><a title=\"$row[2]\" href=\"".$this->set_mod_detail_uri($pageDest, $row[0])."\">$newsMore&nbsp;&raquo;</a></span>
										<div class=\"clrBoth\"></div>
									</div>
								</div>";
		  		}
		  	}
		  	else{
		  		$toRet = "<p>Aucun &eacute;l&eacute;ment &agrave; afficher</p>";	
		  	}
		  	return $toRet."<div class=\"clearBoth\"></div>";
		}
		
		function dgt_load_news_home($pageDest, $start='1', $nombre='2', $newsLang='FR', $newsMore='Lire&nbsp;la&nbsp;suite', $newsCls="newsHome", $cssAlt="atLeft"){
		    global $thewu32_cLink;
		    $query 		= 	"SELECT * FROM $this->tbl_news WHERE display='1' AND (lang_id='$newsLang' OR lang_id='XX') ORDER BY $this->fld_newsDatePub DESC limit $start, $nombre";
		    $result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
		    if($total	= 	mysqli_num_rows($result)){
		        $i	= 0;
		        $toRet    =   "<div class=\"$newsCls\">";
		        while($row = mysqli_fetch_row($result)){
		            $i++;
		            $cssAlt = ((($i % 2) != 0) ? ('') : (' '.$cssAlt)); //$css particuli�re
		            $toRet .= "<div class=\"newsHomeItem\">
		  								<img class=\"imgRounded\" style=\"width:100px; height:100px; margin:0 5px 0 0;\" align=\"left\" src=\"modules/news/img/thumbs/thumb80_".$row[0].".jpg"."\" alt=\"$row[2]\" title=\"$row[2]\" />
		  								<div class=\"title\">$row[2]</div><div class=\"descr\">".$this->chapo($row[3], 100)."</div>
										<p class=\"front_link;\"><a title=\"$row[2]\" href=\"".$this->set_mod_detail_uri($pageDest, $row[0])."\">$newsMore&nbsp;&raquo;</a></p>
										<div class=\"clrBoth\"></div>
									</div>";
		        }
		    }
		    else{
		        $toRet = "<p>Aucun &eacute;l&eacute;ment &agrave; afficher</p>";
		    }
		    return $toRet."<div class=\"clrBoth\"></div></div>";
		}
		
		function load_news_box($start='1', $nombre='2', $newsLang='FR', $newsCls="newsBox"){
		    global $thewu32_cLink;
		 	$query 		= 	"SELECT * FROM $this->tbl_news WHERE display='1' AND lang_id='$newsLang' ORDER BY $this->fld_newsDatePub DESC limit $start, $nombre";
		  	$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
		  	if($total	= 	mysqli_num_rows($result)){
		  		while($row = mysqli_fetch_row($result)){
		  			$toRet .= "<div class=\"$newsCls\">
									<div class=\"descr\">
										<a style=\"font-size:70%;\" href=\"$this->mod_linkDetail?$this->URI_newsVar=$row[0]\" title=\"$row[2]\">
											<img src=\"img/img_articles/thumbs/$row[7]\" alt=\"$row[2]\" title=\"$row[2]\" border=\"0\" align=\"left\" style=\"width: 50px; height: 50px;\" />
											$row[3]											
										</a>
									</div>
									<div class=\"clrBoth\"></div>
								</div>";
		  		}
		  	}
		  	else{
		  		$toRet = "<p>Aucun &eacute;l&eacute;ment &agrave; afficher</p>";	
		  	}
		  	return $toRet."<div class=\"clrBoth\"></div>";
		}
		
		function _sprySliding_load_news_home($newslink, $nombre='4', $lang='FR', $limit='0'){
			global $lang_output, $thewu32_cLink;		
		 	$query 		= 	"SELECT * FROM $this->tbl_news WHERE display='1' ORDER BY $this->fld_newsDatePub DESC limit $limit, $nombre";
		  	$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
		  	if($total	= 	mysqli_num_rows($result)){
		  		$toRet = "
							<div id=\"ticker\" class=\"SlidingPanels\">
								<div class=\"SlidingPanelsContentGroup\">
						 ";
		  		
		  		$nb		= 0;
		  		$item 	= 0;
		  		$pager	= "";
		  		while($row = mysqli_fetch_row($result)){
		  			$id		= $row[0];
		  			$img_id	= $row[9];
		  			
					$nb		+= 1;
					$item	+= 1;
					$nextCount	= ($item + 1);
		  			$prevCount 	= ($item - 1);
		  			
					$pager .= "<div class=\"article_pages\"><a href=\"#\" onclick=\"sp.showPanel('item$item'); return false;\">$item</a></div>";
		  			$toRet .= "<div id=\"item$item\" class=\"sp_article_element_home SlidingPanelsContent\">
		  						<img class=\"head\" src=\"modules/news/img/heads/$row[5]\" />
							  	<h1>".$this->chapo($row[2], 44, '[..]')."</h1>
							  	<p>".$this->chapo($row[3], 166, '...')."<br />
							  	<a href=\"".$this->set_mod_detail_uri($newslink, $row[0])."\" title=\"$row[2]\">&raquo; ".$lang_output["NEWS_MORE"]."</a></p>
							  	<div class=\"clrBoth\"></div>
		  					   </div>";
		  					   
		  		}
		  	}
		  	else{
		  		$toRet = "<p>Aucun &eacute;l&eacute;ment &agrave; afficher</p>";	
		  	}
		  	return $toRet."</div></div><div class=\"clrBoth\"></div><div>$pager</div><div class=\"clrBoth\"></div>
		  	<script type=\"text/javascript\">
				var sp = new Spry.Widget.SlidingPanels('ticker');
		   </script>";
		}
		
		function _flexSliding_load_news_home($newslink, $nombre='4', $lang='FR', $limit='0'){
			global $mod_lang_output, $thewu32_appExt, $thewu32_cLink;
			$query 		= 	"SELECT * FROM $this->tbl_news WHERE display='1' ORDER BY $this->fld_newsDatePub DESC limit $limit, $nombre";
			$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
			if($total	= 	mysqli_num_rows($result)){
				
				$slide 			= 0;
				$slide_menuList	=	"";
				
				$toRet = "<div class=\"flexslider\">
								<ul class=\"slides\">
						 ";
				
				while($row = mysqli_fetch_row($result)){
					$id		= $row[0];
					$img_id	= $row[9];
					
					$slide++;
					$slide_menuList	.= "<li><a class=\"\">$slide</a></li>";
					
										
					$toRet .= 	"<li><img class=\"googleMap\" src=\"modules/news/img/heads/$row[5]\" />
								<div class=\"newsHeader\"><h4>$row[2]</h4>
									<h5>".$this->datetime_to_datefr2($row[1])."</h5>
								</div>
								<p class=\"nextText\">$row[3]&nbsp;<a href=\"$newslink-detail-$row[0]".$thewu32_appExt."\" title=\"$row[2]\">&raquo; ".$mod_lang_output["NEWS_MORE"]."</a></p></li>";
				}
			}
			else{
				$toRet = "<p>".$mod_lang_output['LABEL_NO_ELEMENT_DISPLAY']."</p>";
			}
			return $toRet."</ul>
							<ol class=\"flex-control-nav flex-control-paging\">$slide_menuList</ol>
							<ul class=\"flex-direction-nav\"><li><a class=\"flex-prev\" href=\"#\">Previous</a></li><li><a class=\"flex-next\" href=\"#\">Next</a></li></ul>
							</div>";
		}
		
		function _jollySliding_load_news_home($newslink, $nombre='4', $lang='FR', $limit='0'){
			global $lang_output, $thewu32_cLink;
			$query 		= 	"SELECT * FROM $this->tbl_news WHERE display='1' AND ($this->fld_newsLangId = '$lang' OR $this->fld_newsLangId = 'XX')  ORDER BY $this->fld_newsDatePub DESC limit $limit, $nombre";
			$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
			if($total	= 	mysqli_num_rows($result)){
				$toRet = "";
		
				$nb		= 0;
				$item 	= 0;
				$pager	= "";
				while($row = mysqli_fetch_row($result)){
					$id		= $row[0];
					$img_id	= $row[9];
		
					$nb		+= 1;
					$item	+= 1;
					$nextCount	= ($item + 1);
					$prevCount 	= ($item - 1);
		
					//$pager .= "<div class=\"article_pages\"><a href=\"#\" onclick=\"sp.showPanel('item$item'); return false;\">$item</a></div>";
					$toRet .= "<div class=\"blog-carousel\">
								<div class=\"entry\">
								<img src=\"modules/news/img/heads/$row[5]\" alt=\"\" class=\"img-responsive\">
								<div class=\"magnifier\">
								<div class=\"buttons\">
								<a class=\"st\" rel=\"#\"><i class=\"fa fa-link\"></i></a>
								</div><!-- end buttons -->
								</div><!-- end magnifier -->
								<div class=\"post-type\">
								<i class=\"fa fa-picture-o\"></i>
								</div><!-- end pull-right -->
								</div><!-- end entry -->
								<div class=\"blog-carousel-header\">
								<h3><a title=\"$row[2]\" href=\"".$this->set_mod_detail_uri($newslink, $id)."\">$row[2]</a></h3>
								<div class=\"blog-carousel-meta\">
								<span><i class=\"fa fa-calendar\"></i>".$this->datetime_en3($row[1])."</span>
								</div><!-- end blog-carousel-meta -->
								</div><!-- end blog-carousel-header -->
								<div class=\"blog-carousel-desc\">
								<p>$row[3]</p>
								</div><!-- end blog-carousel-desc -->
								</div><!-- end blog-carousel -->
								";
		
				}
			}
			else{
				$toRet = "<p>Nothing to be displayed!</p>";
			}
					return $toRet;
		}
		
				
		function load_recent_news2($pageDest="news_detail.php", $linkAllTxt="Tous les articles", $css="recent_news", $start="0", $number=10, $lang="FR"){
			//Les articles affich&eacute;s ï¿½ la colonne gauche
			//$number = ((int)($number - 1));
		    //$query = "SELECT $this->fld_newsId, news_title, news_thumb, news_date FROM $this->tbl_news WHERE display = '1' AND lang_id = '$lang' ORDER BY $this->fld_newsDatePub DESC LIMIT $start, $number";
		    global $thewu32_cLink;
			$query = "SELECT $this->fld_newsId, news_title, news_thumb, news_date FROM $this->tbl_news WHERE display = '1' ORDER BY $this->fld_newsDatePub DESC LIMIT $start, $number";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger les titres recents!!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				//$newsLink 	= "<p>&raquo;<a href=\"$linkAll\">$linkAllTxt</a></p>";
				$count		= 0;
				$newsId 	= $this->fld_newsId;
				$toRet 		= "<ul>";
				while($row = mysqli_fetch_array($result)){
					$count++;
					//Alternate row
					$cssAlter 	= ((($count % 2) == 0) ? ("newsEven") : ("newsOdd"));
					$pathOK 	= "<img style=\"margin:4px;\" width:40px;\" src=\"modules/news/img/thumbs/".$row[2]."\" align=\"left\" />";
					$pathNOT	= "<img style=\"margin:4px;\" width:40px;\" src=\"modules/news/img/thumbs/noimg.gif\" align=\"left\" />";
					$pixUrl 	= (($row[2] != "") ? ($pathOK) : ($pathNOT));
					
					$news_detail_link	=	$pageDest.$this->URI_separator."detail".$this->URI_separator."$row[$newsId]".".html";
					
					$toRet .= "<li class=\"$cssAlter\"> 
									<a style=\"color:#285f73; font-size:105%;\" href=\"$news_detail_link\">$pixUrl"."<span style=\"color:#9b5e00; font-weight:bold;\" class=\"recent_news_date\">".$this->datetime_to_datefr($row["news_date"])."</span> - ".$row["news_title"]."</a>
							   		<div style=\"clear:both;\"></div>
							   	</li>
							   ";
				}
			}
			else{
				$toRet = "<p>Aucun article &agrave; afficher!!</p><div class=\"clrBoth\"></div>";
			}
			return $toRet."</ul>";
		}
		
		function load_recent_news($linkAll="news.php", $pageDest="news_detail.php", $linkAllTxt="Tous les articles", $css="recent_news", $start="0", $number=10, $lang="FR"){
			//Les articles affich&eacute;s ï¿½ la colonne gauche
			//$number = ((int)($number - 1));
		    //$query = "SELECT $this->fld_newsId, news_title, news_thumb, news_date FROM $this->tbl_news WHERE display = '1' AND lang_id = '$lang' ORDER BY $this->fld_newsDatePub DESC LIMIT $start, $number";
		    global $thewu32_cLink;
			$query = "SELECT $this->fld_newsId, news_title, news_thumb, news_date FROM $this->tbl_news WHERE display = '1' ORDER BY $this->fld_newsDatePub DESC LIMIT $start, $number";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger les titres recents!!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				//$newsLink 	= "<p>&raquo;<a href=\"$linkAll\">$linkAllTxt</a></p>";
				$count		= 0;
				$newsId 	= $this->fld_newsId;
				$toRet 		= "<div class=\"$css\" style=\"float:left;\">";
				while($row = mysqli_fetch_array($result)){
					$count++;
					//Alternate row
					$cssAlter 	= ((($count % 2) == 0) ? ("newsEven") : ("newsOdd"));
					$pathOK 	= "<img style=\"width:40px;\" src=\"modules/news/img/thumbs/".$row[2]."\" align=\"left\" />";
					$pathNOT	= "<img style=\"width:40px;\" src=\"modules/news/img/thumbs/noimg.gif\" align=\"left\" />";
					$pixUrl 	= (($row[2] != "") ? ($pathOK) : ($pathNOT));
					$toRet .= "<div class=\"$cssAlter\" style=\"float:left; width:100%;\">
					<!-- <a style=\"color:#000; font-size:12px;\" href=\"$pageDest&$this->URI_newsVar=".$row[$newsId]."\">$pixUrl"."<strong>".$this->datetime_to_datefr($row["news_date"])."</strong> - ".$row["news_title"]."</a> -->
					<a href=\"$pageDest"."-".$row[$newsId].".html\">$pixUrl"."<span class=\"recent_news_date\">".$this->datetime_to_datefr($row["news_date"])."</span> - ".$row["news_title"]."</a>
							   		<div class=\"clrBoth\"></div>
							   	</div>
							   	<div class=\"clrBoth\"></div>
							   ";
				}
			}
			else{
				$toRet = "<p>Aucun article &agrave; afficher!!</p><div class=\"clrBoth\"></div>";
			}
			return $toRet."</div><div class=\"clrBoth\"></div>";
		}
		
		
		function load_last_news($number=5, $pageDest='news_read.php', $lang='FR', $css="recent_news", $start=0){
		    global $thewu32_appExt, $thewu32_cLink;
		    //Les titres des news les plus recentes ds un box
		    //$number = ((int)($number - 1));
		    $query = "SELECT $this->fld_newsId, news_title, news_thumb, news_date FROM $this->tbl_news WHERE display = '1' AND ($this->fld_newsLangId = '$lang' OR $this->fld_newsLangId = 'XX') ORDER BY $this->fld_newsDatePub DESC LIMIT $start, $number";
		    $result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger les titres recents!!<br />".mysqli_connect_error());
		    if($total = mysqli_num_rows($result)){
		        //$newsLink 	= "<p>&raquo;<a href=\"$linkAll\">$linkAllTxt</a></p>";
		        $count		= 0;
		        $newsId 	= $this->fld_newsId;
		        $toRet 		= "<div class=\"$css\" style=\"float:left;\">";
		        while($row = mysqli_fetch_array($result)){
		            $count++;
		            //Alternate row
		            $cssAlter 	= ((($count % 2) == 0) ? ("newsEven") : ("newsOdd"));
		            $pathOK 	= "<img style=\"width:40px;\" src=\"modules/news/img/thumbs/".$row[2]."\" align=\"left\" />";
		            $pathNOT	= "<img style=\"width:40px;\" src=\"modules/news/img/thumbs/noimg.gif\" align=\"left\" />";
		            $pixUrl 	= (($row[2] != "") ? ($pathOK) : ($pathNOT));
		            $toRet .= "<div class=\"$cssAlter\" style=\"float:left; width:100%;\">
					               <a href=\"".$this->set_mod_detail_uri($pageDest, $row[0])."\">$pixUrl"."<div class=\"recent_news_date\">".$this->show_date_by_lang($this->extract_date_from_datetime($row["news_date"]), $lang)."</div><div class=\"recent_news_title\">".$row["news_title"]."</div></a>
							   	   <div class=\"clrBoth\"></div>
							   	</div>
							   	<div class=\"clrBoth\"></div>";
		        }
		    }
		    else{
		        $toRet = "<p>Empty</p><div class=\"clrBoth\"></div>";
		    }
		    return $toRet."</div><div class=\"clrBoth\"></div>";
		}
		
		function load_footer_posts($pageDest="news_detail.php", $css="footer_post", $start="0", $number=6, $lang="EN"){
			//Les articles affich&eacute;s ï¿½ la colonne gauche
			//$number = ((int)($number - 1));
			//$query = "SELECT $this->fld_newsId, news_title, news_thumb, news_date FROM $this->tbl_news WHERE display = '1' AND lang_id = '$lang' ORDER BY $this->fld_newsDatePub DESC LIMIT $start, $number";
		    global $mod_lang_output, $thewu32_cLink;
		    $query = "SELECT $this->fld_newsId, news_title, news_thumb, news_date FROM $this->tbl_news WHERE display = '1'  AND ($this->fld_newsLangId = '$lang' OR $this->fld_newsLangId = 'XX') ORDER BY $this->fld_newsDatePub DESC LIMIT $start, $number";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger les titres recents!!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				//$newsLink 	= "<p>&raquo;<a href=\"$linkAll\">$linkAllTxt</a></p>";
				$count		= 0;
				$newsId 	= $this->fld_newsId;
				$toRet 		= "<ul class=\"$css\">";
				while($row = mysqli_fetch_array($result)){
					$count++;
					//Alternate row
					$cssAlter 	= ((($count % 2) == 0) ? ("newsEven") : ("newsOdd"));
					$pathOK 	= "<img  class=\"img-rounded\" src=\"modules/news/img/thumbs/".$row[2]."\" alt=\"".$row['news_title']."\" />";
					$pathNOT	= "<img  class=\"img-rounded\" src=\"modules/news/img/thumbs/noimg.gif\" />";
					$pixUrl 	= (($row[2] != "") ? ($pathOK) : ($pathNOT));
					$toRet .= "<li><a title=\"".$row['news_title']."\" href=\"".$this->set_mod_detail_uri($pageDest, $row[0])."\">$pixUrl</a></li>";
				}
			}
			else{
				$toRet = "<li>".$mod_lang_output['NO_NEWS']."</li>";
			}
			return $toRet."</ul>";
		}
		
		function load_recent_title_home($start="0", $number=5, $lang="FR", $pageDest="news_detail.php", $linkAll="news.php", $linkAllTxt="Tous les articles"){
			//Les articles affich&eacute;s ï¿½ la colonne gauche
			//$number = ((int)($number - 1));
		    global $mod_lang_output, $thewu32_cLink;
		    $query = "SELECT $this->fld_newsId, $this->fld_newsCatId, news_title FROM $this->tbl_news WHERE display = '1' AND lang_id ='$lang' ORDER BY $this->fld_newsDatePub DESC LIMIT $start, $number";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger les titres recents!!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$news_link 	= "<p>&raquo;<a href=\"$linkAll\">$linkTxt</a></p>";
				$newsId 	= $this->fld_newsId;
				$newsCatId	= $this->fld_newsCatId;
				$toRet = "<ul>";
				while($row = mysqli_fetch_array($result)){
					$newsCatLib = $this->get_field_by_id($this->tbl_newsCat, $this->fld_newsCatId, "news_cat_lib", $row[$newsCatId]);
					$toRet .= "<li>
								<span style=\"font-weight:bold; text-transform:uppercase;\">$newsCatLib :</span> <a href=\"$pageDest".$this->URI_separator.$row[$newsId].",newsdetail.html"."\">".$row["news_title"]."</a>
							   </li>";
				}
			}
			else{
			    $toRet = $mod_lang_output['NO_NEWS'];
			}
			return $toRet."</ul>".$news_link;
		}
		
		function load_news($pageDest, $nombre='25', $more="Read more", $lang="FR", $new_chapoLength='180'){
			global $mod_lang_output, $thewu32_cLink;
			
			$limite = $this->limit;
			if(!$limite) $limite = 0;
			
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl_where1_lang($this->tbl_news, $this->fld_newsId, $this->fld_newsDisplay, '1');
			
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
			
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->affichepage($nombre, $pageDest, $total);
		  			
		 	$query 		= 	"SELECT * FROM $this->tbl_news WHERE $this->fld_newsDisplay='1' AND ($this->fld_newsLangId = '$lang' OR $this->fld_newsLangId = 'XX') ORDER BY $this->fld_newsDatePub DESC LIMIT ".$limite.",".$nombre;
		  	$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
		  	if($total	= 	mysqli_num_rows($result)){
		  	    $num	=   0;
		  	    $body    =   '';
		  		//$toRet  =   $nav_menu;
		  		while($row = mysqli_fetch_row($result)){
		  			$num++;
		  			//Alternate row
		  			$cssAlt	= ((($num % 2) == 0) ? ("newsEven") : ("newsOdd"));
		  			//$last_lineBehaviour = (($num == $total) ? ('border-bottom:#ccc dashed 1px; width:100%') : (""));
		  			
		  			$link_detail     =   $this->set_mod_detail_uri($pageDest, $row[0]);	//$pageDest.$this->URI_separator."detail-"."$row[0]".".html";
		  			$news_detailCat  =   $this->get_field_by_id($this->tbl_newsCat, $this->fld_newsCatId, $this->fld_newsCatLib, $row[6]);
		  			$link_cat        =   $this->set_mod_detail_uri_cat($pageDest, $row[6]);
		  			
		  			$body .= "<div class=\"newsList borderedbox $cssAlt\">
								
								<div class=\"nlImg\">
									<a href=\"$link_detail\">
										<img src=\"".$this->mod_imgDir['heads']."$row[5]\" alt=\"$row[2]\" title=\"$row[2]\" />
									</a>
								</div>
			  					<div class=\"nlTitle\">
									<a title=\"$row[2]\" href=\"$link_detail\">$row[2]</a>
								</div>
								<div class=\"nlDescr\">
									<a style=\"color:#000;\" href=\"$link_detail\" title=\"$row[2]\">".$this->chapo($row[3], $new_chapoLength)."</a>
								</div>
                                <span class=\"nlDate\">".$this->show_datetime_by_lang($row[1], $lang)."</span><span class=\"nlCat\">[ <a href=\"$link_cat\">$news_detailCat</a> ]</span>
								<div style=\"clear:both;\"></div>
								<div class=\"more\">&raquo; <a href=\"$link_detail\" title=\"$row[2]\" class=\"lnk_black\">".$mod_lang_output['NEWS_MORE']."</a></div>
								<div class=\"clrBoth;\"></div>
								</div>";
		  		}
		  		//Affichage de la ligne du menu de navigation
		  		$toRet 	=    $nav_menu.$body.$nav_menu;		  				  		
		  	}
		  	else{
		  		$toRet = "<p>".$mod_lang_output['NO_NEWS']."</p>";	
		  	}
		  	return $toRet."<div class=\"clrBoth\"></div>";
		}
		
		function arr_load_news($pageDest, $nombre='25', $more="Read more", $lang="FR", $new_chapoLength='180'){
		    global $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
		
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl_where1($this->tbl_news, $this->fld_newsId, $this->fld_newsDisplay, '1');
		
		
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
		
			//Bloc menu de liens
			if($total > $nombre)
				$nav_menu	= $this->affichepage2($nombre, $pageDest, $total);
				
			$query 	= "SELECT * FROM $this->tbl_news WHERE display='1' AND ($this->fld_newsLangId = '$lang' OR $this->fld_newsLangId = 'XX') ORDER BY $this->fld_newsDatePub DESC LIMIT ".$limite.",".$nombre;
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$num		= 	0;
				$id 		= 	$this->fld_newsId;
				$title		=	$this->fld_newsTitle;
				$descr		=	$this->fld_newsDescr; // Same with header
				$authorId	=	$this->fld_newsAuthId;
				$catId		=	$this->fld_newsCatId;
				$date		=	$this->fld_newsDatePub;
				$img		=	$this->fld_newsImg;
				$thumb		=	$this->fld_newsThumb;
				$tags		=	$this->fld_newsTags;
				$header		=	$this->fld_newsHeader;
				$content	=	$this->fld_newsContent;
				$lang		=	$this->fld_newsLangId;
				$display	=	$this->fld_newsDisplay;
					
				$arr_toRet	=	array();
				while($row 	= 	mysqli_fetch_array($result)){
					$catTitle	=	$this->get_news_cat_by_id($this->fld_newsCatLib, $row[$catId]);
						
					$author_firstName		=	ucfirst($this->get_news_author_by_id($this->fld_newsAuthFirstName, $row[$authorId]));
					$author_lastName		=	strtoupper($this->get_news_author_by_id($this->fld_newsAuthLastName, $row[$authorId]));
					$authorCat				=	$this->get_news_author_cat_by_author_id($row[$authorId]);
					$author					=	$author_firstName.' '.$author_lastName;
						
					$pageUrl	=	$pageDest."-detail-".$row[$id].".html";
					array_push($arr_toRet, array('NEWS_ID'=>$row[$id], 'NEWS_TITLE'=>$row[$title], 'NEWS_DESCR'=>$row[$descr], 'NEWS_AUTHOR'=>$author, 'NEWS_CAT_ID'=>$row[$catId], 'NEWS_CAT_TITLE'=>$catTitle, 'NEWS_DATE'=>$row[$date], 'NEWS_THUMB'=>$row[$thumb], 'NEWS_IMG'=>$row[$img], 'NEWS_TAGS'=>$row[$tags], 'NEWS_CONTENT'=>$row[$content], 'NEWS_LANG'=>$row[$lang], 'NEWS_DISPLAY'=>$row[$display], 'NEWS_URL'=>$pageUrl));
				}
			}
			else{
				$arr_toRet	= false;
			}
			return $arr_toRet;
		
		}
		
		function arr_load_news_by_cat($pageDest, $new_newsCat="", $nombre='25', $more="Read more"){
		    global $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
		
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl_where1($this->tbl_news, $this->fld_newsId, $this->fld_newsCatId, $new_newsCat);
		
		
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
		
			//Bloc menu de liens
			if($total > $nombre)
				$nav_menu	= $this->affichepage2($nombre, $pageDest, $total);
		
			$query 	= "SELECT * FROM $this->tbl_news WHERE display='1' AND $this->fld_newsCatId = '$new_newsCat' ORDER BY $this->fld_newsDatePub DESC LIMIT ".$limite.",".$nombre;
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$num		= 	0;
				$id 		= 	$this->fld_newsId;
				$title		=	$this->fld_newsTitle;
				$descr		=	$this->fld_newsDescr; // Same with header
				$authorId	=	$this->fld_newsAuthId;
				$catId		=	$this->fld_newsCatId;
				$date		=	$this->fld_newsDatePub;
				$img		=	$this->fld_newsImg;
				$thumb		=	$this->fld_newsThumb;
				$tags		=	$this->fld_newsTags;
				$header		=	$this->fld_newsHeader;
				$content	=	$this->fld_newsContent;
				$lang		=	$this->fld_newsLangId;
				$display	=	$this->fld_newsDisplay;
					
				$arr_toRet	=	array();
				while($row 	= 	mysqli_fetch_array($result)){
					$catTitle	=	$this->get_news_cat_by_id($this->fld_newsCatLib, $row[$catId]);
		
					$author_firstName		=	ucfirst($this->get_news_author_by_id($this->fld_newsAuthFirstName, $row[$authorId]));
					$author_lastName		=	strtoupper($this->get_news_author_by_id($this->fld_newsAuthLastName, $row[$authorId]));
					$authorCat				=	$this->get_news_author_cat_by_author_id($row[$authorId]);
					$author					=	$author_firstName.' '.$author_lastName;
		
					$pageUrl	=	$pageDest."-detail-".$row[$id].".html";
					array_push($arr_toRet, array('NEWS_ID'=>$row[$id], 'NEWS_TITLE'=>$row[$title], 'NEWS_DESCR'=>$row[$descr], 'NEWS_AUTHOR'=>$author, 'NEWS_CAT_ID'=>$row[$catId], 'NEWS_CAT_TITLE'=>$catTitle, 'NEWS_DATE'=>$row[$date], 'NEWS_THUMB'=>$row[$thumb], 'NEWS_IMG'=>$row[$img], 'NEWS_TAGS'=>$row[$tags], 'NEWS_CONTENT'=>$row[$content], 'NEWS_LANG'=>$rw[$lang], 'NEWS_DISPLAY'=>$row[$display], 'NEWS_URL'=>$pageUrl));
				}
			}
			else{
				$arr_toRet	= false;
			}
			return $arr_toRet;
		
		}
		
		/* function load_news_cat($pageDest="news.php", $errMsg="", $imgIcon="", $new_newsCatLang='FR'){
		    global $thewu32_cLink;
		    
			$query 	= "SELECT * FROM $this->tbl_newsCat WHERE ($this->fld_modLang = '$new_newsCatLang' OR $this->fld_modLang = 'XX') ORDER BY $this->fld_newsCatLib";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news categories.<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = "<ul class=\"nav\">";
				while($row = mysqli_fetch_array($result)){
					//$toRet .= "<li><a href=\"$pageDest"."&".$this->URI_newsCatVar."=".$row[0]."\">$row[1]</a></li>";
				    $toRet .= "<li>".$this->toggle_icon($imgIcon)."<a href=\"".$this->set_mod_detail_uri_cat($pageDest, $row[0])."\">$row[1]</a></li>";
				}
				$toRet .="</ul>";
			}
			else{
				$toRet = $errMsg;
			}
			return $toRet;
		} */
		
		function load_news_cat($pageDest="news.php", $errMsg="", $imgIcon="", $new_newsCatLang='FR'){
		    global $thewu32_cLink;
		    
		    $query 	= "SELECT DISTINCT $this->fld_newsCatId FROM $this->tbl_news WHERE ($this->fld_modLang = '$new_newsCatLang' OR $this->fld_modLang = 'XX')";
		    $result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news categories.<br />".mysqli_connect_error());
		    if($total = mysqli_num_rows($result)){
		        $toRet = "<ul class=\"nav\">";
		        while($row = mysqli_fetch_array($result)){
		            //$toRet .= "<li><a href=\"$pageDest"."&".$this->URI_newsCatVar."=".$row[0]."\">$row[1]</a></li>";
		            $toRet .= "<li>".$this->toggle_icon($imgIcon)."<a href=\"".$this->set_mod_detail_uri_cat($pageDest, $row[0])."\">".$this->get_news_cat_by_id($this->fld_newsCatLib, $row[0])."</a></li>";
		        }
		        $toRet .="</ul>";
		    }
		    else{
		        $toRet = $errMsg;
		    }
		    return $toRet;
		}
		
		function arr_load_news_cat($pageDest='news.php', $lang){
		    global $thewu32_cLink;
			$query 	= "SELECT * FROM $this->tbl_newsCat WHERE lang = '$lang' OR lang ='XX' ORDER BY $this->fld_newsCatLib";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news categories.<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$arr_toRet = array();
				$id 		= 	$this->fld_newsCatId;
				$title		=	$this->fld_newsCatLib;
				$lang		=	$this->fld_langId;
				while($row = mysqli_fetch_array($result)){
					$totalCat	=	$this->count_in_tbl_where2($this->tbl_news, $this->fld_newsId, $this->fld_newsCatId, 'display', $row[$id], '1');
					$catUrl		=	($totalCat != 0) ? ($pageDest.'-cat@'.$row[0].'.html') : ('#');
					array_push($arr_toRet, array('NEWS_CAT_ID'=>$row[$id], 'NEWS_CAT_TITLE'=>$row[$title], 'NEWS_CAT_NB'=>$totalCat, 'NEWS_CAT_URL'=>$catUrl));
				}
			}
			else{
				$arr_toRet	=	false;
			}
			return $arr_toRet;
		}
		
		//Still to be completed!
		function arr_load_active_news_cat($pageDest='news.php', $lang){
		    global $thewu32_cLink;
			$query 	= "SELECT DISTINCT $this->fld_newsCatId FROM $this->tbl_news WHERE lang = '$lang' or lang = 'XX'";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news categories.<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$arr_toRet = array();
				$id 		= 	$this->fld_newsCatId;
				$title		=	$this->fld_newsCatLib;
				$lang		=	$this->fld_langId;
				while($row = mysqli_fetch_array($result)){
					//$toRet .= "<li><a href=\"$pageDest"."&".$this->URI_annonceCat."=".$row[0]."\">$row[1]</a></li>";
					$totalCat	=	$this->count_in_tbl_where1($this->tbl_news, $this->fld_newsId, $this->fld_newsCatId, $row[$id]);
					$catUrl		=	($totalCat != 0) ? ($pageDest.'-cat@'.$row[0].'.html') : ('#');
					array_push($arr_toRet, array('NEWS_CAT_ID'=>$row[$id], 'NEWS_CAT_TITLE'=>$row[$title], 'NEWS_CAT_NB'=>$totalCat, 'NEWS_CAT_URL'=>$catUrl));
				}
			}
			else{
				$arr_toRet	=	false;
			}
			return $arr_toRet;
		}
		
		function load_news_by_cat($pageDest, $new_newsCat, $nombre='15', $more="Read more...", $newLang="FR", $new_chapoLength="180"){
			global $mod_lang_output, $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
			
			//$page_destCat = $pageDest.'&'.$this->URI_newsCatVar.'='.$new_newsCat; 
			
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl_where2_lang($this->tbl_news, $this->fld_newsId, $this->fld_newsCatId, $this->fld_newsDisplay, $new_newsCat, 1);
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
			
			//Bloc menu de liens
			if($total > $nombre)
				$nav_menu	= $this->affichepage_cat($nombre, $pageDest, $total, $new_newsCat);
				
		 	$query 		= 	"SELECT * FROM $this->tbl_news WHERE $this->fld_newsDisplay='1' AND $this->fld_newsCatId='$new_newsCat' AND ($this->fld_modLang ='$newLang' OR $this->fld_modLang = 'XX') ORDER BY $this->fld_newsDatePub DESC LIMIT ".$limite.",".$nombre;
		  	$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
		  	if($total	= 	mysqli_num_rows($result)){
		  		$toRet  =   $nav_menu;
		  		$num	= 0;
		  		//$pageDest .= '-detail';
		  		while($row = mysqli_fetch_row($result)){
		  			//$last_lineBehaviour = (($num == $total) ? ("") : ('border-bottom:#ccc dashed 1px;'));
		  			$num++;
		  			$cssAlt	         =   ((($num % 2) == 0) ? ("newsEven") : ("newsOdd"));
		  			$link_detail     =   $this->set_mod_detail_uri($pageDest, $row[0]);
		  			
		  			$toRet .= "<div class=\"newsList borderedbox $cssAlt\" style=\"$last_lineBehaviour\">
								
								<div class=\"nlImg\">
									<a href=\"$link_detail\">
										<img src=\"".$this->mod_imgDir['heads']."$row[5]\" alt=\"$row[2]\" title=\"$row[2]\" />
									</a>
								</div>
			  					<div class=\"nlTitle\">
									<a title=\"$row[2]\" href=\"$link_detail\">$row[2]</a>
								</div>
								<div class=\"nlDescr\">
									<a style=\"color:#000;\" href=\"$link_detail\" title=\"$row[2]\">".$this->chapo($row[3], $new_chapoLength)."</a>
								</div>
                                <span class=\"nlDate\">".$this->show_datetime_by_lang($row[1], $lang)."
								<div style=\"clear:both;\"></div>
								<div class=\"more\">&raquo; <a href=\"$link_detail\" title=\"$row[2]\" class=\"lnk_black\">".$mod_lang_output['NEWS_MORE']."</a></div>
								<div class=\"clrBoth;\"></div>
								</div>";
		  		}
		  		$toRet .= $nav_menu;
		  	}
		  	else{
		  		$toRet = "<p>".$mod_lang_output['NO_NEWS']."</p>";	
		  	}
		  	return $toRet."<div class=\"clear_both\"></div>";
		}
		
		function load_valid_news_id(){
			//Charge les id de toutes les news, avec le total comme indice [0] bon pour espace d'admin
			$condition = "WHERE display='1'";
			return $tabNews = $this->load_id($this->tbl_news, $this->fld_newsId, $condition);
		}
		
		function load_valid_news_comment($new_newsId, $dir="ASC"){
		    //Afficher les r&eacute;actions aux articles, quand il y en a
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_newsComment WHERE $this->fld_newsId = '$new_newsId' AND display='1' ORDER BY $this->fld_newsCommentId $dir";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger les r&eacute;actions !!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = "<div class=\"comment\">";
				while($row = mysqli_fetch_array($result)){
					$comment_id 		= 	$row[0];
					$comment_artId 	= 	$row[1];
					$comment_date 	= 	$row[2];
					$usr_name 		= 	$row[3];
					$comment_email	= 	$row[4];;
					$comment_content 	= 	$row[5];
					$toRet .= "<div class=\"comment_container\">
								  <div class=\"comment_container_head\">
									<strong>De :</strong> $usr_name [ <em>$comment_email</em> ]<br />
									<strong>Post&eacute; le :</strong> ".$this->datetime_fr3($comment_date)."
								  </div>
								  <div class=\"comment_container_body\">".nl2br($comment_content)."</div>
							   </div>";
				}
				$toRet .= "</div>";
			}
			else{
				$toRet = "<div class=\"comment_no_comment\">Aucun commentaire pour l'instant.</div>";
			}
			return $toRet;
		}
	
		function load_valid_member_news_comment($new_newsId, $dir="ASC"){
		    global $thewu32_cLink;
			$usr = new cwd_usr();
			//Afficher les r&eacute;actions aux articles par les membres, quand il y en a
			$query = "SELECT * FROM $this->tbl_newsComment WHERE $this->fld_newsId = '$new_newsId' AND display='1' ORDER BY $this->fld_newsCommentId $dir";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger les r&eacute;actions !!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = "<div class=\"comment\">";
				while($row = mysqli_fetch_array($result)){
					$comment_id 		= 	$row[0];
					$comment_artId 	= 	$row[1];
					$comment_date 	= 	$row[2];
					$usr_id 		= 	$row[3];
					$comment_firstName= $usr->get_user_detail_by_usr_id("usr_detail_first", $usr_id);
					$comment_lastName	= $usr->get_user_detail_by_usr_id("usr_detail_last", $usr_id);
					$comment_email	= $usr->get_user_detail_by_usr_id("usr_detail_email", $usr_id);
					$comment_content 	= 	$row[5];
					$toRet .= "<div class=\"comment_container\">
								  <div class=\"comment_container_head\">
									<strong>De :</strong> $comment_firstName $comment_lastName [ <em>$comment_email</em> ]<br />
									<strong>Post&eacute; le :</strong> ".$this->datetime_fr2($comment_date)."
								  </div>
								  <div class=\"comment_container_body\">".nl2br($comment_content)."</div>
							   </div>";
				}
				$toRet .= "</div>";
			}
			else{
				$toRet = "<div class=\"comment_no_comment\">Aucun commentaire pour l'instant.</div>";
			}
			return $toRet;
		}
		
		function load_news_nav_by_cat($newNId="1", $newNCId="MF", $pageDest="news_detail.php", $css="news_nav"){
			/**
			* @param : 	string ^pageDest (Page de destination)
			* @param :	int $newNId (Id de la news)
			* @param :	int $newNCId (Id de la rubrique d'appartenance de la news)
			* @return :	{news nav menu}
			*
			* @descr : 	Afficher le menu de navigation des articles d'une même categorie
			**/
				//Charger les id des news d'une meme rubrique dans un tableau, 
				$tabNewsIdByCat_i	= $this->get_news_id_by_cat($newNCId);
				//On renverse cles/valeurs
				$tabNewsIdByCat_f	= array_flip($tabNewsIdByCat_i);
				//On compte le nombre d'item dans le tableau (les deux en ont le même nombre)
				$nbItem	= count($tabNewsIdByCat_i);
				//On identifie la cle courante
				$current_key 			= $tabNewsIdByCat_f[$newNId];
				//Sachant la cle courante, on peut savoir les cles suivante et precedente
				$next_key		= ($current_key + 1);
				$prev_key		= ($current_key - 1);
				
				//Pour les liens:
				$current		= $tabNewsIdByCat_i[$current_key];
				$next			= ((in_array($tabNewsIdByCat_i[$next_key], $tabNewsIdByCat_i)) ? ($tabNewsIdByCat_i[$next_key]): ($tabNewsIdByCat_i[0]));
				$prev			= ((in_array($tabNewsIdByCat_i[$prev_key], $tabNewsIdByCat_i)) ? ($tabNewsIdByCat_i[$prev_key]): ($tabNewsIdByCat_i[$nbItem - 1])); 
				$first			= $tabNewsIdByCat_i[0];
				$last			= $tabNewsIdByCat_i[$nbItem - 1];
			   /*-------------------------------------------------------------------------------------------------------------
				--------------------------------------------------------------------------------------------------------------*/
				/* $lnkNext 		= "<a href=\"$pageDest?$this->URI_newsVar=$next&$this->URI_newsCatVar=$newNCId#$next\">Next</a>";
				$lnkPrevious 	= "<a href=\"$pageDest?$this->URI_newsVar=$prev&$this->URI_newsCatVar=$newNCId#$prev\">Previous</a>";
				$lnkFirst		= "<a href=\"$pageDest?$this->URI_newsVar=$first&$this->URI_newsCatVar=$newNCId#$first\">First</a>";
				$lnkLast		= "<a href=\"$pageDest?$this->URI_newsVar=$last&$this->URI_newsCatVar=$newNCId#$last\">Last</a>"; */
				
				$lnkNext 		= "<a href=\"$pageDest".$this->URI_separator.$next.",newsdetail.html#$next"."\">$navNext</a>";
				$lnkPrevious 	= "<a href=\"$pageDest".$this->URI_separator.$prev.",newsdetail.html#$prev"."\">$navPrev</a>";
				$lnkFirst		= "<a href=\"$pageDest".$this->URI_separator.$first.",newsdetail.html#$first"."\">$navFirst</a>";
				$lnkLast		= "<a href=\"$pageDest".$this->URI_separator.$last.",newsdetail.html#$last"."\">$navLast</a>";
				
				$toRet			= "<p class=\"$css\">$lnkFirst | $lnkPrevious | $lnkNext | $lnkLast</p>";
				return $toRet;
			}
			
			function load_news_nav($newNId="1", $pageDest="news_detail.php", $css="news_nav", $navNext="Next", $navPrev="Previous", $navFirst="First", $navLast="Last"){
			/**
			* @param : 	string $pageDest (Page de destination)
			* @param :	int $newNId (Id de la news)
			* @return :	{news nav menu}
			*
			* @descr : 	Afficher le menu de navigation de tous les articles
			**/
				//Charger tous les id des news dans un tableau,
				$condition		= "WHERE display='1'";
				$tabNewsId_i	= $this->get_news_id($condition);
				//On renverse cles/valeurs
				$tabNewsId_f	= array_flip($tabNewsId_i);
				//On compte le nombre d'item dans le tableau (les deux en ont le même nombre)
				$nbItem			= count($tabNewsId_i);
				//On identifie la cle courante
				$current_key 	= $tabNewsId_f[$newNId];
				//Sachant la cle courante, on peut savoir les cles suivante et precedente
				$next_key		= ($current_key + 1);
				$prev_key		= ($current_key - 1);
				
				//Pour les liens:
				$current		= $tabNewsId_i[$current_key];
				$next			= ((in_array($tabNewsId_i[$next_key], $tabNewsId_i)) ? ($tabNewsId_i[$next_key]): ($tabNewsId_i[0]));
				$prev			= ((in_array($tabNewsId_i[$prev_key], $tabNewsId_i)) ? ($tabNewsId_i[$prev_key]): ($tabNewsId_i[$nbItem - 1])); 
				$first			= $tabNewsId_i[0];
				$last			= $tabNewsId_i[$nbItem - 1];
			   /*-------------------------------------------------------------------------------------------------------------
				--------------------------------------------------------------------------------------------------------------*/
				/*$lnkNext 		= "<a href=\"$pageDest&$this->URI_newsVar=$next#$next\">$navNext</a>";
				$lnkPrevious 	= "<a href=\"$pageDest&$this->URI_newsVar=$prev#$prev\">$navPrev</a>";
				$lnkFirst		= "<a href=\"$pageDest&$this->URI_newsVar=$first#$first\">$navFirst</a>";
				$lnkLast		= "<a href=\"$pageDest&$this->URI_newsVar=$last#$last\">$navLast</a>";*/
				
				$lnkNext 		= "<a href=\"$pageDest".$this->uri_page_separator[0].$this->uri_page_view[1].$this->uri_page_separator[0].$next.".html#$next"."\">$navNext</a>";
				$lnkPrevious 	= "<a href=\"$pageDest".$this->uri_page_separator[0].$this->uri_page_view[1].$this->uri_page_separator[0].$prev.".html#$prev"."\">$navPrev</a>";
				$lnkFirst		= "<a href=\"$pageDest".$this->uri_page_separator[0].$this->uri_page_view[1].$this->uri_page_separator[0].$first.".html#$first"."\">$navFirst</a>";
				$lnkLast		= "<a href=\"$pageDest".$this->uri_page_separator[0].$this->uri_page_view[1].$this->uri_page_separator[0].$last.".html#$last"."\">$navLast</a>";
				
				$toRet			= "<p class=\"$css\">$lnkFirst | $lnkPrevious | $lnkNext | $lnkLast</p>";
				return $toRet;
			}
			
			function load_news_related($new_newsId, $nbNews="5", $css="related", $pageDest="news_detail.php"){
			/**
			* @param :	string $new_newsId (L'ID de la news)
			* @param :	int $nbNews (Le nbre de lien a renvoyer)
			* @param :	int $css (La classe css pour personnaliser l'affichage)
			* @param : 	int $pageDest (La page de destination des liens renvoyes)
			* @return :	{liste de liens relatifs a la news en cours}
			*
			* @descr : 	afficher les liens de la même rubrique que l'article
			**/
				//Obtenir la categorie d'appartenance a la news courante get_news($new_newsId)
				$tabNewsItem	= $this->get_news($new_newsId);
				$tabNewsId	= array_reverse($this->get_news_by_cat($tabNewsItem[CATID]));
				$count 		= 0;
				$toRet		= "<ul style=\"padding:0; margin:0;\" class=\"$css\">";
				foreach($tabNewsId as $value){
					$count++;
					$newsItem	= $this->get_news($value);
					$cssAlt		= ((($count % 2) == 0) ? ("newsEven") : ("newsOdd"));
					$toRet		.= "<li style=\"padding:2px; margin:2px;\" class=\"$cssAlt\"><a style=\"font-weight:normal; color:#000;\" href=\"$pageDest&$this->URI_newsVar=$value\">$newsItem[TITLE]</a></li>";
					if($count == $nbNews)
						break;
				}
				return $toRet."</ul>";
			}
			
			function load_news_related_by_cat($new_newsCatId, $nbNews="5", $css="related", $pageDest="news_detail.php"){
			/**
			* @param :	string $new_newsCatId (L'ID de la categorie)
			* @param :	int $nbNews (Le nbre de lien a renvoyer)
			* @param :	int $css (La classe css pour personnaliser l'affichage)
			* @param : 	int $pageDest (La page de destination des liens renvoyes)
			* @return :	{liste de liens relatifs a la news en cours}
			*
			* @descr : 	afficher les liens de la même rubrique
			**/
				$tabNewsId	= array_reverse($this->get_news_by_cat($new_newsCatId));
				$count 		= 0;
				$toRet		= "<ul class=\"$css\">";
				foreach($tabNewsId as $value){
					$count++;
					$newsItem	= $this->get_news($value);
					$toRet		.= "<li><a href=\"$pageDest?$this->URI_newsVar=$value&$this->URI_newsCatVar=$new_newsCatId\">$newsItem[TITLE]</a></li>";
					if($count == $nbNews)
						break;
				}
				return $toRet."</ul>";
			}
		/* :::::::: ---- LOADERS End ---- :::::::: */	
		
		
			 /****************************************/	
			/* :::::::: All the switchers ::::::::  */
		   /****************************************/
		   
			function switch_news_state($new_newsId, $new_stateId){
			/**
			* @param : 	int $new_newsId (L'ID de la news concernee)
			* @param :	int / char $new_stateId (La valeur de switch)
			* @return :	true/false
			*
			* @descr :	Rendre public/prive une news
			**/
				return $this->set_updated_1($this->tbl_news, "display", $new_stateId, $this->fld_newsId, $new_newsId);
			}
			
			function switch_news_cat_state($new_newsCatId, $new_stateId){
			/**
			* @param : 	int $new_newsCatId (L'ID de la categorie concernee)
			* @param :	int / char $new_stateId (La valeur de switch)
			* @return :	true/false
			*
			* @descr :	Rendre public/prive une categorie
			**/
				return $this->set_updated_1($this->tbl_newsCat, "display", $new_stateId, $this->fld_newsCatId, $new_newsCatId);
			}
			
			function switch_news_comment_state($new_newsCommentId, $new_stateId){
			/**
			* @param : 	int $new_newsCommentId (L'ID du commentaire concernee)
			* @param :	int / char $new_stateId (La valeur de switch)
			* @return :	true/false
			*
			* @descr :	Rendre public/prive un commentaire
			**/
				return $this->set_updated_1($this->tbl_newsComment, "display", $new_stateId, $this->fld_newsCommentId, $new_newsCommentId);
			}
		/* :::::::: ---- Switchers End ---- :::::::: */	
		
		
			 /****************************************/	
			/* :::::::: All the updaters ::::::::   */
		   /****************************************/	
		
		//Mettre à jour les champs un à un ds la table des news. utile par ex pr MAJ l'image d'une news
		function update_news_element($new_newsId, $new_fldNews, $newVal){
			global $thewu32_cLink;
			$query = "UPDATE $this->tbl_news SET $new_fldNews = '$newVal' WHERE $this->fld_newsId = '$new_newsId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to update a news field.<br />".mysqli_error($thewu32_cLink));
			if(result)
				return true;
			else
				return false;
		}
		
		function update_news($new_newsId,
							 $new_newsDatePub,
							 $new_newsTitle,
							 $new_newsHeader,
							 $new_newsContent,
							 $new_newsHeaderImg,
							 $new_newsCatId,
							 $new_newsThumb,
							 $new_newsAuthId,
							 $new_newsTags,
							 $new_newsLangId){
			global $thewu32_cLink;
			$query = "UPDATE $this->tbl_news SET news_date		= '$new_newsDatePub',
												 news_title		= '$new_newsTitle',
												 news_header	= '$new_newsHeader',
												 news_content	= '$new_newsContent',
												 news_imgfile	= '$new_newsHeaderImg',
												 news_cat_id	= '$new_newsCatId',
												 news_thumb		= '$new_newsThumb',
												 naut_id		= '$new_newsAuthId',
												 news_tags		= '$new_newsTags',
												 $this->fld_newsLangId = '$new_newsLangId'
			WHERE 	$this->fld_newsId = '$new_newsId'";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to update news!<br />".mysqli_error($thewu32_cLink));
			if($result)
				return true;
			else 
				return false;
		}
		
		/**
		* @param :	char $new_newsCatId
		* @param :	string $new_newsCatLib
		* @param :	string $new_newsCatDescr
		* @param :	char $new_newsCatLang
		* @return true/false
		*
		* @descr :	Mettre a jour les rubriques
		**/
		function update_news_cat($new_newsCatId, $new_newsCatLib, $new_newsCatDescr, $new_newsCatLang){
		    global $thewu32_cLink;
			$query = "UPDATE $this->tbl_newsCat SET news_cat_lib	= '$new_newsCatLib',
												 	news_cat_descr	= '$new_newsCatDescr',
												 	lang			= '$new_newsCatLang',
												 	news_cat_id		= '$new_newsCatId'
			WHERE 	news_cat_id = '$new_newsCatId'";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to update news categories!<br />".mysqli_error($thewu32_cLink));
			if($result)
				return true;
			else 
				return false;
		}
		
		/**
		* @param int $new_newsAuthorId
		* @param string $new_newsAuthorLast
		* @param string $new_newsAuthorFirst
		* @param string $new_newsAuthorSex
		* @param int $new_newsAuthorCatId
		* @return true/false
		*
		* @descr Mettre a jour les d'utilisateurs
		**/
		function update_news_author($new_newsAuthorId, $new_newsAuthorLast, $new_newsAuthorFirst, $new_newsAuthorSex, $new_newsAuthorCatId){
		    global $thewu32_cLink;
			$query = "UPDATE $this->tbl_newsAuth SET $this->fld_newsAuthLastName	= '$new_newsAuthorLast',
													 $this->fld_newsAuthFirstName	= '$new_newsAuthorFirst',
													 $this->fld_newsAuthSex			= '$new_newsAuthorSex',
													 $this->fld_newsAuthCatId		= '$new_newsAuthorCatId'
								 WHERE $this->fld_newsAuthId = '$new_newsAuthorId'";
													 $result	= mysqli_query($thewu32_cLink, $query) or die("Unable to update news author!<br />".mysqli_error($thewu32_cLink));
			if($result)
				return true;
			else 
				return false;
		}
		
		function update_news_author_cat($new_newsAuthorCatId, $new_newsAuthorCatLib){
		/**
		* @param int $new_newsAuthorCatId
		* @param string $new_newsAuthorCatLib
		* @return true/false
		*
		* @descr Mettre a jour les groupes d'utilisateurs
		**/
		    global $thewu32_cLink;
			$query = "UPDATE $this->tbl_newsAuthCat SET $this->fld_newsAuthCatLib	= '$new_newsAuthorCatLib' WHERE $this->fld_newsAuthCatId = '$new_newsAuthorCatId'";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to update news author group!<br />".mysqli_connect_error());
			if($result)
				return true;
			else 
				return false;
		}
		   		
		function search_news($newKeyWord, $newsLink = "actuplus.php", $new_errMsg="Aucun article &agrave; afficher"){
		    global $thewu32_cLink;
			$upper 	= strtoupper($newKeyWord);
			$lower	= strtolower($newKeyWord);
			$query 	= "SELECT DISTINCT $this->fld_newsId, $this->fld_newsCatId, news_title, news_content  FROM $this->tbl_news WHERE news_content like '%$newKeyWord%' OR news_title like '%$newKeyWord%' OR news_content like '%$upper%' OR news_content like '%$lower%' AND display='1'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Recherche d'article impossible!<br />".mysqli_error($thewu32_cLink));
			if($total = mysqli_num_rows($result)){
				
				while($row = mysqli_fetch_row($result)){
					/*Determiner la rubrique::*/
					$tempRubTable = $this->tbl_newsCat;
					$tempRubFldId = $this->fld_newsCatId;
					$rub = $this->get_field_by_id($tempRubTable, $tempRubFldId, "news_cat_lib", $row[1]);
					/*fin extraction de la rubrique*/
					
					$id	   = $row[0];
					$titre = $row[2];
					$descr = strip_tags($row[3]);
					//$descr = utf8_decode($this->searchOutPut2($descr, $newKeyWord, 10, 10));
					$descr = $this->chapo($descr,200);
					$toRet .= "<div class=\"searchGroup\">
							   <div class=\"searchTitle\">[ $titre ]</div>
							   <div class=\"searchDescr\"><a class=\"cwv4_lnk_black\" href=\"$newsLink?$this->URI_newsVar=$id\">$descr</a></div>
							   <div class=\"searchLink\"><a class=\"cwv4_lnk_black\" href=\"$newsLink?$this->URI_newsVar=$id\">&raquo;Lire la suite...</a></div>
							   <div class=\"clear_both\"></div>
							   </div>";
				}
			}
			else{
				$toRet = "<div class=\"boxErr\">$new_errMsg pour le mot cl&eacute; '<strong>$newKeyWord</strong>'</div>";
			}
			return $toRet;
		}
		
		/*SECURITY : Check if a news passed on url exists*/
		function news_exists($new_newsId){
			if($this->chk_entry($this->tbl_news, $this->fld_newsId, $new_newsId))
				return true;
			else
				return false;
		}
		
		function count_news(){
			return $this->count_in_tbl($this->tbl_news, $this->fld_newsId);
		}
		
		//Building the main content of the xml spry data set
		function spry_ds_get_file_main(){
			/**
			 * @return {news xml content by cat}
			 *
			 * @descr : Charger les items pour le fichier xml
			 **/
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_news WHERE $this->fld_newsDisplay = '1'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to extract spry item for news!<br />".mysqli_error($thewu32_cLink));
			if($total = mysqli_num_rows($result)){
				while($row = mysqli_fetch_array($result)){
					$catLib	=	$this->get_news_cat_by_id($this->fld_newsCatLib, $row[6]);
					$author_firstName	=	$this->get_news_author_by_id($this->fld_newsAuthFirstName, $row['5']);
					$author_lastName	=	$this->get_news_author_by_id($this->fld_newsAuthLastName, $row['5']);
					$toRet.='<item id="'.$row[0].'" cat="'.$row[6].'">
										<cat><![CDATA['.$catLib.']]></cat>
										<date>'.$row[1].'</date>
										<title><![CDATA['.utf8_decode($row[2]).']]></title>
										<header><![CDATA['.utf8_decode($row[3]).']]></header>
										<content><![CDATA['.utf8_decode($row[4]).']]></content>		
										<img><![CDATA['.$row[5].']]></img>
										<thumb><![CDATA['.$row[7].']]></thumb>
										<author><![CDATA['.ucfirst($author_firstName).' '.strtoupper($author_lastName).']]></author>
										<tags><![CDATA['.$row[11].']]></tags>
										<lang>'.$row[9].'</lang>
										<url>'.$this->get_pages_modules_links('news', $row[9]).'-detail-'.$row[0].'.html'.'</url>
									</item>';
				}
			}
			return $toRet;
		}
		
		function news_autoIncr(){
			return $this->autoIncr($this->tbl_news, $this->fld_newsId);
		}
	}
?>