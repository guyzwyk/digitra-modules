<!-- ************ Annonce global list in modal ************ -->
		<div tabindex='-1' class='modal fade' id='modal-annonceDisplay' role='dialog' aria-hidden='true' aria-labelledby='modal-annonceDisplayLabel' style='display: none;'>
			<div class='modal-dialog' style="width:95%;">

				<div class='modal-content' style="background-color:#eee;">
					
					<div class='modal-header'>
						<button class='close' aria-hidden='true' type='button' data-dismiss='modal'>x</button>
						<h2 class='modal-title'><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_ANNONCE']; ?></h2>
					</div>

					<div class='modal-body'>
						<?php print $annonce->admin_load_annonces(3000); ?>
					</div>

					<div class='modal-footer'>
						<button class='btn btn-default' type='button' data-dismiss='modal'>Close</button>
					</div>

				</div>

			</div>
		</div>
		<!-- Fix the Modal  -->
		<?php if(isset($_REQUEST['action'])) { ?>
        	<script> $('a[data-target="#modal-annonceDisplay"]').click(); </script>
    	<?php } ?>
	`	<!-- ****************************************** -->