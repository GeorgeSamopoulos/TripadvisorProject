<?php
/*
Plugin Name: WP Tripadvisor Review Widgets
Plugin Title: WP Tripadvisor Review Widgets Plugin
Plugin URI: https://wordpress.org/plugins/review-widgets-for-tripadvisor/
Description: Embed Tripadvisor reviews fast and easily into your WordPress site. Increase SEO, trust and sales using Tripadvisor reviews.
Tags: tripadvisor, reviews, hotels, restaurant, accommodation, bar, reviews, ratings, recommendations, testimonials, widget, slider, review, rating, recommendation, testimonial, customer review
Author: Trustindex.io <support@trustindex.io>
Author URI: https://www.trustindex.io/
Contributors: trustindex
License: GPLv2 or later
Version: 10.3
Text Domain: review-widgets-for-tripadvisor
Domain Path: /languages/
Donate link: https://www.trustindex.io/prices/
*/
/*
Copyright 2019 Trustindex Kft (email: support@trustindex.io)
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
require_once plugin_dir_path( __FILE__ ) . 'trustindex-plugin.class.php';
$trustindex_pm_tripadvisor = new TrustindexPlugin_tripadvisor("tripadvisor", __FILE__, "10.3", "WP Tripadvisor Review Widgets", "Tripadvisor");
register_activation_hook(__FILE__, array($trustindex_pm_tripadvisor, 'activate'));
register_deactivation_hook(__FILE__, array($trustindex_pm_tripadvisor, 'deactivate'));
add_action('admin_menu', array($trustindex_pm_tripadvisor, 'add_setting_menu'), 10);
add_filter('plugin_action_links', array($trustindex_pm_tripadvisor, 'add_plugin_action_links'), 10, 2);
add_filter('plugin_row_meta', array($trustindex_pm_tripadvisor, 'add_plugin_meta_links'), 10, 2);
if(!function_exists('register_block_type'))
{
add_action('widgets_init', array($trustindex_pm_tripadvisor, 'init_widget'));
add_action('widgets_init', array($trustindex_pm_tripadvisor, 'register_widget'));
}
if(is_file($trustindex_pm_tripadvisor->getCssFile()))
{
add_action('init', function() {
global $trustindex_pm_tripadvisor;
if(!isset($trustindex_pm_tripadvisor) || is_null($trustindex_pm_tripadvisor))
{
require_once plugin_dir_path( __FILE__ ) . 'trustindex-plugin.class.php';
$trustindex_pm_tripadvisor = new TrustindexPlugin_tripadvisor("tripadvisor", __FILE__, "10.3", "WP Tripadvisor Review Widgets", "Tripadvisor");
}
$path = wp_upload_dir()['baseurl'] .'/'. $trustindex_pm_tripadvisor->getCssFile(true);
if(is_ssl())
{
$path = str_replace('http://', 'https://', $path);
}
wp_register_style('ti-widget-css-tripadvisor', $path, [], filemtime($trustindex_pm_tripadvisor->getCssFile()));
});
}
if (!function_exists("ti_exclude_js"))
{
function ti_exclude_js($list) {
$list[] = 'trustindex.io';
return $list;
}
}
add_filter('rocket_exclude_js', 'ti_exclude_js');
add_filter('litespeed_optimize_js_excludes', 'ti_exclude_js');
if (!function_exists("ti_exclude_inline_js"))
{
function ti_exclude_inline_js($list) {
$list[] = 'Trustindex.init_pager';
return $list;
}
}
add_filter('rocket_excluded_inline_js_content', 'ti_exclude_inline_js');
add_action('init', array($trustindex_pm_tripadvisor, 'init_shortcode'));
add_filter('script_loader_tag', function($tag, $handle) {
if(strpos($tag, 'trustindex.io/loader.js') !== false && strpos($tag, 'defer async') === false) {
$tag = str_replace(' src', ' defer async src', $tag );
}
return $tag;
}, 10, 2);
add_action('init', array($trustindex_pm_tripadvisor, 'register_tinymce_features'));
add_action('init', array($trustindex_pm_tripadvisor, 'output_buffer'));
add_action('wp_ajax_list_trustindex_widgets', array($trustindex_pm_tripadvisor, 'list_trustindex_widgets_ajax'));
add_action('admin_enqueue_scripts', array($trustindex_pm_tripadvisor, 'trustindex_add_scripts'));
add_action('rest_api_init', array($trustindex_pm_tripadvisor, 'init_restapi'));
add_action('admin_notices', function() {
$rate_us = get_option('trustindex-tripadvisor-rate-us', time() - 1);
if($rate_us == 'hide' || (int)$rate_us > time())
{
return;
}
$dir = plugin_dir_path( __FILE__ );
$usage_time = time() + 10;
if(is_dir($dir))
{
$usage_time = filemtime($dir) + (1 * 86400);
}
if($usage_time > time())
{
return;
}
?>
<div class="notice notice-warning is-dismissible trustindex-popup" style="position: fixed; top: 50px; right: 20px; padding-right: 30px; z-index: 1">
<p>
<?php echo TrustindexPlugin_tripadvisor::___("Hello, I am happy to see that you've been using our <strong>%s</strong> plugin for a while now!", ["WP Tripadvisor Review Widgets"]); ?><br>
<?php echo TrustindexPlugin_tripadvisor::___("Could you please help us and give it a 5-star rating on WordPress?"); ?><br><br>
<?php echo TrustindexPlugin_tripadvisor::___("-- Thanks, Gabor M."); ?>
</p>
<p>
<a href="<?php echo admin_url("admin.php?page=review-widgets-for-tripadvisor/settings.php&rate_us=open"); ?>" class="trustindex-rateus" style="text-decoration: none" target="_blank">
<button class="button ti-button-primary button-primary"><?php echo TrustindexPlugin_tripadvisor::___("Sure, you deserve it"); ?></button>
</a>
<a href="<?php echo admin_url("admin.php?page=review-widgets-for-tripadvisor/settings.php&rate_us=later"); ?>" class="trustindex-rateus" style="text-decoration: none">
<button class="button ti-button-default button-secondary"><?php echo TrustindexPlugin_tripadvisor::___("Maybe later"); ?></button>
</a>
<a href="<?php echo admin_url("admin.php?page=review-widgets-for-tripadvisor/settings.php&rate_us=hide"); ?>" class="trustindex-rateus" style="text-decoration: none">
<button class="button ti-button-default button-secondary" style="float: right"><?php echo TrustindexPlugin_tripadvisor::___("Do not remind me again"); ?></button>
</a>
</p>
</div>
<?php
});
if(class_exists('Woocommerce') && !class_exists('TrustindexCollectorPlugin') && !function_exists('ti_woocommerce_notice'))
{
function ti_woocommerce_notice() {
$rate_us = get_option('trustindex-wc-notification', time() - 1);
if($rate_us == 'hide' || (int)$rate_us > time())
{
return;
}
?>
<div class="notice notice-warning is-dismissible" style="margin: 5px 0 15px">
<p><strong><?php echo TrustindexPlugin_tripadvisor::___("Download our new <a href='%s' target='_blank'>%s</a> plugin and get features for free!", [ 'https://wordpress.org/plugins/customer-reviews-collector-for-woocommerce/', TrustindexPlugin_tripadvisor::___('Customer Reviews Collector for WooCommerce') ]); ?></strong></p>
<ul style="list-style-type: disc; margin-left: 10px; padding-left: 15px">
<li><?php echo TrustindexPlugin_tripadvisor::___('Send unlimited review invitations for free'); ?></li>
<li><?php echo TrustindexPlugin_tripadvisor::___('E-mail templates are fully customizable'); ?></li>
<li><?php echo TrustindexPlugin_tripadvisor::___('Collect reviews on 100+ review platforms (Google, Facebook, Yelp, etc.)'); ?></li>
</ul>
<p>
<a href="<?php echo admin_url("admin.php?page=review-widgets-for-tripadvisor/settings.php&wc_notification=open"); ?>" target="_blank" class="trustindex-rateus" style="text-decoration: none">
<button class="button button-primary"><?php echo TrustindexPlugin_tripadvisor::___("Download plugin"); ?></button>
</a>
<a href="<?php echo admin_url("admin.php?page=review-widgets-for-tripadvisor/settings.php&wc_notification=hide"); ?>" class="trustindex-rateus" style="text-decoration: none">
<button class="button button-secondary"><?php echo TrustindexPlugin_tripadvisor::___("Do not remind me again"); ?></button>
</a>
</p>
</div>
<?php
}
add_action('admin_notices', 'ti_woocommerce_notice');
}
add_action('plugins_loaded', array($trustindex_pm_tripadvisor, 'plugin_loaded'));
add_action('wp_ajax_nopriv_'. $trustindex_pm_tripadvisor->get_webhook_action(), $trustindex_pm_tripadvisor->get_webhook_action());
add_action('wp_ajax_'. $trustindex_pm_tripadvisor->get_webhook_action(), $trustindex_pm_tripadvisor->get_webhook_action());
function trustindex_reviews_hook_tripadvisor() {
global $trustindex_pm_tripadvisor;
global $wpdb;
$token = isset($_POST['token']) ? sanitize_text_field($_POST['token']) : "";
if(isset($_POST['test']) && $token == get_option($trustindex_pm_tripadvisor->get_option_name('review-download-token')))
{
echo $token;
exit;
}
$our_token = $trustindex_pm_tripadvisor->is_review_download_in_progress();
if(!$our_token)
{
$our_token = get_option($trustindex_pm_tripadvisor->get_option_name('review-download-token'));
}
try
{
if(!$token || $our_token != $token)
{
throw new Exception('Token invalid');
}
if(!$trustindex_pm_tripadvisor->is_noreg_linked())
{
throw new Exception('Platform not connected');
}
$name = 'Unknown source';
if(isset($_POST['error']) && $_POST['error'])
{
update_option($trustindex_pm_tripadvisor->get_option_name('review-download-inprogress'), 'error', false);
}
else
{
if(isset($_POST['details']))
{
$trustindex_pm_tripadvisor->save_details($_POST['details']);
$trustindex_pm_tripadvisor->save_reviews(isset($_POST['reviews']) ? $_POST['reviews'] : []);
}
delete_option($trustindex_pm_tripadvisor->get_option_name('review-download-inprogress'));
delete_option($trustindex_pm_tripadvisor->get_option_name('review-manual-download'));
}
update_option($trustindex_pm_tripadvisor->get_option_name('download-timestamp'), time() + (86400 * 10), false);
update_option($trustindex_pm_tripadvisor->get_option_name('review-download-notification'), 1, false);
try
{
$subject = 'Tripadvisor reviews downloaded';
$message = '
<p>Great news!</p>
<p><strong>Your reviews are downloaded <span style="color: red">from Tripadvisor</span>!</strong></p>
<p>Create amazing review widgets on your website. You can choose from 40 review widget layouts and 25 widget styles.</p>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate !important;border-radius: 3px;background-color: #2AA8D7;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
<tbody>
<tr>
<td align="center" valign="middle" style="font-family: Arial;font-size: 16px;padding: 12px 20px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
<a title="Create review widget now! »" href="'. admin_url('admin.php') .'?page='. urlencode($trustindex_pm_tripadvisor->get_plugin_slug() .'/settings.php') .'&tab=setup_no_reg" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;display: block;">Create review widget now! »</a>
</td>
</tr>
</tbody>
</table>
';
$headers = [ 'Content-Type: text/html; charset=UTF-8' ];
wp_mail(get_option('admin_email'), $subject, $message, $headers, [ '' ]);
}
catch(Exception $e) { }
echo $our_token;
}
catch(Exception $e) {
echo 'Error in WP: '. $e->getMessage();
}
exit;
}
add_action('admin_notices', function() {
$notification = get_option('trustindex-tripadvisor-review-download-notification', 0);
if(!$notification)
{
return;
}
?>
<div class="notice notice-warning" style="margin: 5px 0 15px">
<p>
<?php echo TrustindexPlugin_tripadvisor::___('Your reviews are downloaded from %s!', [ 'Tripadvisor' ]); ?>
</p>
<p>
<a href="<?php echo admin_url("admin.php?page=review-widgets-for-tripadvisor/settings.php&review_download_notification"); ?>" style="text-decoration: none">
<button class="button button-primary"><?php echo TrustindexPlugin_tripadvisor::___("Create review widget now! »"); ?></button>
</a>
</p>
</div>
<?php
});
?>