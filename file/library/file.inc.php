<?php //
class cwd_file extends cwd_system{
		var $tblFile;
		var $tbl_file;
		var $tbl_fileCat;
		var $fld_fileId;
		
		var $tblFileCat;	
		var $fld_fileCatId;
		
		var $fld_usrId;
		var $fld_fileDate;
		
		var $URI_file;
		var $URI_fileCat;
		var $mod_queryKey	= 'pmId';
		var $mod_fkQueryKey	= 'catId';
		
		var $fld_fileTitle;
		var $fld_fileDescr;
		var $fld_fileUrl;
		var $fld_fileDatePub;
		var $fld_fileLang;
		var $fld_fileDisplay;
		var $fld_fileCatLib;
		var $fld_fileCatDescr;
		var $fld_fileCatLang;
		var $fld_fileCatDisplay;
		
		//var $modName	=	'file';
		//var $modDir		=	'modules/file/';
		
		
		//var $modDir;

        public function __construct(){
            global $thewu32_tblPref, $lang_output;
            $this->tblFile 				= 	$thewu32_tblPref."file";
            $this->tbl_file				=	$thewu32_tblPref."file";
            $this->tbl_fileCat			=	$thewu32_tblPref."file_cat";
            $this->tblFileCat			= 	$thewu32_tblPref."file_cat";

            $this->fld_fileId			= 	'file_id';
            $this->fld_fileCatId		= 	'file_cat_id';
            $this->fld_usrId			= 	'usr_id';

            $this->fld_fileDate			= 	'file_date_pub';
            $this->set_fileDirectory("../modules/file/dox/files/");
            $this->URI_file				= 	'pmId';
            $this->URI_fileCat			= 	'catId';

            $this->fld_fileTitle		= 	'file_title';
            $this->fld_fileDescr		= 	'file_descr';
            $this->fld_fileUrl			= 	'file_url';
            $this->fld_fileDatePub		= 	'file_date_pub';
            $this->fld_fileLang			=	'lang_id';
            $this->fld_fileDisplay		=	'display';
            $this->fld_fileCatLib		=	'file_cat_lib';
            $this->fld_fileCatDescr		=	'file_cat_descr';
            $this->fld_fileCatLang		=	'lang_id';
            $this->fld_fileCatDisplay	=	'display';

            $this->modName				=	'file';
            $this->modDir				.=	$this->modName.'/';
        }

		function cwd_file(){
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
					  <h1>Gestion des fichiers</h1>
					  <ul class=\"ADM_menu_title\">
					  	<h2>Les Fichiers</h2>
					  	<li><a href=\"?what=fileDisplay\">Lister les fichiers</a></li>
						<li><a href=\"?what=fileInsert\">Ajouter un fichier</a></li>
					  </ul>
					  <ul>
					  	<h2>Les Cat&eacute;gories(Types)</h2>
					  	<li><a href=\"?what=fileCatDisplay\">Afficher les cat&eacute;gories</a></li>
					  	<li><a href=\"?what=fileCatInsert\">Ajouter une cat&eacute;gories</a></li>
					  </ul>
					  <div class=\"ADM_menu_descr\"></div>
				  </div>";
		return $toRet;				  
	}
	
	function load_rub_id_ordered(){
		//Charge les id des rubriques, avec le total comme indice [0] bon pour espace d'admin
		return $tabFileCat = $this->loadId_ordered($this->tblFileCat, "file_title", $this->fld_fileCatId, "ASC");
	}
	
	function load_rub_id_ordered_by_lang($lang='FR'){
		//Charge les id des rubriques, avec le total comme indice [0] bon pour espace d'admin
		return $tabFileCat = $this->loadId_ordered($this->tblFileCat, "file_title", $this->fld_fileCatId, "ASC", "WHERE lang_id='$lang' OR lang_id='XX'");
		//return $tabFileCat = $this->loadId_ordered_by_lang($this->tblFileCat, "file_title", $this->fld_fileCatId, $lang, "ASC");
	}
	
	//Ressortir les rubriques sous-forme de liste � puces et par ordre alphab&eacute;tique
	function get_file_rub($pageRub, $lang="FR", $cls=""){
		$tabId = $this->load_rub_id_ordered();
		$toRet = "<ul>";
		foreach($tabId as $key=>$value){
			if($key==0)
				continue;
			$lib_value = $this->get_field_by_id($this->tblFileCat, $this->fld_fileCatId, "file_cat_lib", $value);
			//$toRet .="<li class=\"$cls\"><a href=\"$pageRub&$this->URI_fileCatVar=$value\">$lib_value</a></li>";
			$toRet .="<li class=\"$cls\"><a href=\"$pageRub"."-cat@".$value.".html"."\">$lib_value</a></li>";
		}
	return $toRet."</ul>";
	}
	
	function get_file_rub_by_lang($pageRub, $lang="FR", $cls=""){
		$tabId = $this->load_rub_id_ordered();
		$toRet = "<ul>";
		foreach($tabId as $key=>$value){
			if($key==0)
				continue;
			$lib_value = $this->get_field_by_id($this->tblFileCat, $this->fld_fileCatId, "file_cat_lib", $value);
			//$toRet .="<li class=\"$cls\"><a href=\"$pageRub&$this->URI_fileCatVar=$value\">$lib_value</a></li>";
			$toRet .="<li class=\"$cls\"><a href=\"$pageRub"."-cat@".$value.".html"."\">$lib_value</a></li>";
		}
		return $toRet."</ul>";
	}
	
