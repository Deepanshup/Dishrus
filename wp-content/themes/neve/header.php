<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the page header div.
 *
 * @package Neve
 * @since   1.0.0
 */

$header_classes = apply_filters( 'nv_header_classes', 'header' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php echo wp_kses( apply_filters( 'neve_body_data_attrs', '' ), array( '[class]' => true ) ); ?>>
<?php wp_body_open(); ?>
<div class="wrapper">
	<!--Header builder BEGIN-->
<?php do_action('stm_hb', array('header' => 'construction')); ?>
<!--Header builder END-->
	<?php do_action( 'neve_before_primary' ); ?>

	<main id="content" class="neve-main" role="main">

<?php
do_action( 'neve_after_primary_start' );

