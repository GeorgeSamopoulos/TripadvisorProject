<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
$auto_updates = get_option('auto_update_plugins', []);
$plugin_slug = "review-widgets-for-tripadvisor/review-widgets-for-tripadvisor.php";
if(isset($_GET['auto_update']))
{
if(!in_array($plugin_slug, $auto_updates))
{
array_push($auto_updates, $plugin_slug);
update_option('auto_update_plugins', $auto_updates, false);
}
header('Location: admin.php?page=' . sanitize_text_field($_GET['page']) . '&tab=troubleshooting');
exit;
}
if(isset($_GET['toggle_css_inline']))
{
$v = intval($_GET['toggle_css_inline']);
update_option($trustindex_pm_tripadvisor->get_option_name('load-css-inline'), $v, false);
if($v && is_file($trustindex_pm_tripadvisor->getCssFile()))
{
unlink($trustindex_pm_tripadvisor->getCssFile());
}
header('Location: admin.php?page=' . sanitize_text_field($_GET['page']) . '&tab=troubleshooting');
exit;
}
if(isset($_GET['delete_css']))
{
if(is_file($trustindex_pm_tripadvisor->getCssFile()))
{
unlink($trustindex_pm_tripadvisor->getCssFile());
}
header('Location: admin.php?page=' . sanitize_text_field($_GET['page']) . '&tab=troubleshooting');
exit;
}
$yes_icon = '<span class="dashicons dashicons-yes-alt"></span>';
$no_icon = '<span class="dashicons dashicons-dismiss"></span>';
$plugin_updated = ($trustindex_pm_tripadvisor->get_plugin_current_version() <= "10.3");
$css_inline = get_option($trustindex_pm_tripadvisor->get_option_name('load-css-inline'), 0);
$css = get_option($trustindex_pm_tripadvisor->get_option_name('css-content'));
?>
<div class="ti-box">
<div class="ti-box-header"><?php echo TrustindexPlugin_tripadvisor::___("Troubleshooting"); ?></div>
<p><strong><?php echo TrustindexPlugin_tripadvisor::___('If you have any problem, you should try these steps:'); ?></strong></p>
<ul class="troubleshooting-checklist">
<li>
<?php echo TrustindexPlugin_tripadvisor::___("Trustindex plugin"); ?>
<ul>
<li>
<?php echo TrustindexPlugin_tripadvisor::___('Use the latest version:') .' '. ($plugin_updated ? $yes_icon : $no_icon); ?>
<?php if(!$plugin_updated): ?>
<a href="/wp-admin/plugins.php"><?php echo TrustindexPlugin_tripadvisor::___("Update"); ?></a>
<?php endif; ?>
</li>
<li>
<?php echo TrustindexPlugin_tripadvisor::___('Use automatic plugin update:') .' '. (in_array($plugin_slug, $auto_updates) ? $yes_icon : $no_icon); ?>
<?php if(!in_array($plugin_slug, $auto_updates)): ?>
<a href="?page=<?php echo sanitize_text_field($_GET['page']); ?>&tab=troubleshooting&auto_update"><?php echo TrustindexPlugin_tripadvisor::___("Enable"); ?></a>
<div class="ti-notice notice-warning">
<p><?php echo TrustindexPlugin_tripadvisor::___("You should enable it, to get new features and fixes automatically, right after they published!"); ?></p>
</div>
<?php endif; ?>
</li>
</ul>
</li>
<?php if($css): ?>
<li>
CSS
<ul>
<li><?php
$upload_dir = dirname($trustindex_pm_tripadvisor->getCssFile());
echo TrustindexPlugin_tripadvisor::___('writing permission') .' (<strong>'. $upload_dir .'</strong>): '. (is_writable($upload_dir) ? $yes_icon : $no_icon); ?>
</li>
<li>
<?php echo TrustindexPlugin_tripadvisor::___('CSS content:'); ?>
<?php
if(is_file($trustindex_pm_tripadvisor->getCssFile()))
{
$content = file_get_contents($trustindex_pm_tripadvisor->getCssFile());
if($content === $css)
{
echo $yes_icon;
}
else
{
echo $no_icon .' '. TrustindexPlugin_tripadvisor::___("corrupted") .'
<div class="ti-notice notice-warning">
<p><a href="?page='. sanitize_text_field($_GET['page']) .'&tab=troubleshooting&delete_css">'. TrustindexPlugin_tripadvisor::___("Delete the CSS file at <strong>%s</strong>.", [ $trustindex_pm_tripadvisor->getCssFile() ]) .'</a></p>
</div>';
}
}
else
{
echo $no_icon;
}
?>
<span class="ti-checkbox row" style="margin-top: 5px">
<input type="checkbox" value="1" <?php if($css_inline): ?>checked<?php endif;?> onchange="window.location.href = '?page=<?php echo sanitize_text_field($_GET['page']); ?>&tab=troubleshooting&toggle_css_inline=' + (this.checked ? 1 : 0)">
<label><?php echo TrustindexPlugin_tripadvisor::___("Enable CSS internal loading"); ?></label>
</span>
</li>
</ul>
</li>
<?php endif; ?>
<li>
<?php echo TrustindexPlugin_tripadvisor::___('If you are using cacher plugin, you should:'); ?>
<ul>
<li><?php echo TrustindexPlugin_tripadvisor::___('clear the cache'); ?></li>
<li><?php echo TrustindexPlugin_tripadvisor::___("exclude Trustindex's JS file:"); ?> <strong><?php echo 'https://cdn.trustindex.io/'; ?>loader.js</strong>
<ul>
<li><a href="#" onclick="jQuery('#list-w3-total-cache').toggle(); return false;">W3 Total Cache</a>
<ol id="list-w3-total-cache" style="display: none;">
<li><?php echo TrustindexPlugin_tripadvisor::___('Navigate to'); ?> "Performance" > "Minify"</li>
<li><?php echo TrustindexPlugin_tripadvisor::___('Scroll to'); ?> "Never minify the following JS files"</li>
<li><?php echo TrustindexPlugin_tripadvisor::___('In a new line, add'); ?> https://cdn.trustindex.io/*</li>
<li><?php echo TrustindexPlugin_tripadvisor::___('Save'); ?></li>
</ol>
</li>
</ul>
</li>
</ul>
</li>
<li>
<?php
$plugin_url = 'https://wordpress.org/support/plugin/' . $trustindex_pm_tripadvisor->get_plugin_slug();
$screenshot_url = 'https://snipboard.io';
$screencast_url = 'https://streamable.com/upload-video';
$pastebin_url = 'https://pastebin.com';
echo TrustindexPlugin_tripadvisor::___("If the problem/question still exists, please create an issue here: %s", [ '<a href="'. $plugin_url .'" target="_blank">'. $plugin_url .'</a>' ]);
?>
<br />
<?php echo TrustindexPlugin_tripadvisor::___('Please help us with some information:'); ?>
<ul>
<li><?php echo TrustindexPlugin_tripadvisor::___('Describe your problem'); ?></li>
<li><?php echo TrustindexPlugin_tripadvisor::___('You can share a screenshot with %s', [ '<a href="'. $screenshot_url .'" target="_blank">'. $screenshot_url .'</a>' ]); ?></li>
<li><?php echo TrustindexPlugin_tripadvisor::___('You can share a screencast video with %s', [ '<a href="'. $screencast_url .'" target="_blank">'. $screencast_url .'</a>' ]); ?></li>
<li><?php echo TrustindexPlugin_tripadvisor::___('If you have an (webserver) error log, you can copy it to the issue, or link it with %s', [ '<a href="'. $pastebin_url .'" target="_blank">'. $pastebin_url .'</a>' ]); ?></li>
<li><?php echo TrustindexPlugin_tripadvisor::___('And include the information below:'); ?></li>
</ul>
</li>
</ul>
<textarea class="ti-troubleshooting-info" readonly><?php include $trustindex_pm_tripadvisor->get_plugin_dir() . 'include' . DIRECTORY_SEPARATOR . 'troubleshooting.php'; ?></textarea>
<a href=".ti-troubleshooting-info" class="btn-text btn-copy2clipboard ti-pull-right ti-tooltip toggle-tooltip ti-tooltip-left">
<?php echo TrustindexPlugin_tripadvisor::___("Copy to clipboard") ;?>
<span class="ti-tooltip-message">
<span style="color: #00ff00; margin-right: 2px">✓</span>
<?php echo TrustindexPlugin_tripadvisor::___("Copied"); ?>
</span>
</a>
<div class="clear"></div>
</div>
<div class="ti-box">
<div class="ti-box-header"><?php echo TrustindexPlugin_tripadvisor::___("Re-create plugin"); ?></div>
<p><?php echo TrustindexPlugin_tripadvisor::___('Re-create the database tables of the plugin.<br />Please note: this removes all settings and reviews.'); ?></p>
<a href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=setup_no_reg&recreate" class="btn-text btn-refresh ti-pull-right" style="margin-left: 0"><?php echo TrustindexPlugin_tripadvisor::___("Re-create plugin"); ?></a>
<div class="clear"></div>
</div>
<div class="ti-box">
<div class="ti-box-header"><?php echo TrustindexPlugin_tripadvisor::___("Translation"); ?></div>
<p>
<?php echo TrustindexPlugin_tripadvisor::___('If you notice an incorrect translation in the plugin text, please report it here:'); ?>
 <a href="mailto:support@trustindex.io">support@trustindex.io</a>
</p>
</div>