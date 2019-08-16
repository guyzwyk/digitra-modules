<?php
	class cwd_catalog extends cwd_system { //cwd_gallery {
		var $tbl_catalog;
		var $tbl_catalogType;
		var $tbl_catalogImg;
		
		var $fld_catalogId;
		var $fld_catalogTypeId;
		var $fld_catalogImgId;
		
		var $fld_catalogDescr;
		var $fld_catalogLib;
		var $fld_catalogImg;
		var $fld_catalogTags;
		var $fld_catalogPrixVente;
		var $fld_catalogPrixAchat;
		var $fld_catalogDate;
		var $fld_catalogLang;
		var $fld_catalogDisplay;
		
		var $fld_catalogImgLib;
		
		var $fld_catalogTypeLib;
		var $fld_catalogTypeLang;
		var $fld_catalogTypeDisplay;
		
		var $mod_dir;
		var $img_dir;
		var $img_thumbs_dir;
		
		var $mod_page;
		var $mod_admin_page = 'catalog_manager.php';
		var $mod_queryKey;
		var $mod_catQueryKey;
		var $URI_product 	= 'productId';
		var $URI_productCat	= 'product_catId';
		
		var $defaultImg		= 'noimg.jpg';
		
		//Class constructor
        public function __construct(){
            global $thewu32_tblPref;

            //Tables initializations
            $this->tbl_catalog 				= 	$thewu32_tblPref.'catalogue';
            $this->tbl_catalogType			= 	$thewu32_tblPref.'catalogue_type';
            $this->tbl_catalogImg			= 	$thewu32_tblPref.'catalogue_img';

            //Id fields initializations
            $this->fld_catalogId			= 	'catalogue_id';
            $this->fld_catalogTypeId		= 	'catalogue_type_id';
            $this->fld_catalogImgId			= 	'catalogue_img_id';

            //Secondary fields initializations
            $this->fld_catalogDescr			= 	'catalogue_descr';
            $this->fld_catalogLib			= 	'catalogue_lib';
            $this->fld_catalogImg			= 	'catalogue_img';
            $this->fld_catalogTags			= 	'catalogue_tags';
            $this->fld_catalogPrixVente		= 	'catalogue_prix_vente';
            $this->fld_catalogPrixAchat		= 	'catalogue_prix_achat';
            $this->fld_catalogDate			= 	'catalogue_date';
            $this->fld_catalogLang			= 	'lang';
            $this->fld_catalogDisplay		= 	'display';

            $this->fld_catalogImgLib		= 	'catalogue_img_lib';

            $this->fld_catalogTypeLib		= 	'catalogue_type_lib';
            $this->fld_catalogTypeLang		= 	'lang_id';
            $this->fld_catalogTypeDisplay	= 	'display';

            $this->set_catalog_dir('modules/catalog/', 'img/main/', 'img/thumbs/');
            $this->mod_page					= 	'catalogue.php';
            $this->mod_queryKey				= 	'productId';
            $this->mod_catQueryKey			= 	'product_catId';
        }

		function cwd_catalog(){
			self::__construct();
		}
		
		//Set Catalog directories
		function set_catalog_dir($new_modDir, $new_pixDir, $new_thumbsDir){
			$this->imgs_dir 	= 	$new_modDir.$new_pixDir;
			$this->thumbs_dir	= 	$new_modDir.$new_thumbsDir;
			$this->mod_dir		= 	$new_modDir;
			
			/*$this->set_imgs_dir($this->imgs_dir);
			$this->set_thumbs_dir($this->thumbs_dir);*/
		}
		
		/**
		* Menu pour l'administration du module dans l'espace agr&eacute;&eacute; &agrave; cet effet.
		* 
		* @param void()
		* @return admin menu.
		* */
		function admin_get_menu(){
			$toRet = "<div class=\"ADM_menu\">
						<h1>Gestion du catalogue</h1>
						<ul class=\"ADM_menu_title\">
							<h2>Rubriques</h2>
							<li><a href=\"?what=productCatDisplay\">Lister les rubriques</a></li>
							<li>|</li>
							<li><a href=\"?what=productCatInsert\">Nouvelle rubrique</a></li>
						</ul>
						<ul>
							<h2>Les produits / articles</h2>
							<li><a href=\"?what=productDisplay\">Afficher les produits</a></li>
							<li>|</li>
							<li><a href=\"?what=productInsert\">Nouveau produit</a></li>
							<li>|</li>
							<li><a href=\"?what=productSearch\">Rechercher un produit</a></li>
						</ul>
					<div class=\"ADM_menu_descr\"></div>
					</div>";
			return $toRet;				  
		}
		
		/**
		 * Infos sur la classe catalogue, et ses proprietes
		 * 
		 * @param void()*/
		function get_catalog_infos(){
			return array("tbl_catalog"				=>	($this->tbl_catalog),
						 "tbl_catalog_type"			=>	($this->tbl_catalogType),
						 "catalog_id"				=>	($this->fld_catalogId),
						 "catalog_type_id"			=>	($this->fld_catalogTypeId),
						 "catalog_img_id"			=>	($this->fld_catalogImgId),
						 "catalog_mod_page"			=>	($this->mod_page),
						 "catalog_mod_query_key"	=>	($this->mod_queryKey),
						 "catalog_lib"				=>	($this->fld_catalogLib),
						 "catalog_prix_achat"		=>	($this->fld_catalogPrixAchat),
						 "catalog_prix_vente"		=>	($this->fld_catalogPrixVente),
						 "catalog_lang"				=>	($this->fld_catalogLang),
						 "catalog_date"				=>	($this->fld_catalogDate),
						 "catalog_display"			=>	($this->fld_catalogDisplay)); //on pe en rajouter
		}
		
		/**
		 * Obtenir un enregistrement de la table produit du catalogue sachant son id
		 * 
		 * @param string $new_fld
		 * @param int $new_valId
		 * 
		 * @return La valeur du champ $new_fld
		 * */
		function get_product_by_id($new_fld, $new_valId){
			return $this->get_field_by_id($this->tbl_catalog, $this->fld_catalogId, $new_fld, $new_valId);
		}
		
		function load_catalog_id(){
			return $this->load_id($this->load_id($this->tbl_catalog, $this->fld_catalogId));
		}
		
		/**
		* Charger toutes les pages dans un tableau
		*/
		function display_catalog($pageDest, $lang='FR', $nombre='20', $more='Plus de details'){
		    global $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
			
			//Recherche du nom de la page
			/*$path_parts = pathinfo($PHP_SELF);
			$page = $path_parts["basename"];*/
			
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl($this->tbl_catalog, $this->fld_catalogId);
			
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
			
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->affichepage2($nombre, $pageDest, $total);
						
			$query 		= 	"SELECT * FROM $this->tbl_catalog WHERE $this->fld_catalogDisplay = '1' ORDER BY $this->fld_catalogDate DESC LIMIT ".$limite.",".$nombre;
			$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
			if($total_1	= 	mysqli_num_rows($result)){
				$num	= 0;
				$toRet = "<div style=\"margin-bottom:5px;\">$nav_menu</div>";
				while($row = mysqli_fetch_row($result)){
					$num++;
					$id	= $row[0];
					//Alternate row
					$currentCls = ((($num%2) == 0) ? ("ADM_row1") : ("ADM_row2"));
					$productImg	= 	(($row[5] == "") ? ($this->defaultImg) : ($row[5]));
					$toRet .= "<div class=\"catalog_element\">
								<div class=\"catalog_element_title catalog_title_bg_left\">$row[3]</div>
								<div class=\"catalog_element_body\">
									<div class=\"catalog_element_pix\"><img src = \"".$this->thumbs_dir.$productImg."\" /></div>
									<div class=\"catalog_element_descr\">".$this->chapo(nl2br($row[2]), 85)."</div>
									<div class=\"clear_both\"></div>
									<div class=\"catalog_element_more\"><a href=\"".$pageDest.",".$row[0]."-"."detail.html"."\">$more</a></div>
									<div class=\"clear_both\"></div>
									<div class=\"catalog_element_price\">".$this->setNumber($row[6], 2, 0)." FCFA</div>
									<div class=\"clear_both\"></div>
								</div>
								<div class=\"clear_both\"></div>
							   </div>";
				}
				//Affichage de la ligne du menu de navigation
				//$toRet 	.="<div class=\"clear_both\"></div><div style=\"margin-bottom:5px;\">$nav_menu</div>";		  				  		
			}
			else{
				$toRet = "<p>Aucun &eacute;l&eacute;ment &agrave; afficher</p>";	
			}
			return $toRet."<div class=\"clear_both\"></div>";
		}

		function load_product_by_cat($pageDest, $new_productCat="", $nombre='25', $more="Read more"){
		    global $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
			
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl_where2($this->tbl_catalog, $this->fld_catalogId, $this->fld_catalogTypeId, $this->fld_catalogDisplay, $new_productCat, '1');
			
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
			
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->affichepage($nombre, $pageDest, $total);
				
		 	$query 		= 	"SELECT * FROM $this->tbl_catalog WHERE $this->fld_catalogTypeId = '$new_productCat' && $this->fld_catalogDisplay = '1' ORDER BY $this->fld_catalogDate DESC LIMIT ".$limite.",".$nombre;
			$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
			if($total_1	= 	mysqli_num_rows($result)){
				$num	= 0;
				$toRet = "<div class = \"catalog_wrapper\"><span class=\"tbl_nav_menu\">$nav_menu</span><div class=\"clear_both\"></div>";
				while($row = mysqli_fetch_row($result)){
					$num++;
					$id	= $row[0];
					//Alternate row
					$currentCls = ((($num%2) == 0) ? ("ADM_row1") : ("ADM_row2"));
					$productImg	= 	(($row[5] == "") ? ($this->defaultImg) : ($row[5]));
					$toRet .= "<div class=\"catalog_element\">
								<div class=\"catalog_element_title catalog_title_bg_left\">$row[3]</div>
								<div class=\"catalog_element_body\">
									<div class=\"catalog_element_pix\"><img src = \"".$this->thumbs_dir.$productImg."\" /></div>
									<div class=\"catalog_element_descr\">".$this->chapo(nl2br($row[2]), 85)."</div>
									<div class=\"clear_both\"></div>
									<div class=\"catalog_element_more\"><a href=\"".$pageDest.",".$row[0]."-"."detail.html"."\">$more</a></div>
									<div class=\"clear_both\"></div>
									<div class=\"catalog_element_price\">".$this->setNumber($row[6], 2, 0)." FCFA</div>
									<div class=\"clear_both\"></div>
								</div>
								<div class=\"clear_both\"></div>
							   </div>";
				}
				//Affichage de la ligne du menu de navigation
				$toRet 	.="<div class=\"clear_both\"></div><span class=\"tbl_nav_menu\">$nav_menu</span></div>";		  				  		
			}
			else{
				$toRet = "<p>Aucun &eacute;l&eacute;ment &agrave; afficher</p>";	
			}
			return $toRet;
		}
		
		function load_catalog($pageDest, $lang='FR', $nombre='20', $more){
			return $this->display_catalog($pageDest, $lang, $nombre, $more);
		}
			
		function load_recent_product($number=5, $page_catalogDetail='catalog_read.php', $pageCatalog='catalogs.php', $lang='FR'){
		    global $thewu32_cLink;
			//Les titres des annonces les plus recentes ds un box
			//$number = ((int)($number - 1));
			$query = "SELECT $this->fld_catalogId, $this->fld_catalogLib, $this->fld_catalogDate, $this->fld_catalogImg FROM $this->tbl_catalog WHERE display = '1' and $this->fld_modLang ='$lang' ORDER BY $this->fld_catalogDate DESC LIMIT 0, $number";
			$result = mysqli_query($thewu32_cLink, $query) or die("Unable to load recent products from the catalog!!<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				//$annonces_link = "<p>&raquo;<a class=\"box_link\" href=\"$pageAnnonce\">Toutes les annonces</a></p>";
				$id 	= 	$this->fld_catalogId;
				$img	=	$this->fld_catalogImg;
				$lib	=	$this->fld_catalogLib;
				$date	=	$this->fld_catalogDate;
				$toRet 	= ""; //"<ul>";
				while($row = mysqli_fetch_array($result)){
					$productImg	= (($row[$img] == "") ? ($this->defaultImg) : ($row[$img]));
					$toRet	.= "<p>
							   		<a class=\"catalog_link\" href=\"$page_catalogDetail"."-".$row[$id]."-"."detail.html\"><strong>".$this->date_fr($row[$date])." - </strong>".$row[$lib]."</a>
							  	</p>";
				}
			}
			else{
				$toRet = "Aucune annonce &agrave; afficher!!";
			}
			return $toRet; //."</ul>";
		}
		
		function load_product_cat($pageDest="catalog.php", $errMsg=""){
		    global $thewu32_cLink;
			$query 	= "SELECT * FROM $this->tbl_catalogType ORDER BY $this->fld_catalogTypeLib";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load product categories.<br />".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$toRet = "<ul>";
				while($row = mysqli_fetch_array($result)){
					//$toRet .= "<li><a href=\"$pageDest"."&".$this->URI_productCat."=".$row[0]."\">$row[1]</a></li>";
					$toRet .= "<li><a href=\"$pageDest".",".$row[0].".html\">$row[1]</a></li>";
				}
				$toRet .="</ul>";
			}
			else{
				$toRet = $errMsg;
			}
			return $toRet;
		}
		
		function display_month_catalog($lang='FR', $nombre='20', $limite='0'){
		    global $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
			
			//Recherche du nom de la page
			$path_parts = pathinfo($PHP_SELF);
			$page = $path_parts["basename"];
			
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl($this->tbl_catalog, $this->fld_catalogId);
			
			
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
			
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->affichepage($nombre, $page, $total);
			$dayDate	= date("m");	
						
			$query 		= 	"SELECT * FROM $this->tbl_catalog WHERE catalogue_month = '$dayDate' ORDER BY $this->fld_catalogId DESC LIMIT ".$limite.",".$nombre;
			$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible de lister les pages.<br />".mysqli_connect_error());
			if($total_1	= 	mysqli_num_rows($result)){
				$num	= 0;
				$toRet = "<div class = \"catalog_wrapper\"><span class=\"tbl_nav_menu\">$nav_menu</span><div class=\"clear_both\"></div>";
				while($row = mysqli_fetch_row($result)){
					$num++;
					$id	= $row[0];
					//Alternate row
					$currentCls = ((($num%2) == 0) ? ("ADM_row1") : ("ADM_row2"));
					$toRet .= "<div class=\"catalog_element\">
								<div class=\"catalog_element_price\">$row[3]</div>
								<div>
									<div class=\"catalog_element_pix\"><img src = \"".$this->img_thumbs_dir.$this->get_product_img_by_id($row[5])."\" /></div>
									<div class=\"catalog_element_title\">".$this->setNumber($row[6])." FCFA</div>
									<div class=\"catalog_element_descr\">".$this->chapo($row[2], 65)."</div>
									<div class=\"clear_both\"></div>
								</div>
								<div class=\"catalog_element_sub\"><a href=\"catalogue_detail.php?$this->mod_queryKey=$row[0]\">++ Plus de detail</a></div>
								<div class=\"clear_both\"></div>
							   </div>";
				}
				//Affichage de la ligne du menu de navigation
				$toRet 	.="<div class=\"clear_both\"></div><span class=\"tbl_nav_menu\">$nav_menu</span></div>";		  				  		
			}
			else{
				$toRet = "<p>Aucun &eacute;l&eacute;ment &agrave; afficher</p>";	
			}
			return $toRet;
		}
		/**
		/* Mettre a jour le type de produit
		* */
		function update_product_cat($pcId, $pcLib, $pcLang, $pcDisplay='1'){
		    global $thewu32_cLink;
			$query	= "UPDATE $this->tbl_catalogType SET catalogue_type_lib = '$pcLib', lang_id = '$pcLang', display = '$pcDisplay' 
					   WHERE $this->fld_catalogTypeId = '$pcId'";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to update $this->tbl_catalogType...<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}
		
		function set_product_state($new_fldState='display', $new_userEntry, $new_stateValue){
			return $this->set_connected($this->tbl_catalog, $new_fldState, $this->fld_catalogId, $new_userEntry, $new_stateValue);
		}
		
		function set_product_cat_state($new_fldState='display', $new_userEntry, $new_stateValue){
			return $this->set_connected($this->tbl_catalogType, $new_fldState, $this->fld_catalogTypeId, $new_userEntry, $new_stateValue);
		}
		
		/**
		 * Mettre a jour le de produit
		 * */
		function update_product($prodId, $pcId, $prodDescr, $prodLib, $prodTags, $prod_imgId, $prodVente, $prodAchat, $prodDate, $prodLang, $prodDisplay){
		    global $thewu32_cLink;
			$query	= "UPDATE $this->tbl_catalog SET $this->fld_catalogTypeId 		= 	'$pcId', 
													 $this->fld_catalogDescr		= 	'$prodDescr', 
													 $this->fld_catalogLib			= 	'$prodLib',
													 $this->fld_catalogTags			= 	'$prodTags',
													 $this->fld_catalogImg			= 	'$prod_imgId',
													 $this->fld_catalogPrixVente	= 	'$prodVente',
													 $this->fld_catalogPrixAchat	= 	'$prodAchat',
													 $this->fld_catalogDate			=	'$prodDate',
													 $this->fld_catalogLang			=	'$prodLang',
													 $this->fld_catalogDisplay		=	'$prodDisplay' 
					   WHERE $this->fld_catalogId = '$prodId'";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to update the product in the data base...<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}
		
		function insert_product($new_catalogTypeId, $new_catalogDescr, $new_catalogLib, $new_catalogTags, $new_catalogImg, $new_catalogPVente, $new_catalogPAchat, $new_catalogDate, $new_catalogueLang, $new_catalogueDisplay){
		    global $thewu32_cLink;
			$month	= $this->get_month($new_catalogDate);
			$query	= "INSERT INTO $this->tbl_catalog VALUES('',
															 '$new_catalogTypeId',
															 '$new_catalogDescr',
															 '$new_catalogLib',
															 '$new_catalogTags',
															 '$new_catalogImg',
															 '$new_catalogPVente',
															 '$new_catalogPAchat',
															 '$new_catalogDate',
															 '$new_catalogueLang',
															 '$new_catalogueDisplay')";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Impossible d'ajouter un nouveau produit dans le catalogue!<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}
		
		function insert_product_type($new_catalogLib, $new_catalogTypeLang, $new_catalogDisplay){
		    global $thewu32_cLink;
			$query	= "INSERT INTO $this->tbl_catalogType VALUES('',
																 '$new_catalogLib',
																 '$new_catalogTypeLang',
																 '$new_catalogDisplay')";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Impossible d'ajouter un nouveau type de produit dans le catalogue!<br />".mysqli_connect_error());
			if($result)
				return true;
			else
				return false;
		}
		
		/** 
		 * @param string $new_valImg
		 * @desc Inserer une image ds la table des images du catalogue
		 * @return true/false 
		 * */
		function insert_product_image($new_valImg){
		    global $thewu32_cLink;
			$query = "INSERT INTO $this->tbl_catalogImg VALUES('', '$new_valImg')";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to add image in the system table...<br />".mysqli_connect_error());
			if($result)
				return mysql_insert_id();
			else 
				return false;
		}
		
		/**
		 * Supprimer les types de produits du catalogue!
		 * Attention, supprime aussi tous les produits appartenant a la meme categorie
		 * */
		function delete_product_cat($new_productCatId){
			return $this->cascadel($this->tbl_catalogType, $this->tbl_catalog, $this->fld_catalogTypeId, $new_productCatId);
		}
		/**
		 * Supprimer les produits du catalogue 
		 * */
		function delete_product($productId, $thumbSrc, $main_imgSrc){
			if($this->rem_entry($this->tbl_catalog, $this->fld_catalogId, $productId)){
				$imgId	= $this->get_img_id_by_product($productId);
				$imgName	= $this->get_product_img_by_id($imgId);
				if ($imgId != '0'){ //0 etant l'id de l'image par defaut, il ne fo pas la supprimer
					@unlink($thumSrc.$imgName);
					@unlink($main_imgSrc.$imgName);
				}
				return true;
			}
			else
				return false;
		}
		/**
		 * Suppressions multiples
		 * 
		 * @param array $tabId, le tableau des Ids
		 * @return int nb d'elts supprimes
		 * */
		function delete_products($tabId){
			//le totalCount correspond au nbre d'elt du tableau $tabId
			$n=0;
			if(is_array($tabId)){
				foreach($tabId as $key=>$value){
					$n++;
					$this->delete_product($value, $thumbSrc, $main_imgSrc);
				}
				return $n;
			}
			else 
				return false;
		}
		
		/**
		 * Charger les types de  produits du catalogue dans un combo box : option 1
		 * 
		 * @param void()
		 * */
		function cmb_load_product_type($FRM_var=''){
			return $this->cmb_get_row($this->tbl_catalogType, $this->fld_catalogTypeId, "catalogue_type_lib", "display", $FRM_var);
		}
		
		function get_product_cat_by_id($fldSrc, $entry){
			return $this->get_field_by_id($this->tbl_catalogType, $this->fld_catalogTypeId, $fldSrc, $entry);
		}
		
		/**
		 * Charger les types de  produits du catalogue dans un combo box : option 2 et la meilleure
		 * 
		 * @param string $FRM_var
		 * */
		function cmb_product_cat($FRM_var=""){
				$tab_productCat = $this->load_id($this->tbl_catalogType, $this->fld_catalogTypeId);
				$selected = "";
				foreach($tab_productCat as $value){
					$selected = (($FRM_var == $value) ? (" SELECTED"):(""));
					$toRet .="<option value=\"$value\"$selected>".$this->get_product_cat_by_id("catalogue_type_lib", $value)."</option>";
				}
				return $toRet;
			}
		
		
		/**
		 * Charger les images des produits du catalogue dans l'espace d'admin
		 * 
		 * @param  void()*/
		
		/**
		 * Obtenir le nom de l'image sachant son id depuis la table des produits du catalogue
		 * Le parametre ici c'est l'id de l'image et non du produit
		 * 
		 * @param int product_imgId
		 * */
		
		function get_product_img_by_id($product_imgId){
			return $this->get_field_by_id($this->tbl_catalogImg, $this->fld_catalogImgId, $this->fld_catalogImgLib, $product_imgId);
		}
		
		function get_product_cat($new_catId){
		    global $thewu32_cLink;
			$query  = "SELECT * FROM $this->tbl_catalogType WHERE $this->fld_catalogTypeId='$new_catId'";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load products categories".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				while($row = mysqli_fetch_row($result)){
					$toRet = array("product_cat_ID"		=>	$row[0],
								   "product_cat_LIB"	=>	$row[1],
								   "product_cat_LANGID"	=> 	$row[2],
								   "display"			=> 	$row[3]);
				}
				return $toRet;
			}
			else
				return false;
		}
		
		/**
		 * Obtenir l'enregistrement correspondant ï¿½ l'id d'un produit dans un tableau associatif
		 * 
		 * @param : int $new_productId
		 * 
		 * @return : array() 
		 * 
		 * */
		function get_product($new_productId){
		    global $thewu32_cLink;
			$query  = "SELECT * FROM $this->tbl_catalog WHERE $this->fld_catalogId='$new_productId'";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load $this->tbl_catalog".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				while($row = mysqli_fetch_row($result)){
					$toRet = array("product_ID"		=>	$row[0],
								   "product_CATID"	=>	$row[1],
								   "product_DESCR"	=>	$row[2],
								   "product_LIB"	=>	$row[3],
								   "product_TAGS"	=>	$row[4],
								   "product_IMG"	=> 	$row[5],
								   "product_PVENTE"	=> 	$row[6],
								   "product_PACHAT"	=> 	$row[7],
								   "product_DATE" 	=>	$row[8],
								   "product_LANG"	=>	$row[9],
								   "product_DISPLAY"=>	$row[10]);
				}
				return $toRet;
			}
			else
				return false;
		}
		
		/**
		 * Obtenir l'id de l'image d'un produit...
		 * Utile pr la methode get_product_img_by_id()
		 * */
		function get_img_id_by_product($productId){
			return $this->get_field_by_id($this->tbl_catalog, $this->fld_catalogId, $this->fld_catalogImgId, $productId);
		}
		
		/**
		 * Obtenir le nom d'une image, sachant l'id du produit, celui-ci se trouvant dans une autre table, celle des produits.
		 * 
		 * @param string $productId
		 * */
		function get_img_by_product($productId, $defaultImg="noimg.jpg"){
			//On prend l'id de l'image depuis la table des produits
			$newId	= $this->get_img_id_by_product($productId);
			//on recupere maintenat le nom de l'image depuis la table des images!
			if($newId == '0'){
				$this->defaultImg	= $defaultImg;
				return $this->defaultImg;
			}
			else
				return $this->get_product_img_by_id($newId);
		}
		
		function admin_load_catalog($nombre='3', $more="Read more"){
		    global $thewu32_cLink;
			$limite = $this->limit;
			if(!$limite) $limite = 0;
				
			//Recherche du nom de la page
			$path_parts = pathinfo($PHP_SELF);
			$page = $path_parts["basename"];
				
			//Obtention du total des enregistrements:
			$total = $this->count_in_tbl($this->tbl_catalog, $this->fld_catalogId);
				
				
			//V&eacute;rification de la validit&eacute; de notre variable $limite......
			$veriflimite = $this->veriflimite($limite, $total, $nombre);
			if(!$veriflimite) $limite = 0;
				
			//Bloc menu de liens
			if($total > $nombre) 
				$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
					
			$query 	= 	"SELECT * FROM $this->tbl_catalog ORDER BY $this->fld_catalogId DESC LIMIT ".$limite.",".$nombre;
			$result = 	mysqli_query($thewu32_cLink, $query) or die("Impossible de charger les produits...".mysqli_connect_error());
			if($total = mysqli_num_rows($result)){
				$num	= 	0;
				$toRet	= $nav_menu;
				$toRet 	.= "<table class=\"ADM_table\">
							<tr>
								<th>Num.</th>
								<th>Cat&eacute;gories</th>
								<th>Image</th>
								<th>Nom/Description</th>
								<th>P.Achat(CFA)</th>
								<th>P.Vente(CFA)</th>
								<th colspan=\"3\">Actions</th>
							</tr>";
				$selected = "";
				while($row = mysqli_fetch_row($result)){
					$num++;
					
					$stateImg = (($row[10] == "0") ? ("<img src=\"img/icons/disabled.gif\" />") : ("<img src=\"img/icons/enabled.gif\" />"));
					$varUri		= ($row[10] == "0")?("productPublish"):("productPrivate");
					$stateAlt	= ($row[10] == "0")?("Display it"):("Hide it");
					//Obtenir les libelles des categories
					$categorie 	= $this->get_product_cat_by_id($this->fld_catalogTypeLib, $row[1]);
					
					
					//Affichage des imagettes des articles
					$productImg	= 	(($row[5] == "") ? ($this->defaultImg) : ($row[5]));
					
					//Alternet les css
					$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
					$toRet .= "<tr class=\"$currentCls\">
								  <td>
								  	<input type=\"checkbox\" name=\"productId[]\" value=\"$row[0]\" /> $num
								  </td>
								  <td><strong>$categorie</strong></td>
								  <td>
								  		<a style=\"border:0;\" href=\"#\" onclick=\"".$this->popup("pop_product.php?pId=$row[0]", "600", "400")."\">
											<img style=\"width:50px; height:50px;\" class=\"productImg\" src=\"$this->thumbs_dir".$productImg."\" />
										</a>
								  </td>
								  <td>
									  <strong>$row[3]</strong><br />".strip_tags($row[2])."
								  </td>
								  <td align=\"center\">
									  $row[6]
								  </td>
								  <td align=\"center\">
									  $row[7]
								  </td>
								  <td align=\"center\">
									<a title=\"Update the product\" href=\"?what=productUpdate&action=productUpdate&$this->URI_product=$row[0]\"><img src=\"img/icons/edit.gif\" /></a>
								  </td>
								  <td align=\"center\">
									<a title=\"Delete the product\" href=\"?what=productDisplay&action=productDelete&$this->URI_product=$row[0]\" onclick=\"return confirm('Sure you want to delete?')\"><img src=\"img/icons/delete.gif\" /></a>
								  </td>
								  <td align=\"center\">
									<a title=\"$stateAlt\" href=\"?what=productDisplay&action=$varUri&$this->URI_product=$row[0]&limite=$limite\">$stateImg</a>
								  </td>
							   </tr>";
				}
				$toRet .= "</table>$nav_menu";
			}
			else
				return false;
			return $toRet;
		}
	/**
		* Charger toutes les categories de produits pour l'espace d'admin
		*/
		function admin_load_products_cat(){
		    global $thewu32_cLink;
			$query 		= 	"SELECT * FROM $this->tbl_catalogType ORDER BY catalogue_type_lib";
			$result		=	mysqli_query($thewu32_cLink, $query) or die("Impossible d'afficher les types de produit.<br />".mysqli_connect_error());
			if($total	= 	mysqli_num_rows($result)){
				$toRet 	= "";
				$num	= 0;
				$array_pos = array();
				while($row = mysqli_fetch_row($result)){
					$num++;
					$id	= $row[0];
					
					$stateImg 	= (($row[3] == "0") ? ("<img src=\"img/icons/disabled.gif\" />") : ("<img src=\"img/icons/enabled.gif\" />"));
					$var_uriCat	= ($row[3] == "0") ? ("productCatPublish"):("productCatPrivate");
					$stateAlt	= ($row[3] == "0") ? ("Display it"):("Hide it");
					
					//Pour eviter de supprimer toutes les categories...
					$txt_delLink	= "	| <a onclick=\"return confirm('&Ecirc;tes-vous s&ucirc;r de vouloir supprimer le type de produits s&eacute;lectionne&eacute;e? NB: Sa suppression engendrera celle des produits qui lui sont rattach&eacute;s!')\" href=\"?what=productCatDisplay&action=productCatDelete&$this->mod_catQueryKey=$row[0]\">Suppr.</a>";
					$txtDel	= ((($this->count_in_tbl($this->tbl_catalogType, $this->fld_catalogTypeId)) == 1 ) ? ("") : ($txt_delLink));
					
					//Alternate row
					$currentCls = ((($num%2) == 0) ? ("ADM_row1") : ("ADM_row2"));
					$toRet .= "<tr class=\"$currentCls\">
									<td align=\"center\">$num</td>
									<td>$row[1]</td>
									<td align=\"center\">
										<a title=\"Update the product\" href=\"?what=productCatUpdate&action=productCatUpdate&$this->URI_productCat=$row[0]\"><img src=\"img/icons/edit.gif\" /></a>
								  	</td>
								  	<td align=\"center\">
										<a onclick=\"return confirm('&Ecirc;tes-vous s&ucirc;r de vouloir supprimer le type de produits s&eacute;lectionn&eacute;? NB: Sa suppression engendrera celle des produits de m&ecirc;me cat&eacute;gorie!')\" title=\"Delete the product\" href=\"?what=productCatDisplay&action=productCatDelete&$this->URI_productCat=$row[0]\" onclick=\"return confirm('Sure you want to delete?')\"><img src=\"img/icons/delete.gif\" /></a>
								  	</td>
								  	<td align=\"center\">
										<a title=\"$stateAlt\" href=\"?what=productCatDisplay&action=$var_uriCat&$this->URI_productCat=$row[0]\">$stateImg</a>
								  	</td>
							   </tr>";
				}
			}
			else{
				$toRet = "Aucune liste &agrave; afficher";	
			}
			return $toRet;
		}
	}
?>