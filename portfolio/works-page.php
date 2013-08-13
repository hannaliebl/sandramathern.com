<?php
/*
Template Name: Works
*/
?>
<?php
/**
 * @package WordPress
 */
?>
		<?php get_header('works'); ?>
		<script>
			$('#works-container').delegate('#work','click',function () {
				var data = {action:'get_work',work_id:$(this).attr('data-id')};
				jQuery.post(MyAjax.ajaxurl, data, function(response) {
					$('article').html(response);
				});
				data['action'] = 'get_flickr';
				jQuery.post(MyAjax.ajaxurl, data, function(response) {
					$("#header-container").jQuerySlider({
		              	images:[ response ]
	              	});
	              	$("html, body").animate({
			            scrollTop: $("#work").offset().top
		            }, 1500);
				});
            });
		</script>
		<div id="works-container">
			<?php display_works($post->ID); ?>
		</div>

	</header>
</div>
		<article>
			<?php 
			if ($_POST['workid'] && get_post($_POST['workid'])) {
				echo display_work($_POST['workid']); 
				echo '<script>'.
						'$("#header-container").jQuerySlider({'.
			              	'images:['.
			              	display_flickr_photoset_urls($_POST['workid']) .
			              	 ']'.
		              	'});'.
						'$("html, body").animate({' .
			            	'scrollTop: $("#work").offset().top' .
		            	'}, 1500);'.
					'</script>';
			}
				?>

        </article>
        <!-- End main content -->
        <?php get_footer(); ?>