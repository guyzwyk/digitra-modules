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
						{$s_frmMsgDisplay}
						<form method="POST" name="frm_send">
						<table class="form-contact">
							<tr>
								<th class="frmLabel">{$s_lbl_contact_firstName}<span class="errorRed">*</span> :</th>
								<td><input name="txtFirstName" type="text" class="input_text" id="txtFirstName" value="{$s_validateFirstName}" /></td>
							</tr>
							<tr>
								<th class="frmLabel">{$s_lbl_contact_lastName}<span class="errorRed">*</span> : </th>
								<td><input name="txtLastName" type="text" class="input_text" id="txtLastName" value="{$s_validateLastName}" /></td>
							</tr>
							<tr>
								<th class="frmLabel">{$s_lbl_contact_email}<span class="errorRed">*</span> :</th>
								<td><input name="txtEmail" type="text" class="input_text" id="txtEmail" value="{$s_validateEmail}" /></td>
							</tr>
							<tr>
								<th class="frmLabel">{$s_lbl_contact_phone1} :</th>
								<td><input name="txtPhone1" type="text" class="input_text" id="txtPhone1" value="{$s_validatePhone1}" size="20" /></td>
							</tr>
							<tr>
								<th class="frmLabel">{$s_lbl_contact_phone2} :</th>
								<td><input name="txtPhone2" type="text" class="input_text" id="txtPhone2" value="{$s_validatePhone2}" size="20" /></td>
							</tr>
							<tr>
								<th class="frmLabel">{$s_lbl_contact_webSite} :</th>
								<td>
									<input name="txtWebSite" type="text" class="input_text" id="txtWebSite" value="{$s_validateWebSite}" />					</td>
							</tr>
							<tr>
								<th class="frmLabel">{$s_lbl_contact_country} :</th>
								<td>
									<select name="selCountry">
										<option>{$s_lbl_contact_country}</option>
											{$s_loadCountry}
										</select>
								</td>
							</tr>
							<tr>
								<th class="frmLabel">{$s_lbl_contact_other} <span class="errorRed">*</span> :</th>
								<td valign="top"><textarea name="taOther" cols="40" rows="7">{$s_validateOther}</textarea><span class="errorRed">*</span></td>
							</tr>
							<tr>
								<th class="frmLabel">{$s_lbl_captcha}<span class="errorRed"> *</span> : </th>
								<td>
									<img src="plugins/captcha/captcha.php" /><br />
									<input style="font-family:'Comic Sans MS', 'Times New Roman', Times, serif; width:144px; height:40px; font-size:180%; font-weight:bold;" size="5" name="security_code" type="text" value="{$s_captcha_textbox_lbl}" onclick="this.value=''" />
								</td>
							</tr>
							<tr>
								<td align="right" valign="top">&nbsp;</td>
								<td><input type="submit" name="btnSend" onclick="return confirm('{$s_lbl_contact_confirm}')" value="{$s_lbl_contact_send}" />
									<input type="hidden" name="hdAdmin" value="0" />
								</td>
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
					{$s_modSecondaryMenu}
					{$s_newsLast}
					{*$s_annonceLast*}
					{$s_bannerRight}
				</div>
			</div>
			<div class="clrBoth"></div>
		</div>
	</div>
<!--  // End of body -->
{include file='footer.tpl'}	