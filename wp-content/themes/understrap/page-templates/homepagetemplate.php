<?php
/**
 * Template Name: Home Page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
<div id="slides" class="carousel slide" data-ride="carousel">
 <ul class="carousel-indicators">
    <li data-target="#slides" data-slide-to="0" class="active"></li>
    <li data-target="#slides" data-slide-to="1"></li>
    <li data-target="#slides" data-slide-to="2"></li>
  </ul>

<div class="carousel-inner">
	<div class="carousel-item active">
    <img src="<?php echo get_template_directory_uri(); ?>/img/homehero.jpg" class="img-fluid" alt="Responsive image">
<div class="carousel-caption">
	<h1 class="display-2">Welcome to LEAP</h1>
	<h3>A Parent Support Group</h3>
  <a href="https://www.leap.derekwebdev.com/events/" class="btn btn-outline-light btn-lg" role="button">VIEW EVENTS</a>
	<a href="https://www.leap.derekwebdev.com/contact/" class="btn btn-primary btn-lg" role="button">JOIN US</a>
</div>
</div>

<div class="carousel-item">
    <img src="<?php echo get_template_directory_uri(); ?>/img/contacthero.jpg" class="img-fluid" alt="Responsive image">
    <div class="carousel-caption">
	<h1 class="display-2">Together We Are Strong</h1>
	<h3>The Learning and Educational Advocacy Program</h3>
  <a href="https://www.leap.derekwebdev.com/events/" class="btn btn-outline-light btn-lg" role="button">VIEW EVENTS</a>
  <a href="https://www.leap.derekwebdev.com/contact/" class="btn btn-primary btn-lg" role="button">JOIN US</a>
</div>
</div>
<div class="carousel-item">
    <img src="<?php echo get_template_directory_uri(); ?>/img/heroabout.jpg" class="img-fluid" alt="Responsive image">
    <div class="carousel-caption">
	<h1 class="display-2">Get Support</h1>
	<h3>The Learning and Educational Advocacy Program</h3>
  <a href="https://www.leap.derekwebdev.com/events/" class="btn btn-outline-light btn-lg" role="button">VIEW EVENTS</a>
  <a href="https://www.leap.derekwebdev.com/contact/" class="btn btn-primary btn-lg" role="button">JOIN US</a>
</div>
 </div>

</div>
</div>

<!--Jumbotron-->
<?php if( get_field('boxed_content') ): ?>
<div class="container-fluid">
	 <div class="row jumbotron bg-dark text-white">
			 <div class="col-12">
					 <p class="text-center main-text" style="border:3px; border-style:solid; border-color:#FFF; padding: 1em;">
	 <?php the_field('boxed_content'); ?>

					 </p>
				<div class="container-fluid text-center mt-4">
					<a href="https://www.leap.derekwebdev.com/contact/" class="btn btn-outline-light btn-lg align-center" role="button">LEARN MORE</a>

		 </div>
		 </div>
		 </div>
</div>
<?php endif; ?>
<!--Welcome Station-->
<div class="container-fluid pb-4">
<div class="row welcome text-center">
<div class="col-12">
	<h1 class="display-4">What We Do</h1>
    </div>
    <hr class="container-fluid"></hr>
    <div class="col-12">
    	<p class="lead" id ="mainboxtext" style="border:3px; border-style:solid; border-color:#96DAF6; padding: 1em;"><strong><?php if( get_field('field_name') ): ?>
	<p>My field value: <?php the_field('field_name'); ?></p>
<?php endif; ?>LEAP aims to help you and your child by providing resources, fellow parent and professional contacts, as well as a forum for exchange, to ensure you are supported and feel connected.
</strong></p>
    </div>
</div>
</div>
<!--Three Column Section-->
<div class="container-fluid pb-4">
<div class="row text-center pb-4">
	<div class="col-xs-12 col-sm-6 col-md-4">
		<img src="<?php echo get_template_directory_uri(); ?>/img/famfam.png" height="82px" width="82px">
		<h3>Community</h3>
		<p> LEAP fosters mentorship by connecting parents with similar stories giving you an opportunity to share and learn from a fellow parent who has first hand experience with a diagnosis and / or learning challenge.</p>
 </div>
<div class="col-xs-12 col-sm-6 col-md-4">
		<img src="<?php echo get_template_directory_uri(); ?>/img/resources.png" height="85px" width="75px">
		<h3>Resources</h3>
		<p> LEAP can introduce you to partners in the community (such as Steps with Theera, SENIA and Rainbow Room) who can help you on your journey.
</p>
</div>
<div class="col-sm-12 col-md-4">
		<img src="<?php echo get_template_directory_uri(); ?>/img/involved.jpg" height="85px" width="75px">
		<h3>Get Involved</h3>
		<p>LEAP hosts a few gatherings and coffee mornings during the year to bring the community together around a topic, expert or shared experience. Join our discussion. </p>
</div>
</div>
<hr class="my-4">
</div>
<!--Two Column Section-->
<div class="container-fluid pb-4">
	<div class="row padding">
		<div class="col-md-12 col-lg-6">
			<h2>Our Vision</h2>
      <strong>
			-We believe that all children should be in a safe and enriching educational environment.</strong>
				<br>
				<br>
			<strong>-We believe that in order for this to occur, parents and teachers must collaborate and support each other.</strong>
				<br>
				<br>
				<strong>-We believe that the strength of our community, working in unison, will create a more inclusive society.</strong>

		 </p>
      <br>

			<br>
      <br>
			<a href="https://www.leap.derekwebdev.com/contact/" class="btn btn-primary">Learn More</a>
		</div>
		<div class="col-lg-6 pb-4">
			<img src="<?php echo get_template_directory_uri(); ?>/img/upcomingbanner.jpg" class="img-fluid">
		</div>
	</div>
</div>




<div class="section-1 box">
  <div id="container-fluid col-12">
<!--  <p class="text-center" id="child-quote-text">“Children are the hands by which we take hold of heaven.” </p></div>
  <div id="container-fluid col-12">
  	<p class="text-center pb-4" id="henry">-Henry Beecher</p>--></div>
</div>





<div class="container-fluid pb-4">
<div class="row welcome text-center">
	<div class="col-12">
		<h1 class="display-4">Community
		</h1>
	</div>
	<hr class="container-fluid"></hr>
</div>
</div>

<div class="container-fluid padding1">
	<div class="row padding">


		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="<?php echo get_template_directory_uri(); ?>/img/bkkbang.jpeg" height="300px">
					<div class="card-body">
						<h4 class="card-title">Bangkok</h4>
						<p class="card-text">Get involved with local community outreach programs.</p>
						<a href="https://www.leap.derekwebdev.com/events/" class="btn btn-outline-secondary">Upcoming Events</a>
					</div>
				</div>
			</div>


		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="<?php echo get_template_directory_uri(); ?>/img/meeting.jpeg" height="300px">
					<div class="card-body">
						<h4 class="card-title">Meetings</h4>
						<p class="card-text">Come to our amazing community meetings and enjoy fresh brownies and other goodies!</p>
						<a href="https://www.leap.derekwebdev.com/events/" class="btn btn-outline-secondary">Join Us</a>
					</div>
				</div>
			</div>


		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="<?php echo get_template_directory_uri(); ?>/img/vision.jpg" height="300px">
					<div class="card-body">
						<h4 class="card-title">FAQ's</h4>
						<p class="card-text">View our most recent FAQ's so you can stay up to date in the LEAP Community.</p>
						<a href="https://www.leap.derekwebdev.com/faqs/" class="btn btn-outline-secondary">View FAQ's</a>
					</div>
				</div>
			</div>


      <hr class="my-4">

<?php get_footer(); ?>
