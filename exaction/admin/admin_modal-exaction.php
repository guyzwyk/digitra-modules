<!-- ********************************* Exaction global list in modal *************************************************************
*******************************************************************************************************************************-->
<div tabindex='-1' class='modal fade' id='modal-exactionDisplay' role='dialog' aria-hidden='true' aria-labelledby='modal-exactionDisplayLabel' style='display: none;'>
    <div class='modal-dialog' style="width:95%;">
        <div class='modal-content' style="background-color:#eee;">
            <div class='modal-header'>
                <button class='close' aria-hidden='true' type='button' data-dismiss='modal'>x</button>
                <h2 class='modal-title'><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_EXACTION']; ?></h2>
            </div>
            <div class='modal-body'>
                <?php print $exaction->admin_load_exactions(3000, 250); ?>
            </div>
            <div class='modal-footer'>
                <button class='btn btn-default' type='button' data-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ********************************* Ajouter les exactions  dans un modal ******************************************************
*******************************************************************************************************************************-->
<div tabindex='-1' class='modal fade' id='modalExactionInsert' role='dialog' aria-hidden='true' aria-labelledby='modal-exactionInsertLabel' style='display: none;'>
    <div class='modal-dialog' style="width:60%;">
        <div class='modal-content' style="background-color:#eee;">
          
            <div class='modal-header panel-heading'>
                <button class='close' aria-hidden='true' type='button' data-dismiss='modal'>x</button>
                <h2 class='modal-title'><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_EXACTION']; ?></h2>
            </div>
                          
            <div class='modal-body'>
                <div>
                    <?php //if($_REQUEST['task']=="exactionInsert") { ?>
                        <?php $currentLang = (($_REQUEST['langId'] != '') ? ($_REQUEST['langId']) : ($_SESSION['LANG'])); ?>
                        <?php if(isset($exaction_insert_err_msg)) {  ?>
                            <div class="ADM_err_msg"><?php print $exaction_insert_err_msg; ?></div>
                        <?php } ?>
                                      
                        <?php if(isset($exaction_insert_cfrm_msg)) {  ?>
                            <div class="ADM_cfrm_msg"><?php print $exaction_insert_cfrm_msg; ?></div>
                        <?php } ?>
                                  
                        <div class="tab-content">
                            <div class="tab-pane active" id="horizontal-form">
                                <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="frm_exaction_insert" id="frm_exaction_insert">
                                                  
                                    <div class="form-group">    
                                        <label class="col-sm-4 control-label" for="exaction_selType"><?php print $mod_lang_output['FORM_LABEL_EXACTION_TYPE']; ?></label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="exaction_selType" id="exaction_selType">
                                                <?php print $exaction->admin_cmb_show_cat($exaction->tbl_exactionType, $exaction->fld_exactionTypeId, $_POST['exaction_selType']); ?>
                                            </select>
                                        </div>
                                    </div>
                                                  
                                    <div class="form-group">    
                                        <label class="col-sm-4 control-label" for="exaction_selNature"><?php print $mod_lang_output['FORM_LABEL_EXACTION_NATURE']; ?></label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="exaction_selNature" id="exaction_selNature">
                                                <?php print $exaction->admin_cmb_show_cat($exaction->tbl_exactionNature, $exaction->fld_exactionNatureId, $_POST['exaction_selNature']); ?>
                                            </select>
                                        </div>
                                    </div>
                                                  
                                    <div class="form-group">    
                                        <label class="col-sm-4 control-label" for="exaction_selTown"><?php print $mod_lang_output['FORM_LABEL_EXACTION_TOWN']; ?></label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="exaction_selTown" id="exaction_selTown">
                                                <?php print $exaction->cmb_load_exaction_place($_POST['exaction_selTown']); ?>
                                            </select>
                                        </div>
                                    </div>
                                                  
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"><?php print $mod_lang_output['FORM_LABEL_EXACTION_DATE']; ?></label>
                                        <div class="col-sm-8">
                                            <?php print $exaction->combo_date($_POST['cmbDay'], $_POST['cmbMonth'], $_POST['cmbYear'], '1', $_SESSION['LANG']); ?>
                                        </div>
                                    </div>
                                                  
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="exaction_taVictim"><?php print $mod_lang_output['FORM_LABEL_EXACTION_VICTIM']; ?></label>
                                        <div class="col-sm-8">
                                            <textarea style="width:100%;" name="exaction_taVictim" cols="40" rows="3" id="exaction_taVictim"><?php print $exaction->show_content($exaction_insert_err_msg, $_POST['exaction_taVictim']) ?></textarea>
                                        </div>
                                    </div>
                                                      
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="exaction_taDescr"><?php print $mod_lang_output['FORM_LABEL_EXACTION_DESCR']; ?></label>
                                        <div class="col-sm-8">
                                            <textarea style="width:100%;" name="exaction_taDescr" cols="40" rows="5" id="exaction_taDescr"><?php print $exaction->show_content($exaction_insert_err_msg, $_POST['exaction_taDescr']) ?></textarea>
                                        </div>
                                    </div>
                                                 	
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-offset-4">
                                                <button name="exaction_btnInsert" id="exaction_btnInsert" type="submit" class="btn-success btn" data-toggle="modal" data-target="#modal-exactionInsert"><?php print $mod_lang_output['FORM_BUTTON_ADD_EXACTION']; ?></button>
                                                <input type="hidden" />
                                            </div>
                                        </div>
                                    </div>
                  
                                </form>
                            </div>
                        </div>
                    <?php //} ?>
                </div>
            </div>

            <div class='modal-footer'>
                <button class='btn btn-default' type='button' data-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Fix the Modal  -->
    <?php if(isset($_POST['exaction_btnInsert'])) { ?>
        <script> $('a[data-target="#modalExactionInsert"]').click(); </script>
    <?php } ?>
