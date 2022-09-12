<?php 
get_header(); 

echo '<main id="swup" class="page transition-fade">';
   $bg = get_field('blog_bg', 'options');
   echo '<section id="case-firstscreen" class="case-firstscreen _firstscreen"> <img src="'. $bg['url'] .'" alt="'. $bg['alt'] .'" class="case-firstscreen__bg" loading="lazy"> </section>';

   echo '<section class="blog">';
      echo '<div class="blog__top">';
         echo '<div class="blog__container">';
            $title = get_field('blog_title', 'options');
            echo '<h1 class="blog__title">'. $title .'</h1>';

            echo '<div class="blog__heading">';
               $text = get_field('blog_text', 'options');
               echo $text != '' ? '<div class="blog__text _content">'. $text .'</div>' : '';

               echo do_shortcode('[contact-form-7 id="734" title="Следить за трендами дизайна"]');
            echo '</div>';
         echo '</div>';
      echo '</div>';

      $terms = get_terms([
         'taxonomy' => 'rubric',
         'hide_empty' => 1,
         'orderby' => 'id',
         'order' => 'ASC',
      ]);
      $currendTermId = get_queried_object()->term_id;
      $postType = get_post_type();

      if ($terms) :
         echo '<div class="blog__categories">';
            echo '<div class="blog__container">';
               echo '<nav class="portfolio-categories">';
                  echo '<ul class="portfolio-categories__list">';
                     foreach ($terms as $term) :
                        setup_postdata($term);
                        $termID = $term -> term_id;

                        echo '<li class="portfolio-categories__item"><a class="'. ($termID == $currendTermId ? '_active' : '') .'" href="'. get_term_link($termID) .'" data-taxonomy="'. $term->name .'">'. $term->name .'</a></li>';
                     endforeach;
                  echo '</ul>';
               echo '</nav>';
            echo '</div>';
         echo '</div>';
      endif;

      if (have_posts()) :
         $taxonomy = get_queried_object();
         $items = get_posts(array(
            'post_type'     => 'blog',
            'numberposts'   => -1,
            'tax_query'     => array(
               array(
                   'taxonomy' => 'rubric',
                   'field'    => 'slug',
                   'terms'    => $taxonomy->slug
               )
            ),
         ));
         echo '<div class="_hidden items-count">'. count($items) .'</div>';
         echo '<div class="blog__items">';
            while (have_posts()) :
               the_post();

               echo '<article class="blog__item blog-item">';
                  echo '<img src="'. get_the_post_thumbnail_url() .'" alt="" loading="lazy">';
      
                  echo '<div class="blog-item__body">';
                     echo '<div class="blog-item__heading">';
                        echo '<div class="blog-item__date">'. get_the_date() .'</div>';
                        echo '<a href="'. get_the_permalink() .'" class="blog-item__caption">';
                           echo '<span>'. get_the_title() .'</span>';
                           echo '<i class="_icon-arrow-left"></i>';
                        echo '</a>';
                     echo '</div>';
                     echo '<div class="blog-item__excerpt _content">'. get_the_excerpt() .'</div>';
                  echo '</div>';
               echo '</article>';
            endwhile;
         echo '</div>';

         $btn = get_field('blog_btn', 'options');
         echo '<div class="blog__more">';
            echo '<button type="button" class="btn btn_border">'. $btn .'</button>';
         echo '</div>';
      endif;
   echo '</section>';
echo '</main>';

get_footer();