<?php
/******************************** Ajouter des exactions ***********************************************/
$exaction_selType   =   $_POST['exaction_selType'];
$exaction_selTown   =   $_POST['exaction_selTown'];
$exaction_selNature =   $_POST['exaction_selNature'];
$exaction_taVictim  =   addslashes($_POST['exaction_taVictim']);
$exaction_taDescr   =   addslashes($_POST['exaction_taDescr']);
$exaction_filePj    =   0; //$_FILES['exaction_filePj']['name'];
$cmbDay             =   $_POST['cmbDay'];
$cmbMonth           =   $_POST['cmbMonth'];
$cmbYear            =   $_POST['cmbYear'];

if(isset($_POST['exaction_btnInsert'])){
    
    //If button pressed, then set the date
    $exactionDate   =   $cmbYear.'-'.$cmbMonth.'-'.$cmbDay;
    
    if(empty($exaction_taVictim) || empty($exaction_taDescr)){
        $exaction_insert_err_msg    =   $mod_lang_output['EXACTION_INSERT_ERROR_EMPTY'];
    }
    elseif($myExaction->chk_entry_twice($myExaction->tbl_exaction, 'victime', 'description', $exaction_taVictim, $exaction_taDescr)){
        $exaction_insert_err_msg    =   $mod_lang_output['EXACTION_INSERT_ERROR_EXISTS'];
    }
    elseif($myExaction->set_exaction($exaction_selType, $exaction_selNature, $exaction_filePj, $exaction_selTown, $exaction_taVictim, $exaction_taDescr, $exactionDate)){
        $exaction_insert_cfrm_msg    =   $mod_lang_output['EXACTION_INSERT_OK'];
    }
}

/******************************** Modifier des exactions ***********************************************/
$exaction_hdUpdate		=	$_POST['exaction_hdUpdate'];
$exaction_selTypeUpd   	=   $_POST['exaction_selTypeUpd'];
$exaction_selTownUpd   	=   $_POST['exaction_selTownUpd'];
$exaction_selNatureUpd 	=   $_POST['exaction_selNatureUpd'];
$exaction_taVictimUpd  	=   addslashes($_POST['exaction_taVictimUpd']);
$exaction_taDescrUpd   	=   addslashes($_POST['exaction_taDescrUpd']);
$cmbDayUpd             	=   $_POST['cmbDayUpd'];
$cmbMonthUpd           	=   $_POST['cmbMonthUpd'];
$cmbYearUpd            	=   $_POST['cmbYearUpd'];

