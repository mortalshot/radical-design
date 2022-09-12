<?php 
   get_header(); 

   echo '<main id="swup" class="page transition-fade">';
      echo '<section class="error _firstscreen">';
         echo '<div class="error__container">';
            echo '<div class="error__wrapper">';
               $img = get_field('error_img', 'options');
               $title = get_field('error_title', 'options');
               $text = get_field('error_text', 'options');
               $button = get_field('error_button', 'options');
               echo '<div class="error__image"><img src="'. $img['url'] .'" alt="'. $img['alt'] .'" loading="lazy"></div>';
               echo '<h1 class="error__title">'. $title .'</h1>';
               echo $text != '' ? '<div class="error__text _content">'. $text .'</div>' : '';
               echo '<div class="error__button"><a href="'. get_home_url() .'" class="btn btn_bg">'. $button .'</a></div>';
            echo '</div>';
         echo '</div>';
      echo '</section>';
   echo '</main>';

   get_footer();