<?php
class cwd_annonce extends cwd_page {
	var $tbl_annonce;
	var $tbl_annonceCat;
	var $tbl_annonceAuthor;
	
	var $fld_annonceId;
	var $fld_langId;
	var $fld_annonceCatId;
	
	var $fld_annonceDatePub;
	var $fld_annonceLib;
	var $fld_annonceTitle;
	var $fld_annonceAuthor;
	var $fld_annonceAuthorF;
	var $fld_annonceAuthorL;
	var $fld_annonceSignature;
	var $fld_annonceCatLib;
	var $fld_annonceDisplay;
	
	var $URI_annonce;
	var $URI_annonceCat;
	var $mod_queryKey 		= 'pmId';
	var $mod_fkQueryKey 	= 'catId' ;
	var $URI_annonceLang	= 'langId';
	var $admin_modPage		= 'admin.php?page=annonce'; //'annonce_manager.php';
	
	var $default_recipient;

	public function __construct(){
        global $thewu32_tblPref, $thewu32_appExt;
        $this->tbl_annonce 				= 	$thewu32_tblPref."annonce";
        $this->tbl_annonceAuthor		= 	$thewu32_tblPref."usr_detail";
        $this->annonce_responseTbl 		= 	$thewu32_tblPref."annonce_response";
        $this->modName					=	'annonce';
        $this->modDir					.=	$this->modName;

        $this->fld_annonceAuthorL		= 	"usr_detail_last";
        $this->fld_annonceAuthorF		= 	"usr_detail_first";
        $this->fld_annonceId			= 	'annonce_id';
        $this->fld_annonce_responseId	= 	'annonce_reponse_id';
        $this->fld_langId				=	'lang_id';
        $this->tbl_annonceCat			= 	$thewu32_tblPref."annonce_cat";
        $this->fld_annonceCatId			= 	'annonce_cat_id';
        $this->fld_annonceTitle			= 	'annonce_title';
        $this->fld_annonceAuthor		= 	'usr_id';
        $this->fld_annonceLib			= 	'annonce_lib';
        $this->fld_annonceDatePub		= 	'annonce_date_pub';
        $this->fld_annonceSignature		=	'annonce_signature';
        $this->fld_annonceCatLib		=	'annonce_cat_lib';
        $this->fld_annonceDisplay		=	'display';
		$this->default_recipient		= 	$thewu32_defaultEmail;
		
        $this->set_uri_annonce("pmId");
		$this->set_uri_annonce_cat("catId");
		$this->set_admin_modPage($this->modName);
    }

	function cwd_annonce(){
		self::__construct();
	}
		
	/**
	 * Menu pour l'administration du module dans l'espace agr&eacute;&eacute; &agrave; cet effet.
	 * 
	 * @param void()
	 * @return admin menu.
	 * */
	function admin_get_menu(){
		$toRet = "<div class=\"ADM_menu\">
					  <h1>Gestion des annonces</h1>
					  <ul class=\"ADM_menu_title\">
					  	<h2>Les Annonces</h2>
					  	<li><a href=\"?what=annonceDisplay\">Lister les annonces</a></li>
						<li><a href=\"?what=annonceInsert\">Ins&eacute;rer une annonce</a></li>
					  </ul>
					  <ul>
					  	<h2>Les Cat&eacute;gories d'annonce</h2>
					  	<li><a href=\"?what=annonceCatDisplay\">Afficher les cat&eacute;gories</a></li>
					  	<li><a href=\"?what=annonceCatInsert\">Ajouter une cat&eacute;gorie</a></li>
					  </ul>
					  <div class=\"ADM_menu_descr\"></div>
				  </div>";
		return $toRet;				  
	}

	/**
	 * Definir la variabe d'url pour les annonces
	 * 
	 * @param string $new_uriVar
	 *
	 * @return void()*/
	function set_uri_annonce($new_uriVar){
		return $this->URI_annonce = $new_uriVar;
	}
	/**
	 * Definir la variabe d'url pour les categories d'annonces
	 * 
	 * @param string $new_uriCatVar
	 *
	 * @return void()*/
	function set_uri_annonce_cat($new_uriCatVar){
		return $this->URI_annonceCat = $new_uriCatVar;
	}
	
