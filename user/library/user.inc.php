<?php
	class cwd_user extends cwd_page{
		var $tbl_user;
		var $tbl_userType;
		var $tbl_userDetail;
		
		var $fld_userId;
		var $fld_userTypeId;
		var $fld_userDetailId;
		
		
		
		var $fld_userTypeLib;
		var $fld_userDateInsert;
		var $fld_userLogin;
		var $fld_userPass;
		var $fld_userDetailLastName;
		var $fld_userDetailFirstName;
		var $fld_userDetailEmail;
		var $fld_userDisplay;
		
		var $mod_queryKey 	= 'userId';
		var $mod_fkQueryKey	= 'userTypeId';
		
		var $URI_userVar;
		var $URI_userTypeVar;
		
		//Adds from otourix : Members management
		
		public function __construct(){
            global $thewu32_tblPref;
            $this->tbl_user 				= 	$thewu32_tblPref.'usr';
            $this->tbl_userType				= 	$thewu32_tblPref.'usr_level';
            $this->tbl_userDetail			= 	$thewu32_tblPref.'usr_detail';


            $this->fld_userId				= 	'usr_id';
            $this->fld_userTypeId			= 	'usr_level_id';
            $this->fld_userTypeLib			= 	'usr_level_lib';
            $this->fld_userDetailId			= 	'usr_detail_id';
            $this->fld_userDisplay			= 	'display';


            $this->fld_userTypeLib			= 	'usr_level_lib';
            $this->fld_userDateInsert		= 	'usr_date_enreg';

            $this->fld_userLogin			= 	'usr_login';
            $this->fld_userPass				= 	'usr_pass';

            $this->fld_userDetailFirstName	= 	'usr_detail_first';
            $this->fld_userDetailLastName	= 	'usr_detail_last';
            $this->fld_userDetailEmail		= 	'usr_detail_email';


            $this->set_uri_user("userId");
            $this->set_uri_user_type("user_typeId");


            //Otourix adds
        }

		function cwd_user(){
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
						  <h1>User Manager</h1>
						  <ul class=\"ADM_menu_title\">
						  	<h2>Users</h2>
						  	<li><a href=\"?what=userDisplay\">Display users</a></li>
							<li><a href=\"?what=userInsert\">Create users</a></li>
						  </ul>
						  <ul class=\"ADM_menu_title\">
						  <h2>User categories</h2>
						  	<li><a href=\"?what=userCatDisplay\">Display users categories</a></li>
							<li><a href=\"?what=userCatInsert\">Add user category</a></li>
						  </ul>
						  <div class=\"ADM_menu_descr\"></div>
					  </div>";
			return $toRet;				  
		}
		
		/**
		 * Definir la variabe d'url pour les users
		 * 
		 * @param string $new_uriVar
		 *
		 * @return void()*/
		function set_uri_user($new_uriVar){
			return $this->URI_userVar = $new_uriVar;
		}
		
		/**
		 * Definir la variabe d'url pour les types d'users
		 * 
		 * @param string $new_uriTypeVar
		 *
		 * @return void()*/
		function set_uri_user_type($new_uriTypeVar){
			return $this->URI_userTypeVar = $new_uriTypeVar;
		}
		
	function admin_load_users($nombre='10'){
			global $mod_lang_output, $thewu32_cLink;
			
			$limite = $_REQUEST[limite];
			
			//Recherche du nom de la page
			$path_parts = pathinfo($PHP_SELF);
			$page = $path_parts["basename"];
			
			//Obtention du total des enregistrements de users uniquement:
			$total = $this->count_in_tbl($this->tbl_user, $this->fld_userId);
			
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
				if(!$veriflimite) $limite = 0;
				
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
				
			$query 	= "SELECT * FROM $this->tbl_user ORDER BY $this->fld_userDateInsert DESC LIMIT ".$limite.",".$nombre;
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load users!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$num	= 0;
				$toRet 	= $nav_menu;
				//$toRet 	.= "";
				while($row = mysqli_fetch_array($result)){
					$num++;
					//alterner les liens public / prive
					
					$state_txt = (($row[6] == 0) ? ("[ Pub. ]") : ("[ Priv. ]"));
		  			$state_img = (($row[6] == 0) ? ("<img src=\"img/icons/disabled.gif\" />") : ("<img src=\"img/icons/enabled.gif\" />"));
		  			$state_lnk = (($row[6] == 0) ? ("?page=user&what=display&action=show") : ("?page=user&what=display&action=hide"));
		  			$state_alt = (($row[6] == 0) ? ("Activate") : ("De-activate"));
		  			$state_cls = (($row[6] == 0) ? ("green") : ("red"));
					
					//Convertir la date
					$dateInsert		= $this->datetime_en3($row[4]);
					
					//Alternet les css
					$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
					$usr_fName 	= $this->get_user_detail_by_user_id($this->fld_userDetailFirstName, $row[0]);
					$usr_lName	= $this->get_user_detail_by_user_id($this->fld_userDetailLastName, $row[0]);
					$usrEmail	= $this->get_user_detail_by_user_id($this->fld_userDetailEmail, $row[0]);
					$usrStatus	= $this->get_user_type_by_id($this->fld_userTypeLib, $row[3]);
					
					//if($row[0] == $_SESSION['uId'])
					
					$toRet .="<tr class=\"$currentCls\">
								<th scope=\"row\">$num</th>
								<td>".strtoupper($usr_lName)." ".ucfirst($usr_fName)."</td>
								<td>$row[1]</td>
								<td>$usrEmail</td>
								<td>$usrStatus</td>
								<td>$dateInsert</td>
								<td style=\"text-align:center; background:#FFF\">
									<a title=\"".$mod_lang_output['TABLE_TOOLTIP_UPDATE']."\" href=\"?page=user&what=update&action=update&$this->URI_userVar=$row[0]\"><img src=\"img/icons/edit.gif\" /></a>
									<a title=\"".$mod_lang_output['TABLE_TOOLTIP_DELETE']."\" onclick=\"return confirm('Sure you want to delete the selected user?')\" href=\"?page=user&what=display&action=delete&$this->URI_userVar=$row[0]\"><img src=\"img/icons/delete.gif\" /></a>
									<a title=\"$state_alt\" class=\"$state_cls\" href=\"$state_lnk&$this->URI_userVar=$row[0]\">$state_img</a>
								</td>
								
							  </tr>";
				}
				$toRet .= "</table>$nav_menu";
				
			}
			else{
				$toRet	= "No user";
			}
			return $toRet;
		}
		
		function admin_load_users_cat($nombre='50'){
		    global $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
			
			//Recherche du nom de la page
			$path_parts = pathinfo($PHP_SELF);
			$page = $path_parts["basename"];
			
						
			$query 	= "SELECT * FROM $this->tbl_userType ORDER BY $this->fld_userTypeLib";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load users categories!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$num	= 0;
				$toRet 	= "";
				//$toRet 	.= "";
				while($row = mysqli_fetch_array($result)){
					$num++;
					
					$userSystem		=	array('0', '1', '2');
					$adminSystem	=	array('0', '1');
					
					if(!in_array($row[0], $userSystem))
						$delete_action	=	"<a title=\"Delete the user category\" onclick=\"return confirm('Sure you want to delete the selected user category?')\" href=\"?page=user&what=catDisplay&action=catDelete&$this->URI_userTypeVar=$row[0]\"><img src=\"img/icons/delete.gif\" /></a>";
					if(!in_array($row[0], $adminSystem))
						$update_action	=	"<a title=\"Update the user category\" href=\"?page=user&what=catUpdate&action=catUpdate&$this->URI_userTypeVar=$row[0]\"><img src=\"img/icons/edit.gif\" /></a>";
					
					//Alternet les css
					$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
					$toRet .="<tr class=\"$currentCls\">
								<th scope=\"row\" align=\"center\">$num</th>
								<td>".ucfirst($row[1])."</td>
								<td style=\"text-align:center; background:#FFF\">
									$update_action &nbsp; $delete_action
								</td>
								
							  </tr>";
				}
				$toRet .= "</table>";
				
			}
			else{
				$toRet	= "No user category to be displayed";
			}
			return $toRet;
		}
		
		//Load a usere form
		function frm_load_login_user(){
			
		}
		
		function create_user($new_userLogin, $new_userPass, $new_userCatId, $new_userDateEnreg, $new_isConnected, $new_display){
		    $new_userId	=	$this->user_autoIncr();
		    global $thewu32_cLink;
            $query = "INSERT INTO $this->tbl_user VALUES('$new_userId',
														 '$new_userLogin', 
														 '$new_userPass', 
														 '$new_userCatId', 
														 '$new_userDateEnreg', 
														 '$new_isConnected',
														 '$new_display')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to create user<br />".mysqli_error($thewu32_cLink));
			if($result)
				return $new_userId; //return the created id
			else
				return false;
		}
		
		function create_user_detail($new_userDetailFirst, $new_userDetailLast, $new_userDetailEmail, $new_userDetailTelephone, $new_userDetailImg, $new_userId){
		    global $thewu32_cLink;
			//$new_userDetailId	=	($this->get_last_id($this->tbl_userDetail, $this->fld_userDetailId)	+	1);
			$query = "INSERT INTO $this->tbl_userDetail VALUES('".$this->userdetail_autoIncr()."',
														 	   '$new_userDetailFirst', 
														 	   '$new_userDetailLast', 
														 	   '$new_userDetailEmail', 
														 	   '$new_userDetailTelephone', 
														 	   '$new_userDetailImg',
														 	   '$new_userId')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to append user details<br />".mysqli_error($thewu32_cLink));
			if($result)
				return true;
		}
		
		function create_user_cat($new_userCatLib){
		    global $thewu32_cLink;
			$query = "INSERT INTO $this->tbl_userType VALUES('".$this->usercat_autoIncr()."',
															'$new_userCatLib')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to create user<br />".mysqli_error($thewu32_cLink));
			if($result)
				/*return mysql_insert_id();
			else
				return false;
			*/
				return true;
		}

		function set_connected_user($new_userId, $new_valConnected){
			return $this->set_connected($this->tbl_user, 'is_connected', $this->fld_userId, $new_userId, $new_valConnected);
		}
		
		function get_user_by_id($new_fld, $new_entry){
			return $this->get_field_by_id($this->tbl_user, $this->fld_userId, $new_fld, $new_entry);
		}
		
		function get_user_type_by_id($new_fld, $new_entry){
			return $this->get_field_by_id($this->tbl_userType, $this->fld_userTypeId, $new_fld, $new_entry);
		}
		
		function get_user_detail_by_id($new_fld, $new_entry){
			return $this->get_field_by_id($this->tbl_userDetail, $this->fld_userDetailId, $new_fld, $new_entry);
		}
		
		function get_user_detail_by_user_id($new_fld, $new_entry){
			return $this->get_field_by_id($this->tbl_userDetail, $this->fld_userId, $new_fld, $new_entry);
		}
		
		/**
		 * @param string $new_userLogin
		 * @desc Load an associative array of user record knowing the user login
		 * @return array_assoc*/
		function get_user_by_login($new_userLogin){
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_user WHERE $this->fld_userLogin = '$new_userLogin'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to load user record by login!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				while($row = mysqli_fetch_row($result)){
					$toRet = array("u_ID"			=> $row[0],
								   "u_LOGIN"		=> $row[1],
								   "u_PASS"			=> $row[2],
								   "u_TYPE"			=> $row[3],
								   "u_DATEENREG"	=> $row[4],
								   "u_ISCONNECTED"	=> $row[5],
								   "u_DISPLAY"		=> $row[6]);								
				}
				return $toRet;
			}
			else
				return false;
		}
		
		function get_user($new_userId){
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_user WHERE $this->fld_userId = '$new_userId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to load user record<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				while($row = mysqli_fetch_row($result)){
					$toRet = array("u_ID"			=> $row[0],
								   "u_LOGIN"		=> $row[1],
								   "u_PASS"			=> $row[2],
								   "u_TYPE"			=> $row[3],
								   "u_DATEENREG"	=> $row[4],
								   "u_ISCONNECTED"	=> $row[5],
								   "u_DISPLAY"		=> $row[6]);								
				}
				return $toRet;
			}
			else
				return false;
		}
		
		function get_user_detail($new_userId){
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_userDetail WHERE $this->fld_userId = '$new_userId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to load user detail record<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				while($row = mysqli_fetch_row($result)){
					$toRet = array("ud_ID"			=> $row[0],
								   "ud_FIRST"		=> $row[1],
								   "ud_LAST"		=> $row[2],
								   "ud_EMAIL"		=> $row[3],
								   "ud_TELEPHONE"	=> $row[4],
								   "ud_IMGID"		=> $row[5],
								   "ud_USERID"		=> $row[6]);								
				}
				return $toRet;
			}
			else
				return false;
		}
		
		function get_user_type($new_userTypeId){
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_userType WHERE $this->fld_userTypeId = '$new_userTypeId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to load user category record<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				while($row = mysqli_fetch_row($result)){
					$toRet = array("ut_ID"			=> $row[0],
								   "ut_LIB"			=> $row[1]);
				}
				return $toRet;
			}
			else
				return false;
		}
		function get_user_cat($new_userCatId){
			return $this->get_user_type($new_userCatId);
		}
		
		/**
		 * @param int $new_userCatId
		 * @param string $new_userCatVal
		 * @return true/false
		 * @desc Update user category
		 * */
		function update_user_cat($new_userCatId, $new_userCatVal){
			return $this->update_entry_cat($this->tbl_userType, $this->fld_userTypeId, $this->fld_userTypeLib, $new_userCatVal, $new_userCatId);
		}
		
		/**
		 * @param int $new_userCatId
		 * @return true/false
		 * @desc Delete user category
		 * */
		function delete_user_cat($new_userCatId){
			return $this->rem_entry($this->tbl_userType, $this->fld_userTypeId, $new_userCatId);
		}
		
		/*Activer/desactiver un utilisateur */
		function set_user_state($new_userId, $new_stateId){
			return $this->set_updated_1($this->tbl_user, "display", $new_stateId, $this->fld_userId, $new_userId);
		}
		
		/*Rendre public/prive une categorie d'utilisateur*/
		function set_usercat_state($new_userTypeId, $new_stateId){
			return $this->set_updated_1($this->tbl_userType, "display", $new_stateId, $this->fld_userTypeId, $new_userTypeId);
		}

		/**
		 * @param int $new_userId
		 * @return true/false
		 * @desc Delete user
		 * */
		function delete_user($new_userId){
			return $this->rem_entry($this->tbl_user, $this->fld_userId, $new_userId);
		}
		
		/**
		 * @param int $new_valId
		 * @param string $new_userLogin
		 * @param string $new_userPass
		 * @param int $new_userCat
		 * @param date $new_userDateEnreg
		 * @param int $new_userIsConnected
		 * @param char $new_userDisplay
		 * @return true/false
		 * @desc Update user
		 * */
		function update_user($new_valId, $new_userLogin, $new_userPass, $new_userCat, $new_userDateEnreg, $new_userIsConnected, $new_userDisplay){
		    global $thewu32_cLink;
			$query = "UPDATE $this->tbl_user SET $this->fld_userLogin 		= '$new_userLogin',
												 $this->fld_userPass		= '$new_userPass',
												 $this->fld_userTypeId		= '$new_userCat',
												 $this->fld_userDateInsert	= '$new_userDateEnreg',
												 is_connected				= '$new_userIsConnected',
												 display					= '$new_userDisplay'
											 WHERE $this->fld_userId = '$new_valId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to update user account.<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}
		
		function update_user_detail($new_valId, $new_userDetailFirst, $new_userDetailLast, $new_userDetailEmail, $new_userDetailTelephone, $new_userDetailImg){
		    global $thewu32_cLink;
			$query = "UPDATE $this->tbl_userDetail SET  $this->fld_userDetailFirstName 		= '$new_userDetailFirst',
												 		$this->fld_userDetailLastName		= '$new_userDetailLast',
												 	   	$this->fld_userDetailEmail			= '$new_userDetailEmail',
												 		usr_detail_teleph					= '$new_userDetailTelephone',
												 		img_id								= '$new_userDetailImg'
											 WHERE usr_id = '$new_valId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to update user details.<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;			
		}
		
		//Compter le nombre de fichiers qu'il ya dans la table des fichiers
		function count_users(){
			return $toRet = $this->count_in_tbl($this->tbl_user, $this->fld_userId);
		}
		
		function user_autoIncr(){
			return $this->autoIncr($this->tbl_user, $this->fld_userId);
		}

		function userdetail_autoIncr(){
			return $this->autoIncr($this->tbl_userDetail, $this->fld_userDetailId);
		}
		
		function usercat_autoIncr(){
			return $this->autoIncr($this->tbl_userType, $this->fld_userTypeId);
		}
	}