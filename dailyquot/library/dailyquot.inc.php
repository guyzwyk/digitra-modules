<?php
class cwd_dailyquot extends cwd_page {
	var $tbl_dailyquot;
	var $tbl_dailyquotCat;
	var $tbl_dailyquotAuthor;
	
	var $fld_dailyquotId;
	var $fld_dailyquotCatId;
	var $fld_langId;
	
	var $fld_dailyquotDatePub;
	var $fld_dailyquotDateIns;
	var $fld_dailyquotLib;
	var $fld_dailyquotTitle;
	var $fld_dailyquotAuthorL;
	var $fld_dailyquotAuthorF;
	var $fld_dailyquotDisplay;
	var $fld_dailyquotCatLib;
	
	var $URI_dailyquot;
	var $mod_queryKey 		= 'dailyquotId';
	var $mod_fkQueryKey 	= 'catId' ;
	var $URI_dailyquotLang	= 'langId';
	
	var $admin_modPage		= '?page=dailyquot';


	public function __construct(){
        global $thewu32_tblPref;
        $this->tbl_dailyquot 			= 	$thewu32_tblPref."dailyquot";
        $this->tbl_dailyquotCat			=	$thewu32_tblPref."dailyquot_cat";
        $this->tbl_dailyquotAuthor		= 	$thewu32_tblPref."usr_detail";
        $this->modName					=	'dailyquot';
        $this->modDir					.=	$this->modName;

        $this->fld_dailyquotAuthorL		= 	"usr_detail_last";
        $this->fld_dailyquotAuthorF		= 	"usr_detail_first";
        $this->fld_dailyquotTitle		= 	'dq_reference';
        $this->fld_dailyquotAuthor		= 	'usr_id';
        $this->fld_dailyquotLib			= 	'dq_text';
        $this->fld_dailyquotDatePub		= 	'dq_date_display';
        $this->fld_dailyquotDateIns		= 	'dq_date_insert';
        $this->fld_dailyquotDisplay		=	'display';
        $this->fld_dailyquotCatLib		=	'dq_cat_lib';

        $this->fld_dailyquotId			= 	'dq_id';
        $this->fld_dailyquotCatId		=	'dq_cat_id';
        $this->fld_langId				=	'lang_id';


        $this->set_uri_dailyquot("dailyquotId");
        $this->set_uri_dailyquot_cat("catId");
    }

    function cwd_dailyquot(){
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
					  <h1>Gestion des Versets du jour</h1>
					  <ul class=\"ADM_menu_title\">
					  	<h2>Les versets</h2>
					  	<li><a href=\"?what=dailyquotDisplay\">Lister les versets du jour</a></li>
				|
						<li><a href=\"?what=dailyquotInsert\">Ins&eacute;rer un verset du jour</a></li>
					  </ul>
					  <ul>
					  	<h2>Les Cat&eacute;gories de versets</h2>
					  	<li><a href=\"?what=dailyquotCatDisplay\">Afficher les cat&eacute;gories</a></li>
				|
					  	<li><a href=\"?what=dailyquotCatInsert\">Ajouter une cat&eacute;gorie</a></li>
					  </ul>
					  <div class=\"ADM_menu_descr\"></div>
				  </div>";
		return $toRet;				  
	}
	
	/**
	 * Definir la variabe d'url pour les dailyquots
	 * 
	 * @param string $new_uriVar
	 *
	 * @return void()*/
	function set_uri_dailyquot($new_uriVar){
		return $this->URI_dailyquot = $new_uriVar;
	}
	/**
	 * Definir la variabe d'url pour les categories d'dailyquots
	 * 
	 * @param string $new_uriCatVar
	 *
	 * @return void()*/
	function set_uri_dailyquot_cat($new_uriCatVar){
		return $this->URI_dailyquotCat = $new_uriCatVar;
	}
	
