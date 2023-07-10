<?php
$urltrimmedtab = remove_query_arg( array('page', '_wpnonce', 'taction', 'tid', 'sortby', 'sortdir', 'opt','settings-updated') );

$urlreviewlist = esc_url( add_query_arg( 'page', 'wp_tripadvisor-reviews',$urltrimmedtab ) );
$urltemplateposts = esc_url( add_query_arg( 'page', 'wp_tripadvisor-templates_posts',$urltrimmedtab ) );
$urlgetpro = esc_url( add_query_arg( 'page', 'wp_tripadvisor-get_tripadvisor',$urltrimmedtab ) );
$urlforum = esc_url( add_query_arg( 'page', 'wp_tripadvisor-get_pro',$urltrimmedtab ) );
$urlwelcome = esc_url( add_query_arg( 'page', 'wp_tripadvisor-welcome',$urltrimmedtab ) );
?>	
	<div class="w3-bar w3-border w3-white">
	<a href="<?php echo $urlwelcome; ?>" class="w3-bar-item w3-button <?php if($_GET['page']=='wp_tripadvisor-welcome'){echo 'w3-greentrip';} ?>"><i class="fa fa-home"></i> <?php _e('Welcome', 'wp-tripadvisor-review-slider'); ?></a>
	<a href="<?php echo $urlgetpro; ?>" class="w3-bar-item w3-button <?php if($_GET['page']=='wp_tripadvisor-get_tripadvisor'){echo 'w3-greentrip';} ?>"><i class="fa fa-search"></i> <?php _e('Get TripAdvisor Reviews', 'wp-tripadvisor-review-slider'); ?></a>
	<a href="<?php echo $urlreviewlist; ?>" class="w3-bar-item w3-button <?php if($_GET['page']=='wp_tripadvisor-reviews'){echo 'w3-greentrip';} ?>"><i class="fa fa-list"></i> <?php _e('Review List', 'wp-tripadvisor-review-slider'); ?></a>
	<a href="<?php echo $urltemplateposts; ?>" class="w3-bar-item w3-button <?php if($_GET['page']=='wp_tripadvisor-templates_posts'){echo 'w3-greentrip';} ?>"><i class="fa fa-commenting-o"></i> <?php _e('Templates', 'wp-tripadvisor-review-slider'); ?></a>
	<a href="https://wpreviewslider.com/" target="_blank" class="goprohbtntrip w3-bar-item w3-button <?php if($_GET['page']=='wp_tripadvisor-get_pro'){echo 'w3-greentrip';} ?>"><i class="fa fa-external-link-square" aria-hidden="true"></i> <?php _e('Get Pro Version!', 'wp_tripadvisor-get_pro'); ?></a>

	</div>