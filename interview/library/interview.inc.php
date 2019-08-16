<?php 
	class cwd_interview extends cwd_page {
		var $tblInterview;
		var $tbl_interview;
		
		var $fld_intId;
		var $fld_interviewId;

		var $fld_intName;
		var $fld_intRank;
		var $fld_intSubject;
		var $fld_intEmail;
		var $fld_intTel;
		var $fld_intIdNum;
		var $fld_intDate;
		var $fld_intStatus;
		
		var $URI_interview;
		var $mod_queryKey = 'itwId';
		
		public function __construct(){
            global $thewu32_tblPref;
			$this->tblInterview		= 	$thewu32_tblPref."interview";
			$this->tbl_interview	= 	$thewu32_tblPref."interview";

			$this->fld_intId		=	"int_id";
			$this->fld_interviewId	=	"int_id";
            $this->fld_intName		=	"int_name";
            $this->fld_intRank		=	"int_rank";
            $this->fld_intSubject	=	"int_subject";
            $this->fld_intEmail		=	"int_email";
            $this->fld_intTel		=	"int_tel";
            $this->fld_intIdNum		=	"int_idnum";
            $this->fld_intDate		=	"int_date";
            $this->fld_intStatus	=	"int_status";
            $this->set_uri_interview("itwId");
        }

		function cwd_interview(){
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
						  <h1>Gestion des audiences</h1>
						  <ul class=\"ADM_menu_title\">
						  	<h2>Les Audiences</h2>
						  	<li><a href=\"?what=interviewDisplay\">Lister les audiences</a></li>
							<li><a href=\"?what=interviewInsert\">Ins&eacute;rer une audience</a></li>
						  </ul>
						  <div class=\"ADM_menu_descr\"></div>
					  </div>";
			return $toRet;				  
		}
		
		/**
		 * Definir la variabe d'url pour les audiences
		 * 
		 * @param string $new_uriVar
		 *
		 * @return void()*/
		function set_uri_interview($new_uriVar){
			return $this->URI_interview = $new_uriVar;
		}
		
		function admin_load_interviews($nombre='50', $limit='0'){
		    global $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
			
			//Recherche du nom de la page
			$path_parts = pathinfo($PHP_SELF);
			$page = $path_parts["basename"];
			
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl($this->tblInterview, $this->fld_intId);
			
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
				if(!$veriflimite) $limite = 0;
				
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
				
			$query 	= "SELECT * FROM $this->tblInterview ORDER BY $this->fld_intDate DESC LIMIT ".$limite.",".$nombre;
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$num	= 0;
				$toRet 	= $nav_menu;
				$toRet 	.= "<table class=\"ADM_table\">
							<tr>
								<th>N&ordm;</th>
								<th>Nom</th>
								<th>Telephone</th>
								<th>Date proposee</th>
								<th>Objet</th>
								<th>Statut</th>
							</tr>";
				while($row = mysqli_fetch_array($result)){
					$num++;
					//alterner les liens public / prive
					$linkState	= ($row[8] == "0")?("Priv."):("Pub.");
					$varUri		= ($row[8] == "0")?("itwPublish"):("itwPrivate");
					$linkTitle	= ($row[8] == "0")?("Demande en cours"):("Demande expir&eacute;e");
					//Convertir la date
					$date		= $this->datetime_fr($row[7]);
					//Alternet les css
					$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
					$author = (($row[2] == '0')?("Administrateur"):($row[2]));
					
					$toRet .="<tr class=\"$currentCls\">
								<td align=\"center\">$num</td>
								<td>$row[1]</td>
								<td>$row[5]</td>
								<td>$date</td>
								<td>$row[3]</td>
								<td nowrap><a title=\"Modifier la demande\" href=\"?what=interviewUpdate&action=interviewUpdate&$this->URI_interview=$row[0]\">Mod.</a> | <a title=\"Supprimer la demande d'audience\" href=\"?what=interviewDisplay&action=interviewDelete&$this->URI_interview=$row[0]\" onclick=\"return confirm('&Ecirc;tes-vous s&ucirc;r de vouloir supprimer cette demande d\'audience?')\">Suppr.</a> | [ <a title=\"$linkTitle\" href=\"?action=$varUri&$this->URI_interview=$row[0]\">$linkState</a> ] </td>								
							  </tr>";
				}
				$toRet .= "</table>$nav_menu";
				
			}
			else{
				$toRet	= "Aucun &eacute;l&eacute;ment &agrave; afficher";
			}
			return $toRet;
		}
		
		

		/*Rendre actif/inactiv une demande d'audience*/
		function set_interview_state($new_interviewId, $new_stateId){
			return $this->set_updated_1($this->tblInterview, "int_status", $new_stateId, $this->fld_intId, $new_interviewId);
		}
		
		function interview_show($nombre='50', $limit='0'){
			return $this->admin_load_interviews($nombre, $limit);
		}
		
		/*Supprimer une demande d'audience*/
		function del_interview($new_itwId){
			return $this->rem_entry($this->tblInterview, $this->fld_inId, $new_itwId);
		}
		
		function update_interview($new_itwId,
									$new_itwName, 
								 	$new_itwRank, 
								 	$new_itwSubject, 
								 	$new_itwEmail, 
								 	$new_itwTel,
								 	$new_itwIdNum,
		                            $new_itwDate){
		        global $thewu32_cLink;
				$query = "UPDATE $this->tblInterview SET  
												 $this->fld_intName 	= 	'$new_itwName',
												 $this->fld_intRank		= 	'$new_itwRank',
						  	 					 $this->fld_intSubject	= 	'$new_itwSubject',
						  	 					 $this->fld_intEmail	= 	'$new_itwEmail',
						  	 					 $this->fld_intTel		= 	'$new_itwTel',
						  	 					 $this->fld_intIdNum	= 	'$new_itwIdNum',
						  	 					 $this->fld_intDate		= 	'$new_itwDate'
				WHERE 	$this->fld_intId = '$new_itwId'";
				$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to update requests of audiences!<br />".mysqli_connect_error());
			if($result)
				return true;
			else 
				return false;
		}
		
		/**
		 * Ressortir l'enregistrement li&eacute; ï¿½ une demande d'audience
		 *
		 * @return un tableau.
		 */
		function get_interview($new_itwId){
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tblInterview WHERE int_id = '$new_itwId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger la demande d'audience!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				while($row = mysqli_fetch_row($result)){
					$toRet = array(
								   "ID"			=> 	$row[0],
								   "NAME"		=> 	$row[1],
								   "RANK"		=> 	$row[2],
								   "SUBJECT"	=> 	$row[3],
								   "EMAIL"		=> 	$row[4],
								   "TELEPHONE"	=> 	$row[5],
								   "IDNUM"		=> 	$row[6],
								   "DATE"		=> 	$row[7],
								   "STATUS"		=> 	$row[8]
								   );
				}
				return $toRet;
			}
			else
				return false;
		}
		
		/**
		 * Un get_field_by_id adapt&eacute; aux demandes d'audiences uniquement
		 *
		 * @return la valeur du champ $fldToGet de la table des ddes d'audiences, dont l'id est $newId.
		 */
		function get_interview_by_id($fldToGet, $newId){
			return $this->get_field_by_id($this->tblInterview, "int_id", $fldToGet, $newId);
		}
		
		function interview_state($newStateId, $lang="FR"){
			if($lang == "FR"){
				switch($newStateId){
					case("1") : $toRet = "Expir&eacute;";
					break;
					case("0") : $toRet = "En attente";
					break;
				}
			}
			elseif($lang == "EN"){
				switch($newStateId){
					case("1") : $toRet = "Expired";
					break;
					case("0") : $toRet = "Pending";
					break;
				}
			}
			return $toRet;
		}
		
		/**
		 * Alterner l'etat Expir&eacute;/ En cours des demandes d'audience
		 * */
		function switch_interview_status($new_itwId, $statusVal){
			if($this->set_updated_1($this->tblInterview, "int_status", $statusVal, "int_id", $new_itwId))
				return true;
		}
		
		/**
		 * Ins&eacute;rer une annonce dans la bdd par l'utilisateur $newUserId
		 *
		 * @return true si l'annonce est ins&eacute;r&eacute;e, false sinon.
		 */
		function insert_interview($new_itwName, 
							 	  $new_itwRank, 
							 	  $new_itwSubject, 
							 	  $new_itwEmail, 
							 	  $new_itwTel,
							 	  $new_itwIdNum,
		                          $new_itwDate){
		    global $thewu32_cLink;
			$query = "INSERT INTO $this->tblInterview VALUES('', 
														   '$new_itwName', 
														   '$new_itwRank', 
														   '$new_itwSubject',
														   '$new_itwEmail', 
														   '$new_itwTel', 
														   '$new_itwIdNum', 
														   '$new_itwDate',
														   '0')";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'ajouter les demandes d'audiences!<br />".mysqli_connect_error());
			if($result)
				return mysql_insert_id();
			else
				return false;
				
		}
		
		function interview_insert($new_itwName, 
							 	  $new_itwRank, 
							 	  $new_itwSubject, 
							 	  $new_itwEmail, 
							 	  $new_itwTel,
							 	  $new_itwIdNum,
							 	  $new_itwDate){
			return $this->insert_interview($new_itwName, $new_itwRank, $new_itwSubject, $new_itwEmail, $new_itwTel, $new_itwIdNum, $new_itwDate);
		}
		
		function interview_delete($new_itwId){
			return $this->rem_entry($this->tblInterview, $this->fld_intId, $new_itwId);
		}

		//Compter le nombre de bannieres qu'il ya dans la table des bannieres
		function count_interviews(){
			return $toRet = $this->count_in_tbl($this->tbl_interview, $this->fld_interviewId);
		}
		  
		function interview_autoIncr(){
			return $this->autoIncr($this->tbl_interview, $this->fld_interviewId);
		}
	}