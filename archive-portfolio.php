<?php 
   get_header(); 

   echo '<main id="swup" class="page transition-fade">';
      $bg = get_field('portfolio_bg', 'options');
      echo '<section id="case-firstscreen" class="case-firstscreen _firstscreen"> <img src="'. $bg['url'] .'" alt="'. $bg['alt'] .'" class="case-firstscreen__bg" loading="lazy"> </section>';

      echo '<section id="portfolio" class="portfolio">';
         $heading = get_field('portfolio_heading', 'options');
         $terms = get_terms([
            'taxonomy' => 'theme',
            'hide_empty' => 1,
            'orderby' => 'id',
            'order' => 'DESC',
         ]);

         if ($heading || $terms) :
            echo '<div class="portfolio__heading">';
               echo '<div class="portfolio__container">';
                  echo $heading != '' ? '<div class="_content">'. $heading .'</div>' : '';

                  if ($terms) :
                     echo '<nav class="portfolio__categories portfolio-categories">';
                        $postType = get_post_type();

                        echo '<ul class="portfolio-categories__list">';
                           echo '<li class="portfolio-categories__item"><a href="'. get_post_type_archive_link($postType) .'" class="_active" >Все</a></li>';
                           foreach ($terms as $term) :
                              setup_postdata($term);
                              $termID = $term -> term_id;
                                 echo '<li class="portfolio-categories__item"><a href="'. get_term_link($termID) .'">'. $term->name .'</a></li>';
                           endforeach;
                        echo '</ul>';
                  echo '</nav>';
                  endif;
               echo '</div>';
            echo '</div>';
         endif;

         $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
         $args = array(
            'post_type'       => 'portfolio',
            'numberposts'     => -1,
            'posts_per_page'  => 12,
            'paged' => $paged,
            /* 'tax_query' => [
               [
                  'taxonomy' => 'theme',
                  'terms' => 'ofisy',
                  'field' => 'slug',
               ]
            ], */
         );
         $query = new WP_Query($args);
         
         $pin = get_field('pin', 'options');
         $pinImage = $pin['pin_image'];
         $pinText = $pin['pin_text'];

         if ($query -> have_posts()) :
            echo '<div class="portfolio__items">';
               $j = 0;
               $cta = get_field('portfolio_cta', 'options');
               $ctaBtn = get_field('portfolio_btn', 'options');

               while ($query -> have_posts()) :
                  $query -> the_post();

                  $itemBG = get_field('case-firstscreen_bg');
                  $itemDescr = get_the_excerpt();
                  if (!$itemDescr) :
                     $itemDescr = "Смотреть кейс";
                  endif;
                  $itemCaption = get_the_title();

                  echo '<a href="'. get_permalink() .'" class="portfolio__item item-portfolio">';
                     if ($itemBG) :
                        echo '<div class="item-portfolio__img"><img src="'. $itemBG['url'] .'" alt="" loading="lazy"></div>';
                     else:
                        echo '<div class="item-portfolio__img">';
                           echo '<img src="'. $pinImage['url'] .'" alt="" loading="lazy">';
                           echo '<span>'. $pinText .'</span>';
                        echo '</div>';
                     endif;
                     echo '<div class="item-portfolio__body">';
                        echo '<div class="item-portfolio__descr">'. $itemDescr .'</div>';
                        echo '<div class="item-portfolio__caption">'. $itemCaption .'</div>';
                     echo '</div>';
                  echo '</a>';

                  if ($j == 5 && $ctaBtn) :
                     echo '<div class="portfolio__cta cta">';
                        echo '<div class="portfolio__container">';
                           echo $cta != '' ? '<div class="cta__text _content">'. $cta .'</div>' : '';
                           echo '<div class="cta__button"><button class="btn btn_bg" data-popup="#request">'. $ctaBtn .'</button></div>';
                        echo '</div>';
                     echo '</div>';
                  endif;
                  $j++;
               endwhile;
            echo '</div>';

            if (get_next_posts_link() || get_previous_posts_link()) :
               echo '<div class="portfolio__pagination portfolio__container">';
                  echo '<div class="page-pagination">';
                     // Без этой строчки значение posts_per_page берется из админки
                     $GLOBALS['wp_query']->max_num_pages = $query->max_num_pages;

                     echo '<div class="page-pagination__arrows">';
                        echo '<a href="'. previous_posts(false) .'" class="page-numbers page-pagination__prev _icon-slider-right" '. (get_previous_posts_link() != '' ? '' : 'disabled') .'></a>';
                        echo '<a href="'. next_posts(0, false) .'" class="page-numbers page-pagination__next _icon-slider-right" '. (get_next_posts_link() != '' ? '' : 'disabled') .'></a>';
                     echo '</div>';


                     the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_next' => false,
                     ));
                  echo '</div>';
               echo '</div>';
            endif;

            if ($terms) :
               echo '<div class="portfolio__heading">';
                  echo '<div class="portfolio__container">';
                     if ($terms) :
                        echo '<nav class="portfolio__categories portfolio-categories">';
                           $postType = get_post_type();
      
                           echo '<ul class="portfolio-categories__list">';
                              echo '<li class="portfolio-categories__item"><a href="'. get_post_type_archive_link($postType) .'">Все</a></li>';
                              foreach ($terms as $term) :
                                 setup_postdata($term);
                                 $termID = $term -> term_id;
                                    echo '<li class="portfolio-categories__item"><a class="'. ($termID == $currendTermId ? '_active' : '') .'" href="'. get_term_link($termID) .'">'. $term->name .'</a></li>';
                              endforeach;
                           echo '</ul>';
                       echo '</nav>';
                     endif;
                  echo '</div>';
               echo '</div>';
            endif;
         endif;
         wp_reset_query();
      echo '</section>';
   echo '</main>';

   get_footer();