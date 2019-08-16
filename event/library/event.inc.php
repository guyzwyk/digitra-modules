<?php
	class cwd_event extends cwd_system {
		var $tbl_event;
		var $tblEventType;
		var $tbl_eventType;
		
		var $fld_eventId;
		var $fld_eventTypeId;
		
		var $fld_eventLib;
		var $fld_eventDescr;
		var $fld_eventLang;
		var $fld_eventDisplay;
		var $fld_eventDate;
		var $fld_eventStart;
		var $fld_eventDateCrea;
		var $fld_eventEnd;
		var $fld_eventLocation;
		var $fld_eventUrl;
		var $fld_eventTypeLib;
		
		var $mod_queryKey 	= 	'pmId';
		var $URI_event;
		var $URI_eventCat	=	'catId';
		var $admin_modPage	= 	"admin.php?page=event";

		
		public function __construct(){
            global $thewu32_tblPref;
            $this->tbl_event 			= 	$thewu32_tblPref."event";
            $this->tbl_eventType		=	$thewu32_tblPref."event_type";
            $this->tblEventType 		= 	$thewu32_tblPref."event_type";

            $this->fld_eventId 			= 	'event_id';
            $this->fld_eventTypeId		= 	'event_type_id';

            $this->fld_eventLib			= 	'event_name';
            $this->fld_eventDescr		=	'event_descr';
            $this->fld_eventLang		= 	'lang_id';
            $this->fld_eventDisplay		= 	'display';
            $this->fld_eventDate		= 	'event_end';
            $this->fld_eventStart		=	'event_start';
            $this->fld_eventEnd			=	'event_end';
            $this->fld_eventDateCrea	=	'event_date_crea';
            $this->fld_eventLocation	=	'event_location';
            $this->eventUrl				=	'event_url';
            $this->fld_eventTypeLib		=	'event_type_lib';
            $this->set_uri_event('pmId');
            $this->set_uri_event_cat('catId');

            $this->modName				=	'event';
            $this->modDir				.=	$this->modName;
        }

		function cwd_event(){
			self::_construct();
		}
		
		/**
	* Menu pour l'administration du module dans l'espace agr&eacute;&eacute; &agrave; cet effet.
	* 
	* @param void()
	* @return admin menu.
	* */
	function admin_get_menu(){
		$toRet = "<div class=\"ADM_menu\">
				    <h1>Gestion des &eacute;v&eacute;nements</h1>
					<ul>
						<h2>Les &eacute;v&eacute;nements</h2>
						<li><a href=\"?what=eventDisplay\">Afficher les &eacute;v&eacute;nements</a></li>
						<li>|</li>
						<li><a href=\"?what=eventInsert\">Nouvel &eacute;v&eacute;nement</a></li>
						<!-- <li>|</li>
						<li><a href=\"?what=eventSearch\">Rechercher un &eacute;v&eacute;nement</a></li> -->
					</ul>
					<ul class=\"ADM_menu_title\">
						<h2>Types d'&eacute;v&eacute;nements</h2>
						<li><a href=\"?what=eventCatDisplay\">Lister les types d'&eacute;v&eacute;nement</a></li>
						<li>|</li>
						<li><a href=\"?what=eventCatInsert\">Nouveau type d'&eacute;v&eacute;nement</a></li>
					</ul>
				<div class=\"ADM_menu_descr\"></div>
				</div>";
		return $toRet;				  
	}
	
	/**
	 * Definir la variabe d'url pour les evenements
	 * 
	 * @param string $new_uriVar
	 *
	 * @return void()*/
	function set_uri_event($new_uriVar){
		return $this->URI_event = $new_uriVar;
	}
	/**
	 * Definir la variabe d'url pour les categories d'evennements
	 * 
	 * @param string $new_uriCatVar
	 *
	 * @return void()*/
	function set_uri_event_cat($new_uriCatVar){
		return $this->URI_eventCat = $new_uriCatVar;
	}
	
	function admin_load_events($nombre='50', $level='admin'){
		$limite = $_REQUEST[limite];
		global $thewu32_tblPref, $thewu32_cLink;
	
		//Recherche du nom de la page
		$path_parts = pathinfo($PHP_SELF);
		$page = $path_parts["basename"].'?what=eventDisplay';
			
		//Obtention du total des enregistrements:
		$total = $this->count_in_tbl($this->tbl_event, $this->fld_eventId);
			
			
		//V&eacute;rification de la validit&eacute; de notre variable $limite......
		$veriflimite = $this->veriflimite($limite, $total, $nombre);
		if(!$veriflimite) $limite = 0;
	
		//Bloc menu de liens
		if($total > $nombre)
			$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
	
		$query 	= "SELECT * FROM $this->tbl_event ORDER BY $this->fld_eventDate DESC LIMIT ".$limite.",".$nombre;
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load events!<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$num	= 0;
			$toRet 	= $nav_menu."<p>&nbsp;</p>";
			//$toRet 	.= "";
			while($row = mysqli_fetch_array($result)){
				$num++;
				//alterner les liens public / prive
				$stateImg 	= (($row[11] == 0) ? ("<img src=\"img/icons/disabled.gif\" />") : ("<img src=\"img/icons/enabled.gif\" />"));
				$varUri		= ($row[11] == "0")?("show"):("hide");
				$stateAlt	= ($row[11] == "0")?("Display the event"):("Hide the event");
					
				//Obtenir les libelles des categories
				$categorie 	= $this->get_event_cat_by_id("event_type_lib", $row[1]);
	
				//Convertir les dates
				$start		= $this->datetime_en3($row[6]);
				$end		= $this->datetime_en3($row[7]);
				$date		= $this->datetime_en3($row[9]);
	
				//Alternet les css
				$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
	
				//Determiner le nom de l'auteur sachant son id
				$ud_lastName	=	$this->get_field_by_id($thewu32_tblPref.'usr_detail', 'usr_id', 'usr_detail_last', $row[2]);
				$ud_firstName	=	$this->get_field_by_id($thewu32_tblPref.'usr_detail', 'usr_id', 'usr_detail_first', $row[2]);
				$eventAuthor	=	ucfirst($ud_firstName).' '.strtoupper($ud_lastName);
	
				$author = (($row[2] == '0')	?	("SuperUser"):($eventAuthor));
	
				//Le rendu final
				$toRet .="<tr class=\"$currentCls\">
				<th scope=\"row\" align=\"center\">$num</td>
				<td>$categorie</td>
				<td>$row[3]</td>
				<td>$author</td>
				<td>$start</td>
				<td>$end</td>
				<td>$date</td>
				<td nowrap style=\"background:#FFF\">
				<a title=\"Update the event\" href=\"?page=event&what=update&action=update&$this->URI_event=$row[0]\"><img src=\"img/icons/edit.gif\" /></a>
				<a title=\"Delete the event\" href=\"?page=event&what=display&action=delete&$this->URI_event=$row[0]\" onclick=\"return confirm('Are you sure that you want to delete the selected event?')\"><img src=\"img/icons/delete.gif\" /></a>
				<a title=\"$stateAlt\" href=\"?page=event&what=display&action=$varUri&$this->URI_event=$row[0]&limite=$limite\">$stateImg</a>
				</td>
				</tr>";
			}
			//$toRet .= "</table>".$nav_menu;
				
		}
		else{
		$toRet	= "<tr><td colspan=\"8\">No data</td></tr>";
		}
		return $toRet."</table>".$nav_menu;
	}
	
	
	
	function admin_load_events_cat(){
	    global $thewu32_cLink;
		$query 	= "SELECT * FROM $this->tblEventType ORDER BY '$this->fld_eventTypeId'";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load events types!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$num	= 0;
				$toRet 	= "";
				while($row = mysqli_fetch_array($result)){
					$num++;
					//alterner les liens public / prive
		/*$linkState	= ($row[3] == "0")?("Priv."):("Pub.");
		$varUri		= ($row[3] == "0")?("newsCatPublish"):("newsCatPrivate");
		$linkTitle	= ($row[3] == "0")?("Rendre la cat&eacute;gorie publique"):("Rendre la cat&eacute;gorie priv&eacute;e"); */
		//Alterner les css
		$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
		
		$toRet .="<tr class=\"$currentCls\">
				<th scope=\"row\" align=\"center\">$num</td>
				<td>$row[1] ($row[2])</td>
				<!-- <td>$row[3]</td> -->
				<td nowrap align=\"center\" style=\"background:#FFF\">
					
		
				<a title=\"Update the category\" href=\"?what=eventCatUpdate&action=eventCatUpdate&catId=$row[0]\"><img src=\"img/icons/edit.gif\" /></a>
				<a title=\"Delete the category\" href=\"?what=eventCatDisplay&action=eventCatDelete&catId=$row[0]\" onclick=\"return confirm('The deletion of the category shall involve that of the concerned events! Do you wish to proceed anyway?')\"><img src=\"img/icons/delete.gif\" /></a>
				</td>
				</tr>";
		}
		//$toRet .="</table>";
			
		}
		else{
		$toRet	= "<tr><td colspan=\"3\">No data</td></tr>";
		}
		return $toRet."</table>";
	}
	
	/**
	 * Afficher les rubriques dans un combobox, toutes les rubriques (Utile pour l'espace d'admin).
	 *
	 * @param $FORM_var 	: La variable de formulaire, pour fixer la valeur choisie, en cas d'erreur dans le formulaire qui entrainerait le rechargement de la page
	 * @param $CSS_class 	: La classe CSS a utiliser pour enjoliver la presentation
	*/
	function admin_cmb_show_rub($FORM_var="", $CSS_class=""){
	    global $thewu32_cLink;
		$query 	= "SELECT * FROM $this->tblEventType ORDER BY event_type_lib";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load events' categories.<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$toRet = "";
			//if($FORM_var	== )
			while($row = mysqli_fetch_array($result)){
				$selected = ($FORM_var == $row[0])?("SELECTED"):("");
				$toRet .= "<option value=\"$row[0]\"$selected>$row[1] ($row[2])</option>";
			}
		}
		else{
			$toRet = "<option>Aucun type d'&eacute;v&eacute;nement &agrave; afficher</option>";
		}
		return $toRet;
	}
	
	function admin_cmb_show_rub_by_lang($lang="FR", $FORM_var="", $CSS_class=""){
	    global $lang_output, $thewu32_cLink;
	    if($lang   !=  'XX')
	        $query 	=  "SELECT * FROM $this->tblEventType WHERE $this->fld_modLang ='$lang' ORDER BY event_type_lib";
	    else 
	        $query  =  "SELECT * FROM $this->tblEventType ORDER BY event_type_lib";
	    
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load events' categories.<br />".mysqli_connect_error());
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
	
	/*function load_event($new_pageDest, $newNbr, $newMore, $newLang, $newNo){
		return $this->display_event($new_pageDest, $newNbr, $newMore, $newLang, $newNo);
	}*/
	
	//Afficher les evenements de page en page
	function load_event($pageDest, $nombre='25', $more='read more', $lang='FR', $noEvent=''){
		global $mod_lang_output, $thewu32_cLink;
		
		$limite = $this->limit;
		if(!$limite) $limite = 0;
			
		//Obtention du total des enregistrements:
		//$total = $this->count_in_tbl_where1($this->tbl_event, $this->fld_eventId, $this->fld_eventDisplay, '1');
		$total = $this->count_in_tbl_where2_lang($this->tbl_event, $this->fld_eventId, $this->fld_eventDisplay, $this->fld_modLang, '1', $lang);
		
			
		//V&eacute;rification de la validit&eacute; de notre variable $limite......
		$veriflimite = $this->veriflimite($limite, $total, $nombre);
		if(!$veriflimite) $limite = 0;
			
		//Bloc menu de liens
		if($total > $nombre) 
			$nav_menu	= $this->affichepage($nombre, $pageDest, $total);		  			
						
		$query 		= 	"SELECT * FROM $this->tbl_event WHERE ($this->fld_modLang='$lang' OR $this->fld_modLang = 'XX') AND $this->fld_modDisplay ='1' ORDER BY event_start DESC LIMIT ".$limite.",".$nombre;
		$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les &eacute;v&eacute;nements.<br />".mysqli_connect_error());
		if($total_1	= 	mysqli_num_rows($result)){
			$num	= 0;
			$toRet = $nav_menu."<div class=\"events\">";
			//$pageDest .= '&view=detail';
			
			//$pageDest .= '-detail';
			while($row = mysqli_fetch_row($result)){
				$num++;
				//Alternate row
		  		//$cssAlt	= ((($num % 2) == 0) ? ("newsEven") : ("newsOdd"));
		  		$last_lineBehaviour = (($num == $total) ? ("") : ('border-bottom:#ccc dashed 1px;'));
		  		//$dateEvent	= ($lang=='FR') ? ($this->datetime_to_datefr2($row[6])) : ($this->datetime_to_dateen2($row[6]));
		  		$id	          =   $row[0];
		  		$dateEvent    =   $row[6];
		  		$toRet .= "<div class=\"event_element\">
			  					<div class=\"event_element_title\"><span style=\"color:#fa2365;\">".$this->show_datetime_by_lang($dateEvent, $lang)." :</span> ".$row[3]."</div>
			  					<div class=\"event_element_descr\">".strip_tags($this->chapo($row[4], 120))."</div>
		  						&raquo;<a href=\"".$this->set_mod_detail_uri($pageDest, $id)."\">$more</a>
		  						<div class=\"clear_both\"></div>
		  				   </div>";
		  	}
		  	$toRet .= "<div class=\"clear_both\"></div></div>$nav_menu";
		 }
		 else{
		  	$toRet = "<p>$noEvent</p>";	
		 }
		 return $toRet;
	}
	
	function arr_load_events($pageDest, $nombre='25', $more='read more', $lang='EN', $noEvent=''){
	    global $thewu32_cLink;
		$limite = $this->limit;
		if(!$limite) $limite = 0;
			
		//Obtention du total des enregistrements:
		//$total = $this->count_in_tbl_where1($this->tbl_event, $this->fld_eventId, $this->fld_eventDisplay, '1');
		$total = $this->count_in_tbl_where2($this->tbl_event, $this->fld_eventId, $this->fld_eventDisplay, $this->fld_eventLang, '1', $lang);
	
			
		//V&eacute;rification de la validit&eacute; de notre variable $limite......
		$veriflimite = $this->veriflimite($limite, $total, $nombre);
		if(!$veriflimite) $limite = 0;
			
		//Bloc menu de liens
		if($total > $nombre)
			$nav_menu	= $this->affichepage2($nombre, $pageDest, $total);
	
		$query 		= 	"SELECT * FROM $this->tbl_event WHERE $this->fld_eventLang='$lang' AND display='1' ORDER BY event_start DESC LIMIT ".$limite.",".$nombre;
		$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les &eacute;v&eacute;nements.<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$id 		= 	$this->fld_eventId;
			$catId		=	$this->fld_eventTypeId;
			$title		=	$this->fld_eventLib;
			$descr		=	$this->fld_eventDescr;
			$userId		=	'user_id';
			$location	=	$this->fld_eventLocation;
			$start		=	$this->fld_eventStart;
			$end		=	$this->fld_eventEnd;
			$dateCrea	=	$this->fld_eventDateCrea;
			$url		=	$this->fld_eventUrl;
				
			$arr_toRet	=	array();
			while($row 	= 	mysqli_fetch_array($result)){
				$catTitle	=	$this->get_event_cat_by_id($this->fld_eventTypeLib, $row[$catId]);
				$pageUrl	=	$pageDest."-detail-".$row[$id].".html";
				array_push($arr_toRet, array('EVENT_ID'=>$row[$id],
				'EVENT_TITLE'=>$row[$title],
				'EVENT_DESCR'=>$this->chapo($row[$descr], 100),
				'EVENT_USER_ID'=>$row[$author],
				'EVENT_CAT_ID'=>$row[$catId],
				'EVENT_CAT_TITLE'=>$catTitle,
				'EVENT_DATE'=>$row[$date],
				'EVENT_START'=>$row[$start],
				'EVENT_END'=>$row[$end],
				'EVENT_LOCATION'=>$row[$location],
				'EVENT_LINK'=>$row[$url],
				'EVENT_URL'=>$pageUrl));
			}
		}
		else{
			$arr_toRet	= false;
		}
		return $arr_toRet;
	}
	
	
	function arr_load_event_by_cat($pageDest, $new_eventCatId, $nombre='100', $more='read more', $lang='EN', $noEvent=''){
	    global $thewu32_cLink;
		$limite = $this->limit;
		if(!$limite) $limite = 0;
			
		//Obtention du total des enregistrements:
		//$total = $this->count_in_tbl_where1($this->tbl_event, $this->fld_eventId, $this->fld_eventDisplay, '1');
		$total	=	$this->count_in_tbl_where33($this->tbl_event, $this->fld_eventId, $this->fld_eventTypeId, $new_eventCat, $this->fld_eventLang, $lang, $this->fld_eventDisplay, '1');
	
			
		//V&eacute;rification de la validit&eacute; de notre variable $limite......
		$veriflimite = $this->veriflimite($limite, $total, $nombre);
		if(!$veriflimite) $limite = 0;
			
		//Bloc menu de liens
		if($total > $nombre)
			$nav_menu	= $this->affichepage2($nombre, $pageDest, $total);
	
		$query 		= 	"SELECT * FROM $this->tbl_event WHERE $this->fld_eventTypeId='$new_eventCatId' AND $this->fld_eventLang='$lang' AND display='1' ORDER BY event_start DESC LIMIT ".$limite.",".$nombre;
		$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les &eacute;v&eacute;nements.<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$id 		= 	$this->fld_eventId;
			$catId		=	$this->fld_eventTypeId;
			$title		=	$this->fld_eventLib;
			$descr		=	$this->fld_eventDescr;
			$userId		=	'user_id';
			$location	=	$this->fld_eventLocation;
			$start		=	$this->fld_eventStart;
			$end		=	$this->fld_eventEnd;
			$dateCrea	=	$this->fld_eventDateCrea;
			$url		=	$this->fld_eventUrl;
	
			$arr_toRet	=	array();
			while($row 	= 	mysqli_fetch_array($result)){
				$catTitle	=	$this->get_event_cat_by_id($this->fld_eventTypeLib, $row[$catId]);
				$pageUrl	=	$pageDest."-detail-".$row[$id].".html";
				array_push($arr_toRet, array('EVENT_ID'=>$row[$id],
				'EVENT_TITLE'=>$row[$title],
				'EVENT_DESCR'=>$row[$descr],
				'EVENT_USER_ID'=>$row[$author],
				'EVENT_CAT_ID'=>$row[$catId],
				'EVENT_CAT_TITLE'=>$catTitle,
				'EVENT_DATE'=>$row[$date],
				'EVENT_START'=>$row[$start],
				'EVENT_END'=>$row[$end],
				'EVENT_LOCATION'=>$row[$location],
				'EVENT_LINK'=>$row[$url],
				'EVENT_URL'=>$pageUrl));
			}
		}
		else{
			$arr_toRet	= false;
		}
		return $arr_toRet;
	}
	
	/*Rendre public/prive une categorie*/
	function set_rub_state($new_eventTypeId, $new_stateId){
		return $this->set_updated_1('$this->tblEventType', "display", '$new_stateId', '$this->fld_eventTypeId', '$new_eventTypeId');
	}
		
		/**
		* Cr�er un nouveau type d'�v�nement
		*/
	function set_event_type($new_eventTypeId, $new_eventTypeLib, $new_eventLang){
	    global $thewu32_cLink;
		$query = "INSERT INTO $this->tblEventType VALUES('$new_eventTypeId', '$new_eventTypeLib', '$new_eventLang')";
		$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de cr&eacute;er le type d'&eacute;v&eacute;nement...<br />".mysqli_connect_error());
		if($result)
			return true;
		else
			return false;
	}
		
		/**
		* Cr�er un nouvel �v�nement
		*/
		function set_event($new_eventTypeId,
						  $new_eventOwner,
				  		  $new_eventName, 
						  $new_eventDescr, 
						  $new_eventLocation, 
						  $new_eventStart,
						  $new_eventEnd,
						  $new_eventUrl,
						  $new_eventLang
		    ){
		    global $thewu32_cLink;
			$dateCrea	= $this->get_datetime();
			//$new_eventId	=	$this->count_in_tbl($this->tbl_event, $this->fld_eventId) + 1;
			$query = "INSERT INTO $this->tbl_event VALUES('".$this->event_autoIncr()."',
														  '$new_eventTypeId',
														  $new_eventOwner,
												  		  '$new_eventName', 
														  '$new_eventDescr', 
														  '$new_eventLocation', 
														  '$new_eventStart',
														  '$new_eventEnd',
														  '$new_eventUrl',
														  '$dateCrea',
														  '$new_eventLang',
														  '0')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de cr&eacute;er l'&eacute;v&eacute;nement...<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}
		
		function delete_event($new_eventId){
			/*
			* Supprimer un �v�nement
			*
			* @param : $new_eventId = id de l'�v�nement � supprimer
			*/
			return $this->rem_entry($this->tbl_event, "event_id", $new_eventId);
		}
		
		/*Suppression des categories*/
		function delete_event_cat($new_eventCatId){
			return $toRet = $this->cascadel($this->tblEventType, $this->tbl_event, $this->fld_eventTypeId, $new_eventCatId);
		}
		
		/*function get_event_by_date($date_mysql){
			$query = "SELECT * FROM $this->tbl_event WHERE event_start = '$date_mysql'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'effectuer la req�te");
			toto
		}*/
		
		function get_event($new_eventId){
		    global $thewu32_cLink;
			/*
			* Nous permet d'acc�der � un enregistrement gr�ce aux tableaux associatifs
			*
			* @param : $new_eventId = l'�v�nement � afficher
			*/
			$query 	= "SELECT * FROM $this->tbl_event WHERE event_id = '$new_eventId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'afficher l'&eacute;v&eacute;nement...<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				while($row = mysqli_fetch_row($result)){
					$toRet = array(
								   "eventID"		=> $row[0],
								   "eventTYPEID"	=> $row[1],
								   "eventOWNER"		=> $row[2],
								   "eventNAME"		=> $row[3],
								   "eventDESCR"		=> $row[4],
								   "eventLOCATION"	=> $row[5],
								   "eventSTART"		=> $row[6],
								   "eventEND"		=> $row[7],
								   "eventURL"		=> $row[8],
								   "eventDATECREA"	=> $row[9],
					               "eventLANG"      => $row[10],
								   "eventDISPLAY"	=> $row[11]
								   );
				}
				return $toRet;
			}
			else
				return false;
		}
		
		function get_event_by_id($fldToGet, $valId){
			/*
			* Obtenir la valeur d'un champ de la table des memos sachant son id
			* Raccourci pour get_field_by_id()
			*
			* @param : $fldToGet = Champ � interroger
			* @param : $valId	= Valeur � mettre � jour dans le champ interrog� $fldToGet
			*/
			return $this->get_field_by_id($this->tbl_event, "event_id", $fldToGet, $valId);
		}
		
		function update_event($new_eventId,
							  $new_eventTypeId,
						  	  $new_eventOwner,
							  $new_eventName, 
							  $new_eventDescr, 
							  $new_eventLocation, 
							  $new_eventStart,
							  $new_eventEnd,
							  $new_eventUrl,
							  $new_eventLang
		    ){
		    global $thewu32_cLink;
			$query = "UPDATE $this->tbl_event SET event_type_id 	= '$new_eventTypeId',
												 user_id 		= '$new_eventOwner',
												 event_name		= '$new_eventName', 
												 event_descr	= '$new_eventDescr', 
												 event_location	= '$new_eventLocation', 
												 event_start	= '$new_eventStart',
												 event_end		= '$new_eventEnd',
												 event_url		= '$new_eventUrl',
												 lang_id		= '$new_eventLang'
						WHERE event_id = '$new_eventId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible mettre l'&eacute;v&eacute;nement &agrave; jour...<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}
		
		function update_event_by_field($fldToUpdate, $valUpdate, $new_eventId){
			/*
			* Mettre � jour n'importe kel champ de la table des evenements, en sachant juste le nom du champ et l'id pivot
			* @param : $fldToUpdate = Champ � mettre � jour
			* @param : $valUpdate	= Nouvelle valeur saisie par l'user
			* @param : $new_eventId  = l'Id � circonscrire
			*/
			return $this->update_entry_by_id($this->tbl_event, "event_id", $fldToUpdate, $valUpdate, $new_eventId);
		}
		
		function load_event_id(){
			/*
			* Affiche les ids des �v�nements
			*/
			return $this->load_id($this->tbl_event, "event_id");			
		}
		
		function get_event_cat($new_eventTypeId){
		    global $thewu32_cLink;
			/*
			* Nous permet d'acc�der � un enregistrement gr�ce aux tableaux associatifs
			*
			* @param : $new_eventTypeId = la cat�gorie d'�v�nement � afficher
			*/
			$query 	= "SELECT * FROM $this->tblEventType WHERE event_type_id = '$new_eventTypeId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'afficher la cat&eacute;gorie d'&eacute;v&eacute;nement...<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				while($row = mysqli_fetch_row($result)){
					$toRet = array(
								   "eventTYPEID"	=> $row[0],
								   "eventTYPELIB"	=> $row[1],
								   "eventLANGID"	=> $row[2]
								   );
				}
				return $toRet;
			}
			else
				return false;
		}
		
		function load_event_cat($pageDest="event.php", $errMsg="", $imgIcon="", $lang='EN'){
		    global $thewu32_cLink;
			$query 	= "SELECT * FROM $this->tblEventType WHERE ($this->fld_modLang = '$lang' OR $this->fld_modLang = 'XX') ORDER BY event_type_lib";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load events categories.<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = "<ul class=\"nav\">";
				while($row = mysqli_fetch_array($result)){
					//$toRet .= "<li><a href=\"$pageDest"."&".$this->URI_eventCat."=".$row[0]."\">$row[1]</a></li>";
				    $toRet .= "<li>".$this->toggle_icon($imgIcon)."<a href=\"$pageDest"."-cat@".$row[0].".html\">$row[1]</a></li>";
				}
				$toRet .="</ul>";
			}
			else{
				$toRet = $errMsg;
			}
			return $toRet;
		}
		
		function arr_load_event_cat($pageDest="event.php", $lang='EN'){
		    global $thewu32_cLink;
			$query 	= "SELECT * FROM $this->tblEventType WHERE $this->fld_eventLang = '$lang' ORDER BY event_type_lib";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load events categories.<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$id 		= 	$this->fld_eventTypeId;
				$title		=	$this->fld_eventTypeLib;
				$lang		=	$this->fld_eventLang;
				$arr_toRet = array();
				while($row = mysqli_fetch_array($result)){
					$totalCat	=	$this->count_in_tbl_where1($this->tbl_event, $this->fld_eventId, $this->fld_eventTypeId, $row[$id]);
					//$totalCat	=	$this->count_in_tbl_where33($this->tbl_event, $this->fld_eventId, $this->fld_eventTypeId, $row[$id], $this->fld_eventLang, $lang, $this->fld_eventDisplay, '1');
					
					$catUrl		=	($totalCat != 0) ? ($pageDest.'-cat@'.$row[0].'.html') : ('#');
					array_push($arr_toRet, array('EVENT_CAT_ID'=>$row[$id], 'EVENT_CAT_TITLE'=>$row[$title], 'EVENT_CAT_LANG'=>$row[$lang], 'EVENT_CAT_URL'=>$catUrl, 'EVENT_CAT_NB'=>$totalCat));
				}
			}
			else{
				$arr_toRet = false;
			}
			return $arr_toRet;
		}
		
		function get_event_cat_by_id($fldToGet, $valCatId){
			/*
			* Obtenir la valeur d'un champ de la table des memos sachant son id
			* Raccourci pour get_field_by_id()
			*
			* @param : $fldToGet = Champ � interroger
			* @param : $valId	= Valeur � mettre � jour dans le champ interrog� $fldToGet
			*/
			return $this->get_field_by_id($this->tblEventType, "event_type_id", $fldToGet, $valCatId);
		}
		
		function update_event_cat($new_eventTypeId, $new_eventTypeLib, $new_langId){
		    global $thewu32_cLink;
			$query = "UPDATE $this->tblEventType SET event_type_lib	= '$new_eventTypeLib', 
													 lang_id 		= '$new_langId' 
												WHERE event_type_id = '$new_eventTypeId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible mettre le type d'&eacute;v&eacute;nement &agrave; jour...<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}
		
		function update_event_cat_by_field($fldToUpdate, $valUpdate, $new_eventTypeId){
			/*
			* Mettre � jour n'importe kel champ de la table des types d'evenements, en sachant juste le nom du champ et l'id pivot
			* @param : $fldToUpdate = Champ � mettre � jour
			* @param : $valUpdate	= Nouvelle valeur saisie par l'user
			* @param : $new_eventTypeId  = l'Id � circonscrire
			*/
			return $this->update_entry_by_id($this->tblEventType, "event_type_id", $fldToUpdate, $valUpdate, $new_eventTypeId);
		}
		
		function load_event_cat_id(){
			/*
			* Affiche les ids des types d'�v�nements
			*/
			return $this->load_id($this->tblEventType, "event_type_id");			
		}
		
		function cmb_get_event_cat(){
			/*
			* Affiche les ids des types d'�v�nements dans un combo box
			*/
			$tabEventCatId = $this->load_event_cat_id();
			foreach($tabEventCatId as $value){
				$row_event_cat = $this->get_event_cat($value);
				$id		= $row_event_cat[eventTYPEID];
				$lib	= $row_event_cat[eventTYPELIB];
				$toRet 	.= "<option value=\"$id\">$lib</option>"; 
			}
			return $toRet;
		}
		
		//Obtenir un evenement sachant la date
		function get_event_by_date($new_dateMysql){
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_event WHERE event_end like '$new_dateMysql%' ORDER BY event_start DESC";
			$result = mysqli_query($thewu32_cLink, $query) or die("Error while extracting events!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				while($row = mysqli_fetch_row($result)){
					$event_id		= $row[0];
					$event_type_id	= $row[1];
					$event_user_id	= $row[2];
					$event_title 	= $row[3];
					$event_descr	= $row[4];
					$event_location	= $this->nodata($row[5], "Lieu non d&eacute;termin&eacute;");
					$toRet .= "
						<div class=\"monthly_event\"> 
							<div class=\"title\">$event_title</div>
							<div class=\"descr\">$event_descr</div>
							<div class=\"location\"><u><strong>Lieu :</strong></u> $event_location</div>
							<div class=\"clear_both\"></div>
						</div>
						";
				}
			}
			else
				$toRet = "<div class=\"monthly_event\"><div class=\"title\">Aucun &eacute;v&eacute;nement pour la date choisie.</div></div>";
			return $toRet;
		}
		
		//Savoir si une date appartient � un evenement afin de le mettre en evidence dans le calendreier.
		function is_valid_event($new_dateMysql){
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_event WHERE event_start like '$new_dateMysql%' ORDER BY event_start DESC";
			$result = mysqli_query($thewu32_cLink, $query) or die("Error while extracting events!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result))
				return true;
			else
				return false;
		}
		
		function get_event_by_month($new_dateMysql){
		    global $thewu32_cLink;
			$currentMonth = date("Y")."-".date("m");
			$month 	= $this->get_month($new_dateMysql);
			$year	= $this->get_year($new_dateMysql);
			$selectedMonth	= $year."-".$month;
			
			$sqlMonth	= ($new_dateMysql=="")?($currentMonth):($selectedMonth);
			$query = "SELECT * FROM $this->tbl_event WHERE event_start like '$sqlMonth%' ORDER BY event_start DESC";
			$result = mysqli_query($thewu32_cLink, $query) or die("Error while extracting events!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				while($row = mysqli_fetch_row($result)){
					$event_id		= $row[0];
					$event_type_id	= $row[1];
					$event_user_id	= $row[2];
					$event_title 	= $row[3];
					$event_descr	= $row[4];
					$event_location	= $this->nodata($row[5], "Lieu non d&eacute;termin&eacute;");
					$toRet .= "
						<div class=\"monthly_event\"> 
							<div class=\"title\">$event_title</div>
							<div class=\"descr\">$event_descr</div>
							<div class=\"location\"><u><strong>Lieu :</strong></u> $event_location</div>
							<div class=\"clear_both\"></div>
						</div>
						";
				}
			}
			else
				$toRet = "<div class=\"monthly_event\"><div class=\"title\">Aucun &eacute;v&eacute;nement pour ce mois.</div></div>";
			return $toRet;
		}
		
		function calendar_get_events($new_dateMysql){
			//Recuperer les mois et les annees dans une date mysql:
			global $thewu32_cLink;
			$month	=	$this->get_month($new_dateMysql);
			$year	=	$this->get_year($new_dateMysql);
			$query	=	"SELECT * FROM $this->tbl_event WHERE MONTH($this->fld_eventStart) = '$month' AND YEAR($this->fld_eventStart) = '$year' AND $this->fld_display = '1'";
			$result = 	mysqli_query($thewu32_cLink, $query) or die("Error while extracting monthly events!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$arr_toRet	=	array();
				while($row	=	mysqli_fetch_row($result)){
					$event_id			= 	$row[0];
					$event_type_id		= 	$row[1];
					$event_user_id		= 	$row[2];
					$event_title 		= 	$row[3];
					$event_descr		= 	$row[4];
					$event_date_start	=	$row[6];
					$event_date_end		=	$row[7];
					
					array_push($arr_toRet, array(	'ID'		=>	$event_id,
													'CATID'		=>	$event_type_id,
													'CAT'		=>	$this->get_event_cat_by_id($this->fld_eventTypeLib, $event_type_id),
													'TITLE'		=>	$event_title,
													'DESCR'		=>	$event_descr,
													'START'		=>	$event_date_start,
													'END'		=>	$event_date_end,
													'DAY-START'	=>	$this->get_day($this->extract_date_from_datetime($event_date_start)),
													'DAY-END'	=>	$this->get_day($this->extract_date_from_datetime($event_date_end)))
												);
				}
				return $arr_toRet;
			}
			else
				return false;
		}
		
		function load_incoming_events($nbEvents=3, $pageEvent='event_read.php', $eventCls='', $lang, $noEvent=''){
		    global $thewu32_cLink;
			$currentDatetime = $this->get_datetime();
			$query = "SELECT * FROM $this->tbl_event WHERE $this->fld_eventEnd >= '$currentDatetime' AND display = '1' AND ($this->fld_modLang = '$lang' or $this->fld_modLang='XX') ORDER BY $this->fld_eventStart";
			$result = mysqli_query($thewu32_cLink, $query) or die("Error while extracting events!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$count = 0;
				while(($row = mysqli_fetch_row($result)) && ($count<=$nbEvents)){
					$count+=1;
					$event_id			= 	$row[0];
					$event_type_id		= 	$row[1];
					$event_user_id		= 	$row[2];
					$event_title 		= 	$row[3];
					$event_descr		= 	$row[4];
					$event_date_start	=	$row[6];
					//Decouper la date
					$arr_date			=	$this->array_extract_datetime($event_date_start);
					//$day	=	$this->get_mo
					$toRet .= "
							<li>
								<div class=\"event\">
									<div class=\"event_date\">
										<span class=\"event_month\">".strtoupper($this->chapo($this->month_converterEN($arr_date['MONTH']), 3, '.'))."</span>
										<span class=\"event_day\">".$arr_date['DAY']."</span>
                                        <div class=\"clrBoth\"></div>
									</div>
                                    <div class=\"event_title\"><a href=\"".$this->set_mod_detail_uri($pageEvent, $event_id)."\">".$event_title."</a></div>
						   		</div>
                                <div class=\"clrBoth\"></div>
						   	</li>
							";
				}
			}
			else
				$toRet = "<li>$noEvent</li>";
			return "<ul class=\"$eventCls\">$toRet</ul>";
		}
		
		function load_last_event($number=5, $page_eventDetail='event_read.php', $lang='FR', $css='recent', $start=0){
		    global $thewu32_appExt, $thewu32_cLink;
		    $currentDatetime = $this->get_datetime();
		    $query = "SELECT * FROM $this->tbl_event WHERE $this->fld_eventEnd >= '$currentDatetime' AND display = '1' AND ($this->fld_eventLang = '$lang' or $this->fld_eventLang='XX') ORDER BY $this->fld_eventStart";
		    $result = mysqli_query($thewu32_cLink, $query) or die("Error while extracting events!<br />".mysqli_connect_error());
		    if($total = mysqli_num_rows($result)){
		        $count = 0;
		        while(($row = mysqli_fetch_row($result)) && ($count<=$nbEvents)){
		            $count+=1;
		            $event_id			= 	$row[0];
		            $event_type_id		= 	$row[1];
		            $event_user_id		= 	$row[2];
		            $event_title 		= 	$row[3];
		            $event_descr		= 	$row[4];
		            $event_date_start	=	$row[6];
		            //Decouper la date
		            $arr_date			=	$this->array_extract_datetime($event_date_start);
		            //$day	=	$this->get_mo
		            $toRet .= "
							<li>
								<div class=\"event_inner\">
									<div class=\"event_date\">
										<span class=\"event_month\">".strtoupper($this->chapo($this->month_converterEN($arr_date['MONTH']), 3, '.'))."</span>
										<span class=\"event_day\">".$arr_date['DAY']."</span>
									</div>
						   			<h4 class=\"event_title\"><a href=\"".$this->set_mod_detail_uri($page_eventDetail, $event_id)."\">".$event_title."</a></h4>
						   			    
						   		</div>
						   	</li>
							";
		        }
		    }
		    else{
		        $toRet = "<p class=\"event_recent\">No incoming event!!</p>";
		    }
		    return $toRet; //."</ul>";
		}
		
		function load_incoming_events_accordion($nbEvents=3, $pageEvent='event_read.php', $eventCls='', $lang, $noEvent=''){
		    global $thewu32_cLink;
			$currentDatetime = $this->get_datetime();
			$query = "SELECT * FROM $this->tbl_event WHERE $this->fld_eventEnd >= '$currentDatetime' AND display = '1' AND $this->fld_eventLang = '$lang' ORDER BY $this->fld_eventStart";
			$result = mysqli_query($thewu32_cLink, $query) or die("Error while extracting events!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$count 	= 0;
				$toRet	=	"<div id=\"accordion-first\" class=\"clearfix\">
								<div class=\"accordion\" id=\"accordionHomeEvent\">";
				while(($row = mysqli_fetch_row($result)) && ($count<=$nbEvents)){
					$count+=1;
					$event_id		= $row[0];
					$event_type_id	= $row[1];
					$event_user_id	= $row[2];
					$event_title 	= $row[3];
					$event_descr	= $row[4];
					$toRet .= "
					<div class=\"accordion-group\">
						<div class=\"accordion-heading\">
							<a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordionHomeEvent\" href=\"#collapse_".$count."\">
									<em class=\"fa fa-plus icon-fixed-width\"></em>$event_title
									</a>
									</div>
									<div id=\"collapse_".$count."\" class=\"accordion-body collapse\">
							<div class=\"accordion-inner\">
											".$this->chapo($event_descr, 150)."&nbsp; &raquo;<a href=\"$pageEvent".",".$event_id.".html\">Know more ...</a>
							</div>
						</div>
					</div>
													";
			}
			$toRet .= "</div></div>";
			}
			else
				$toRet = "<p>$noEvent</p>";
				return $toRet;
		}
		
				
		function load_top_event($nbEvents, $pageEvent, $eventCls, $lang='FR', $noEvent=''){
			return $this->load_incoming_events($nbEvents, $pageEvent, $eventCls, $lang, $noEvent);
		}
		
		
		
		function load_event_home(){
			//
		}
		
		//Obtenir un evenemet sachant la date
		function get_event_by_datetime($new_datetimeMysql){
		    global $thewu32_cLink;
			$date = $this->extract_date_from_datetime($new_datetimeMysql);
			$query = "SELECT * FROM $this->tbl_event WHERE $this->fld_eventEnd = '$date%' AND display = '1' ORDER BY $this->fld_eventStart DESC";
			$result = mysqli_query($thewu32_cLink, $query) or die("Error while extracting events!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				while($row = mysqli_fetch_row($result)){
					$event_id		= $row[0];
					$event_type_id	= $row[1];
					$event_user_id	= $row[2];
					$event_title 	= $row[3];
					$event_descr	= $row[4];
					$event_location	= $row[5];
					$toRet .= "<p>$event_title</p>";
				}
			}
			else
				$toRet = "Aucun &eacute;v&eacute;nement pour la date choisie.";
			return $toRet;
		}
		
		/**
		 * Alterner l'etat activ�/desactiv� des �v�nements
		 * */
		function switch_event_status($newEventId, $statusVal){
			if($this->set_updated_1($this->tbl_event, "display", $statusVal, "event_id", $newEventId))
				return true;
		}
		
		function load_event_by_cat($pageDest, $new_eventCat="", $nombre='25', $more="Read more", $lang="FR"){
		    global $mod_lang_output, $thewu32_cLang;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
			
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl_where1($this->tbl_event, $this->fld_eventId, $this->fld_eventTypeId, $new_eventCat);
			
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
			
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->affichepage_cat($nombre, $pageDest, $total, $new_eventCat);
			
				
			$toRet = $nav_menu."<div class=\"events\">";
				
		 	$query 		= 	"SELECT * FROM $this->tbl_event WHERE $this->fld_modDisplay='1' AND ($this->fld_modLang='$lang' OR $this->fld_modLang = 'XX') AND $this->fld_eventTypeId='$new_eventCat' ORDER BY $this->fld_eventStart DESC LIMIT ".$limite.",".$nombre;
		 	
		  	$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les &eacute;v&eacute;nements.<br />".mysqli_connect_error());
			if($total_1	= 	mysqli_num_rows($result)){
				$num	= 0;
				//$pageDest .= '-detail';
				while($row = mysqli_fetch_row($result)){
					$num++;
					//Alternate row
			  		//$cssAlt	= ((($num % 2) == 0) ? ("newsEven") : ("newsOdd"));
			  		$last_lineBehaviour = (($num == $total) ? ("") : ('border-bottom:#ccc dashed 1px;'));
			  		$id	= $row[0];
			  		$toRet .= "<div class=\"event_element $cssAlt\">
				  					<div class=\"event_element_title\"><span style=\"color:#fa2365;\">".$this->datetime_to_datefr2($row[6])." :</span> ".$row[3]."</div>
				  					<div class=\"event_element_descr\">".strip_tags($this->chapo($row[4], 120))."</div>
			  						<!-- &raquo;<a href=\"$pageDest&$this->URI_event=$row[0]\">$more</a> -->
			  						&raquo;<a href=\"".$this->set_mod_detail_uri($pageDest, $id)."\">$more</a>
			  						<div class=\"clear_both\"></div>
			  				   </div>";
			  	}
			}
			else{
			  	$toRet = "<p>".$mod_lang_output['NO_EVENT']."</p>";	
			}
		  	return $toRet."<div class=\"clear_both\"></div></div>$nav_menu";
		}
		
		function count_events(){
			return $this->count_in_tbl($this->tbl_event, $this->fld_eventId);
		}

	//Building the main content of the xml spry data set
	function spry_ds_get_file_main(){
				/**
				 * @return {event xml content by cat}
				 *
				 * @descr : Charger les items pour le fichier xml
				 **/
	            global $thewu32_cLink;
				$query = "SELECT * FROM $this->tbl_event WHERE $this->fld_eventDisplay ='1'";
				$result = mysql_query($thewu32_cLink, $query) or die("Unable to extract spry item for event!<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					while($row = mysqli_fetch_array($result)){
						/*$toRet.='
						 <galleryItem id="'.$row["gallery_id"].'">
						 <galleryThumbs><![CDATA['.$row["gallery_lib"].']]></galleryThumbs>
						 <galleryTitle><![CDATA['.$row["gallery_title"].']]></galleryTitle>
						 <galleryDescr><![CDATA['.$row["gallery_descr"].']]></galleryDescr>
						 </galleryItem>';*/
						$catLib	=	$this->get_event_cat_by_id($this->fld_eventTypeLib, $row[1]);
						$toRet.='<item id="'.$row[0].'" cat="'.$row[1].'">
										<cat><![CDATA['.$catLib.']]></cat>
										<date start="'.$row[6].'" end="'.$row[7].'">'.$row[9].'</date>
										<title><![CDATA['.$row[3].']]></title>
										<desc><![CDATA['.$row[4].']]></desc>
										<url>'.$row[8].'</url>
										<lang>'.$row[10].'</lang>
									</item>';
					}
				}
				return $toRet;
			}
			
			function event_autoIncr(){
				return $this->autoIncr($this->tbl_event, $this->fld_eventId);
			}
			
			/* function spry_ds_create(){
				return $this->digitra_spry_xml_create($this->modName, $this->spry_ds_get_file_main());
			} */
		//function count_
	}
?>