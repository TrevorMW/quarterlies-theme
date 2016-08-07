<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="IE ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<!--[if IE 8 ]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
<title><?php echo site_global_description(); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/media/favicon.ico">
<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<header class="wrapper header" role="menubar">
		<div class="container table">
			<div class="table-cell fourth header-logo">
				<a href="#">
					<h1>Custom Header Logo</h1>
					<!-- <img src="<?php echo get_template_directory_uri(); ?>" alt="" /> -->
				</a>
			</div>
			<div class="table-cell three-fourth align-right main-navigation">
				<nav role="navigation">
					<ul>
						<li><a href="#">Fake Link</a></li>
						<li><a href="#">Fake Link</a></li>
						<li><a href="#">Fake Link</a></li>
					</ul>
				</nav>

			</div>
		</div>
	</header>

	<div class="main-content">
		<main class="wrapper " role="main" data-loader-parent>
			<div class="container">



