<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://ljapps.com
 * @since      1.0.0
 *
 * @package    WP_TripAdvisor_Review
 * @subpackage WP_TripAdvisor_Review/admin/partials
 */
 
     // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
	$dbmsg = "";
	$html="";
	$currenttemplate= new stdClass();
	$currenttemplate->id="";
	$currenttemplate->title ="";
	$currenttemplate->template_type ="";
	$currenttemplate->style ="";
	$currenttemplate->created_time_stamp ="";
	$currenttemplate->display_num ="";
	$currenttemplate->display_num_rows ="";
	$currenttemplate->display_order ="";
	$currenttemplate->hide_no_text ="";
	$currenttemplate->template_css ="";
	$currenttemplate->min_rating ="";
	$currenttemplate->min_words ="";
	$currenttemplate->max_words ="";
	$currenttemplate->rtype ="";
	$currenttemplate->rpage ="";
	$currenttemplate->showreviewsbyid ="";
	$currenttemplate->createslider ="";
	$currenttemplate->numslides ="";
	$currenttemplate->sliderautoplay ="";
	$currenttemplate->sliderdirection ="";
	$currenttemplate->sliderarrows ="";
	$currenttemplate->sliderdots ="";
	$currenttemplate->sliderdelay ="";
	$currenttemplate->sliderheight ="";
	$currenttemplate->template_misc ="";
	$currenttemplate->read_more ="";
	$currenttemplate->read_more_text ="read more";
	
	
	//db function variables
	global $wpdb;
	$table_name = $wpdb->prefix . 'wptripadvisor_post_templates';
	
	//form deleting and updating here---------------------------
	if(isset($_GET['taction'])){
		$tid = htmlentities($_GET['tid']);
		$tid = intval($tid);
		//for deleting
		if($_GET['taction'] == "del" && $_GET['tid'] > 0){
			//security
			check_admin_referer( 'tdel_');
			//delete
			$wpdb->delete( $table_name, array( 'id' => $tid ), array( '%d' ) );
		}
		//for updating
		if($_GET['taction'] == "edit" && $_GET['tid'] > 0){
			//security
			check_admin_referer( 'tedit_');
			//get form array
			$currenttemplate = $wpdb->get_row( "SELECT * FROM ".$table_name." WHERE id = ".$tid );
		}
		
	}
	//------------------------------------------

	//form posting here--------------------------------
	//check to see if form has been posted.
	//if template id present then update database if not then insert as new.

	if (isset($_POST['wptripadvisor_submittemplatebtn'])){
		//verify nonce wp_nonce_field( 'wptripadvisor_save_template');
		check_admin_referer( 'wptripadvisor_save_template');

		//get form submission values and then save or update
		$t_id = htmlentities($_POST['edittid']);
		$title = htmlentities($_POST['wptripadvisor_template_title']);
		$template_type = htmlentities($_POST['wptripadvisor_template_type']);
		$style = htmlentities($_POST['wptripadvisor_template_style']);
		$display_num = htmlentities($_POST['wptripadvisor_t_display_num']);
		$display_num_rows = htmlentities($_POST['wptripadvisor_t_display_num_rows']);
		$display_order = htmlentities($_POST['wptripadvisor_t_display_order']);
		$hide_no_text = htmlentities($_POST['wptripadvisor_t_hidenotext']);
		$template_css = htmlentities($_POST['wptripadvisor_template_css']);
		
		$createslider = htmlentities($_POST['wptripadvisor_t_createslider']);
		$numslides = htmlentities($_POST['wptripadvisor_t_numslides']);
		
		$read_more = sanitize_text_field($_POST['wptripadvisor_t_read_more']);
		$read_more_text = sanitize_text_field($_POST['wptripadvisor_t_read_more_text']);

		
		//santize
		$title = sanitize_text_field( $title );
		$template_type = sanitize_text_field( $template_type );
		$display_order = sanitize_text_field( $display_order );
		$template_css = sanitize_text_field( $template_css );
		$display_order = sanitize_text_field( $display_order );

		
		//template misc
		$templatemiscarray = array();
		$templatemiscarray['showstars']=htmlentities($_POST['wptripadvisor_template_misc_showstars']);
		$templatemiscarray['verified']=htmlentities($_POST['wptripadvisor_template_misc_verified']);
		$templatemiscarray['showdate']=htmlentities($_POST['wptripadvisor_template_misc_showdate']);
		$templatemiscarray['bgcolor1']=htmlentities($_POST['wptripadvisor_template_misc_bgcolor1']);
		$templatemiscarray['bgcolor2']=htmlentities($_POST['wptripadvisor_template_misc_bgcolor2']);
		$templatemiscarray['tcolor1']=htmlentities($_POST['wptripadvisor_template_misc_tcolor1']);
		$templatemiscarray['tcolor2']=htmlentities($_POST['wptripadvisor_template_misc_tcolor2']);
		$templatemiscarray['tcolor3']=htmlentities($_POST['wptripadvisor_template_misc_tcolor3']);
		$templatemiscarray['bradius']=htmlentities($_POST['wptripadvisor_template_misc_bradius']);
		$templatemiscjson = json_encode($templatemiscarray);
		

		//only save if using pro version
			$min_rating = "";
			$min_words = "";
			$max_words = "";			
			$rtype = "";
			$rpage = "";
			$showreviewsbyid="";
			$sliderautoplay = "";
			$sliderdirection = "";
			$sliderarrows = "";
			$sliderdots = "";
			$sliderdelay = "";
			$sliderheight = "";
			
			$min_rating = sanitize_text_field($_POST['wptripadvisor_t_min_rating']);

		$timenow = time();
		
		//+++++++++need to sql escape using prepare+++++++++++++++++++
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++
		//insert or update
			$data = array( 
				'title' => "$title",
				'template_type' => "$template_type",
				'style' => "$style",
				'created_time_stamp' => "$timenow",
				'display_num' => "$display_num",
				'display_num_rows' => "$display_num_rows",
				'display_order' => "$display_order", 
				'hide_no_text' => "$hide_no_text",
				'template_css' => "$template_css", 
				'min_rating' => "$min_rating", 
				'min_words' => "$min_words",
				'max_words' => "$max_words",
				'rtype' => "$rtype", 
				'rpage' => "$rpage",
				'createslider' => "$createslider",
				'numslides' => "$numslides",
				'sliderautoplay' => "$sliderautoplay",
				'sliderdirection' => "$sliderdirection",
				'sliderarrows' => "$sliderarrows",
				'sliderdots' => "$sliderdots",
				'sliderdelay' => "$sliderdelay",
				'sliderheight' => "$sliderheight",
				'showreviewsbyid' => "$showreviewsbyid",
				'template_misc' => "$templatemiscjson",
				'read_more' => "$read_more",
				'read_more_text' => "$read_more_text"
				);
			$format = array( 
					'%s',
					'%s',
					'%d',
					'%d',
					'%d',
					'%d',
					'%s',
					'%s',
					'%s',
					'%d',
					'%d',
					'%d',
					'%s',
					'%s',
					'%s',
					'%d',
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
					'%s',
					'%s',
					'%s',
					'%s'
				); 

		if($t_id==""){
			//insert
			$wpdb->insert( $table_name, $data, $format );
				//exit( var_dump( $wpdb->last_error ) );
				//Print last SQL query string
				//$wpdb->last_query;
				// Print last SQL query result
				//$wpdb->last_result;
				// Print last SQL query Error
				//$wpdb->last_error;
		} else {
			//update
			$updatetempquery = $wpdb->update($table_name, $data, array( 'id' => $t_id ), $format, array( '%d' ));
			if($updatetempquery>0){
				$dbmsg = '<div id="setting-error-wptripadvisor_message" class="updated settings-error notice is-dismissible">'.__('<p><strong>Template Updated!</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>', 'wp-tripadvisor-review-slider').'</div>';
			}
		}
		
	}

	//Get list of all current forms--------------------------
	$currentforms = $wpdb->get_results("SELECT id, title, template_type, created_time_stamp, style FROM $table_name");
	
	//-------------------------------------------------------
	
	
	
	//check to see if reviews are in database
	//total number of rows
	$reviews_table_name = $wpdb->prefix . 'wptripadvisor_reviews';
	$reviewtotalcount = $wpdb->get_var( 'SELECT COUNT(*) FROM '.$reviews_table_name );
	if($reviewtotalcount<1){
		$dbmsg = $dbmsg . '<div id="setting-error-wptripadvisor_message" class="updated settings-error notice is-dismissible">'.__('<p><strong>No reviews found. Please visit the <a href="?page=wp_tripadvisor-get_tripadvisor">Get TripAdvisor Reviews</a> page to retrieve reviews from TripAdvisor.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>', 'wp-tripadvisor-review-slider').'</div>';
	}
	
	//add thickbox
	add_thickbox();
	
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


