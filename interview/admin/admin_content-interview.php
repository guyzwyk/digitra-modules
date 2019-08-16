<?php
	require("../modules/interview/langfiles/".$langFile.".php"); //Module language pack
	require_once('../modules/interview/inc/interview_validations.php');	
?>
<?php if($_REQUEST[what]=="catInsert"){ ?>
      <h1>Nouvelle cat&eacute;gorie d'interview</h1>
      
      <?php if(isset($rub_insert_err_msg)) {  ?>
      <div class="ADM_err_msg"><?php print $rub_insert_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($rub_insert_cfrm_msg)) {  ?>
      <div class="ADM_cfrm_msg"><?php print $rub_insert_cfrm_msg; ?></div>
      <?php } ?>
      <form id="frm_rub_insert" name="frm_rub_insert" method="post" action="">
        <table class="ADM_form">
          <tr>
            <th align="right">Choisir la langue : </th>
            <td><select name="interview_selLang" id="interview_selLang">
                <?php print $myInterview->cmb_showLang($_POST[interview_selLang]); ?>
              </select>            </td>
          </tr>
          <tr>
            <th align="right">Intitul&eacute; : </th>
            <td><input name="txt_cat_lib" type="text" id="txt_cat_lib" value="" size="40" /></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td><input type="submit" value="Ajouter la cat&eacute;gorie" name="btn_cat_insert" id="btn_cat_insert" /></td>
          </tr>
        </table>
      </form>
      <?php } ?>
      
      <!-- ********************************* Afficher les demandes d'audiences  ******************************************************
      ****************************************************************************************************************-->
      <?php if(isset($rub_displayUpd)){ ?>
      <h1>Modifier une cat&eacute;gorie</h1>
      
      <?php if(isset($rub_update_err_msg)) {  ?>
      <div class="ADM_err_msg"><?php print $rub_update_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($rub_update_cfrm_msg)) {  ?>
      <div class="ADM_cfrm_msg"><?php print $rub_update_cfrm_msg; ?></div>
      <?php } ?>
      <form id="frm_cat_update" name="frm_cat_update" method="post" action="">
        <table class="ADM_form">
          <tr>
            <th align="right">Choisir la langue : </th>
            <td><select name="interview_selLangUpd" id="interview_selLangUpd">
                <?php print $myInterview->cmb_showLang($tabCatUpd[interviewCATLANG]); ?>
              </select>
            </td>
          </tr>
          <tr>
            <th align="right">Libell&eacute;: </th>
            <td><input name="txt_cat_lib_upd" value="<?php print $tabCatUpd[interviewCATLIB]; ?>" type="text" id="txt_cat_lib_upd" size="30" /></td>
          </tr>
          <tr>
            <th align="right"><input type="hidden" name="hd_cat_id" value="<?php print $_REQUEST[acId]; ?>" /></th>
            <td><input type="submit" value="Modifier la cat&eacute;gorie" name="btn_cat_upd" id="btn_cat_upd" /></td>
          </tr>
        </table>
      </form>
      <?php } ?>
      
      
      <?php if($_REQUEST[what]=="catDisplay") { ?>
          <h1>Afficher les cat&eacute;gories</h1>
          
          <?php if(isset($rub_display_err_msg)) {  ?>
          <div class="ADM_err_msg"><?php print $rub_display_err_msg; ?></div>
          <?php } ?>
          <?php if(isset($rub_display_cfrm_msg)) {  ?>
          <div class="ADM_cfrm_msg"><?php print $rub_display_cfrm_msg; ?></div>
          <?php } ?>
          
          <?php print $myInterview->admin_load_interviews_cat(); ?>
      <?php } ?>
      
      
      <?php if($_REQUEST[what]=="insert") { ?>
      <h1>Nouvelle demande d'audience</h1>
      
      <?php if(isset($interview_insert_err_msg)) {  ?>
        <?php $currentLang = (($_REQUEST[langId] != '') ? ($_REQUEST[langId]) : ($_SESSION['LANG'])); ?>
      <div class="ADM_err_msg"><?php print $interview_insert_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($interview_insert_cfrm_msg)) {  ?>
      <div class="ADM_cfrm_msg"><?php print $interview_insert_cfrm_msg; ?></div>
      <?php } ?>
      <form method="POST" name="frm_audience">
					 			<table class="form-interview">
					                <tr>
					                    <th class="frmLabel">{$s_lbl_itw_name}<span class="errorRed"> *</span> : </th>
					                    <td><input name="txtName" type="text" class="input_text" id="txtName" value="{$s_validateName}" /></td>
					                </tr>
					                <tr>
					                    <th class="frmLabel">{$s_lbl_itw_rank}<span class="errorRed"> *</span> : </th>
					                    <td><input name="txtRank" type="text" class="input_text" id="txtRank" size="50" value="{$s_validateRank}" /></td>
					                </tr>
					                <tr>
					                    <th class="frmLabel">{$s_lbl_itw_subject}<span class="errorRed"> *</span> : </th>
					                    <td><textarea name="taSubject" class="input_text" id="taSubject" rows="5" cols="50">{$s_validateSubject}</textarea></td>
					                </tr>
					                <tr>
					                   	<th class="frmLabel">{$s_lbl_itw_email}<span class="errorRed"> *</span> : </th>
					                   	<td><input name="txtEmail" type="text" class="input_text" id="txtEmail" value="{$s_validateEmail}" /></td>
					                </tr>
					                <tr>
					                   	<th class="frmLabel">{$s_lbl_itw_phone} :</th>
					                   	<td><input name="txtPhone" type="text" class="input_text" id="txtPhone" value="{$s_validatePhone}" size="20" /></td>
					                </tr>
					                <tr>
					                   	<th class="frmLabel">{$s_lbl_itw_cni} :</th>
					                   	<td><input name="txtCni" type="text" class="input_text" id="txtCni" value="{$s_validateCni}" size="20" /></td>
					                </tr>
					                <tr>
					                   	<th class="frmLabel">{$s_lbl_itw_date}<span class="errorRed"> *</span> :</th>
					                   	<td>
											{if $s_pageLang eq 'FR'}
												{$s_load_datetimeFR}
											{else}
												{$s_load_datetimeEN}
											{/if}
					                   	</td>
					                </tr>
					                
									<tr>
					                   	<td align="right" valign="top">&nbsp;</td>
					                   	<td><input type="submit" name="btn_itwBook" onclick="return confirm('{$s_lbl_itw_book_confirm}')" value="{$s_lbl_itw_btn_ok}" /></td>
					                </tr>
					            </table>
					        </form>
      <?php } ?>

      <?php if(!isset($_REQUEST['what']) || ($_REQUEST['what']=="display")) { ?>
          <h1>Afficher les demandes d'audience</h1>
		  <?php $myInterview->limit = $_REQUEST[limite]; ?>
          
          <?php if(isset($itw_display_err_msg)) {  ?>
          <div class="ADM_err_msg"><?php print $itw_display_err_msg; ?></div>
          <?php } ?>
          <?php if(isset($itw_display_cfrm_msg)) {  ?>
          <div class="ADM_cfrm_msg"><?php print $itw_display_cfrm_msg; ?></div>
          <?php } ?>
          
          <?php print stripslashes($myInterview->admin_load_interviews()); ?>
      <?php } ?>
      
      
      <?php 
      	if($_REQUEST[what] == "update") { // Si on a clique sur modifier l'interview... 
	  		$tabUpd	= $myInterview->get_interview($_REQUEST[$myInterview->mod_queryKey]);
	  ?>
      <h1>Modifier une interview</h1>
      <?php if(isset($interview_update_err_msg)) { ?>
      <div class="ADM_err_msg"><?php print $interview_update_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($interview_update_cfrm_msg)) { ?>
      <div class="ADM_cfrm_msg"><?php print $interview_update_cfrm_msg; ?></div>
      <?php } ?>
      <form id="frm_interview_update" name="frm_interview_update" method="post" action="">
        <table class="ADM_form">
          <tr>
            <th align="right">Nom(s) et Pr&eacute;nom(s) : </th>
            <td><input name="txt_nameUpd" id="txt_nameUpd" type="text" value="<?php print $tabUpd["NAME"]; ?>" /></td>
          </tr>
          <tr>
            <th align="right">Qualit&eacute; / Rang : </th>
            <td><input name="txt_nameUpd" id="interview_nameUpd" type="text" value="<?php print $tabUpd["RANK"]; ?>" /></td>
          </tr>
          <tr>
            <th align="right">Objet : </th>
            <td><textarea name="ta_subjectUpd" cols="40" rows="5" id="ta_subjectUpd"><?php print stripslashes($tabUpd["SUBJECT"]); ?></textarea></td>
          </tr>
            <th align="right">Email : </th>
            <td><input name="txt_emailUpd" type="text" value="<?php print stripslashes($tabUpd["EMAIL"]); ?>" id="txt_emailUpd" size="40" /></td>
          </tr>
          <tr>
            <th align="right">Numero de T&eacute;l&eacute;phone : </th>
            <td><input name="txt_telUpd" type="text" value="<?php print stripslashes($tabUpd["TELEPHONE"]); ?>" id="txt_telUpd" size="35" /></td>
          </tr>
          <tr>
            <th align="right">Numero CNI : </th>
            <td><input name="txt_cniUpd" type="text" value="<?php print stripslashes($tabUpd["IDNUM"]); ?>" id="txt_cniUpd" size="35" /></td>
          </tr>
          <tr>
            <th align="right">Date pr&eacute;vue : </th>
            <td><?php print $myInterview->combo_datetimeFrUpd($tabUpd[DATE], 1910, ''); ?></td>
          </tr>
          <tr>
            <th align="right"><input type="hidden" name="hd_interview_id" value="<?php print $_REQUEST[interviewId]; ?>" /></th>
            <td><input type="submit" value="Modifier la demande d'audience" name="btn_interview_upd" id="btn_interview_upd" /></td>
          </tr>
        </table>
      </form>
      <?php } ?>