if(isset($_POST['exaction_btnUpdate'])){
    //If button pressed, then set the date
    $exactionDateUpd   =   $cmbYearUpd.'-'.$cmbMonthUpd.'-'.$cmbDayUpd;
    
    if(empty($exaction_taVictimUpd) || empty($exaction_taDescrUpd)){
        $exaction_update_err_msg    =   $mod_lang_output['EXACTION_UPDATE_ERROR_EMPTY'];
    }
    elseif($myExaction->update_exaction($exaction_hdUpdate, $exaction_selTypeUpd, $exaction_selNatureUpd, '0', $exaction_selTownUpd, $exaction_taVictimUpd, $exaction_taDescrUpd, $exactionDateUpd, '1')){
        $exaction_update_cfrm_msg    =   $mod_lang_output['EXACTION_UPDATE_OK'];
    }
}


   
    /******************************** Ajouter une piece-jointe  ***********************************************/
    $exaction_btnPjInsert		= 	$_POST['exaction_btnPjInsert'];
    
    //Les fichiers
    $exaction_filePj_name 		= 	$_FILES['exaction_filePj']['name'];
    $exaction_filePj_size 		= 	$_FILES['exaction_filePj']['size'];
    
    //Les autres champs
    $exaction_txtPjTitle        =   addslashes($_POST['exaction_txtPjTitle']);
    $exaction_taPjDescr         =   addslashes($_POST['exaction_taPjDescr']);
    $exaction_hdId              =   $_POST['exaction_hdId'];
    
    //Detecter le type de fichier
    $fileExt    =   $myExaction->get_file_ext($exaction_filePj_name);
    
    //Extensions acceptees
    $tabExt     =   array('jpeg', 'jpg', 'png', 'pdf', 'docx', 'doc'); 
    $fileDest   =   '../modules/exaction/files/attachments/';
    
    if(isset($exaction_btnPjInsert)){
        if($exaction_filePj_name ==''){
            $exaction_pj_insert_err_msg 	=  $mod_lang_output['EXACTION_PJ_INSERT_ERROR_EMPTY'];
        }
        elseif(empty($exaction_txtPjTitle)){
            $exaction_pj_insert_err_msg 	=  $mod_lang_output['EXACTION_PJ_INSERT_ERROR_TITLE'];
        }
        elseif(!in_array($fileExt, $tabExt)){
            $exaction_pj_insert_err_msg 	=  $mod_lang_output['EXACTION_PJ_INSERT_ERROR_TYPE'];
        }
        elseif($myExaction->chk_entry_trice($myExaction->tbl_exactionPieces, $myExaction->fld_exactionId, $myExaction->fld_exactionPiecesLib, $myExaction->fld_exactionPiecesDescr, $exaction_hdId, $exaction_txtPjTitle, $exaction_taDescr)){
            $exaction_pj_insert_err_msg 	=  $mod_lang_output['EXACTION_PJ_INSERT_ERROR_EXISTS'];
        }
        else{
            //$exaction_pj_insert_cfrm_msg = $mod_lang_output['EXACTION_PJ_INSERT_OK'];
            //$myExaction->set_exaction_pj($exaction_hdId, $exaction_txtPjTitle, $exaction_taPjDescr);
            if($insertId = $myExaction->set_exaction_pj($exaction_hdId, $exaction_txtPjTitle, $exaction_taPjDescr, '')){
                //print $fileUrl_name.'<br />Cat is : '.$file_selCat;
                /*** Envoyer le fichier physique et Mettre la table à jour ***/
                // 1 -Renommage du fichier avec le code categorie et le numero d'insertion ds la table (<catID>_<insertId>.<EXT>)
                $exaction_filePj_name 	= $insertId.'.'.$fileExt;
                
                // 2 - Upload proprement dit et mise à jour ds la table des fichiers
                if(move_uploaded_file($_FILES['exaction_filePj']['tmp_name'], $fileDest . $exaction_filePj_name) ){
                    $myExaction->update_entry_where($myExaction->tbl_exactionPieces, $myExaction->fld_exactionPiecesName, $exaction_filePj_name, $myExaction->fld_exactionPiecesId, $insertId);
                    
                    $exaction_pj_insert_cfrm_msg = $mod_lang_output['EXACTION_PJ_INSERT_OK'];
                    
                    $system->set_log('EXACTION ATTACHMENT INSERTED - ('.$exaction_txtPjTitle.')');
                }
            }
        }
    }
    
?>



<?php

	switch($_REQUEST[action]){
		case	'dump'		: 	if($totalExaction = $myExaction->csv_dump_exaction($_REQUEST[mFile])) { $action_msgOk	=	"<div class=\"ADM_cfrm_msg\">$totalExaction exactions effectivement import&eacute;s dans le syst&egrave;me.<br /><a href=\"?what=exactionDisplay\">Afficher les exactions</a></div>"; $system->set_log('EXACTION FILE DUMPED SUCCESSFULLY - ('.$_REQUEST[mFile].')');} else{$file_dumpMsg="<div class=\"ADM_err_msg\">Erreur lors de l'importation des donn&eacute;es dans le syst&egrave;me</div>"; $system->set_log('EXACTION FILE DUMP ERROR - ('.$_REQUEST[mFile].')');}
		break;		
		case 	'delete'	: 	if($myExaction->del_exaction($_REQUEST['exId'])) { $action_msgOk	=	"<div class=\"ADM_cfrm_msg\">Bravo<br />Le membre a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s!</div>"; }
		break;		
		case 	"update" 	: 	$exactionInfo	=	$myExaction->get_exaction($_REQUEST[exId]);	
		break;		
		case 	'drop'		:	if($myExaction->drop_exaction()) { $empty_data_msg = "<div class=\"ADM_cfrm_msg\">La table des exactions a &eacute;t&eacute; vid&eacute;e avec succ&egrave;s</div>"; $system->set_log('EXACTION DROP OK'); } else { $empty_data_msg = "<div class=\"ADM_err_msg\">La table des exactions n' a pas pu &ecirc;tre vid&eacute;e</div>"; $system->set_log('EXACTION DROP ERROR');}
		break;
	}
?>