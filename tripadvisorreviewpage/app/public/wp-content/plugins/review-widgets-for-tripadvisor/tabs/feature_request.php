<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
if(isset($_POST['command']) && $_POST['command'] == 'send-feature-request')
{
check_admin_referer('send-feature-request_'.$trustindex_pm_tripadvisor->get_plugin_slug(), '_wpnonce_send_feature_request');
$name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : "";
$email = isset($_POST['email']) ? sanitize_email($_POST['email']) : "";
$description = isset($_POST['description']) ? wp_kses_post(stripslashes($_POST['description'])) : "";
$workaround = isset($_POST['workaround']) ? wp_kses_post(stripslashes($_POST['workaround'])) : "";
if($email && $description)
{
$subject = 'Feature request from Tripadvisor plugin';
$message = 'We received a feature request to the Tripadvisor plugin from <strong>'. $name .' ('. $email .', url: '. get_option('siteurl') .')</strong>:<br /><br /><strong>'. $description .'</strong><br /><br />Current workaround: <br /><br /><strong>'. $workaround .'</strong>';
ob_start();
include $trustindex_pm_tripadvisor->get_plugin_dir() . 'include' . DIRECTORY_SEPARATOR . 'troubleshooting.php';
$troubleshooting_data = ob_get_clean();
$message .= '<br /><br />Troubleshooting:<br />'. nl2br(str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $troubleshooting_data));
$attachments = [];
if(isset($_FILES['attachments']))
{
$wp_upload_dir = wp_upload_dir();
for($i = 0; $i < count($_FILES['attachments']['name']); $i++)
{
$target_file = $wp_upload_dir['basedir'] . DIRECTORY_SEPARATOR . date('YmdHis') . '-' . basename($_FILES['attachments']['name'][ $i ]);
if(@move_uploaded_file($_FILES['attachments']['tmp_name'][ $i ], $target_file))
{
$attachments []= $target_file;
}
}
}
wp_mail('support@trustindex.io', $subject, $message, [ 'From: '. $email, 'Content-Type: text/html; charset=UTF-8' ], $attachments);
foreach($attachments as $attachment)
{
@unlink($attachment);
}
}
exit;
}
?>
<div class="ti-box ti-feature-request-container">
<div class="ti-feature-request">
<div class="ti-box-header"><?php echo TrustindexPlugin_tripadvisor::___('Missing a feature?'); ?></div>
<p>
<?php echo TrustindexPlugin_tripadvisor::___('Anything you are missing in our product?'); ?><br />
<?php echo TrustindexPlugin_tripadvisor::___('Drop a message here to let us know!'); ?>
</p>
<form method="post" enctype="multipart/form-data">
<?php wp_nonce_field('send-feature-request_'.$trustindex_pm_tripadvisor->get_plugin_slug(), '_wpnonce_send_feature_request' ); ?>
<input type="hidden" name="command" value="send-feature-request" />
<div class="ti-input-row">
<label><?php echo TrustindexPlugin_tripadvisor::___('Please describe the feature you need'); ?>*</label>
<textarea class="form-control" name="description" rows="3" placeholder="<?php echo TrustindexPlugin_tripadvisor::___('The more detail you can share, the better.'); ?>"></textarea>
</div>
<div class="ti-input-row">
<label><?php echo TrustindexPlugin_tripadvisor::___('Attach images'); ?> (<?php echo TrustindexPlugin_tripadvisor::___('max %d pcs %s', [ 3, '3MB' ]); ?>)</label>
<div class="ti-input-file-upload">
<input type="file" name="attachments[]" multiple="true" accept="image/*">
<button type="button"><?php echo TrustindexPlugin_tripadvisor::___('Browse images'); ?></button>
</div>
</div>
<div class="ti-input-row">
<label><?php echo TrustindexPlugin_tripadvisor::___('Please describe your current workaround'); ?></label>
<textarea class="form-control" name="workaround" rows="3" placeholder="<?php echo TrustindexPlugin_tripadvisor::___('If you have one - otherwise leave it blank.'); ?>"></textarea>
</div>
<div class="ti-input-row">
<label><?php echo TrustindexPlugin_tripadvisor::___('Your name'); ?></label>
<input type="text" class="form-control" name="name" placeholder="<?php echo TrustindexPlugin_tripadvisor::___('The more detail you can share, the better.'); ?>" />
</div>
<div class="ti-input-row">
<label><?php echo TrustindexPlugin_tripadvisor::___('Your email address'); ?>*</label>
<input type="text" class="form-control" name="email" value="<?php echo esc_attr($current_user->user_email); ?>" />
</div>
<p><?php echo TrustindexPlugin_tripadvisor::___('Thanks for taking the time - we will get back to you as soon as possible to ask a few clarifying question or to give you an update.'); ?></p>
<div class="ti-box-footer">
<a href="#" class="btn-text btn-send-feature-request ti-tooltip toggle-tooltip ti-tooltip-left">
<?php echo TrustindexPlugin_tripadvisor::___("Send feature request") ;?>
<span class="ti-tooltip-message">
<span style="color: #00ff00; margin-right: 2px">✓</span>
<?php echo TrustindexPlugin_tripadvisor::___("Feature request sent"); ?>
</span>
</a>
</div>
</form>
</div>
</div>
