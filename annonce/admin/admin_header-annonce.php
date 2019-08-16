<?php
    //Library call
    require('../modules/annonce/langfiles/'.$langFile.'.php');

    //Initializations
    $annonce	        =   new cwd_annonce();
    $my_annonceStats	=	new cwd_annonce();

    //For statistics
    $nbAnnonces			=	$my_annonceStats->count_annonces();
?>
<?php
	$myRss->set_rss_tblInfos($annonce->tbl_annonce, $annonce->fld_annonceId, $annonce->fld_annonceTitle, $annonce->fld_annonceLib, $annonce->fld_annonceAuthor, $annonce->fld_annonceDatePub, $annonce->tbl_annonceAuthor, $annonce->fld_annonceAuthorF, $annonce->fld_annonceAuthorL);
	$myRss->set_rss_link_param($annonce->URI_annonce, $thewu32_modLink['annonce'], $thewu32_modLink['annonce']);
	$myRss->rss_customize_layout("North West region Announcements", "Toutes les annonces de la R&eacute;gion du Nord-Ouest", $thewu32_site_url.'modules/annonce/img/rss_annonces.gif', "Announcements / Annonces", "NWR Announcements / Annonces RNO", "");
	//$myRss->se
	$myRss->makeRSS("../modules/annonce/rss/annonces.xml");
?>