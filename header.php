<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />

		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php wp_title( '|', true, 'right' ); ?></title>

		<!-- mobile meta (hooray!) -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<!-- icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<!-- or, set /favicon.ico for IE10 win -->

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
		<![endif]-->

		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->

		<!-- drop Google Analytics Here -->
		<!-- end analytics -->

	</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<div class="inner-header">
			<div class="site-branding">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			</div>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<!--
				<h3 class="menu-toggle"><?php _e( 'Menu', 'tabula_rasa' ); ?></h3>
				<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'tabula_rasa' ); ?>"><?php _e( 'Skip to content', 'tabula_rasa' ); ?></a>
					<?php //tr_main_nav(); ?>
				-->
				<div class="block_dropdown">
				<?php mod_taxonomy_dropdown( 'blocks' ); ?>
				<script type="text/javascript"><!--
					var dropdown = document.getElementById("cat");
					function onCatChange() {
						if ( dropdown.options[dropdown.selectedIndex].value > '' ) {
							location.href = "<?php echo get_option('home'); ?>/blocks/"+dropdown.options[dropdown.selectedIndex].value;
						}
					}
				dropdown.onchange = onCatChange;
				--></script>	
				</div>
				<div class="add_new">
					<a href="<?php echo admin_url(); ?>post-new.php?post_type=location">Add New Location</a>
				</div>				
			</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->

	<div id="main" class="site-main">