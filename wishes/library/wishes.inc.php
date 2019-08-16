<?php
	class cwd_wishes extends cwd_system{
		var $tbl_wishes;
		var $fld_wishesId;
		var $fld_wishesDate;
		
		var $URI_wishes;

		public function __construct(){
            global $thewu32_tblPref;
            $this->tbl_wishes     	= $thewu32_tblPref.'wishes';

            $this->fld_wishesId		= "wishes_id";
            $this->fld_wishesDate	= "wishes_date";
            $this->set_uri_wishes("wId");
            return $toRet = array("WISHES"=>($this->tbl_wishes), "WISHES_URI"=>($this->URI_wishes));
        }

		function cwd_wishes(){
			self::__construct();
		}
		
		function admin_get_menu($level){
			switch($level){
				case "admin" : $toRet = "<div class=\"ADM_menu\">
											  <h1>Gestion des v&oelig;ux</h1>
											  <ul class=\"ADM_menu_title\">
												<h2>Les V&oelig;ux</h2>
												<li><a href=\"?what=wishesDisplay\">Lister les v&oelig;ux</a></li>
											  </ul>
											  <div class=\"ADM_menu_descr\"></div>
										  </div>";
				break;
				case "editor" : $toRet = "<div class=\"ADM_menu\">
											  <h1>Gestion des v&oelig;ux</h1>
											  <ul class=\"ADM_menu_title\">
												<h2>Les V&oelig;ux</h2>
												<li><a href=\"?what=wishesDisplay\">Lister les v&oelig;ux</a></li>
											  </ul>
											  <div class=\"ADM_menu_descr\"></div>
										  </div>";
				break;
			}
		return $toRet;				  
		}
		
		function set_uri_wishes($new_uriVar){
			return $this->URI_wishes = $new_uriVar;
		}

		
		/*Rendre public/prive un voeu*/
		function set_wishes_state($new_wishesId, $new_stateId){
			return $this->set_updated_1($this->tbl_wishes, "display", $new_stateId, $this->fld_wishesId, $new_wishesId);
		}
		
		/*Supprimer un voeu*/
		function del_wishes($new_wishesId){
			return $this->rem_entry($this->tbl_wishes, $this->fld_wishesId, $new_wishesId);
		}
		
		function update_wishes($new_wishesId, $new_wishesName, $new_wishesEmail, $new_wishesContent, $new_wishesDate){
		    global $thewu32_cLink;
			$query = "UPDATE $this->tbl_wishes SET wishes_name	= '$new_wishesName',
												 wishes_email	= '$new_wishesEmail',
												 wishes_content	= '$new_wishesContent',
												 wishes_date	= '$new_wishesDate'
			WHERE 	".$this->fld_wishesId." = '$new_wishesId'";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to update wishes!<br />".mysqli_connect_error());
			if($result)
				return true;
			else 
				return false;
		}
		
		function admin_load_wishes($nombre='50', $limit='0'){
		    global $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
			
			//Recherche du nom de la page
			$path_parts = pathinfo($PHP_SELF);
			$page = $path_parts["basename"];
			
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl($this->tbl_wishes, $this->fld_wishesId);
			
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
				if(!$veriflimite) $limite = 0;
				
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
				
			$query 	= "SELECT * FROM $this->tbl_wishes ORDER BY $this->fld_wishesId DESC LIMIT ".$limite.",".$nombre;
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load online wishes!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$num	= 0;
				$toRet 	= $nav_menu;
				$toRet 	.= "<table class=\"ADM_table\">
							<tr>
								<th>N&ordm;</th>
								<th>Auteur</th>
								<th>Email</th>
								<th>Date</th>
								<th>Contenu</th>
							</tr>";
				while($row = mysqli_fetch_array($result)){
					$num++;
					//alterner les liens public / prive
					$linkState	= ($row[5] == "0")?("Priv."):("Pub.");
					$varUri		= ($row[5] == "0")?("wishesPublish"):("wishesPrivate");
					$linkTitle	= ($row[5] == "0")?("Publier le voeu"):("Masquer le voeu");
					
					//Convertir la date
					$date		= $this->datetime_fr3($row[4]);
					//Alternet les css
					$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
					
					$toRet .="<tr class=\"$currentCls\">
								<td align=\"center\">$num</td>
								<td>$row[1]</td>
								<td>$row[2]</td>
								<td>".utf8_decode(stripslashes($row[3]))."</td>
								<td>$date</td>
								<td nowrap align=\"center\">
								<a title=\"Supprimer le voeu\" href=\"?what=wishesDisplay&action=wishesDelete&wId=$row[0]\" onclick=\"return confirm('La suppression de ce voeu sera irr&eacute;vocable!')\">Supp.</a> | [ <a title=\"$linkTitle\" href=\"?what=wishesDisplay&action=$varUri&wId=".$row[0]."\">$linkState</a> ]
								</td>
							  </tr>";
				}
				$toRet .= "</table>$nav_menu";
				
			}
			else{
				$toRet	= "Aucun v&oelig;u &agrave; afficher";
			}
			return $toRet;
		}
		
		function insert_wishes($wishesName, $wishesEmail, $wishesContent){
		    global $thewu32_cLink;
			$date = $this->get_datetime();
			$query = "INSERT INTO $this->tbl_wishes VALUES('', '$wishesName', '$wishesEmail', '$wishesContent', '$date', '1')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to insert the recent wish!<br />".mysqli_connect_error());
			if($result)
				return mysql_insert_id();
			else
				return false;
		}
		
		function load_validXMLWishes($order="DESC"){
		    global $thewu32_cLink;
			$query = "SELECT $this->fld_wishesId, wishes_name, wishes_email, wishes_content, wishes_date FROM $this->tbl_wishes WHERE display='1' ORDER BY $this->fld_wishesId $order";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger les voeu pour un XML output!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$wishesHeader = $this->insert_xmlIntro().$this->insert_xmlComment("G&eacute;n&eacute;r&eacute; par theWu32").'<wishes>';
				$wishesItem = "";
				while($row = mysqli_fetch_row($result)){
					//Prevoir l'image
					$wishesItem .= '<wishesItem id="'.$row[0].'">
								  <author><![CDATA['.utf8_decode($row[1]).']]></author>
								  <email><![CDATA['.utf8_decode($row[2]).']]></email>
								  <message><![CDATA['.utf8_decode($row[3]).']]></message>
								  <date>'.$this->datetime_fr3($row[4]).'</date>
								  </wishesItem>';
								  
				}
				$wishesFooter = '</wishes>';
				$toRet = $wishesHeader.$wishesItem.$wishesFooter;
			}
			else{
				$toRet = false;
			}
			return $toRet;		 
		}
		
		//Cr&eacute;ation du fichier de voeu au format xml
		function create_xml_wishes($xmlPath="xml/thewu32_wishes.xml"){
		    global $thewu32_cLink;
			$fileContent = $this->load_validXMLWishes();
			if($this->write_in_file($xmlPath, $fileContent))
				return true;
			else
				return false;
		}
		
		function get_valid_wishes($dir="ASC"){
		    //Afficher les r&eacute;actions aux articles, quand il y en a
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_wishes WHERE display='1' ORDER BY $this->fld_wishesId $dir";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger les messages courts !!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = "<div class=\"react\">";
				while($row = mysqli_fetch_array($result)){
					$wishes_id 		= 	$row[0];
					$wishes_name 	= 	$row[1];
					$wishes_email 	= 	$row[2];
					$wishes_content = 	$row[3];
					$wishes_date	= 	$row[4];
					$toRet .= "<div class=\"wishes_container\">
								  <div class=\"wishes_container_head\">
									<strong>De :</strong> $wishes_name [ <em>$wishes_email</em> ]<br />
									<strong>Post&eacute; le :</strong> ".$this->datetime_fr3($wishes_date)."
								  </div>
								  <div class=\"wishes_container_body\">".nl2br($wishes_content)."</div>
							   </div>";
				}
				$toRet .= "</div>";
			}
			else{
				$toRet = "<div class=\"wishes_no_comment\">Aucun v&oelig;u &agrave; afficher pour l'instant.</div>";
			}
			return $toRet;
		}
		
		function display_valid_wishes($pageDest="wishes.php", $nombre="10", $limite="0"){
		    global $thewu32_cLink;
			$query 	= "SELECT * FROM $this->tbl_wishes WHERE display='1' ORDER BY $this->fld_wishesId DESC LIMIT ".$limite.",".$nombre;
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load online wishes!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet	= "";
				while($row = mysqli_fetch_array($result)){
					//Convertir la date
					$date		= $this->datetime_fr3($row[4]);
					$toRet .="<span class=\"name\"> $row[1] : </span><span class=\"content\">$row[3]</span> -- ";
				}
			}
			else{
				$toRet = "Aucun v&oelig;u &agrave; afficher";
			}
			return $toRet."<span class=\"name\">NWR : </span><span class=\"content\"><a href=\"$pageDest$thewu32_appExt\">Diffusez vos messages en cliquant ici</a>".$this->nbsp(9)."</span>";
		}
	}
?>