	function admin_load_dailyquots($nombre='50', $limit='0'){
		global $mod_lang_output, $thewu32_cLink;
		
		$limite = $this->limit;
		if(!$limite) $limite = 0;
	
		//Recherche du nom de la page
		$path_parts = pathinfo($PHP_SELF);
		$page = $path_parts["basename"];
	
		//Obtention du total des enregistrements:
		$total = $this->count_in_tbl($this->tbl_dailyquot, $this->fld_dailyquotId);

		//Appel de la bibliotheque des users
		$myUser	=	new cwd_user();
	
	
		//V&eacute;rification de la validit&eacute; de notre variable $limite......
		$veriflimite = $this->veriflimite($limite, $total, $nombre);
		if(!$veriflimite) $limite = 0;
			
		//Bloc menu de liens
		if($total > $nombre)
			$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
			
		$query 	= "SELECT * FROM $this->tbl_dailyquot ORDER BY $this->fld_dailyquotDatePub DESC LIMIT ".$limite.",".$nombre;
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news!<br />".mysqli_error($thewu32_cLink));
		if($total = mysqli_num_rows($result)){
			$num	= 0;
			$toRet 	= $nav_menu;
			$toRet 	.= "<table class=\"table table-bordered\">
						<tr>
							<th>N&deg;</th>
							<th>".$mod_lang_output['TABLE_HEADER_DAILYQUOT_REFERENCE']."</th>
							<th>".$mod_lang_output['TABLE_HEADER_DAILYQUOT_CONTENT']."</th>
							<th>".$mod_lang_output['TABLE_HEADER_CATEGORY']."</th>
							<th>".$mod_lang_output['TABLE_HEADER_AUTHOR']."</th>
							<th>".$mod_lang_output['TABLE_HEADER_PUB-DATE']."</th>
							<th>".$mod_lang_output['TABLE_HEADER_REG-DATE']."</th>
							<th>".$mod_lang_output['TABLE_HEADER_ACTION']."</th>
						</tr>";
			while($row = mysqli_fetch_array($result)){
				$num++;
				
				//alterner les liens public / prive
				$stateImg 		= 	($row[8] == "0") 	? 	("<img src=\"img/icons/disabled.gif\" />") : 	("<img src=\"img/icons/enabled.gif\" />");
				$varUri			= 	($row[8] == "0")	?	("show")	:	("hide");
				$stateAlt		= 	($row[8] == "0")	?	($mod_lang_output['DAILYQUOT_ACTION_SHOW'])	:	($mod_lang_output['DAILYQUOT_ACTION_HIDE']);

				//Titre
				$title	=	$this->chapo(stripslashes($row[3]), 100);
				
				//Obtenir les categories
				$categorie 	= $this->get_dailyquot_cat_by_id($row[1]);
				
				//Convertir les dates
				$datePub		= 	$this->date_fr($row[4]);
				$dateIns		=	$this->datetime_fr($row[5]);
				
				//Alternet les css
				$currentCls 	= ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
				
				//Afficher les auteurs
				//$author 	= (($row[7] == '0')?("Administrateur"):($row[7]));
				$author		=	ucfirst($myUser->get_user_detail_by_user_id($myUser->fld_userDetailFirstName, $row[7]))." ".strtoupper($myUser->get_user_detail_by_user_id($myUser->fld_userDetailLastName, $row[7]));
				$author		=	($author	==	'')	?	('Unknown user')	: ($author); //Si utilisateur supprime...

				$toRet .="<tr class=\"$currentCls\">
				<th row=\"scope\" align=\"center\">$num</td>
				<td>$row[2]</td>
				<td>$title</td>
				<td>".stripslashes($categorie)."</td>
				<td>$author</td>
				<td>$datePub</td>
				<td>$dateIns</td>
				<td nowrap style=\"background-color:#FFF; text-align:center;\">
					<a title=\"".$mod_lang_output['DAILYQUOT_ACTION_UPDATE']."\" href=\"?page=dailyquot&what=update&action=update&$this->URI_dailyquot=$row[0]\"><img src=\"img/icons/edit.gif\" /></a>
					<a title=\"".$mod_lang_output['DAILYQUOT_ACTION_DELETE']."\" href=\"?page=dailyquot&what=display&action=delete&$this->URI_dailyquot=$row[0]\" onclick=\"return confirm('".$mod_lang_output['CALLOUT_DELETE_WARNING']." : $title')\"><img src=\"img/icons/delete.gif\" /></a>
					<a title=\"$stateAlt\" href=\"?page=dailyquot&what=display&action=$varUri&$this->URI_dailyquot=$row[0]\">$stateImg</a>
				</td>
					
				</tr>";
			}
			$toRet .= "</table>$nav_menu";
				
		}
		else{
		$toRet	= "Aucun &eacute;l&eacute;ment &agrave; afficher";
		}
		return $toRet;
	}
	
