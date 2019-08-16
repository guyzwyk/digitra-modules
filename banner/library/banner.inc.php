<?php //require_once("/scripts/incfiles/config.inc.php"); ?>
<?php
	class cwd_banner extends cwd_system{
		/*Directories set*/
		var $banner_imgDefault;
		
		var $tbl_banner;
		var $tbl_bannerPosition;
		
		var $fld_bannerId;
		var $fld_bannerPositionId;
		var $fld_bannerPageId;
		
		var $fld_bannerFile;
		var $fld_bannerLang;
		var $fld_bannerType;
		var $fld_bannerPositionLib;
		var $fld_bannerDescr;
		var $fld_bannerDisplay;
		var $fld_bannerFileLink;
		var $fld_bannerDate;
		
		var $URI_bannerVar	= 'banId';
		var $ban_imgDir		= 'modules/banner/bans/';

		public function __construct(){
            global $thewu32_tblPref, $thewu32_cLink;
            $this->tbl_banner     		= $thewu32_tblPref.'banner';
            $this->tbl_bannerPosition	= $thewu32_tblPref.'banner_position';

            $this->fld_bannerId				= "banner_id";
            $this->fld_bannerPositionId		= "banner_position_id";
            $this->fld_bannerPageId			= 'pages_id';


            $this->banner_imgDefault		= "banner.jpg"; //???
            $this->fld_bannerFile			= 'banner_file';
            $this->fld_bannerLang			= 'banner_lang';
            $this->fld_bannerPositionLib	= 'banner_position_lib';
            $this->fld_bannerType			= 'banner_type';
            $this->fld_bannerDescr			= 'banner_descr';
            $this->fld_bannerDisplay		= 'display';
            $this->fld_bannerFileLink		= 'banner_link';
            $this->fld_bannerDate			= 'banner_date_expire';

            //$this->set_uri_banner("banId");
            //return $toRet = array("BANNER"=>($this->tbl_banner), "BANNER_CAT" => ($this->tbl_bannerCat), "BANNER_URI"=>($this->URI_banner));
        }

		function cwd_banner(){ //Constructeur de la classe
			self::__construct();
		}
		
		function admin_load_menu(){
	  	$toRet = "<div class=\"ADM_menu\">
						  <h1>Banners management</h1>
						  <ul class=\"ADM_menu_title\">
						  	<h2>The Banners</h2>
						  	<li><a href=\"?what=bannerDisplay\">List banners</a></li>
							<li><a href=\"?what=bannerInsert\">New banner</a></li>
							<li><a href=\"?what=homeBannerInsertUpdate\">Home banner</a></li>
						  </ul>
						  <ul class=\"ADM_menu_title\">
						  	<h2>The banners positions</h2>
						  	<li><a href=\"?what=bpDisplay\">List Banners positions</a></li>
						  </ul>
						  <div class=\"ADM_menu_descr\"></div>
					  </div>";
			return $toRet;
	  }
	
	  
		function get_page_banner($pageLang="EN"){
		    global $thewu32_cLink;
			$query 	= "SELECT * FROM $this->tbl_banner WHERE banner_lang = '$pageLang'";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to get page banner!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = array();
				while($row = mysqli_fetch_array($result)){
					$toRet = array(
							 "ID"	=> $row[0],
							 "FILE"	=> $row[1],
							 "LANG"	=> $row[2],
							 "TYPE"	=> $row[3]);
					
				}
				return $toRet;
			}
			else 
				return false;
		}
		
		/**
		 * @param int $new_bannerId
		 * @return array or false
		 * 
		 * @desc get a record of a banner
		 * */
		function get_banner($new_bannerId){
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_banner WHERE $this->fld_bannerId = '$new_bannerId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to get the $new_bannerId record!<br />".mysqli_connect_error());
			
			if($total = mysqli_num_rows($result)){
				while($row = mysqli_fetch_array($result)){
					$toRet = array(
								"ID" 			=> 	$row[0],
								"FILE"			=>	$row[1],
								"TYPE"			=>	$row[2],
								"PAGE_ID"		=>	$row[3],
								"POSITION_ID"	=>	$row[4],
								"DESCR"			=>	$row[5],
								"LINK"			=>	$row[6],
								"DATE_EXPIRE"	=>	$row[7],
								"DISPLAY"		=>	$row[8]
					);
				}
				return $toRet;
			}
			else
				return false;
		}
		
		function cmb_load_ban_position($varRefresh){
			return $this->upd_combo_sel_row_2($this->tbl_bannerPosition, $this->fld_bannerPositionId, $this->fld_bannerPositionLib, $varRefresh, "");
		}
		
	
		
		/**
		 * @param int new_banPage
		 * @param int new_banPosition
		 * @param string $new_banFile
		 * @param string $new_banDescr
		 * @param date $new_banDateExpire
		 * 
		 * @desc Insert a new banner
		 * @return true / false
		 * */
		function set_banner($new_banPage, $new_banType, $new_banPosition, $new_banFile, $new_banDescr, $new_banLink, $new_banDateExpire){
		    global $thewu32_cLink;
			$query = "INSERT INTO $this->tbl_banner VALUES('".$this->banner_autoIncr()."', 
														   '$new_banFile', 
														   '$new_banType', 
														   '$new_banPage', 
														   '$new_banPosition', 
														   '$new_banDescr',
														   '$new_banLink',
														   '$new_banDateExpire', 
														   '1')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to add a new banner!<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}
		
		/*
		 * @param int $new_pageId
		 * @param int $new_banPosition
		 * 
		 * @desc Obtenir la banniere propre a une page
		 * @desc Ban script for any page but homepage
		 * */
		function get_page_ban($new_pageId, $new_banPosition, $banCls=""){
		    global $thewu32_cLink;
			$dayDate	= $this->get_date();
			$query 		= "SELECT * FROM $this->tbl_banner WHERE $this->fld_bannerPageId = '$new_pageId' AND $this->fld_bannerPositionId = '$new_banPosition' AND $this->fld_bannerDate >= '$dayDate' AND $this->fld_bannerDisplay = '1'";
			$result 	= mysqli_query($thewu32_cLink, $query) or die("Unable to load page banner!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
		  		while($row = mysqli_fetch_row($result)){
		  			//Flash <embed> for the updated version
			  		if($row[2] == 'swf'){
			  			$img	=	"<embed src=\"$this->ban_imgDir$row[1]\" width=\"462\" height=\"100\"></embed>";
			  		}
			  		else{
			  			$img	=	($row[6] == "") ? ("<img class=\"$banCls\" border=\"0\" src=\"$this->ban_imgDir$row[1]\" />") : ("<a target=\"_blank\" href=\"$row[6]\"><img class=\"$banCls\" border=\"0\" src=\"$this->ban_imgDir$row[1]\" /></a>");
			  		}
			  	}
			}
			else{
			  	$img = false;
			}
  			return $img;
		}
		
		/*
		 * @param int $new_homePageId
		 * @param int $new_banPosition
		 * 
		 * @desc Obtenir la banniere de la page d'accueil
		 * @desc Ban Script only for homepages
		 * */
		function get_home_ban($new_homePageId, $new_banPosition='6', $banCls="banHome"){
		    global $thewu32_cLink;
			$dayDate	=	$this->get_date();
			$query		=	"SELECT * FROM $this->tbl_banner WHERE $this->fld_bannerPageId = '$new_homePageId' AND $this->fld_bannerPositionId = '$new_banPosition' AND $this->fld_bannerDate >= '$dayDate' AND $this->fld_bannerDisplay = '1'";
			$result 	= 	mysqli_query($thewu32_cLink, $query) or die("Unable to load homepage banner!<br />".mysqli_connect_error());
  			if($total = mysqli_num_rows($result)){
		  		while($row = mysqli_fetch_row($result)){
		  			//Flash <embed> for the updated version
		  			if($row[2] == 'swf'){
		  				$img	=	"<embed class=\"$banCls\" src=\"$this->ban_imgDir$row[1]\" width=\"462\" height=\"100\"></embed>";
		  			}
		  			else{
		  				//$img	=	"<img class=\"$banCls\" border=\"0\" src=\"$this->ban_imgDir$row[1]\" />";
		  				$img	=	($row[6] == "") ? ("<img class=\"$banCls\" border=\"0\" src=\"$this->ban_imgDir$row[1]\" />") : ("<a target=\"_blank\" href=\"$row[6]\"><img class=\"$banCls\" border=\"0\" src=\"$this->ban_imgDir$row[1]\" /></a>");
		  			}
		  		}
		  	}
		  	else {
		  		$img = false;
		  	}
  			return $img;
		}
				
		
	function tbl_load_banners(){
		global $mod_lang_output, $thewu32_cLink;
		
	  	$query 		= 	"SELECT * FROM $this->tbl_banner ORDER BY $this->fld_bannerPageId";
	  	$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les banni&egrave;res.<br />".mysqli_error($thewu32_cLink));
	  	if($total	= 	mysqli_num_rows($result)){
	  		
	  		$num	= 0;
	  		$array_pos = array();
	  		$myPage = new cwd_page();
	  		$toRet 	= "<table  class=\"table table-bordered\">
	  					<tr>
							<th>&num;</th>
							<th>".$mod_lang_output['TABLE_HEADER_POSITION']."</th>
							<th>".$mod_lang_output['TABLE_HEADER_PAGES']."</th>
							<th>".$mod_lang_output['TABLE_HEADER_DESCRIPTION']."</th>
							<th>".$mod_lang_output['TABLE_HEADER_URL']."</th>
							<th nowrap>".$mod_lang_output['TABLE_HEADER_EXP-DATE']."</th>
							<th>".$mod_lang_output['TABLE_HEADER_ACTION']."</th>
						</tr>";
	  		while($row = mysqli_fetch_row($result)){
	  			$num++;
	  			$id	= $row[0];
	  			//$pos = $this->get_page_order($id); // Les positionnements des menus pour monter/descendre
	  			$banPosition	= $this->get_field_by_id($this->tbl_bannerPosition, $this->fld_bannerPositionId, $this->fld_bannerPositionLib, $row[4]);
	  			$banPage		= $myPage->get_page_by_id($myPage->fld_pageLib, $row[3]);
	  			$state_txt = (($row[8] == 0) ? ("[ Pub. ]") : ("[ Priv. ]"));
	  			$state_img = (($row[8] == 0) ? ("<img src=\"img/icons/disabled.gif\" />") : ("<img src=\"img/icons/enabled.gif\" />"));
	  			$state_lnk = (($row[8] == 0) ? ("?page=banner&what=display&action=show") : ("?page=banner&what=display&action=hide"));
	  			$state_alt = (($row[8] == 0) ? ("Set public") : ("Set private"));
	  			$state_cls = (($row[8] == 0) ? ("green") : ("red"));
				//Alternate row
				$currentCls = ((($num%2) == 0) ? ("ADM_row1") : ("ADM_row2"));
	  			
	  			$toRet .= "<tr class=\"$currentCls\">
	  							<th row=\"scope\" align=\"center\">$num</th>
	  							<td>$banPosition</td>
	  							<td>$banPage</td>
	  							<td>$row[5]</td>
	  							<td>$row[6]</td>
	  							<td>".$this->date_fr2($row[7])."</td>
	  							<td nowrap class=\"col-action\"><a title=\"Edit\" href=\"?page=banner&what=update&$this->URI_bannerVar=$row[0]\"><img src=\"img/icons/edit.gif\" /></a> &nbsp; <a title=\"Delete\" onclick=\"return confirm('Sure you want to delete the selected banner?')\" href=\"?page=banner&what=display&action=delete&$this->URI_bannerVar=$row[0]\"><img src=\"img/icons/delete.gif\" /></a> &nbsp; <a class=\"$state_cls\" title=\"$state_alt\" href=\"$state_lnk&$this->URI_bannerVar=$row[0]\">$state_img</a></td>
	  					   </tr>";
	  		}
  		}
  		else{
  			$toRet = "<tr><td colspan=\"7\">Aucune banni&egrave;re &agrave; afficher</td></tr>";	
  		}
  		return $toRet."</table>";
	}
		
	function tbl_load_banners_positions(){
	    global $thewu32_cLink;
	  	$query 		= 	"SELECT * FROM $this->tbl_bannerPosition ORDER BY $this->fld_bannerPositionId";
	  	$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les positions des banni&egrave;res.<br />".mysqli_connect_error());
	  	if($total	= 	mysqli_num_rows($result)){
	  		$toRet 	= "";
	  		$num	= 0;
	  		$array_pos = array();
	  		while($row = mysqli_fetch_row($result)){
	  			$num++;
	  			$id	= $row[0];
	  			
				//Alternate row
				$currentCls = ((($num%2) == 0) ? ("ADM_row1") : ("ADM_row2"));
				
	  			$toRet .= "<tr class=\"$currentCls\">
	  							<td align=\"center\">$num</td>
	  							<td>$row[1]</td>
	  							<td align=\"center\"><a title=\"Edit\" href=\"?what=bpUpdate&$this->URI_bpVar=$row[0]\"><img src=\"img/icons/edit.gif\" /></a> &nbsp; <a title=\"Delete\" onclick=\"return confirm('Sure you want to delete the selected banner position?')\" href=\"?what=bpDelete&$this->URI_bpVar=$row[0]\"><img src=\"img/icons/delete.gif\" /></a></td>
	  					   </tr>";
	  		}
	  	}
	  	else{
	  		$toRet = "Aucune position de banni&egrave;re &agrave; afficher";	
	  	}
	  	return $toRet;
	  }
	  
	  /**
	   * @param int $new_banId
	   * @param string $new_banFile
	   * @param char $new_banType
	   * @param int $new_pageId
	   * @param int $new_banPositionId
	   * @param string $new_banDescr
	   * @param string $new_banLink
	   * @param date $new_banDateExpire
	   * @param char $new_banDisplay
	   * 
	   * @return true/false
	   * 
	   * @desc Update a record of banner
	   * */
	  function update_banner($new_banId, $new_banFile, $new_banType, $new_banPageId, $new_banPositionId, $new_banDescr, $new_banLink, $new_banDateExpire, $new_banDisplay){
	    global $thewu32_cLink;
	  	$query = "UPDATE $this->tbl_banner SET 
	  						banner_file			= 	'$new_banFile',
	  						banner_type			=	'$new_banType',
	  						pages_id			=	'$new_banPageId',
	  						banner_position_id	=	'$new_banPositionId',
	  						banner_descr		=	'$new_banDescr',
	  						banner_link			=	'$new_banLink',
	  						banner_date_expire	=	'$new_banDateExpire',
	  						display				=	'$new_banDisplay'
	  	WHERE $this->fld_bannerId = '$new_banId'";
	  	
	  	$result = mysqli_query($thewu32_cLink, $query) or die("Unable to update the banner identified by $new_banId !<br />".mysqli_connect_error());
	  	if($result)
	  		return true;
	  	else
	  		return false;
	  }
	  
	  function banner_delete($new_banId, $new_banUrl){
	  	$ban_toDelete = $this->get_field_by_id($this->tbl_banner, $this->fld_bannerId, $this->fld_bannerFile, $new_banId);
	  	if(($this->rem_entry($this->tbl_banner, $this->fld_bannerId, $new_banId)) && (unlink($new_banUrl.$ban_toDelete)))
	  		return true;
	  	else
	  		return false;
	  }
	  
	  /**
	   * @param int $new_bannerId
	   * @param int $new_switchVal
	   * 
	   * @return true/false
	   * 
	   * @desc Display or hide banner (fld_display = 1 or 0)
	   * */
	  function switch_banner_state($new_bannerId, $new_switchVal='0'){
	  	return $toRet = $this->set_connected($this->tbl_banner, 'display', $this->fld_bannerId, $new_bannerId, $new_switchVal);
	  }
	  
	  //Compter le nombre de bannieres qu'il ya dans la table des bannieres
	  function count_banners(){
	  	return $toRet = $this->count_in_tbl($this->tbl_banner, $this->fld_bannerId);
	  }
		
	  function banner_autoIncr(){
	  	return $this->autoIncr($this->tbl_banner, $this->fld_bannerId);
	  }
	}
?>