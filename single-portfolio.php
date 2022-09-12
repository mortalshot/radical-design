<?php 
   get_header(); 

   echo '<main id="swup" class="page transition-fade">';
      $firstscreenBg = get_field('case-firstscreen_bg');
      $firstscreenText = get_field('case-firstscreen_text');



      echo '<section id="case-firstscreen" class="case-firstscreen _firstscreen">';
         if ($firstscreenBg) :
            echo '<img src="'. $firstscreenBg['url'] .'" alt="'. $firstscreenBg['alt'] .'" class="case-firstscreen__bg" loading="lazy">';
         else :   
            $pin = get_field('pin', 'options');
            $pinImage = $pin['pin_image'];
            $pinText = $pin['pin_text'];
            echo '<img class="case-firstscreen__bg" src="'. $pinImage['url'] .'" alt="" loading="lazy">';
         endif;

         echo '<div class="case-firstscreen__container">';
            echo '<div class="case-firstscreen__text _content">';
               echo $firstscreenText != '' ? $firstscreenText : '<h1>'. get_the_title() .'</h1>';
            echo '</div>';
         echo '</div>';
      echo '</section>';

      $caseDetails = get_field('case-details_items');
      if ($caseDetails) :
         echo '<section class="case-details">';
            echo '<div class="case-details__container">';
               foreach ($caseDetails as $item) :
                  $itemHeading = $item['item-details_heading'];
                  $caption = $itemHeading['item-details_caption'];
                  $indicators = $itemHeading['item-details_indicators'];

                  echo '<div class="case-details__item item-details '. ($caption || $indicators ? 'item-details_column' : '') .'">';
                     if ($caption || $indicators) :
                        echo '<div class="item-details__heading">';
                           echo $caption != '' ? '<h3 class="item-details__caption">'. $caption .'</h3>' : '';

                           if ($indicators) :
                              echo '<div class="item-details__indicators">';
                                 foreach ($indicators as $indicator) :
                                    $indicatorValue = $indicator['item-details_indicators-value'];
                                    $indicatorCaption = $indicator['item-details_indicators-caption'];

                                    echo '<div class="item-details__indicator">';
                                       echo $indicatorValue != '' ? '<div class="item-details__indicators-value">'. $indicatorValue .'</div>' : '';
                                       echo $indicatorCaption != '' ? '<div class="item-details__indicators-caption">'. $indicatorCaption .'</div>' : '';
                                    echo '</div>';
                                 endforeach;
                              echo '</div>';
                           endif;
                        echo '</div>';
                     endif;

                     $itemBody = $item['item-details_body'];

                     if ($itemBody) :
                        echo '<div class="item-details__body">';
                           foreach ($itemBody as $row) :
                              if ($row['acf_fc_layout'] == "item-details_gallery") :
                                 $gallery = $row['gallery'];

                                 if ($gallery) :
                                    echo '<div class="item-details__gallery grid-row" data-gallery>';
                                       foreach ($gallery as $image) :
                                          $imageGrid = $image['grid'];
                                          $gridMain = $imageGrid['grid'];
                                          $gridSm = $imageGrid['grid-sm'];
                                          $imageSrc = $image['gallery_img'];

                                          echo '<a href="'. $imageSrc['url'] .'" class="grid-'. $gridMain .' grid-sm-'. $gridSm .'"><img src="'. $imageSrc['url'] .'" alt="'. $imageSrc['alt'] .'" loading="lazy"></a>';
                                       endforeach;
                                    echo '</div>';
                                 endif;
                              elseif ($row['acf_fc_layout'] == "item-details_content") :
                                 $content = $row['content'];

                                 echo $content != '' ? '<div class="_content">'. $content .'</div>' : '';
                              endif;
                           endforeach;
                        echo '</div>';
                     endif;
                  echo '</div>';
               endforeach;
            echo '</div>';
         echo '</section>';
      endif;

      echo '<section class="case-navigation">';
         echo '<div class="case-navigation__items">';

            $prevPost = get_adjacent_post(true, '', true, 'theme');
            if ($prevPost) :
               $prevPostID = $prevPost->ID;
            else:
               $taxonomy = wp_get_post_terms(get_the_ID(), 'theme');
               $query = new WP_Query( [
                  'post_type' => 'portfolio',
                  'order'     => 'ASC',
                  'tax_query' => array(
                     array(
                        'taxonomy' => 'theme',
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
            
            $prevPostBG = get_field('case-firstscreen_bg', $prevPostID);
            echo '<a href="'. get_permalink($prevPostID) .'" class="case-navigation__item">';
               echo '<div class="case-navigation__bg"><img src="'. $prevPostBG['url'] .'" alt="'. $prevPostBG['alt'] .'"></div>';

               echo '<div class="case-navigation__wrapper">';
                  echo '<div class="case-navigation__label">Смотреть кейс</div>';
                  echo '<h4 class="case-navigation__title">'. get_the_title($prevPostID) .'</h4>';
                  echo '<div class="case-navigation__arrow _icon-slider-right"></div>';
               echo '</div>';
            echo '</a>';

            $nextPost = get_adjacent_post( true, '', false, 'theme' );
            if ($nextPost) :
               $nextPostID = $nextPost->ID;
            else:
               $taxonomy = wp_get_post_terms(get_the_ID(), 'theme');

               $query = new WP_Query( [
                  'post_type' => 'portfolio',
                  'order'     => 'ASC',
                  'tax_query' => array(
                     array(
                        'taxonomy' => 'theme',
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

            $nextPostBG = get_field('case-firstscreen_bg', $nextPostID);
            echo '<a href="'. get_permalink($nextPostID) .'" class="case-navigation__item">';
               echo '<div class="case-navigation__bg"><img src="'. $nextPostBG['url'] .'" alt="'. $nextPostBG['alt'] .'"></div>';

               echo '<div class="case-navigation__wrapper">';
                  echo '<div class="case-navigation__label">Смотреть кейс</div>';
                  echo '<h4 class="case-navigation__title">'. get_the_title($nextPostID) .'</h4>';
                  echo '<div class="case-navigation__arrow _icon-slider-right"></div>';
               echo '</div>';
            echo '</a>';
         echo '</div>';
      echo '</section>';

      $heading = get_field('callback_heading', 'options');
      $form = get_field('callback_form', 'options');

      echo '<section id="callback-' . $i . '" class="callback">';
         echo '<div class="callback__container">';
            echo $heading != '' ? '<div class="callback__heading _content">' . $heading . '</div>' : '';
            echo '<div class="callback__form">';
               echo do_shortcode($form);
            echo '</div>';
         echo '</div>';
      echo '</section>';
   echo '</main>';

   get_footer();