<?php
/*
Template Name: About
*/
?>

<?php
/**
 * @package WordPress
 * @subpackage portfolio
 */

get_header(); ?>

<div class="row">
        	<div class="fourcol secondary-nav">
        		<ul>
        			<li><a href="#artists-statement">Artist's Statement</a></li>
        			<li><a href="#bio">Biography</a></li>
        			<li><a href="#events">Events and Awards</a></li>
        		</ul>       
       		</div>
		</div>
	</header>
</div>
<div class="main-container">
     	<div class="container">
     		<div class="row">
     			<div class="twelvecol">
     			<h2 id="artists-statement">Artist's Statement</h2>
     			</div>
     		</div>
     		<div class="row">
     			<div class="sixcol-extramargin">
     				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
     				<?php the_content(); ?>
     			</div>
     			
				
     			<p class="return-to-top"><a href="#">Back to the top.</a></p>
     		</div>
     	</div>
     </div>
     <div id="bio-image-container">
     </div>
     <div class="main-container">
     	<div class="container">
     		<div class="row">
     			<div class="twelvecol">
     				<h2 id="bio">Biography</h2>
     				<p><a href="http://sandramathern.com/wp-content/uploads/2013/01/Resume_Mathern_2012.pdf">Download CV</a><br/>
     			<a href="mailto:mathern@denison.edu">Email Sandra</a>
     			</p>
     			</div>
     		</div>
     		<div class="row">
     			<div class="sixcol-extramargin">
     			<?php the_field('biography'); ?>
       			</div>
     			<p class="return-to-top"><a href="#">Back to the top.</a></p>
     		</div>
     	</div>
     </div>
     <div id="events-image-container">
     </div>
     <div class="main-container">
     	<div class="container">
     		<div class="row">
     			<div class="twelvecol">
     				<h2 id="events">Events and Awards</h2>
     				 <?php endwhile; endif; ?>
   					<p class="return-to-top"><a href="#">Back to the top.</a></p>
     			</div>
     		</div>
     	</div>
     </div>


<?php get_footer(); ?>