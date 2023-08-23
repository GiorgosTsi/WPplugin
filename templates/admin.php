<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

<div class="wrap">
	<h1>Giorghs Plugin</h1>

	<?php
		// WP method to print if save is ok or no  
		settings_errors(); 
	?>


	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Manage Settings</a></li>
		<li><a href="#tab-2">Updates</a></li>
		<li><a href="#tab-3">About</a></li>
	</ul>


	<div class="tab-content">
		
		<div id="tab-1" class="tab-pane active">

			<form method="post" action="options.php">
				<?php 
										/*Use built in WP methods to print the section and the fields: */

					settings_fields( 'giorghs_option_group' );//pass the option group

					do_settings_sections( 'giorghs_plugin' );//pass the slug of the main page

					submit_button(); //create submit button for save settings.
				?>
			</form>
		</div>


		<div id="tab-2" class="tab-pane">
				<h3>Updates</h3>
		</div>

		<div id="tab-3" class="tab-pane">
				<h3>About</h3>
		</div>

	</div>

</div>

</body>
</html>