<!-- ****************************************** -->

<!-- ********************************* Ajouter les pieces-jointes des exactions  ******************************************************
***************************************************************************************************************************************-->
<div tabindex='-1' class='modal fade' id='modal-exactionPjInsert' role='dialog' aria-hidden='true' aria-labelledby='modal-exactionPjInsertLabel' style='display: none;'>
    <div class='modal-dialog' style="width:60%;">
        <div class='modal-content' style="background-color:#eee;">

            <div class='modal-header panel-heading'>
                <button class='close' aria-hidden='true' type='button' data-dismiss='modal'><i class="fa fa-times"></i></button>
                <h2 class='modal-title'><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_EXACTION_PJ']; ?></h2>
            </div>

            <div class='modal-body'>
                <div>
                    <?php //if($_REQUEST['task']=="exactionInsert") { ?>
                        <?php $currentLang = (($_REQUEST['langId'] != '') ? ($_REQUEST['langId']) : ($_SESSION['LANG'])); ?>

                        <?php if(isset($exaction_pj_insert_err_msg)) {  ?>
                            <div class="ADM_err_msg"><?php print $exaction_pj_insert_err_msg; ?></div>
                        <?php } ?>
                                                      
                        <?php if(isset($exaction_pj_insert_cfrm_msg)) {  ?>
                            <div class="ADM_cfrm_msg"><?php print $exaction_pj_insert_cfrm_msg; ?></div>
                        <?php } ?>
                                                  
                        <div class="tab-content">
                            <div class="tab-pane active" id="horizontal-form">

                                <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="frm_exaction_pj_insert" id="frm_exaction_pj_insert">
                          
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="exaction_filePj"><?php print $mod_lang_output['FORM_LABEL_EXACTION_PJ']; ?></label>
                                        <div class="col-sm-8">
                                            <input class="form-control1" type="file" name="exaction_filePj" id="exaction_filePj" />
                                        </div>
                                    </div>
                                                                  
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="exaction_taPjTitle"><?php print $mod_lang_output['FORM_LABEL_EXACTION_PJ_TITLE']; ?></label>
                                        <div class="col-sm-8">
                                            <input class="form-control1" type="text" name="exaction_txtPjTitle" id="exaction_txtPjTitle" value="<?php print $exaction->show_content($exaction_pj_insert_err_msg, $_POST['exaction_txtPjTitle']) ?>" />
                                        </div>
                                    </div>
                                                                      
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="exaction_taPjDescr"><?php print $mod_lang_output['FORM_LABEL_EXACTION_PJ_DESCR']; ?></label>
                                        <div class="col-sm-8">
                                            <textarea style="width:100%;" name="exaction_taDescr" cols="40" rows="15" id="exaction_taPjDescr"><?php print $exaction->show_content($exaction_pj_insert_err_msg, $_POST['exaction_taPjDescr']) ?></textarea>
                                        </div>
                                    </div>
                                                                         
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-offset-4">
                                                <button name="exaction_btnPjInsert" id="exaction_btnPjInsert" type="submit" class="btn-success btn" data-target="#modal-exactionPjInsert"><?php print $mod_lang_output['FORM_BUTTON_ADD_EXACTION_PJ']; ?></button>
                                                <input type="hidden" name="exaction_hdId" value="<?php print $_REQUEST[$myExaction->URI_exactionVar]; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                  
                                </form>

                            </div>
                        </div>
                    <?php //} ?>
                </div>
            </div>
                                          
            <div class='modal-footer'>
                <button class='btn btn-default' type='button' data-dismiss='modal'>Close</button>
            </div>

        </div>
    </div>
</div>

<!-- Fix the Modal  -->
<?php if(isset($_POST['exaction_btnPjInsert'])) { ?>
    <script> $('a[data-target="#modal-exactionPjInsert"]').click(); </script>
<?php } ?>
<!-- ****************************************** -->