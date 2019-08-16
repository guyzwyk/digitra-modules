{include file='header.tpl'}
<!-- Body starts -->
		<div class="page_body page_grid">
		
			<div class="section group">
			
				<div class="col span_9_of_12">
					<div class="pageRow pageInner">
						{$s_bannerTop}
		  				{$s_pagePathWay}
		  				<h1>{$s_pageTitle}</h1>
			  			{eval assign='scriptPage' var=$s_pageContent|extractBetween:$s_pageLang}
						{$scriptPage}
						
						<fieldset class="fieldset">
					  		<legend>{$s_frmMsgFrame}</legend>
					  		{$s_frmBookMsgDisplay}
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
				                    	<th class="frmLabel">{$s_lbl_itw_captcha}<span class="errorRed"> *</span> : </th>
				                       	<td>
				                       		<img src="plugins/captcha/captcha.php" /><br />
								  			<input style="font-family:'Comic Sans MS', 'Times New Roman', Times, serif; width:144px; height:40px; font-size:180%; font-weight:bold;" size="5" name="security_code" type="text" value="{$s_captcha_textbox_lbl}" onclick="this.value=''" />
								  	 	</td>
				                    </tr>
									<tr>
					                   	<td align="right" valign="top">&nbsp;</td>
					                   	<td><input type="submit" name="btn_itwBook" onclick="return confirm('{$s_lbl_itw_book_confirm}')" value="{$s_lbl_itw_btn_ok}" /></td>
					                </tr>
					            </table>
					        </form>
					  	</fieldset>
						
						{if isset($smarty.get.view)}
							{$s_bannerBottom}
						{/if}
			  			<div class="clearBoth"></div>
					</div>
				</div>
				
				<div class="col span_3_of_12 page_sideCol">
					<div class="pageRow">
						{$s_pageSecondaryMenu}
						{$s_newsLast}
						{*$s_annonceLast*}
						{$s_bannerRight}
					</div>
				</div>
				
			</div>
			
		</div>
<!--  // End of body -->
{include file='footer.tpl'}	