	function arr_load_file_cat($pageDest='file.php', $lang){
	    global $thewu32_cLink;
		$query 	= "SELECT * FROM $this->tbl_fileCat WHERE $this->fld_fileCatLang = '$lang' OR $this->fld_fileCatLang = 'XX' AND $this->fld_fileCatDisplay='1' ORDER BY $this->fld_fileCatLib";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load files categories.<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$arr_toRet = array();
			$id 		= 	$this->fld_fileCatId;
			$title		=	$this->fld_fileCatLib;
			$descr		=	$this->fld_fileCatDescr;
			$lang		=	$this->fld_fileCatLang;
			$display	=	$this->fld_fileCatDisplay;
			while($row = mysqli_fetch_array($result)){
				//$totalCat	=	$this->count_in_tbl_where1($this->tbl_file, $this->fld_fileId, $this->fld_fileCatId, $row[$id]);
				$totalCat	=	$this->count_in_tbl_where2($this->tbl_file, $this->fld_fileId, $this->fld_fileCatId, $this->fld_fileDisplay, $row[$id], '1');
				//$totalCat	=	$this->count_in_tbl_where33($this->tbl_file, $this->fld_fileId, $this->fld_fileLang, $lang, $this->fld_fileDisplay, '1', $this->fld_fileId, $row[$id]);
				$catUrl		=	($totalCat != 0) ? ($pageDest.'-cat@'.$row[0].'.html') : ('#');
				array_push($arr_toRet, array('FILE_CAT_ID'=>$row[$id], 'FILE_CAT_TITLE'=>$row[$title], 'FILE_CAT_DESCR'=>$row[$descr], 'FILE_CAT_LANG'=>$lang, 'FILE_CAT_DISPLAY'=>$display, 'FILE_CAT_NB'=>$totalCat, 'FILE_CAT_URL'=>$catUrl));
			}
		}
		else{
			$arr_toRet	=	false;
		}
		return $arr_toRet;
	}
	
	/*function load_file_cat($pageDest, $lang='FR'){
		return $this->get_file_rub($pageDest, $lang);
	}*/
	/*
	function load_file_cat($pageDest="file.php", $errMsg="", $imgIcon="", $lang){
		$query 	= "SELECT * FROM $this->tbl_fileCat WHERE lang_id = '$lang' or lang_id = 'XX' ORDER BY $this->fld_fileCatLib";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load file categories.<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			$toRet = "<ul>";
			while($row = mysqli_fetch_array($result)){
				//$toRet .= "<li><a href=\"$pageDest"."&".$this->URI_annonceCat."=".$row[0]."\">$row[1]</a></li>";
				$toRet .= "<li>$imgIcon&nbsp;&nbsp;<a href=\"$pageDest"."-cat@".$row[0].".html\">$row[1]</a></li>";
			}
			$toRet .="</ul>";
		}
		else{
			$toRet = $errMsg;
		}
		return $toRet;
	}*/
	
	/* function load_file_cat($pageDest="file.php", $errMsg=""){
	    global $thewu32_cLink;
	    $query 	= "SELECT * FROM $this->tbl_fileCat WHERE $this->fld_fileCatLang = '".$_SESSION[LANG]."' OR $this->fld_fileCatLang = 'XX' ORDER BY $this->fld_fileCatLib";
	    $result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load file categories.<br />".mysqli_connect_error());
	    if($total = mysqli_num_rows($result)){
	        $toRet = "<ul class=\"nav\">";
	        while($row = mysqli_fetch_array($result)){
	            $toRet .= "<li>".$this->toggle_icon($this->mod_catIcon)."<a href=\"$pageDest"."-cat@".$row[0].".html\">$row[1]</a></li>";
	        }
	        $toRet .="</ul>";
	    }
	    else{
	        $toRet = $errMsg;
	    }
	    return $toRet;
	} */
	
	function load_file_cat($pageDest="file.php", $errMsg="", $imgIcon="", $new_fileCatLang='FR'){
	    global $thewu32_cLink;
	    $query 	= "SELECT DISTINCT $this->fld_fileCatId FROM $this->tbl_file WHERE ($this->fld_modLang = '$new_fileCatLang' OR $this->fld_modLang = 'XX')";
	    $result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load file categories.<br />".mysqli_connect_error());
	    if($total = mysqli_num_rows($result)){
	        $toRet = "<ul class=\"nav\">";
	        while($row = mysqli_fetch_array($result)){
	            $toRet .= "<li>".$this->toggle_icon($this->mod_catIcon)."<a href=\"$pageDest"."-cat@".$row[0].".html\">".$this->get_file_cat_by_id($row[0])."</a></li>";
	        }
	        $toRet .="</ul>";
	    }
	    else{
	        $toRet = $errMsg;
	    }
	    return $toRet;
	}
	
	function load_last_file($pageFile='file.php', $number=5, $lang='EN', $cls="recent"){
	    global $thewu32_cLink;
		//Les titres des fichiers les plus recentes ds un box
		//$number = ((int)($number - 1));
		$query = "SELECT $this->fld_fileId, $this->fld_fileTitle, $this->fld_fileUrl FROM $this->tblFile WHERE	(lang_id='$lang' OR lang_id='XX') AND display='1' ORDER BY $this->fld_fileDatePub DESC LIMIT 0, $number";
		$result = mysqli_query($thewu32_cLink, $query) or die("Unable to load recent files!!<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			//$annonces_link = "<p>&raquo;<a class=\"box_link\" href=\"$pageAnnonce\">Toutes les annonces</a></p>";
			$id 		= $this->fld_fileId;
			$title		= $this->fld_fileTitle;
			$file		= $this->fld_fileUrl;
			
			
			
			$toRet 	= "<ul class=\"$cls\">";
			while($row = mysqli_fetch_array($result)){
				$fileName	= $row[$file];
				
				//Now get the file extension
				$fileExt	= $this->get_file_ext($fileName);
				
				$toRet	.= "<li>
								<img style=\"margin-right:5px;\" align=\"left\" src=\"".$this->modDir."/img/icons/".$fileExt."_25.gif"."\" />
						   		<a class=\"file_link\" href=\"$pageFile"."-detail-".$row[$id].".html"."\">".$row[$title]."</a>
						  	</li>";
			}
		}
		else{
			$toRet = "Aucun afichier &agrave; afficher!!";
		}
		return $toRet."</ul>";
	}
	
	function load_last_file_by_cat($pageFile='file.php', $number=5, $lang='EN', $cls="recent"){
	    global $thewu32_cLink;
	    //Les titres des fichiers les plus recentes ds un box
	    //$number = ((int)($number - 1));
	    $query = "SELECT $this->fld_fileId, $this->fld_fileTitle, $this->fld_fileUrl FROM $this->tblFile WHERE	(lang_id='$lang' OR lang_id='XX') AND display='1' ORDER BY $this->fld_fileDatePub DESC LIMIT 0, $number";
	    $result = mysqli_query($thewu32_cLink, $query) or die("Unable to load recent files!!<br />".mysqli_connect_error());
	    if($total = mysqli_num_rows($result)){
	        //$annonces_link = "<p>&raquo;<a class=\"box_link\" href=\"$pageAnnonce\">Toutes les annonces</a></p>";
	        $id 		= $this->fld_fileId;
	        $title		= $this->fld_fileTitle;
	        $file		= $this->fld_fileUrl;
	        
	        
	        
	        $toRet 	= "<ul class=\"$cls\">";
	        while($row = mysqli_fetch_array($result)){
	            $fileName	= $row[$file];
	            
	            //Now get the file extension
	            $fileExt	= $this->get_file_ext($fileName);
	            
	            $toRet	.= "<li>
								<img style=\"margin-right:5px;\" align=\"left\" src=\"".$this->modDir."/img/icons/".$fileExt."_25.gif"."\" />
						   		<a class=\"file_link\" href=\"$pageFile"."-detail-".$row[$id].".html"."\">".$row[$title]."</a>
						  	</li>";
	        }
	    }
	    else{
	        $toRet = "Aucun afichier &agrave; afficher!!";
	    }
	    return $toRet."</ul>";
	}
	
	function load_last_file_accordion($pageFile='file.php', $number=5, $lang='EN', $accId='acc1', $cls="recent"){
	    global $thewu32_cLink;
	    //Les titres des fichiers les plus recentes ds un box
	    //$number = ((int)($number - 1));
	    $query = "SELECT $this->fld_fileId, $this->fld_fileTitle, $this->fld_fileUrl FROM $this->tblFile WHERE	(lang_id='$lang' OR lang_id='XX') AND display='1' ORDER BY $this->fld_fileDatePub DESC LIMIT 0, $number";
	    $result = mysqli_query($thewu32_cLink, $query) or die("Unable to load recent files!!<br />".mysqli_connect_error());
	    if($total = mysqli_num_rows($result)){
	        //$annonces_link = "<p>&raquo;<a class=\"box_link\" href=\"$pageAnnonce\">Toutes les annonces</a></p>";
	        $id 		= $this->fld_fileId;
	        $title		= $this->fld_fileTitle;
	        $file		= $this->fld_fileUrl;
	        
	        
	        
	        $toRet 	= "<ul class=\"$cls\">";
	        while($row = mysqli_fetch_array($result)){
	            $fileName	= $row[$file];
	            
	            //Now get the file extension
	            $fileExt	= $this->get_file_ext($fileName);
	            
	            $toRet	.= "<li>
								<img style=\"margin-right:5px;\" align=\"left\" src=\"".$this->modDir."/img/icons/".$fileExt."_25.gif"."\" />
						   		<a class=\"file_link\" href=\"$pageFile"."-detail-".$row[$id].".html"."\">".$row[$title]."</a>
						  	</li>";
	        }
	    }
	    else{
	        $toRet = "Aucun afichier &agrave; afficher!!";
	    }
	    return $toRet."</ul>";
	}
	
	/**
	 * Definir la variabe d'url pour les fichiers
	 * 
	 * @param string $new_uriVar
	 *
	 * @return void()*/
	function set_uri_file($new_uriVar){
		return $this->URI_file = $new_uriVar;
	}
		
