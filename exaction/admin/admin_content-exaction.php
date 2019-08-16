<?php
    /***********************************************************
    *                 Module language call                     *
    ************************************************************/
    require('../modules/exaction/langfiles/'.$langFile.'.php');
?>



<?php
    /***********************************************************
    *                   Module validations                     *
    ************************************************************/
    require_once('../modules/exaction/inc/exaction_validations.php');
?>


    <!-- ********************************* Afficher les exactions  ***************************************************
	****************************************************************************************************************-->
	
	<!-- ************ Listing des exactions  *****************-->
	<?php if(!isset($_REQUEST['what']) || ($_REQUEST['what']=="display") || ($_REQUEST['what']=="delete")) { ?>
			      
                  <div class="xs">
                      
                      <h3>
                          <?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_EXACTION']; ?>
                          <span style="float:right;">
                              <?php if($_POST['exaction_txtSearch'] != ''){ ?><a href="<?php print $myExaction->admin_modPage; ?>" title="<?php print $mod_lang_output['PAGE_HEADER_LIST_EXACTION']; ?>"><?php print $system->admin_button_crud('back'); ?></a><?php } ?>
                              <a title="<?php print $mod_lang_output['FORM_BUTTON_ADD_EXACTION']; ?>" data-toggle="modal" data-target="#modalExactionInsert"><?php print $system->admin_button_crud('create'); ?></a>
                              <a title="<?php print $mod_lang_output['FORM_BUTTON_LIST_EXACTIONS']; ?>" data-toggle="modal" data-target="#modal-exactionDisplay"><?php print $system->admin_button_crud('read'); ?></a>
                          </span>
                      </h3>
                      
                      <div class="col-md-9">
                              
                          <!--  Exactions search form  -->
                          <form method="post" name="exaction_frmSearch" id="exaction_frmSearch" action="">
                                      <div class="input-group">
                                          <input type="text" name="exaction_txtSearch" class="form-control1 input-search" placeholder="Search..." />
                                          <span class="input-group-btn">
                                              <button class="btn btn-success" type="submit" name="exaction_btnSearch"><i class="fa fa-search"></i></button>
                                          </span>
                                  </div>
                          </form>
                          
                          <?php if(!empty($_POST['exaction_txtSearch'])) { ?>
                          
                          <!--  Exactions search results -->
                                          
                          <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
                              <div class="panel-body no-padding">
                                  <?php 
                                     print $myExaction->search_exaction($_POST['exaction_txtSearch'], $mod_lang_output['EXACTION_SEARCH_MSG_ERROR'], $_SESSION['LANG']);
                                  ?>
                              </div>
                          </div>
                          <?php } ?>
                          
                          <?php if($_REQUEST["what"]=="exactionDelete") { ?>
                          
                          <!--  Exations delete msg -->
                                          
                          <div class="alert alert-success">
                              <?php 
                                   print $mod_lang_output["EXACTION_DELETE_MSG_OK"];
                              ?>
                          </div>
                          <?php } ?>
                          
                              <?php if(!isset($_POST['exaction_btnSearch']))  { //Hide exaction list when search is active ?> 
                              
                              <!--  Exations preview list -->
                              
                              <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
                                  <div class="panel-body no-padding">
                                      <?php $exaction->limit = $_REQUEST['limite']; ?>
                                            
                                      <?php if(isset($exaction_display_err_msg)) {  ?>
                                          <div class="ADM_err_msg"><?php print $exaction_display_err_msg; ?></div>
                                      <?php } ?>
                                              
                                      <?php if(isset($exaction_display_cfrm_msg)) {  ?>
                                          <div class="ADM_cfrm_msg"><?php print $exaction_display_cfrm_msg; ?></div>
                                      <?php } ?>
                                      
                                      <div class="table-responsive" style="height:600px; overflow-y:auto;">
                                          <?php print $exaction->admin_load_exactions(500); ?>
                                      </div>
                                  </div>
                              </div>
                              
                              <?php } ?>
                              
                                  
                      
                          <div class="panel panel-warning" data-widget-static="">
                              <div class="panel-body">
                                  <div class="table-responsive">
                                      <table class="stats-exactions table table-bordered">
                                          <tr>
                                              <th colspan="2"><?php print $mod_lang_output['PAGE_HEADER_REPORTED_EXACTION_STATS']; ?></th>
                                          </tr>
                                          <tr>
                                              <td><?php print $mod_lang_output['EXACTION_STATS_KILLINGS_LABEL']?></td>
                                              <td><?php print $nbKillings.'('.round(($nbKillings * 100)/$nbExaction, 1).' %)'; ?></td>
                                          </tr>
                                          <tr>
                                              <td><?php print $mod_lang_output['EXACTION_STATS_ABDUCTIONS_LABEL']?></td>
                                              <td><?php print $nbAbductions.'('.round(($nbAbductions * 100)/$nbExaction, 1).' %)'; ?></td>
                                          </tr>
                                          <tr>
                                              <td><?php print $mod_lang_output['EXACTION_STATS_BURNINGS_LABEL']?></td>
                                              <td><?php print $nbBurnings.'('.round(($nbBurnings * 100)/$nbExaction, 1).' %)'; ?></td>
                                          </tr>
                                          <tr>
                                              <td><?php print $mod_lang_output['EXACTION_STATS_INJURIES_LABEL']?></td>
                                              <td><?php print $nbInjuries.'('.round(($nbInjuries * 100)/$nbExaction, 1).' %)'; ?></td>
                                          </tr>
                                          <tr>
                                              <td><?php print $mod_lang_output['EXACTION_STATS_RAPES_LABEL']?></td>
                                              <td><?php print $nbRapes.'('.round(($nbRapes * 100)/$nbExaction, 1).' %)'; ?></td>
                                          </tr>
                                          <tr>
                                              <td><?php print $mod_lang_output['EXACTION_STATS_EXTORTIONS_LABEL']?></td>
                                              <td><?php print $nbExtorsions.'('.round(($nbExtorsions * 100)/$nbExaction, 1).' %)'; ?></td>
                                          </tr>
                                          <tr style="text-align:center; font-weight:bold;">
                                              <td><?php print $mod_lang_output['EXACTION_STATS_TOTAL_LABEL']?></td>
                                              <td><?php print $nbExaction; ?></td>
                                          </tr>					
                                      </table>
                                  </div>
                              </div>
                          </div>
                          
                          
                          <!-- Graph here -->
                          
                          <div class="panel panel-warning" data-widget-static="">
                              <div class="panel-body">
                                  <!-- <iframe src="../modules/exaction/inc/piechart.php" width="100%" height="300" border="0"></iframe> -->
                                  <style> 
                                      /* white color data labels */ 
                                      .jqplot-data-label{color:white;} 
                                  </style>
                                   <?php print $chartOut; ?>
                              </div>
                             </div>
                                                            
                      </div>
                  
                                      
                      <!-- ********************************* Statistiques des exactions  ******************************************************
                      **********************************************************************************************************************-->
                              
                      <div class="col-md-3">
          
                          <div class="panel panel-warning" data-widget-static=""  style="margin-top:0;">
                              <div class="panel-body">
                                  <table class="table table-bordered">
                                      <tr>
                                          <th><?php print $mod_lang_output['EXACTION_STATS_TOWN_HEADER']; ?></th>
                                      </tr>
                                  <?php
                                      foreach($mostDangerous as $value){
                                          print "<tr><td>$value</td></tr>";
                                      }
                                  ?>
                                  </table>
                              </div>
                          </div>
                      </div>
                      <div class="clearfix"></div>
                  
                  </div>
                  
              <?php } ?>				
              
              
              
                         
                         <!-- <div class="clearfix"></div> -->
                          
                      <!-- ********************************* Modifier les exactions  ******************************************************
                      ****************************************************************************************************************-->
              
                          <?php if($_REQUEST['what']=="update") {  $tabExaction = $myExaction->get_exaction($_REQUEST[$myExaction->URI_exactionVar]); ?>
                              <?php if (in_array($_REQUEST[$myExaction->URI_exactionVar], $tabExaction)) {?>
                                  <h3>
                                      <?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_UPDATE_EXACTION']; ?>
                                      <span style='float:right;'>
                                            <a href="<?php print $myExaction->admin_modPage; ?>" title="<?php print $mod_lang_output['PAGE_HEADER_LIST_EXACTION']; ?>"><?php print $system->admin_button_crud('back'); ?></a>
                                            <a title="<?php print $mod_lang_output['FORM_BUTTON_ADD_EXACTION_PJ']; ?>" data-toggle="modal" data-target="#modal-exactionPjInsert"><i class="fa fa-paperclip"></i></a>
                                        </span>         
                                  </h3>

                                  <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <?php print $mod_lang_output['PAGE_HEADER_UPDATE_EXACTION']; ?>
                                          <span style="float:right;">	
                                          <?php print $myExaction->admin_load_exaction_nav($_REQUEST[$myExaction->URI_exactionVar], '?page=exaction&what=update'); ?>
                                      </span>
                                      </div>
                                      
                                      <div class="panel-body">
                                          <?php $currentLang = (($_REQUEST['langId'] != '') ? ($_REQUEST['langId']) : ($_SESSION['LANG'])); ?>
                                    
                                          <?php if(isset($exaction_update_err_msg)) {  ?>
                                              <div class="ADM_err_msg"><?php print $exaction_update_err_msg; ?></div>
                                          <?php } ?>
                                          <?php if(isset($exaction_update_cfrm_msg)) {  ?>
                                              <div class="ADM_cfrm_msg"><?php print $exaction_update_cfrm_msg; ?></div>
                                          <?php } ?>
                                          <div class="tab-content">
                                              <div class="tab-pane active" id="horizontal-form">
                                                  <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="frm_exaction_update" id="frm_exaction_update">
                                                  
                                                      <div class="form-group">    
                                                          <label class="col-sm-2 control-label" for="exaction_selTypeUpd"><?php print $mod_lang_output['FORM_LABEL_EXACTION_TYPE']; ?></label>
                                                          <div class="col-sm-8">
                                                              <select class="form-control" name="exaction_selTypeUpd" id="exaction_selTypeUpd">
                                                                  <?php print $exaction->admin_cmb_show_cat($exaction->tbl_exactionType, $exaction->fld_exactionTypeId, $tabExaction['TYPE']); ?>
                                                              </select>
                                                          </div>
                                                          <div class="col-sm-2">
                                                              <!-- <p class="help-block">Your help text!</p> -->
                                                          </div>
                                                      </div>
                                                  
                                                      <div class="form-group">    
                                                          <label class="col-sm-2 control-label" for="exaction_selNatureUpd"><?php print $mod_lang_output['FORM_LABEL_EXACTION_NATURE']; ?></label>
                                                          <div class="col-sm-8">
                                                              <select class="form-control" name="exaction_selNatureUpd" id="exaction_selNatureUpd">
                                                                  <?php print $exaction->admin_cmb_show_cat($exaction->tbl_exactionNature, $exaction->fld_exactionNatureId, $tabExaction['NATURE']); ?>
                                                              </select>
                                                          </div>
                                                          <div class="col-sm-2">
                                                              <!-- <p class="help-block">Your help text!</p> -->
                                                          </div>
                                                      </div>
                                                  
                                                      <div class="form-group">    
                                                          <label class="col-sm-2 control-label" for="exaction_selTownUpd"><?php print $mod_lang_output['FORM_LABEL_EXACTION_TOWN']; ?></label>
                                                          <div class="col-sm-8">
                                                              <select class="form-control" name="exaction_selTownUpd" id="exaction_selTownUpd">
                                                                  <?php print print $exaction->cmb_load_exaction_place($tabExaction['TOWN']); ?>
                                                              </select>
                                                          </div>
                                                          <div class="col-sm-2">
                                                              <!-- <p class="help-block">Your help text!</p> -->
                                                          </div>
                                                      </div>
                                                  
                                                      <div class="form-group">
                                                          <label class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_PUB-DATE']; ?></label>
                                                          <div class="col-sm-8">
                                                              <?php print $exaction->combo_load_date_update($tabExaction['DATE'], 'Upd'); ?>
                                                          </div>
                                                          <div class="col-sm-2">
                                                              <!-- <p class="help-block">Your help text!</p> -->
                                                          </div>
                                                      </div>
                                                  
                                                      <div class="form-group">
                                                          <label class="col-sm-2 control-label" for="exaction_taVictimUpd"><?php print $mod_lang_output['FORM_LABEL_EXACTION_VICTIM']; ?></label>
                                                          <div class="col-sm-8">
                                                              <textarea style="width:100%;" name="exaction_taVictimUpd" cols="40" rows="3" id="exaction_taVictimUpd"><?php print $tabExaction['VICTIM']; ?></textarea>
                                                          </div>
                                                          <div class="col-sm-2">
                                                              <!-- <p class="help-block">Your help text!</p> -->
                                                          </div>
                                                      </div>
                                                  
                                                      <div class="form-group">
                                                          <label class="col-sm-2 control-label" for="exaction_taDescrUpd"><?php print $mod_lang_output['FORM_LABEL_EXACTION_DESCR']; ?></label>
                                                          <div class="col-sm-8">
                                                              <textarea style="width:100%;" name="exaction_taDescrUpd" cols="40" rows="5" id="exaction_taDescrUpd"><?php print $tabExaction['DESCR']; ?></textarea>
                                                          </div>
                                                          <div class="col-sm-2">
                                                              <!-- <p class="help-block">Your help text!</p> -->
                                                          </div>
                                                      </div>
                                                     
                                                      <div class="panel-footer">
                                                          <div class="row">
                                                              <div class="col-sm-8 col-sm-offset-2">
                                                                  <button type="submit" name="exaction_btnUpdate" id="exaction_btnUpdate" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE_EXACTION']; ?></button>
                                                                  <input type="hidden" name="exaction_hdUpdate" value="<?php print $tabExaction['ID']; ?>" />
                                                              </div>
                                                          </div>
                                                      </div>
                  
                                                  </form>
                                              </div>
                                          </div>
                                      </div> <!-- Fin Panel Body -->
                                  </div> <!-- Fin Panel  -->
                              <?php } ?>
                          <?php } ?>
                              
          
                          <!-- ****************************************** -->
                          
                          <!-- **********************  Exaction au detail ******************************** -->
                            <?php
                            if($_REQUEST['what'] == 'detail') {
                                $tab_exactionDetail =   $myExaction->get_exaction($_REQUEST[$myExaction->URI_exactionVar]);
                            ?>
                            <div class="xs">
                                <h3>
                                    <?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_EXACTION']; ?>
                                    <span style="float:right;">
                                        <a href="<?php print $myExaction->admin_modPage; ?>" title="<?php print $mod_lang_output['PAGE_HEADER_LIST_EXACTION']; ?>"><?php print $system->admin_button_crud('back'); ?></a>
                                        <a title="<?php print $mod_lang_output['FORM_BUTTON_ADD_EXACTION']; ?>" data-toggle="modal" data-target="#modal-exactionInsert"><?php print $system->admin_button_crud('create'); ?></a>
                                        <a title="<?php print $mod_lang_output['FORM_BUTTON_LIST_EXACTIONS']; ?>" data-toggle="modal" data-target="#modal-exactionDisplay"><?php print $system->admin_button_crud('read'); ?></a>
                                        <a title="<?php print $mod_lang_output['FORM_BUTTON_UPDATE_EXACTIONS'];?>" href="?page=exaction&what=update&action=update&<?php print $myExaction->URI_exactionVar; ?>=<?php print $_REQUEST[$myExaction->URI_exactionVar];?>"><?php print $myExaction->admin_button_crud('update'); ?></a>
                                    </span>
                                </h3>  
                                <div class="col-md-8">
                                    <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
                                        <div class="panel-body no-padding">
                                            <h4>
                                                <i class="fa fa-info-circle"></i>&nbsp;Detail de l'exaction
                                                <span style="float:right;">
                                                    <?php print $myExaction->admin_load_exaction_nav($_REQUEST[$myExaction->URI_exactionVar]); ?>
                                                </span>
                                            </h4>
                                            <p>&nbsp;</p>
                                            <hr />
                                            <h3><?php print $myExaction->get_exaction_type_by_id($tab_exactionDetail['TYPE']); ?></h3>
                                            <p><strong><u><i class="fa fa-map-marker"></i>&nbsp;Lieu de l'exaction :</u></strong> <?php print $myExaction->get_exaction_town_by_id($tab_exactionDetail['TOWN']); ?></p>
                                            <p><strong><u>Nature de l'exaction :</u></strong> <?php print $myExaction->get_exaction_nature_by_id($tab_exactionDetail['NATURE']); ?></p>
                                          
                                            <p><strong><u><i class="fa fa-accessible-icon"></i>&nbsp;Victime :</u></strong> <?php print $tab_exactionDetail['VICTIM']; ?></p>
                                            <p><strong><u><i class="fa fa-calendar"></i>&nbsp;Date :</u></strong> <?php print $myExaction->set_date_by_lang($tab_exactionDetail['DATE'], $_SESSION['LANG']); ?></p>
                                            <hr />
                                            <p style="font-weight:bold; text-decoration:underline;">Circonstances :</p>
                                            <p><?php print $tab_exactionDetail['DESCR']; ?></p>
                                            <p><hr /></p>
                                            <span style="float:right;">
                                                <?php print $myExaction->admin_load_exaction_nav($_REQUEST[$myExaction->URI_exactionVar]); ?>
                                            </span>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
                                        <div class="panel-body no-padding">
                                            <h4><i class="fa fa-paperclip"></i>&nbsp;Pieces jointes</h4>
                                            <hr />
                                            <?php print $myExaction->admin_load_exactions_pj($_REQUEST[$myExaction->URI_exactionVar]); ?>
                                            <a title="<?php print $mod_lang_output['FORM_BUTTON_ADD_EXACTION_PJ']; ?>" data-toggle="modal" data-target="#modal-exactionPjInsert"><?php print $system->admin_button_crud('create'); ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div> 
                            <?php      
                              }
                            ?>
                          
                          