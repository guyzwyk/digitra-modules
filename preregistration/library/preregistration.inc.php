<?php
	class cwd_preregistration extends cwd_system{
		var $dir_preg_img;
		
		var $tbl_preg;
		var $tbl_contest;
		var $tbl_center;
		
		var $fld_pregId;
		var $fld_centerId;
		var $fld_contestId;
		
		var $fld_pregLastName;
		var $fld_pregFirstName;
		var $fld_pregCity;
		var $fld_pregCenterId;
		var $fld_pregFPhone;
		var $fld_pregMPhone;
		var $fld_pregEmail;
		var $fld_pregPobox;
		var $fld_pregCountryId;
		var $fld_pregLastDiploma;
		var $fld_pregContestId;
		var $fld_pregPhoto;
		var $fld_pregDate;
		
		var $fld_centerLib;
		var $fld_contestLib;
		var $fld_contestCode;
		
		public function __construct(){
            global $thewu32_tblPref;
            $this->tbl_preg     			= $thewu32_tblPref.'preregistrations';
            $this->tbl_center				= $thewu32_tblPref.'center';
            $this->tbl_contest				= $thewu32_tblPref.'contest';

            $this->fld_pregId				= "preg_id";
            $this->fld_centerId				= "center_id";
            $this->fld_contestId			= "contest_id";

            $this->fld_pregLastName			= "preg_lastname";
            $this->fld_pregFirstName		= "preg_firstname";
            $this->fld_pregCity				= "preg_homecity";
            $this->fld_pregCenterId			= "center_id";
            $this->fld_pregFPhone			= "preg_phone";
            $this->fld_pregMPhone			= "preg_cellphone";
            $this->fld_pregEmail			= "preg_email";
            $this->fld_pregPobox			= "preg_pobox";
            $this->fld_pregCountryId		= "country_code";
            $this->fld_pregLastDiploma		= "preg_lastdiploma";
            $this->fld_pregContestId		= "contest_id";
            $this->fld_pregPhoto			= "preg_photo4x4";
            $this->fld_pregDate				= "preg_date";

            $this->fld_centerLib			= "center_lib";
            $this->fld_contestCode			= "contest_code";
            $this->fld_contestLib			= "contest_lib";

            $this->set_dir_preg_img('modules/preregistration/4x4/');
		}


		function cwd_preregistration(){
			self::__construct();
		}
		
		function set_preregistration($new_fName, $new_lName, $new_city, $new_center, $new_phone, $new_cellphone, $new_email, $new_pobox, $new_country, $new_diploma, $new_contest, $new_photo, $new_date){
		    global $thewu32_cLink;
			$query = "INSERT INTO $this->tbl_preg VALUES ('',
														  '$new_fName',
														  '$new_lName',
														  '$new_city',
														  '$new_center',
														  '$new_phone',
														  '$new_cellphone',
														  '$new_email',
														  '$new_pobox',
														  '$new_country',
														  '$new_diploma',
														  '$new_contest',
														  '$new_photo',
														  '$new_date')";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to insert a new pre-registration row!<br />".mysqli_connect_error());
			if(result)
				return true;
			else
				return false;
			
		}
		function set_dir_preg_img($new_imgDir){
			return $this->dir_preg_img = $new_imgDir;
		}
		
		function cmb_load_centers($varRefresh){
			return $this->upd_combo_sel_row_2($this->tbl_center, $this->fld_centerId, $this->fld_centerLib, $varRefresh, "");
		}
		
		function cmb_load_contests($varRefresh){
			return $this->upd_combo_sel_row_2($this->tbl_contest, $this->fld_contestId, $this->fld_contestLib, $varRefresh, "");
		}
		function get_dir_preg_img(){
			return $this->dir_preg_img;
		}
		
		function get_center_by_id($new_centerId){
			return $this->get_field_by_id($this->tbl_center, $this->fld_centerId, $this->fld_centerLib, $new_centerId);
		}
		
		function get_contest_by_id($new_contestId){
			return $this->get_field_by_id($this->tbl_contest, $this->fld_contestId, $this->fld_contestLib, $new_contestId);
		}
		
		function get_contest_code_by_id($new_contestId){
			return $this->get_field_by_id($this->tbl_contest, $this->fld_contestId, $this->fld_contestCode, $new_contestId);
		}
	}
?>