<div class="wptripadvisor_margin10">
	<a id="wptripadvisor_helpicon_posts" class="wptripadvisor_btnicononly button dashicons-before dashicons-editor-help"></a>
	<a id="wptripadvisor_addnewtemplate" class="button dashicons-before dashicons-plus-alt"><?php _e('Add New Reviews Template', 'wp-tripadvisor-review-slider'); ?></a>
</div>

<?php
//display message
echo $dbmsg;
		$html .= '
		<table class="wp-list-table widefat striped posts">
			<thead>
				<tr>
					<th scope="col" width="30px" class="manage-column">'.__('ID', 'wp-tripadvisor-review-slider').'</th>
					<th scope="col" class="manage-column">'.__('Title', 'wp-tripadvisor-review-slider').'</th>
					<th scope="col" width="180px" class="manage-column">'.__('Date Created', 'wp-tripadvisor-review-slider').'</th>
					<th scope="col" width="300px" class="manage-column">'.__('Action', 'wp-tripadvisor-review-slider').'</th>
				</tr>
				</thead>
			<tbody id="review_list">';
			
	$haswidgettemplate = false;	//for hiding widget type, going to be phasing widget types out.
	foreach ( $currentforms as $currentform ) 
	{
	//remove query args we just used
	$urltrimmed = remove_query_arg( array('taction', 'id') );
		$tempeditbtn =  add_query_arg(  array(
			'taction' => 'edit',
			'tid' => "$currentform->id",
			),$urltrimmed);
			
		$url_tempeditbtn = wp_nonce_url( $tempeditbtn, 'tedit_');
			
		$tempdelbtn = add_query_arg(  array(
			'taction' => 'del',
			'tid' => "$currentform->id",
			),$urltrimmed) ;
			
		$url_tempdelbtn = wp_nonce_url( $tempdelbtn, 'tdel_');
		
		if($currentform->template_type=='widget'){
			$haswidgettemplate = true;
		}
		
		$html .= '<tr id="'.$currentform->id.'">
				<th scope="col" class="wptripadvisor_upgrade_needed manage-column">'.$currentform->id.'</th>
				<th scope="col" class="wptripadvisor_upgrade_needed manage-column"><b>'.$currentform->title.'</b></th>
				<th scope="col" class="wptripadvisor_upgrade_needed manage-column">'.date("F j, Y",$currentform->created_time_stamp) .'</th>
				<th scope="col" class="manage-column" templateid="'.$currentform->id.'" templatetype="'.$currentform->template_type.'"><a href="'.$url_tempeditbtn.'" class="button button-primary dashicons-before dashicons-admin-generic">'.__('Edit', 'wp-tripadvisor-review-slider').'</a>, <a href="'.$url_tempdelbtn.'" class="button button-secondary dashicons-before dashicons-trash">'.__('Delete', 'wp-tripadvisor-review-slider').'</a>, <a class="wptripadvisor_displayshortcode button button-secondary dashicons-before dashicons-visibility">'.__('Shortcode', 'wp-tripadvisor-review-slider').'</a></th>
			</tr>';
	}	
		$html .= '</tbody></table>';
			
 echo $html;			
