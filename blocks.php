<?php 
if (have_rows('all_blocks')) :
    $i = 1;
    while (have_rows('all_blocks')) :
        the_row();
        include 'templates.php';
        $i++;
    endwhile;
endif;

if (get_the_content()) :
    echo '<section id="single-content" class="single-content">';
        echo '<div class="single-content__container">';
            the_content();
        echo '</div>';
    echo '</section>';
endif;
