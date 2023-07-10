<label class="ti-left-label"><span><?php echo TrustindexPlugin_tripadvisor::___("%s Business URL", [ "Tripadvisor" ]); ?>:</span></label>
<div class="input">
<input class="form-control"
placeholder="<?php echo TrustindexPlugin_tripadvisor::___("e.g.:") . ' ' . esc_attr($example_url); ?>"
id="page-link"
type="text" required="required"
/>
<span class="info-text"><?php echo TrustindexPlugin_tripadvisor::___("Type your business/company's URL and select from the list"); ?></span>
<img class="loading" src="<?php echo admin_url('images/loading.gif'); ?>" />
<div class="results"
data-errortext="<?php echo TrustindexPlugin_tripadvisor::___("Please add your URL again: this is not a valid %s page.", [ "Tripadvisor" ]); ?>"
></div>
</div>
<button class="btn btn-text btn-check"><?php echo TrustindexPlugin_tripadvisor::___("Check") ;?></button>