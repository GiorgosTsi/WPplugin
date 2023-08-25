<div class="wrap">
	<h1>CPT Manager</h1>
	<?php settings_errors(); ?>

	<form method="post" action="options.php">
		<?php 
			settings_fields( 'giorghs_plugin_cpt_settings' ); //option group
			do_settings_sections( 'giorghs_cpt' );//main page slug
			submit_button();
		?>
	</form>
</div>