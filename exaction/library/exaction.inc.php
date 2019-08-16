<?php
	class cwd_exaction extends cwd_system{
	    var $tbl_exaction;
    	var $tbl_exactionType;
    	var $tbl_exactionNature;
    	var $tbl_exactionPieces;
    	var $tbl_exactionPiecesDetail;
    	var $tbl_exactionLieu;
    	var $tbl_exactionDivision;

    	var $fld_exactionId;
    	var $fld_exactionTypeId;
    	var $fld_exactionNatureId;
    	var $fld_exactionPiecesId;
    	var $fld_exactionPiecesDetailId;
    	var $fld_exactionLieuId;
    	var $fld_exactionDivisionId;

    	var $fld_exactionDate;
    	var $fld_exactionTitre;
    	var $fld_exactionDivisionLib;
    	var $fld_exactionVictime;
    	var $fld_exactionDescription;
    	var $fld_exactionTypeLib;
    	var $fld_exactionNatureLib;
    	var $fld_exactionPiecesLib;
    	var $fld_exactionPiecesName;
    	var $fld_exactionPiecesDescr;


    	var $URI_exaction;
    	var $URI_exactionCat;
		var $URI_exactionVar		= 'exId';
    	var $mod_queryKey 			= 'pmId';
    	var $mod_fkQueryKey 		= 'catId' ;
    	var $URI_exactionLang		= 'langId';
    	var $admin_modPage			= '?page=exaction';

    	var $default_recipient;

		public function __construct(){
		    global $thewu32_tblPref, $thewu32_cLink, $thewu32_appExt;

            $this->tbl_exaction 			    = 	$thewu32_tblPref."exaction";
            $this->tbl_exactionType 		    = 	$thewu32_tblPref."exaction_type";
			$this->tbl_exactionNature 		    = 	$thewu32_tblPref."exaction_nature";
			$this->tbl_exactionDivision			=	'cwd_division';
			$this->tbl_exactionLieu				=	'cwd_town';
            $this->tbl_exactionType 		    = 	$thewu32_tblPref."exaction_type";
            $this->tbl_exactionPieces 		    = 	$thewu32_tblPref."exaction_pieces";
            $this->tbl_exactionPiecesDetail	    = 	$thewu32_tblPref."exaction_pieces_detail";

            $this->fld_exactionId               =   'id_exaction';
            $this->fld_exactionTypeId           =   'id_exaction_type';
            $this->fld_exactionNatureId         =   'id_exaction_nature';
            $this->fld_exactionPiecesId         =   'id_exaction_pieces';
            $this->fld_exactionLieuId           =   'town_id';
            $this->fld_exactionDivisionId    	=   'division_id';

            $this->fld_exactionVictime          =   'victime';
            $this->fld_exactionDescription      =   'description';
            $this->fld_exactionDate             =   'date';
            $this->fld_exactionTypeLib          =   'lbl_exaction_type';
            $this->fld_exactionNatureLib        =   'lbl_exaction_nature';
            $this->fld_exactionPiecesLib        =   'lbl_exaction_pieces';
            $this->fld_exactionPiecesDescr      =   'descr_exaction_pieces';
			$this->fld_exactionPiecesName       =   'name_exaction_pieces';
			$this->fld_exactionDivisionLib    	=   'division_lib';


            /*
            $this->set_uri_exaction("pmId");
            $this->set_uri_exaction_cat("catId"); */
		}

		function cwd_exaction(){ //Constructeur de la classe
			self::__construct();
		}

		function set_uri_exaction($new_uriVar){
		    return $this->URI_exaction = $new_uriVar;
		}
		/**
		 * Definir la variabe d'url pour les categories d'annonces
		 *
		 * @param string $new_uriCatVar
		 *
		 * @return void()*/
		function set_uri_exaction_cat($new_uriCatVar){
		    return $this->URI_exactionCat = $new_uriCatVar;
		}


	   function admin_load_exactions($nombre=1000, $preview=0, $level="admin"){
		  global $lang_output, $mod_lang_output, $thewu32_cLink;

		  $limite 	= 	$_REQUEST[limite];
		  $nombre	=	isset($_REQUEST['nb']) ? ($_REQUEST['nb']) : ($nombre);

		  //Recherche du nom de la page
		  $path_parts = pathinfo($PHP_SELF);
		  $page = $path_parts["basename"].'?what=exactionDisplay';

		  //Obtention du total des enregistrements:
		  $total = $this->count_in_tbl($this->tbl_exaction, $this->fld_exactionId);


		  //V&eacute;rification de la validit&eacute; de notre variable $limite......
		  $veriflimite = $this->veriflimite($limite, $total, $nombre);
		  if(!$veriflimite) $limite = 0;

		  //Bloc menu de liens
		  if($total > $nombre)
		      $nav_menu	= $this->cmb_affichepage($nombre, $page, $total);

		  $query 	= "SELECT * FROM $this->tbl_exaction ORDER BY $this->fld_exactionDate DESC LIMIT ".$limite.",".$nombre;
		  $result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load exactions!<br />".mysqli_error($thewu32_cLink));

		  if($total = mysqli_num_rows($result)){
		      $num	 = 0;
		      $toRet = $nav_menu;

			  //Hide cols in pagemaster master view
			  $descr_colLabel		=	($preview > 0)	?	("<th>".$mod_lang_output['TABLE_HEADER_EXACTION_DESCR']."</th>")	:	('');
			  $division_colLabel	=	($preview > 0)	?	("<th>".$mod_lang_output['TABLE_HEADER_EXACTION_DIVISION']."</th>")	:	('');

			  //Hide action col in modal/fullscreen view
			  $action_colLabel		=	($preview <= 0)	?	("<th>".$mod_lang_output['TABLE_HEADER_ACTION']."</th>")	:	('');

		            $toRet 	.= "<form><table class=\"table table-bordered\">
								<tr>
									<th>&num;</th>
									<th>".$mod_lang_output['TABLE_HEADER_EXACTION_TYPE']."</th>
									<th>".$mod_lang_output['TABLE_HEADER_EXACTION_NATURE']."</th>
									<th>".$mod_lang_output['TABLE_HEADER_EXACTION_DATE']."</th>
									<th>".$mod_lang_output['TABLE_HEADER_EXACTION_VICTIM']."</th>
                                    ".$descr_colLabel."
									<th>".$mod_lang_output['TABLE_HEADER_EXACTION_PLACE']."</th>
									".$division_colLabel."
									".$action_colLabel."
								</tr>";
		            while($row = mysqli_fetch_array($result)){
		                $num++;

						//Victime et circonstances
						$exactionVictimes	=	($preview <= 0)	?	($this->chapo($row[5], 250))	:	($row[5]);
						$exactionDescr		=	($preview <= 0)	?	($this->chapo($row[6], 250))	:	($row[6]);

		                //Obtenir les libelles des categories
		                $exactionType    	=   $this->get_exaction_type_by_id($row[1]);
		                $exactionNature	  	=   $this->get_exaction_nature_by_id($row[2]);
						$exactionLieu     	=   $this->get_field_by_id($this->tbl_town, $this->fld_townId, $this->fld_townLib, $row[4]);
						
						//Extract the division id from town ID
						$divisionId			=	$this->get_field_by_id($this->tbl_town, $this->fld_townId, $this->fld_exactionDivisionId, $row[4]); 

						//Get the name of the division knowing it's ID
						$exactionDivision	=	$this->get_field_by_id($this->tbl_exactionDivision, $this->fld_exactionDivisionId, $this->fld_exactionDivisionLib, $divisionId);
						
						//Convertir la date
		                $date		= $this->show_date_by_lang($row[7], $_SESSION['LANG']);
						
						//Alternet les css
						$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
						
						$exaction_colDescr		=	($preview > 0)	?	("<td>$exactionDescr</td>")	:	('');
						$exaction_colDivision	=	($preview > 0)	?	("<td>$exactionDivision</td>")	:	('');

						$action_colContent	=	($preview <= 0)	?	("<td style=\"background:#FFF; text-align:center;\">
									<a title=\"".$lang_output['TABLE_TOOLTIP_DETAIL']."\" href=\"?page=exaction&what=detail&$this->URI_exactionVar=$row[0]\">".$this->admin_button_crud('detail')."</a>&nbsp;
									<a title=\"".$lang_output['TABLE_TOOLTIP_UPDATE']."\" href=\"?page=exaction&what=update&action=update&$this->URI_exactionVar=$row[0]\">".$this->admin_button_crud('update')."</a>&nbsp;
									<a title=\"".$lang_output['TABLE_TOOLTIP_DELETE']."\" href=\"?page=exaction&what=display&action=delete&$this->URI_exactionVar=$row[0]\" onclick=\"return confirm('Sure you want to delete?')\">".$this->admin_button_crud('delete')."</a>
								</td>")	:	('');


		                $toRet .="<tr class=\"$currentCls\">
								<th>$num</th>
								<td>$exactionType</td>
								<td>$exactionNature</td>
								<td nowrap>$date</td>
								<td>$exactionVictimes</td>
                                ".$exaction_colDescr."
								<td>$exactionLieu</td>
								".$exaction_colDivision."
                                ".$action_colContent."
								</tr>";
		            }
		            $toRet .= "</table></form>$nav_menu";

		        }
		        else{
		            $toRet	= "Aucune Exaction &agrave; afficher";
		        }
		        return $toRet;
		}

		function admin_load_exactions_pj($new_exactionId, $nombre='20'){
		    global $lang_output, $mod_lang_output, $thewu32_cLink;

		    $limite = $_REQUEST[limite];
		    $nombre	=	isset($_REQUEST['nb']) ? ($_REQUEST['nb']) : ($nombre);

		    //Recherche du nom de la page
		    $path_parts = pathinfo($PHP_SELF);
		    $page = $path_parts["basename"].'?what=exactionDetail&exId=424';

		    //Obtention du total des enregistrements:
		    $total = $this->count_in_tbl_where1($this->tbl_exactionPieces, $this->fld_exactionPiecesId, $this->fld_exactionId, $new_exactionId);


		    //V&eacute;rification de la validit&eacute; de notre variable $limite......
		    $veriflimite = $this->veriflimite($limite, $total, $nombre);
		    if(!$veriflimite) $limite = 0;

		    //Bloc menu de liens
		    if($total > $nombre)
		        $nav_menu	= $this->affichepage($nombre, $page, $total);

		        $query 	= "SELECT * FROM $this->tbl_exactionPieces WHERE $this->fld_exactionId = '$new_exactionId' ORDER BY $this->fld_exactionPiecesLib DESC LIMIT ".$limite.",".$nombre;
		        $result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load exaction attachments!<br />".mysqli_connect_error());
		        if($total = mysqli_num_rows($result)){
		            $num	= 0;
		            $toRet 	= $nav_menu;

		            $toRet 	.= "<ul class=\"admin_attachments\">";
		            while($row = mysqli_fetch_array($result)){

		                $toRet .="<li><i class=\"fa fa-file\"></i>&nbsp;<a rel=\"lightbox\" href=\"../modules/exaction/files/attachments/".$row[4]."\" target=\"_blank\">".$row[2]."</a></li>";
		            }
		            $toRet .= "</ul>$nav_menu";

		        }
		        else{
		            $toRet	= "<p style=\"font-style:italic;\">No attachment yet!</p>";
		        }
		        return $toRet;
		}

		function admin_load_exaction_nav($newEId=1, $pageDest='admin.php?page=exaction&what=detail', $cls='btn btn-default'){
		    /**
		     * @param : 	string $pageDest (Page de destination)
		     * @param :		int $newEId (Id de l'exaction)
		     * @return :	{news nav menu}
		     *
		     * @descr : 	Afficher le menu de navigation de toutes les exactions
		     **/
		    //Charger tous les id des news dans un tableau,
		    $condition		         =   "WHERE display='1'";
		    $tabExactionId_i	     =   $this->get_exaction_id($condition);

		    //On renverse cles/valeurs pour le pointeur
		    $tabExactionId_f	     =   array_flip($tabExactionId_i);

		    //On compte le nombre d'item dans le tableau (les deux en ont le même nombre)
		    $nbItem			= 	count($tabExactionId_i);

		    //On identifie la cle courante
		    $current_key 	= 	$tabExactionId_f[$newEId];

		    //Sachant la cle courante, on peut savoir les cles suivante et precedente
		    $next_key		= 	($current_key + 1);
		    $prev_key		= 	($current_key - 1);

		    //Pour les liens:
		    $current		= 	$tabExactionId_i[$current_key];

		    $prev			= 	((in_array($tabExactionId_i[$next_key], $tabExactionId_i)) ? ($tabExactionId_i[$next_key]): ($tabExactionId_i[0]));
		    $next			= 	((in_array($tabExactionId_i[$prev_key], $tabExactionId_i)) ? ($tabExactionId_i[$prev_key]): ($tabExactionId_i[$nbItem - 1]));
		    $last			= 	$tabExactionId_i[0];
		    $first			= 	$tabExactionId_i[$nbItem - 1];
		    /*-------------------------------------------------------------------------------------------------------------
		     -------------------------------------------------------------------------------------------------------------- */
		    $lnkNext 	    =   (is_numeric($next))     ?     ("<a class=\"$cls\" href=\"$pageDest&$this->URI_exactionVar=$next#$next\">".$this->admin_button_crud('next')."</a>")     :   ('');
		    $lnkPrevious 	=   (is_numeric($prev))     ?     ("<a class=\"$cls\" href=\"$pageDest&$this->URI_exactionVar=$prev#$prev\">".$this->admin_button_crud('previous')."</a>") :   ('');

		    $lnkFirst		= 	"<a class=\"$cls\" href=\"$pageDest&$this->URI_exactionVar=$first#$first\">".$this->admin_button_crud('first')."</a>";
		    $lnkLast		= 	"<a class=\"$cls\" href=\"$pageDest&$this->URI_exactionVar=$last#$last\">".$this->admin_button_crud('last')."</a>";
		    
		    $toRet			= 	"<div class=\"btn-group\">$lnkFirst  $lnkPrevious  $lnkNext  $lnkLast</div>";
		    return $toRet;
		}

		function get_exaction_id($condition){
		    /**
		     * @param 	: 	string $sql_condition
		     * @return 	: Array()
		     *
		     * @desc 	: 	Renvoit un tableau d'Id des exaction selon la condition SQL $condition
		     **/
		    return $this->load_id_ordered($this->tbl_exaction, $this->fld_exactionId, $this->fld_exactionDate, $condition);
		}

		function set_exaction_pj($new_exactionId, $new_exactionPieceTitle, $new_exactionPieceDescr, $new_exactionPieceName){
		    global $thewu32_cLink;

		    $query    =   "INSERT INTO $this->tbl_exactionPieces VALUES('".$this->exaction_pj_autoIncr()."', '$new_exactionId', '$new_exactionPieceTitle', '$new_exactionPieceDescr', '$new_exactionPieceName')";
		    $result   =   mysqli_query($thewu32_cLink, $query) or die ('Unable to insert an attachment for this exaction('.$new_exactionPieceName.' in table '.$this->tbl_exactionPieces.').<br />'.mysqli_error($thewu32_cLink));
		    if($result)
		        return mysqli_insert_id($thewu32_cLink);
		    else
		        return false;
		}

		function search_exaction($strSearch, $error="", $lang='FR'){
		    global $thewu32_cLink;

		    $query= "SELECT $this->fld_exactionId, $this->fld_exactionTypeId, $this->fld_exactionVictime, $this->fld_exactionDescription, $this->fld_exactionDate FROM $this->tbl_exaction WHERE (`description` LIKE '%".addslashes($strSearch)."%' || `victime` LIKE '%".addslashes($strSearch)."%' || `date` LIKE '%".$strSearch."%')";

		    $result = mysqli_query($thewu32_cLink, $query) or die ("Cannot load any result for that query<br />".mysqli_error($thewu32_cLink));
		    if($total = mysqli_num_rows($result)){
		        $toRet = "<div id=\"searchExaction\">";
		        while($row = mysqli_fetch_row($result)){
		            $id      	= $row[0];
		            $type   	= $this->get_exaction_type_by_id($row[1]);
		            $victim 	= $row[2];
		            $descr		= $row[3];
		            $date		= $row[4];

		            //$url		= $this->get_url_by_page_id($id, $lang);
		            $victimShow	= $this->nodata($this->chapo(strip_tags($victim), 100), "");
					$descrShow	= $this->nodata($this->chapo(strip_tags($descr), 100), ""); 

		            $toRet .= "<div class=\"title\">$type</div>
			  			 <div class=\"descr\"><a href=\"?what=exactionDetail&".$this->URI_exactionVar."=$id\">$victimShow :</a><br />$descrShow</div>
			  			 <div style=\"clear:both;\"></div>";
		        }
		    }
		    else
		        $toRet = $error."<div style=\"clear:both;\"></div></div>";

		    return $toRet."</div>";
		}

		//Dump the exaction file content into DB
		function csv_dump_exactions($fileOrig='', $val_delim=';', $val_skip='Prefix', $lang='FR'){
		    // Ouverture fichier en lecture
		    if($fp = @fopen($fileOrig,"r")) {
		        $toRet = "";
		        $compteur = 0;
		        $newContent = '';
		        while (!feof($fp)){
		            $compteur += 1;
		            $row 		= fgets($fp);

		            $tab_elem	= explode($val_delim, $row);


		            if(in_array($val_skip, $tab_elem)){ //$val_skip = valeur a sauter si on rencontre dans le csv
		                continue;
		            }
		            elseif(!is_array($tab_elem)){ //Si on a une ligne vide, continuer
		                continue;
		            }
		            else{
		                //Dump into DB table and update the exactions
		                $this->set_exaction($tab_elem[2], $tab_elem[3], '', $tab_elem[6], $tab_elem[5], $tab_elem[7], $this->datefr_toDatetime($tab_elem[1]));
		            }

		        }
		        // fermeture fichier
		        fclose ($fp);
		        return $compteur;
		    }
		    else{
		        return false;
		    }

		}


		/****************************************/
		/* :::::::: All the getters ::::::::   */
		/****************************************/

		/**
		 * @param int $new_exactionId
		 * @return {array_assoc}
		 *
		 * @desc Charger un enregistrement d'une news dans un tableau associatif.
		 * Exemple : sert a avoir tout l'enregistrement propre a un ID de news connu.
		 * */
		function get_exaction(int $new_exactionId){
		    global $thewu32_cLink;
			$query = "SELECT * FROM $this->tbl_exaction WHERE $this->fld_exactionId = '$new_exactionId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'extraire l'exaction".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = array();
				while($row = mysqli_fetch_array($result)){
					$toRet = array(
							 "ID"      	=> $row[0],
							 "TYPE" 	=> $row[1],
							 "NATURE"  	=> $row[2],
							 "PJ"		=> $row[3],
							 "TOWN" 	=> $row[4],
							 "VICTIM"   => $row[5],
							 "DESCR"	=> $row[6],
							 "DATE"  	=> $row[7],
							 "DISPLAY"	=> $row[8]);
				}
				return $toRet;
			}
			else{
				return false;
			}
		}

		function get_exaction_type_by_id($new_exactionTypeId){
		    return $this->get_field_by_id($this->tbl_exactionType, $this->fld_exactionTypeId, $this->fld_exactionTypeLib, $new_exactionTypeId);
		}

		function get_exaction_nature_by_id($new_exactionNatureId){
		    return $this->get_field_by_id($this->tbl_exactionNature, $this->fld_exactionNatureId, $this->fld_exactionNatureLib, $new_exactionNatureId);
		}

		function get_exaction_town_by_id($new_exactionTownId){
		    return $this->get_field_by_id($this->tbl_exactionLieu, $this->fld_exactionLieuId, 'town_lib', $new_exactionTownId);
		}

		/*function get_exaction_by_id($new_exactionVar, $new_exactionFld){
			return $this->get_field_by_id($this->tbl)
		}*/

		function set_exaction($new_exactionType, $new_exactionNature, $new_exactionPieces, $new_exactionLieu, $new_exactionVictime, $new_exactionDescription, $new_exactionDate, $msgError='Error in exaction\'s insert query<br />'){
		    global $thewu32_cLink;
		    //$new_exactionId	=	(int)$this->count_in_tbl($this->tbl_exaction, $this->fld_exactionId) + 1;
		    $query 	= 	"INSERT INTO $this->tbl_exaction VALUES('".$this->exaction_autoIncr()."', '$new_exactionType', '$new_exactionNature', '$new_exactionPieces', '$new_exactionLieu', '$new_exactionVictime', '$new_exactionDescription', '$new_exactionDate', '1')";
		    $result = 	mysqli_query($thewu32_cLink, $query) or die ("$msgError<br />".mysqli_error($thewu32_cLink));
		    if($result)
		        return true;
		    else
		        return false;
		}

		function cmb_load_exaction_place($selected=''){
		    return $this->upd_combo_sel_row_2($this->tbl_town, $this->fld_townId, $this->fld_townLib, $selected);
		}

		//Compter le nombre d'exactions commises dans la base de donnees
		function count_exactions($new_exactionType=""){
			switch($new_exactionType){
				case '0' 	: 	$toRet 	= 	$this->count_in_tbl($this->tbl_exaction, $this->fld_exactionId); //all
					break;
				case '1'	:	$toRet 	= 	$this->count_in_tbl_where1($this->tbl_exaction, $this->fld_exactionId, $this->fld_exactionTypeId, '5'); //Killings
					break;
				case '2'	:	$toRet 	= 	$this->count_in_tbl_where1($this->tbl_exaction, $this->fld_exactionId, $this->fld_exactionTypeId, '4'); //Kidnappings
					break;
				case '3'	:	$toRet	=	($this->count_in_tbl_where1($this->tbl_exaction, $this->fld_exactionId, $this->fld_exactionTypeId, '1') + $this->count_in_tbl_where1($this->tbl_exaction, $this->fld_exactionId, $this->fld_exactionTypeId, '3')); //Burnings and lootings
					 break;
				case '4'	:	$toRet	=	($this->count_in_tbl_where1($this->tbl_exaction, $this->fld_exactionId, $this->fld_exactionTypeId, '7') + $this->count_in_tbl_where1($this->tbl_exaction, $this->fld_exactionId, $this->fld_exactionTypeId, '8') + $this->count_in_tbl_where1($this->tbl_exaction, $this->fld_exactionId, $this->fld_exactionTypeId, '9')); //Injuries
					 break;
				case '5'	:	$toRet	=	($this->count_in_tbl_where1($this->tbl_exaction, $this->fld_exactionId, $this->fld_exactionTypeId, '10')); //Rapes
					 break;
				case '6'	:	$toRet	=	($this->count_in_tbl_where1($this->tbl_exaction, $this->fld_exactionId, $this->fld_exactionTypeId, '2') + $this->count_in_tbl_where1($this->tbl_exaction, $this->fld_exactionId, $this->fld_exactionTypeId, '6')); //Extorsions and intimidations
					 break;
				default		:	$toRet 	= 	$this->count_in_tbl($this->tbl_exaction, $this->fld_exactionId); //all
			}
			return (int)$toRet;
		}

		function exactions_autoIncr(){
			return $this->autoIncr($this->tbl_exaction, $this->fld_exactionsId);
		}

		function get_exaction_most_dangerous_area(){
			//Get ids of the concerned towns;
			$arr_affected_towns		=	$this->load_field($this->tbl_exaction, $this->fld_exactionLieuId);

			$arr_affected_towns_names	=	array();
			foreach($arr_affected_towns as $values){
				array_push($arr_affected_towns_names, $this->get_field_by_id($this->tbl_town, $this->fld_townId, $this->fld_townLib, $values));
			}

			//Count the occurrence of each town_id --> associative array
			$arr_town_occurences					=	array_count_values($arr_affected_towns);
			$arr_affected_towns_names_occurences	=	array_count_values($arr_affected_towns_names);

			$final   =   array();
			foreach($arr_affected_towns_names_occurences as $keys => $values){
				array_push($final, $keys.'('.$values.')');
			}
			//Sort the town occurences result
			sort($final);

			$arr_town_occurences_sorted = array();
			$arrlength = count($final);
				for($x = 0; $x < $arrlength; $x++) {
					array_push($arr_town_occurences_sorted, $final[$x]);
				}


			//Finish
			return $arr_town_occurences_sorted;
		}


	  /****************************************/
	/* :::::::: All the updaters ::::::::   */
	/****************************************/

		//Mettre à jour les champs un à un ds la table des news. utile par ex pr MAJ l'image d'une news
		function update_exaction_element($new_exactionId, $new_fldExaction, $newVal){
			global $thewu32_cLink;
			$query = "UPDATE $this->tbl_exaction SET $new_fldExaction = '$newVal' WHERE $this->fld_exactionId = '$new_exactionId'";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to update an exaction field.<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}

		function update_exaction($new_exactionId, $new_exactionType, $new_exactionNature, $new_exactionPJ, $new_exactionTown, $new_exactionVictime, $new_exactionDescription, $new_exactionDate, $new_exactionDisplay){
		    global $thewu32_cLink;
		    $query = "UPDATE $this->tbl_exaction SET
													 $this->fld_exactionTypeId	    = 	'$new_exactionType',
													 $this->fld_exactionNatureId	= 	'$new_exactionNature',
													 $this->fld_exactionPiecesId	= 	'$new_exactionPJ',
													 $this->fld_exactionLieuId		= 	'$new_exactionTown',
													 $this->fld_exactionVictime		= 	'$new_exactionVictime',
													 $this->fld_exactionDescription	= 	'$new_exactionDescription',
													 $this->fld_exactionDate		= 	'$new_exactionDate',
													 $this->fld_display    			= 	'$new_exactionDisplay'
                        WHERE $this->fld_exactionId = '$new_exactionId'";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to update exaction!<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}

		function exaction_autoIncr(){
		    return $this->autoIncr($this->tbl_exaction, $this->fld_exactionId);
		}
		function exaction_pj_autoIncr(){
		    return $this->autoIncr($this->tbl_exactionPieces, $this->fld_exactionPiecesId);
		}
	}
?>