function admin_load_files($nombre='20', $limit='0'){
		global $lang_output, $mod_lang_output, $thewu32_cLink;
		
		$limite = $this->limit;
		if(!$limite) $limite = 0;
		
		//Recherche du nom de la page
		$path_parts = pathinfo($PHP_SELF);
		$page = $path_parts["basename"];
		
		//Obtention du total des enregistrements:
		$total = $this->count_in_tbl($this->tblFile, $this->fld_fileId);
		$myUser	=	new cwd_user();
		
		//V&eacute;rification de la validit&eacute; de notre variable $limite......
		$veriflimite = $this->veriflimite($limite, $total, $nombre);
		if(!$veriflimite) $limite = 0;
		
		//Bloc menu de liens
		if($total > $nombre) 
			$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
			
		$query 	= "SELECT * FROM $this->tblFile ORDER BY '".$this->fld_fileId."' DESC LIMIT ".$limite.",".$nombre;
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load files!<br />".mysqli_connect_error());
		if($total_1 = mysqli_num_rows($result)){
			$num	= 0;
			$toRet 	= $nav_menu;
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
				$stateImg 	= ($row[8] == 0) ? ("<img src=\"img/icons/disabled.gif\" />") : ("<img src=\"img/icons/enabled.gif\" />");
				$varUri		= ($row[8] == 0)?("filePublish"):("filePrivate");
				$stateAlt	= ($row[8] == 0)?($lang_output['TABLE_TOOLTIP_SHOW']):($lang_output['TABLE_TOOLTIP_HIDE']);
				
				//Obtenir les libelles des categories
				$categorie 	= $this->get_file_cat_by_id($row[1]);
				//Convertir la date
				$date		= $this->datetime_en3($row[6]);
				//Alternet les css
				$author		=	ucfirst($myUser->get_user_detail_by_id($myUser->fld_userDetailFirstName, $row[2]))." ".strtoupper($myUser->get_user_detail_by_id($myUser->fld_userDetailLastName, $row[2]));
				
				$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
				$author		= (($row[2] == 0) ? ("Administrator") : ($author));
				
				$toRet .="<tr class=\"$currentCls\">
							<th scope=\"row\" align=\"center\">$num</th>
							<td>$categorie</td>
							<td>$row[3]</td>
							<td>$author</td>
							<td>$date</td>
							<td style=\"background:#FFF; text-align:center;\">
								<a  title=\"".$lang_output['TABLE_TOOLTIP_UPDATE']."\" href=\"?what=fileUpdate&action=fileUpdate&".$this->URI_file."=$row[0]#FILES\"><img src=\"img/icons/edit.gif\" /></a>
								<a title=\"".$lang_output['TABLE_TOOLTIP_DELETE']."\" href=\"?what=fileDisplay&action=fileDelete&".$this->URI_file."=$row[0]#FILES\" onclick = \"return confirm('Sure you want to delete the said file?')\"><img src=\"img/icons/delete.gif\" /></a>
								<a title=\"$stateAlt\" href=\"?action=$varUri&".$this->URI_file."=$row[0]#FILES\">$stateImg</a>
							</td>
						  </tr>";
			}
			$toRet .= "</table>$nav_menu";
			
		}
		else{
			$toRet	= "<p>".$mod_lang_output['NO_FILE']."</p>";
		}
		return $toRet;
	}
	
	function admin_load_filescat($nombre='20', $limit='0'){
		global $lang_output, $mod_lang_output, $thewu32_cLink;
		
		$limite = $this->limit;
		if(!$limite) $limite = 0;
		
		//Recherche du nom de la page
		$path_parts = pathinfo($PHP_SELF);
		$page = $path_parts["basename"];
		
		//Obtention du total des enregistrements:
		$total = $this->count_in_tbl($this->tblFile, $this->fld_fileId);
		
		
		//V&eacute;rification de la validit&eacute; de notre variable $limite......
		$veriflimite = $this->veriflimite($limite, $total, $nombre);
		if(!$veriflimite) $limite = 0;
		
		//Bloc menu de liens
		if($total > $nombre) 
			$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
			
		$query 	= "SELECT * FROM $this->tblFileCat ORDER BY '$this->fld_fileCatId' DESC LIMIT ".$limite.",".$nombre;
		$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news categories!<br />".mysqli_connect_error());
		if($total_1 = mysqli_num_rows($result)){
			$num	= 0;
			$toRet 	= $nav_menu;
			$toRet 	.= "<table class=\"table table-bordered\">
						<tr>
							<th>&num;</th>
							<th>".$lang_output['TABLE_HEADER_CATEGORY']."</th>
							<th>".$lang_output['TABLE_HEADER_DESCRIPTION']."</th>
							<th>".$lang_output['TABLE_HEADER_ACTION']."</th>
						</tr>";
			while($row = mysqli_fetch_array($result)){
				$num++;
				//alterner les liens public / prive
				$linkState	= ($row[3] == "0")?("Priv."):("Pub.");
				$varUri		= ($row[3] == "0")?("fileCatPublish"):("fileCatPrivate");
				$linkTitle	= ($row[3] == "0")?("Display the category"):("Hide th category");
				//Alternet les css
				$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));				
				
				$toRet .="<tr class=\"$currentCls\">
							<th scope=\"row\">$num</th>
							<td>$row[1]</td>
							<td>$row[2]</td>
							<td class=\"table-action\">
								<a title=\"".$lang_output['TABLE_TOOLTIP_UPDATE']."\" href=\"?what=fileCatDisplay&action=fileCatUpdate&catId=$row[0]\"><img src=\"img/icons/edit.gif\" /></a>
								<a title=\"".$lang_output['TABLE_TOOLTIP_DELETE']."\" href=\"?what=fileCatDisplay&action=fileCatDelete&catId=$row[0]\" onclick=\"return confirm('The deletion of the category shall involve the on of the concerned files.<br />Do you wish to proceed anyways?')\"><img src=\"img/icons/delete.gif\" /></a>
							</td>
						  </tr>";
			}
			$toRet .="</table>$nav_menu";
			
		}
		else{
			$toRet	= "No category to be displayed";
		}
		return $toRet;
	}


		
		function display_files($pageDest, $nombre='20', $lang='EN'){
			global $mod_lang_output, $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
			
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl($this->tblFile, $this->fld_fileId);
			
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
			
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->affichepage2($nombre, $pageDest, $total);
		  			
						
		 	$query 		= 	"SELECT * FROM $this->tblFile WHERE display='1' AND ($this->fld_langId='$lang' OR $this->fld_langId='XX') ORDER BY file_title LIMIT ".$limite.",".$nombre;
		  	$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
		  	if($total_1	= 	mysqli_num_rows($result)){
		  		$num	= 0;
		  		$toRet = "<div style=\"margin-bottom:5px;\">$nav_menu</div>";
		  		while($row = mysqli_fetch_row($result)){
		  			$num++;
		  			$id	= $row[0];
					//Alternate row
					$currentCls = ((($num%2) == 0) ? ("row1") : ("row2"));
					
					//mettre le chemin � jour :
					//$fileDir	= $this->set_fileDirectory("dox/files/");
					
					$fileUrl	= "modules/file/dox/files/".$row[5];
					$fileSize	= @ceil((filesize($fileUrl) / 1024));
					$fileInfo	= $this->get_file_ext_name($fileUrl);
					
		  			$toRet .= "<div class=\"file_element\">
			  						<div class = \"file_element_title\">$row[3]</div>
			  						<div class=\"file_element_content\">
			  							<!-- <a href=\"$pageDest?$this->URI_fileVar=$row[0]&action=dld\"><img src=\"".$this->modDir."img/icons/$fileInfo[img]\" /></a> -->
			  							<a href=\"".$pageDest."-".$row[0]."-"."dld.html\"><img style=\"border:0; margin-right:5px;\" src=\"".$this->modDir."img/icons/$fileInfo[img]\" /></a>
				  						<div class=\"file_element_content_descr\">".$this->chapo($row[4], 1200)."</div>
				  						<div class=\"clrBoth\"></div>
				  						<div class=\"file_element_content_prop\">
				  							<ul>
				  								<li><strong>".$mod_lang_output["FILE_LBL_FILE"]." :</strong> $fileInfo[type]</li>
			  									<li><strong>".$mod_lang_output["FILE_LBL_WIDTH"]." :</strong> $fileSize Ko</li>
			  									<!-- <li><a style=\"color:#fa2365; font-weight:bold;\" href=\"$pageDest&$this->URI_fileVar=$row[0]&view=detail\">".$mod_lang_output["FILE_LBL_MORE"]."</a></li> -->
			  									<li><a style=\"color:#fa2365; font-weight:bold;\" href=\"$pageDest"."-".$row[0]."."."detail.html"."\">".$mod_lang_output["FILE_LBL_MORE"]."</a></li>
			  								</ul>
			  							</div>
			  						</div>
			  						<div class=\"file_element_link\">
			  							&raquo;<a target=\"_blank\" href=\"$fileUrl\">".$mod_lang_output["FILE_LBL_DLD"]."</a>
			  						</div>
		  							<div class=\"clear_both\"></div>
		  					   </div>";
		  		}
		  		//Affichage de la ligne du menu de navigation
		  		$toRet 	.="<div style=\"margin-bottom:5px;\">$nav_menu</div>";		  				  		
		  	}
		  	else{
		  		$toRet = "<p>Aucun &eacute;l&eacute;ment &agrave; afficher</p>";	
		  	}
		  	return $toRet."<div class=\"clear_both\"></div>";
		}
		
		function arr_load_file($pageDest, $nombre='20', $lang='EN'){
			global $lang_output, $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
		
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl($this->tblFile, $this->fld_fileId);
		
		
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
		
			//Bloc menu de liens
			if($total > $nombre)
				$nav_menu	= $this->affichepage2($nombre, $pageDest, $total);
				
		
			$query 		= 	"SELECT * FROM $this->tblFile WHERE display='1' AND (lang_id='$lang' OR lang_id='XX') ORDER BY file_title LIMIT ".$limite.",".$nombre;
			$result		=	mysqli_query($thewu32_cLink, $query) or die("Unable to list files.<br />".mysqli_connect_error());
			if($total_1	= 	mysqli_num_rows($result)){
				$num	= 0;
				$arr_toRet	=	array();
				$id			=	$this->fld_fileId;
				$title		=	$this->fld_fileTitle;
				$name		=	$this->fld_fileUrl;
				$descr		=	$this->fld_fileDescr;
				$author		=	$this->fld_usrId;
				$catId		=	$this->fld_fileCatId;
				$date		=	$this->fld_fileDatePub;
				$display	=	$this->fld_fileDisplay;
					
				while($row = mysqli_fetch_array($result)){
		
					$catTitle		=	$this->get_file_cat_by_id($row[$catId]);
					$fileUrl		= 	"modules/file/dox/files/".$row[$name];
					$fileSize		= 	@ceil((filesize($fileUrl) / 1024));
					$fileInfo		= 	$this->get_file_ext_name($fileUrl);
					$fileType		=	$fileInfo['type'];
					$fileIcon		=	$fileInfo['img'];
					$file_iconUrl	=	"<img style=\"border:none;\" src=\"modules/file/img/icons/$fileIcon\" />";
					$pageUrl		=	$pageDest."-detail-".$row[$id].".html";
		
					array_push($arr_toRet, array('FILE_ID'=>$row[$id], 'FILE_TITLE'=>$row[$title], 'FILE_NAME'=>$row[$name], 'FILE_SIZE'=>$fileSize, 'FILE_TYPE'=>$fileType, 'FILE_ICON'=>$fileIcon, 'FILE_LINK'=>$fileUrl, 'FILE_ICON_SRC'=>$file_iconUrl, 'FILE_DESCR'=>$row[$descr], 'FILE_AUTHOR'=>$row[$author], 'FILE_CAT_ID'=>$row[$catId], 'FILE_CAT_TITLE'=>$catTitle, 'FILE_DATE'=>$row[$date], 'FILE_URL'=>$pageUrl));
				}
			}
			else{
				return false;
			}
			return $arr_toRet;
		}
		
		
		function arr_load_file_by_cat($pageDest, $new_fileCat="", $nombre='25', $more="Read more", $lang='EN'){
			global $lang_output, $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
		
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl_where1($this->tbl_file, $this->fld_fileId, $this->fld_fileCatId, $new_fileCat);
		
		
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
		
			//Bloc menu de liens
			if($total > $nombre)
				$nav_menu	= $this->affichepage2($nombre, $pageDest, $total);
		
		
			$query 		= 	"SELECT * FROM $this->tbl_file WHERE $this->fld_fileCatId='$new_fileCat' AND ($this->fld_fileLang='$lang' OR $this->fld_fileLang='XX') AND $this->fld_fileDisplay='1' ORDER BY $this->fld_fileTitle LIMIT ".$limite.",".$nombre;
			$result		=	mysqli_query($thewu32_cLink, $query) or die("Unable to list files.<br />".mysqli_connect_error());
			if($total_1	= 	mysqli_num_rows($result)){
				$num		= 	0;
				$arr_toRet	=	array();
				$id			=	$this->fld_fileId;
				$title		=	$this->fld_fileTitle;
				$name		=	$this->fld_fileUrl;
				$descr		=	$this->fld_fileDescr;
				$author		=	$this->fld_usrId;
				$catId		=	$this->fld_fileCatId;
				$date		=	$this->fld_fileDatePub;
				$display	=	$this->fld_fileDisplay;
					
				while($row = mysqli_fetch_array($result)){
		
					$catTitle	=	$this->get_file_cat_by_id($row[$catId]);
					$fileUrl	= 	"modules/file/dox/files/".$row[$name];
					$fileSize	= 	@ceil((filesize($fileUrl) / 1024));
					$fileInfo	= 	$this->get_file_ext_name($fileUrl);
					$fileType	=	$fileInfo['type'];
					$fileIcon	=	$fileInfo['img'];
					$pageUrl	=	$pageDest."-detail-".$row[$id].".html";
		
					array_push($arr_toRet, array('FILE_ID'=>$row[$id], 'FILE_TITLE'=>$row[$title], 'FILE_NAME'=>$row[$name], 'FILE_SIZE'=>$fileSize, 'FILE_TYPE'=>$fileType, 'FILE_ICON'=>$fileIcon, 'FILE_LINK'=>$fileUrl, 'FILE_DESCR'=>$row[$descr], 'FILE_AUTHOR'=>$row[$author], 'FILE_CAT_ID'=>$row[$catId], 'FILE_CAT_TITLE'=>$catTitle, 'FILE_DATE'=>$row[$date], 'FILE_URL'=>$pageUrl));
		
				}
			}
			else{
				return false;
			}
			return $arr_toRet;
		}
		
		function load_file($pageDest, $nombre='20', $more="Read more", $lang='EN'){
		    global $mod_lang_output, $thewu32_cLink;
		    $limite = $this->limit;
		    if(!$limite) $limite = 0;
		    
		    //Obtention du total des enregistrements:
		    $total = $this->count_in_tbl($this->tblFile, $this->fld_fileId);
		    
		    
		    //V&eacute;rification de la validit&eacute; de notre variable $limite......
		    $veriflimite = $this->veriflimite($limite, $total, $nombre);
		    if(!$veriflimite) $limite = 0;
		    
		    //Bloc menu de liens
		    if($total > $nombre)
		        $nav_menu	= $this->affichepage($nombre, $pageDest, $total);
		        
		        
		        $query 		= 	"SELECT * FROM $this->tblFile WHERE display='1' AND (lang_id = 'XX' OR lang_id = '$lang') ORDER BY file_title LIMIT ".$limite.",".$nombre;
		        $result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
		        if($total_1	= 	mysqli_num_rows($result)){
		            $num	= 0;
		            $toRet = $nav_menu;
		            while($row = mysqli_fetch_row($result)){
		                $num++;
		                $id	= $row[0];
		                //Alternate row
		                $currentCls = ((($num%2) == 0) ? ("row1") : ("row2"));
		                
		                //mettre le chemin � jour :
		                //$fileDir	= $this->set_fileDirectory("dox/files/");
		                
		                $fileUrl	= "modules/file/dox/files/".$row[5];
		                $fileSize	= @ceil((filesize($fileUrl) / 1024));
		                $fileInfo	= $this->get_file_ext_name($fileUrl);
		                
		                $toRet .= "<div class=\"file_element\">
			  						<div class = \"file_element_title\">$row[3]</div>
			  						<div class=\"file_element_content\">
			  							<a href=\"".$this->set_mod_detail_uri($pageDest, $id)."\"><img style=\"border:0; margin-right:5px;\" src=\"".$this->modDir."img/icons/$fileInfo[img]\" /></a>
				  						<div class=\"file_element_content_descr\">".$this->chapo($row[4], 1200)."</div>
				  						<div class=\"clrBoth\"></div>
				  						<div class=\"file_element_content_prop\">
				  							<ul>
				  								<li><strong>".$mod_lang_output["FILE_LBL_FILE"]." :</strong> $fileInfo[type]</li>
			  									<li><strong>".$mod_lang_output["FILE_LBL_WIDTH"]." :</strong> $fileSize Ko</li>
			  									<li><a style=\"color:#fa2365; font-weight:bold;\" href=\"".$this->set_mod_detail_uri($pageDest, $id)."\">".$mod_lang_output["FILE_LBL_MORE"]."</a></li>
			  								</ul>
			  							</div>
			  						</div>
			  						<div class=\"file_element_link\">
			  							&raquo;<a target=\"_blank\" href=\"$fileUrl\">".$mod_lang_output["FILE_LBL_DLD"]."</a>
			  						</div>
		  							<div class=\"clear_both\"></div>
		  					   </div>";
		            }
		            //Affichage de la ligne du menu de navigation
		            $toRet 	.=    $nav_menu;
		        }
		        else{
		            $toRet = "<p>".$mod_lang_output['NO_FILE']."</p>";
		        }
		        return $toRet."<div class=\"clear_both\"></div>";
		}
		
		function search_files($new_keyWord, $nombre='2', $limit='0'){
			global $mod_lang_output, $thewu32_cLink;
			$new_keyWord = strtolower($new_keyWord);
			$limite = $this->limit;
			if(!$limite) $limite = 0;
			
			//Recherche du nom de la page
			$path_parts = pathinfo($PHP_SELF);
			$page = $path_parts["basename"];
			
			//Obtention du total des enregistrements:
			$my_countQuery	= 	"SELECT COUNT($this->fld_fileId) FROM $this->tblFile WHERE display='1' AND file_title like '%$new_keyWord%' OR file_descr like '%$new_keyWord%'";
			$total			= $this->count_query($my_countQuery);
			//$total = $this->count_in_tbl($this->tblFile, $this->fld_fileId);
			
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
			
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->affichepage($nombre, $page, $total);
			//fin Bloc menu de liens
		  			
		 	$query 		= 	"SELECT * FROM $this->tblFile WHERE display='1' AND file_title like '%$new_keyWord%' OR file_descr like '%$new_keyWord%' ORDER BY file_title LIMIT ".$limite.",".$nombre;
		  	$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
		  	if($total_1	= 	mysqli_num_rows($result)){
		  		$num	= 0;
		  		$toRet = $nav_menu;
		  		while($row = mysqli_fetch_row($result)){
		  			$num++;
		  			$id	= $row[0];
					//Alternate row
					$currentCls = ((($num%2) == 0) ? ("row1") : ("row2"));
					
					//mettre le chemin � jour :
					//$fileDir	= $this->set_fileDirectory("dox/files/");
					
					$fileUrl	= "modules/file/dox/files/".$row[5];
					$fileSize	= ceil(filesize($fileUrl) / 1024);
					$fileInfo	= $this->get_file_ext_name($fileUrl);
					
		  			$toRet .= "<div class=\"file_element\">
			  						<div class = \"file_element_title\">$row[3]</div>
			  						<div class=\"file_element_content\">
			  							<!-- <a href=\"documentation_upload.php?$this->mod_queryKey=$row[0]\"><img style=\"border:none;\" src=\"".$this->modDir."img/icons/$fileInfo[img]\" /></a> -->
			  							<a style=\"border:0;\" href=\"documentation_upload.php?$this->mod_queryKey=$row[0]\"><img style=\"border:none;\" src=\"".$this->modDir."img/icons/$fileInfo[img]\" /></a>
				  						<div class=\"file_element_content_descr\">".$this->chapo($row[4], 1200)."</div>
				  						<div class=\"file_element_content_prop\">
				  							<ul>
				  								<li><strong>".$mod_lang_output["FILE_LBL_FILE"]." :</strong> $fileInfo[type]</li>
			  									<li><strong>".$mod_lang_output["FILE_LBL_WIDTH"]." :</strong> $fileSize Ko</li>
			  									<li><a style=\"color:#fa2365; font-weight:bold;\" href=\"".$this->set_mod_detail_uri($pageDest, $id)."\">".$mod_lang_output["FILE_LBL_MORE"]."</a></li>
			  								</ul>
			  							</div>
			  						</div>
			  						<div class=\"file_element_link\">
			  							&raquo;<a href=\"$pageDest&$this->URI_fileVar=$row[0]\">".$mod_lang_output["FILE_LBL_DLD"]."</a>
			  						</div>
		  							<div class=\"clear_both\"></div>
		  					   </div>";
		  		}
		  		//Affichage de la ligne du menu de navigation
		  		$toRet 	.=$nav_menu;		  				  		
		  	}
		  	else{
		  		$toRet = "<p>Votre recherche n'a renvoy&eacute; aucun r&eacute;sultat!</p>";	
		  	}
		  	return $toRet."<div class=\"clear_both\"></div>";
		}
		
		function load_file_by_cat($pageDest, $new_fileCat, $nombre='25', $more="Read more", $lang="FR"){
			global $mod_lang_output, $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
			
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl_where1($this->tblFile, $this->fld_fileId, $this->fld_fileCatId, $new_fileCat);
			
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
			
			//Bloc menu de liens
			if($total > $nombre)
			    $nav_menu	= $this->affichepage_cat($nombre, $pageDest, $total, $new_fileCat);
		  			
						
		 	$query 		= 	"SELECT * FROM $this->tblFile WHERE $this->fld_modDisplay='1' AND ($this->fld_modLang='$lang' OR $this->fld_modLang = 'XX') AND $this->fld_fileCatId='$new_fileCat' ORDER BY 'file_title' DESC limit $limite, $nombre";
		  	$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les fichiers par categorie.<br />".mysqli_connect_error());
		  	if($total_1	= 	mysqli_num_rows($result)){
		  		$num	= 0;
		  		$toRet = $nav_menu;
		  		while($row = mysqli_fetch_row($result)){
		  			$num++;
		  			$id	= $row[0];
					//Alternate row
					$currentCls = ((($num%2) == 0) ? ("row1") : ("row2"));
					
					//mettre le chemin � jour :
					//$fileDir	= $this->set_fileDirectory("dox/files/");
					
					$fileUrl	= "modules/file/dox/files/".$row[5];
					$fileSize	= @ceil((filesize($fileUrl) / 1024));
					$fileInfo	= $this->get_file_ext_name($fileUrl);
		  			$toRet .= "<div class=\"file_element\">
			  						<div class = \"file_element_title\">$row[3]</div>
			  						<div class=\"file_element_content\">
			  							<a href=\"pageDest&$this->URI_fileVar=$row[0]\"><img style=\"border:0; margin-right:5px;\" src=\"".$this->modDir."img/icons/$fileInfo[img]\" /></a>
				  						<div class=\"file_element_content_descr\">".$this->chapo($row[4], 200)."</div>
				  						<div class=\"file_element_content_prop\">
				  							<ul>
				  								<li><strong>".$mod_lang_output["FILE_LBL_FILE"]." :</strong> $fileInfo[type]</li>
			  									<li><strong>".$mod_lang_output["FILE_LBL_WIDTH"]." :</strong> $fileSize Ko</li>
			  									<li><a style=\"color:#fa2365; font-weight:bold;\" href=\"$pageDest&$this->URI_fileVar=$row[0]\">".$mod_lang_output["FILE_LBL_MORE"]."</a></li>
			  								</ul>
			  							</div>
			  						</div>
			  						<div class=\"file_element_link\">
			  							&raquo;<a href=\"$fileUrl\">".$mod_lang_output["FILE_LBL_DLD"]."</a>
			  						</div>
		  							<div class=\"clear_both\"></div>
		  					   </div>";
		  		}
		  		//Affichage de la ligne du menu de navigation
		  		$toRet 	.= $nav_menu;		  				  		
		  	}
		  	else{
		  		$toRet = "<p>".$mod_lang_output['NO_FILE']."</p>";	
		  	}
		  	return $toRet."<div class=\"clear_both\"></div>";
		}
		
		
		//Creer le fichier
		function set_file($new_fileCatId,
						  $new_fileAuthor,
						  $new_fileTitle,
						  $new_fileDescr,
						  $new_fileUrl,
						  $new_fileDate,
						  $new_fileLang,
		                  $new_fileDisplay = '1'){
		    global $thewu32_cLink;
			//$new_fileId	=	($this->get_last_id($this->tbl_file, $this->fld_fileId) + 1);
			$query = "INSERT INTO $this->tblFile VALUES('".$this->file_autoIncr()."', '$new_fileCatId',
															'$new_fileAuthor',
															'$new_fileTitle',
															'$new_fileDescr',
															'$new_fileUrl',
															'$new_fileDate',
															'$new_fileLang',
															'$new_fileDisplay')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de cr&eacute;er le fichier...<br />".mysqli_connect_error());
			if($result)
			    return mysqli_insert_id($thewu32_cLink);
			else
				return false;
		}
		
		//Creer la categorie(type) de fichier
		function set_file_cat($new_catId, $new_catLib, $new_catDescr, $new_catLangId){
		    global $thewu32_cLink;
			$query	= "INSERT INTO $this->tblFileCat VALUES('$new_catId', '$new_catLib', '$new_catDescr', '$new_catLangId', '1')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de cr&eacute;er la cat&eacute;gorie de fichier...<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}
		function update_file_cat($new_catLib, $new_catDescr, $new_entry){
		    global $thewu32_cLink;
			$query = "UPDATE $this->tblFileCat SET file_cat_lib	= '$new_catLib', file_cat_descr = '$new_catDescr' WHERE $this->fld_fileCatId = '$new_entry'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de modifier la cat&eacute;gorie de fichier...<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}

	
	//Compter le nombre de fichiers qu'il ya dans la table des fichiers
	function count_files(){
		return $toRet = $this->count_in_tbl($this->tblFile, $this->fld_fileId);
	}
	
	function count_files_valid(){
		return $toRet = $this->count_in_tbl_where1($this->tblFile, $this->fld_fileId, "display", "1");
	}
	
	//Compter le nombre de fichiers par categorie
	function count_files_by_cat($newCat){
		return $toRet = $this->count_in_tbl_where1($this->tblFile, $this->fld_fileId, $this->fld_fileCatId, $newCat);
	}
		
	function update_file($new_fileCatId, $new_fileAuthor, $new_fileTitle, $new_fileDescr, $new_fileUrl, $new_fileDisplay, $new_entry, $new_fileLang){
	    global $thewu32_cLink;
		$query = "UPDATE $this->tblFile SET file_cat_id = '$new_fileCatId',
										    usr_id		= '$new_fileAuthor',
											file_title	= '$new_fileTitle',
											file_descr	= '$new_fileDescr',
											file_url	= '$new_fileUrl',
                                            lang_id     = '$new_fileLang',
											display		= '$new_fileDisplay'
											WHERE $this->fld_fileId = '$new_entry'";
		$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de mettre la table des fichiers &agrave; jour...<br />".mysqli_error($thewu32_cLink));
		if($result)
			return true;
		else
			return false;
	}
		
	//Compter le nombre de fichiers actifs par categorie 
	function count_files_by_cat_valid($newCat){
		return $toRet = $this->count_in_tbl_where2($this->tblFile, $this->fld_fileId, $this->fld_fileCatId, "display", $newCat, "1");
	}
		
	
	//Supprimer les fichiers
	function delete_file($new_fileId){
		//Obtenir le nom du fichier � supprimer depuis la bdd
		$file_tab 	= 	$this->get_file($new_fileId);
		//Le chemin complet vers le fichier
		$file_url	=	$this->fileDirectory.$file_tab[fileURL];
		//Suppression physique du fichier
		if($this->rem_entry($this->tbl_file, $this->fld_fileId, $new_fileId))
			return @unlink($file_url);
		else
			return false;
	}
		
	//Supprimer les categories
	function delete_file_cat($new_fileCatId){
		return $this->rem_entry($this->tblFileCat, $this->fld_fileCatId, $new_fileCatId);
	}
		
	function get_file($new_fileId){
	    global $thewu32_cLink;
		/*
		* Nous permet d'acc�der � un enregistrement gr�ce aux tableaux associatifs
		*
		* @param : $new_fileId = le fichier � afficher
		*/
		$query 	= "SELECT * FROM $this->tblFile WHERE $this->fld_fileId = '$new_fileId'";
		$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger le fichier...<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			while($row = mysqli_fetch_row($result)){
				$toRet = array(
							   "fileID"			=> 	$row[0],
							   "fileCATID"		=> 	$row[1],
							   "fileAUTHID"		=> 	$row[2],
							   "fileTITLE"		=> 	$row[3],
							   "fileDESCR"		=> 	$row[4],
							   "fileURL"		=> 	$row[5],
							   "fileDATE"		=> 	$row[6],
							   "fileLANGID"		=>	$row[7],
							   "fileDISPLAY"	=> 	$row[8]
							   );
			}
			return $toRet;
		}
		else
			return false;
	}
		
	function get_file_cat($new_fileCatId){
	    global $thewu32_cLink;
		/*
		* Nous permet d'acc�der � un enregistrement gr�ce aux tableaux associatifs
		*
		* @param : $new_fileCatId = la categorie de fichier � afficher
		*/
		$query 	= "SELECT * FROM $this->tblFileCat WHERE $this->fld_fileCatId = '$new_fileCatId'";
		$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger la categorie de fichier...<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			while($row = mysqli_fetch_row($result)){
				$toRet = array(
							   "fileCATID"		=>     $row[0],
							   "fileCATLIB"		=>     $row[1],
							   "fileCATDESCR"	=>     $row[2],
				               "fileCATLANG"    =>     $row[3],
				               "fileCATDISPLAY" =>     $row[4]
							   );
			}
			return $toRet;
		}
		else
			return false;
	}
		
	function get_file_by_id($fldToGet, $valId){
		/*
		* Obtenir la valeur d'un champ de la table des fichiers sachant son id
		* Raccourci pour get_field_by_id()
		*
		* @param : $fldToGet = Champ � interroger
		* @param : $valId	= Valeur � mettre � jour dans le champ interrog� $fldToGet
		*/
		return $this->get_field_by_id($this->tblFile, $this->fld_fileId, $fldToGet, $valId);
	}
		
	//Obtenir la categorie sachant l'id
	function get_file_cat_by_id($new_catId){
		return $this->get_field_by_id($this->tblFileCat, $this->fld_fileCatId, "file_cat_lib", $new_catId);
	}
		
	function update_file_by_field($fldToUpdate, $valUpdate, $new_fileId){
		/*
		* Mettre � jour n'importe kel champ de la table des fichiers, en sachant juste le nom du champ et l'id pivot
		* @param : $fldToUpdate = Champ � mettre � jour
		* @param : $valUpdate	= Nouvelle valeur saisie par l'user
		* @param : $new_fileId  = l'Id � circonscrire
		*/
		return $this->update_entry_by_id($this->tblFile, "file_id", $fldToUpdate, $valUpdate, $new_fileId);
	}
	
	//Recopie exacte de la methode precedente
	function file_element_update($fldToUpdate, $valUpdate, $new_fileId){
		return $this->update_file_by_field($fldToUpdate, $valUpdate, $new_fileId);
	}
		
	//Afficher ou masquer un fichier
	function set_file_state($new_fileId, $stateId){
		return $this->set_updated_1($this->tblFile, "display", $stateId, $this->fld_fileId, $new_fileId);
	}
		
	function update_user_file($fldToUpdate, $valUpdate, $new_usrId){
		/*
		* Mettre � jour n'importe kel champ de la table des fichiers, en sachant juste le nom du champ et l'id du user
		* @param : $fldToUpdate = Champ � mettre � jour
		* @param : $valUpdate	= Nouvelle valeur saisie par l'user
		* @param : $new_userId  = l'Id utilisateur � circonscrire
		*/
		return $this->update_entry_by_id($this->tblFile, $this->fld_usrId, $fldToUpdate, $valUpdate, $new_usrId);
	}
		
	function load_file_id(){
		/*
		* Affiche les ids des fichiers
		*/
		return $this->load_id($this->tblFile, $this->fld_fileId);			
	}
	
	function random_get_file($nbFile='0', $cls=''){
		//creer un tableau d'id des fichiers:
		$tab_filesId = $this->load_id($this->tblFile, $this->fld_fileId, "WHERE display='1'");
		//Faire un random dans le tableau d'id, retourne un tableau
		$tab_random = array_rand($tab_filesId, $nbFile);
		//Obtenir les enregistrements :
		foreach($tab_random as $value){
			$row_file = $this->get_file($value);
			$out		.= "<li><strong>$row_file[fileTITLE]</strong><a href=\"documentation_download.php?fId=$row_file[fileID]\"> (T&eacute;l&eacute;charger)</a></li>";
			//$out 		.= "<li>$value</li>";
		}
		//Sortie sous-forme de liste:
		return "<ul>$out</ul>";
	}
	
	//Load items
			function spry_ds_get_file_main(){
				/**
				 * @return {gallery xml content by cat}
				 *
				 * @descr : Charger les enregistrement de meme categorie pour le fichier xml
				 **/
			    global $thewu32_cLink;
				$query = "SELECT * FROM $this->tbl_file WHERE $this->fld_fileDisplay = '1' ORDER BY $this->fld_fileId DESC";
				$result = mysqli_query($thewu32_cLink, $query) or die("Unable to extract spry item for file module!<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					while($row = mysqli_fetch_array($result)){
						/*$toRet.='
						 <galleryItem id="'.$row["gallery_id"].'">
						 <galleryThumbs><![CDATA['.$row["gallery_lib"].']]></galleryThumbs>
						 <galleryTitle><![CDATA['.$row["gallery_title"].']]></galleryTitle>
						 <galleryDescr><![CDATA['.$row["gallery_descr"].']]></galleryDescr>
						 </galleryItem>';*/
						$catLib	=	$this->get_file_cat_by_id($row[1]);
						
						$fileUrl	= "modules/file/dox/files/".$row[5];
						$fileSize	= @ceil((filesize('../'.$fileUrl) / 1024));
						$fileInfo	= $this->get_file_ext_name($fileUrl);
						
						$toRet.='<item id="'.$row[0].'" cat="'.$row[1].'">
										<cat><![CDATA['.$catLib.']]></cat>
										<date>'.$row[6].'</date>
										<title><![CDATA['.$row[3].']]></title>
										<desc><![CDATA['.$this->chapo($row[4], 60).']]></desc>
										<icon><![CDATA['.$this->modDir.'/img/icons/'.$fileInfo[img].']]></icon>
										<filetype><![CDATA['.$fileInfo[type].']]></filetype>
										<filesize>'.$fileSize.'</filesize>
										<location><![CDATA['.$fileUrl.']]></location>
										<url><![CDATA['.$this->get_pages_modules_links('file', $row[7]).'-detail-'.$row[0].'.html'.']]></url>
										<lang>'.$row[7].'</lang>
									</item>';
					}
				}
				return $toRet;
			}
			
			function file_autoIncr(){
				return $this->autoIncr($this->tbl_file, $this->fld_fileId);
			}
			
			/* function spry_ds_create(){
				return $this->digitra_spry_xml_create($this->modName, $this->spry_ds_get_file_main());
			} */

			/* The base
			function load_file_accordion($nbElts){
				$arr_fileCat	=	$this->load_field_display($this->tblFileCat, $this->fld_fileCatId, '1');

				$toRet_head		=	'';
				$toRet_title	=	'';
				$final			=	'';

				foreach($arr_fileCat as $cat){
					$toRet_head 		= 	"<h1>".$this->get_file_cat_by_id($cat)."</h1>";
					$arr_fileTitle		=	$this->load_field_by_cat($this->tblFile, $this->fld_fileTitle, $this->fld_fileCatId, $cat, $nbElts);
					foreach($arr_fileTitle as $title){
						$new_title 		.=	"<p>$title</p>";
						$toRet_title	=	$new_title;
					}
					$new_title			=	'';
					$final	.=	$toRet_head . $toRet_title;	
				}
				return $final;
			} */

			function load_file_accordion($new_filePage='file.php', $nbElts='3', $lang='FR'){
				$arr_fileCat	=	$this->load_field_display($this->tblFileCat, $this->fld_fileCatId, '1', $lang);

				$toRet_head		=	'';
				$toRet_title	=	'';
				$final			=	'';
				if(is_array($arr_fileCat)){
					foreach($arr_fileCat as $cat){
						$toRet_head 		= 	"<button class=\"accordion\">".$this->get_file_cat_by_id($cat)."</button>";
						$arr_fileTitle		=	$this->load_field_by_cat_2($this->tblFile, $this->fld_fileId, $this->fld_fileTitle, $this->fld_fileCatId, $cat, $nbElts);
						foreach($arr_fileTitle as $file){
							$new_title_open	=	"<div class=\"panel\"><ul>";
							$new_title_close=	"</ul></div>";
							//$fileId 		=	$this->get_field_by_id($this->tblFile, $this->fld_fileTitle, )
							$new_title 		.=	"<li><a href=\"$new_filePage"."-detail-".$file[ID].".html\">$file[LIB]</a></li>";
							$toRet_title	=	$new_title;
						}
						$new_title			=	'';
						$final	.=	$toRet_head . $new_title_open.$toRet_title.$new_title_close;	
					}
					return $final;
				}
				else
					return false;
			}
}
?>