?>
<div class="wptripadvisor_margin10" id="wptripadvisor_new_template">
<form name="newtemplateform" id="newtemplateform" action="?page=wp_tripadvisor-templates_posts" method="post" onsubmit="return validateForm()">
	<table class="wptripadvisor_margin10 form-table ">
		<tbody>
			<tr class="wptripadvisor_row">
				<th scope="row">
					<?php _e('Template Title:', 'wp-tripadvisor-review-slider'); ?>
				</th>
				<td>
					<input id="wptripadvisor_template_title" data-custom="custom" type="text" name="wptripadvisor_template_title" placeholder="" value="<?php echo $currenttemplate->title; ?>" required>
					<p class="description">
					<?php _e('Enter a title or name for this template.', 'wp-tripadvisor-review-slider'); ?>		</p>
				</td>
			</tr>
			<tr  <?php if($haswidgettemplate==false){echo "style='display:none;'";} ?> class="wptripadvisor_row">
				<th scope="row">
					<?php _e('Choose Template Type:', 'wp-tripadvisor-review-slider'); ?>
				</th>
				<td><div id="divtemplatestyles">

					<input type="radio" name="wptripadvisor_template_type" id="wptripadvisor_template_type1-radio" value="post" checked="checked">
					<label for="wptripadvisor_template_type1-radio"><?php _e('Post or Page', 'wp-tripadvisor-review-slider'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

					<input type="radio" name="wptripadvisor_template_type" id="wptripadvisor_template_type2-radio" value="widget" <?php if($currenttemplate->template_type== "widget"){echo 'checked="checked"';}?>>
					<label for="wptripadvisor_template_type2-radio"><?php _e('Widget Area', 'wp-tripadvisor-review-slider'); ?></label>
					</div>
					<p class="description">
					<?php _e('Are you going to use this on a Page/Post or in a Widget area like your sidebar?', 'wp-tripadvisor-review-slider'); ?></p>
				</td>
			</tr>
			
			
			
<tr class="wptripadvisor_row">
				<th scope="row">
					<?php _e('Template Style Settings:', 'wp-tripadvisor-review-slider'); ?>
				</th>
				<td>
					<div class="w3_wprs-row">
						  <div class="w3_wprs-col s6">
							<div class="w3_wprs-col s6">
								<div class="wprevpre_temp_label_row">
								<?php _e('Template Style:', 'wp-tripadvisor-review-slider'); ?>
								</div>
								<div class="wprevpre_temp_label_row">
								<?php _e('Show Stars:', 'wp-tripadvisor-review-slider'); ?>
								</div>
								<div class="wprevpre_temp_label_row">
								<?php _e('Show Verified:', 'wp-tripadvisor-review-slider'); ?>
								</div>
								
								<div class="wprevpre_temp_label_row">
								<?php _e('Show Date:', 'wp-tripadvisor-review-slider'); ?>
								</div>
								<div class="wprevpre_temp_label_row">
								<?php _e('Border Radius:', 'wp-tripadvisor-review-slider'); ?>
								</div>
								<div class="wprevpre_temp_label_row">
								<?php _e('Background Color 1:', 'wp-tripadvisor-review-slider'); ?>
								</div>
								<div class="wprevpre_temp_label_row wprevpre_bgcolor2">
								<?php _e('Background Color 2:', 'wp-tripadvisor-review-slider'); ?>
								</div>
								<div class="wprevpre_temp_label_row">
								<?php _e('Text Color 1:', 'wp-tripadvisor-review-slider'); ?>
								</div>
								<div class="wprevpre_temp_label_row">
								<?php _e('Text Color 2:', 'wp-tripadvisor-review-slider'); ?>
								</div>
								<div class="wprevpre_temp_label_row wprevpre_tcolor3">
								<?php _e('Text Color 3:', 'wp-tripadvisor-review-slider'); ?>
								</div>
							</div>
							<div class="w3_wprs-col s6">
								<div class="wprevpre_temp_label_row">
									<select name="wptripadvisor_template_style" id="wptripadvisor_template_style">
									  <option value="1" <?php if($currenttemplate->style=='1' || $currenttemplate->style==""){echo "selected";} ?>><?php _e('Style 1', 'wp-tripadvisor-review-slider'); ?></option>
									</select>
								</div>
				<?php
				//echo $currenttemplate->template_misc;
				$template_misc_array = json_decode($currenttemplate->template_misc, true);
				if(!is_array($template_misc_array)){
					$template_misc_array=array();
					$template_misc_array['showstars']="";
					$template_misc_array['showdate']="";
					$template_misc_array['bgcolor1']="";
					$template_misc_array['bgcolor2']="";
					$template_misc_array['tcolor1']="";
					$template_misc_array['tcolor2']="";
					$template_misc_array['tcolor3']="";
					$template_misc_array['bradius']="0";
				}
				if(!isset($template_misc_array['verified'])){
					$template_misc_array['verified']="";
				}
				?>
								<div class="wprevpre_temp_label_row">
									<select name="wptripadvisor_template_misc_showstars" id="wptripadvisor_template_misc_showstars">
									  <option value="yes" <?php if($template_misc_array['showstars']=='yes'){echo "selected";} ?>>Yes</option>
									  <option value="no" <?php if($template_misc_array['showstars']=='no'){echo "selected";} ?>>No</option>
									</select>
								</div>
								<div class="wprevpre_temp_label_row">
									<select name="wptripadvisor_template_misc_verified" id="wptripadvisor_template_misc_verified">
										<option value="no" <?php if($template_misc_array['verified']=='no' || $template_misc_array['verified']==''){echo "selected";} ?>><?php _e('No', 'wp-tripadvisor-review-slider'); ?></option>
										<option value="yes1" <?php if($template_misc_array['verified']=='yes1'){echo "selected";} ?>><?php _e('Yes', 'wp-tripadvisor-review-slider'); ?></option>
									</select>
								</div>
								<div class="wprevpre_temp_label_row">
									<select name="wptripadvisor_template_misc_showdate" id="wptripadvisor_template_misc_showdate">
									  <option value="yes" <?php if($template_misc_array['showdate']=='yes'){echo "selected";} ?>>Yes</option>
									  <option value="no" <?php if($template_misc_array['showdate']=='no'){echo "selected";} ?>>No</option>
									</select>
								</div>
								<div class="wprevpre_temp_label_row">
									<input id="wptripadvisor_template_misc_bradius" type="number" min="0" name="wptripadvisor_template_misc_bradius" placeholder="" value="<?php echo $template_misc_array['bradius']; ?>" style="width: 4em">
								</div>
								<div class="wprevpre_temp_label_row">
									<input type="text" data-alpha="true" value="<?php echo $template_misc_array['bgcolor1']; ?>" name="wptripadvisor_template_misc_bgcolor1" id="wptripadvisor_template_misc_bgcolor1" class="my-color-field" />
								</div>
								<div class="wprevpre_temp_label_row wprevpre_bgcolor2">
									<input type="text" data-alpha="true" value="<?php echo $template_misc_array['bgcolor2']; ?>" name="wptripadvisor_template_misc_bgcolor2" id="wptripadvisor_template_misc_bgcolor2" class="my-color-field" />
								</div>
								<div class="wprevpre_temp_label_row">
									<input type="text" value="<?php echo $template_misc_array['tcolor1']; ?>" name="wptripadvisor_template_misc_tcolor1" id="wptripadvisor_template_misc_tcolor1" class="my-color-field" />
								</div>
								<div class="wprevpre_temp_label_row">
									<input type="text" value="<?php echo $template_misc_array['tcolor2']; ?>" name="wptripadvisor_template_misc_tcolor2" id="wptripadvisor_template_misc_tcolor2" class="my-color-field" />
								</div>
								<div class="wprevpre_temp_label_row wprevpre_tcolor3">
									<input type="text" value="<?php echo $template_misc_array['tcolor3']; ?>" name="wptripadvisor_template_misc_tcolor3" id="wptripadvisor_template_misc_tcolor3" class="my-color-field" />
								</div>
								
								
								<a id="wptripadvisor_pre_resetbtn" class="button"><?php _e('Reset Colors', 'wp-tripadvisor-review-slider'); ?></a>
							</div>
						  </div>
						  <div class="w3_wprs-col s6" id="wptripadvisor_template_preview">

						  </div>
					</div>
					<p class="description">
					<?php _e('More styles available in <a href="https://wpreviewslider.com/" target="blank">Pro Version</a> of plugin!', 'wp-tripadvisor-review-slider'); ?></p>
				</td>
			</tr>
			<tr class="wptripadvisor_row">
				<th scope="row">
					<?php _e('Custom CSS:', 'wp-tripadvisor-review-slider'); ?>
				</th>
				<td>
					<textarea name="wptripadvisor_template_css" id="wptripadvisor_template_css" cols="50" rows="4"><?php echo $currenttemplate->template_css; ?></textarea>
					<p class="description">
					<?php _e('Enter custom CSS code to change the look of the template when being displayed. ex: </br>.wptripadvisor_t1_outer_div {
						background: #e4e4e4;
					}', 'wp-tripadvisor-review-slider'); ?></p>
				</td>
			</tr>			

			<tr class="wptripadvisor_row">
				<th scope="row">
					<?php _e('Number of Reviews:', 'wp-tripadvisor-review-slider'); ?>
				</th>
				<td><div class="divtemplatestyles">
					<label for="wptripadvisor_t_display_num"><?php _e('How many per a row?', 'wp-tripadvisor-review-slider'); ?></label>
					<select name="wptripadvisor_t_display_num" id="wptripadvisor_t_display_num">
					  <option value="1" <?php if($currenttemplate->display_num==1){echo "selected";} ?>>1</option>
					  <option value="2" <?php if($currenttemplate->display_num==2){echo "selected";} ?>>2</option>
					  <option value="3" <?php if($currenttemplate->display_num==3 || $currenttemplate->display_num==""){echo "selected";} ?>>3</option>
					  <option value="4" <?php if($currenttemplate->display_num==4){echo "selected";} ?>>4</option>
					</select>
					
					<label for="wptripadvisor_t_display_num_rows"><?php _e('How many total rows?', 'wp-tripadvisor-review-slider'); ?></label>
					<input id="wptripadvisor_t_display_num_rows" type="number" name="wptripadvisor_t_display_num_rows" placeholder="" value="<?php if($currenttemplate->display_num_rows>0){echo $currenttemplate->display_num_rows;} else {echo "1";}?>">
					
					</div>
					<p class="description">
					<?php _e('How many reviews to display on the page at a time.', 'wp-tripadvisor-review-slider'); ?></p>
				</td>
			</tr>
			
			<tr class="wptripadvisor_row">
				<th scope="row">
					<?php _e('Display Order:', 'wp-tripadvisor-review-slider'); ?>
				</th>
				<td>
					<select name="wptripadvisor_t_display_order" id="wptripadvisor_t_display_order">
						<option value="random" <?php if($currenttemplate->display_order=="random"){echo "selected";} ?>><?php _e('Random', 'wp-tripadvisor-review-slider'); ?></option>
						<option value="newest" <?php if($currenttemplate->display_order=="newest"){echo "selected";} ?>><?php _e('Newest', 'wp-tripadvisor-review-slider'); ?></option>
					</select>
					<p class="description">
					<?php _e('The order in which the reviews are displayed.', 'wp-tripadvisor-review-slider'); ?></p>
				</td>
			</tr>
			<tr class="wptripadvisor_row">
				<th scope="row">
					<?php _e('Hide Reviews Without Text:', 'wp-tripadvisor-review-slider'); ?>
				</th>
				<td>
					<select name="wptripadvisor_t_hidenotext" id="wptripadvisor_t_hidenotext">
						<option value="yes" <?php if($currenttemplate->hide_no_text=="yes"){echo "selected";} ?>><?php _e('Yes', 'wp-tripadvisor-review-slider'); ?></option>
						<option value="no" <?php if($currenttemplate->hide_no_text=="no"){echo "selected";} ?>><?php _e('No', 'wp-tripadvisor-review-slider'); ?></option>
					</select>
					<p class="description">
					<?php _e('Set to Yes and only display reviews that have text included.', 'wp-tripadvisor-review-slider'); ?></p>
				</td>
			</tr>
			<?php
			if(!isset($currenttemplate->min_rating)){
				$currenttemplate->min_rating==1;
			}
			
			?>
			<tr class="wptripadvisor_row">
				<th scope="row">
					<?php _e('Filter By Rating:', 'wp-google-reviews'); ?>
				</th>
				<td>
					<select name="wptripadvisor_t_min_rating" id="wptripadvisor_t_min_rating">
					  <option value="1" <?php if($currenttemplate->min_rating==1){echo "selected";} ?>><?php _e('Show All', 'wp-google-reviews'); ?></option>
					  <option value="2" <?php if($currenttemplate->min_rating==2){echo "selected";} ?>><?php _e('2 & Higher', 'wp-google-reviews'); ?></option>
					  <option value="3" <?php if($currenttemplate->min_rating==3){echo "selected";} ?>><?php _e('3 & Higher', 'wp-google-reviews'); ?></option>
					  <option value="4" <?php if($currenttemplate->min_rating==4){echo "selected";} ?>><?php _e('4 & Higher', 'wp-google-reviews'); ?></option>
					  <option value="5" <?php if($currenttemplate->min_rating==5){echo "selected";} ?>><?php _e('Only 5 Star', 'wp-google-reviews'); ?></option>
					</select>
					<p class="description">
					<?php _e('Show only reviews with at least this value rating. Allows you to hide low reviews.', 'wp-tripadvisor-review-slider'); ?></p>
				</td>
			</tr>

			<tr class="wptripadvisor_row">
				<th scope="row">
					<?php _e('Create Slider:', 'wp-tripadvisor-review-slider'); ?>
				</th>
				<td>
					<div class="divtemplatestyles">
						<label for="wptripadvisor_t_createslider"><?php _e('Display reviews in slider?', 'wp-tripadvisor-review-slider'); ?></label>
						<select name="wptripadvisor_t_createslider" id="wptripadvisor_t_createslider">
							<option value="no" <?php if($currenttemplate->createslider=="no"){echo "selected";} ?>><?php _e('No', 'wp-tripadvisor-review-slider'); ?></option>
							<option value="yes" <?php if($currenttemplate->createslider=="yes"){echo "selected";} ?>><?php _e('Yes', 'wp-tripadvisor-review-slider'); ?></option>
						</select>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label for="wptripadvisor_t_display_num_rows"><?php _e('How many total slides?', 'wp-tripadvisor-review-slider'); ?></label>
						<select name="wptripadvisor_t_numslides" id="wptripadvisor_t_numslides">
							<option value="2" <?php if($currenttemplate->numslides=="2"){echo "selected";} ?>>2</option>
							<option value="3" <?php if($currenttemplate->numslides=="3"){echo "selected";} ?>>3</option>
							<option value="4" <?php if($currenttemplate->numslides=="4"){echo "selected";} ?>>4</option>
							<option value="5" <?php if($currenttemplate->numslides=="5"){echo "selected";} ?>>5</option>
							<option value="6" <?php if($currenttemplate->numslides=="6"){echo "selected";} ?>>6</option>
							<option value="7" <?php if($currenttemplate->numslides=="7"){echo "selected";} ?>>7</option>
							<option value="8" <?php if($currenttemplate->numslides=="8"){echo "selected";} ?>>8</option>
							<option value="9" <?php if($currenttemplate->numslides=="9"){echo "selected";} ?>>9</option>
							<option value="10" <?php if($currenttemplate->numslides=="10"){echo "selected";} ?>>10</option>
						</select>
					
					</div>
					<p class="description">
					<?php _e('Allows you to create a slide show with your reviews.', 'wp-tripadvisor-review-slider'); ?></p>
				</td>
			</tr>
			<?php
			if(!isset($currenttemplate->read_more)){
				$currenttemplate->read_more='';
				$currenttemplate->read_more_text='';
			}
			?>
			
			<tr class="wptripadvisor_row">
				<th scope="row">
					<?php _e('Add Read More Link:', 'wp-tripadvisor-review-slider'); ?>
				</th>
				<td><div class="divtemplatestyles">
					<label for="wptripadvisor_t_read_more"><?php _e('', 'wp-tripadvisor-review-slider'); ?></label>
					<select name="wptripadvisor_t_read_more" id="wptripadvisor_t_read_more" class="mt2">
						<option value="no" <?php if($currenttemplate->read_more=='no'){echo "selected";} ?>>No</option>
						<option value="yes" <?php if($currenttemplate->read_more=='yes' || $currenttemplate->read_more==''){echo "selected";} ?>>Yes</option>
					</select>
					<label for="wptripadvisor_t_read_more_text">&nbsp;&nbsp;<?php _e('Read More Text:', 'wp-tripadvisor-review-slider'); ?></label>
					<input id="wptripadvisor_t_read_more_text" type="text" name="wptripadvisor_t_read_more_text" placeholder="read more" value="<?php if($currenttemplate->read_more_text!=''){echo $currenttemplate->read_more_text;} else {echo "read more";}?>" style="width: 6em">
					</div>
					<p class="description">
					<?php _e('Allows you to cut off long reviews and add a read more link that will show the rest of the review when clicked.', 'wp-tripadvisor-review-slider'); ?></p>
				</td>
			</tr>

			<tr>
				<td class="notice updated " colspan="2" style="border-left: 4px solid #d6d6d6;">
					<p><strong><?php _e('Upgrade to the <a href="https://wpreviewslider.com/">Pro Version</a> of this plugin to access more super cool settings!', 'wp-tripadvisor-review-slider'); ?></strong></p>
				</td>
			</tr>

			
		</tbody>
	</table>
	<?php 
	//security nonce
	wp_nonce_field( 'wptripadvisor_save_template');
	?>
	<input type="hidden" name="edittid" id="edittid"  value="<?php echo $currenttemplate->id; ?>">
	<input type="submit" name="wptripadvisor_submittemplatebtn" id="wptripadvisor_submittemplatebtn" class="button button-primary" value="<?php _e('Save Template', 'wp-tripadvisor-review-slider'); ?>">
	<a id="wptripadvisor_addnewtemplate_cancel" class="button button-secondary"><?php _e('Cancel', 'wp-tripadvisor-review-slider'); ?></a>
	</form>
</div>
<div class=""><p>Do you like this plugin? If so please take a moment to leave me a review <a href="https://wordpress.org/plugins/wp-tripadvisor-review-slider/" target="blank">here!</a> If it's missing something then please contact me <a href="https://wpreviewslider.com/contact/" target="blank">here</a>. Thanks!</p></div>

</div></div></div>
	
<div id="popup_review_list" class="popup-wrapper wptripadvisor_hide">
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
</div>

<div id="mythickboxid" style="display:none;">
     <p>
         <img src="<?php echo plugin_dir_url( __FILE__ ); ?>pro_settings.png">
     </p>
</div>