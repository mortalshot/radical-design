<?php 
   get_header(); 

   echo '<main id="swup" class="page transition-fade">';
      $bg = get_field('blog_bg', 'options');
      echo '<section id="case-firstscreen" class="case-firstscreen _firstscreen"> <img src="'. $bg['url'] .'" alt="'. $bg['alt'] .'" class="case-firstscreen__bg" loading="lazy"> </section>';
      
      echo '<section class="single-article">';
         echo '<div class="single-article__heading">';
         echo '<div class="single-article__container">';
               $url = htmlspecialchars($_SERVER['HTTP_REFERER']);
               echo '<div class="back"> <a href="'. $url .'" class="back__link _icon-arrow-left">назад</a> </div>';

               echo '<div class="single-article__wrapper">';
                  echo '<h1 class="single-article__title">'. get_the_title() .'</h1>';
                  echo '<div class="blog-item__date">'. get_the_date() .'</div>';
               echo '</div>';
            echo '</div>';
         echo '</div>';
         if (get_the_post_thumbnail_url()) :
            echo '<div class="single-article__preview"><img src="'. get_the_post_thumbnail_url() .'" alt="" loading="lazy"></div>';
         endif;

         if (get_the_content()) :
            echo '<div class="single-article__content">';
               echo '<div class="single-article__container">';
                  echo '<div class="_content">'. get_the_content() .'</div>';
               echo '</div>';
            echo '</div>';
         endif;
      echo '</section>';

      echo '<section class="case-navigation">';
         echo '<div class="case-navigation__heading">';
            echo '<div class="case-navigation__container">';
               echo '<div class="_content"> <h2 style="text-align: center;">Ещё статьи</h2> </div>';
            echo '</div>';
         echo '</div>';

         echo '<div class="case-navigation__items">';
            $prevPost = get_adjacent_post(true, '', true, 'rubric');
            if ($prevPost) :
               $prevPostID = $prevPost->ID;
            else:
               $taxonomy = wp_get_post_terms(get_the_ID(), 'rubric');
               $query = new WP_Query( [
                  'post_type' => 'blog',
                  'order'     => 'ASC',
                  'tax_query' => array(
                     array(
                        'taxonomy' => 'rubric',
                        'field'    => 'name',
                        'terms'    => $taxonomy[0]->name
                     )
                  )
               ] );

               while ($query -> have_posts()) :
                  $query -> the_post();
                  $prevPostID = get_the_ID();
               endwhile;

               wp_reset_postdata();
            endif;

            $prevPostBG = get_the_post_thumbnail_url($prevPostID);
            echo '<a href="'. get_permalink($prevPostID) .'" class="case-navigation__item">';
               echo '<div class="case-navigation__bg"><img src="'. $prevPostBG .'" alt=""></div>';

               echo '<div class="case-navigation__wrapper">';
                  echo '<h4 class="case-navigation__title">'. get_the_title($prevPostID) .'</h4>';
                  echo '<div class="case-navigation__arrow _icon-slider-right"></div>';
               echo '</div>';
            echo '</a>';

            $nextPost = get_adjacent_post( true, '', false, 'rubric' );
            if ($nextPost) :
               $nextPostID = $nextPost->ID;
            else:
               $taxonomy = wp_get_post_terms(get_the_ID(), 'rubric');

               $query = new WP_Query( [
                  'post_type' => 'blog',
                  'order'     => 'ASC',
                  'tax_query' => array(
                     array(
                        'taxonomy' => 'rubric',
                        'field'    => 'name',
                        'terms'    => $taxonomy[0]->name
                     )
                  )
               ] );

               $j = 0;
               while ($query -> have_posts()) :
                  $query -> the_post();
                  if ($j == 0) {
                     $nextPostID = get_the_ID();
                     break;
                  }
                  $j++;
               endwhile;

               wp_reset_postdata();
            endif;

            $nextPostBG = get_the_post_thumbnail_url($nextPostID);
            echo '<a href="'. get_permalink($nextPostID) .'" class="case-navigation__item">';
               echo '<div class="case-navigation__bg"><img src="'. $nextPostBG .'" alt=""></div>';

               echo '<div class="case-navigation__wrapper">';
                  echo '<h4 class="case-navigation__title">'. get_the_title($nextPostID) .'</h4>';
                  echo '<div class="case-navigation__arrow _icon-slider-right"></div>';
               echo '</div>';
            echo '</a>';
         echo '</div>';
      echo '</div>';
   echo '</main>';

   get_footer();