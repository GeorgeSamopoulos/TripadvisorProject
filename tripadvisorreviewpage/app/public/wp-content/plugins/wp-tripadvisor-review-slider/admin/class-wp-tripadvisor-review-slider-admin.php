<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_TripAdvisor_Review
 * @subpackage WP_TripAdvisor_Review/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hookfs for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_TripAdvisor_Review
 * @subpackage WP_TripAdvisor_Review/admin
 * @author     Your Name <email@example.com>
 */
class WP_TripAdvisor_Review_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugintoken    The ID of this plugin.
	 */
	private $plugintoken;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugintoken       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugintoken, $version ) {

		$this->_token = $plugintoken;
		//$this->version = $version;
		//for testing==============
		$this->version = time();
		//===================
				

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_TripAdvisor_Review_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_TripAdvisor_Review_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		//only load for this plugin wp_tripadvisor-settings-pricing
		if(isset($_GET['page'])){
			if($_GET['page']=="wp_tripadvisor-reviews" || $_GET['page']=="wp_tripadvisor-templates_posts" || $_GET['page']=="wp_tripadvisor-get_tripadvisor" || $_GET['page']=="wp_tripadvisor-get_pro" || $_GET['page']=="wp_tripadvisor-welcome"){

			wp_register_style( 'Font_Awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
			wp_enqueue_style('Font_Awesome');
				
				wp_enqueue_style( $this->_token."_wprev_w3", plugin_dir_url( __FILE__ ) . 'css/wprev_w3.css', array(), $this->version, 'all' );

			wp_enqueue_style( $this->_token, plugin_dir_url( __FILE__ ) . 'css/wptripadvisor_admin.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->_token."_wptripadvisor_w3", plugin_dir_url( __FILE__ ) . 'css/wptripadvisor_w3.css', array(), $this->version, 'all' );
			}
			//load template styles for wp_tripadvisor-templates_posts page
			if($_GET['page']=="wp_tripadvisor-templates_posts"|| $_GET['page']=="wp_tripadvisor-get_pro" || $_GET['page']=="wp_tripadvisor-welcome"){
				//enque template styles for preview
				wp_enqueue_style( $this->_token."_style1", plugin_dir_url(dirname(__FILE__)) . 'public/css/wprev-public_template1.css', array(), $this->version, 'all' );
			}
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_TripAdvisor_Review_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_TripAdvisor_Review_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		

		//scripts for all pages in this plugin
		if(isset($_GET['page'])){
			if($_GET['page']=="wp_tripadvisor-reviews" || $_GET['page']=="wp_tripadvisor-templates_posts" || $_GET['page']=="wp_tripadvisor-get_tripadvisor" || $_GET['page']=="wp_tripadvisor-get_pro"){
				//pop-up script
				wp_register_script( 'simple-popup-js',  plugin_dir_url( __FILE__ ) . 'js/wptripadvisor_simple-popup.min.js' , '', $this->version, false );
				wp_enqueue_script( 'simple-popup-js' );
				
			}
		}

		
	
		
		if(isset($_GET['page'])){
			if($_GET['page']=="wp_tripadvisor-get_tripadvisor"){
				wp_enqueue_script('wptripadvisor_get_tripadvisor-js', plugin_dir_url( __FILE__ ) . 'js/wptripadvisor_get_tripadvisor.js', array( 'jquery','media-upload','thickbox' ), $this->version, false );
				//used for ajax
				wp_localize_script('wptripadvisor_get_tripadvisor-js', 'adminjs_script_vars', 
					array(
					'wptripadvisor_nonce'=> wp_create_nonce('randomnoncestring')
					)
				);
			}

			

			//scripts for review list page
			if($_GET['page']=="wp_tripadvisor-reviews"){
				//admin js
				wp_enqueue_script('wptripadvisor_review_list_page-js', plugin_dir_url( __FILE__ ) . 'js/wptripadvisor_review_list_page.js', array( 'jquery','media-upload','thickbox' ), $this->version, false );
				//used for ajax
				wp_localize_script('wptripadvisor_review_list_page-js', 'adminjs_script_vars', 
					array(
					'wptripadvisor_nonce'=> wp_create_nonce('randomnoncestring')
					)
				);
				
 				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox');
		 
				wp_enqueue_script('media-upload');
				wp_enqueue_script('wptuts-upload');

			}
			
			//scripts for templates posts page
			if($_GET['page']=="wp_tripadvisor-templates_posts"){
			
				//admin js
				wp_enqueue_script('wptripadvisor_templates_posts_page-js', plugin_dir_url( __FILE__ ) . 'js/wptripadvisor_templates_posts_page.js', array( 'jquery' ), $this->version, false );
				//used for ajax
				wp_localize_script('wptripadvisor_templates_posts_page-js', 'adminjs_script_vars', 
					array(
					'wptripadvisor_nonce'=> wp_create_nonce('randomnoncestring'),
					'pluginsUrl' => wprev_trip_plugin_url
					)
				);
 				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox');
				
				//add color picker here
				wp_enqueue_style( 'wp-color-picker' );
				//enque alpha color add-on wptripadvisor-wp-color-picker-alpha.js
				wp_enqueue_script( 'wp-color-picker-alpha', plugin_dir_url( __FILE__ ) . 'js/wptripadvisor-wp-color-picker-alpha.js', array( 'wp-color-picker' ), '2.1.2', false );
				
				//add public script for preview
	
				wp_enqueue_script( $this->_token."_plublic", plugin_dir_url(dirname(__FILE__)) . 'public/js/wprev-public.js', array( 'jquery' ), $this->version, false );

			}
		}
		
	}
	
	public function add_menu_pages() {

		/**
		 * adds the menu pages to wordpress
		 */

		$page_title = 'WP TripAdvisor Reviews : Welcome';
		$menu_title = 'WP TripAdvisor';
		$capability = 'manage_options';
		$menu_slug = 'wp_tripadvisor-welcome';
		
		// Now add the submenu page for the actual reviews list
		
		
		add_menu_page($page_title, $menu_title, $capability, $menu_slug, array($this,'wp_tripadvisor_welcome'),'dashicons-star-half');
		
		// We add this submenu page with the same slug as the parent to ensure we don't get duplicates
		$sub_menu_title = 'Welcome';
		add_submenu_page($menu_slug, $page_title, $sub_menu_title, $capability, $menu_slug, array($this,'wp_tripadvisor_welcome'));	
		
		
		// We add this submenu page with the same slug as the parent to ensure we don't get duplicates
		//$sub_menu_title = 'Get FB Reviews';
		//add_submenu_page($menu_slug, $page_title, $sub_menu_title, $capability, $menu_slug, array($this,'wp_tripadvisor_settings'));
		
		// Now add the submenu page for tripadvisor
		$submenu_page_title = 'WP Reviews Pro : Reviews List';
		$submenu_title = 'Review List';
		$submenu_slug = 'wp_tripadvisor-reviews';
		add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, array($this,'wp_tripadvisor_reviews'));
		
		// Now add the submenu page for tripadvisor
		$submenu_page_title = 'WP Reviews Pro : TripAdvisor';
		$submenu_title = 'Get TripAdvisor Reviews';
		$submenu_slug = 'wp_tripadvisor-get_tripadvisor';
		add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, array($this,'wp_tripadvisor_gettripadvisor'));
		

		
		// Now add the submenu page for the reviews templates
		$submenu_page_title = 'WP Reviews Pro : Templates';
		$submenu_title = 'Templates';
		$submenu_slug = 'wp_tripadvisor-templates_posts';
		add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, array($this,'wp_tripadvisor_templates_posts'));
		
		// Now add the submenu page for the reviews templates
		//$submenu_page_title = 'WP FB Reviews : Upgrade';
		//$submenu_title = 'Get Pro';
		//$submenu_slug = 'wp_tripadvisor-get_pro';
		//add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, array($this,'wp_fb_getpro'));
	

	}
	
	public function wp_tripadvisor_welcome() {
		require_once plugin_dir_path( __FILE__ ) . '/partials/welcome.php';
	}
	
	public function wp_tripadvisor_reviews() {
		require_once plugin_dir_path( __FILE__ ) . '/partials/review_list.php';
	}
	
	public function wp_tripadvisor_templates_posts() {
		require_once plugin_dir_path( __FILE__ ) . '/partials/templates_posts.php';
	}
	public function wp_tripadvisor_gettripadvisor() {
		require_once plugin_dir_path( __FILE__ ) . '/partials/get_tripadvisor.php';
	}
	public function wp_fb_getpro() {
		require_once plugin_dir_path( __FILE__ ) . '/partials/get_pro.php';
	}
	
	public function wprev_trip_add_external_link_admin_submenu() {
		global $submenu;

		$menu_slug = 'wp_tripadvisor-welcome'; // used as "key" in menus
		$menu_pos = 1; // whatever position you want your menu to appear
		if (array_key_exists($menu_slug, $submenu)) {
		// add the external links to the slug you used when adding the top level menu
		$submenu[$menu_slug][] = array('<div id="wprev-66023">Go Pro!</div>', 'manage_options', 'https://wpreviewslider.com/');
		}
	}
	public function wpse_66023_add_jquery() 
	{
		?>
		<script type="text/javascript">
			jQuery(document).ready( function($) {   
				$('#wprev-66022').parent().attr('target','_blank');  
			});
		</script>
		<?php
	}

	/**
	 * custom option and settings on tripadvisor page
	 */
	 //===========start tripadvisor page settings===========================================================
	public function wptripadvisor_tripadvisor_settings_init()
	{
	
		// register a new setting for "wp_tripadvisor-get_tripadvisor" page
		register_setting('wp_tripadvisor-get_tripadvisor', 'wptripadvisor_tripadvisor_settings');
		
		// register a new section in the "wp_tripadvisor-get_tripadvisor" page
		add_settings_section(
			'wptripadvisor_tripadvisor_section_developers',
			'',
			array($this,'wptripadvisor_tripadvisor_section_developers_cb'),
			'wp_tripadvisor-get_tripadvisor'
		);
		
		//register tripadvisor business url input field
		add_settings_field(
			'tripadvisor_business_url', // as of WP 4.6 this value is used only internally
			'TripAdvisor Business URL',
			array($this,'wptripadvisor_field_tripadvisor_business_id_cb'),
			'wp_tripadvisor-get_tripadvisor',
			'wptripadvisor_tripadvisor_section_developers',
			[
				'label_for'         => 'tripadvisor_business_url',
				'class'             => 'wptripadvisor_row',
				'wptripadvisor_custom_data' => 'custom',
			]
		);

		//Turn on TripAdvisor Reviews Downloader
		/*
		add_settings_field("tripadvisor_radio", "Turn On TripAdvisor Reviews", array($this,'tripadvisor_radio_display'), "wp_tripadvisor-get_tripadvisor", "wptripadvisor_tripadvisor_section_developers",
			[
				'label_for'         => 'tripadvisor_radio',
				'class'             => 'wptripadvisor_row',
				'wptripadvisor_custom_data' => 'custom',
			]); 
			*/
	
	}
	//==== developers section cb ====
	public function wptripadvisor_tripadvisor_section_developers_cb($args)
	{
		//echos out at top of section
	}
	
	//==== field cb =====
	public function wptripadvisor_field_tripadvisor_business_id_cb($args)
	{
		// get the value of the setting we've registered with register_setting()
		$options = get_option('wptripadvisor_tripadvisor_settings');

		// output the field
		?>
		<input id="<?= esc_attr($args['label_for']); ?>" data-custom="<?= esc_attr($args['wptripadvisor_custom_data']); ?>" type="text" name="wptripadvisor_tripadvisor_settings[<?= esc_attr($args['label_for']); ?>]" placeholder="" value="<?php echo $options[$args['label_for']]; ?>">
		
		<p class="description">
			<?= esc_html__('Enter the TripAdvisor URL for your business and click Save Settings. Example:', 'wp-tripadvisor-review-slider'); ?>
			</br>
			<?= esc_html__('https://www.tripadvisor.com/Restaurant_Review-g30620-d10262422-Reviews-Yellowhammer_Brewing-Huntsville_Alabama.html', 'wp-tripadvisor-review-slider'); ?>
		</p>
		<?php
	}
	/*
	public function tripadvisor_radio_display($args)
		{
		$options = get_option('wptripadvisor_tripadvisor_settings');
		
		   ?>
				<input type="radio" name="wptripadvisor_tripadvisor_settings[<?= esc_attr($args['label_for']); ?>]" value="yes" <?php checked('yes', $options[$args['label_for']], true); ?>>Yes&nbsp;&nbsp;&nbsp;
				<input type="radio" name="wptripadvisor_tripadvisor_settings[<?= esc_attr($args['label_for']); ?>]" value="no" <?php checked('no', $options[$args['label_for']], true); ?>>No
		   <?php
		}
		*/
	//=======end tripadvisor page settings========================================================

	
	/**
	 * Store reviews in table, called from javascript file admin.js
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function wptripadvisor_process_ajax(){
	//ini_set('display_errors',1);  
	//error_reporting(E_ALL);
		
		check_ajax_referer('randomnoncestring', 'wptripadvisor_nonce');
		
		$postreviewarray = $_POST['postreviewarray'];
		
		//var_dump($postreviewarray);

		//loop through each one and insert in to db
		global $wpdb;
		$table_name = $wpdb->prefix . 'wptripadvisor_reviews';
		
		$stats = array();
		
		foreach($postreviewarray as $item) { //foreach element in $arr
			$pageid = $item['pageid'];
			$pagename = $item['pagename'];
			$created_time = $item['created_time'];
			$created_time_stamp = strtotime($created_time);
			$reviewer_name = $item['reviewer_name'];
			$reviewer_id = $item['reviewer_id'];
			$rating = $item['rating'];
			$review_text = $item['review_text'];
			$review_length = str_word_count($review_text);
			$rtype = $item['type'];
			
			//check to see if row is in db already
			//$checkrow = $wpdb->get_row( "SELECT id FROM ".$table_name." WHERE created_time = '$created_time'" );
			//$checkrow = $wpdb->get_var( 'SELECT id FROM '.$table_name.' WHERE reviewer_name = "'.$reviewer_name.'" AND (review_length = "'.$review_length.'" OR created_time_stamp = "'.$created_time_stamp.'")' );
			
			$checkrow = $wpdb->get_var( "SELECT id FROM ".$table_name." WHERE reviewer_name = '".$reviewer_name."' AND (review_length = '".$review_length."' OR created_time_stamp = '".$created_time_stamp."')" );
			
			//echo $wpdb->last_result;
			//echo "<br>here<br>";
			//echo $wpdb->last_query;
			
			echo $checkrow;
			
			if ( null === $checkrow ) {
				$stats[] =array( 
						'pageid' => $pageid, 
						'pagename' => $pagename, 
						'created_time' => $created_time,
						'created_time_stamp' => strtotime($created_time),
						'reviewer_name' => $reviewer_name,
						'reviewer_id' => $reviewer_id,
						'rating' => $rating,
						'review_text' => $review_text,
						'hide' => '',
						'review_length' => $review_length,
						'type' => $rtype
					);
			}
		}
		$i = 0;
		$insertnum = 0;
		foreach ( $stats as $stat ){
			$insertnum = $wpdb->insert( $table_name, $stat );
			$i=$i + 1;
		}
	
		$insertid = $wpdb->insert_id;

		//header('Content-Type: application/json');
		echo $insertnum."-".$insertid."-".$i;

		die();
	}

	/**
	 * Hides or deletes reviews in table, called from javascript file wptripadvisor_review_list_page.js
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function wptripadvisor_hidereview_ajax(){
	//ini_set('display_errors',1);  
	//error_reporting(E_ALL);
		
		check_ajax_referer('randomnoncestring', 'wptripadvisor_nonce');
		
		$rid = intval($_POST['reviewid']);
		$myaction = $_POST['myaction'];

		//loop through each one and insert in to db
		global $wpdb;
		$table_name = $wpdb->prefix . 'wptripadvisor_reviews';
		
		//check to see if we are deleting or just hiding or showing
		if($myaction=="hideshow"){
			//grab review and see if it is hidden or not
			$myreview = $wpdb->get_row( "SELECT * FROM $table_name WHERE id = $rid" );
			
			//pull array from options table of tripadvisor hidden
			$tripadvisorhidden = get_option( 'wptripadvisor_hidden_reviews' );
			if(!$tripadvisorhidden){
				$tripadvisorhiddenarray = array('');
			} else {
				$tripadvisorhiddenarray = json_decode($tripadvisorhidden,true);
			}
			if(!is_array($tripadvisorhiddenarray)){
				$tripadvisorhiddenarray = array('');
			}
			$this_tripadvisor_val = $myreview->reviewer_name."-".$myreview->created_time_stamp."-".$myreview->review_length."-".$myreview->type."-".$myreview->rating;

			if($myreview->hide=="yes"){
				//already hidden need to show
				$newvalue = "";
				
				//remove from $tripadvisorhidden
				if(($key = array_search($this_tripadvisor_val, $tripadvisorhiddenarray)) !== false) {
					unset($tripadvisorhiddenarray[$key]);
				}
				
			} else {
				//shown, need to hide
				$newvalue = "yes";
				
				//need to update TripAdvisor hidden ids in options table here array of name,time,count,type
				 array_push($tripadvisorhiddenarray,$this_tripadvisor_val);
			}
			//update hidden tripadvisor reviews option, use this when downloading tripadvisor reviews so we can re-hide them each download
			$tripadvisorhiddenjson=json_encode($tripadvisorhiddenarray);
			update_option( 'wptripadvisor_hidden_reviews', $tripadvisorhiddenjson );
			
			//update database review table to hide this one
			$data = array( 
				'hide' => "$newvalue"
				);
			$format = array( 
					'%s'
				); 
			$updatetempquery = $wpdb->update($table_name, $data, array( 'id' => $rid ), $format, array( '%d' ));
			if($updatetempquery>0){
				echo $rid."-".$myaction."-".$newvalue;
			} else {
				echo $rid."-".$myaction."-fail";
			}

		}
		if($myaction=="deleterev"){
			$deletereview = $wpdb->delete( $table_name, array( 'id' => $rid ), array( '%d' ) );
			if($deletereview>0){
				echo $rid."-".$myaction."-success";
			} else {
				echo $rid."-".$myaction."-fail";
			}
		
		}

		die();
	}
	
	/**
	 * Ajax, retrieves reviews from table, called from javascript file wptripadvisor_templates_posts_page.js
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function wptripadvisor_getreviews_ajax(){
	//ini_set('display_errors',1);  
	//error_reporting(E_ALL);
		
		check_ajax_referer('randomnoncestring', 'wptripadvisor_nonce');
		$filtertext = htmlentities($_POST['filtertext']);
		$filterrating = htmlentities($_POST['filterrating']);
		$filterrating = intval($filterrating);
		$curselrevs = $_POST['curselrevs'];
		
		//perform db search and return results
		global $wpdb;
		$table_name = $wpdb->prefix . 'wptripadvisor_reviews';
		$rowsperpage = 20;
		
		//pagenumber
		if(isset($_POST['pnum'])){
		$temppagenum = $_POST['pnum'];
		} else {
		$temppagenum ="";
		}
		if ( $temppagenum=="") {
			$pagenum = 1;
		} else if(is_numeric($temppagenum)){
			$pagenum = intval($temppagenum);
		}
		
		//sort direction
		if($_POST['sortdir']=="ASC" || $_POST['sortdir']=="DESC"){
			$sortdir = $_POST['sortdir'];
		} else {
			$sortdir = "DESC";
		}

		//make sure sortby is valid
		if(!isset($_POST['sortby'])){
			$_POST['sortby'] = "";
		}
		$allowed_keys = ['created_time_stamp', 'reviewer_name', 'rating', 'review_length', 'pagename', 'type' , 'hide'];
		$checkorderby = sanitize_key($_POST['sortby']);
	
		if(in_array($checkorderby, $allowed_keys, true) && $_POST['sortby']!=""){
			$sorttable = $_POST['sortby']. " ";
		} else {
			$sorttable = "created_time_stamp ";
		}
		if($_POST['sortdir']=="ASC" || $_POST['sortdir']=="DESC"){
			$sortdir = $_POST['sortdir'];
		} else {
			$sortdir = "DESC";
		}
		
		//get reviews from db
		$lowlimit = ($pagenum - 1) * $rowsperpage;
		$tablelimit = $lowlimit.",".$rowsperpage;
		
		if($filterrating>0){
			$filterratingtext = "rating = ".$filterrating;
		} else {
			$filterratingtext = "rating > 0";
		}
			
		//check to see if looking for previously selected only
		if (is_array($curselrevs)){
			$query = "SELECT * FROM ".$table_name." WHERE id IN (";
			//loop array and add to query
			$n=1;
			foreach ($curselrevs as $value) {
				if($value!=""){
					if(count($curselrevs)==$n){
						$query = $query." $value";
					} else {
						$query = $query." $value,";
					}
				}
				$n++;
			}
			$query = $query.")";
			//echo $query ;

			$reviewsrows = $wpdb->get_results($query);
			$hidepagination = true;
			$hidesearch = true;
		} else {
		

			//if filtertext set then use different query
			if($filtertext!=""){
				$reviewsrows = $wpdb->get_results("SELECT * FROM ".$table_name."
					WHERE (reviewer_name LIKE '%".$filtertext."%' or review_text LIKE '%".$filtertext."%') AND ".$filterratingtext."
					ORDER BY ".$sorttable." ".$sortdir." 
					LIMIT ".$tablelimit." "
				);
				$hidepagination = true;
			} else {
				$reviewsrows = $wpdb->get_results(
					$wpdb->prepare("SELECT * FROM ".$table_name."
					WHERE id>%d AND ".$filterratingtext."
					ORDER BY ".$sorttable." ".$sortdir." 
					LIMIT ".$tablelimit." ", "0")
				);
			}
		}
		
		//total number of rows
		$reviewtotalcount = $wpdb->get_var( "SELECT COUNT(*) FROM ".$table_name." WHERE id>1 AND ".$filterratingtext );
		//total pages
		$totalpages = ceil($reviewtotalcount/$rowsperpage);
		
		$reviewsrows['reviewtotalcount']=$reviewtotalcount;
		$reviewsrows['totalpages']=$totalpages;
		$reviewsrows['pagenum']=$pagenum;
		if($hidepagination){
			$reviewsrows['reviewtotalcount']=0;
			//$reviewsrows['totalpages']=0;
			//$reviewsrows['pagenum']=0;
		}
		if($hidesearch){
			//$reviewsrows['reviewtotalcount']=0;
			$reviewsrows['totalpages']=0;
			//$reviewsrows['pagenum']=0;
		}
		
		$results = json_encode($reviewsrows);
		echo $results;

		die();
	}
	
	
	
	/**
	 * replaces insert into post text on media uploader when uploading reviewer avatar
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */	
	public function wptripadvisor_media_text() {
		global $pagenow;
		if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
			// Now we'll replace the 'Insert into Post Button' inside Thickbox
			add_filter( 'gettext', array($this,'replace_thickbox_text') , 1, 3 );
		}
	}
	 
	public function replace_thickbox_text($translated_text, $text, $domain) {
		if ('Insert into Post' == $text) {
			$referer = strpos( wp_get_referer(), 'wp_tripadvisor-reviews' );
			if ( $referer != '' ) {
				return __('Use as Reviewer Avatar', 'wp-tripadvisor-review-slider' );
			}
		}
		return $translated_text;
	}
	

	/**
	 * download csv file of reviews
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */	
	public function wptripadvisor_download_csv() {
      global $pagenow;
      if ($pagenow=='admin.php' && current_user_can('export') && isset($_GET['taction']) && $_GET['taction']=='downloadallrevs' && $_GET['page']=='wp_tripadvisor-reviews') {
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=reviewdata.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

		global $wpdb;
		$table_name = $wpdb->prefix . 'wptripadvisor_reviews';		
		$downloadreviewsrows = $wpdb->get_results(
				$wpdb->prepare("SELECT * FROM ".$table_name."
				WHERE id>%d ", "0"),'ARRAY_A'
			);
		$file = fopen('php://output', 'w');
		$delimiter=";";
		
		foreach ($downloadreviewsrows as $line) {
		    fputcsv($file, $line, $delimiter);
		}

        exit();
      }
    }	
	

	/**
	 * download tripadvisor reviews when clicking the save button on TripAdvisor page
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */	
	public function wptripadvisor_download_tripadvisor() {
      global $pagenow;
      if (isset($_GET['settings-updated']) && $pagenow=='admin.php' && current_user_can('export') && $_GET['page']=='wp_tripadvisor-get_tripadvisor') {
		$this->wptripadvisor_download_tripadvisor_master();
      }
    }
	
	
	
	//for using curl instead of fopen
	private function file_get_contents_curl($url) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

		$data = curl_exec($ch);
		curl_close($ch);

		return $data;
	}
	
	
	//fix stringtotime for other languages
	private function myStrtotime($date_string) {
		$monthnamearray = array(
		'janvier'=>'jan',
		'février'=>'feb',
		'févr.'=>'feb',
		'mars'=>'march',
		'avril'=>'apr',
		'mai'=>'may',
		'juin'=>'jun',
		'juillet'=>'jul',
		'juil.'=>'jul',
		'août'=>'aug',
		'septembre'=>'sep',
		'octobre'=>'oct',
		'novembre'=>'nov',
		'décembre'=>'dec',
		'gennaio'=>'jan',
		'febbraio'=>'feb',
		'marzo'=>'march',
		'aprile'=>'apr',
		'maggio'=>'may',
		'giugno'=>'jun',
		'luglio'=>'jul',
		'agosto'=>'aug',
		'settembre'=>'sep',
		'ottobre'=>'oct',
		'novembre'=>'nov',
		'dicembre'=>'dec',
		'janeiro'=>'jan',
		'fevereiro'=>'feb',
		'março'=>'march',
		'abril'=>'apr',
		'maio'=>'may',
		'junho'=>'jun',
		'julho'=>'jul',
		'agosto'=>'aug',
		'setembro'=>'sep',
		'outubro'=>'oct',
		'novembro'=>'nov',
		'dezembro'=>'dec',
		'enero'=>'jan',
		'febrero'=>'feb',
		'marzo'=>'march',
		'abril'=>'apr',
		'mayo'=>'may',
		'junio'=>'jun',
		'julio'=>'jul',
		'agosto'=>'aug',
		'septiembre'=>'sep',
		'octubre'=>'oct',
		'noviembre'=>'nov',
		'diciembre'=>'dec',
		'januari'=>'jan',
		'februari'=>'feb',
		'maart'=>'march',
		'april'=>'apr',
		'mei'=>'may',
		'juni'=>'jun',
		'juli'=>'jul',
		'augustus'=>'aug',
		'september'=>'sep',
		'oktober'=>'oct',
		'november'=>'nov',
		'december'=>'dec',
		' de '=>'',
		'dezember'=>'dec',
		'januar '=>'jan ',
		'stycznia'=>'jan',
		'lutego'=>'feb',
		'februar'=>'feb',
		'marca'=>'march',
		'märz'=>'march',
		'kwietnia'=>'apr',
		'maja'=>'may',
		'czerwca'=>'jun',
		'lipca'=>'jul',
		'sierpnia'=>'aug',
		'września'=>'sep',
		'października'=>'oct',
		'listopada'=>'nov',
		'grudnia'=>'dec',
		'february'=>'feb',
		'января'=>'jan',
		'февраля'=>'feb',
		'марта'=>'march',
		'апреля'=>'apr',
		'мая'=>'may',
		'июня'=>'jun',
		'июля'=>'jul',
		'августа'=>'aug',
		'сентября'=>'sep',
		'октября'=>'oct',
		'ноября'=>'nov',
		'декабря'=>'dec',
		'tháng 1,'=>'jan',
		'tháng 2,'=>'feb',
		'tháng 3,'=>'march',
		'tháng 4,'=>'apr',
		'tháng 5,'=>'may',
		'tháng 6,'=>'jun',
		'tháng 7,'=>'jul',
		'tháng 8,'=>'aug',
		'tháng 9,'=>'sep',
		'tháng 10,'=>'oct',
		'tháng 11,'=>'nov',
		'tháng 12,'=>'dec',
		'Ιανουαρίου'=>'jan',
		'Φεβρουαρίου'=>'feb',
		'Μαρτίου'=>'march',
		'Απριλίου'=>'apr',
		'Μαΐου'=>'may',
		'Ιουνίου'=>'jun',
		'Ιουλίου'=>'jul',
		'Αυγούστου'=>'aug',
		'Σεπτεμβρίου'=>'sep',
		'Οκτωβρίου'=>'oct',
		'Νοεμβρίου'=>'nov',
		'Δεκεμβρίου'=>'dec',
		'janv.'=>'jan',
		'févr.'=>'feb',
		'mars'=>'march',
		'avril'=>'apr',
		'mai'=>'may',
		'juin'=>'jun',
		'juil.'=>'jul',
		'août'=>'aug',
		'sept.'=>'sep',
		'oct.'=>'oct',
		'nov.'=>'nov',
		'déc.'=>'dec',
		);
		
		$result = strtr(strtolower($date_string), $monthnamearray);
		
		if($result ==''){
			$result = strtr(($date_string), $monthnamearray);
		}
		
		//echo "<br>res:".$result;
		
		//echo "<br>str:". strtotime($result);
		

		return strtotime($result); 
		
	}
	
	
	public function getBetween($content, $start, $end) {
		$n = explode($start, $content);
		$result = Array();
		foreach ($n as $val) {
			$pos = strpos($val, $end);
			if ($pos !== false) {
				$result[] = substr($val, 0, $pos);
			}
		}
		return $result;
	}

		//for using curl instead of fopen
	private function file_get_contents_curl_browser($url,$cookieval) {
		$agent= 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							'pragma: no-cache',
							'cache-control: no-cache',
							'upgrade-insecure-requests: 1',
							'user-agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36',
							'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3', 'accept-encoding: gzip, deflate, br',
							'accept-language: en-US,en;q=0.9',
							'cookie: '.$cookieval.''
					));
		curl_setopt($ch, CURLOPT_URL,$url);
		$result=curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	public function wprevpro_download_tripadvisor_showuserreviews_url($currenturl) {
		ini_set('memory_limit','500M');
		//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


		if (strpos($currenturl, 'VacationRentalReview') !== false) {
			//this is a vactionrental
			$vactionrental = true;
		} else {
			$vactionrental = false;
		}
					

		$args = array(
			'timeout'     => 15,
			'sslverify' => false
		); 
		$response = wp_remote_get( $currenturl,$args );
		if ( is_array( $response ) ) {
		  $header = $response['headers']; // array of http header lines
		  $fileurlcontents = $response['body']; // use the content
		} else {
			echo esc_html__('Error finding reviews. Please contact plugin support. Error: ', 'wp-tripadvisor-review-slider');
			if( is_wp_error( $response ) ) {
				echo $response->get_error_message();
			}
			die();
		}
		
		
			//fix for lazy load base64 ""
			//$fileurlcontents = str_replace('=="', '', $fileurlcontents);
			
			//echo $fileurlcontents;
			//die();
			
			$html = wptrip_str_get_html($fileurlcontents);
			//echo $html;
			//die();
			//die();
			//unset($fileurlcontents);
			
			//find total and average number here
			$avgrating ='';
			$totalreviews = '';
			
			$reviewobject5 ="";
			$page2url ="";
			$rtitlelink ="";
			$nextbtnlink="";
			//echo $currenturl;
			//echo "<br><br>";
			//check to see if on vacation rental or regular page
			if($vactionrental==true){
				if($html->find('div.reviewSelector')){
					$reviewobject = $html->find('div.reviewSelector',0);
				} else {
					echo esc_html__('Error 102a: Unable to read Vacation Rental TripAdvisor page. Please contact support.', 'wp-tripadvisor-review-slider');
					die();	
				}
			} else {
				if($html->find('div.review-container')){
						$reviewobject = $html->find('div.review-container',0);
						$reviewobject5 = $html->find('div.review-container',5);
				}
			}
			
			//need to get the links
			if($html->find("div[class*=ReviewTitle]", 0)){
				$rtitlelink = $html->find("div[class*=ReviewTitle]", 0)->find('a',0)->href;

				if($html->find("div[class*=ReviewTitle]", 4)){
					$nextbtnlink = $html->find("div[class*=ReviewTitle]", 4)->find('a',0)->href;
				}
				//echo $rtitlelink;
				//echo 'h1';
			
			} else if($html->find("div[data-test-target*=review-title]", 0)){

				$rtitlelink = $html->find("div[data-test-target*=review-title]", 0)->find('a',0)->href;

				if($html->find("div[data-test-target*=review-title]", 4)){
					$nextbtnlink = $html->find("div[data-test-target*=review-title]", 4)->find('a',0)->href;
				}
				//echo $rtitlelink;
				//echo 'h2';
			
			} else if($html->find("div.glasR4aX", 0)){
				$rtitlelink = $html->find("div.glasR4aX", 0)->find('a',0)->href;

				if($html->find("div.glasR4aX", 4)){
					$nextbtnlink = $html->find("div.glasR4aX", 4)->find('a',0)->href;
				}
				//echo $rtitlelink;
				//echo 'h3';
			
			} else {
				//try to find links using string search here, had to add for italian languages
				$urlmatches = $this->getBetween($fileurlcontents, "/ShowUserReviews-", '"');

				//print_r($urlmatches2);
				//echo '<br><br>';
				if(isset($urlmatches[0]) && $urlmatches[0]!=''){
					$rtitlelink = "/ShowUserReviews-".$urlmatches['1'];
					$nextbtnlink = "/ShowUserReviews-".$urlmatches['6'];
					//echo $rtitlelink;
				//echo 'h4';
				} else if(isset($urlmatches[1]) && $urlmatches[1]!=''){
					$rtitlelink = "/ShowUserReviews-".$urlmatches['0'];
					$nextbtnlink = "/ShowUserReviews-".$urlmatches['5'];
					//echo $rtitlelink;
				//echo 'h4';
					
					
				} else {

					echo esc_html__('Error 103a: Unable to read TripAdvisor page. Please contact support.', 'wp-tripadvisor-review-slider');
					//echo $html;
					die();	
				}
			}
			
			//find page name here
					//find tripadvisor business name and add to db under pagename
					$pagename ='';
					
					if($vactionrental==false){
						if($html->find('.altHeadInline', 0)){
							if($html->find('.altHeadInline', 0)->find('a',0)){
								$pagename = $html->find('.altHeadInline', 0)->find('a',0)->plaintext;
							}
						}
					} else {
						if($html->find('.vrPgHdr', 0)){
							if($html->find('.vrPgHdr', 0)->find('a',0)){
								$pagename = $html->find('.vrPgHdr', 0)->find('a',0)->plaintext;
							}
						}
					}

					if($pagename==''){
						if($html->find('h1[id=HEADING]',0)){
						$pagename = $html->find('h1[id=HEADING]',0)->plaintext;
						}
					}
					if($pagename==''){
						if($html->find('h1[class=ui_header h1]',0)){
						$pagename = $html->find('h1[class=ui_header h1]',0)->plaintext;
						}
					}
					if($pagename==''){
						if($html->find('h1[class=propertyHeading]',0)){
						$pagename = $html->find('h1[class=propertyHeading]',0)->plaintext;
						}
					}
					if($pagename==''){
						if($html->find('span[class=ui_header h1]',0)){
						$pagename = $html->find('span[class=ui_header h1]',0)->plaintext;
						}
					}
					//=====================
			
			//print_r($reviewobject);
			//echo "<br><br>";
			//print_r(reviewobject5);		
			
			if(isset($reviewobject) && $reviewobject!="" && $rtitlelink==''){
				$rtitlelink = $reviewobject->find('div.quote', 0)->find('a',0)->href;
				//echo $rtitlelink;
				//echo 'h5';
			}
			
			if($reviewobject5!="" && $nextbtnlink==''){
				$nextbtnlink = $reviewobject5->find('div.quote', 0)->find('a',0)->href;
			}
			
			$parseurl = parse_url($currenturl);
			$newurl = $parseurl['scheme'].'://'.$parseurl['host'].$rtitlelink;
			$page2url = $parseurl['scheme'].'://'.$parseurl['host'].$nextbtnlink;
			
			//$response =array("page1"=>$newurl,"page2"=>$page2url);
			
			$response =array("page1"=>$newurl,"page2"=>$page2url,"totalreviews"=>$totalreviews,"avgrating"=>$avgrating,"pagename"=>$pagename);
			$html->clear(); 
			unset($html);
			
			//print_r($response);
			//die();

			//create new link based on $currenturl and $rtitlelink
		return $response;
	}
	
	/**
	 * download tripadvisor reviews
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */	
	public function wptripadvisor_download_tripadvisor_master() {
		ini_set('memory_limit','800M');
		set_time_limit(60);
		//make sure file get contents is turned on for this host
		$errormsg ='';
		$ShowUserReviews = false;
		$HotelUserReviews = false;
		$onfirstpage = false;
		
			global $wpdb;
			$table_name = $wpdb->prefix . 'wptripadvisor_reviews';
			$options = get_option('wptripadvisor_tripadvisor_settings');
			
			$tempurl = trim($options['tripadvisor_business_url']);
			
			//make sure you have valid url, if not display message
			if (filter_var($tempurl, FILTER_VALIDATE_URL)) {
			  // you're good
			  //echo "valid url";
			  //if($options['tripadvisor_radio']=='yes'){
				//echo "passed both tests";
				$stripvariableurl = strtok($options['tripadvisor_business_url'], '?');
				$urlvalue = trim($stripvariableurl);
				if (strpos($stripvariableurl, 'ShowUserReviews') === false  && strpos($stripvariableurl, 'AttractionProductReview') == false) {
					//this is a hotel or vacation rental review, we have to now find the ShowUserReviews url
					//====we are now using this for all types in order to get userpics
					$urlarray = $this->wprevpro_download_tripadvisor_showuserreviews_url($stripvariableurl);
					$urlvalue = $urlarray['page1'];
					//if($urlarray['page2']!=""){
						//$tripadvisorurl[1] = $urlarray['page2'];
					//} else {
						//$tripadvisorurl[1] ='';
					//}
					$ShowUserReviews = true;
				}
				
				//hotel page check
				if (strpos($urlvalue, 'ShowUserReviews') !== false) {
					$ShowUserReviews = true;
				}
				if (strpos($urlvalue, 'Hotel_Review') !== false) {
					$HotelUserReviews= true;
				}

				
				//we are now looping to make sure we are at first showuserreviewpage.
				$loop = 0;
				start:
				//goto start;
				
				
				//loop to grab pages
				$reviews = [];
				$n=1;

					
					//echo $urlvalue;
					//die();
				$localorphantom = "local";
				$phatomtry = 1;
				phantom:
				
				if($phatomtry == 1){
					$apitoken = 'a-demo-key-with-low-quota-per-ip-address';
					$phantomtempurlvalue = "https://phantomjscloud.com/api/browser/v2/".$apitoken."/?request={url:%22".urlencode($urlvalue)."%22,renderType:%22html%22,requestSettings:{doneWhen:[{event:%22domReady%22}]}}";
				} else {
					//calling server so we can hide phantomjs api key
					//$phantomtempurlvalue = "https://crawl.ljapps.com/freetripphantom.php?urlval=".urlencode($urlvalue);
					//echo $phantomtempurlvalue;
					//die();
				}
					//echo $phantomtempurlvalue;
					//die();

					$args = array(
						'timeout'     => 60,
						'sslverify' => false
					);
					if($localorphantom =="local"){
						$response = wp_remote_get( $urlvalue,$args );
					} else {
						$response = wp_remote_get( $phantomtempurlvalue,$args );
					}

					if ( is_array( $response ) ) {
					  $header = $response['headers']; // array of http header lines
					  $fileurlcontents = $response['body']; // use the content
					} else {
						//echo esc_html__('Error finding reviews. Please contact plugin support.', 'wp-tripadvisor-review-slider');
						$errormsg = $errormsg . ' Error finding reviews. Please contact plugin support.';
						$this->errormsg = $errormsg;
						//die();
					}

					
					//check for error from phatomjs and retry with paid key.
					if(strpos($fileurlcontents, 'REQUEST REJECTED') !== false || strpos($fileurlcontents, 'DEMO OUT OF CREDITS') !== false || strpos($fileurlcontents, 'Access Denied') !== false){
						//echo "here";
						//echo "The string 'lazy' was found in the string\n";
						if($phatomtry==1){
							$phatomtry = 2;
							goto phantom;
						}
					}
					//echo $fileurlcontents;
					//die();

					//fix for lazy load base64 ""
					$fileurlcontents = str_replace('=="', '', $fileurlcontents);
					
					//echo $fileurlcontents;
					//die();

					$html = wptrip_str_get_html($fileurlcontents);
					
					unset($fileurlcontents);
					
					//var_dump($html);
					//die();
					
					if (!is_object($html)) {
						echo "Unable to retrieve TripAdvisor reviews for that URL. Try going to the TripAdvisor URL in a browser, click on the title of your first review, then copy that URL and use it in the plugin.";
						die();
					}
					
					$parseurl = parse_url($urlvalue);
					
			
					//check to make sure we are on first page here.
					if($ShowUserReviews && $loop == 0){
						//echo "here";
						if($html->find("a[class=pageNum first current]",0)){
							//we must be on first page. se we continue on
							$onfirstpage = true;
							//echo "here1";
						} else if($html->find("a[class=pageNum first]",0)){
							//we must find href for page one.
							$newurl = $html->find("a[class=pageNum first]",0)->href;
							$urlvalue = $parseurl['scheme'].'://'.$parseurl['host'].$newurl;
							$onfirstpage = true;
							$loop++;
							//echo "here2:".$urlvalue;
							//echo "<br>";
							goto start;
						}							
					}
					//die();
					
					//find tripadvisor business name and add to db under pagename
					$pagename ='';
					if($html->find('.heading_title', 0)){
						$pagename = $html->find('.heading_title', 0)->plaintext;
					}
					if($pagename==''){
						if($html->find('a[class=HEADING]',0)){
						$pagename = $html->find('a[class=HEADING]',0)->plaintext;
						}
					}
					if($pagename==''){
						if($html->find('h1[id=HEADING]',0)){
						$pagename = $html->find('h1[id=HEADING]',0)->plaintext;
						}
					}
					
					//echo "pagename:".$pagename;
					//die();

					
					//find lazyload image js variable and convert to array #\slazyImgs\s*=\s*(.*?);\s*$#s
					
					$startstringpos = stripos("$html","var lazyImgs = [") + 16;
					$choppedstr = substr("$html", $startstringpos);
					$endstringpos = stripos("$choppedstr","]");
					$finalstring = trim(substr("$html", $startstringpos, $endstringpos));
					$finalstring =str_replace(":true",':"true"',$finalstring);
					$finalstring ="[".str_replace(":false",':"false"',$finalstring)."]";
					$jsonlazyimg  = json_decode($finalstring, true);
					
					//echo "finalstring:";
					//echo $finalstring;
					//echo "<br>";
					//print_r($jsonlazyimg);
					//die();
					
					$reviewcontainerdiv = Array();
					//fix for hotel reviews..
					//if($HotelUserReviews){
					//	$reviewcontainerdiv = $html->find('div.hotels-hotel-review-community-content-review-list-parts-SingleReview__reviewContainer--2LYmA');
					//} else {
					
					//echo $html;
					
						
					if($html->find('div.reviewSelector', 0)){
						$reviewcontainerdiv = $html->find('div.reviewSelector');
						//echo "here1";
					} else if($html->find('div.review-container', 0)){
						$reviewcontainerdiv = $html->find('div.review-container');
						//echo "here2";
					} else if($html->find('div._1c8_1ITO', 0)){
						//print_r($html->find('div._1c8_1ITO', 0));
						$reviewcontainerdiv = $html->find('div._1c8_1ITO', 0)->children;
					} else if($html->find("div[class=Dq9MAugU T870kzTX LnVzGwUB]",0)){
						//echo "here3";
							//another attraction review
							$reviewcontainerdiv = $html->find("div[class=Dq9MAugU T870kzTX LnVzGwUB]");
					} else if($html->find('div[class=eVykL Gi z cPeBe MD cwpFC]',0)){
							//another attraction review
							//eVykL Gi z cPeBe MD cwpFC
							//echo "here4";
							$reviewcontainerdiv = $html->find('div[class=eVykL Gi z cPeBe MD cwpFC]');
					} else if($html->find('div.bPhtn', 0)){
							//another attraction review
							$reviewcontainerdiv = $html->find('div.bPhtn', 0)->children;
						
					} else if($html->find('div.dHjBB', 0)){
							//another attraction review
							$reviewcontainerdiv = $html->find('div.dHjBB', 0)->children;
					} else if($html->find('div.LbPSX', 0)){
							//another attraction review
							$reviewcontainerdiv = $html->find('div.LbPSX', 0)->children;
					}
					if(count($reviewcontainerdiv)<1 && $phatomtry<3){
						
						$phatomtry = 3;
						$localorphantom="phantom";
						goto phantom;
						
						$errormsg = $errormsg . ' Error 103a: Unable to read TripAdvisor page.';
						$this->errormsg = $errormsg;
						
						//echo esc_html__('Error 103a: Unable to read TripAdvisor page. Please contact support', 'wp-review-slider-pro');
						//echo $html;
						//die();	
					}
					//echo "here5";

					//echo $html;
					
					//$html->clear();
					//unset($html);

					//echo "<br><br><br>";
					//print_r($reviewcontainerdiv[0]);
					//die();
					
					
					//echo memory_get_usage();
					//echo "<br>";
					//echo memory_get_peak_usage();
					$foundavatar = false;
					$i = 1;
					foreach ($reviewcontainerdiv as $review) {
						
						//print_r($review);
					//die();
						$tempcheckclass = $review->class;
						$pos = strpos($tempcheckclass, 'recent_review'); //check to see if partial review
						if ($pos === false) {
							if ($i > 21) {
									break;
							}
							$user_name='';
							$userimage='';
							$rating='';
							$datesubmitted='';
							$rtext='';
							// Find user_name
							if($review->find('div.username', 0)){
								$user_name = $review->find('div.username', 0)->plaintext;
							}
							if($user_name==''){
								if($review->find('div.info_text', 0)){
									$user_name = $review->find('div.info_text', 0)->find('div', 0)->plaintext;
								}
							}
							
							if($user_name==''){
								if($review->find("span[class=DrjyGw-P _1SRa-qNz NGv7A1lw _2yS548m8 _2cnjB3re _1TAWSgm1 _1Z1zA2gh _2-K8UW3T _2AAjjcx8]", 0)){
									$user_name = $review->find("span[class=DrjyGw-P _1SRa-qNz NGv7A1lw _2yS548m8 _2cnjB3re _1TAWSgm1 _1Z1zA2gh _2-K8UW3T _2AAjjcx8]", 0)->plaintext;
								}
							}
							if($user_name==''){
								if($review->find("a[class=ui_header_link _1r_My98y]", 0)){
									$user_name = $review->find("a[class=ui_header_link _1r_My98y]", 0)->plaintext;
								}
							}
							if($user_name==''){
								if($review->find("a[class=ui_header_link bPvDb]", 0)){
									$user_name = $review->find("a[class=ui_header_link bPvDb]", 0)->plaintext;
								}
							}
							//for attraction 2
							if($user_name==''){
								if($review->find("a[class=iPqaD _F G- ddFHE eKwUx btBEK fUpii]", 0)){
									$user_name = $review->find("a[class=iPqaD _F G- ddFHE eKwUx btBEK fUpii]", 0)->plaintext;
								}
							}
							//for attraction 2 biGQs _P fiohW fOtGX
							if($user_name==''){
								if($review->find("span[class=biGQs _P fiohW fOtGX]", 0)){
									$user_name = $review->find("span[class=biGQs _P fiohW fOtGX]", 0)->plaintext;
								}
							}
							
							// Find userimage ui_avatar, need to pull from lazy load varible
							if($review->find('div.ui_avatar', 0)){
								if($review->find('div.ui_avatar', 0)->find('img.basicImg', 0)){
									$userimageid = $review->find('div.ui_avatar', 0)->find('img.basicImg', 0)->id;
									//strip id from 
									$userimageid = strrchr ($userimageid , "_" );
									//loop through array and return url
									if (isset($jsonlazyimg) && is_array($jsonlazyimg)){
									for ($x = 0; $x <= count($jsonlazyimg); $x++) {
										//get temp id
										$tempid = $jsonlazyimg[$x]['id'];
										$tempid = strrchr ($tempid , "_" );
										if($userimageid==$tempid){
											$userimage = $jsonlazyimg[$x]['data'];
											$x = count($jsonlazyimg) + 1;
										}
									} 
									}
								}
							}

							//if userimage not found check
							$checkstringpos =  strpos($userimage, 'base64');
							if($userimage =='' || $checkstringpos>0){
								if($review->find('div.ui_avatar', 0)){
									if($review->find('div.ui_avatar', 0)->find('img.basicImg', 0)){
										if($review->find('div.ui_avatar', 0)->find('img.basicImg', 0)->{'data-lazyurl'}){
											$userimage =$review->find('div.ui_avatar', 0)->find('img.basicImg', 0)->{'data-lazyurl'};
										} else {
											$userimage =$review->find('div.ui_avatar', 0)->find('img.basicImg', 0)->src;
										}
									}
								}
								
							}
							//another fix
							if($userimage ==''){
								if($review->find('div.avatar', 0)){
									if($review->find('div.avatar', 0)->find('img.avatar', 0)){
										$userimage =$review->find('div.avatar', 0)->find('img.avatar', 0)->{'src'};
									}
								}
							}
							//one more try for hotels
							if($userimage =='' && $review->find('div.ui_avatar', 0)){
								if($review->find('div.ui_avatar', 0)->find('img.basicImg', 0)){
										$userimage =$review->find('div.ui_avatar', 0)->find('img.basicImg', 0)->src;
								}
							}
							
							//if userimage not found check
							if($userimage =='' && $review->find('div.ui_avatar', 0)){
								if($review->find('div.ui_avatar', 0)->find('img.basicImg', 0)){
									if($review->find('div.ui_avatar', 0)->find('img.basicImg', 0)->{'data-lazyurl'}){
										$userimage =$review->find('div.ui_avatar', 0)->find('img.basicImg', 0)->{'data-lazyurl'};
									}
								}
								//echo "<br>userimage:".$userimage;
							}
							//another check for activities userimage
							if($userimage =='' && $review->find('picture._2f-Th360', 0)){
								if($review->find('picture._2f-Th360', 0)->find('img', 0)){
										$userimage =$review->find('picture._2f-Th360', 0)->find('img', 0)->src;
								}
							}
							//another check for activities userimage
							if($userimage =='' && $review->find("a[class=_3x5_awTA ui_social_avatar inline]", 0)){
								if($review->find("a[class=_3x5_awTA ui_social_avatar inline]", 0)->find('img', 0)){
										$userimage =$review->find("a[class=_3x5_awTA ui_social_avatar inline]", 0)->find('img', 0)->src;
								}
							}
							//another check for activities userimage
							if($userimage =='' && $review->find("a[class=ui_social_avatar inline]", 0)){
								if($review->find("a[class=ui_social_avatar inline]", 0)->find('img', 0)){
										$userimage =$review->find("a[class=ui_social_avatar inline]", 0)->find('img', 0)->src;
								}
							}
							//bugwz I ui_social_avatar inline
							if($userimage =='' && $review->find("a[class=bugwz I ui_social_avatar inline]", 0)){
								if($review->find("a[class=bugwz I ui_social_avatar inline]", 0)->find('img', 0)){
										$userimage =$review->find("a[class=bugwz I ui_social_avatar inline]", 0)->find('img', 0)->src;
								}
							}
							//another check for activities userimage
							if($userimage =='' && $review->find("a[class=iPqaD _F G- ddFHE eKwUx]", 0)){
								if($review->find("a[class=iPqaD _F G- ddFHE eKwUx]", 0)->find('img', 0)){
										$userimage =$review->find("a[class=iPqaD _F G- ddFHE eKwUx]", 0)->find('img', 0)->src;
								}
							}
							//another check for activities userimage
							if($userimage =='' && $review->find("div[class=FGwzt PaRlG]", 0)){
								if($review->find("div[class=FGwzt PaRlG]", 0)->find('img', 0)){
										$userimage =$review->find("div[class=FGwzt PaRlG]", 0)->find('img', 0)->src;
								}
							}
							

							// find rating
							if($review->find('span.ui_bubble_rating', 0)){
								$temprating = $review->find('span.ui_bubble_rating', 0)->class;
								$int = filter_var($temprating, FILTER_SANITIZE_NUMBER_INT);
								//echo $int."<br>";
								$rating = str_replace(0,"",$int);
							}
							
							//rating for activities
							if($rating ==''){
								if($review->find('.zWXXYhVR', 0)){
								$temprating = $review->find('.zWXXYhVR', 0)->title;
								} else if($review->find("svg[class=RWYkj d H0]", 0)){
								$temprating = $review->find("svg[class=RWYkj d H0]", 0)->title;	
								} else if($review->find("svg[class=UctUV d H0]", 0)){
								$temprating = $review->find("svg[class=UctUV d H0]", 0)->getAttribute('aria-label');
								}
								$temprating = str_replace('.0 of 5 bubbles',"",$temprating);
								$temprating = str_replace('Punteggio ',"",$temprating);
								$temprating = str_replace(',0 su 5',"",$temprating);
								$temprating = str_replace(',0 sur 5',"",$temprating);
								$rating = filter_var($temprating, FILTER_SANITIZE_NUMBER_INT);
								$rating = $rating[0];
							}

							//echo "<br>rating: ".$rating;	
							//die();
							
							// find date
							if($review->find('span.ratingDate', 0)){
								$datesubmitted = $review->find('span.ratingDate', 0)->title;
							}
							if($datesubmitted ==''){
								if($review->find('span.ratingDate', 0)){
									$datesubmitted = $review->find('span.ratingDate', 0)->innertext;
									$datesubmitted = preg_replace("(<([a-z]+)>.*?</\\1>)is","",$datesubmitted);
									$datesubmitted = str_replace("Reviewed","",$datesubmitted);
									$datesubmitted = str_replace("Beoordeeld","",$datesubmitted);
									$datesubmitted = str_replace("op","",$datesubmitted);
									$datesubmitted = str_replace('Recensito il',"",$datesubmitted);
								}
							}
							$datesubmitted = str_replace(' г.',"",$datesubmitted);

							//for activities 2 _2fxQ4TOx
							if($datesubmitted ==''){
								if($review->find("div[class=_2fxQ4TOx]", 0)){
									$datesubmitted = $review->find("div[class=_2fxQ4TOx]", 0)->plaintext;
									if(1 === preg_match('~[0-9]~', $datesubmitted)){
										#has numbers
									} else {
										if ($this->yesterdaycontains($datesubmitted)) {
											
											$datesubmitted = date('M d, Y',strtotime("-1 days"));
											//echo "found:".$datesubmitted;
											//die();
										} else {
										$datesubmitted ='';
										}
									}
								}
							}
							//echo "found:".$datesubmitted;
							//for activities 2
							if($datesubmitted ==''){
								if($review->find("span[class=_34Xs-BQm]", 0)){
									$datesubmitted = $review->find("span[class=_34Xs-BQm]", 0)->plaintext;
								}
							}
							
							
							//for activities 2 DrjyGw-P _26S7gyB4 _1z-B2F-n _1dimhEoy
							if($datesubmitted ==''){
								if($review->find("div[class=DrjyGw-P _26S7gyB4 _1z-B2F-n _1dimhEoy]", 0)){
									$datesubmitted = $review->find("div[class=DrjyGw-P _26S7gyB4 _1z-B2F-n _1dimhEoy]", 0)->plaintext;
								}
							}
							//for activities 2 euPKI _R Me S4 H3
							if($datesubmitted ==''){
								if($review->find("span[class=euPKI _R Me S4 H3]", 0)){
									$datesubmitted = $review->find("span[class=euPKI _R Me S4 H3]", 0)->plaintext;
								}
							}
							//for activities
							if($datesubmitted ==''){
								if($review->find("div[class=WlYyy diXIH cspKb bQCoY]", 0)){
									$datesubmitted = $review->find("div[class=WlYyy diXIH cspKb bQCoY]", 0)->plaintext;
								}
							}
							//for activities  biGQs _P pZUbB ncFvv osNWb
							if($datesubmitted ==''){
								if($review->find("div[class=biGQs _P pZUbB ncFvv osNWb]", 0)){
									$datesubmitted = $review->find("div[class=biGQs _P pZUbB ncFvv osNWb]", 0)->plaintext;
								}
							}
							
									$datesubmitted = str_replace($user_name,"",$datesubmitted);
									$datesubmitted = str_replace(" wrote a review ","",$datesubmitted); 
									$datesubmitted = str_replace("Written ","",$datesubmitted);
									$datesubmitted = str_replace("Scritta in data ","",$datesubmitted); 
									$datesubmitted = str_replace("Date of experience:","",$datesubmitted); 
									$datesubmitted = str_replace("Date de l'expérience","",$datesubmitted);
									
								
									$datesubmitted = str_replace("eine Bewertung geschrieben.","",$datesubmitted);
									$datesubmitted = str_replace("hat im","",$datesubmitted);
									$datesubmitted = str_replace("Écrit le ","",$datesubmitted);
									$datesubmitted = str_replace("a écrit un avis","",$datesubmitted);
									$datesubmitted = str_replace("(","",$datesubmitted);
									$datesubmitted = str_replace(")","",$datesubmitted);
									$datesubmitted = str_replace(":","",$datesubmitted);
									
									$string = htmlentities($datesubmitted, null, 'utf-8');
									$content = str_replace("&nbsp;", " ", $string);
									$datesubmitted = html_entity_decode($content);
									
									$datesubmitted = trim($datesubmitted);
							
							//echo "found:".$datesubmitted;
							//die();
											
						
							
							if($ShowUserReviews==true){
								// find text
								if($review->find('div.prw_reviews_text_summary_hsx', 0)){
									$rtext = $review->find('div.prw_reviews_text_summary_hsx', 0)->find('p', 0)->plaintext;
								}
								if($rtext==''){
									if($review->find('div.prw_reviews_resp_sur_review_text', 0)){
										$rtext = $review->find('div.prw_reviews_resp_sur_review_text', 0)->find('p', 0)->plaintext;
									}
								}
								//if this is first one treat differently
								if($i==1){
									if($review->find('div.prw_reviews_resp_sur_review_text', 0)){
										if($review->find('div.prw_reviews_resp_sur_review_text', 0)->find('span.fullText', 0)){
											$rtext = $review->find('div.prw_reviews_resp_sur_review_text', 0)->find('span.fullText', 0)->plaintext;
										} else {
											$rtext = $review->find('div.prw_reviews_resp_sur_review_text', 0)->find('p', 0)->plaintext;
										}
									} else if($review->find('div.prw_reviews_resp_sur_review_text_expanded', 0)){
										$rtext = $review->find('div.prw_reviews_resp_sur_review_text_expanded', 0)->find('p', 0)->plaintext;
									}
								}
								
							} else {
								// find text
								if($review->find('div.prw_reviews_text_summary_hsx', 0)){
									$rtext = $review->find('div.prw_reviews_text_summary_hsx', 0)->find('p', 0)->plaintext;
								}

							}
							
							//backukp text method for hotel
							if($rtext ==''){
								if($review->find('div.prw_reviews_text_summary_hsx', 0)){
								$rtext = $review->find('div.prw_reviews_text_summary_hsx', 0)->find('p', 0)->plaintext;
								}
							}
							if($rtext ==''){
								if($review->find('div.vrReviewText', 0)){
									$rtext = $review->find('div.vrReviewText', 0)->find('p', 0)->plaintext;
								}
							}
							//if rtext is blank try one more time, used to get top review on hotels
							if($rtext==''){
								if($review->find('div.entry', 0)){
									$rtext = $review->find('div.entry', 0)->find('p', 0)->plaintext;
								}
							}
							//try again for activities
							if($rtext==''){
								if($review->find("div[class=DrjyGw-P _26S7gyB4 _2nPM5Opx]", 0)){
									$rtext = $review->find("div[class=DrjyGw-P _26S7gyB4 _2nPM5Opx]", 0)->plaintext;
								}
							}
							//try again for activities
							if($rtext==''){
								if($review->find("div[class=cPQsENeY]", 0)){
									$rtext = $review->find("div[class=cPQsENeY]", 0)->plaintext;
								}
							}
							//try again for activities
							if($rtext==''){
								if($review->find("q[class=XllAv H4 _a]", 0)){
									$rtext = $review->find("q[class=XllAv H4 _a]", 0)->plaintext;
									//$rtext = mb_substr($rtext, 0, -10);
									$rtext = str_replace("…","",$rtext);
								}
							}
							//try again for activities
							if($rtext==''){
								if($review->find("div[class=WlYyy diXIH dDKKM]", 0)){
									$rtext = $review->find("div[class=WlYyy diXIH dDKKM]", 0)->plaintext;
									//$rtext = mb_substr($rtext, 0, -10);
									$rtext = str_replace("…","",$rtext);
								}
							}
							//try again for activities
							if($rtext==''){
								if($review->find("div[class=biGQs _P pZUbB KxBGd]", 0)){
									$rtext = $review->find("div[class=biGQs _P pZUbB KxBGd]", 0)->plaintext;
									//$rtext = mb_substr($rtext, 0, -10);
									$rtext = str_replace("…","",$rtext);
								}
							}
							
							$rtext = str_replace("…","",$rtext);
							$rtext = str_replace("&hellip;","",$rtext);
							
							$review_title ='';
							if($review->find("span[class=noQuotes]", 0)){
								$review_title = $review->find("span[class=noQuotes]", 0)->plaintext;
							}
														
							//echo $user_name;
							//echo "<br>-<br>";
							//echo $userimage;
							//echo "<br>-<br>";
							//echo $rating;
							//echo "<br>-<br>";
							//echo $datesubmitted;
							//echo "<br>-<br>";
							//echo $rtext;
							//die();
							
							if($rating>0 && $rtext!=''){
								$review_length = str_word_count($rtext);
								$pos = strpos($userimage, 'default_avatars');
								if ($pos === false) {
									$userimage = str_replace("60s.jpg","120s.jpg",$userimage);
								}
								
								
								//$timestamp = strtotime($datesubmitted);
								//echo $datesubmitted."<br>";
								$timestamp = $this->myStrtotime($datesubmitted);
								//echo $timestamp."<br>";
								$unixtimestamp = $timestamp;
								$timestamp = date("Y-m-d H:i:s", $timestamp);
								//echo $timestamp."<br>";
								//echo "here";
								//die();
								//check option to see if this one has been hidden
								//pull array from options table of tripadvisor hidden
								$tripadvisorhidden = get_option( 'wptripadvisor_hidden_reviews' );
								if(!$tripadvisorhidden){
									$tripadvisorhiddenarray = array('');
								} else {
									$tripadvisorhiddenarray = json_decode($tripadvisorhidden,true);
								}
								$this_tripadvisor_val = trim($user_name)."-".strtotime($datesubmitted)."-".$review_length."-TripAdvisor-".$rating;
								if (in_array($this_tripadvisor_val, $tripadvisorhiddenarray)){
									$hideme = 'yes';
								} else {
									$hideme = 'no';
								}
								
								//add check to see if already in db, skip if it is and end loop
								$reviewindb = 'no';
								$user_name = trim($user_name);
								
								//$checkrow = $wpdb->get_var( 'SELECT id FROM '.$table_name.' WHERE reviewer_name = "'.$user_name.'" AND (review_length = "'.$review_length.'" OR created_time = "'.$timestamp.'")' );
								
								$checkrow = $wpdb->get_var( "SELECT id FROM ".$table_name." WHERE reviewer_name = '".$user_name."' AND (review_length = '".$review_length."' OR created_time = '".$timestamp."')" );
						
								if( empty( $checkrow ) ){
										$reviewindb = 'no';
								} else {
										$reviewindb = 'yes';
								}
								
								if($userimage!=''){
									$foundavatar = true;
								}
								
								if( $reviewindb == 'no' )
								{
								$reviews[] = [
										'reviewer_name' => $user_name,
										'pagename' => trim($pagename),
										'userpic' => $userimage,
										'rating' => $rating,
										'created_time' => $timestamp,
										'created_time_stamp' => $unixtimestamp,
										'review_text' => trim($rtext),
										'hide' => $hideme,
										'review_length' => $review_length,
										'type' => 'TripAdvisor',
										'review_title' => $review_title
								];
								}
								$review_length ='';
							}
					 
							$i++;
					}
					}

					//find total number here and end break loop early if total number less than 50. review-count
					//$totalreviews = $html->find('span.header_rating', 0)->find('span[property=v:count]', 0)->plaintext;
					//$totalreviews = intval($totalreviews);
					//if (($n*20) > $totalreviews) {
					//				break;
					//		}
					//sleep for random 2 seconds
					sleep(rand(0,2));
					$n++;
					
				
					//print_r($reviews);
				
				//remove duplicates
				//remove duplicates
				$reviewtexts = [];
				$insertreviews = [];
				foreach ( $reviews as $stat ){
					if (!in_array($stat['review_text'], $reviewtexts)) {
						$insertreviews[] = $stat;
					}
					$reviewtexts[] = $stat['review_text'];
				}
				//print_r($insertreviews);
				//print("<pre>".print_r($insertreviews,true)."</pre>");
				//die();
			
				//add all new tripadvisor reviews to db
				$insertnum=0;
				foreach ( $insertreviews as $stat ){
					$insertnum = $wpdb->insert( $table_name, $stat );
				}
				
				//if on first page now try to find second page and loop again.
				if($ShowUserReviews && $loop < 2 && $onfirstpage){
					if($html->find("a[class=nav next ui_button primary]",0)){
						$newurl = $html->find("a[class=nav next ui_button primary]",0)->href;
						$urlvalue = $parseurl['scheme'].'://'.$parseurl['host'].$newurl;
						if (strpos($urlvalue, 'ShowUserReviews') !== false) {
							//echo $urlvalue;
							//die();
							$loop++;
							goto start;
						}
					} else if($html->find("a[class=nav next]",0)){
						$newurl = $html->find("a[class=nav next]",0)->href;
						$urlvalue = $parseurl['scheme'].'://'.$parseurl['host'].$newurl;
						if (strpos($urlvalue, 'ShowUserReviews') !== false) {
							//echo $urlvalue;
							//die();
							$loop++;
							goto start;
						}
					}						
				}
				//reviews added to db
				if($insertnum>0){
					$errormsg = $errormsg . ' TripAdvisor reviews downloaded. They should now be on the Review List page.';
					$this->errormsg = $errormsg;
				} else {
					$errormsg = $errormsg . ' Unable to find any new reviews.';
					$this->errormsg = $errormsg;
				}
				
									// clean up memory
				if (!empty($html)) {
					$html->clear();
					unset($html);
				}
				if (!empty($reviewcontainerdiv)) {
					unset($reviewcontainerdiv);
				}

				// clean up memory
				if (!empty($html)) {
					$html->clear();
					unset($html);
				}
				if (!empty($html)) {
					$html->clear();
					unset($html);
				}
				
			 // }
			  
			  
			} else {
				$errormsg = $errormsg . ' Please enter a valid URL.';
				$this->errormsg = $errormsg;
			}
			/*
			if($options['tripadvisor_radio']=='no'){
				$wpdb->delete( $table_name, array( 'type' => 'TripAdvisor' ) );
				//cancel wp cron job
			}
			*/
			

		if($errormsg !=''){
			//echo $errormsg;
		}
	}
	

	
	/**
	 * check if string has yesterday in it for date
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function yesterdaycontains($str)
	{
		//echo '<br>str:'.$str;
		
		$array = array("Hier", "yesterday", "ieri", "ayer","gisteren");
		foreach($array as $a) {
			if (stripos($str,$a) !== false){
				return true;
			}
		}
		return false;
	}
	
	
	/**
	 * displays message in admin if it's been longer than 30 days.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function wprp_admin_notice__success () {

		$activatedtime = get_option('wprev_activated_time_trip');
		//if this is an old install then use 23 days ago
		if($activatedtime==''){
			$activatedtime= time() - (86400*23);
			update_option( 'wprev_activated_time_trip', $activatedtime );
		}
		$thirtydaysago = time() - (86400*14);
		
		//check if an option was clicked on
		if (isset($_GET['wprevpronotice'])) {
		  $wprevpronotice = $_GET['wprevpronotice'];
		} else {
		  //Handle the case where there is no parameter
		   $wprevpronotice = '';
		}
		if($wprevpronotice=='mlater_trip'){		//hide the notice for another 30 days
			update_option( 'wprev_notice_hide_trip', 'later' );
			$newtime = time() - (86400*21);
			update_option( 'wprev_activated_time_trip', $newtime );
			$activatedtime = $newtime;
			
		} else if($wprevpronotice=='notagain_trip'){		//hide the notice forever
			update_option( 'wprev_notice_hide_trip', 'never' );
		}
		
		$wprev_notice_hide = get_option('wprev_notice_hide_trip');

		if($activatedtime<$thirtydaysago && $wprev_notice_hide!='never'){
		
			$urltrimmedtab = remove_query_arg( array('taction', 'tid', 'sortby', 'sortdir', 'opt') );
			$urlmayberlater = esc_url( add_query_arg( 'wprevpronotice', 'mlater_trip',$urltrimmedtab ) );
			$urlnotagain = esc_url( add_query_arg( 'wprevpronotice', 'notagain_trip',$urltrimmedtab ) );
			
			$temphtml = '<p>Hey, I noticed you\'ve been using my <b>WP TripAdvisor Review Slider</b> plugin for a while now – that’s awesome! Could you please do me a BIG favor and give it a 5-star rating on WordPress? <br>
			Thanks!<br>
			~ Josh W.<br></p>
			<ul>
			<li><a href="https://wordpress.org/support/plugin/wp-tripadvisor-review-slider/reviews/#new-post" target="_blank">Ok, you deserve it</a></li>
			<li><a href="'.$urlmayberlater.'">Not right now, maybe later</a></li>
			<li><a href="'.$urlnotagain.'">Don\'t remind me again</a></li>
			</ul>
			<p>P.S. If you\'ve been thinking about upgrading to the <a href="https://wpreviewslider.com/" target="_blank">Pro</a> version, here\'s a 10% off coupon code you can use! ->  <b>wprevpro10off</b></p>';
			
			?>
			<div class="notice notice-info">
				<div class="wprevpro_admin_notice" style="color: #007500;">
				<?php _e( $temphtml, $this->_token ); ?>
				</div>
			</div>
			<?php
		}

	}
	
			/**
	 * add dashboard widget to wordpress admin
	 * @access  public
	 * @since   7.1
	 * @return  void
	 */
	public function wprevtrip_dashboard_widget() {
		global $wp_meta_boxes;
		//wp_add_dashboard_widget('custom_help_widget', 'Theme Support', 'custom_dashboard_help');
		add_meta_box( 'id', 'WP TripAdvisor Review Slider Recent Reviews', array($this,'custom_dashboard_help'), 'dashboard', 'side', 'high' );
	}
	 
	public function custom_dashboard_help() {
		global $wpdb;
		$reviews_table_name = $wpdb->prefix . 'wptripadvisor_reviews';
		$tempquery = "select * from ".$reviews_table_name." ORDER by created_time_stamp Desc limit 4";
		$reviewrows = $wpdb->get_results($tempquery);
		$now = time(); // or your date as well
		
		echo '<style>
			img.wprev_dash_avatar {float: left;margin-right: 8px;border-radius: 20px;}
			.wprev_dash_stars {float: right;}
			p.wprev_dash_text {margin-top: -6px;}
			span.wprev_dash_timeago {font-size: 12px;font-style: italic;}
			.wprev_dash_revdiv {min-height: 50px;}
			</style>';
		echo '<ul>';
		foreach ( $reviewrows as $review ) 
		{
			$timesince = '';
			if(strlen($review->review_text)>130){
				$reviewtext = substr($review->review_text,0,130).'...';
			} else {
				$reviewtext = $review->review_text;
			}
			
			$your_date = $review->created_time_stamp;
			$datediff = $now - $your_date;
			$daysago = round($datediff / (60 * 60 * 24));
			if($daysago==1){
				$daysagohtml = $daysago.' day ago';
			} else {
				$daysagohtml = $daysago.' days ago';
			}
			if($review->rating<1){
				if($review->recommendation_type=='positive'){
					$review->rating=5;
				} else {
					$review->rating=2;
				}
			}

			$imgs_url = plugin_dir_url(__DIR__).'/public/partials/imgs/';
			$starfile = 'tripadvisor_stars_'.$review->rating.'.png';
			$starhtml='<img src="'.$imgs_url."".$starfile.'" alt="'.$review->rating.' star rating" class="wprev_dash_stars">';
			
			$avatarhtml = '';
			if(isset($review->userpic) && $review->userpic!=''){
				$avatarhtml = '<img alt="" src="'.$review->userpic.'" class="wprev_dash_avatar" height="40" width="40">';
			}
			
			echo '<li><div class="wprev_dash_revdiv">'.$avatarhtml.'<div class="wprev_dash_stars">'.$starhtml.'</div><h4 class="wprev_dash_name">'.$review->reviewer_name.' - <span class="wprev_dash_timeago">'.$daysagohtml.'</span></h4><p class="wprev_dash_text">'.$reviewtext.'</p></div></li>';
			
		}
		echo '</ul>';
		
		echo '<div><a href="admin.php?page=wp_tripadvisor-reviews">All Reviews</a> - <a href="https://wpreviewslider.com/" target="_blank">Go Pro For More Cool Features!</a></div>';
	}
	
	
	

    

}