	function admin_load_annonces($nombre='50', $limit='0'){
		global $lang_output, $mod_lang_output, $thewu32_cLink;
		
		$limite = $this->limit;
		if(!$limite) $limite = 0;
		
		//Recherche du nom de la page
		$path_parts = pathinfo($PHP_SELF);
		$page = $path_parts["basename"].'?page=annonce';
		
		//Obtention du total des enregistrements:
		$total = $this->count_in_tbl($this->tbl_annonce, $this->fld_annonceId);
		
		$myUser	=	new cwd_user();
		
		
		//V&eacute;rification de la validit&eacute; de notre variable $limite......
		$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
			
		//Bloc menu de liens
		if($total > $nombre)
			$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
		
		
			
		$query 	= "SELECT * FROM $this->tbl_annonce ORDER BY $this->fld_annonceDatePub DESC LIMIT ".$limite.",".$nombre;
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load announcements!<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$num		= 	0;
			$toRet 		= 	$nav_menu;			
			$toRet 	.= "<table class=\"table table-bordered\">
							<tr>
								<th>&num;</th>
								<th>".$lang_output['TABLE_HEADER_CATEGORY']."</th>
								<th>".$lang_output['TABLE_HEADER_TITLE']."</th>
								<th>".$lang_output['TABLE_HEADER_AUTHOR']."</th>
								<th>".$lang_output['TABLE_HEADER_PUB-DATE']."</th>
								<th>".$lang_output['TABLE_HEADER_ACTION']."</th>
							</tr>";
			while($row = mysqli_fetch_array($result)){
				$num++;
				//alterner les liens public / prive
				
				$stateImg 	= (($row[11] == 0) ? ("<img src=\"img/icons/disabled.gif\" />") : ("<img src=\"img/icons/enabled.gif\" />"));
				$linkState	= ($row[11] == "0")?($mod_lang_output['ANNONCE_ACTION_SHOW']):($mod_lang_output['ANNONCE_ACTION_HIDE']);
				$varUri		= ($row[11] == "0")?("show"):("hide");
				$stateAlt	= ($row[11] == "0")?($mod_lang_output['ANNONCE_ACTION_SHOW']):($mod_lang_output['ANNONCE_ACTION_HIDE']);
				//Obtenir les libelles des categories
				$categorie 	= $this->get_annonce_cat_by_id($row[1]);
				//Convertir la date
				$date		= $this->date_fr($row[7]);
				
				$title		=	stripslashes($row[3]);
				//Alternet les css
				$author		=	ucfirst($myUser->get_user_detail_by_user_id($myUser->fld_userDetailFirstName, $row[2]))." ".strtoupper($myUser->get_user_detail_by_user_id($myUser->fld_userDetailLastName, $row[2]));
				
				$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
				//$author = (($row[2] == '0')?("Administrateur"):($row[2]));
				
				$toRet .="<tr class=\"$currentCls\">
							<th scope=\"row\">$num</th>
							<td>$categorie</td>
							<td>$title</td>
							<td>$author</td>
							<td>$date</td>
							<td nowrap style=\"background-color:#FFF; text-align:center;\">
								<a title=\"".$mod_lang_output['ANNONCE_ACTION_UPDATE']."\" href=\"?page=annonce&what=update&action=update&$this->URI_annonce=$row[0]\"><img src=\"img/icons/edit.gif\" /></a>
								<a title=\"".$mod_lang_output['ANNONCE_ACTION_DELETE']."\" href=\"?page=annonce&what=display&action=delete&$this->URI_annonce=$row[0]\" onclick=\"return confirm('".$mod_lang_output['CALLOUT_DELETE_WARNING']." : $title')\"><img src=\"img/icons/delete.gif\" /></a> 
								<a title=\"$linkState\" href=\"?page=annonce&action=$varUri&$this->URI_annonce=$row[0]&limite=$limite\">$stateImg</a>
							</td>							
						  </tr>";
			}
			$toRet .= "</table>$nav_menu";
			
		}
		else{
			$toRet	= $mod_lang_output['NO_ANNONCE'];
		}
		return $toRet;
	}
	
	function load_annonce($pageDest, $nombre='50', $more="Read more", $lang){ //Penser � rendre multilingue
	    global $thewu32_appExt, $thewu32_cLink;
		$limite = $this->limit;
		if(!$limite) $limite = 0;
		
		//Recherche du nom de la page
		/*$path_parts = pathinfo($PHP_SELF);
		$page = $path_parts["basename"];*/
		
		//Obtention du total des enregistrements:
		//$where = "WHERE $this->fld_langId = '$lang'";
		$total = $this->count_in_tbl_where1_lang($this->tbl_annonce, $this->fld_annonceId, $this->fld_langId, $lang);
		
		
		//V&eacute;rification de la validit&eacute; de notre variable $limite......
		$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
			
		//Bloc menu de liens
		if($total > $nombre) 
			$nav_menu	= $this->affichepage($nombre, $pageDest, $total, $this->uri_page_view[0]);
			
		$query 	= "SELECT $this->fld_annonceId, $this->fld_annonceCatId, annonce_title, annonce_lib, $this->fld_annonceDatePub FROM $this->tbl_annonce WHERE display='1' AND ($this->fld_modLang='$lang' OR $this->fld_modLang='XX') ORDER BY $this->fld_annonceDatePub DESC LIMIT ".$limite.",".$nombre;
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load announcements!<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$num	= 0;
			$toRet 	= $nav_menu;
			$toRet	.= "<ul class=\"annonce\">";
			while($row = mysqli_fetch_array($result)){
				$num++;
				//$last_lineBehaviour = (($num == $total) ? ("") : ('border-bottom:#ccc dashed 1px;'));
				//Obtenir les libelles des categories
				$categorie 	= $this->get_annonce_cat_by_id($row[1]);
				//Convertir la date
				$date		= $row[4];
				//Alternet les css
				//$currentCls = ((($num%2)==0) ? ("annonceEven") : ("annonceOdd"));
				
				$toRet .="<li>
							<div class=\"annonce_date\">".$this->show_date_by_lang($date, $lang)."</div>
							<div class=\"annonce_title\">$row[2]</div>
							<div class=\"annonce_lib\">".strip_tags($this->chapo($row[3], 150))."</div>
                            <span class=\"annonce_link\"><a href=\"".$this->set_mod_detail_uri($pageDest, $row[0])."\">$more</a></span>
							<span class=\"annonce_cat\">[ <a href=\"".$this->set_mod_detail_uri_cat($pageDest, $row[1])."\">$categorie</a> ]</span>
						  </li>";
			}
			$toRet .= "</ul>
                       $nav_menu";
			
		}
		else{
			$toRet	= "<p>Aucun &eacute;l&eacute;ment &agrave; afficher</p>";
		}
		return $toRet;
	}
	
	function arr_load_annonce($pageDest, $nombre='50', $more="Read more", $lang){
	    global $thewu32_appExt, $thewu32_cLink;
		$limite = $this->limit;
		if(!$limite) $limite = 0;
	
		//Recherche du nom de la page
		/*$path_parts = pathinfo($PHP_SELF);
		 $page = $path_parts["basename"];*/
	
		//Obtention du total des enregistrements:
		//$where = "WHERE $this->fld_langId = '$lang'";
		$total = $this->count_in_tbl_where1($this->tbl_annonce, $this->fld_annonceId, $this->fld_langId, $lang);
	
	
		//V&eacute;rification de la validit&eacute; de notre variable $limite......
		$veriflimite = $this->veriflimite($limite, $total, $nombre);
		if(!$veriflimite) $limite = 0;
			
		//Bloc menu de liens
		if($total > $nombre)
			$nav_menu	= $this->affichepage($nombre, $pageDest, $total);
			
		$query 	= "SELECT * FROM $this->tbl_annonce WHERE display='1' AND lang='$lang' ORDER BY $this->fld_annonceDatePub DESC LIMIT ".$limite.",".$nombre;
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load announcements!<br />".mysqli_error($thewu32_cLink));
		if($total = mysqli_num_rows($result)){
			$num		= 	0;
			$id 		= 	$this->fld_annonceId;
			$title		=	$this->fld_annonceTitle;
			$descr		=	$this->fld_annonceLib;
			$author		=	$this->fld_annonceAuthor;
			$catId		=	$this->fld_annonceCatId;
			$date		=	$this->fld_annonceDatePub;
			$signature	=	$this->fld_annonceSignature;
				
			$arr_toRet	=	array();
			while($row 	= 	mysqli_fetch_array($result)){
				$catTitle	=	$this->get_annonce_cat_by_id($row[$catId]);
				$pageUrl	=	$pageDest.$this->URI_pageSeparator[0].$this->uri_page_view[1].$this->uri_page_separator[0].$row[$id].$thewu32_appExt;
				array_push($arr_toRet, array('ANNONCE_ID'=>$row[$id], 'ANNONCE_TITLE'=>$row[$title], 'ANNONCE_DESCR'=>$row[$descr], 'ANNONCE_AUTHOR'=>$row[$author], 'ANNONCE_CAT_ID'=>$row[$catId], 'ANNONCE_CAT_TITLE'=>$catTitle, 'ANNONCE_DATE'=>$row[$date], 'ANNONCE_URL'=>$pageUrl));
			}
		}
		else{
			$arr_toRet	= false;
		}
		return $arr_toRet;
	}
	
	/*function admin_load_annonces(){
		$query 	= "SELECT * FROM $this->tbl_annonce ORDER BY '$this->fld_annonceId'";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load announcements!<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$num	= 0;
			$toRet 	= "<table class=\"ADM_table\">
						<tr>
							<th>N&ordm;</th>
							<th>Cat&eacute;gorie</th>
							<th>Titre</th>
							<th>Auteur</th>
							<th>Date de publication</th>
						</tr>";
			while($row = mysqli_fetch_array($result)){
				$num++;
				//alterner les liens public / prive
				$linkState	= ($row[11] == "0")?("Priv."):("Pub.");
				$varUri		= ($row[11] == "0")?("annoncePublish"):("annoncePrivate");
				$linkTitle	= ($row[11] == "0")?("Rendre l'annonce publique"):("Rendre l'annonce priv&eacute;");
				//Obtenir les libelles des categories
				$categorie 	= $this->get_annonce_cat_by_id($row[1]);
				//Convertir la date
				$date		= $this->date_fr($row[7]);
				//Alternet les css
				$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
				$author = (($row[2] == '0')?("Administrateur"):($row[2]));
				
				$toRet .="<tr class=\"$currentCls\">
							<td align=\"center\">$num</td>
							<td>$categorie</td>
							<td>$row[3]</td>
							<td>$author</td>
							<td>$date</td>
							<td nowrap><a title=\"Modifier l'article\" href=\"?what=annonceUpdate&action=annonceUpdate&$this->URI_annonce=$row[0]\">Mod.</a> | <a title=\"Supprimer l'article\" href=\"?what=annonceDisplay&action=annonceDelete&$this->URI_annonce=$row[0]\" onclick=\"return confirm('&Ecirc;tes-vous s&ucirc;r de vouloir supprimer cette annonce?')\">Suppr.</a> | [ <a title=\"$linkTitle\" href=\"?action=$varUri&$this->URI_annonce=$row[0]\">$linkState</a> ] </td>
							
						  </tr>";
			}
			$toRet .= "</table>";
			
		}
		else{
			$toRet	= "Aucune news &agrave; afficher";
		}
		return $toRet;
	}*/
	
	function admin_load_annonces_cat(){
		global $lang_output, $mod_lang_output, $thewu32_cLink;
		
		$query 	= "SELECT * FROM $this->tbl_annonceCat ORDER BY '$this->fld_annonceCatId'";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news categories!<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$num	= 0;
			$toRet 	= "<table class=\"table table-bordered\">
						<tr>
							<th>&num;</th>
							<th>".$mod_lang_output['TABLE_HEADER_CATEGORY']."</th>
							<th>".$mod_lang_output['TABLE_HEADER_ACTION']."</th>
						</tr>";
			while($row = mysqli_fetch_array($result)){
				$num++;
				
				
				//alterner les liens public / prive
				/*$linkState	= ($row[3] == "0")?("Priv."):("Pub.");
				$varUri		= ($row[3] == "0")?("newsCatPublish"):("newsCatPrivate");
				$linkTitle	= ($row[3] == "0")?("Rendre la cat&eacute;gorie publique"):("Rendre la cat&eacute;gorie priv&eacute;e"); */
				//Alterner les css
				$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));				
				
				$toRet .="<tr class=\"$currentCls\">
							<th scope=\"row\" align=\"center\">$num</th>
							<td>$row[1]</td>
							<!-- <td>$row[2]</td> -->
							<td nowrap style=\"background-color:#FFF; text-align:center;\">
							<a title=\"".$lang_output['TABLE_TOOLTIP_UPDATE']."\" href=\"?page=annonce&what=catDisplay&action=catUpdate&acId=$row[0]\"><img src=\"img/icons/edit.gif\" /></a>
							<a title=\"".$lang_output['TABLE_TOOLTIP_DELETE']."\" href=\"?page=annonce&what=catDisplay&action=catDelete&acId=$row[0]\" onclick=\"return confirm('".$mod_lang_output['CALLOUT_CAT_DELETE_WARNING']."')\"><img src=\"img/icons/delete.gif\" /></a>
							</td> 
						  </tr>";
			}
			$toRet .="</table>";
			
		}
		else{
			$toRet	= "<p>".$mod_lang_output['NO_ANNONCE_CATEGORY']."</p>";
		}
		return $toRet;
	}
	
	/* function load_annonce_cat($pageDest="annonce.php", $errMsg=""){
	    global $thewu32_cLink;
		$query 	= "SELECT * FROM $this->tbl_annonceCat WHERE lang_id = '".$_SESSION[LANG]."' ORDER BY annonce_cat_lib";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load annonces categories.<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$toRet = "<ul class=\"nav\">";
			while($row = mysqli_fetch_array($result)){
				//$toRet .= "<li><a href=\"$pageDest"."&".$this->URI_annonceCat."=".$row[0]."\">$row[1]</a></li>";
				$toRet .= "<li>".$this->toggle_icon($this->mod_catIcon)."<a href=\"".$this->set_mod_detail_uri_cat($pageDest, $row[0])."\">$row[1]</a></li>";
			}
			$toRet .="</ul>";
		}
		else{
			$toRet = $errMsg;
		}
		return $toRet;
	} */
	
	function load_annonce_cat($pageDest="annonce.php", $errMsg="",  $imgIcon="", $new_annonceCatLang='FR'){
	    global $thewu32_cLink;
	    $query 	= "SELECT DISTINCT $this->fld_annonceCatId FROM $this->tbl_annonce WHERE ($this->fld_modLang = '$new_annonceCatLang' OR $this->fld_modLang = 'XX')";
	    $result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load annonces categories.<br />".mysqli_error($thewu32_cLink));
	    if($total = mysqli_num_rows($result)){
	        $toRet = "<ul class=\"nav\">";
	        while($row = mysqli_fetch_array($result)){
	            //$toRet .= "<li><a href=\"$pageDest"."&".$this->URI_annonceCat."=".$row[0]."\">$row[1]</a></li>";
	            $toRet .= "<li>".$this->toggle_icon($this->mod_catIcon)."<a href=\"".$this->set_mod_detail_uri_cat($pageDest, $row[0])."\">".$this->get_annonce_cat_by_id($row[0])."</a></li>";
	        }
	        $toRet .="</ul>";
	    }
	    else{
	        $toRet = $errMsg;
	    }
	    return $toRet;
	}
	
	function arr_load_annonce_cat($pageDest='annonce.php', $lang){
	    global $thewu32_cLink;
		$query 	= "SELECT * FROM $this->tbl_annonceCat WHERE lang = '$lang' ORDER BY annonce_cat_lib";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load annonces categories.<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$arr_toRet = array();
			$id 		= 	$this->fld_annonceCatId;
			$title		=	$this->fld_annonceCatLib;
			$lang		=	$this->fld_langId;
			while($row = mysqli_fetch_array($result)){
				//$toRet .= "<li><a href=\"$pageDest"."&".$this->URI_annonceCat."=".$row[0]."\">$row[1]</a></li>";
				$totalCat	=	$this->count_in_tbl_where2($this->tbl_annonce, $this->fld_annonceId, $this->fld_annonceCatId, 'display', $row[$id], '1');
				$catUrl		=	($totalCat != 0) ? ($pageDest.'-cat@'.$row[0].'.html') : ('#');
				array_push($arr_toRet, array('ANNONCE_CAT_ID'=>$row[$id], 'ANNONCE_CAT_TITLE'=>$row[$title], 'ANNONCE_CAT_NB'=>$totalCat, 'ANNONCE_CAT_URL'=>$catUrl));
			}
		}
		else{
			$arr_toRet	=	false;
		}
		return $arr_toRet;
	}
	
	/**
	 * Afficher les rubriques dans un combobox, toutes les rubriques (Utile pour l'espace d'admin).
	 *
	 * @param $FORM_var 	: La variable de formulaire, pour fixer la valeur choisie, en cas d'erreur dans le formulaire qui entrainerait le rechargement de la page
	 * @param $CSS_class 	: La classe CSS a utiliser pour enjoliver la presentation
	*/
	function admin_cmb_show_rub($FORM_var="", $CSS_class=""){
	    global $thewu32_cLink;
		$query 	= "SELECT * FROM $this->tbl_annonceCat ORDER BY annonce_cat_lib";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load annonces categories.<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$toRet = "";
			//if($FORM_var	== )
			while($row = mysqli_fetch_array($result)){
				$selected = ($FORM_var == $row[0])?("SELECTED"):("");
				$toRet .= "<option value=\"$row[0]\"$selected>$row[1]</option>";
			}
		}
		else{
			$toRet = "<option>Aucune cat&eacute;gorie &agrave; afficher</option>";
		}
		return $toRet;
	}
	
	/*function admin_cmb_show_rub_by_lang($lang="FR", $FORM_var="", $CSS_class=""){
		$query 	= "SELECT * FROM $this->tbl_annonceCat WHERE lang='$lang' ORDER BY annonce_cat_lib";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load announcements categories.<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$toRet = "";
			//if($FORM_var	== )
			while($row = mysqli_fetch_array($result)){
				$selected = ($FORM_var == $row[0])?("SELECTED"):("");
				$toRet .= "<option value=\"$row[0]\"$selected>$row[1]</option>";
			}
		}
		else{
			$toRet = "<option>Aucun type d'&eacute;v&eacute;nement &agrave; afficher</option>";
		}
		return $toRet;
	}*/
	
	function admin_cmb_show_rub_by_lang($lang="FR", $FORM_var="", $CSS_class=""){
	    global $lang_output, $thewu32_cLink;
	    if($lang   !=  'XX')
	        $query 	=  "SELECT * FROM $this->tbl_annonceCat WHERE $this->fld_modLang ='$lang' ORDER BY $this->fld_annonceCatLib";
	        else
	            $query  =  "SELECT * FROM $this->tbl_annonceCat ORDER BY $this->fld_annonceCatLib";
	            
	            $result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load annonce categories.<br />".mysqli_connect_error());
	            if($total = mysqli_num_rows($result)){
	                $toRet = "";
	                //if($FORM_var	== )
	                while($row = mysqli_fetch_array($result)){
	                    $selected = ($FORM_var == $row[0])?("SELECTED"):("");
	                    $toRet .= "<option value=\"$row[0]\"$selected>$row[1] ($row[2])</option>";
	                }
	            }
	            else{
	                $toRet = "<option value=\"\">".$lang_output['ADMIN_COMBO_NO_DATA']."</option>";
	            }
	            return $toRet;
	}
	
	/*Rendre public/prive une categorie*/
	function set_rub_state($new_annonceCatId, $new_stateId){
		return $this->set_updated_1($this->tbl_annonceCat, "display", $new_stateId, $this->fld_annonceCatId, $new_annonceCatId);
	}
	
	/*Rendre public/prive une annonce*/
	function set_annonce_state($new_annonceId, $new_stateId){
		return $this->set_updated_1($this->tbl_annonce, "display", $new_stateId, $this->fld_annonceId, $new_annonceId);
	}
	
	/*Rendre public/prive une rubrique*/
	function set_annoncecat_state($new_annonceCatId, $new_stateId){
		return $this->set_updated_1($this->tbl_annonceCat, "display", $new_stateId, $this->fld_annonceCatId, $new_annonceCatId);
	}
	
	/*Supprimer une annonce*/
	function del_annonce($new_annonceId){
		return $this->rem_entry($this->tbl_annonce, $this->fld_annonceId, $new_annonceId);
	}
	
	/**
	 * Supprimer une categorie : 
	 * Entraine une suppression en cascade dans les tables mï¿½re et fille
	 * 
	 * @param int $new_annonceCatId 
	 * @return true or false*/
	function del_annonce_cat($new_annonceCatId){
		if(
			($this->rem_entry($this->tbl_annonceCat, $this->fld_annonceCatId, $new_annonceCatId)) 
			&& 
			($this->rem_entry($this->tbl_annonceCat, $this->fld_annonceCatId, $new_annonceCatId))
		)
			return true;
		else 
			return false;
	}
	
	
	/**
	 * Afficher les rubriques dans un combobox, suivant la langue.
	 *
	 * @param $FORM_var 	: La variable de formulaire, pour fixer la valeur choisie, en cas d'erreur dans le formulaire qui entrainerait le rechargement de la page
	 * @param $lang 		: La langue utilisee (Francais par defaut)
	 * @param $CSS_class 	: La classe CSS a utiliser pour enjoliver la presentation
	*/
	function cmb_show_rub($FORM_var="", $lang = "FR", $CSS_class=""){
	    global $thewu32_cLink;
		$query 	= "SELECT * FROM $this->tbl_annonceCatTbl WHERE lang = '$lang' ORDER BY rub_lib";
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

	function get_recent_annonce($annonceLink="annonce.php", $number=5, $lang='FR', $dfltMsg="Aucune annonce &agrave; afficher!!"){
	    global $thewu32_cLink;
		//Les titres des annonces les plus recentes ds un box
		//$number = ((int)($number - 1));
		$query = "SELECT $this->fld_annonceId, annonce_title FROM $this->tbl_annonce WHERE display = '1' and lang_id='$lang' ORDER BY annonce_date_pub DESC LIMIT 0, $number";
		$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger les annonces r&eacute;centes!!<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$id = $this->fld_annonceId;
			$toRet = "<ul>";
			while($row = mysqli_fetch_array($result)){
				$toRet .= "<li>
						   	<a class=\"annonce_link\" href=\"$annonceLink?$this->URI_annonce=".$row[$id]."\">".$row["annonce_title"]."</a>
						   </li>";
			}
		}
		else{
			$toRet = "<p>$dfltMsg</p>";
		}
		return $toRet."</ul>";
	}
	/*function load_recent_annonce($annonceLink="annonce.php", $nb="5", $lang="FR", $dfltMsg="Aucune annonce &agrave; afficher!!"){
		return $this->get_recent_annonce($annonceLink, $nb, $lang, $dfltMsg);
	}*/
	
	function load_recent_annonce($number=5, $page_annonceDetail='annonce_read.php', $lang='FR', $pageAnnonce='annonces.php'){
	    global $thewu32_cLink;
		//Les titres des annonces les plus recentes ds un box
		//$number = ((int)($number - 1));
		$query = "SELECT $this->fld_annonceId, annonce_title, annonce_date_pub FROM $this->tbl_annonce WHERE display = '1' AND lang='$lang' ORDER BY annonce_date_pub DESC LIMIT 0, $number";
		$result = mysqli_query($thewu32_cLink, $query) or die("Unable to load recent announcements!!<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			//$annonces_link = "<p>&raquo;<a class=\"box_link\" href=\"$pageAnnonce\">Toutes les annonces</a></p>";
			$id 	= $this->fld_annonceId;
			$toRet 	= ""; //"<ul>";
			while($row = mysqli_fetch_array($result)){
				$toRet	.= "<p class=\"recent\">
						   		<!-- <a class=\"annonce_link\" href=\"$page_annonceDetail&$this->URI_annonce=".$row[$id]."&view=detail\"><strong>".$this->date_fr($row["annonce_date_pub"])." - </strong>".$row["annonce_title"]."</a> -->
						   		<a class=\"annonce_link\" href=\"$page_annonceDetail"."-".$row[$id]."-"."detail.html\"><span style=\"font-weight:bold; color:#E36917\">".$this->date_fr($row["annonce_date_pub"])." - </span>".$row["annonce_title"]."</a>
						  	</p>";
			}
		}
		else{
			$toRet = "<p class=\"annonce_recent\">Aucune annonce &agrave; afficher!!</p>";
		}
		return $toRet; //."</ul>";
	}
	
	function load_last_annonce($number=5, $page_annonceDetail='annonce_read.php', $lang='FR', $css='top_annonce', $start=0){
	    global $thewu32_cLink;
	    $query = "SELECT $this->fld_annonceId, annonce_title, annonce_date_pub FROM $this->tbl_annonce WHERE display = '1' AND (lang_id='$lang' OR lang_id = 'XX') ORDER BY annonce_date_pub DESC LIMIT $start, $number";
	    $result = mysqli_query($thewu32_cLink, $query) or die("Unable to load recent announcements!!<br />".mysqli_connect_error());
	    if($total = mysqli_num_rows($result)){
	        $toRet 	= "<ul class=\"$css\">";
	        while($row = mysqli_fetch_array($result)){
	            $toRet	.= "<li>
						   		<a href=\"".$this->set_mod_detail_uri($page_annonceDetail, $row[0])."\"><span class=\"annonce_date\">".$this->show_date_by_lang($row["annonce_date_pub"], $lang)." - </span>".$row["annonce_title"]."</a>
						  	</li>";
	        }
	        $toRet .=  "</ul>";
	    }
	    else{
	        $toRet = "<p class=\"annonce_recent\">Aucune annonce &agrave; afficher!!</p>";
	    }
	    return $toRet;
	}
	
	function arr_load_recent_annonce($number='5',  $page_annonceDetail='annonce_read.php', $lang='EN', $pageAnnonce='annonces.php'){
	    global $thewu32_cLink;
		$query = "SELECT $this->fld_annonceId, annonce_title, annonce_date_pub FROM $this->tbl_annonce WHERE display = '1' AND lang_id='$lang' ORDER BY annonce_date_pub DESC LIMIT 0, $number";
		$result = mysqli_query($thewu32_cLink, $query) or die("Unable to load recent announcements!!<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$id 		= 	$this->fld_annonceId;
			$title		=	$this->fld_annonceTitle;
			$date		=	$this->fld_annonceDatePub;
			$arr_toRet	= 	array();
			while($row = mysqli_fetch_array($result)){
				array_push($arr_toRet, array('ANNONCE_ID'=>"$row[$id]", 'ANNONCE_TITLE'=>"$row[$title]", 'ANNONCE_DATE'=>"$row[$date]"));
			}
		} //else $arr_toRet = false;
		return $arr_toRet;
	}
	
	function load_recent_annonce_home($number=5, $page_annonceDetail='annonce_read.php', $lang='FR', $pageAnnonce='annonces.php'){
	    global $thewu32_cLink;
		//Les titres des annonces les plus recentes ds un box
		//$number = ((int)($number - 1));
		$query = "SELECT $this->fld_annonceId, annonce_title, annonce_date_pub FROM $this->tbl_annonce WHERE display = '1' AND lang='$lang' ORDER BY annonce_date_pub DESC LIMIT 0, $number";
		$result = mysqli_query($thewu32_cLink, $query) or die("Unable to load recent announcements!!<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			//$annonces_link = "<p>&raquo;<a class=\"box_link\" href=\"$pageAnnonce\">Toutes les annonces</a></p>";
			$id 	= $this->fld_annonceId;
			$toRet 	= ""; //"<ul>";
			while($row = mysqli_fetch_array($result)){
				$toRet	.= "<div class=\"top_annonce\">
						   		<!-- <a class=\"annonce_link\" href=\"$page_annonceDetail&$this->URI_annonce=".$row[$id]."&view=detail\"><strong>".$this->date_fr($row["annonce_date_pub"])." - </strong>".$row["annonce_title"]."</a> -->
						   		<a href=\"$page_annonceDetail"."-".$row[$id]."-"."detail.html\"><span class=\"annonce_date\">".$this->date_fr($row["annonce_date_pub"])." - </span>".$row["annonce_title"]."</a>
						  	</div>";
			}
		}
		else{
			$toRet = "<p>Aucune annonce &agrave; afficher!!</p>";
		}
		return $toRet; //."</ul>";
	}
	
		function get_annonce_id(){
			return $this->load_id($this->tbl_annonce, "annonce_id");
		}
		
		function get_annonce_response_id(){
			return $this->load_id($this->annonce_responseTbl, "annonce_response_id");
		}
		
		function get_public_annonce_id(){
			return $this->load_id($this->tbl_annonce, "annonce_id", "WHERE display = 1");
		}
		
		function get_public_annonce_id_by_cat($new_catId){
			return $this->load_id($this->tbl_annonce, "annonce_id", "WHERE $this->fld_annonceCatId ='$new_catId' AND display = 1");
		}
		
		function get_public_annonce_response_id(){
			return $this->load_id($this->annonce_responseTbl, "annonce_response_id", "WHERE display = 1");
		}
		
		/**
		* Les id des annonces les plus r&eacute;centes
		*/
		function get_recent_annonce_id(){
			return $this->get_lastId($this->tbl_annonce, "annonce_id", "display", "1", "annonce_id", 1);
		}
		
		/**
		* Les id des reponses aux annonces les plus r&eacute;centes
		*/
		function get_recent_annonce_response_id($nbId=5){
			return $this->get_lastId($this->annonce_responseTbl, "announce_response_id", "display", "1", "announce_response_id", $nbId);
		}
		
		function update_annonce($new_annonceId, $new_annonceCatId, $new_annonceUserId, $new_annonceTitle, $new_annonceLib, $new_annonceSignature, $new_annonceDatePub, $new_annonceLang){
		    global $thewu32_cLink;
			$query = "UPDATE $this->tbl_annonce SET  
											 $this->fld_annonceCatId 	= '$new_annonceCatId',
											 usr_id						= '$new_annonceUserId',
					  	 					 annonce_title				= '$new_annonceTitle',
					  	 					 annonce_lib				= '$new_annonceLib',
					  	 					 annonce_signature			= '$new_annonceSignature',
					  	 					 annonce_date_pub			= '$new_annonceDatePub',
					  	 					 lang						= '$new_annonceLang'
			WHERE 	$this->fld_annonceId = '$new_annonceId'";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to update announcements!<br />".mysqli_connect_error());
		if($result)
			return true;
		else 
			return false;
	}
	
	
	function update_annonce_cat($new_annonceCatId, $new_annonceCatLib, $new_annonceCatLang){
	    global $thewu32_cLink;
		$query = "UPDATE $this->tbl_annonceCat SET  annonce_cat_lib	= '$new_annonceCatLib', lang_id = '$new_annonceCatLang'
		WHERE 	$this->fld_annonceCatId = '$new_annonceCatId'";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to update announcements categories!<br />".mysqli_error($thewu32_cLink));
		if($result)
			return true;
		else 
			return false;
	}
		
		
	//Inserer une annonce dans la BDD
	function annonce_insert($new_annonceCatId, $new_annonceUserId, $new_annonceTitle, $new_annonceLib, $new_annonceSignature, $new_annonceImg, $new_annonceDatePub, $new_annonceDateInsert, $new_annoncePj, $new_annonceLang){
		return $this->set_annonce($new_annonceCatId, $new_annonceUserId, $new_annonceTitle, $new_annonceLib, $new_annonceSignature, $new_annonceImg, $new_annonceDatePub, $new_annonceDateInsert, $new_annoncePj, $new_annonceLang);
	}
		
	//Inserer une categorie d'annonce dans la BDD
	function annonce_cat_insert($newCatLib, $newCatLang){
		return $this->set_annonce_cat($newCatLib, $newCatLang);
	}
	/**
	 * Ressortir l'enregistrement li&eacute; ï¿½ une annonce
	 *
	 * @return un tableau.
	 */
	function get_annonce($new_annonceId){
	    global $thewu32_cLink;
		$query = "SELECT * FROM $this->tbl_annonce WHERE annonce_id = '$new_annonceId'";
		$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger l'annonce!<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			while($row = mysqli_fetch_row($result)){
				$toRet = array(
							   "annonceID"			=> $row[0],
							   "annonceCATID"		=> $row[1],
							   "userID"				=> $row[2],
							   "annonceTITLE"		=> $row[3],
							   "annonceLIB"			=> $row[4],
							   "annonceSIGNATURE"	=> $row[5],
							   "annonceIMG"			=> $row[6],
							   "annonceDATEPUB"		=> $row[7],
							   "annonceDATECREA"	=> $row[8],
							   "annoncePJ"			=> $row[9],
							   "annonceLANG"		=> $row[10],
							   "annonceDISPLAY"		=> $row[11]
							   );
			}
			return $toRet;
		}
		else
			return false;
	}
		
	function get_annonce_cat($new_annonceCatId){
	    global $thewu32_cLink;
		$query = "SELECT * FROM $this->tbl_annonceCat WHERE $this->fld_annonceCatId = '$new_annonceCatId'";
		$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger la cat&eacute;gorie d'annonce!<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			while($row = mysqli_fetch_row($result)){
				$toRet = array(
							   "annonceCATID"		=> $row[0],
							   "annonceCATLIB"		=> $row[1],
							   "annonceCATLANG"		=> $row[2]
							   );
			}
			return $toRet;
		}
		else
			return false;
	}
		
	/**
	 * Ressortir l'enregistrement li&eacute; ï¿½ une reponse d'annonce
	 * si userID = 0, alors c'est un visiteur
	 * @return un tableau.
	 */
	function get_annonce_response($newId){
	    global $thewu32_cLink;
		$query = "SELECT * FROM $this->annonce_responseTbl WHERE announce_response_id = '$newId'";
		$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger l'annonce!<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			while($row = mysqli_fetch_row($result)){
				$toRet = array("annonce_responseID"		=> $row[0],
							   "annonceID"				=> $row[1],
							   "userID"					=> $row[2],
							   "annonce_responseAUTHOR"	=> $row[3],
							   "annonce_responseTITRE"	=> $row[4],
							   "annonce_responseLIB"	=> $row[5],
							   "annonce_responseDATE"	=> $row[6],
							   "annonce_responseDISPLAY"=> $row[7]
							   );
			}
			return $toRet;
		}
		else
			return false;
	}
		
		/**
		 * Un get_field_by_id adapt&eacute; aux annonces uniquement
		 *
		 * @return la valeur du champ $fldToGet de la table des annonces, dont l'id est $newId.
		 */
		function get_annonce_by_id($fldToGet, $newId){
			return $this->get_field_by_id($this->tbl_annonce, "annonce_id", $fldToGet, $newId);
		}
		
		function get_annonce_cat_by_id($new_annonceCatId){
			return $this->get_field_by_id($this->tbl_annonceCat, $this->fld_annonceCatId, "annonce_cat_lib", $new_annonceCatId);
		}
		
		/**
		 * Un get_field_by_id adapt&eacute; aux r&eacute;ponses des annonces uniquement
		 *
		 * @return la valeur du champ $fldToGet de la table des reponses aux annonces, dont l'id est $newId.
		 */
		function get_annonce_response_by_id($fldToGet, $newId){
			return $this->get_field_by_id($this->annonce_responseTbl, "annonce_response_id", $fldToGet, $newId);
		}
		
		function annonce_state($newStateId, $lang="FR"){
			if($lang == "FR"){
				switch($newStateId){
					case("1") : $toRet = "Public";
					break;
					case("0") : $toRet = "En cours de validation";
					break;
				}
			}
			elseif($lang == "EN"){
				switch($newStateId){
					case("1") : $toRet = "Public";
					break;
					case("0") : $toRet = "Pending";
					break;
				}
			}
			return $toRet;
		}
		
		/**
		 * Alterner l'etat activ&eacute;/desactiv&eacute; des annonces
		 * */
		function switch_annonce_status($newAnnId, $statusVal){
			if($this->set_updated_1($this->tbl_annonce, "display", $statusVal, "annonce_id", $newAnnId))
				return true;
		}
		
		/**
		 * Supprimer une annonce
		 * */
		function annonce_delete($new_annonceId){
			if($this->rem_entry($this->tbl_annonce, "annonce_id", $new_annonceId));
				return true;
		}
				
		/**
		 * Afficher un tableau d'id des annonces de l'utilisateur newUserId
		 *
		 * @return un tableau.
		 */
		function get_user_annonce_id($newUserId, $dir="DESC"){
			/*
			*	Ressortir l'enregistrement li&eacute; &agrave; une annonce
			*/
			$condition = " WHERE user_id = '$newUserId'";
			return $tabId = $this->load_id($this->tbl_annonce, "annonce_id", $condition);
		}
		
		/**
		 * Ins&eacute;rer une annonce dans la bdd par l'utilisateur $newUserId
		 *
		 * @return true si l'annonce est ins&eacute;r&eacute;e, false sinon.
		 */
		function set_annonce($new_annonceCatId, 
							 $new_annonceUserId, 
							 $new_annonceTitle, 
							 $new_annonceLib, 
							 $new_annonceSignature,
							 $new_annonceImg,
							 $new_annonceDatePub,
							 $new_annonceDateInsert,
							 $new_annoncePj,
		    $new_annonceLang){
		    global $thewu32_cLink;
			//$newId	= $this->count_in_tbl($this->tbl_annonce, $this->fld_annonceId) + 1;
			$query = "INSERT INTO $this->tbl_annonce VALUES('".$this->annonce_autoIncr()."', '$new_annonceCatId', 
														   '$new_annonceUserId', 
														   '$new_annonceTitle',
														   '$new_annonceLib', 
														   '$new_annonceSignature', 
														   '$new_annonceImg', 
														   '$new_annonceDatePub',
														   '".$this->get_datetime()."',
														   '$new_annoncePj',
														   '$new_annonceLang',
														   '0')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'ajouter des annonces!<br />".mysqli_error($thewu32_cLink));
			if($result)
				return true; //mysql_insert_id($thewu32_cLink);
			else
				return false;
				
		}
		
		function set_annonce_cat($newCatLib, $newCatLang='FR'){
		    global $thewu32_cLink;
			$new_catId	=	$this->count_in_tbl($this->tbl_annonceCat, $this->fld_annonceCatId) + 1;
			$query = "INSERT INTO $this->tbl_annonceCat VALUES($new_catId, '$newCatLib', '$newCatLang')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'ajouter les cat&eacute;gories d'annonces!<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
				
		}
		
		/*Mettre a jour n'importe kel champ de la table des annonce sachant l'id*/
		function annonce_element_update($new_fldAnnonce, $new_valAnnonce, $new_annonceId){
			return	$this->update_entry_by_id($this->tbl_annonce, $this->fld_annonceId, $new_fldAnnonce, $new_valAnnonce, $new_annonceId);
		}
		
		/**
		 * Ins&eacute;rer une reponse d'annonce dans la bdd par l'utilisateur $newUserId
		 *
		 * @return true si l'annonce est ins&eacute;r&eacute;e, false sinon.
		 */
		function set_annonce_response($newannonceId, $newUserId, $newAuthor, $newTitle, $newLib){
		    global $thewu32_cLink;
			$query = "INSERT INTO $this->annonce_responseTbl VALUES('',
															'$newannonceId',
															'$newUserId',
															'$newAuthor', 
															'$newTitle', 
															'$newLib',
															'".$this->get_datetime()."',
															'1')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'ajouter les reponses aux annonces!<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
				
		}
		
		/**
		 * Mettre une annonce ï¿½ jour
		 *
		 * @return true si succï¿½s, false sinon.
		 */
		function annonce_update($new_annonceId, $new_annonceUserId, $new_annonceCatId, $new_annonceTitle, $new_annonceLib, $new_annonceSignature, $new_annonceDate, $new_annonceLang){
		    global $thewu32_cLink;
			$query = "UPDATE $this->tbl_annonce SET $this->fld_annonceCatId			= 	'$new_annonceCatId',
													$this->fld_annonceTitle	 		= 	'$new_annonceTitle', 
													$this->fld_annonceLib 			= 	'$new_annonceLib',
													$this->fld_annonceDatePub 		= 	'$new_annonceDate',
													$this->fld_annonceSignature		= 	'$new_annonceSignature',
													usr_id							= 	'$new_annonceUserId',
													$this->fld_langId				= 	'$new_annonceLang'
					 WHERE annonce_id = '$new_annonceId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de modifier l' annonce!<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;				
		}
		
		function load_annonce_by_cat($pageDest, $new_annonceCat="", $nombre='25', $more="Read more"){
		    global $thewu32_appExt, $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
			
			//Recherche du nom de la page
			/*$path_parts = pathinfo($PHP_SELF);
			$page = $path_parts["basename"];
			$pageDest = $pageDest.'&'.$this->URI_annonceCat.'='.$new_annonceCat;
			$pageDest = $pageDest.'-'.$new_annonceCat;*/
			
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl_where1($this->tbl_annonce, $this->fld_annonceId, $this->fld_annonceCatId, $new_annonceCat);
			
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
			
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->affichepage_cat($nombre, $pageDest, $total, $new_annonceCat);
				
		 	$query 		= 	"SELECT $this->fld_annonceId, $this->fld_annonceCatId, annonce_title, annonce_lib, $this->fld_annonceDatePub FROM $this->tbl_annonce WHERE display='1' AND $this->fld_annonceCatId='$new_annonceCat' ORDER BY $this->fld_annonceDatePub DESC LIMIT ".$limite.",".$nombre;
		  	$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
		  	if($total = mysqli_num_rows($result)){
				$num	= 0;
				//$toRet 	= $nav_menu;
				$toRet	= $nav_menu."<div class=\"clrBoth\"></div><div style=\"float:left; width:600px; height:25px; background:url(modules/annonce/img/bg/babillard_top.png) top no-repeat;\"></div>
						   <div style=\"float:left; width:550px; padding:0 10px 20px 40px; background:url(modules/annonce/img/bg/babillard_middle.png) top repeat-y;\">";
				while($row = mysqli_fetch_array($result)){
					$num++;
					$last_lineBehaviour = (($num == $total) ? ("") : ('border-bottom:#ccc dashed 1px;'));
					//Obtenir les libelles des categories
					$categorie 	= $this->get_annonce_cat_by_id($row[1]);
					//Convertir la date
					$date		= $row[4];
					//Alternet les css
					$currentCls = ((($num%2)==0) ? ("annonceEven") : ("annonceOdd"));
					
					/*$toRet .="<li class=\"$currentCls\" style=\"list-style-type:none; margin-bottom:10px; $last_lineBehaviour\" >
								<div class=\"annonce_date\">$date</div>
								<div class=\"annonce_title\">$row[2]</div>
								<div class=\"annonce_lib\">".strip_tags($this->chapo($row[3], 150))."</div>
								<div class=\"annonce_link\"><a href=\"".$pageDest.$this->uri_page_separator[0].$this->uri_page_view[1].$this->uri_page_separator[0].$row[0].$thewu32_appExt."\">$more</a></div>
							  </li>";
					*/
					
					$toRet .="<li style=\"text-indent:none; background-color:#c1c1c1; padding: 10px;\" class=\"borderedbox $currentCls\" style=\"list-style-type:none; margin-bottom:10px; $last_lineBehaviour\">
							<div class=\"annonce_date\">".$this->show_date_by_lang($date, $lang)."</div>
							<div class=\"annonce_title\">$row[2]</div>
							<div class=\"annonce_lib\">".strip_tags($this->chapo($row[3], 150))."</div>
                            <span class=\"annonce_link\"><a href=\"".$this->set_mod_detail_uri($pageDest, $row[0])."\">$more</a></span>
						  </li>";
				}
				$toRet .= "</ul></div><div style=\"float:left;width:600px; height:29px; background:url(modules/annonce/img/bg/babillard_bottom.png) top no-repeat;\"></div><div class=\"clrBoth\"></div>";			
			}
		  	else{
				$toRet	= "<p>Aucun &eacute;l&eacute;ment &agrave; afficher</p>";
			}
			return $toRet.$nav_menu;
		}
		
		function arr_load_annonce_by_cat($pageDest, $new_annonceCat="", $nombre='25', $more="Read more"){
			$limite = $this->limit;
			if(!$limite) $limite = 0;
		
		
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl_where1($this->tbl_annonce, $this->fld_annonceId, $this->fld_annonceCatId, $new_annonceCat);
		
		
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
		
			//Bloc menu de liens
			if($total > $nombre)
				$nav_menu	= $this->affichepage($nombre, $pageDest, $total);
		
			$query 		= 	"SELECT * FROM $this->tbl_annonce WHERE display='1' AND $this->fld_annonceCatId='$new_annonceCat' ORDER BY $this->fld_annonceDatePub DESC LIMIT ".$limite.",".$nombre;
			$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$num		=	0;
				$id 		= 	$this->fld_annonceId;
				$title		=	$this->fld_annonceTitle;
				$descr		=	$this->fld_annonceLib;
				$author		=	$this->fld_annonceAuthor;
				$catId		=	$this->fld_annonceCatId;
				$date		=	$this->fld_annonceDatePub;
				$signature	=	$this->fld_annonceSignature;
		
				$arr_toRet	=	array();
				while($row = mysqli_fetch_array($result)){
					$num++;
					$categorie 	= $this->get_annonce_cat_by_id($row[$catId]);
					//Convertir la date
					//$date		= 	$this->date_en2($date);
					$pageUrl	=	$pageDest."-".detail."-".$row[0].".html";
					array_push($arr_toRet, array('ANNONCE_ID'=>$row[$id], 'ANNONCE_TITLE'=>$row[$title], 'ANNONCE_DESCR'=>$row[$descr], 'ANNONCE_AUTHOR'=>$row[$author], 'ANNONCE_CAT_ID'=>$row[$catId], 'ANNONCE_CAT_TITLE'=>$categorie, 'ANNONCE_DATE'=>$this->date_en2($row[$date]), 'ANNONCE_URL'=>$pageUrl));
				}
			}
			else{
				return	false;
			}
			return $arr_toRet;
		}
		
		//Compter le nombre d'annonces qu'il ya dans la table des annonces
		function count_annonces(){
			return $toRet = $this->count_in_tbl($this->tbl_annonce, $this->fld_annonceId);
		}
		
		//Building the main content of the xml spry data set
		function spry_ds_get_file_main(){
			/**
			 * @return {annonce xml content by cat}
			 *
			 * @descr : Charger les items pour le fichier xml
			 **/
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_annonce WHERE $this->fld_annonceDisplay ='1'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to extract spry item for annonce!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				while($row = mysqli_fetch_array($result)){
					$catLib	=	$this->get_annonce_cat_by_id($row[1]);
					$toRet.='<item id="'.$row[0].'" cat="'.$row[1].'">
										<cat><![CDATA['.$catLib.']]></cat>
										<date>'.$row[7].'</date>
										<title><![CDATA['.$row[3].']]></title>
										<desc><![CDATA['.$row[4].']]></desc>
										<img><![CDATA['.$row[6].']]></img>
										<signature><![CDATA['.$row[5].']]></signature>
										<attachment><![CDATA['.$row[9].']]></attachment>
										<lang>'.$row[10].'</lang>
									</item>';
				}
			}
			return $toRet;
		}
		
		function annonce_autoIncr(){
			return $this->autoIncr($this->tbl_annonce, $this->fld_annonceId);
		}
		/* function spry_ds_create(){
		 return $this->digitra_spry_xml_create($this->modName, $this->spry_ds_get_file_main());
		 } */
		//function count_
		//}
	}