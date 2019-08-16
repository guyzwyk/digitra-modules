<?php
	class cwd_gallery extends cwd_system{
		/*Directories set*/
		var $thumbs_dir;
		var $imgs_dir;
		
		/*Tables set*/
		var $tbl_gallery;
		var $tbl_galleryCat;
		var $tbl_galleryComment;
		var $tbl_galleryCatComment;
		
		/*Id fields set*/
		var $fld_galleryId;
		var $fld_galleryCatId;
		var $fld_galleryCommentId;
		
		/*Other indexed fields*/
		var $fld_galleryLib;
		var $fld_galleryTitle;
		var $fld_galleryDescr;
		var $fld_galleryDate;
		var $fld_galleryLang;
		var $fld_galleryCatLib;
		var $fld_galleryCatDate;
		var $fld_galleryDisplay;
		
		/*Default module elements
		NB : elements par defaut du module*/
		var $galleryLink;
		var $imgDefault 	= 'noimg.gif';
		var $thumbDefault	= 'nothumb.gif';
		
		/*The URI_vars* 
		NB : très utilisees dans les loaders*/
		var $URI_galleryVar				= 'pmId';
		var $URI_galleryCatVar			= 'catId';
		
		var $URI_galleryCommentVar 		= 'pgcId';
		var $URI_galleryCatCommentVar	= 'gccId';
		
		/*The module files*/
		var $mod_link			= 'gallery.php';
		var $mod_linkDetail		= 'gallery_detail.php';
		var $mod_linkCat		= 'gallery_cat.php';
		var $mod_linkCatDetail	= 'gallery_cat_detail.php';
		
		/*Settings for xml*/
		var $xml_dir;
		var $xmlHeader;
		var $xmlMain;
		var $xmlFooter;
		
		/*Settings for Spry */
		var $spry_dataDir;
		var $spryHeader;
		var $spryMain;
		var $spryFooter;

		
		var $admin_page;

		public function __construct($new_thumbsDir="../img/thumbs/", $new_imgsDir="../img/main/", $new_spryDataDir='../spry/data/'){
            global $thewu32_tblPref;

            $this->set_thumbs_dir($new_thumbsDir);
            $this->set_imgs_dir($new_imgsDir);
            $this->set_spry_data_dir($new_spryDataDir);

            $this->admin_page				=	$this->digitra_get_mod_admin("gallery");

            $this->tbl_gallery				= 	$thewu32_tblPref.'gallery';
            $this->tbl_galleryCat			= 	$thewu32_tblPref.'gallery_category';
            $this->tbl_galleryComment		= 	$thewu32_tblPref.'gallery_comment';
            $this->tbl_galleryCatComment	= 	$thewu32_tblPref.'gallery_category_comment';

            $this->fld_galleryId			= 	'gallery_id';
            $this->fld_galleryCatLib		= 	'gallery_cat_lib';
            $this->fld_galleryCatId			= 	'gallery_cat_id';
            $this->fld_galleryCommentId		= 	'gallery_comment_id';
            $this->fld_galleryCatCommentId	= 	'gallery_cat_comment_id';

            $this->fld_galleryLib			= 	'gallery_lib';
            $this->fld_galleryTitle			=	'gallery_title';
            $this->fld_galleryDescr			=	'gallery_descr';
            $this->fld_galleryDate			= 	'gallery_date';
            $this->fld_galleryLang			=	'lang_id';
            $this->fld_galleryDisplay		=	'display';
            $this->fld_galleryCatDate		= 	'gallery_cat_date';

            //Spry
            $this->init_spry_gallery();
            $this->modName					=	'gallery';
            $this->modDir					.=	$this->modName;
        }

		function cwd_gallery(){
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
						  <h1>Gestion de la gal&eacute;rie d'images</h1>
						  <ul class=\"ADM_menu_title\">
							<h2>Les images</h2>
							<li><a href=\"?what=galleryDisplay\">Afficher les images</a></li>
							<li>|</li>
							<li><a href=\"?what=galleryInsert\">Ins&eacute;rer une image</a></li>
							<li>|</li>
							<li><a href=\"?what=gallery_commentDisplay\">Commentaires sur les photos</a></li>
						  </ul>
						  <ul>
							<h2>Les album ou cat&eacute;gories</h2>
							<li><a href=\"?what=galleryCatDisplay\">Afficher les albums</a></li>
							<li>|</li>
							<li><a href=\"?what=galleryCatInsert\">Nouvel album</a></li>
						  </ul>
						  <div class=\"ADM_menu_descr\"></div>
					  </div>";
			return $toRet;				  
		}
		
		
		function init_spry_gallery($file='spry-gallery.xml'){
			return $dsInit 	=	"<script type='text/javascript'>
									var dsGallery = new Spry.Data.XMLDataSet('".$this->spry_dataDir.$file."', 'gallery/item');
								</script>";
		}
			 /****************************************/	
			/* :::::::: All the getters ::::::::    */
		   /****************************************/	
			function get_gallery($new_galleryId){
			/**
			* @param : 	int $new_galleryId
			* @return : Array_Assoc()
			* @descr : 	Obtenir tout un enregistrement concernant une image de la galerie
			**/
			    global $thewu32_cLink;
				$query = "SELECT * FROM $this->tbl_gallery WHERE $this->fld_galleryId = '$new_galleryId'";
				$result = mysqli_query($thewu32_cLink, $query) or die("Unable to load gallery assoc table!<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					while($row = mysqli_fetch_array($result)){
						$toRet = array(
								 "ID"     		=> $row[0],
								 "CATID"  		=> $row[1],
								 "LIB"   		=> $row[2],
								 "DESCR"		=> $row[3],
								 "TITLE"    	=> $row[4],
								 "DATE"			=> $row[5],
								 "DISPLAY"  	=> $row[6]);
					}
					return $toRet;
				}
				else{
					return false;
				}
			}
			
			function get_gallery_ids(){
				return $this->load_id($this->tbl_gallery, $this->fld_galleryId, "WHERE display='1'");
			}
			
			function get_gallery_cat($new_galleryCatId){
			/**
			* @param : 	int $new_galleryCatId
			* @return : Array_Assoc()
			* @descr : 	Obtenir tout un enregistrement concernant la categorie d'appartenance à une image de la galerie
			**/
			    global $thewu32_cLink;
				$query = "SELECT * FROM $this->tbl_galleryCat WHERE $this->fld_galleryCatId = '$new_galleryCatId'";
				$result = mysqli_query($thewu32_cLink, $query) or die("Unable to load gallery category assoc table!<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					while($row = mysqli_fetch_array($result)){
						$toRet = array(
								 "CATID"     	=> $row[0],
								 "CATLIB"  		=> $row[1],
								 "CATDESCR"   	=> $row[2],
								 "CATDATE"		=> $row[3]);
					}
					return $toRet;
				}
				else{
					return false;
				}
			}
			
			function get_gallery_id($condition="WHERE 1"){
			/**
			* @param : 	string $sql_condition
			* @return : Array()
			* @descr : 	Renvoit un tableau d'Id des images selon la condition SQL $condition
			**/
				return $this->load_id($this->tbl_gallery, $this->fld_galleryId, $condition);
			}
			
			function get_gallery_by_cat($new_galleryCat){
			/**
			* @param : 	int newThumbsCat
			* @return : array
			*
			* @descr : 	Charger un tableau d'id d'images appartenant a la meme categorie
			*/
			    global $thewu32_cLink;
				$query 	= "SELECT $this->fld_galleryId FROM $this->tbl_gallery WHERE $this->fld_galleryCatId='$new_galleryCat'";
				$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load thumbs<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					$toRet = array();
					while($row = mysqli_fetch_row($result)){
						array_push($toRet, $row[0]);
					}
				}
				return $toRet;
			}
			
			function get_gallery_id_by_cat($new_galleryCatId){
				return $this->get_gallery_by_cat($new_galleryCatId);
			}
			
			function get_gallery_cat_id($condition="WHERE 1"){
			/**
			* @param : 	string $sql_condition
			* @return : Array()
			*
			* @descr : 	Renvoit un tableau d'Id des albums selon la condition SQL $condition
			**/
				return $this->load_id($this->tbl_galleryCat, $this->fld_galleryCatId, $condition);
			}
			
			function get_gallery_by_id($new_fldSrc, $new_galleryId){
			/**
			* @param : 	string $new_fldSrc, int $new_galleryId, 
			* @return : Field value or false
			* @descr : 	Renvoit la valeur d'un champ $new_fldSrc sachant l'Id de l'enregistrement 
			*          indexé dans la table des images de la galérie
			**/
				return $this->get_field_by_id($this->tbl_gallery, $this->fld_galleryId, $new_fldSrc, $new_galleryId);
			}
			
			function get_gallery_lib_by_id($new_galleryId){
			/**
			* @param : 	int $new_galleryId, 
			* @return : Field value or false
			* @descr : 	Le libelle de la photo
			**/
				return $this->get_gallery_by_id("gallery_lib", $new_galleryId);
			}
			
			function get_gallery_cat_by_id($new_fldCatSrc, $new_galleryCatId){
			/**
			* @param : 	string $new_fldCatSrc, int $new_galleryId, 
			* @return : Field value or false
			* @descr : 	Renvoit la valeur d'un champ $new_fldCatSrc sachant l'Id de l'enregistrement 
			*          	indexé dans la table des catégories ou albums
			**/
				return $this->get_field_by_id($this->tbl_galleryCat, $this->fld_galleryCatId, $new_fldCatSrc, $new_galleryCatId);
			}
			
			function get_gallery_cat_lib_by_id($new_galleryCatId){
			/**
			* @param : 	int $new_galleryCatId, 
			* @return : Field value or false
			* @descr : 	Le titre de la galerie photo
			**/
				return $this->get_gallery_cat_by_id($this->fld_galleryCatLib, $new_galleryCatId);
			}
			
			function get_thumbs_by_id($new_thumbsId){
				return $this->get_field_by_id($this->tbl_gallery, $this->fld_galleryId, "gallery_lib", $new_thumbsId);
			}
			
			function get_gallery_cat_lib_by_gallery_id($new_galleryId){
			/**
			* @param : 	int $new_imgId
			* @return : {CATLIB}
			*
			* @descr :	Connaitre le nom de la categorie(album) a laquelle appartient une image de la galerie
			*/
				$cat	= $this->get_field_by_id($this->tbl_gallery, $this->fld_galleryId, $this->fld_galleryCatId, $new_galleryId);
				return $this->get_field_by_id($this->tbl_galleryCat, $this->fld_galleryCatId, "gallery_cat_lib", $cat);
			}
			
			function get_gallery_cat_id_by_gallery_id($new_galleryId){
			/**
			* @param : 	int $new_galleryId
			* @return : {CATID}
			*
			* @descr :	Connaitre l'id de la categorie(album) auquel appartient une image de la galerie
			**/
				return $this->get_field_by_id($this->tbl_gallery, $this->fld_galleryId, $this->fld_galleryCatId, $new_galleryId);
			}
					
			function get_gallery_descr_by_id($new_galleryId){
			/**
			* @param : 	int $new_galleryId
			* @return : {DESCR}
			*
			* @descr :	Connaitre la description de l'image sachant son ID
			* Peut etre remplacee par get_gallery_by_id("gallery_descr", $new_galleryId). 
			* Il suffit de connaitre le nom du champ recherche
			**/
				return $this->get_field_by_id($this->tbl_gallery, $this->fld_galleryId, "gallery_descr", $new_galleryId);
			}
			
			function get_thumbs_id_by_cat($newThumbsCat){
			/**
			* @param : 	int newThumbsCat
			* @return : array
			*
			* @descr : 	Charger un tableau d'id des imagettes <=> get_gallery_by_cat()
			*/
				return $this->get_gallery_by_cat($newThumbsCat);
			}
			
			/****************************
			* 	La galerie en xml		*
			* **************************/
			function get_xmlGalleryByCat($new_galleryCatId){
			/**
			* @param int $new_galleryCatId
			* @return {gallery xml content by cat}
			*
			* @descr : Charger les enregistrement de meme categorie pour le fichier xml
			**/
			    global $thewu32_cLink;
				$query = "SELECT * FROM $this->tbl_gallery WHERE display = '1' AND $this->fld_galleryCatId = '$new_galleryCatId'";
				$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'extraire les images!<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					while($row = mysqli_fetch_array($result)){
						/*$toRet.='
								<galleryItem id="'.$row["gallery_id"].'">
									<galleryThumbs><![CDATA['.$row["gallery_lib"].']]></galleryThumbs>
									<galleryTitle><![CDATA['.$row["gallery_title"].']]></galleryTitle>
									<galleryDescr><![CDATA['.$row["gallery_descr"].']]></galleryDescr>
								</galleryItem>';*/
						$toRet.='
								<image>
									<date>'.$this->date_fr($row["gallery_date"]).'</date>
									<title>'.$row["gallery_title"].'</title>
									<desc>'.$row["gallery_descr"].'</desc>
									<thumb>'.$row["gallery_lib"].'</thumb>
									<img>'.$row["gallery_lib"].'</img>
								</image>';
					}
				}
				return $toRet;
			}
			
			function spry_ds_get_gallery_main(){
				/**
				 * @param int $new_galleryCatId
				 * @return {ds gallery content by cat}
				 *
				 * @descr : Charger les enregistrement de meme categorie pour le fichier xml
				 **/
			    global $thewu32_cLink;
				$query = "SELECT * FROM $this->tbl_galleryCat WHERE 1";
				$result = mysqli_query($thewu32_cLink, $query) or die("Impossible d'extraire les albums pour creer le contenu du data set de gallery<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					while($row = mysqli_fetch_array($result)){
						/*$toRet.='
						 <galleryItem id="'.$row["gallery_id"].'">
						 <galleryThumbs><![CDATA['.$row["gallery_lib"].']]></galleryThumbs>
						 <galleryTitle><![CDATA['.$row["gallery_title"].']]></galleryTitle>
						 <galleryDescr><![CDATA['.$row["gallery_descr"].']]></galleryDescr>
						 </galleryItem>';*/
						$toRet.='
								<album id="'.$row[0].'" lang = "'.$row[4].'" date="'.$row[3].'">
									'.$this->spry_ds_get_gallery_item($row[0]).'
								</album>';
					}
					return $toRet;
				}				
				else return false;
			}
			
			//Load albums
			
			//Load items
			function spry_ds_get_gallery_item($new_albumId){
				/**
				 * @return {gallery xml content by cat}
				 *
				 * @descr : Charger les enregistrement de meme categorie pour le fichier xml
				 **/
			    global $thewu32_cLink;
				$query = "SELECT * FROM $this->tbl_gallery WHERE $this->fld_galleryCatId	=	'$new_albumId'";
				$result = mysqli_query($thewu32_cLink, $query) or die("Unable to extract spry item from album!<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					while($row = mysqli_fetch_array($result)){
						/*$toRet.='
						 <galleryItem id="'.$row["gallery_id"].'">
						 <galleryThumbs><![CDATA['.$row["gallery_lib"].']]></galleryThumbs>
						 <galleryTitle><![CDATA['.$row["gallery_title"].']]></galleryTitle>
						 <galleryDescr><![CDATA['.$row["gallery_descr"].']]></galleryDescr>
						 </galleryItem>';*/
						$catLib	=	$this->get_gallery_cat_by_id($this->fld_galleryCatLib, $row['gallery_cat_id']);
						$toRet.='<item id="'.$row["gallery_id"].'" cat="'.$row["gallery_cat_id"].'">
										<cat><![CDATA['.$catLib.']]></cat>
										<date>'.$this->date_fr($row["gallery_date"]).'</date>
										<title><![CDATA['.$row["gallery_title"].']]></title>
										<desc><![CDATA['.$row["gallery_descr"].']]></desc>
										<thumb>'.$row["gallery_lib"].'</thumb>
										<img>'.$row["gallery_lib"].'</img>
										<display>'.$row["display"].'</display>
									</item>';
					}
				}
				return $toRet;
			}
			
			function set_spry_ds_gallery(){
				return $this->get_spry_gallery();
			}
			
			function get_last_gallery_lib_by_cat_id($new_galleryCatId){
			/**
			* @param 	: int $new_galleryCatId
			* @return 	: {last LIB}
			*
			* @descr 	: Obtenir la derniere image de la galerie photo $new_galleryCatId
			*				Etape1 : Obtient l'id le plus recent parmi ceux dont le catId=$new_galleryCatId --> lastId
			*				Etape2 : Utiliser une variante de get_field_by_id afin d'avoir la valeur du gallery_lib correspondant.
			**/
				$lastId = $this->show_last_where($this->tbl_gallery, $this->fld_galleryId, $this->fld_galleryCatId, $new_galleryCatId);//
				return $toRet = $this->get_gallery_by_id("gallery_lib", $lastId);
				//return $toRet = $this->get_gallery_cat_by_id("gallery_cat_lib", $lastId);
			}
			
			function get_imgDir(){
				return $this->img_dir;
			}

		/* :::::::: ---- GETTERS End ---- :::::::: */	


			 /****************************************/	
			/* :::::::: All the SETTERS ::::::::    */
		   /****************************************/	
		
			function set_imgs_dir($new_imgsDir){
			/**
			* @param : 	string new_imgDir
			* @return : true
			* @descr : 	Definir le repertoire des images
			*/
				/*if(!file_exists($new_imgsDir))
					$this->create_dir($new_imgsDir);*/
				return $this->imgs_dir = $new_imgsDir;
			}
		
		
			function set_thumbs_dir($new_thumbsDir){
			/**
			* @param : 	string new_thumbsDir
			* @return : true
			* @ descr : Definir le repertoire des imagettes (Images reduites)
			*/
				/*if(!file_exists($new_thumbsDir))
					$this->create_dir($new_thumbsDir);*/
				return $this->thumbs_dir = $new_thumbsDir;
			}
			
			
			function set_gallery($new_galleryId, $new_galleryCat, $new_galleryLib, $new_galleryDescr, $new_galleryTitle, $new_galleryDate, $new_galleryLang, $new_galleryPublishVal){
			/**
			* @param : int $new_galleryId
			* @param : 	int $new_galleryCat
			* @param : 	string $new_galleryLib
			* @param : 	string $new_galleryDescr
			* @param : 	string $new_galleryTitle
			* @param : 	date $new_galleryDate
			* @param : 	int $new_galleryPublishVal
			* @return : true
			* @descr : 	Ajouter une image dans la galerie photo
			*/
			    global $thewu32_cLink;
				$query	= "INSERT INTO $this->tbl_gallery VALUES('$new_galleryId', 
																 '$new_galleryCat', 
																 '$new_galleryLib', 
																 '$new_galleryDescr', 
																 '$new_galleryTitle',
																 '$new_galleryDate',
                                                                 '$new_galleryLang',
																 '$new_galleryPublishVal')";
				$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to add picture in the gallery...<br />".mysqli_connect_error());
				if($result)
					return true;
			}
			
			function set_gallery_cat($new_galleryCat, $new_galleryCatDescr, $new_galleryCatDate, $new_galleryCatLang){
			/**
			* @param : 	string $new_galleryCat
			* @return : true
			* @descr : 	Creer un nouvel album ou une nouvelle categorie
			*/
			    global $thewu32_cLink;
				$query	= "INSERT INTO $this->tbl_galleryCat VALUES('".$this->autoIncr($this->tbl_galleryCat, $this->fld_galleryCatId)."', 
																	'$new_galleryCat', 
																	'$new_galleryCatDescr', 
																	'$new_galleryCatDate',
																	'$new_galleryCatLang',
                                                                    '1')";
				$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to add category/album in the gallery...<br />".mysqli_error($thewu32_cLink));
				if($result)
					return true;
			}
			
			function set_gallery_comment($new_commentEmail, $new_commentName, $new_commentContent, $new_galleryId){
			/**
			* @param : string $new_commentEmail
			* @param : string $new_commentName
			* @param : string $new_commentContent
			* @param : int $new_galleryId
			* @return : true or false
			*
			* @descr : Ajouter un commentaire à une photo dont l'ID est $new_galleryId
			*/
			    global $thewu32_cLink;
				$datetime = date("Y-m-d")." ".date("G:h:i");
				$query = "INSERT INTO $this->tbl_galleryComment VALUES('', 
																	   '$new_galleryId', 
																	   '$datetime', 
																	   '$new_commentName', 
																	   '$new_commentEmail', 
																	   '$new_commentContent', 
																	   '1')";
				$result = mysqli_query($thewu32_cLink, $query) or die("Unable to insert a comment for the gallery module!<br />".mysqli_connect_error());
				if($result)
					return true;
				else
					return false;
			}
			
			function set_member_gallery_comment($new_galleryId, $new_usrId, $new_commentContent){
			/**
			* @param : string $new_galleryId
			* @param : string $new_usrId (ID du membre)
			* @param : string $new_commentContent
			* @return : true or false
			*
			* @descr : Ajouter un commentaire à une photo dont l'ID est $new_galleryId, par un membre enregistre.
			*/
			    global $thewu32_cLink;
				$datetime = date("Y-m-d")." ".date("G:h:i");
				$query = "INSERT INTO $this->tbl_galleryComment VALUES('', 
																	   '$new_galleryId', 
																	   '$datetime', 
																	   '$new_usrId', 
																	   '', 
																	   '$new_commentContent', 
																	   '1')";
				$result = mysqli_query($thewu32_cLink, $query) or die("Unable to insert comment for the gallery module by a member!<br />".mysqli_connect_error());
				if($result)
					return true;
				else
					return false;
			}
			
			function set_gallery_cat_default_param($varURL){
			/**
			* @descr : Methode pour la securisation des variables d'URL
			**/	
				$this->URI_galleryCatVar	= (!isset($varURL)) ? ("1") : ($_REQUEST[$this->URI_galleryCatVar]);
				$tab_galleryCat	= $this->get_gallery_cat_id();
				if(in_array($this->URI_galleryCatVar, $tab_galleryCat)){
					return $this->URI_galleryCatVar;
				}
				else{
					return 1;
				}
			}
			
			function set_img_default($imgDefault){
				return $this->imgDefault = $imgDefault;
			}
			
			function img_create_thumb($file_name, $txt="", $ratio="100"){
				$file_dest = $this->thumbs_dir.".".$file_name;	
				if(isset($file_name)){
					//header('Content-type: image/png');			
					/***************************************************/
					/* premiï¿½re &eacute;tape : r&eacute;cup&eacute;ratin du poids de l'image               */
					/***************************************************/
					$file_size = filesize($file_name); //r&eacute;cup&eacute;ration de la taille en octets
					$file_size = round($file_size/1024); //conversion en ko
					/***************************************************/
					/* seconde &eacute;tape : calcul des dimensions de la                        */
					/* nouvelle image comprenant contour + l&eacute;gende                    */
					/***************************************************/
					list($largeur, $hauteur) = getimagesize($file_name); //dimensions de l'image originale
					/***************************************************/
					/* on veut une image r&eacute;duite de 150px de large                       */
					/* sans compter les contours                                                      */
					/* on doit donc diviser la largeur par 150                                */
					/* on passe ï¿½ l'inverse car on multiplie par la                          */
					/* suite : cela &eacute;vite un agrandissement                                     */
					/***************************************************/
					$ratio = $ratio / $largeur; //ratio pour r&eacute;duire ï¿½ une taille voulue
					$vignette_largeur = $largeur * $ratio + 2; //on ajoute 2px ï¿½ cause du contour
					/* on ajoute 3px ï¿½ cause du contour+l&eacute;gende */
					/* imagefontheight retourne la hauteur en pixels */
					/* d'une police s&eacute;lection&eacute;e : cela permet de */
					/* calculer la hauteur de la l&eacute;gende */
					$vignette_hauteur = $hauteur * $ratio + 3 + imagefontheight(3);
					$n_image_largeur = $largeur * $ratio; //largeur de l'image r&eacute;duite
					$n_image_hauteur = $hauteur * $ratio; //hauteur de l'image r&eacute;duite
					/***************************************************/
					/* cr&eacute;ation de la vignette : on attribue aucune */
					/* couleur pour laisser un cadre noir */
					/***************************************************/
					$image = imagecreatetruecolor($vignette_largeur,$vignette_hauteur);
					/***************************************************/
					/* cr&eacute;ation de la l&eacute;gende : texte en blanc */
					/***************************************************/
					$blanc = imagecolorallocate($image,255,255,255); //couleur blanche
					//$string = $largeur."x".$hauteur." ".$file_size."ko"; //cr&eacute;ation du texte de l&eacute;gende
					/* on doit d&eacute;terminer l'endroit pour commencer */
					/* ï¿½ &eacute;crire. On centre le texte d'oï¿½ la */
					/* formulation plus complexe */
					$write_h = $vignette_hauteur - imagefontheight(3) - 1; //hauteur
					/* centrage -> on r&eacute;cupï¿½re $n_largeur la largeur */
					/* de la vignette, on lui retire la largeur de la */
					/* police multipli&eacute;e par le nombre de caractï¿½res */
					/* puis on divise le r&eacute;sultat par 2 pour centrer */
					$write_w = ($vignette_largeur - strlen($txt) * imagefontwidth(3))/2;
					imagestring($image, 3, $write_w, $write_h, $txt, $blanc); //on &eacute;crit la l&eacute;gende
					/***************************************************/
					/* ouverture du fichier */
					/***************************************************/
					$source = imagecreatefromjpeg($file_name);
					/***************************************************/
					/* r&eacute;duction, r&eacute;&eacute;chantillonage et copie de l'image */
					/* originale */
					/* on recopie l'image ï¿½ partir du point de */
					/* coordonn&eacute;es 1,1 pour laisser un cadre noir */
					/***************************************************/
					imagecopyresampled($image,$source, 1,1, 0,0, $n_image_largeur , $n_image_hauteur , $largeur,
					$hauteur);
					/***************************************************/
					/* envoi de l'image et destruction */
					/***************************************************/		
					if(imagepng($image, $file_dest)){
						return true;
						imagedestroy($image);
					}
				}		
			}
			
			/**
			 * Supprimer les images de la galerie
			 * */
			function delete_thumb($thumbId){
				return $this->delete_to_gallery($thumbId);
			}
			
			function delete_to_gallery($new_thumbId){
				if($this->rem_entry($this->tbl_gallery, $this->fld_galleryId, $new_thumbId)){ //Suppression de la BDD OK
					$img_toBeDeleted	= $this->get_gallery_lib_by_id($new_thumbId);
					$imgSrc				= $this->imgs_dir.$img_toBeDeleted;
					$thumbSrc			= $this->thumbs_dir.$img_toBeDeleted;
					if((@unlink("$imgSrc")) && (@unlink("$thumbSrc")))
						return true;
				}
				else
					return false;
			}
			
			function delete_thumbs($totalCount, $tabId){
			/**
			* @param : 	string $totalCount
			* @param :	array $tabId (les id regroupes dans un tableau)
			* @return :	true or false
			*
			* @descr : 	supprimer plusieurs images a la fois. 
			*			Les images sont dans un tableau.
			**/
				//le totalCount correspond au nbre d'elt du tableau $tabId
				foreach($tabId as $key=>$value){
					return $this->delete_to_gallery($value);
				}
			}
			/**
			 * Supprime les albums et range les photos ds la categorie par defaut
			 * */
			function delete_gallery_cat($new_catId){
				if($this->rem_entry($this->tbl_galleryCat, $this->fld_galleryCatId, $new_catId))
					return true;
				else
					return false;
			}
			
			/*Supprimer un commentaire*/
			function del_gallery_comment($new_galleryCommentId){
				return $this->rem_entry($this->tbl_galleryComment, $this->fld_galleryCommentId, $new_galleryCommentId);
			}
			/****************************
			* 	La galerie en xml		*
			* **************************/
			function set_xml_dir($newDir){
				if(file_exists($newDir))
					return $this->xml_dir = $newDir;
				else
					return false;
			}
			
			function set_spry_data_dir($new_spryDataDir='modules/gallery/spry/data/'){
				if(file_exists($new_spryDataDir))
					return $this->spry_dataDir = $new_spryDataDir;
				else
					return false;
			}
			
			function get_spry_data_dir(){
				return $this->spry_dataDir;
			}
			
			function set_xmlgalleryHeader(){
				$date			= 	$this->get_datetime();
				$galleryHeader	= 	'<?xml version = "1.0" encoding="ISO-8859-1" ?>';
				//$galleryHeader	.=	'<gallery title="DIGITRA Gallery" thumbDir="img/thumbs/" imageDir="img/main/" random="False">';
				$galleryHeader	.=	'<gallery title="DIGITRA Gallery" thumbDir="'.$this->thumbs_dir.'" imageDir="'.$this->imgs_dir.'" random="False">';
				$galleryHeader	.=	'<channel>';
				$galleryHeader	.= 	'<author>DIGITRA Labs - '.$date.' </author>';
				$galleryHeader	.=	'<version>1.0</version>';
				$galleryHeader	.=	'</channel>';
				
				$this->imgs_dir;
				
				return $this->xmlHeader = $galleryHeader;
			}
			
			
			function set_xmlgalleryMain(){
			/**
			* @param : void
			* @return {gallery xml main content}
			*
			* @descr : Generer le contenu du fichier xml
			**/
				$tab_galleryCat	=	$this->load_id($this->tbl_galleryCat, $this->fld_galleryCatId);//load_galleryCat();
				foreach ($tab_galleryCat as $value){
					$catLib		= $this->get_field_by_id($this->tbl_galleryCat, $this->fld_galleryCatId, "gallery_cat_lib", $value);
					$catMain	= $this->get_xmlGalleryByCat($value);
					$lineContent	.= '<category name="'.$catLib.'">'.$catMain.'</category>';
					//$lineContent	.= '<category id="'.$catLib.'">'.$catMain.'</category>';
				}
				return $lineContent;
			}
			
			function set_xmlgalleryFooter(){
			/**
			* @param : void
			* @return {gallery xml footer}
			*
			* @descr : Inserer le footer a la fin du fichier xml
			**/
				return $toRet	=	"</gallery>";
			}
			
			function set_xml_gallery($dirDest){
			/**
			* @param : 	$dirDest (Repertoire de destination pour le fichier xml)
			* @return 	true or false
			*
			* @descr : 	Creer un fichier xml pour la gelerie
			**/
				$dirDest 			= 	$this->set_xml_dir($dirDest);
				$xml_galleryHeader	= 	$this->set_xmlgalleryHeader();
				$xml_galleryMain	=	$this->set_xmlgalleryMain();
				$xml_galleryFooter	= 	$this->set_xmlgalleryFooter();
				if ($this->create_xml($dirDest, $xml_galleryHeader, $xml_galleryMain, $xml_galleryFooter))
				/*$fileContent	= 	$xml_galHeader.$xml_galMain.$xml_galFooter;
				if($this->write_in_file($dirDest, $fileContent)) fonctionne aussi tres bien */
					return true;
				else
					return false;
			}
			
			function create_xml_gallery($dirDest){
				return $this->set_xml_gallery($dirDest);
			}
			
			/**
			 * Creating a spry Data Sheet for gallery without album
			 * */
			function create_spry_ds($fileDest='spry-gallery.xml'){
				$dest			=	$this->spry_dataDir.$fileDest;
				$spry_dsHeader	=	$this->set_xmlgalleryHeader();
				//$spry_dsMain	=	$this->get_spry_gallery();
				$spry_dsFooter	=	$this->set_xmlgalleryFooter();
				if($this->create_xml($dest, $spry_dsHeader, $spry_dsMain, $spry_dsFooter))
					return true;
				else
					return false;
				
			}
			
			/**
			 * Creating a spry Data Sheet for gallery with albums ::
			 * */
			function spry_ds_create($fileDest='spry-gallery.xml'){
				$dest			=	$this->spry_dataDir.$fileDest;
				$spry_dsHeader	=	$this->set_xmlgalleryHeader();
				$spry_dsMain	=	$this->spry_ds_get_gallery_main();
				$spry_dsFooter	=	$this->set_xmlgalleryFooter();
				if($this->create_xml($dest, $spry_dsHeader, $spry_dsMain, $spry_dsFooter))
					return true;
				else
					return false;
			}
		/* :::::::: ---- Setters End ---- :::::::: */	

		
			
			 /****************************************/	
			/* :::::::: All the LOADERS ::::::::    */
		   /****************************************/	
			
			/*function load_galleryCat(){
				$query = "SELECT * FROM $this->tbl_galleryCat WHERE display = '1'";
				$result = mysqli_query($thewu32_cLink, $query) or 
			}*/
			function admin_load_gallery($nombre='30', $limit='0'){
			/**
			* @param int $nombre (nombre d'enregistrement par page)
			* @param int $limit (initialisation de la pagination)
			* @return : {Tableau HTML + images} ou {MSG --> Aucune image a afficher}
			*
			* @descr : Afficher toutes les images de la BDD dans l'espace d'admin
			**/
			    global $thewu32_cLink;
				$limite = $this->limit;
				if(!$limite) $limite = 0;
				
				//Recherche du nom de la page
				$path_parts = pathinfo($PHP_SELF);
				$page = $path_parts["basename"];
				
				//Obtention du total des enregistrements:
				$total = $this->count_in_tbl($this->tbl_gallery, $this->fld_galleryId);
				
				
				//Verification de la validite de notre variable $limite......
				$veriflimite = $this->veriflimite($limite, $total, $nombre);
					if(!$veriflimite) $limite = 0;
					
				//Bloc menu de liens
				if($total > $nombre) 
					$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
					
				$query 	= "SELECT * FROM $this->tbl_gallery ORDER BY $this->fld_galleryId DESC LIMIT ".$limite.",".$nombre;
				$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news!<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					$num	= 0;
					$toRet 	= $nav_menu."";
					while($row = mysqli_fetch_array($result)){
						$num++;
						//alterner les liens public / prive
						$stateImg 	= ($row[6] == "0") ? ("<img src=\"img/icons/disabled.gif\" />") : ("<img src=\"img/icons/enabled.gif\" />");
						$varUri		= ($row[6] == "0")?("galleryPublish"):("galleryPrivate");
						$stateAlt	= ($row[6] == "0")?("publier la photo"):("Masquer la photo");
						
						
		  				$state_lnk = (($row[6] == 0) ? ("?what=galleryDisplay&action=galleryPublish") : ("?what=galleryDisplay&action=galleryPrivate"));
		  				$state_cls = (($row[6] == 0) ? ("green") : ("red"));
						
						//Obtenir les libelles des categories
						$album 	= $this->get_gallery_cat_lib_by_gallery_id($row[0]);
						//Convertir la date
						$date		= $this->date_fr($row[5]);
						//Alternet les css
						$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
						
						$toRet .="<tr class=\"$currentCls\">
									<td align=\"center\">$num&nbsp;<input type=\"checkbox\" name=\"".$this->URI_galleryVar."[]\" value=\"$row[0]\" /></td>
									<td>$album</td>
									<td>$row[4]</td>
									<td>$row[3]</td>
									<td>$date</td>
									<td><a style=\"border:0;\" href=\"#\" onclick=\"".$this->popup("pop_img.php", "600", "400")."\"><img class=\"galleryImg\" src=\"$this->thumbs_dir$row[2]\" /></a></td>
									<td nowrap style=\"background-color:#FFF; text-align:center;\">
										<a href=\"?what=galleryUpdate&action=galleryUpdate&".$this->URI_galleryVar."=$row[0]&limite=$_REQUEST[limite]#UPDATE\"><img src=\"img/icons/edit.gif\" /></a>
										<a href=\"?what=galleryDisplay&action=galleryDelete&".$this->URI_galleryVar."=$row[0]\" onclick=\"return confirm('Sure you want to delete?')\"><img src=\"img/icons/delete.gif\" /></a>
										<a title=\"$stateAlt\" href=\"$state_lnk&".$this->URI_galleryVar."=$row[0]\">$stateImg</a>
									</td>
								  </tr>";
					}
					$toRet .= "</table>$nav_menu";					
				}
				else{
					$toRet	= "<tr><td colspan=\"7\">Aucune image &agrave; afficher</td></tr></table>";
				}
				return $toRet;
			}
			
			function admin_load_gallery_by_cat($new_galleryCat='1', $nombre='30', $limit='0'){
			/**
			* @param : 	string $new_galleryCat
			* @param : 	string $nombre 
			* @param : 	int $limit
			* @return : tableau HTML d'images d'un album
			* @descr : 	Charger toutes les images d'un album
			*/
			    global $thewu32_cLink;
				$limite = $this->limit;
				if(!$limite) $limite = 0;
				
				//Recherche du nom de la page
				$path_parts = pathinfo($PHP_SELF);
				$page = $path_parts["basename"];
				
				//Obtention du total des enregistrements:
				$total = $this->count_in_tbl_where1($this->tbl_gallery, $this->fld_galleryId, $this->fld_galleryCatId, $new_galleryCat);
				
				
				//V&eacute;rification de la validit&eacute; de notre variable $limite......
				$veriflimite = $this->veriflimite($limite, $total, $nombre);
					if(!$veriflimite) $limite = 0;
					
				//Bloc menu de liens
				if($total > $nombre) 
					$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
					
				$query 	= "SELECT * FROM $this->tbl_gallery WHERE $this->fld_galleryCatId='$new_galleryCat' ORDER BY $this->fld_galleryDate and $this->fld_galleryId DESC LIMIT ".$limite.",".$nombre;
				$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load gallery by cat!<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					$num	= 0;
					$toRet 	= $nav_menu."<form enctype=\"multipart/form-data\" action=\"\" method=\"post\">";
					$toRet 	.= "";
					while($row = mysqli_fetch_array($result)){
						$num++;
						//alterner les liens public / prive
						$stateImg 	= ($row[6] == "0") ? ("<img src=\"img/icons/disabled.gif\" />") : ("<img src=\"img/icons/enabled.gif\" />");
						$varUri		= ($row[6] == "0")?("galleryPublish"):("galleryPrivate");
						$stateAlt	= ($row[6] == "0")?("publier la photo"):("Masquer la photo");
						//Obtenir les libelles des categories
						$album 	= $this->get_gallery_cat_lib_by_gallery_id($row[0]);
						//Convertir la date
						$date		= $this->date_fr($row[5]);
						//Alternet les css
						$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
						
						$toRet .="<tr class=\"$currentCls\">
									<td align=\"center\">$num&nbsp;<input type=\"checkbox\" name=\"galleryId[]\" value=\"$row[0]\" /></td>
									
									<td>$row[4]</td>
									<td>$row[3]</td>
									<td>$date</td>
									<td><a style=\"border:0;\" href=\"#\" onclick=\"".$this->popup("pop_img.php", "600", "400")."\"><img class=\"pxGalImg\" src=\"$this->thumbs_dir$row[2]\" /></a></td>
									<td nowrap>
										<ul>
											<a href=\"?what=galleryUpdate&action=galleryUpdate&".$this->URI_galleryVar."=$row[0]&limite=$_REQUEST[limite]#UPDATE\"><img src=\"img/icons/edit.gif\" /></a>
											<a href=\"?what=galleryDisplay&action=galleryDelete&".$this->URI_galleryVar."=$row[0]\"><img src=\"img/icons/delete.gif\" /></a>
											<a title=\"$stateAlt\" href=\"$state_lnk&".$this->URI_galleryVar."=$row[0]\">$stateImg</a>
										</ul>
									</td>
								  </tr>";
					}
					$toRet .= "</table>$nav_menu<div style=\"margin:20px 7px;\">
					<input onclick=\"return confirm('&Ecirc;tes-vous s&ucirc;r de vouloir supprimer les images s&eacute;lectionn&eacute;es?')\" type=\"submit\" name=\"btn_deleteSelectedGallery\" value=\"Supprimer les images s&eacute;lectionn&eacute;es\" />
				</div></form>";
					
				}
				else{
					$toRet	= "<tr><td colspan=\"6\">No data</td></tr>";
				}
				return $toRet."</table>";
			}
			
			function admin_load_gallery_comment($nombre='50', $limit='0'){
			/**
			* @param :	int $nombre (nombre d'enregistrement par page)
			* @param :	int $limit	(initialisation de la limite)
			* @return : Un tableau HTML contenant les commentaires sur images
			*/
			    global $thewu32_cLink;
				$limite = $this->limit;
				if(!$limite) $limite = 0;
				
				//Recherche du nom de la page
				$path_parts = pathinfo($PHP_SELF);
				$page = $path_parts["basename"];
				
				//Obtention du total des enregistrements:
				$total = $this->count_in_tbl($this->tbl_galleryComment, $this->fld_galleryCommentId);
				
				
				//V&eacute;rification de la validit&eacute; de notre variable $limite......
				$veriflimite = $this->veriflimite($limite, $total, $nombre);
					if(!$veriflimite) $limite = 0;
					
				//Bloc menu de liens
				if($total > $nombre) 
					$nav_menu	= $this->cmb_affichepage($nombre, $page, $total);
					
				$query 	= "SELECT * FROM $this->tbl_galleryComment ORDER BY $this->fld_galleryCommentId DESC LIMIT ".$limite.",".$nombre;
				$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load news reaction!<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					$num	= 0;
					$toRet 	= $nav_menu;
					$toRet 	.= "";
					while($row = mysqli_fetch_array($result)){
						$num++;
						//alterner les liens public / prive
						$linkState	= ($row[6] == "0")?("Priv."):("Pub.");
						$varUri		= ($row[6] == "0")?("gallery_commentPublish"):("gallery_commentPrivate");
						$linkTitle	= ($row[6] == "0")?("Publier le commentaire"):("Masquer le commentaire");
						//Obtenir les libelles des categories
						$tab_gallery	= $this->get_gallery($row[1]);
						//Convertir la date
						$date		= $this->datetime_fr3($row[2]);
						//Alternet les css
						$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));
						
						$toRet .="<tr class=\"$currentCls\">
									<td align=\"center\">$num</td>
									<td>".$tab_gallery[TITLE]."</td>
									<td>$date</td>
									<td>$row[3]</td>
									<td>$row[4]</td>
									<td>".utf8_encode(stripslashes($row[5]))."</td>
									<td nowrap align=\"center\">
									<a title=\"Supprimer le commentaire\" href=\"?what=gallery_commentDisplay&action=gallery_commentDelete&".$this->URI_galleryCommentVar."=$row[0]\" onclick=\"return confirm('La suppression de ce commentaire sera irr&eacute;m&eacute;diable!')\">Supp.</a> | [ <a title=\"$linkTitle\" href=\"?what=gallery_commentDisplay&action=$varUri&".$this->URI_galleryCommentVar."=$row[0]\">$linkState</a> ]
									</td>
								  </tr>";
					}
					$toRet .= "</table>$nav_menu";
					
				}
				else{
					$toRet	= "Aucun commentaire &agrave; afficher";
				}
				return $toRet;
			}
			
			function admin_load_gallery_cat(){
			    global $thewu32_cLink;
				$query 	= "SELECT * FROM $this->tbl_galleryCat ORDER BY gallery_cat_date DESC";
				$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load pix categories!<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					$num	= 0;
					$toRet 	= "";
					while($row = mysqli_fetch_array($result)){
						$num++;
						//alterner les liens public / prive
						$linkState	= ($row[10] == "0")?("Priv."):("Pub.");
						$varUri		= ($row[10] == "0")?("newsCatPublish"):("newsCatPrivate");
						$linkTitle	= ($row[10] == "0")?("Rendre la rubrique publique"):("Rendre la rubrique priv&eacute;e");
						//Alternet les css
						$currentCls = ((($num%2)==0) ? ("ADM_row1") : ("ADM_row2"));				
						$linkSupp = $row[0] == "1" ? ("") : (" | <a title=\"Supprimer l'album\" href=\"?what=galleryCatDisplay&action=galleryCatDelete&".$this->URI_galleryCatVar."=$row[0]\" onclick=\"return confirm('La suppression de cet album entrainera celle des images correspondantes! Continuer?')\">Supp.</a>");
						$toRet .="<tr class=\"$currentCls\">
									<td align=\"center\">$num</td>
									<td><a href=\"?what=galleryDisplayByCat&".$this->URI_galleryCatVar."=$row[0]\">$row[1]</a></td>
									<td nowrap align=\"center\">
									<a title=\"Modifier l'album\" href=\"?what=galleryCatDisplay&action=galleryCatUpdate&".$this->URI_galleryCatVar."=$row[0]\">Mod.</a>
									$linkSupp
									</td>
								  </tr>";
					}
					$toRet .="</table>";
					
				}
				else{
					$toRet	= "Aucun Album &agrave; afficher";
				}
				return $toRet;
			}
			
			
			/**
			* @param : 	$string $FRM_varAfficher les albums ou categories dans un combobox
			* @return : ComboBox
			* @descr :	Obtenir la liste des albums dans un combo box
			**/
			/* function load_cmb_gallery_cat($FRM_var=""){
			
				$query = "SELECT * FROM $this->tbl_galleryCat ORDER BY $this->fld_galleryCatDate DESC";
				$result = mysqli_query($thewu32_cLink, $query) or die("Unable to load gallery album in a combo box...".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					$toRet = "";
					$selected = "";
					while($row = mysqli_fetch_row($result)){
						$selected = (($FRM_var == $row[0]) ? (" SELECTED") : (""));
						$toRet .= "<option value=\"$row[0]\"$selected>$row[1]</option>";
					}
				}
				return $toRet;
			} */
			
			function admin_cmb_show_rub_by_lang($lang="FR", $FORM_var="", $CSS_class=""){
			    global $lang_output, $thewu32_cLink;
			    if($lang   !=  'XX')
			        $query 	=  "SELECT * FROM $this->tbl_galleryCat WHERE $this->fld_modLang ='$lang' ORDER BY $this->fld_galleryCatLib";
			        else
			            $query  =  "SELECT * FROM $this->tbl_galleryCat ORDER BY $this->fld_galleryCatLib";
			            
			            $result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load gallery categories.<br />".mysqli_connect_error());
			            if($total = mysqli_num_rows($result)){
			                $toRet = "";
			                //if($FORM_var	== )
			                while($row = mysqli_fetch_array($result)){
			                    $selected = ($FORM_var == $row[0])?("SELECTED"):("");
			                    $toRet .= "<option value=\"$row[0]\"$selected>$row[1] ($row[4])</option>";
			                }
			            }
			            else{
			                $toRet = "<option value=\"NULL\">".$lang_output['ADMIN_COMBO_NO_DATA']."</option>";
			            }
			            return $toRet;
			}
			
			/**
			 * Afficher les images avec le mm rendu que dans l'espace d'administration sans 
			 * les checkboxes et le bouton de suppression
			 * */
			function load_gallery(){
			    global $thewu32_cLink;
				$query = "SELECT * FROM $this->tbl_gallery WHERE display='1'";
				$result = mysqli_query($thewu32_cLink, $query) or die("Unable to load gallery...".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					$toRet = "";
					$selected = "";
					while($row = mysqli_fetch_row($result)){
						$album = $this->get_gallery_cat_by_id($row[2]);
						$toRet .= "<div class=\"pxGal_wrapper\">
									  <div class=\"pxGal_element\">
										<a style=\"border:0;\" href=\"#\" onclick=\"".$this->popup("pop_img.php", "600", "400")."\"><img class=\"pxGalImg\" src=\"$this->thumbs_dir$row[2]\" /></a>
									  </div>
									  <div class=\"pxGal_elementMenu\">
										<ul><li>$album</li></ul>
									  </div>
									  <div class=\"clear_both\"></div>
									</div>";
					}
					$toRet .= "<div class=\"clear_both\"></div>";
							   
				}
				return $toRet;
			}
			
			/**
			 * Load recent photo albums*/
			function load_last_gallery($number=5, $page_galleryCat='gallery_cat_read.php', $lang='FR', $css='gallery_recent', $start=0){
			    global $thewu32_cLink;
			    $query = "SELECT $this->fld_galleryCatId, $this->fld_galleryCatLib, $this->fld_galleryCatDate FROM $this->tbl_galleryCat WHERE display = '1' AND ($this->fld_galleryLang ='$lang' OR $this->fld_galleryLang = 'XX') ORDER BY $this->fld_galleryCatDate DESC LIMIT $start, $number";
			    $result = mysqli_query($thewu32_cLink, $query) or die("Unable to load recent photo albums!!<br />".mysqli_connect_error());
			    if($total = mysqli_num_rows($result)){
			        $toRet 	= ""; //"<ul>";
			        while($row = mysqli_fetch_array($result)){
			            $toRet	.= "<p class=\"$css\">
						   		     <a class=\"gallery_link\" href=\"".$this->set_mod_detail_uri_cat($page_galleryCat, $row[0])."\">".$row[1]."</a>
						  	       </p>";
			        }
			    }
			    else{
			        $toRet = "<p class=\"annonce_recent\">Aucune annonce &agrave; afficher!!</p>";
			    }
			    return $toRet; //."</ul>";
			}
			
			
			/**
			* @param : string $gallery_pageDest
			* @param : int $gallery_catUri
			* @param : int $galleryUri
			* @param : string $new_thumbsDir
			* @param : string $new_imgsDir
			* @descr : Afficher la galerie d'images
			* */
			function load_cmb_redir_gallery($gallery_pageDest, $gallery_catUri="0", $galleryUri = "0", $new_thumbsDir="gallery/thumbs/", $new_imgsDir="gallery/imgs/"){
				$this->set_thumbs_dir($new_thumbsDir);
				$this->set_imgs_dir($new_imgsDir);
				
				//Recuperer l'image par defaut au cas ou on ne trouve pas d'image
				$imgLib = ($this->get_gallery_by_id($galleryUri)== $this->imgDefault)?($this->imgDefault) : ($this->get_gallery_by_id($galleryUri));
				
				//Image choisie sinon, image par defaut
				$imgSrc = ($this->imgs_dir.$imgLib != $this->imgs_dir) ? ($this->imgs_dir.$imgLib) : ($this->imgs_dir.$this->imgDefault);
				$div_galleryTitle	= (($galleryUri == "") ? "" : "<div id=\"pxGal_CatTitle\">Album : ".utf8_decode($this->get_pix_gal_cat_by_id($gallery_catUri))."</div>");
				$div_galleryThumbs	= (($gallery_catUri == "") ? "" : "<div id=\"pxGal_thumbs\">".$this->get_thumbs($gallery_catUri)."</div>");
				$div_galleryDescr	= (($galleryUri == "") ? "" : "<div id=\"pxGal_descr\">".$this->get_gallery_descr_by_id($imgUri)."</div>");
							
				$toRet = "<div id=\"pxGal\">
							  <form>
							  <div id=\"pxGal_cat\">
								<select  name=\"jumpMenu\" id=\"jumpMenu\" onChange=\"MM_jumpMenu('parent',this,0)\">
									<option> Choisir la categorie</option>".$this->redir_combo_pix_gal_cat($gallery_pageDest, "gallery_catId")."</select></div>
							  </form>
							  <div class=\"clear_both\"></div>
							  $div_galleryTitle
								$div_galleryThumbs
								<div id=\"pxGal_main\"><img src=\"$imgSrc\" /></div> 
								$div_galleryDescr
							  <div class=\"clear_both\"></div>
						  </div>";
				return $toRet;
			}
			
			function load_random_gallery($pageDest="gallery.php", $title="Random pix", $css="gallery-image-random"){
				//Charger un tableau d'Ids
				$tab_galleryId = $this->load_conditionnalId($this->tbl_gallery, $this->fld_galleryId, 'display', '1');
				//Choisir l'id retenu de façon aleatoire
				$choosenId		= @array_rand(array_flip($tab_galleryId), 1);
				
				//La photo
				$choosenPix			= $this->get_gallery_by_id("gallery_lib", $choosenId);
				$choosenPixDescr 	= $this->get_gallery_descr_by_id($choosenId);
				//L'album
				$choosenAlbumId		= $this->get_gallery_cat_id_by_gallery_id($choosenId);
				$choosenAlbum		= $this->get_gallery_cat_lib_by_gallery_id($choosenId);
				
				//L'affichage du resultat final
				return $toRet = "<div class=\"inner_box\">
									<div class=\"title\">$title</div>
									<div class=\"content\">
										<div class=\"$css\">
											<a title=\"$choosenPixDescr\" href=\"".$this->set_mod_detail_uri_cat($pageDest, $choosenAlbumId)."\"><img style=\"width:225px;\" src=\"$this->imgs_dir"."$choosenPix\" /></a><p style=\"font-weight:bold; color:#fff; text-align:center\">$choosenAlbum</p>
										</div>
									</div>
								</div>";								
			}
			
			function arr_load_random_gallery($pageDest="gallery.php", $width="204"){
				//Charger un tableau d'Ids
				$tab_galleryId 		= 	$this->load_conditionnalId($this->tbl_gallery, $this->fld_galleryId, 'display', '1');
				//Choisir l'id retenu de façon aleatoire
				$choosenId			= 	@array_rand(array_flip($tab_galleryId), 1);
					
				//La photo
				$choosenPix			= 	$this->get_gallery_by_id("gallery_lib", $choosenId);
				$choosenPixDescr 	= 	$this->get_gallery_descr_by_id($choosenId);
				//L'album
				$choosenAlbumId		= 	$this->get_gallery_cat_id_by_gallery_id($choosenId);
				$choosenAlbum		= 	$this->get_gallery_cat_lib_by_gallery_id($choosenId);
				$choosenAlbumUrl	=	$this->set_mod_detail_uri_cat($pageDest, $choosenAlbumId);
			
				return $arr_toRet	=	array('PIX_ID'	=>	$choosenId, 'PIX_NAME' => $choosenPix, 'PIX_DESCR'	=>	$choosenPixDescr, 'PIX_ALBUM_ID' => $choosenAlbumId, 'PIX_ALBUM_TITLE' => $choosenAlbum, 'PIX_ALBUM_URL' => $choosenAlbumUrl);
			}
			
			function load_last_thumb_by_cat($pageDest="gallery_thumbs.php", $css="gallery_recents", $nbThumbs="1", $nbThumbsPerLine="6", $crtMax="20", $lang='EN'){
			/**
			* @param : int $nb_thumbs (Nombre d'imagettes a afficher)
			* @param : int nb_thumbPerLine (Nombre d'imagettes par ligne)
			* @param : int $crtMax (Nbre de caractere maximum à afficher pour la description)
			* @param : int $pageDest
			* @return : {Imagettes avec titre, description et image la plus recente de l'album}
			*
			* @descr : Afficher les albums les plus recents en mode graphique selon la langue en cours
			**/
				$tab_galleryCat		= array_slice($this->get_gallery_cat_id("WHERE lang_id='$lang' OR lang_id='XX'"), 0, $nbThumbs);
				$thumbsCount		= 0;
				
				//Fonction de comptage pour reinitialiser
				foreach($tab_galleryCat as $value){
					//Incrementation du compteur
					$thumbsCount++;
					//Preparation des parametres du passage a la ligne
					$break	= ((($thumbsCount % $nbThumbsPerLine) == 0) ? ("<div style=\"clear:both;\"></div>") : (""));
					
					$gallery_catTitle 	= $this->get_gallery_cat_by_id("gallery_cat_lib", $value);
					$gallery_catDescr	= $this->chapo($this->get_gallery_cat_by_id("gallery_cat_descr", $value), $crtMax);
					$gallery_catImg		= $this->get_last_gallery_lib_by_cat_id($value); //L'image la plus recente de l'album
					$gallery_catLnk		= ($gallery_catImg=="") ? ("#") : ($pageDest."-cat@".$value.".html"); //Lien = '#' si album vide
					$gallery_catImg		= ($gallery_catImg=="") ? ("nothumb.gif") : ($gallery_catImg); //Image par defaut, au cas ou
										
					$toRet .= "<div class=\"thumb_gallery_cat\">
									<div class=\"thumb_gallery_cat_title\"><a href=\"$gallery_catLnk\">$gallery_catTitle</a></div>
										<a href=\"$gallery_catLnk\">
											<img src=\"".$this->thumbs_dir."$gallery_catImg\" />
										</a>
									<div class=\"thumb_gallery_cat_descr\">
										<a style=\"font-weight:normal; text-decoration:none;\" href=\"$gallery_catLnk\">$gallery_catDescr</a>
									</div>	
								</div>";
				}
				return "<div class=\"$css\">$toRet<div class=\"clrBoth\"></div></div>";
			}
			
			function arr_load_last_thumb_by_cat($pageDest="gallery_thumbs.php", $crtMax="200"){
				/**
				 * @param : int $nb_thumbs (Nombre d'imagettes a afficher)
				 * @param : int nb_thumbPerLine (Nombre d'imagettes par ligne)
				 * @param : int $crtMax (Nbre de caractere maximum à afficher pour la description)
				 * @param : int $pageDest
				 * @return : {Imagettes avec titre, description et image la plus recente de l'album}
				 *
				 * @descr : Afficher les albums lesplus recents en mode graphique
				 **/
				$tab_galleryCat	= array_slice($this->get_gallery_cat_id(), 0, $nbThumbs);
				$thumbsCount		= 0;
			
				$arr_toRet 	=	array();
					
				//Fonction de comptage pour reinitialiser
				foreach($tab_galleryCat as $value){
					//Incrementation du compteur
					$thumbsCount++;
					//Preparation des parametres du passage a la ligne
					//$break	= ((($thumbsCount % $nbThumbsPerLine) == 0) ? ("<div style=\"clear:both;\"></div>") : (""));
			
					$gallery_catTitle 	= $this->get_gallery_cat_by_id("gallery_cat_lib", $value);
					$gallery_catDescr	= $this->chapo($this->get_gallery_cat_by_id("gallery_cat_descr", $value), $crtMax);
					$gallery_catImg		= $this->get_last_gallery_lib_by_cat_id($value); //L'image la plus recente de l'album
					$gallery_catLnk		= ($gallery_catImg=="") ? ("#") : ($pageDest.'-cat@'.$value.".html"); //Lien = '#' si album vide
					$gallery_catImg		= ($gallery_catImg=="") ? ("nothumb.jpg") : ($gallery_catImg); //Image par defaut, au cas ou
						
					array_push($arr_toRet, array('GALLERY_CAT_TITLE' => $gallery_catTitle, 'GALLERY_CAT_DESCR' => $gallery_catDescr, 'GALLERY_CAT_IMG' => $gallery_catImg, 'GALLERY_CAT_URL' => $gallery_catLnk));
				}
				return $arr_toRet;
			}
			
			function load_thumbs($gallery_pageDetail="gallery_detail.php", $new_galleryCatId, $nb_thumbPerLine="6", $css="gallery_thumbs", $errMsg="Aucune image &agrave; afficher...", $rel=""){
			/**
			* @param : int $new_galleryCatId (ID de l'album)
			* @param : int $nb_thumbPerLine (nombre d'imagette par ligne)
			* @param : string $css (La classe CSS a utiliser pour l'affichage)
			* @param : string $gallery_pageDetail (Page d'affichage des image au grand format)
			* @param : string $errMsg (Message d'erreur par defaut)
			* @return : {thumbs}
			*
			* @descr : Afficher les imagettes d'une categorie definie
			*/	
				//1 - On charge les id des images de la categorie $new_galleryCatId
				$tab_galleryId 	= 	$this->get_gallery_id_by_cat($new_galleryCatId);
				//Initialisation du compteur pour le controle du nombre d'imagettes par ligne
				$nbThumb		= 0;
				
				if(is_array($tab_galleryId)){
					$thumbs = "<div class=\"$css\">";
					foreach($tab_galleryId as $value){
						//Incrementation du compteur
						$nbThumb++;
						
						//Preparation des parametres du passage a la ligne
						$break	= ((($nbThumb % $nb_thumbPerLine) == 0) ? ("<div style=\"clear:both;\"></div>") : (""));
						
						//Identification des images concernees
						$thumbLib 	= ($this->get_gallery_by_id("gallery_lib", $value) != "") ? ($this->get_gallery_by_id("gallery_lib", $value)) : ($this->thumbDefault);
						
						//Identification de la description de l'image
						$thumbDescr	= ($this->get_gallery_by_id("gallery_descr", $value) != "") ? ($this->get_gallery_by_id("gallery_descr", $value)) : ($errMsg);
						
						$thumbSrc 	= $this->thumbs_dir.$thumbLib;
						$mainSrc	= $this->imgs_dir.$thumbLib;
						
						//$thumbs 	.= "<div class=\"item\"><a title=\"$thumbDescr\" href=\"$gallery_pageDetail&view=galleryDetail&".$this->URI_galleryVar."=$value&".$this->URI_galleryCatVar."=".$_GET[$this->URI_galleryCatVar]."#$value\"><img src =\"$thumbSrc\" /></a></div>$break";
						if ($rel == "") { $thumbs 	.= "<div class=\"item\"><a title=\"$thumbDescr\" class=\"lightbox\" href=\"$mainSrc\"><img src =\"$thumbSrc\" /></a></div>"; }
						elseif ($rel == "lightbox") { $thumbs 	.= "<div class=\"item\"><a title=\"$thumbDescr\" rel=\"$rel\" href=\"$mainSrc\"><img src =\"$thumbSrc\" /></a></div>"; }
						elseif ($rel == "roadtrip") { $thumbs 	.= "<div class=\"item\"><a title=\"$thumbDescr\" rel=\"lightbox[roadtrip]\" href=\"$mainSrc\"><img src =\"$thumbSrc\" /></a></div>"; }
						
					}	
					return $thumbs."<div style=\"clear:both;\"></div></div>";
				}				
				else{
					//return $thumbs = "<div class=\"$css\"><div class=\"item\"><a title=\"$thumbDescr\" href=\"$gallery_pageDetail&view=galleryDetail&".$this->URI_galleryVar."=$value&".$this->URI_galleryCatVar."=".$_GET[$this->URI_galleryCatVar]."#$value\"><img src =\"".$this->thumbs_dir.$this->thumbDefault."\" /></a></div><div style=\"clear:both;\"></div></div>";
					return $thumbs = "<div class=\"$css\"><div class=\"item\"><a rel=\"$rel\" title=\"$thumbDescr\" href=\"$gallery_pageDetail"."-"."galleryDetail"."-".$value."-"."#$value\"><img src =\"".$this->thumbs_dir.$this->thumbDefault."\" /></a></div><div style=\"clear:both;\"></div></div>";
				}
			}
			
			function arr_load_gallery_by_cat($gallery_pageDetail="gallery_detail.php", $new_galleryCatId){
				/**
				 * @param : int $new_galleryCatId (ID de l'album)
				 * @param : int $nb_thumbPerLine (nombre d'imagette par ligne)
				 * @param : string $css (La classe CSS a utiliser pour l'affichage)
				 * @param : string $gallery_pageDetail (Page d'affichage des image au grand format)
				 * @param : string $errMsg (Message d'erreur par defaut)
				 * @return : {thumbs}
				 *
				 * @descr : Afficher les imagettes d'une categorie definie
				 */
				//1 - On charge les id des images de la categorie $new_galleryCatId
				$tab_galleryId 	= 	$this->get_gallery_id_by_cat($new_galleryCatId);
				//Initialisation du compteur pour le controle du nombre d'imagettes par ligne
				$nbThumb		= 0;
				$arr_toRet 		=	array();
					
				if(is_array($tab_galleryId)){
					$thumbs = "<div class=\"$css\">";
					foreach($tab_galleryId as $value){
						//Incrementation du compteur
						$nbThumb++;
							
			
							
						//Identification des images concernees
						$thumbLib 	= ($this->get_gallery_by_id("gallery_lib", $value) != "") ? ($this->get_gallery_by_id("gallery_lib", $value)) : ($this->thumbDefault);
						$thumbTitle = $this->get_gallery_by_id('gallery_title', $value);
						$date 		= $this->get_gallery_by_id('gallery_date', $value);
						//Identification de la description de l'image
						$thumbDescr	= ($this->get_gallery_by_id("gallery_descr", $value) != "") ? ($this->get_gallery_by_id("gallery_descr", $value)) : ($errMsg);
							
						$thumbSrc 	= $this->thumbs_dir.$thumbLib;
						$mainSrc	= $this->imgs_dir.$thumbLib;
							
						//$thumbs 	.= "<div class=\"item\"><a title=\"$thumbDescr\" href=\"$gallery_pageDetail&view=galleryDetail&".$this->URI_galleryVar."=$value&".$this->URI_galleryCatVar."=".$_GET[$this->URI_galleryCatVar]."#$value\"><img src =\"$thumbSrc\" /></a></div>$break";
						/*if ($rel == "") { $thumbs 	.= "<div class=\"item\"><a rel=\"$rel\" title=\"$thumbDescr\" href=\"$gallery_pageDetail"."-"."galleryDetail"."-".$value."-".$_GET[$this->URI_galleryCatVar].".html#$value\"><img src =\"$thumbSrc\" /></a></div>$break"; }
						 elseif ($rel == "lightbox") { $thumbs 	.= "<div class=\"item\"><a rel=\"$rel\" title=\"$thumbDescr\" href=\"$mainSrc\"><img src =\"$thumbSrc\" /></a></div>$break"; }
						 elseif ($rel == "roadtrip") { $thumbs 	.= "<div class=\"item\"><a rel=\"lightbox[roadtrip]\" title=\"$thumbDescr\" href=\"$mainSrc\"><img src =\"$thumbSrc\" /></a></div>$break"; } */
							
						array_push($arr_toRet, array('THUMB_ID' => $value, 'THUMB_NAME' => $thumbLib, 'THUMB_TITLE' => $thumbTitle, 'THUMB_DESCR' => $thumbDescr, 'THUMB_URL' => $thumbSrc, 'PIX_URL' => $mainSrc, 'PIX_DATE' => $date));
					}
					return $arr_toRet;
				}
				else{
					//return $thumbs = "<div class=\"$css\"><div class=\"item\"><a title=\"$thumbDescr\" href=\"$gallery_pageDetail&view=galleryDetail&".$this->URI_galleryVar."=$value&".$this->URI_galleryCatVar."=".$_GET[$this->URI_galleryCatVar]."#$value\"><img src =\"".$this->thumbs_dir.$this->thumbDefault."\" /></a></div><div style=\"clear:both;\"></div></div>";
					//return $thumbs = "<div class=\"$css\"><div class=\"item\"><a rel=\"$rel\" title=\"$thumbDescr\" href=\"$gallery_pageDetail"."-"."galleryDetail"."-".$value."-"."#$value\"><img src =\"".$this->thumbs_dir.$this->thumbDefault."\" /></a></div><div style=\"clear:both;\"></div></div>";
					return false;
				}
			}
			
			/*function load_gallery_cat($pageDest="gallery_cat_display.php", $nb='3', $css="gallery_cat_list"){
			//$tabId = $this->load_id_where_limit($this->imgCatTbl, $this->fld_imgCatId, "WHERE 1", 0, 2);
			//$tabId	= $this->loa
				//*$tabId = array_reverse($this->load_galCatId());
				$tabId = array_reverse($this->get_gallery_cat_id());
				$count = 0;
				$toRet = "<div class=\"address\"><ul class=\"$css\">";
				foreach($tabId as $value){
					$count++;
					//$catLib	= $this->get_pix_gal_cat_by_id($value);
					$catLib	= $this->get_gallery_cat_by_id($this->fld_galleryCatLib, $value);
					$nbPix	= $this->count_pix_per_album($value);
					$catLnk	= ($nbPix == 0) ? ("#") : ($pageDest."-cat@".$value.".html");
					
					$toRet .="<li><a href=\"$catLnk\">$catLib</a>&nbsp;($nbPix)</li>";
					if($nb <= $count)
						break;
				}
				return $toRet."</ul></div>";
			}*/
			
			
		function load_gallery_cat($pageDest="galley.php", $errMsg="", $imgIcon="", $lang){
		    global $thewu32_cLink;
			$query 	= "SELECT * FROM $this->tbl_galleryCat WHERE lang_id = '$lang' or lang_id = 'XX' ORDER BY gallery_cat_lib";
			$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load gallery cat.<br />".mysqli_connect_error());
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
		}
			
			
			//Charger les albums
			function arr_load_gallery($pageDest="gallery_cat_display.php", $nb='3', $css="gallery_cat_list"){
				//$tabId = $this->load_id_where_limit($this->imgCatTbl, $this->fld_imgCatId, "WHERE 1", 0, 2);
				//$tabId	= $this->loa
				//*$tabId = array_reverse($this->load_galCatId());
				$tabId = array_reverse($this->get_gallery_cat_id());
				$count = 0;
				$arr_toRet	=	array();
				foreach($tabId as $value){
					$count++;
					//$catLib	= $this->get_pix_gal_cat_by_id($value);
					$catLib	= $this->get_gallery_cat_by_id($this->fld_galleryCatLib, $value);
					$nbPix	= $this->count_pix_per_album($value);
					$catLnk	= ($nbPix == 0) ? ("#") : ($this->set_mod_detail_uri_cat($pageDest, $value));
			
					array_push($arr_toRet, array('ALBUM_ID' => $value, 'ALBUM_TITLE' => $catLib, 'ALBUM_LINK' => $catLnk, 'ALBUM_NB_PIX' => $nbPix));
						
					if($nb <= $count)
						break;
				}
				return $arr_toRet;
			}
				
			function arr_load_gallery_cat($pageDest='gallery.php', $lang){
			    global $thewu32_cLink;
				$query 	= "SELECT * FROM $this->tbl_galleryCat WHERE lang_id = '$lang' OR lang_id = 'XX' ORDER BY $this->fld_galleryCatDate";
				$result	= mysqli_query($thewu32_cLink, $query) or die("Unable to load galleries.<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					$arr_toRet 	= 	array();
					$id 		= 	$this->fld_galleryCatId;
					$title		=	$this->fld_galleryCatLib;
					$lang		=	$this->fld_langId;
					while($row = mysqli_fetch_array($result)){
						//$toRet .= "<li><a href=\"$pageDest"."&".$this->URI_annonceCat."=".$row[0]."\">$row[1]</a></li>";
						$totalCat	=	$this->count_in_tbl_where1($this->tbl_gallery, $this->fld_galleryId, $this->fld_galleryCatId, $row[$id]);
						$catUrl		=	($totalCat != 0) ? ($this->set_mod_detail_uri_cat($pageDest, $row[0])) : ('#');
						array_push($arr_toRet, array('GALLERY_CAT_ID'=>$row[$id], 'GALLERY_CAT_TITLE'=>$row[$title], 'GALLERY_CAT_NB'=>$totalCat, 'GALLERY_CAT_URL'=>$catUrl));
					}
				}
				else{
					$arr_toRet	=	false;
				}
				return $arr_toRet;
			}
			
			/**
			 * Charger les titres des albums dans un box
			 * @param int $nb, le nombre d'albums à afficher
			 * */
			function load_gallery_cat_box($albumPage, $nb='3'){
				$tabId = array_reverse($this->get_gallery_cat_id());
				$count = 0;
				$toRet = "<ul>";
				foreach($tabId as $value){
					$count++;
					$catLib	= $this->get_gallery_cat_by_id($value);
					$toRet .="<li><a href=\"$albumPage&catId=$value\">$catLib</a></li>";
					if($nb <= $count)
						break;
				}
				return $toRet."</ul>";
			}
			
			function load_lilThumbs($catUri, $page_detail="gallery_display_photo.php"){
			    global $thewu32_cLink;
			//$thumbsTab = $this->load_thumbs_id_by_cat($catUri);
				$thumbsTab = $this->get_thumbs_id_by_cat($catUri);
				if(is_array($thumbsTab)){
					$thumbs = "";
					foreach($thumbsTab as $value){
						$thumbLib 	= ($this->get_thumbs_by_id($value) != "") ? ($this->get_thumbs_by_id($value)) : ($this->imgDefault);
						$thumbDescr	= ($this->get_thumbs_by_id($value) != "") ? ($this->get_img_descr_by_id($value)) : ("Aucune image &agrave; afficher...");
						$thumbSrc 	= $this->thumbs_dir.$thumbLib;
						$thumbs 	.= "<a title=\"$thumbDescr\" href=\"$page_detail?what=pixDisplay&pId=$value&catId=".$_GET[catId]."#$value\"><img class=\"pxGal_lilThumbs\" src =\"$thumbSrc\" /></a>";
					}	
					return $thumbs;
				}
				
				else
					return $thumbs = "<img src =\"".$this->thumbs_dir.$this->imgDefault."\" />";
			}
			
			function load_valid_gallery_comment($new_galleryId, $dir="ASC", $default="Aucun commentaire pour l'instant."){
			    global $thewu32_cLink;
			//Afficher les r&eacute;actions aux articles, quand il y en a
				$query = "SELECT * FROM $this->tbl_galleryComment WHERE $this->fld_galleryId = '$new_galleryId' AND display='1' ORDER BY $this->fld_galleryCommentId $dir";
				$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger les commentaires !!<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					$toRet = "<div class=\"gallery_comment\">";
					while($row = mysqli_fetch_array($result)){
						$react_id 		= 	$row[0];
						$react_artId 	= 	$row[1];
						$react_date 	= 	$row[2];
						$usr_name 		= 	$row[3];
						$react_email	= 	$row[4];;
						$react_content 	= 	$row[5];
						$toRet .= "<div class=\"comment_container\">
									  <div class=\"comment_container_head\">
										<strong>De :</strong> $usr_name [ <em>$react_email</em> ]<br />
										<strong>Post&eacute; le :</strong> ".$this->datetime_fr3($react_date)."
									  </div>
									  <div class=\"react_container_body\">".nl2br($react_content)."</div>
								   </div>";
					}
					$toRet .= "</div>";
				}
				else{
					$toRet = "<div class=\"gallery_no_comment\">$default</div>";
				}
				return $toRet;
			}
			
			function load_valid_member_gallery_comment($new_galleryId, $dir="ASC", $default="Aucun commentaire pour l'instant."){
				$usr = new cwd_usr();
				//Afficher les r&eacute;actions aux articles par les membres, quand il y en a
				$query = "SELECT * FROM $this->tbl_galleryComment WHERE $this->fld_imgId = '$new_galleryId' AND display='1' ORDER BY $this->fld_newsReactId $dir";
				$result = mysqli_query($thewu32_cLink, $query) or die("Impossible de charger les comentaires !!<br />".mysqli_connect_error());
				if($total = mysqli_num_rows($result)){
					$toRet = "<div class=\"react\">";
					while($row = mysqli_fetch_array($result)){
						$react_id 		= 	$row[0];
						$react_artId 	= 	$row[1];
						$react_date 	= 	$row[2];
						$usr_id 		= 	$row[3];
						$react_firstName= $usr->get_user_detail_by_usr_id("usr_detail_first", $usr_id);
						$react_lastName	= $usr->get_user_detail_by_usr_id("usr_detail_last", $usr_id);
						$react_email	= $usr->get_user_detail_by_usr_id("usr_detail_email", $usr_id);
						$react_content 	= 	$row[5];
						$toRet .= "<div class=\"react_container\">
									  <div class=\"react_container_head\">
										<strong>De :</strong> $react_firstName $react_lastName [ <em>$react_email</em> ]<br />
										<strong>Post&eacute; le :</strong> ".$this->datetime_fr2($react_date)."
									  </div>
									  <div class=\"react_container_body\">".nl2br($react_content)."</div>
								   </div>";
					}
					$toRet .= "</div>";
				}
				else{
					$toRet = "<div class=\"react_no_comment\">$default</div>";
				}
				return $toRet;
			}
			
			function load_gallery_nav($newGId="1", $newGCId="1", $pageDest="gallery_detail.php"){
			/**
			* @param : 	string ^pageDest (Page de destination)
			* @param :	int $newGId (Id de l'image)
			* @param :	int $newGCId (Id de l'album)
			* @return :	{gallery nav menu}
			*
			* @descr : 	Afficher le menu de navigation dans l'album photo
			**/
				//Charger les id des images d'un meme album dans un tableau, 
				$tabGalleryIdByCat_i	= $this->get_gallery_id_by_cat($newGCId);
				//On renverse cles/valeurs
				$tabGalleryIdByCat_f	= array_flip($tabGalleryIdByCat_i);
				//On compte le nombre d'item dans le tableau (les deux en ont le même nombre)
				$nbItem	= count($tabGalleryIdByCat_i);
				//On identifie la cle courante
				$current_key 			= $tabGalleryIdByCat_f[$newGId];
				//Sachant la cle courante, on peut savoir les cles suivante et precedente
				$next_key		= ($current_key + 1);
				$prev_key		= ($current_key - 1);
				
				//Pour les liens:
				$current		= $tabGalleryIdByCat_i[$current_key];
				$next			= ((in_array($tabGalleryIdByCat_i[$next_key], $tabGalleryIdByCat_i)) ? ($tabGalleryIdByCat_i[$next_key]): ($tabGalleryIdByCat_i[0]));
				$prev			= ((in_array($tabGalleryIdByCat_i[$prev_key], $tabGalleryIdByCat_i)) ? ($tabGalleryIdByCat_i[$prev_key]): ($tabGalleryIdByCat_i[$nbItem - 1])); 
				$first			= $tabGalleryIdByCat_i[0];
				$last			= $tabGalleryIdByCat_i[$nbItem - 1];
			   /*-------------------------------------------------------------------------------------------------------------
				--------------------------------------------------------------------------------------------------------------*/
				/*$lnkNext 		= "<a href=\"$pageDest&view=galleryDetail&$this->URI_galleryVar=$next&$this->URI_galleryCatVar=$newGCId#$next\">Next</a>";
				$lnkPrevious 	= "<a href=\"$pageDest&view=galleryDetail&$this->URI_galleryVar=$prev&$this->URI_galleryCatVar=$newGCId#$prev\">Previous</a>";
				$lnkFirst		= "<a href=\"$pageDest&view=galleryDetail&$this->URI_galleryVar=$first&$this->URI_galleryCatVar=$newGCId#$first\">First</a>";
				$lnkLast		= "<a href=\"$pageDest&view=galleryDetail&$this->URI_galleryVar=$last&$this->URI_galleryCatVar=$newGCId#$last\">Last</a>";*/
				
				$lnkNext 		= "<a href=\"".$pageDest."-"."detail"."-".$next.".html#".$next."\">Next</a>";
				$lnkPrevious 	= "<a href=\"".$pageDest."-"."detail"."-".$prev.".html#".$prev."\">Previous</a>";
				$lnkFirst		= "<a href=\"".$pageDest."-"."detail"."-".$first.".html#".$first."\">First</a>";
				$lnkLast		= "<a href=\"".$pageDest."-"."detail"."-".$last.".html#".$last."\">Last</a>";
				
				$toRet			= "<p>$lnkFirst | $lnkPrevious | $lnkNext | $lnkLast</p>";
				return $toRet;
			}
		/* :::::::: ---- LOADERS End ---- :::::::: */	
		
		
			 /****************************************/	
			/* :::::::: All the switchers ::::::::  */
		   /****************************************/	
			function switch_gallery_state($pixId, $displayVal){
			//Publier / Masquer une image de la galerie
				return $toRet = $this->set_connected($this->tbl_gallery, "display", $this->fld_galleryId, $pixId, $displayVal);
			}
			function switch_gallery_comment_state($new_galleryId, $new_stateId){
			/**
			* @param : 	string $new_galleryId
			* @param : 	string $new_stateId
			* @return : true or false
			*
			* @descr : 	Rendre public/prive un comentaire sur image
			*/
				return $this->set_updated_1($this->tbl_galleryComment, "display", $new_stateId, $this->fld_galleryCommentId, $new_galleryId);
			}
		/* :::::::: ---- Switchers End ---- :::::::: */	
		
		
			 /****************************************/	
			/* :::::::: All the updaters ::::::::   */
		   /****************************************/	
			function update_gallery($new_galleryId, $new_galleryCatId, $new_galleryLib, $new_galleryDescr, $new_galleryTitle, $new_galleryDate, $new_galleryLang, $new_galleryPublishVal){
			/**
		 	* @param : 	int $new_galleryId, 
		 	* @param : 	int $new_galleryCatId,
		 	* @param : 	string $new_galleryLib,
		 	* @param : 	string $new_galleryDescr,
		 	* @param : 	string $new_galleryTitle,
		 	* @param : 	int $new_galleryPublishVal
		 	* @return :	true or false
			*
			* @descr : 	Mettre &agrave; jour la photo dans la gallerie
			* */
			    global $thewu32_cLink;
				$query = "UPDATE $this->tbl_gallery SET $this->fld_galleryCatId = '$new_galleryCatId',
												   		gallery_lib		   	= '$new_galleryLib',
												   		gallery_descr		= '$new_galleryDescr',
												   		gallery_title		= '$new_galleryTitle',
												   		gallery_date		= '$new_galleryDate',
                                                        $this->fld_modLang  =   '$new_galleryLang',
												   		display				= '$new_galleryPublishVal'
						 WHERE $this->fld_galleryId	= '$new_galleryId'";
				if($result = mysqli_query($thewu32_cLink, $query) or die("Unable to update pix gallery.<br />".mysqli_connect_error()))
					return true;
				else
					return false;
			}
			
			/**
			* @param: int $new_galleryCatId
			* @param: string $new_galleryCatLib
			* @return true or false
			*
			* Mettre &agrave; jour l'album photo
			* */
			function update_gallery_cat($new_galleryCatId, $new_galleryCatLib, $new_galleryCatDescr, $new_galleryCatDate){
			    global $thewu32_cLink;
				$query = "UPDATE $this->tbl_galleryCat SET gallery_cat_lib 		= '$new_galleryCatLib',
												   		   gallery_cat_descr 	= '$new_galleryCatDescr',
												   		   gallery_cat_date	 	= '$new_galleryCatDate'
						 WHERE $this->fld_galleryCatId	= '$new_galleryCatId'";
				$result = mysqli_query($thewu32_cLink, $query) or die("Unable to update picture gallery album.<br />".mysqli_connect_error());
				if($result)
					return true;//if($this->update_entry_cat($this->imgCatTbl, $this->fld_imgCatId, "pix_gal_cat_lib", $new_galleryCatLib, $new_galleryCatId))
				else
					return false;
			}
		
		/* :::::::: ---- Updaters End ---- :::::::: */	

		
		
		
		
		function redir_combo_pix_gal_cat($page_redirect, $redir_key="query"){
			return $this->redir_combo_sel_row($this->imgCatTbl, $this->fld_imgCatId, "pix_gal_cat_lib", $page_redirect, $redir_key);
		}
		
		
		
		
		
		
		function img_create($w, $h, $color="DBFECB", $type="png"){
			$type = strtolower($type);
			switch ($type){
				case "png" : header("Content-type: image/png");
							 $image = imagecreatetruecolor($w, $h);
							 $r 	= hexdec(substr($color, 0, 2));
							 $g 	= hexdec(substr($color, 2, 4));
							 $b 	= hexdec(substr($color, 4, 6));
							 //allouer une couleur ï¿½ l'image vide ï¿½ cr&eacute;er;
							$couleur = imagecolorallocate($image, $r, $g, $b);
							//on remplit l'image
							imagefill($image,0,0,$couleur);
							//Cr&eacute;er l'image ï¿½ pr&eacute;sent
							$toRet = imagepng($image);
				break;
				
				case "jpg" : header("Content-type: image/jpeg");
							 $image = imagecreatetruecolor($w, $h);
							 $r 	= hexdec(substr($color, 0, 2));
							 $g 	= hexdec(substr($color, 2, 4));
							 $b 	= hexdec(substr($color, 4, 6));
							 //allouer une couleur ï¿½ l'image vide ï¿½ cr&eacute;er;
							$couleur = imagecolorallocate($image, $r, $g, $b);
							//on remplit l'image
							imagefill($image,0,0,$couleur);
							//Cr&eacute;er l'image ï¿½ pr&eacute;sent
							$toRet = imagejpeg($image);
				break;
				
				case "jpeg" : header("Content-type: image/jpeg");
							 $image = imagecreatetruecolor($w, $h);
							 $r 	= hexdec(substr($color, 0, 2));
							 $g 	= hexdec(substr($color, 2, 4));
							 $b 	= hexdec(substr($color, 4, 6));
							 //allouer une couleur ï¿½ l'image vide ï¿½ cr&eacute;er;
							$couleur = imagecolorallocate($image, $r, $g, $b);
							//on remplit l'image
							imagefill($image,0,0,$couleur);
							//Cr&eacute;er l'image ï¿½ pr&eacute;sent
							$toRet = imagejpeg($image);
				break;
				
				case "gif" : header("Content-type: image/gif");
							 $image = imagecreatetruecolor($w, $h);
							 $r 	= hexdec(substr($color, 0, 2));
							 $g 	= hexdec(substr($color, 2, 4));
							 $b 	= hexdec(substr($color, 4, 6));
							 //allouer une couleur ï¿½ l'image vide ï¿½ cr&eacute;er;
							$couleur = imagecolorallocate($image, $r, $g, $b);
							//on remplit l'image
							imagefill($image,0,0,$couleur);
							//Cr&eacute;er l'image ï¿½ pr&eacute;sent
							$toRet = imagegif($image);
				break;
				
				default	   : $image = imagecreatetruecolor($w, $h);
							 $r 	= hexdec(substr($color, 0, 2));
							 $g 	= hexdec(substr($color, 2, 4));
							 $b 	= hexdec(substr($color, 4, 6));
							 //allouer une couleur ï¿½ l'image vide ï¿½ cr&eacute;er;
							$couleur = imagecolorallocate($image, $r, $g, $b);
							//on remplit l'image
							imagefill($image,0,0,$couleur);
							//Cr&eacute;er l'image ï¿½ pr&eacute;sent
							$toRet = imagepng($image);					 
			}
			return $toRet;
			imagedestroy($image);
		}
		
		function img_write($w, $h, $coodX, $coordY, $txt, $font=10, $color="DBFECB", $type="png"){
			$type = strtolower($type);
			switch ($type){
				case "png" : header("Content-type: image/png");
							 $image = imagecreatetruecolor($w, $h);
							 $r 	= hexdec(substr($color, 0, 2));
							 $g 	= hexdec(substr($color, 2, 4));
							 $b 	= hexdec(substr($color, 4, 6));
							 //allouer une couleur ï¿½ l'image vide ï¿½ cr&eacute;er;
							$couleur = imagecolorallocate($image, $r, $g, $b);
							//on remplit l'image
							//imagefill($image,0,0,$couleur);
							//on &eacute;crit horizontalement
							imagestring($image, $font, $coodX, $coordY, $txt, $couleur);
							
							/*Ecrire verticalement************************************************************
							imagestringup($image, $font, 65, 10, "horizontal", $couleur);
							********************************************************************************/
							
							//Cr&eacute;er l'image ï¿½ pr&eacute;sent
							$toRet = imagepng($image);
				break;
				
				case "jpg" : header("Content-type: image/jpeg");
							 $image = imagecreatetruecolor($w, $h);
							 $r 	= hexdec(substr($color, 0, 2));
							 $g 	= hexdec(substr($color, 2, 4));
							 $b 	= hexdec(substr($color, 4, 6));
							 //allouer une couleur ï¿½ l'image vide ï¿½ cr&eacute;er;
							$couleur = imagecolorallocate($image, $r, $g, $b);
							//on remplit l'image
							imagefill($image,0,0,$couleur);
							//on &eacute;crit horizontalement
							imagestring($image, $font, $coodX, $coordY, $txt, $couleur);
							
							/*Ecrire verticalement************************************************************
							imagestringup($image, $font, 65, 10, "horizontal", $couleur);
							********************************************************************************/
							
							//Cr&eacute;er l'image ï¿½ pr&eacute;sent
							$toRet = imagejpeg($image);
				break;
				
				case "jpeg" : header("Content-type: image/jpeg");
							 $image = imagecreatetruecolor($w, $h);
							 $r 	= hexdec(substr($color, 0, 2));
							 $g 	= hexdec(substr($color, 2, 4));
							 $b 	= hexdec(substr($color, 4, 6));
							 //allouer une couleur ï¿½ l'image vide ï¿½ cr&eacute;er;
							$couleur = imagecolorallocate($image, $r, $g, $b);
							//on remplit l'image
							imagefill($image,0,0,$couleur);
							//on &eacute;crit horizontalement
							imagestring($image, $font, $coodX, $coordY, $txt, $couleur);
							
							/*Ecrire verticalement************************************************************
							imagestringup($image, $font, 65, 10, "horizontal", $couleur);
							********************************************************************************/
							
							//Cr&eacute;er l'image ï¿½ pr&eacute;sent
							$toRet = imagejpeg($image);
				break;
				
				case "gif" : header("Content-type: image/gif");
							 $image = imagecreatetruecolor($w, $h);
							 $r 	= hexdec(substr($color, 0, 2));
							 $g 	= hexdec(substr($color, 2, 4));
							 $b 	= hexdec(substr($color, 4, 6));
							 //allouer une couleur ï¿½ l'image vide ï¿½ cr&eacute;er;
							$couleur = imagecolorallocate($image, $r, $g, $b);
							//on remplit l'image
							imagefill($image,0,0,$couleur);
							//on &eacute;crit horizontalement
							imagestring($image, $font, $coodX, $coordY, $txt, $couleur);
							
							/*Ecrire verticalement************************************************************
							imagestringup($image, $font, 65, 10, "horizontal", $couleur);
							********************************************************************************/
							
							//Cr&eacute;er l'image ï¿½ pr&eacute;sent
							$toRet = imagegif($image);
				break;
				
				default	   : $image = imagecreatetruecolor($w, $h);
							 $r 	= hexdec(substr($color, 0, 2));
							 $g 	= hexdec(substr($color, 2, 4));
							 $b 	= hexdec(substr($color, 4, 6));
							 //allouer une couleur ï¿½ l'image vide ï¿½ cr&eacute;er;
							$couleur = imagecolorallocate($image, $r, $g, $b);
							//on remplit l'image
							imagefill($image,0,0,$couleur);
							//on &eacute;crit horizontalement
							imagestring($image, $font, $coodX, $coordY, $txt, $couleur);
							
							/*Ecrire verticalement************************************************************
							imagestringup($image, $font, 65, 10, "horizontal", $couleur);
							********************************************************************************/
							
							//Cr&eacute;er l'image ï¿½ pr&eacute;sent
							$toRet = imagepng($image);					 
			}
			return $toRet;
			imagedestroy($image);
		}
		
		
		function create_thumbs($file_name, $ratio){
		/**
		 * Creer des imagettes pour la galerie d'images
		 * 
		 * @param string file_name
		 * @param int ratio : largeur de l'imagette
		 * */
		 
			//Chemins complets des images et imagettes
			$file_orig	= $this->imgs_dir.$file_name;
			$file_dest 	= $this->thumbs_dir.$file_name;
			
			list($largeur, $hauteur) = getimagesize($file_orig); //dimensions de l'image originale
			$ratio = $ratio / $largeur; //ratio pour r&eacute;duire a une taille voulue
			
			/*Nouvelles dimensions a appliquer*/
			$n_image_largeur = $largeur * $ratio; //largeur de l'image r&eacute;duite
			$n_image_hauteur = $hauteur * $ratio; //hauteur de l'image r&eacute;duite
			
			$destination 	= imagecreatetruecolor($n_image_largeur, $n_image_hauteur);
			$pixExt			= $this->get_file_ext($file_name);
			
			//Definir le tableau des extensions possibles
			$tab_pixExt = array("jpg", "jpeg", "gif", "png");
			
			if(in_array($pixExt, $tab_pixExt)){
				switch($pixExt){
					case "jpeg" :	$source = imagecreatefromjpeg($file_orig);
									imagecopyresampled($destination, $source, 0,0, 0,0, $n_image_largeur , $n_image_hauteur , $largeur, $hauteur);		
									imagejpeg($destination, $file_dest);
									imagedestroy($source);
					break;
					
					case "jpg" :	$source = imagecreatefromjpeg($file_orig);
									imagecopyresampled($destination, $source, 0,0, 0,0, $n_image_largeur , $n_image_hauteur , $largeur, $hauteur);		
									imagejpeg($destination, $file_dest);
									imagedestroy($source);
					break;
					
					case "png" :	$source = imagecreatefrompng($file_orig);
									imagecopyresampled($destination, $source, 0,0, 0,0, $n_image_largeur , $n_image_hauteur , $largeur, $hauteur);		
									imagepng($destination, $file_dest);
									imagedestroy($source);
					break;
					
					case "gif" :	$source = imagecreatefromgif($file_orig);
									imagecopyresampled($destination, $source, 0,0, 0,0, $n_image_largeur , $n_image_hauteur , $largeur, $hauteur);		
									imagegif($destination, $file_dest);
									imagedestroy($source);
					break;
				}
			}
			else
				return false;
		}
		
		
		function create_thumbs_2($image, $hauteur_max="100", $largeur_max="130"){
			// on défini le répertoire qui contient nos images de grande taille   
			$dir = $this->thumbs_dir;
			// on récupère les infos de cette image  
			$tableau = @getimagesize($this->thumbs_dir.$image);  
			// si il ne s'agit pas d'un fichier image, on redirige le visiteur vers l'accueil de la galerie  
				// si notre image est de type jpeg  
			if ($tableau[2] == 2) {  
				// on crée une image à partir de notre grande image à l'aide de la librairie GD  
				$src = imagecreatefromjpeg($dir.'/'.$image);  
					// on teste si notre image est de type paysage ou portrait  
				if ($tableau[0] > $tableau[1]) {  
					$im = imagecreatetruecolor(round(($hauteur_max/$tableau[1])*$tableau[0]), $hauteur_max);  
					imagecopyresampled($im, $src, 0, 0, 0, 0, round(($hauteur_max/$tableau[1])*$tableau[0]), $hauteur_max, $tableau[0], $tableau[1]);  
				}  
				else {  
					$im = imagecreatetruecolor($largeur_max, round(($largeur_max/$tableau[0])*$tableau[1]));  
					imagecopyresampled($im, $src, 0, 0, 0, 0, $largeur_max, round($tableau[1]*($largeur_max/$tableau[0])), $tableau[0], $tableau[1]);  
				}  
					// on génère des images à la volée, on envoie un header au navigateur web du visiteur lui disant que le fichier mini.php va en fait générer une image de type jpeg, soit du type mime image/jpeg.  
					header ("Content-type: image/jpeg");  
					imagejpeg ($im);  
			}  
			elseif ($tableau[2] == 3) {  
				$src = imagecreatefrompng($dir.'/'.$image);  
				if ($tableau[0] > $tableau[1]) {  
					$im = imagecreatetruecolor(round(($hauteur_max/$tableau[1])*$tableau[0]), $hauteur_max);  
					imagecopyresampled($im, $src, 0, 0, 0, 0, round(($hauteur_max/$tableau[1])*$tableau[0]), $hauteur_max, $tableau[0], $tableau[1]);  
				}  
				else{  
					$im = imagecreatetruecolor($largeur_max, round(($largeur_max/$tableau[0])*$tableau[1]));  
					imagecopyresampled($im, $src, 0, 0, 0, 0, $largeur_max, round($tableau[1]*($largeur_max/$tableau[0])), $tableau[0], $tableau[1]);  
				}  
				header ("Content-type: image/png");  
				imagepng ($im);  
			}  
		}
		
		/**imagette pour articles
		 * NB: Les imagettes pour articles n'ont pas toujours leur correspondant dans le repertoire parent
		 */
		function create_thumbs_article($file_name, $ratio){
			//Chemins complets des images et imagettes
			$file_orig	= $this->imgs_dir.$file_name;
			$file_dest 	= $this->thumbs_dir.$file_name;
			
			list($largeur, $hauteur) = getimagesize($file_orig); //dimensions de l'image originale
			$ratio = $ratio / $largeur; //ratio pour r&eacute;duire ï¿½ une taille voulue
			
			/*Nouvelles dimensions a appliquer*/
			$n_image_largeur = $largeur * $ratio; //largeur de l'image r&eacute;duite
			$n_image_hauteur = $hauteur * $ratio; //hauteur de l'image r&eacute;duite
			
			$destination 	= imagecreatetruecolor($n_image_largeur, $n_image_hauteur);
			$pixExt			= $this->get_file_ext($file_name);
			
			//Fonction ï¿½ utiliser selon l'extension
			switch($pixExt){
				case "jpeg" :	$source = imagecreatefromjpeg($file_orig);
								imagecopyresampled($destination, $source, 0,0, 0,0, $n_image_largeur , $n_image_hauteur , $largeur, $hauteur);		
								imagejpeg($destination, $file_dest);
								imagedestroy($source);
				break;
				
				case "jpg" :	$source = imagecreatefromjpeg($file_orig);
								imagecopyresampled($destination, $source, 0,0, 0,0, $n_image_largeur , $n_image_hauteur , $largeur, $hauteur);		
								imagejpeg($destination, $file_dest);
								imagedestroy($source);
				break;
				
				case "png" :	$source = imagecreatefrompng($file_orig);
								imagecopyresampled($destination, $source, 0,0, 0,0, $n_image_largeur , $n_image_hauteur , $largeur, $hauteur);		
								imagepng($destination, $file_dest);
								imagedestroy($source);
				break;
				
				case "gif" :	$source = imagecreatefromgif($file_orig);
								imagecopyresampled($destination, $source, 0,0, 0,0, $n_image_largeur , $n_image_hauteur , $largeur, $hauteur);		
								imagegif($destination, $file_dest);
								imagedestroy($source);
				break;
			}
		}
		
		function count_pix_per_album($val_albumId){
			return $this->count_in_tbl_where1($this->tbl_gallery, $this->fld_galleryId, $this->fld_galleryCatId, $val_albumId);
		}
		
		
		function build_step_carousel($filePath="modules/gallery/stepcarousel.html", $pageDest="gallery_thumbs.php", $nbThumbs="20", $panelCss="panel", $crtMax="20"){
			/**
			* @param : string $filePath
			* @param : int $nb_thumbs (Nombre d'imagettes a afficher)
			* @param : int $crtMax (Nbre de caractere maximum à afficher pour la description)
			* @param : int $pageDest
			* @return : {Imagettes avec titre, description et image la plus recente de l'album}
			*
			* @descr : Afficher les albums lesplus recents en mode graphique
			**/
				$tab_galleryCat		=   array_slice($this->get_gallery_cat_id(), 0, $nbThumbs);
				$content            =   '';
				
				//Fonction de comptage pour reinitialiser
				foreach($tab_galleryCat as $value){
					
					$gallery_catTitle 	= $this->get_gallery_cat_by_id("gallery_cat_lib", $value);
					$gallery_catDescr	= $this->chapo($this->get_gallery_cat_by_id("gallery_cat_descr", $value), $crtMax);
					$gallery_catImg		= $this->get_last_gallery_lib_by_cat_id($value); //L'image la plus recente de l'album
					$gallery_catLnk		= ($gallery_catImg=="") ? ("#") : ($pageDest."-cat@".$value.".html"); //Lien = '#' si album vide
					$gallery_catImg		= ($gallery_catImg=="") ? ("nothumb.gif") : ($gallery_catImg); //Image par defaut, au cas ou
										
					$content .= "<div class=\"$panelCss\">
									<a title=\"$gallery_catTitle\" href=\"$gallery_catLnk\"><img src=\"".$this->img_pathRestaure("../", "", $this->thumbs_dir)."$gallery_catImg\" /></a>
								</div>";
				}
				$toRet = ($filePath	!=	'') ? ($this->write_in_file($filePath, $content)) : ($content);
				
				return $toRet;
		}
		
		/*
		 * @param : string $galCat
		 * @return : int nb of picture or album according to the value of $galCat(0 for pictures, 1 for albums)
		 * 
		 * @descr : return the num ber of photos or album in the picture gallery
		 * **/
		function count_gallery($galCat){
			switch($galCat){
				case '1'	:	return $toRet = $this->count_in_tbl($this->tbl_galleryCat, $this->fld_galleryCatId);
				break;
				case '0'	:	return $toRet = $this->count_in_tbl($this->tbl_gallery, $this->fld_galleryId);
				break;
				default 	:	return $toRet = $this->count_in_tbl($this->tbl_gallery, $this->fld_galleryId);
			}
		}
		
		function gallery_autoIncr(){
			return $this->autoIncr($this->tbl_gallery, $this->fld_galleryId);
		}
		
	}
?>