			function admin_cmb_show_rub_by_lang($lang="FR", $FORM_var="", $CSS_class=""){
			    global $lang_output, $thewu32_cLink;
			    if($lang   !=  'XX')
			        $query 	=  "SELECT * FROM $this->tbl_dailyquotCat WHERE $this->fld_modLang ='$lang' ORDER BY $this->fld_dailyquotCatLib";
			        else
			            $query  =  "SELECT * FROM $this->tbl_dailyquotCat ORDER BY $this->fld_dailyquotCatLib";
			            
			            $result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load dailyquot categories.<br />".mysqli_error($thewu32_cLink));
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
			
    function load_dailyquot($pageDest, $nombre='50', $more="Read more", $lang){ //Penser � rendre multilingue
	   global $thewu32_cLink;
		$limite = $this->limit;
		if(!$limite) $limite = 0;
	
		//Recherche du nom de la page
		/*$path_parts = pathinfo($PHP_SELF);
		$page = $path_parts["basename"];*/
	
		//Obtention du total des enregistrements:
		//$where = "WHERE $this->fld_langId = '$lang'";
		$total = $this->count_in_tbl_where1($this->tbl_dailyquot, $this->fld_dailyquotId, $this->fld_langId, $lang);
	
	
		//V&eacute;rification de la validit&eacute; de notre variable $limite......
		$veriflimite = $this->veriflimite($limite, $total, $nombre);
		if(!$veriflimite) $limite = 0;
			
		//Bloc menu de liens
		if($total > $nombre)
			$nav_menu	= $this->affichepage($nombre, $pageDest, $total);
				
		$query 	= "SELECT $this->fld_dailyquotId, dq_reference, dq_text, $this->fld_dailyquotDatePub FROM $this->tbl_dailyquot WHERE display='1' AND lang='$lang' ORDER BY $this->fld_dailyquotDatePub DESC LIMIT ".$limite.",".$nombre;
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load daily quotes!<br />".mysqli_error($thewu32_cLink));
			if($total = mysqli_num_rows($result)){
				$num	= 0;
				$toRet 	= "<div>$nav_menu</div>";
				$toRet	.= "<ul class=\"dailyquot\">";
				while($row = mysqli_fetch_array($result)){
					$num++;
					$last_lineBehaviour = (($num == $total) ? ("") : ('border-bottom:#ccc dashed 1px;'));
			
					//Convertir la date
					$datePub		= $this->date_fr($row[3]);
					//Alternet les css
					$currentCls = ((($num%2)==0) ? ("dailyquotEven") : ("dailyquotOdd"));
	
					$toRet .="<li style=\"margin-left:0; padding-left:0;\" class=\"$currentCls\" style=\"list-style-type:none; margin-bottom:10px; $last_lineBehaviour\">
					<div class=\"dailyquot_date\">$datePub</div>
					<div class=\"dailyquot_title\">$row[1]</div>
					<div class=\"dailyquot_lib\">".strip_tags($this->chapo($row[2], 150))."</div>
					<!-- <div class=\"dailyquot_link\"><a href=\"".$pageDest."&".$this->URI_dailyquot."=".$row[0]."&view=detail\">$more</a></div> -->
							<div class=\"dailyquot_link\"><a href=\"".$pageDest."-".$row[0]."-"."detail.html"."\">$more</a></div>
								</li>";
				}
				$toRet .= "</ul><div>$nav_menu</div><p>&nbsp;</p>";
				
			}
			else{
				$toRet	= "<p>Aucun &eacute;l&eacute;ment &agrave; afficher</p>";
			}
			return $toRet;
	}
	
	function admin_load_dailyquots_cat(){
		global $mod_lang_output, $thewu32_cLink;
		
		$query 	= "SELECT * FROM $this->tbl_dailyquotCat ORDER BY '$this->fld_dailyquotCatId'";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news categories!<br />".mysqli_error($thewu32_cLink));
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
				<th row=\"scope\" align=\"center\">$num</th>
				<td>$row[1]</td>
				<!-- <td>$row[2]</td> -->
				<td style=\"text-align:center; background:#fff;\">
				<a title=\"".$lang_output['TABLE_TOOLTIP_UPDATE']."\" href=\"?page=dailyquot&what=catDisplay&action=catUpdate&catId=$row[0]\"><img src=\"img/icons/edit.gif\" /></a> 
				<a title=\"".$lang_output['TABLE_TOOLTIP_DELETE']."\" href=\"?page=dailyquot&what=catDisplay&action=catDelete&catId=$row[0]\" onclick=\"return confirm('".$mod_lang_output['CALLOUT_CAT_DELETE_WARNING']."')\"><img src=\"img/icons/delete.gif\" /></a>
				</td>
				</tr>";
			}
			$toRet .="</table>";
		
		}
			else{
			$toRet	= "<p>Aucune Cat&eacute;gorie &agrave; afficher</p>";
		}
		return $toRet;
	}
	
	function load_dailyquot_cat($pageDest="dailyquot.php", $errMsg="", $lang){
	    global $thewu32_cLink;
    	$query 	= "SELECT * FROM $this->tbl_dailyquotCat WHERE lang = '$lang' ORDER BY dq_cat_lib";
    	$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load dailyquots categories.<br />".mysqli_error($thewu32_cLink));
    		if($total = mysqli_num_rows($result)){
    			$toRet = "<ul class=\"nav\">";
    			while($row = mysqli_fetch_array($result)){
    			//$toRet .= "<li><a href=\"$pageDest"."&".$this->URI_dailyquotCat."=".$row[0]."\">$row[1]</a></li>";
    				$toRet .= "<li>".$this->toggle_icon($this->mod_catIcon)."<a href=\"$pageDest"."-".$row[0].".html\">$row[1]</a></li>";
    			}
    			$toRet .="</ul>";
    			}
    			else{
    			$toRet = $errMsg;
    	}
    	return $toRet;
	}
	
	//Load the quote of the day
	function load_actual_dailyquot($pageDetail, $more="Plus de detail", $lang="FR"){
		if($tab_dqActual	=	$this->get_actual_dailyquot($lang))
			$toRet	= "<strong>$tab_dqActual[dailyquotTITLE]</strong><br />	&laquo;".$this->chapo($tab_dqActual[dailyquotCONTENT], 80)."&raquo<br />&raquo; <a href=\"$pageDetail".",".$tab_dqActual[dailyquotID]."-"."detail.html\">$more</a>";
		else 
			$toRet	= "Aucun extrait biblique &agrave; afficher pour le moment...<br />&raquo; <a href=\"".$pageDetail.".html\">Voir les extraits pr&eacute;c&eacute;dents</a>";
		return $toRet;
	}
	
	//Load all the previous quotes
	function load_previous_dailyquots($number=5, $page_dailyquotDetail='dailyquot_read.php', $lang='FR', $pageDailyquot='dailyquots.php'){
	    global $thewu32_cLink;
		//Les titres des dailyquots les plus recentes ds un box
		//$number = ((int)($number - 1));
		$query = "SELECT * FROM $this->tbl_dailyquot WHERE dq_date_display < '".$this->get_date()."' AND display = '1' AND lang='$lang' ORDER BY dq_date_display DESC LIMIT 0, $number";
		$result = mysqli_query($thewu32_cLink, $query) or die("Unable to load previous quotes!!<br />".mysqli_error($thewu32_cLink));
		if($total = mysqli_num_rows($result)){
			//$dailyquots_link = "<p>&raquo;<a class=\"box_link\" href=\"$pagedailyquot\">Toutes les dailyquots</a></p>";
			$id 	= $this->fld_dailyquotId;
			$toRet 	= ""; //"<ul>";
			while($row = mysqli_fetch_array($result)){
				$toRet	.= "<p class=\"dailyquot_recent\">
				<!-- <a class=\"dailyquot_link\" href=\"$page_dailyquotDetail&$this->URI_dailyquot=".$row[$id]."&view=detail\"><strong>".$this->date_fr($row["dq_date_pub"])." - </strong>".$row["dailyquot_title"]."</a> -->
				<a class=\"dailyquot_link\" href=\"$page_dailyquotDetail".",".$row[$id]."-"."detail.html\"><span style=\"font-weight:bold; color:#E36917\">".$this->date_fr($row[4])." - </span><strong>".$row[2]."</strong><br />".$this->chapo($row[3], 100)."</a>
						  	</p>";
			}
		}
		else{
			$toRet = "<p class=\"dailyquot_recent\">Aucun extrait biblique &agrave; afficher!!</p><p>".$this->br(10)."</p>";
		}
		return $toRet; //."</ul>";
	}
	
	function load_dailyquot_by_cat($pageDest, $new_dailyquotCat="", $nombre='25', $more="Read more"){
	    global $thewu32_cLink;
		$limite = $this->limit;
		if(!$limite) $limite = 0;
			
		//Recherche du nom de la page
		/*$path_parts = pathinfo($PHP_SELF);
		 $page = $path_parts["basename"];
		 $pageDest = $pageDest.'&'.$this->URI_dailyquotCat.'='.$new_dailyquotCat;
		 $pageDest = $pageDest.'-'.$new_dailyquotCat;*/
			
		//Obtention du total des enregistrements:
		$total = $this->count_in_tbl_where1($this->tbl_dailyquot, $this->fld_dailyquotId, $this->fld_dailyquotCatId, $new_dailyquotCat);
			
			
		//V&eacute;rification de la validit&eacute; de notre variable $limite......
		$veriflimite = $this->veriflimite($limite, $total, $nombre);
		if(!$veriflimite) $limite = 0;
			
		//Bloc menu de liens
		if($total > $nombre)
			$nav_menu	= $this->affichepage($nombre, $pageDest, $total);
	
		$query 		= 	"SELECT $this->fld_dailyquotId, $this->fld_dailyquotCatId, dq_reference, dq_text, $this->fld_dailyquotDatePub FROM $this->tbl_dailyquot WHERE $this->fld_dailyquotDatePub < '".$this->get_date()."' AND display='1' AND $this->fld_dailyquotCatId='$new_dailyquotCat' ORDER BY $this->fld_dailyquotDatePub DESC LIMIT ".$limite.",".$nombre;
		$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_error($thewu32_cLink));
		if($total = mysqli_num_rows($result)){
			$num	= 0;
			$toRet 	= $nav_menu;
			$toRet	.= "<div class=\"dailyquot\">";
			while($row = mysqli_fetch_array($result)){
				$num++;
				//$last_lineBehaviour = (($num == $total) ? ("") : ('border-bottom:#ccc dashed 1px;'));
				//Obtenir les libelles des categories
				$categorie 	= $this->get_dailyquot_cat_by_id($row[1]);
				//Convertir la date
				$date		= $this->date_fr($row[4]);
				//Alternet les css
				$currentCls = ((($num%2)==0) ? ("dailyquotEven") : ("dailyquotOdd"));
					
				$toRet .="<p class=\"$currentCls\"><span style=\"font-weight:bold; color:#E36917\">$date</span> - <strong>$row[2]</strong><br />".strip_tags($this->chapo($row[3], 150))."
								<span class=\"dailyquot_link\"><a href=\"".$pageDest.",".$row[0]."-"."detail.html"."\">$more</a></span>
						</p>";
			}
			$toRet .= "</div>$nav_menu<p>&nbsp;</p>";
		}
		else{
			$toRet	= "<p>Aucun &eacute;l&eacute;ment &agrave; afficher".$this->br(15)."</p>";
			}
			return $toRet;
	}
	
	
	
	/* Updaters */
	
	function update_dailyquot($new_dailyquotId, $new_dailyquotCatId, $new_dailyquotTitle, $new_dailyquotLib, $new_dailyquotDatePub, $new_dailyquotLang, $new_dailyquotUserId){
	    global $thewu32_cLink;
		$query = "UPDATE $this->tbl_dailyquot 	SET 	$this->fld_dailyquotCatId 	= 	'$new_dailyquotCatId',
														dq_reference				= 	'$new_dailyquotTitle',
														dq_text						= 	'$new_dailyquotLib',
														dq_date_display				= 	'$new_dailyquotDatePub',
														lang_id						= 	'$new_dailyquotLang',
														usr_id						= 	'$new_dailyquotUserId'
		WHERE 	$this->fld_dailyquotId = '$new_dailyquotId'";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to update daily quotes!<br />".mysqli_error($thewu32_cLink));
		if($result)
			return true;
		else
			return false;
	}
	
	
	function update_dailyquot_cat($new_dailyquotCatId, $new_dailyquotCatLib, $new_dailyquotCatLang){
	    global $thewu32_cLink;
		$query = "UPDATE $this->tbl_dailyquotCat SET  dq_cat_lib	= '$new_dailyquotCatLib', $this->fld_modLang = '$new_dailyquotCatLang'
		WHERE 	$this->fld_dailyquotCatId = '$new_dailyquotCatId'";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to update daily quotes categories!<br />".mysqli_error($thewu32_cLink));
		if($result)
			return true;
		else
			return false;
	}
	
	/*Mettre a jour n'importe kel champ de la table des dailyquot sachant l'id*/
	function dailyquot_element_update($new_fldDailyquot, $new_valDailyquot, $new_dailyquotId){
		return	$this->update_entry_by_id($this->tbl_dailyquot, $this->fld_dailyquotId, $new_fldDailyquot, $new_valDailyquot, $new_dailyquotId);
	}
	
	
	
	
	/* Setters */
	
	//Inserer une dailyquot dans la BDD
	function dailyquot_insert($new_dailyquotCatId, $new_dailyquotTitle, $new_dailyquotLib, $new_dailyquotDatePub, $new_dailyquotDateInsert, $new_dailyquotLang, $new_dailyquotUserId){
		return $this->set_dailyquot($new_dailyquotCatId, $new_dailyquotTitle, $new_dailyquotLib, $new_dailyquotDatePub, $new_dailyquotDateInsert, $new_dailyquotLang, $new_dailyquotUserId);
	}
	
	//Inserer une categorie d'dailyquot dans la BDD
	function dailyquot_cat_insert($new_catId, $new_catLib, $new_catLang){
		return $this->set_dailyquot_cat($new_catId, $new_catLib, $new_catLang);
	}
	
	/**
	 * Ins&eacute;rer une dailyquot dans la bdd par l'utilisateur $newUserId
	 *
	 * @return true si le dailyquot est ins&eacute;r&eacute;e, false sinon.
	 */
	function set_dailyquot($new_dailyquotCatId, $new_dailyquotTitle, $new_dailyquotLib, $new_dailyquotDatePub, $new_dailyquotDateInsert, $new_dailyquotLang, $new_dailyquotUserId){
	    global $thewu32_cLink;
		$query = "INSERT INTO $this->tbl_dailyquot VALUES('".$this->dailyquot_autoIncr()."', '$new_dailyquotCatId', '$new_dailyquotTitle', '$new_dailyquotLib', '$new_dailyquotDatePub', '".$this->get_datetime()."', '$new_dailyquotLang', '$new_dailyquotUserId', '0')";
		$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'ajouter les citations!<br />".mysqli_error($thewu32_cLink));
		if($result)
			return true;
		else
			return false;	
	}
	
	function set_dailyquot_cat($new_catId, $new_catLib, $new_catLang='FR'){
	    global $thewu32_cLink;
		$query = "INSERT INTO $this->tbl_dailyquotCat VALUES('$new_catId', '$new_catLib', '$new_catLang')";
		$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'ajouter les cat&eacute;gories de daily quotes!<br />".mysqli_error($thewu32_cLink));
		if($result)
			return true;
		else
			return false;
	}
		
	/*Rendre public/prive une categorie*/
	function set_rub_state($new_dailyquotCatId, $new_stateId){
		return $this->set_updated_1($this->tbl_dailyquotCat, "display", $new_stateId, $this->fld_dailyquotCatId, $new_dailyquotCatId);
	}
	
	/*Rendre public/prive une dailyquot*/
	function set_dailyquot_state($new_dailyquotId, $new_stateId){
		return $this->set_updated_1($this->tbl_dailyquot, "display", $new_stateId, $this->fld_dailyquotId, $new_dailyquotId);
	}
	
	/*Rendre public/prive une rubrique*/
	function set_dailyquotcat_state($new_dailyquotCatId, $new_stateId){
		return $this->set_updated_1($this->tbl_dailyquotCat, "display", $new_stateId, $this->fld_dailyquotCatId, $new_dailyquotCatId);
	}
	
	/*Supprimer une dailyquot*/
	function del_dailyquot($new_dailyquotId){
		return $this->rem_entry($this->tbl_dailyquot, $this->fld_dailyquotId, $new_dailyquotId);
	}
	
	/**
	 * Supprimer une categorie en cascade:
	 * Entraine une suppression en cascade dans les tables mï¿½re et fille
	 *
	 * @param int $new_dailyquotCatId
	 * @return true or false*/
	function cascadel_dailyquot_cat($new_dailyquotCatId){
		if($this->cascadel($this->tbl_dailyquotCat, $this->tbl_dailyquot, $this->fld_dailyquotCatId, $new_dailyquotCatId))
			return true;
		else
			return false;
	}
	
	/*Supprimer une dailyquot*/
	function del_dailyquot_cat($new_dailyquotCatId){
		return $this->rem_entry($this->tbl_dailyquotCat, $this->fld_dailyquotCatId, $new_dailyquotCatId);
	}
	
	
	
	/* Getters */
	
	function get_actual_dailyquot($currentLang='FR'){
	    global $thewu32_cLink;
		$query 		= 	"SELECT * FROM $this->tbl_dailyquot WHERE ($this->fld_modLang ='$currentLang' OR $this->fld_modLang ='XX') AND dq_date_display = '".$this->get_date()."' AND display='1'";
		$result 	= 	mysqli_query($thewu32_cLink, $query) or die("Impossible de charger la citation du jour!<br />".mysqli_error($thewu32_cLink));
		if($total	=	mysqli_num_rows($result)){
			while($row = mysqli_fetch_row($result)){
				$toRet	= array('dailyquotID'		=> 	$row[0],
								'dailyquotCATID'	=> 	$row[1],
								'dailyquotTITLE'	=> 	$row[2],
								'dailyquotCONTENT'	=> 	$row[3],
								'dailyquotDATEPUB'	=> 	$row[4],
								'dailyquotDATEINS'	=> 	$row[5],
								'dailyquotLANG'		=> 	$row[6],
								'dailyquotUSRID'	=> 	$row[7],
								'dailyquotLANGID'	=> 	$row[8]);
			}
			return $toRet;			
		}
		else
			return false;
	}
	
	
	function get_dailyquot_cat_by_id($new_dailyquotCatId){
		return $this->get_field_by_id($this->tbl_dailyquotCat, $this->fld_dailyquotCatId, "dq_cat_lib", $new_dailyquotCatId);
	}
	
	function get_dailyquot_cat($new_dailyquotCatId){
	    global $thewu32_cLink;
		$query = "SELECT * FROM $this->tbl_dailyquotCat WHERE $this->fld_dailyquotCatId = '$new_dailyquotCatId'";
		$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger la cat&eacute;gorie de citations!<br />".mysqli_error($thewu32_cLink));
		if($total = mysqli_num_rows($result)){
			while($row = mysqli_fetch_row($result)){
				$toRet = array(
						"dailyquotCATID"		=> $row[0],
						"dailyquotCATLIB"		=> $row[1],
						"dailyquotCATLANG"		=> $row[2]
				);
			}
			return $toRet;
		}
		else
			return false;
	}
	
	/**
	 * Ressortir l'enregistrement li&eacute; ï¿½ une dailyquot
	 *
	 * @return un tableau.
	 */
	function get_dailyquot($new_dailyquotId){
	    global $thewu32_cLink;
		$query = "SELECT * FROM $this->tbl_dailyquot WHERE dq_id = '$new_dailyquotId'";
		$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger la citation du jour!<br />".mysqli_error($thewu32_cLink));
		if($total = mysqli_num_rows($result)){
			while($row = mysqli_fetch_row($result)){
				$toRet = array(
						"dailyquotID"			=> $row[0],
						"dailyquotCATID"		=> $row[1],
						"dailyquotTITLE"		=> $row[2],
						"dailyquotLIB"			=> $row[3],
						"dailyquotDATEPUB"		=> $row[4],
						"dailyquotDATEINS"		=> $row[5],
						"dailyquotLANG"			=> $row[6],
						"userID"				=> $row[7],
						"dailyquotDISPLAY"		=> $row[8]
				);
			}
			return $toRet;
		}
		else
			return false;
	}
	
	/**
	 * Afficher les rubriques dans un combobox, toutes les rubriques (Utile pour l'espace d'admin).
	 *
	 * @param $FORM_var 	: La variable de formulaire, pour fixer la valeur choisie, en cas d'erreur dans le formulaire qui entrainerait le rechargement de la page
	 * @param $CSS_class 	: La classe CSS a utiliser pour enjoliver la presentation
	 */
	function admin_cmb_show_rub($FORM_var="", $CSS_class=""){
	    global $thewu32_cLink;
		$query 	= "SELECT * FROM $this->tbl_dailyquotCat ORDER BY dq_cat_lib";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load daily quotes categories.<br />".mysqli_error($thewu32_cLink));
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
	
	function count_dailyquots(){
		return $toRet = $this->count_in_tbl($this->tbl_dailyquot, $this->fld_dailyquotId);
	}
	
	//Building the main content of the xml spry data set
	function spry_ds_get_file_main(){
	    global $thewu32_cLink;
		/**
		 * @return {annonce xml content by cat}
		 *
		 * @descr : Charger les items pour le fichier xml
		 **/
		$query = "SELECT * FROM $this->tbl_dailyquot WHERE $this->fld_dailyquotDisplay ='1'";
		$result = mysqli_query($thewu32_cLink, $query) or die("Unable to extract spry item for dailyquot!<br />".mysqli_error($thewu32_cLink));
		if($total = mysqli_num_rows($result)){
			while($row = mysqli_fetch_array($result)){
				$catLib	=	$this->get_dailyquot_cat_by_id($row[1]);
				$toRet.='<item id="'.$row[0].'" cat="'.$row[1].'">
										<cat><![CDATA['.$catLib.']]></cat>
										<date>'.$row[4].'</date>
										<text><![CDATA['.$row[3].']]></text>
										<lang>'.$row[10].'</lang>
									</item>';
			}
		}
		return $toRet;
	}
	
	function dailyquot_autoIncr(){
		return $this->autoIncr($this->tbl_dailyquot, $this->fld_dailyquotId);
	}
}