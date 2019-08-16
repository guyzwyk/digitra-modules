<?php
class cwd_tube extends cwd_system {
	var $tbl_tube;
	var $fld_tube_id;
	
	var $tbl_tube_cat;
	var $fld_tube_cat_id;
	
	var $tbl_artists 	= "yafe08_artistes"; //Peut etre remplac�e par la table des utilisateurs
	var $fld_artistsId	= "arts_id";


	public function __construct(){
        $this->tbl_tube			= "cwd_tube";
        $this->tbl_tube_cat		= "cwd_tube_cat";
        $this->fld_tube_id		= "tube_id";
        $this->fld_tube_cat_id	= "tube_cat_id";
    }

	function cwd_tube(){
	    self::__construct();
	}
	
	function set_tube($new_tubeCat, $new_tubeTitle, $new_tubeDescr, $new_tubeObject, $new_artistId, $display='1'){
	    global $thewu32_cLink;
		$query	= "INSERT INTO $this->tbl_tube VALUES ('', '$new_tubeCat', '$new_tubeTitle', '$new_tubeDescr', '$new_tubeObject', '$new_artistId', $display')";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Erreur d'insertion de tubes!<br />".mysqli_connect_error());
		if($result)
			return true;
		else
			return false;
	}
	
	function get_tube($new_tubeId){
	    global $thewu32_cLink;
		$query = "SELECT * FROM $this->tbl_tube WHERE $this->fld_tube_id = '$new_tubeId'";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Erreur de selection de tube!<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			while($row = mysqli_fetch_row($result)){
				$toRet = array(
							   "tubeID"		 	=> $row[0],
							   "tubeCATID"		=> $row[1],
							   "tubeTITLE"		=> $row[2],
							   "tubeDESCR"		=> $row[3],
							   "tubeOBJECT"		=> $row[4],
							   "artistID"		=> $row[5],
							   "tubeDISPLAY"	=> $row[6]
						   );
				}
				return $toRet;
			}
			else
				return false;
		
	}
	
	//Obtenir un tube selon sa cat&eacute;gorie
	function get_tube_by_cat($new_tubeId, $new_tubeCatId){
	    global $thewu32_cLink;
		$query = "SELECT * FROM $this->tbl_tube WHERE $this->fld_tube_id = '$new_tubeId' and $this->fld_tube_cat_id = '$new_tubeCatId'";
		$result	= mysqli_query($thewu32_cLink, $query) or die("Erreur de selection de tube!<br />".mysqli_connect_error());
		if($total = mysqli_num_rows($result)){
			while($row = mysqli_fetch_row($result)){
				$toRet = array(
							   "tubeID"		 	=> $row[0],
							   "tubeCATID"		=> $row[1],
							   "tubeTITLE"		=> $row[2],
							   "tubeDESCR"		=> $row[3],
							   "tubeOBJECT"		=> $row[4],
							   "artistID"		=> $row[5],
							   "tubeDISPLAY"	=> $row[6]
						   );
				}
				return $toRet;
			}
			else
				return false;
		
	}
	
	function get_tube_cat_by_id($new_tubeCatId){
		return $this->get_field_by_id($this->tbl_tube_cat, $this->fld_tube_cat_id, 'tube_cat_lib', $new_tubeCatId);
	}
	
	function cmb_get_tube_cat(){
		return $this->combo_sel_row_2($this->tbl_tube_cat, $this->fld_tube_cat_id, 'tube_cat_lib');
	}
	
	function cmb_get_tube_artist(){
		return $this->combo_sel_row_2($this->tbl_artists, $this->fld_artistsId, 'arts_nom');
	}
	
	function random_get_tube(){
		$nbTube	= $this->count_in_tbl_where1($this->tbl_tube, $this->fld_tube_id, "display", '1');
		$tubeId	= rand(1, $nbTube);
		return $tubeId;
	}
}
?>