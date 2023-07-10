<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_TripAdvisor_Review
 * @subpackage WP_TripAdvisor_Review/admin/partials
 */
 
     // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
	
	    // wordpress will add the "settings-updated" $_GET parameter to the url
		//https://freegolftracker.com/blog/wp-admin/admin.php?settings-updated=true&page=wp_tripadvisor-reviews
    if (isset($_GET['settings-updated'])) {
        // add settings saved message with the class of "updated"
        add_settings_error('tripadvisor-radio', 'wptripadvisor_message', __('Settings Saved', 'wp-tripadvisor-review-slider'), 'updated');
    }

	if(isset($this->errormsg)){
		add_settings_error('tripadvisor-radio', 'wptripadvisor_message', __($this->errormsg, 'wp-tripadvisor-review-slider'), 'error');
	}
?>

<div class="">
<h1></h1>
<div class="wrap" id="wp_rev_maindiv">

<img class="wprev_headerimg" src="<?php echo plugin_dir_url( __FILE__ ) . 'logo.png?v='.$this->version; ?>">
<?php 
include("tabmenu.php");
?>	
	<div class="wpfbr_margin10">
		<div class="w3-col welcomediv w3-container w3-white w3-border w3-border-light-gray2 w3-round-small">

			<p>
				Note:
				<br>- The free version does not currently work for Vacation Rentals.

			</p>

			<form action="options.php" method="post">
				<?php
				// output security fields for the registered setting "wp_tripadvisor-get_tripadvisor"
				settings_fields('wp_tripadvisor-get_tripadvisor');
				// output setting sections and their fields
				// (sections are registered for "wp_tripadvisor-get_tripadvisor", each field is registered to a specific section)
				do_settings_sections('wp_tripadvisor-get_tripadvisor');
				// output save settings button
				submit_button('Save Settings & Download');
				?>
				<div id="buttonloader" style="display:none;margin-top: -20px;" class="wprevloader triploader"></div>
				<p><b>The Pro version can download all your reviews with avatars from multiple locations and check for new reviews daily!</b></p>
			</form>
			<?php 
				// show error/update messages
				settings_errors('tripadvisor-radio');
		?>

		</div>
	</div>
	</div>
	</div>

	<div id="popup_info" class="popup-wrapper wptripadvisor_hide">
	  <div class="popup-content">
		<div class="popup-title">
		  <button type="button" class="popup-close">&times;</button>
		  <h3 id="popup_titletext"></h3>
		</div>
		<div class="popup-body">
		  <div id="popup_bobytext1"></div>
		  <div id="popup_bobytext2"></div>
		</div>
	  </div>
	</div>
	

