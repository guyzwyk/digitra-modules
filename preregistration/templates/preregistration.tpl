{include file='header.tpl'}
<div id="cwdv4_main">
  	<div id="cwdv4_medCol">
  		{$s_bannerTop}
  		<div id="cwdv4_navbar"><p>{$s_pagePathWay}</p></div>
  		<h1>{$s_pageTitle}</h1>
		{$s_pageContent}
			  {$s_frmMsgDisplay}
			  <form method="POST" enctype="multipart/form-data" name="frm_send">
<table class="form" width="100%" cellspacing="2" cellpadding="2">
			                  <tr>
			                    <th class="frmLabel">{$s_lbl_preg_firstName} :</th>
			                    <td>
			                    	<input name="txtFirstName" type="text" class="input_text" id="txtFirstName" value="{$s_validateFirstName}" />
			                    </td>
			                  </tr>
			                  <tr>
			                    <th class="frmLabel">{$s_lbl_preg_lastName} <span class="errorRed">*</span> : </th>
			                    <td><input name="txtLastName" type="text" class="input_text" id="txtLastName" value="{$s_validateLastName}" />
			                    <span class="errorRed">*</span></td>
			                  </tr>
			                  <tr>
			                    <th class="frmLabel">{$s_lbl_preg_city} <span class="errorRed">*</span> : </th>
			                    <td><input name="txtCity" type="text" class="input_text" id="txtCity" value="{$s_validateCity}" />
		                        <span class="errorRed"> *</span></td>
        </tr>
			                  <tr>
			                    <th class="frmLabel">{$s_lbl_preg_country}<span class="errorRed"> *</span> :</th>
			                    <td>
			                    	<select name="selCountry">
                                  		<option value="">{$s_lbl_preg_chooseCountry}</option>
										{$s_loadCountry}
		                        	</select>
		                        <span class="errorRed">*</span></td>
        </tr>
			                  <tr>
			                    <th class="frmLabel">{$s_lbl_preg_iaiCenter}<span class="errorRed"> *</span> :</th>
			                    <td>
	                                <select name="selCenter" id="sel_iaiCenter">
	                                	<option value="">{$s_lbl_preg_chooseCenter}</option>
										{$s_loadCenters}
	                                </select>
                                <span class="errorRed"> *</span></td>
        </tr>
			                  <tr>
			                    <th class="frmLabel">{$s_lbl_preg_iaiContest} <span class="errorRed">*</span> :</th>
			                    <td>
				                    <select name="selContest" id="sel_iaiContest">
				                    	<option value="">{$s_lbl_preg_chooseContest}</option>
										{$s_loadContests}
	                                </select>
                                <span class="errorRed"> *</span></td>
        </tr>
			                  <tr>
			                    <th class="frmLabel">{$s_lbl_preg_email}<span class="errorRed"> *</span> :</th>
			                    <td><input name="txtEmail" type="text" class="input_text" id="txtEmail" value="{$s_validateEmail}" />
		                        <span class="errorRed"> *</span></td>
        </tr>
			                  <tr>
			                    <th class="frmLabel">{$s_lbl_preg_fPhone} :</th>
			                    <td>
			                      <input name="txtPhone1" type="text" class="input_text" id="txtPhone1" value="{$s_validatePhone1}" maxlength="20" />&nbsp;&nbsp;<em>(Ex : +237 2220 1031)</em>
			                    </td>
			                  </tr>
			                  <tr>
			                    <th class="frmLabel">{$s_lbl_preg_mPhone} <span class="errorRed">*</span> :</th>
			                    <td><input name="txtPhone2" type="text" class="input_text" id="txtPhone2" value="{$s_validatePhone2}" maxlength="20" />
                                  <span class="errorRed">*</span>&nbsp;&nbsp;<em>(Ex : +237 9998 1031)</em></td>
			                  </tr>
			                  <tr>
			                    <th class="frmLabel">{$s_lbl_preg_pobox}<span class="errorRed"> *</span> :</th>
			                    <td><input name="txtAdress" type="text" class="input_text" id="txtAdress" value="{$s_validateAdress}" maxlength="20" />
		                        <span class="errorRed">*</span></td>
			                  </tr>
			                  <tr>
			                    <th class="frmLabel">{$s_lbl_preg_lastDiploma}<span class="errorRed"> * </span>:</th>
			                    <td><input name="txt_lastDiploma" type="text" class="input_text" id="txt_lastDiploma" value="{$s_validateLastDiploma}" />
		                        <span class="errorRed">*</span></td>
			                  </tr>
			                  
							  <tr>
			                    <th class="frmLabel">{$s_lbl_preg_photo}<span class="errorRed">*</span> :</th>
			                    <td valign="top"><span class="errorRed">
			                      <input type="file" name="selPhoto" id="selPhoto" />
		                        *</span>&nbsp;&nbsp;<em>(Gif, Jpg, Png : 150 Ko Max.)</em></td>
        </tr>
							  <tr>
			                    <td align="right" valign="top">&nbsp;</td>
			                    <td>
			                    	<input name="btnOk" type="submit" id="btnOk" onclick="return confirm('{$s_lbl_preg_confirm}')" value="{$s_lbl_preg_okBtn}" />
			                    </td>
			                  </tr>
			                </table>
      </form>
	  <div class="cwdv4_clearboth"></div>
  	</div>
  	<div id="cwdv4_rightCol">
  		<div class="cwdv4_innerContent">
  			<ul>
  				{$s_pageSecondaryMenu}
  			</ul>
  		</div>
  		<div class="cwdv4_clearboth" style="padding-bottom: 3px;"></div>
  		<div class="cwdv4_innerContent">
  		{$s_newsLast}
  		</div>
  		<div class="cwdv4_clearboth"></div>
  		<div class="cwdv4_clearboth" style="padding-bottom: 3px;"></div>
  		<div class="cwdv4_innerContent">
  			{$s_annonceLast}
  			{$s_bannerRight}
	  </div>
  	</div>
  	<div class="cwdv4_clearboth"></div>
  </div>
  <div class="cwdv4_clearboth"></div>
{include file='footer.tpl'}	