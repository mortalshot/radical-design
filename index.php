<?php 
get_header(); 

echo '<main id="swup" class="page transition-fade">';
	if (get_the_post_thumbnail_url()) :
		echo '<section id="case-firstscreen" class="case-firstscreen _firstscreen"> <img src="'. get_the_post_thumbnail_url() .'" alt="" class="case-firstscreen__bg" loading="lazy"> </section>';
	endif;
	
	include 'blocks.php';
echo '</main>';

get_footer();