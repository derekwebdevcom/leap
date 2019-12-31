<?php
/**
 * Sidebar setup for footer full.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$container = get_theme_mod( 'understrap_container_type' );

?>

<?php if ( is_active_sidebar( 'footerfull' ) ) : ?>

	<!-- ******************* The Footer Full-width Widget Area ******************* -->
	<div class="container-fluid pb-4 text-center">
   <div class="row text-center">
     <div class="col-12">
     <h2>Connect<h2>
     </div>
   <div class="col-12 social padding">
     <a href="https://facebook.com/leapbangkok/"><img src="<?php echo get_template_directory_uri(); ?>/img/fb.png" height="50px" width="50px"></a>
         <a href="https://twitter.com/BkkLeap"><img src="<?php echo get_template_directory_uri(); ?>/img/twitter.png" height="75px" width="75px"></a>
             <a href="https://instagram.com/leapbkk?utm_source=ig_profile_share&igshid=1l48yievmzboo"><img src="<?php echo get_template_directory_uri(); ?>/img/ig.jpg" height="50px" width="50px"></a>
   </div>
 </div>
 </div>


			<div class="container-fluid footer">
	<footer class="text-center pt-5">
	 <img src="<?php echo get_template_directory_uri(); ?>/img/leaplogo.png" height="65px" width="65px">&copy; Copyright 2019, LEAPBKK
	<hr class="text-center"></hr>
	</footer>
	</div>

<?php endif; ?>
