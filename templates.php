<?php
   if (get_row_layout() == 'template1') :
      $bg = get_sub_field('firstscreen_bg');
      $text = get_sub_field('firstscreen_text');
      $actions = get_sub_field('firstscreen_actions');

      echo '<section id="firstscreen-' . $i . '" class="firstscreen _firstscreen" data-fullscreen>';
         echo '<img src="'. $bg['url'] .'" alt="'. $bg['alt'] .'" class="firstscreen__bg" loading="lazy">';
         echo '<div class="firstscreen__container">';
            echo '<div class="firstscreen__wrapper">';
               echo $text != '' ? '<div class="firstscreen__text _content">'. $text .'</div>' : '';

               if ($actions) :
                  echo '<div class="firstscreen__actions">';
                     foreach ($actions as $button) :
                        $type = $button['button_type'];
                        $class = $button['button_class'];

                        if ($class == "Градиентная") :
                           $btnClass = "btn_bg";
                        elseif ($class == "С обводкой") :
                           $btnClass = "btn_border";
                        elseif ($class == "Белая") :
                           $btnClass = "btn_white";
                        endif;
                        

                        if ($type == "Ссылка на страницу") :
                           $link = $button['button_link'];

                           echo '<a href="'. $link['url'] .'" class="firstscreen__btn btn '. $btnClass .'" target="'. $link['target'] .'">'. $link['title'] .'</a>';
                        elseif ($type == "Якорная ссылка") :
                           $caption = $button['button_caption'];
                           $goto = $button['button_goto'];

                           echo '<a href="'. $goto .'" class="firstscreen__btn btn '. $btnClass .'" data-goto="'. $goto .'">'. $caption .'</a>';
                        elseif ($type == "Модальное окно") :
                           $caption = $button['button_caption'];
                           $popup = $button['button_popup'];
                           
                           if ($popup == "Оставьте заявку") :
                              $popupID = "#request";
                           endif;

                           echo '<button type="button" class="firstscreen__btn btn btn_bg" data-popup="'. $popupID .'">'. $caption .'</button>';
                        endif;
                     endforeach;
                  echo '</div>';
               endif;

               $social = get_field('social', 'options');
               $instagram = $social['instagram'];
               $vk = $social['vk'];
               $behance = $social['behance'];
               $telegram = $social['telegram'];

               if ($instagram || $vk || $behance || $telegram) :
                  echo '<div class="firstscreen__social social">';
                     echo $instagram != '' ? '<a href="'. $instagram .'" class="social__item _icon-instagram" target="_blank"></a>' : '';
                     echo $vk != '' ? '<a href="'. $vk .'" class="social__item _icon-vk" target="_blank"></a>' : '';
                     echo $behance != '' ? '<a href="'. $behance .'" class="social__item _icon-behance" target="_blank"></a>' : '';
                     echo $telegram != '' ? '<a href="'. $telegram .'" class="social__item _icon-telegram" target="_blank"></a>' : '';
                  echo '</div>';
               endif;
            echo '</div>';
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template2') :
      $bgColor = get_sub_field('about_bg-color');
      $title = get_sub_field('about_title');
      $text = get_sub_field('about_text');
      $persons = get_sub_field('about_persons');
      $features = get_sub_field('about_features');
      $featuresImage = $features['about_image'];
      $featuresIndicators = $features['about_indicators'];

      echo '<section id="about-' . $i . '" class="about" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="about__container">';
            echo $title != '' ? '<h2 class="about__title">' . $title . '</h2>' : '';

            if ($text || $persons) :
               echo '<div class="about__top-row">';
                  echo $text != '' ? '<div class="about__text _content">' . $text . '</div>' : '';

                  if ($persons) :
                     echo '<div class="about__persons">';
                        foreach ($persons as $person) :
                           $avatar = $person['person-about_avatar'];
                           $body = $person['person-about_body'];
                           $quote = $body['person-about_quote'];
                           $name = $body['person-about_name'];
                           $position = $body['person-about_position'];

                           echo '<div class="about__person person-about">';
                              echo '<div class="person-about__avatar"><img src="'. $avatar['url'] .'" alt="'. $avatar['alt'] .'" loading="lazy"></div>';
                              echo '<div class="person-about__body">';
                                 echo $quote != '' ? '<div class="person-about__quote _content">' . $quote . '</div>' : '';
                                 echo '<div class="person-about__heading">';
                                    echo '<div class="person-about__name">'. $name .'</div>';
                                    echo $position != '' ? '<div class="person-about__position">' . $position . '</div>' : '';
                                 echo '</div>';
                              echo '</div>';
                           echo '</div>';
                        endforeach;
                     echo '</div>';
                  endif;
               echo '</div>';
            endif;

            if ($featuresIndicators) :
               echo '<div class="about__bottom-row">';
                  if ($featuresImage) :
                     echo '<div class="about__image">';
                        echo '<img src="'. $featuresImage['url'] .'" alt="'. $featuresImage['alt'] .'" loading="lazy">';
                        echo '<div class="about__image-thumb"></div>';
                     echo '</div>';
                  endif;

                  echo '<div class="about__indicators">';
                     foreach ($featuresIndicators as $indicator) :
                        $value = $indicator['indicator-about_value'];
                        $caption = $indicator['indicator-about_caption'];

                        echo '<div class="about__indicator indicator-about">';
                           echo $value != '' ? '<div class="indicator-about__value">' . $value . '</div>' : '';
                           echo $caption != '' ? '<div class="indicator-about__caption">' . $caption . '</div>' : '';
                        echo '</div>';
                     endforeach;
                  echo '</div>';
               echo '</div>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template3') :
      $bgColor = get_sub_field('portfolio_bg-color');
      $heading = get_sub_field('portfolio_heading');
      $items = get_sub_field('portfolio_items');

      echo '<section id="portfolio-' . $i . '" class="portfolio" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         if ($heading) :
            echo '<div class="portfolio__heading _content">';
               echo '<div class="portfolio__container">'. $heading .'</div>';
            echo '</div>';
         endif;

         if ($items) :
            $count = 0;
            foreach ($items as $item) :
               $count++;
            endforeach;
            echo '<div class="portfolio__wrapper">';
               echo '<div class="portfolio__items-wrapper">';
                  echo '<div class="portfolio__items">';
                     $j = 0;
                     foreach ($items as $item) :
                        if ($j < 4) :
                           $itemID = $item['item-portfolio'];
                           $itemBG = get_field('case-firstscreen_bg', $itemID);
                           $itemBody = $item['item-portfolio_body'];
                           $itemDescr = $itemBody['item-portfolio_descr'];
                           if (!$itemDescr && get_the_excerpt($itemID)) :
                              $itemDescr = get_the_excerpt($itemID);
                           elseif (!$itemDescr && !get_the_excerpt($itemID)):
                              $itemDescr = "Смотреть кейс";
                           endif;
                           $itemCaption = $itemBody['item-portfolio_caption'];
                           if (!$itemCaption) :
                              $itemCaption = get_the_title($itemID);
                           endif;

                           echo '<a href="'. get_permalink($itemID) .'" class="portfolio__item item-portfolio">';
                              echo '<div class="item-portfolio__img"><img src="'. $itemBG['url'] .'" alt="'. $itemBG['alt'] .'" loading="lazy"></div>';

                              echo '<div class="item-portfolio__body">';
                                 echo '<div class="item-portfolio__descr">'. $itemDescr .'</div>';
                                 echo '<div class="item-portfolio__caption">'. $itemCaption .'</div>';
                              echo '</div>';
                           echo '</a>';
                        endif;
                        $j++;
                     endforeach;
                  echo '</div>';

                  if ($count > 4) :
                     echo '<div class="portfolio__items_hidden" hidden>';
                        echo '<div class="portfolio__items">';
                           $j = 0;
                           foreach ($items as $item) :
                              if ($j >= 4) :
                                 $itemID = $item['item-portfolio'];
                                 $itemBG = get_field('case-firstscreen_bg', $itemID);
                                 $itemBody = $item['item-portfolio_body'];
                                 $itemDescr = $itemBody['item-portfolio_descr'];
                                 if (!$itemDescr && get_the_excerpt($itemID)) :
                                    $itemDescr = get_the_excerpt($itemID);
                                 elseif (!$itemDescr && !get_the_excerpt($itemID)):
                                    $itemDescr = "Смотреть кейс";
                                 endif;
                                 $itemCaption = $itemBody['item-portfolio_caption'];
                                 if (!$itemCaption) :
                                    $itemCaption = get_the_title($itemID);
                                 endif;
         
                                 echo '<a href="'. get_permalink($itemID) .'" class="portfolio__item item-portfolio">';
                                    echo '<div class="item-portfolio__img"><img src="'. $itemBG['url'] .'" alt="'. $itemBG['alt'] .'" loading="lazy"></div>';
         
                                    echo '<div class="item-portfolio__body">';
                                       echo '<div class="item-portfolio__descr">'. $itemDescr .'</div>';
                                       echo '<div class="item-portfolio__caption">'. $itemCaption .'</div>';
                                    echo '</div>';
                                 echo '</a>';
                              endif;
                              $j++;
                           endforeach;
                        echo '</div>';
                     echo '</div>';
                  endif;
               echo '</div>';

               if ($count > 4) :
                  echo '<div class="portfolio__btn"><button class="btn btn_border">Показать ещё</button></div>';
               endif;
            echo '</div>';
         endif;

         $cta = get_sub_field('cta');
         $ctaText = $cta['cta_text'];
         $ctaButton = $cta['cta_button'];
         $btnType = $ctaButton['button_type'];
         $btnLink = $ctaButton['button_link'];
         $btnCaption = $ctaButton['button_caption'];

         if ($ctaText || $btnLink || $btnCaption) :
            echo '<div class="portfolio__cta cta">';
               echo $ctaText != '' ? '<div class="cta__text _content">'. $ctaText .'</div>' : '';

               $class = $ctaButton['button_class'];
               if ($class == "Градиентная") :
                  $btnClass = "btn_bg";
               elseif ($class == "С обводкой") :
                  $btnClass = "btn_border";
               elseif ($class == "Белая") :
                  $btnClass = "btn_white";
               endif;

               if ($btnType == "Ссылка на страницу") :
                  echo '<div class="cta__button"><a href="'. $btnLink['url'] .'" class="btn '. $btnClass .'" target="'. $btnLink['target'] .'">'. $btnLink['title'] .'</a></div>';
               elseif ($btnType == "Якорная ссылка") :
                  $btnGoto = $ctaButton['button_goto'];

                  echo '<div class="cta__button"><a href="'. $btnGoto .'" class="btn '. $btnClass .'" data-goto="'. $btnGoto .'">'. $btnCaption .'</a></div>';
               elseif ($btnType == "Модальное окно") :
                  $btnPopup = $ctaButton['button_popup'];
                  
                  if ($btnPopup == "Оставьте заявку") :
                     $btnPopupID = "#request";
                  endif;

                  echo '<div class="cta__button"><button type="button" class="btn btn_bg" data-popup="'. $btnPopupID .'">'. $btnCaption .'</button></div>';
               endif;
            echo '</div>';
         endif;
      echo '</section>';
   elseif (get_row_layout() == 'template4') :
      $bgColor = get_sub_field('features_bg-color');
      $title = get_sub_field('features_title');
      if ($title == '') $title = get_field('features_title', 'options');
      $items = get_sub_field('features_items');
      if ($items == '') $items = get_field('features_items', 'options');

      echo '<section id="features-' . $i . '" class="features" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="features__container">';
            echo $title != '' ? '<div class="features__title _content">' . $title . '</div>' : '';

            if ($items) :
               echo '<div class="features__items">';
                  foreach ($items as $item) :
                     $itemIcon = $item['item-feature_icon'];
                     $itemCaption = $item['item-feature_caption'];
                     $itemText = $item['item-feature_text'];

                     echo '<div class="features__item item-feature">';
                        echo $itemIcon != '' ? '<div class="item-feature__icon"><img src="'. $itemIcon['url'] .'" alt="'. $itemIcon['alt'] .'" loading="lazy"></div>' : '';
                        echo '<div class="item-feature__caption">'. $itemCaption .'</div>';
                        echo $itemText != '' ? '<div class="item-feature__text _content">' . $itemText . '</div>' : '';
                     echo '</div>';
                  endforeach;
               echo '</div>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template5') :
      $bg = get_sub_field('steps_bg');
      if ($bg == '') $bg = get_field('steps_bg', 'options');
      $title = get_sub_field('steps_title');
      if ($title == '') $title = get_field('steps_title', 'options');
      $spollers = get_sub_field('steps_spollers');
      if ($spollers == '') $spollers = get_field('steps_spollers', 'options');

      echo '<section id="steps-' . $i . '" class="steps">';
         echo '<div class="steps__bg"><img src="'. $bg['url'] .'" alt="'. $bg['alt'] .'" loading="lazy"></div>';
         echo '<div class="steps__container">';
            echo $title != '' ? '<div class="steps__title _content">' . $title . '</div>' : '';

            if ($spollers) :
               echo '<div data-spollers="575, max" class="steps__spollers spollers">';
                  $j = 1;
                  foreach ($spollers as $item) :
                     $class = $item['item-step_class'];
                     if ($class == "100%") :
                        $class = "item-step-md-6";
                     elseif ($class == "83%") :
                        $class = "item-step-md-5";
                     elseif ($class == "66%") :
                        $class = "item-step-md-4";
                     elseif ($class == "50%") :
                        $class = "item-step-md-3";
                     elseif ($class == "33%") :
                        $class = "item-step-md-2";
                     elseif ($class == "16%") :
                        $class = "item-step-md-1";
                     endif;

                     $caption = $item['item-step_caption'];
                     $text = $item['item-step_text'];

                     echo '<div class="steps__item item-step spollers__item '. $class .'">';
                        echo '<button type="button" data-spoller class="item-step__title spollers__title">';
                           echo '<div class="item-step__num">'. ($j < 10 ? '0' . $j : $j) .'</div>';
                           echo '<div class="item-step__caption">'. $caption .'</div>';
                        echo '</button>';

                        echo '<div class="item-step__text spollers__body _content">';
                           echo $text != '' ? $text : '';
                        echo '</div>';
                     echo '</div>';

                     $j++;
                  endforeach;
               echo '</div>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template6') :
      $title = get_sub_field('tariffs_heading');
      $table = get_sub_field('tariffs_table');
      $thead = $table['table_thead'];
      $theadServices = $thead['table_thead-services'];
      $theadCaptions = $thead['table_thead'];
      $rows = $table['table_tr'];

      echo '<section id="tariffs-' . $i . '" class="tariffs">';
         echo '<div class="tariffs__container">';
            echo $title != '' ? '<div class="tariffs__heading _content">' . $title . '</div>' : '';

            echo '<div class="tariffs__table table">';
               echo '<table>';
                  echo '<thead>';
                     echo '<tr>';
                        echo '<th>'. $theadServices .'</th>';
                        foreach ($theadCaptions as $th) :
                           echo '<th>'. $th['table_th'] .'</th>';
                        endforeach;
                     echo '</tr>';
                  echo '</thead>';

                  echo '<tbody>';
                     foreach ($rows as $row) :
                        $rowCaption = $row['table_tr-caption'];
                        $captionTitle = $rowCaption['caption'];
                        $captionText = $rowCaption['text'];

                        $rowItems = $row['table_td'];

                        echo '<tr>';
                           echo '<td class="_content">';
                              echo '<p>'. $captionTitle .'</p>';
                              echo $captionText;
                           echo '</td>';

                           foreach ($rowItems as $item) :
                              $itemTD = $item['table_td'];
                              $tdIcon = $itemTD['icon'];
                              $tdText = $itemTD['text'];
                              
                              echo '<td class="_content">';
                                 echo $tdIcon == "+" ? '<i class="_icon-check"></i>' : '<i class="_icon-negative"></i>';
                                 echo $tdText != '' ? '<p>'. $tdText .'</p>' : '';
                              echo '</td>';
                           endforeach;
                        echo '</tr>';
                     endforeach;
                  echo '</tbody>';
               echo '</table>';
            echo '</div>';

            echo '<div class="tariffs__slider swiper">';
               echo '<div class="tariffs__wrapper swiper-wrapper">';
                  for ($k = 0; $k < count($theadCaptions); $k++) :
                     echo '<div class="tariffs__slide tariff-slide swiper-slide">';
                        echo '<div class="tariff-slide__caption">'. $theadCaptions[$k]['table_th'] .'</div>';

                        foreach ($rows as $row) :
                           $rowCaption = $row['table_tr-caption'];
                           $captionTitle = $rowCaption['caption'];
                           $rowItems = $row['table_td'];
                           $itemTD = $rowItems[$k]['table_td'];
                           $tdIcon = $itemTD['icon'];
                           $tdText = $itemTD['text'];

                           echo '<div class="tariff-slide__row">';
                              echo '<div class="tariff-slide__key">'. $captionTitle .'</div>';
                              echo '<div class="tariff-slide__value _content">';
                                 echo $tdIcon == "+" ? '<i class="_icon-check"></i>' : '<i class="_icon-negative"></i>';
                                 echo $tdText != '' ? '<p>'. $tdText .'</p>' : '';
                              echo '</div>';
                           echo '</div>';
                        endforeach;
                     echo '</div>';
                  endfor;
               echo '</div>';
               echo '<div class="swiper-pagination"></div>';
            echo '</div>';

            $cta = get_sub_field('cta');
            $ctaText = $cta['cta_text'];
            $ctaButton = $cta['cta_button'];
            $btnType = $ctaButton['button_type'];
            $btnLink = $ctaButton['button_link'];
            $btnCaption = $ctaButton['button_caption'];

            if ($ctaText || $btnLink || $btnCaption) :
               echo '<div class="tariffs__cta cta">';
                  echo $ctaText != '' ? '<div class="cta__text _content">'. $ctaText .'</div>' : '';

                  $class = $ctaButton['button_class'];
                  if ($class == "Градиентная") :
                     $btnClass = "btn_bg";
                  elseif ($class == "С обводкой") :
                     $btnClass = "btn_border";
                  elseif ($class == "Белая") :
                     $btnClass = "btn_white";
                  endif;

                  if ($btnType == "Ссылка на страницу") :
                     echo '<div class="cta__button"><a href="'. $btnLink['url'] .'" class="btn '. $btnClass .'" target="'. $btnLink['target'] .'">'. $btnLink['title'] .'</a></div>';
                  elseif ($btnType == "Якорная ссылка") :
                     $btnGoto = $ctaButton['button_goto'];

                     echo '<div class="cta__button"><a href="'. $btnGoto .'" class="btn '. $btnClass .'" data-goto="'. $btnGoto .'">'. $btnCaption .'</a></div>';
                  elseif ($btnType == "Модальное окно") :
                     $btnPopup = $ctaButton['button_popup'];
                     
                     if ($btnPopup == "Оставьте заявку") :
                        $btnPopupID = "#request";
                     endif;

                     echo '<div class="cta__button"><button type="button" class="btn btn_bg" data-popup="'. $btnPopupID .'">'. $btnCaption .'</button></div>';
                  endif;
               echo '</div>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template7') :
      $bgColor = get_sub_field('reviews_bg-color');
      $title = get_sub_field('reviews_title');
      if ($title == '') $title = get_field('reviews_title', 'options');
      $slider = get_sub_field('reviews_slider');
      if ($slider == '') $slider = get_field('reviews_slider', 'options');

      echo '<section id="reviews-' . $i . '" class="reviews" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="reviews__slider swiper">';
            if ($title || $slider) :
               echo '<div class="reviews__heading">';
                  echo $title != '' ? '<div class="reviews__title _content">' . $title . '</div>' : '';

                  if ($slider) :
                     echo '<div class="swiper__arrows">';
                        echo '<button class="swiper__arrow swiper__arrow_left _icon-slider-right"></button>';
                        echo '<button class="swiper__arrow swiper__arrow_right _icon-slider-right"></button>';
                     echo '</div>';
                  endif;
               echo '</div>';
            endif;

            if ($slider) :
               echo '<div class="reviews__wrapper swiper-wrapper">';
                  foreach ($slider as $slide) :
                     $text = $slide['review-slide_text'];
                     $author = $slide['review-slide_author'];
                     $authorName = $author['review-slide_name'];
                     $authorPosition = $author['review-slide_position'];

                     echo '<div class="reviews__slide review-slide swiper-slide">';
                        echo '<div class="review-slide__text _content">'. $text .'</div>';

                        echo '<div class="review-slide__author">';
                           echo '<div class="review-slide__name">'. $authorName .'</div>';
                           echo $authorPosition != '' ? '<div class="review-slide__position">'. $authorPosition .'</div>' : '';
                        echo '</div>';
                     echo '</div>';
                  endforeach;
               echo '</div>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template8') :
      $title = get_sub_field('addresses_text');
      if ($title == '') $title = get_field('addresses_text', 'options');
      $map = get_sub_field('addresses_map');
      if ($map == '') $map = get_field('addresses_map', 'options');

      $contacts = get_sub_field('addresses_contacts');
      $contactsCaption = $contacts['footer_contacts-caption'];
      if ($contactsCaption == '') :
         $contacts = get_field('addresses_contacts', 'options');
         $contactsCaption = $contacts['footer_contacts-caption'];
      endif;

      $contacts = get_sub_field('addresses_contacts');
      $contactsList = $contacts['footer_contacts'];
      if ($contactsList == '') :
         $contacts = get_field('addresses_contacts', 'options');
         $contactsList = $contacts['footer_contacts'];
         if ($contactsList == '') :
            $contacts = get_field('footer_contacts', 'options');
            $contactsList = $contacts['footer_contacts'];
         endif;
      endif;

      echo '<section id="addresses-' . $i . '" class="addresses">';
         echo '<div class="addresses__container">';
            echo '<div class="addresses__row">';
               echo '<div class="addresses__left">';
                  echo $title != '' ? '<div class="addresses__text _content">' . $title . '</div>' : '';

                  if ($contactsCaption || $contactsList) :
                     echo '<div class="addresses__contacts contacts">';
                        echo $contactsCaption != '' ? '<div class="contacts__caption">'. $contactsCaption .'</div>' : '';

                        if ($contactsList) :
                           foreach ($contactsList as $item) :
                              $contactType = $item['contacts_type'];
                              $contactText = $item['contacts_text'];
      
                              if ($contactType == "Телефон") :
                                 $phone = $contactText;
                                 $phonePreg =  preg_replace("/[^0-9]/", '', $phone);
      
                                 echo '<a href="tel:+'. $phonePreg .'" class="contacts__item contacts__item_phone _icon-phone"><span>'. $phone .'</span></a>';
                              elseif ($contactType == "Почта") :
                                 echo '<a href="mailto:'. $contactText .'" class="contacts__item _icon-mail"><span>'. $contactText .'</span></a>';
                              elseif ($contactType == "Адрес") :
                                 $contactLink = $item['contacts_link'];
                                 if ($contactLink) :
                                    echo '<a href="'. $contactLink['url'] .'" class="contacts__item _icon-location" target="'. $contactLink['target'] .'"><span>'. $contactText .'</span></a>';
                                 else:
                                    echo '<div class="contacts__item _icon-location"><span>'. $contactText .'</span></div>';
                                 endif;
                              endif;
                           endforeach;
                        endif;
                     echo '</div>';
                  endif;
               echo '</div>';

               echo '<div class="addresses__map"><img src="'. $map['url'] .'" alt="'. $map['alt'] .'" loading="lazy"></div>';
            echo '</div>';
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template9') :
      $bg = get_sub_field('banner_bg');
      $text = get_sub_field('banner_text');
      $btn = get_sub_field('banner_btn');
      $btnType = $btn['button_type'];
      $btnLink = $btn['button_link'];
      $btnCaption = $btn['button_caption'];
      $back = get_sub_field('banner_back');

      echo '<section id="banner-' . $i . '" class="banner" data-fullscreen>';
         echo '<div class="banner__bg"><img src="'. $bg['url'] .'" alt="'. $bg['alt'] .'" loading="lazy"></div>';

         echo '<div class="banner__container">';
            echo $text != '' ? '<div class="banner__text _content">' . $text . '</div>' : '';

            if ($btnLink || $btnCaption) :
               $class = $btn['button_class'];
               if ($class == "Градиентная") :
                  $btnClass = "btn_bg";
               elseif ($class == "С обводкой") :
                  $btnClass = "btn_border";
               elseif ($class == "Белая") :
                  $btnClass = "btn_white";
               endif;

               if ($btnType == "Ссылка на страницу") :
                  echo '<div class="banner__btn"><a href="'. $btnLink['url'] .'" class="btn '. $btnClass .'" target="'. $btnLink['target'] .'">'. $btnLink['title'] .'</a></div>';
               elseif ($btnType == "Якорная ссылка") :
                  $btnGoto = $ctaButton['button_goto'];

                  echo '<div class="banner__btn"><a href="'. $btnGoto .'" class="btn '. $btnClass .'" data-goto="'. $btnGoto .'">'. $btnCaption .'</a></div>';
               elseif ($btnType == "Модальное окно") :
                  $btnPopup = $ctaButton['button_popup'];
                  
                  if ($btnPopup == "Оставьте заявку") :
                     $btnPopupID = "#request";
                  endif;

                  echo '<div class="banner__btn"><button type="button" class="btn btn_bg" data-popup="'. $btnPopupID .'">'. $btnCaption .'</button></div>';
               endif;
            endif;

            echo $back != '' ? '<div class="banner__back"><a href="'. $back['url'] .'" class="back-button _icon-arrow-left" target="'. $back['target'] .'"><span>'. $back['title'] .'</span></a></div>' : '';
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template10') :
      $heading = get_sub_field('callback_heading');
      if ($heading == '') $heading = get_field('callback_heading', 'options');
      $form = get_sub_field('callback_form');
      if ($form == '') $form = get_field('callback_form', 'options');

      echo '<section id="callback-' . $i . '" class="callback">';
         echo '<div class="callback__container">';
            echo $heading != '' ? '<div class="callback__heading _content">' . $heading . '</div>' : '';
            echo '<div class="callback__form">';
               echo do_shortcode($form);
            echo '</div>';
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template11') :
      $bgColor = get_sub_field('timeline_bg-color');
      $heading = get_sub_field('timeline_heading');
      if ($heading == '') $heading = get_field('timeline_heading', 'options');
      $list = get_sub_field('timeline_list');
      if ($list == '') $list = get_field('timeline_list', 'options');

      echo '<section id="timeline-' . $i . '" class="timeline" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="timeline__container">';
            echo $heading != '' ? '<div class="timeline__heading _content">' . $heading . '</div>' : '';

            if ($list) :
               echo '<ul class="timeline__list">';
                  foreach ($list as $item) :
                     $itemDate = $item['timeline_date'];
                     $itemText = $item['timeline_text'];
                     echo '<li class="timeline__item _content" data-date="'. $itemDate .'">'. $itemText .'</li>';
                  endforeach;
               echo '</ul>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template12') :
      $bgColor = get_sub_field('clients_bg-color');
      $heading = get_sub_field('clients_heading');
      if ($heading == '') $heading = get_field('clients_heading', 'options');
      $slider = get_sub_field('clients_slider');
      if ($slider == '') $slider = get_field('clients_slider', 'options');

      echo '<section id="clients-' . $i . '" class="clients" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="clients__container">';
            echo $heading != '' ? '<div class="clients__heading _content">' . $heading . '</div>' : '';

            if ($slider) :
               echo '<div class="clients__slider swiper">';
                  echo '<div class="clients__wrapper swiper-wrapper">';
                     foreach ($slider as $slide) :
                        $slideLink = $slide['clients_link'];
                        $slideLogo = $slide['clients_logo'];

                        if ($slideLink) :
                           echo '<a href="'. $slideLink .'" class="clients__slide swiper-slide" target="_blank"><img src="'. $slideLogo['url'] .'" alt="'. $slideLogo['alt'] .'" loading="lazy"></a>';
                        else:
                           echo '<div class="clients__slide swiper-slide"><img src="'. $slideLogo['url'] .'" alt="'. $slideLogo['alt'] .'" loading="lazy"></div>';
                        endif;
                     endforeach;
                  echo '</div>';
               echo '</div>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template13') :
      $bgColor = get_sub_field('cta2_bg-color');
      $template = get_sub_field('cta2_template');
      $cta = get_sub_field('cta2');
      $ctaText = $cta['cta2_text'];
      $ctaButton = $cta['cta2_button'];
      $btnType = $ctaButton['button_type'];
      $btnLink = $ctaButton['button_link'];
      $btnCaption = $ctaButton['button_caption'];
      $ctaLink = $cta['cta2_link'];

      echo '<section id="cta2-' . $i . '" class="cta2 '. ($template=="Шаблон 2" ? 'cta2_row' : '') .'" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="cta2__container">';
            echo $ctaText != '' ? '<div class="cta2__text _content">'. $ctaText .'</div>' : '';

            $class = $ctaButton['button_class'];
            if ($class == "Градиентная") :
               $btnClass = "btn_bg";
            elseif ($class == "С обводкой") :
               $btnClass = "btn_border";
            elseif ($class == "Белая") :
               $btnClass = "btn_white";
            endif;

            if ($btnType == "Ссылка на страницу") :
               echo '<div class="cta2__button"><a href="'. $btnLink['url'] .'" class="btn '. $btnClass .'" target="'. $btnLink['target'] .'">'. $btnLink['title'] .'</a></div>';
            elseif ($btnType == "Якорная ссылка") :
               $btnGoto = $ctaButton['button_goto'];

               echo '<div class="cta2__button"><a href="'. $btnGoto .'" class="btn '. $btnClass .'" data-goto="'. $btnGoto .'">'. $btnCaption .'</a></div>';
            elseif ($btnType == "Модальное окно") :
               $btnPopup = $ctaButton['button_popup'];
               
               if ($btnPopup == "Оставьте заявку") :
                  $btnPopupID = "#request";
               endif;

               echo '<div class="cta2__button"><button type="button" class="btn btn_bg" data-popup="'. $btnPopupID .'">'. $btnCaption .'</button></div>';
            endif;

            if ($template=="Шаблон 1" && $ctaLink) :
               echo '<div class="cta2__link"><a href="'. $ctaLink['url'] .'" class="back-button _icon-arrow-left" target="'. $ctaLink['target'] .'"><span>'. $ctaLink['title'] .'</span></a></div>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template14') :
      $bgColor = get_sub_field('cost_bg-color');
      $title = get_sub_field('cost_title');
      $text = get_sub_field('cost_text');
      $items = get_sub_field('cost_items');

      echo '<section id="cost-' . $i . '" class="cost" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="cost__container">';
            if ($title || $text) :
               echo '<div class="cost__heading">';
                  echo $title != '' ? '<h2 class="cost__title">' . $title . '</h2>' : '';
                  echo $text != '' ? '<div class="cost__text _content">' . $text . '</div>' : '';
               echo '</div>';
            endif;

            if ($items) :
               echo '<div class="cost__items">';
                  foreach ($items as $item) :
                     $itemIcon = $item['item-cost_icon'];
                     $itemText = $item['item-cost_text'];

                     echo '<div class="cost__item item-cost">';
                        echo $itemIcon != '' ? '<div class="item-cost__icon"><img src="'. $itemIcon['url'] .'" alt="'. $itemIcon['alt'] .'" loading="lazy"></div>' : '';
                        echo $itemText != '' ? '<div class="item-cost__text _content">' . $itemText . '</div>' : '';
                     echo '</div>';
                  endforeach;
               echo '</div>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template15') :
      $bgColor = get_sub_field('image-full_bg-color');
      $image = get_sub_field('image-full_image');
      $text = get_sub_field('image-full_body');

      echo '<section id="image-full-' . $i . '" class="image-full" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="image-full__image"> <img src="'. $image['url'] .'" alt="'. $image['alt'] .'" loading="lazy"> </div>';
         
         echo '<div class="image-full__content">';
            echo '<div class="image-full__container">';
               echo '<div class="image-full__body _content">'. $text .'</div>';
            echo '</div>';
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template16') :
      $bgColor = get_sub_field('features2_bg-color');
      $heading = get_sub_field('features2_heading');
      $items = get_sub_field('features2_items');

      echo '<section id="features2-' . $i . '" class="features2" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="features2__container">';
            echo $heading != '' ? '<div class="features2__heading _content">' . $heading . '</div>' : '';

            if ($items) :
               echo '<div class="features2__items">';
                  foreach ($items as $item) :
                     echo '<div class="features2__item features2-item">';
                        $itemIcon = $item['features2-item_icon'];
                        $itemCaption = $item['features2-item_caption'];
                        $itemText = $item['features2-item_text'];

                        echo $itemIcon != '' ? '<div class="features2-item__icon"><img src="'. $itemIcon['url'] .'" alt="'. $itemIcon['alt'] .'"></div>' : '';
                        echo $itemCaption != '' ? '<div class="features2-item__caption">' . $itemCaption . '</div>' : '';
                        echo $itemText != '' ? '<div class="features2-item__text">' . $itemText . '</div>' : '';
                     echo '</div>';
                  endforeach;
               echo '</div>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template17') :
      $bgColor = get_sub_field('reviews2_bg-color');
      $heading = get_sub_field('reviews2_heading');
      $slider = get_sub_field('reviews2_wrapper');

      echo '<section id="reviews2-' . $i . '" class="reviews2" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="reviews2__container">';
            echo '<div class="reviews2__slider swiper">';
               echo '<div class="reviews2__heading">';
                  echo '<h2 class="reviews2__title">'. $heading .'</h2>';
                  
                  echo '<div class="swiper__arrows">';
                     echo '<button class="swiper__arrow swiper__arrow_left _icon-slider-right"></button>';
                     echo '<button class="swiper__arrow swiper__arrow_right _icon-slider-right"></button>';
                  echo '</div>';
               echo '</div>';
               
               echo '<div class="reviews2__wrapper swiper-wrapper" data-gallery>';
                  foreach ($slider as $slide) :
                     $slideImg = $slide['review2-slide_img'];
                     $slideCaption = $slide['review2-slide_caption'];

                     echo '<a href="'. $slideImg['url'] .'" class="reviews2__slide review2-slide swiper-slide">';
                        echo '<div class="review2-slide__img"><img src="'. $slideImg['url'] .'" alt="'. ($slideCaption != '' ? $slideCaption : '') .'" loading="lazy"></div>';
                        echo $slideCaption != '' ? '<div class="review2-slide__caption">'. $slideCaption .'</div>' : '';
                     echo '</a>';
                  endforeach;
               echo '</div>';

               echo '<div class="swiper-pagination"></div>';
            echo '</div>';
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template18') :
      $heading = get_sub_field('job_heading');
      $items = get_sub_field('job_items');

      echo '<section id="job-' . $i . '" class="job" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="job__container">';
            echo $heading != '' ? '<div class="job__heading _content">' . $heading . '</div>' : '';

            if ($items) :
               echo '<div class="job__items">';
                  foreach ($items as $item) :
                     $itemPosition = $item['job-item_position'];
                     $itemPrice = $item['job-item_price'];
                     $itemDescr = $item['job-item_descr'];
                     $itemList = $item['job-item_list'];
                     echo '<div class="job__item job-item" data-showmore="items">';
                        echo '<div class="job-item__heading">';
                           echo '<div class="job-item__position">'. $itemPosition .'</div>';
                           echo $itemPrice != '' ? '<div class="job-item__price">'. $itemPrice .'</div>' : '';
                           echo $itemDescr != '' ? '<div class="job-item__descr _content">'. $itemDescr .'</div>' : '';
                        echo '</div>';

                        echo '<div data-showmore-content="1" class="job-item__body">';
                           if ($itemList) :
                              echo '<div class="job-item__list">';
                                 foreach ($itemList as $row) :
                                    echo '<div class="job-item__row">';
                                       $rowCaption = $row['job-item_caption'];
                                       $rowText = $row['job-item_text'];

                                       echo '<div class="job-item__caption">'. $rowCaption .'</div>';
                                       echo '<div class="job-item__text _content">'. $rowText .'</div>';
                                    echo '</div>';
                                 endforeach;
                                 echo '<div class="job-item__row">';
                                    $wait = get_sub_field('job-item_wait');
                                    $button = get_sub_field('job-item_button');

                                    echo '<div class="job-item__caption">'. $wait .'</div>';
                                    echo '<div class="job-item__button"><button type="button" class="btn btn_bg" data-popup="#job-posting">'. $button .'</button></div>';
                                 echo '</div>';
                              echo '</div>';
                           endif;
                        echo '</div>';

                        $more = get_sub_field('job-item_more');
                        $more2 = get_sub_field('job-item_more2');
                        echo '<button hidden data-showmore-button type="button" class="job-item__more">';
                           echo '<span>'. $more .'</span>';
                           echo '<span>'. $more2 .'</span>';
                        echo '</button>';
                     echo '</div>';
                  endforeach;
               echo '</div>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template19') :
      $video = get_sub_field('frontpage_video');
      $videoMain = $video['video-main'];
      $videoWebm = $video['video-webm'];
      $gallery = get_sub_field('frontpage_slider');
      $subtitle = get_sub_field('frontpage_subtitle');
      $title = get_sub_field('frontpage_title');
      $description = get_sub_field('frontpage_description');
      $link = get_sub_field('frontpage_link');
      $indicators = get_sub_field('frontpage_indicators');

      echo '<section id="frontpage-' . $i . '" class="frontpage _firstscreen" data-fullscreen>';
         if ($gallery || $videoMain) :
            echo '<div class="frontpage__slider swiper '. ($videoMain != '' ? 'frontpage__slider_video' : '') .'">';
               echo '<div class="frontpage__wrapper swiper-wrapper">';
                  if ($videoMain) :
                     echo '<div class="frontpage__slide swiper-slide">';
                        echo '<video autoplay loop muted playsinline preload="metadata">';
                           echo $videoWebm != '' ? '<source src="'. $videoWebm .'" type="video/webm">' : '';
                           echo '<source src="'. $videoMain .'" type="video/mp4">';
                        echo '</video>';
                     echo '</div>';
                  else:
                     foreach ($gallery as $image) :
                        $imageLarge = $image['sizes']['large'];

                        echo '<div class="frontpage__slide swiper-slide">';
                           echo '<picture>';
                              echo '<source srcset="'. $imageLarge .'" media="(max-width: 767px)">';
                              echo '<img src="'. $image['url'] .'" alt="'. $image['alt'] .'" loading="lazy">';
                           echo '</picture>';
                        echo '</div>';
                     endforeach;
                  endif;
               echo '</div>';
            echo '</div>';
         endif;

         echo '<div class="frontpage__graphic">';
            echo '<span class="frontpage__d"></span>';
            echo '<span class="frontpage__line frontpage__line_one"></span>';
            echo '<span class="frontpage__line frontpage__line_two"></span>';
            echo '<span class="frontpage__r"></span>';
         echo '</div>';

         echo '<div class="frontpage__container">';
            echo '<div class="frontpage__go">';
               echo '<img src="'. get_template_directory_uri() .'/dist/img/icons/cursor.svg" alt="" loading="lazy">';
               echo '<span>Нажмите для продолжения</span>';
            echo '</div>';

            echo '<a href="'. $link .'" class="frontpage__link"></a>';

            if ($title || $subtitle || $description) :
               echo '<div class="frontpage__heading">';
                  echo $subtitle != '' ? '<div class="frontpage__subtitle"> <span>'. $subtitle .'</span> </div>' : '';
                  echo $title != '' ? '<h1 class="frontpage__title"> <span>'. $title .'</span> </h1>' : '';
                  echo $description != '' ? '<div class="frontpage__description"> <span>'. $description .'</span> </div>' : '';
               echo '</div>';
            endif;

            if ($indicators) :
               echo '<div class="frontpage__indicators">';
                  foreach ($indicators as $indicator) :
                     $indicatorValue = $indicator['indicator-about_value'];
                     $indicatorCaption = $indicator['indicator-about_caption'];
                     echo '<div class="frontpage__indicator indicator-about">';
                        echo $indicatorValue != '' ? '<div class="indicator-about__value">'. $indicatorValue .'</div>' : '';
                        echo '<div class="indicator-about__caption">'. $indicatorCaption .'</div>';
                     echo '</div>';
                  endforeach;
               echo '</div>';
            endif;

            $social = get_field('social', 'options');
            $instagram = $social['instagram'];
            $vk = $social['vk'];
            $behance = $social['behance'];
            $telegram = $social['telegram'];

            if ($instagram || $vk || $behance || $telegram) :
               echo '<div class="frontpage__social social">';
                  echo $instagram != '' ? '<a href="'. $instagram .'" class="social__item _icon-instagram" target="_blank"></a>' : '';
                  echo $vk != '' ? '<a href="'. $vk .'" class="social__item _icon-vk" target="_blank"></a>' : '';
                  echo $behance != '' ? '<a href="'. $behance .'" class="social__item _icon-behance" target="_blank"></a>' : '';
                  echo $telegram != '' ? '<a href="'. $telegram .'" class="social__item _icon-telegram" target="_blank"></a>' : '';
               echo '</div>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template20') :
      $bgColor = get_sub_field('company_bg-color');
      $roadHeading = get_sub_field('road_heading');
      $roadNavigation = get_sub_field('road_navigation');
      $image = get_sub_field('company_image');
      $heading = get_sub_field('company_heading');
      $indicator = get_sub_field('indicator-about');
      $indicatorValue = $indicator['indicator-about_value'];
      $indicatorCaption = $indicator['indicator-about_caption'];
      $text = get_sub_field('company_text');


      echo '<section id="company-' . $i . '" class="company" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="company__container">';
            if ($roadHeading || $roadNavigation) :
               echo '<div class="road">';
                  echo $roadHeading != '' ? '<div class="road__heading _content">'. $roadHeading .'</div>' : '';

                  if ($roadNavigation) :
                     echo '<nav class="road__navigation">';
                        echo '<ul class="road__list">';
                           foreach ($roadNavigation as $item) :
                              $itemText = $item['road_item-text'];
                              $itemLink = $item['road_item-link'];

                              echo '<li class="road__item"> <a href="" data-goto="'. $itemLink .'" data-goto-top="40">'. $itemText .'</a> </li>';
                           endforeach;
                        echo '</ul>';
                     echo '</nav>';
                  endif;
               echo '</div>';
            endif;

            echo '<div class="company__row">';
               echo '<div class="company__image"><img src="'. $image['url'] .'" alt="'. $image['alt'] .'" loading="lazy"></div>';
               echo '<div class="company__heading _content">'. $heading .'</div>';
               echo '<div class="company__indicator indicator-about">';
                  echo '<div class="indicator-about__value">'. $indicatorValue .'</div>';
                  echo '<div class="indicator-about__caption">'. $indicatorCaption .'</div>';
               echo '</div>';
               echo $text != '' ? '<div class="company__text _content">'. $text .'</div>' : '';
            echo '</div>';
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template21') :
      $bgColor = get_sub_field('team_bg-color');
      $heading = get_sub_field('team_heading');
      $columns = get_sub_field('team_columns');
      $main = get_sub_field('team_main');
      $mainCaption = $main['team_caption'];
      $mainAbout = $main['team_founder-about'];
      $mainQuote = $main['team_founder-quote'];
      $mainAvatar = $main['team-person_avatar'];
      $mainName = $main['team-person_name'];
      $mainPosition = $main['team-person_position'];


      echo '<section id="team-' . $i . '" class="team" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="team__container">';
            echo $heading != '' ? '<div class="team__heading _content">' . $heading . '</div>' : '';

            if ($columns) :
               echo '<div class="team__columns">';
                  foreach ($columns as $column) :
                     $links = $column['team_column'];

                     echo '<div class="team__column">';
                        foreach ($links as $link) :
                           echo '<div class="team__item"><a href="'. $link['team_item']['url'] .'" target="'. $link['team_item']['target'] .'">'. $link['team_item']['title'] .'</a></div>';
                        endforeach;
                     echo '</div>';
                  endforeach;
               echo '</div>';
            endif;

            echo '<div class="team__main">';
               echo $mainCaption != '' ? '<h3 class="team__caption">' . $mainCaption . '</h3>' : '';
               
               echo '<div class="team__founder">';
                  echo $mainAbout != '' ? '<div class="team__founder-about _content">' . $mainAbout . '</div>' : '';
                  echo $mainQuote != '' ? '<div class="team__founder-quote _content">' . $mainQuote . '</div>' : '';

                  echo '<div class="team__person team-person">';
                     echo '<div class="team-person__avatar"><img src="'. $mainAvatar['url'] .'" alt="'. $mainAvatar['alt'] .'" loading="lazy"></div>';
                     echo '<div class="team-person__body">';
                        echo '<div class="team-person__name">'. $mainName .'</div>';
                        echo $mainPosition != '' ? '<div class="team-person__position">' . $mainPosition . '</div>' : '';
                     echo '</div>';
                  echo '</div>';
               echo '</div>';
            echo '</div>';
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template22') :
      $bgColor = get_sub_field('awards_bg-color');
      $heading = get_sub_field('awards_heading');
      if ($heading == '') $heading = get_field('awards_heading', 'options');
      $columns = get_sub_field('awards_columns');
      if ($columns == '') $columns = get_field('awards_columns', 'options');
      $button = get_sub_field('awards_button');
      if ($button == '') $button = get_field('awards_button', 'options');

      echo '<section id="awards-' . $i . '" class="awards" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="awards__container">';
            echo $heading != '' ? '<div class="awards__heading _content">' . $heading . '</div>' : '';

            if ($columns) :
               echo '<div class="awards__columns">';
                  foreach ($columns as $column) :
                     $links = $column['awards_column'];

                     echo '<div class="awards__column">';
                        foreach ($links as $link) :
                           echo '<div class="awards__item"><a href="'. $link['awards_item']['url'] .'" target="'. $link['awards_item']['target'] .'">'. $link['awards_item']['title'] .'</a></div>';
                        endforeach;
                     echo '</div>';
                  endforeach;
               echo '</div>';
            endif;

            echo $button != '' ? '<div class="awards__button"><button type="button" class="btn btn_border" data-popup="#request">'. $button .'</button></div>' : '';
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template23') :
      $bgColor = get_sub_field('steps2_bg-color');
      $heading = get_sub_field('steps2_heading');
      if ($heading == '') $heading = get_field('steps2_heading', 'options');
      $items = get_sub_field('steps2_items');
      if ($items == '') $items = get_field('steps2_items', 'options');
      $cta = get_sub_field('steps2_cta');
      $ctaText = $cta['cta_text'];
      $ctaButton = $cta['cta_button'];
      $btnType = $ctaButton['button_type'];
      $btnLink = $ctaButton['button_link'];
      $btnCaption = $ctaButton['button_caption'];

      echo '<section id="steps2-' . $i . '" class="steps2" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="steps2__container">';
            echo $heading != '' ? '<div class="steps2__heading _content">' . $heading . '</div>' : '';

            if ($items) :
               echo '<div class="steps2__items">';
                  foreach ($items as $item) :
                     $itemImg = $item['steps2_img'];
                     $itemCaption = $item['steps2_caption'];
                     $itemText = $item['steps2_text'];

                     echo '<div class="steps2__item">';
                        echo '<div class="steps2__img"><img src="'. $itemImg['url'] .'" alt="'. $itemImg['alt'] .'"></div>';
                        echo '<div class="steps2__body">';
                           echo '<div class="steps2__caption">'. $itemCaption .'</div>';
                           echo $itemText != '' ? '<div class="steps2__text _content">'. $itemText .'</div>' : '';
                        echo '</div>';
                     echo '</div>';
                  endforeach;
               echo '</div>';
            endif;

            if ($ctaText || $btnLink || $btnCaption) :
               echo '<div class="steps2__cta cta">';
                  echo $ctaText != '' ? '<div class="cta__text _content">'. $ctaText .'</div>' : '';
   
                  $class = $ctaButton['button_class'];
                  if ($class == "Градиентная") :
                     $btnClass = "btn_bg";
                  elseif ($class == "С обводкой") :
                     $btnClass = "btn_border";
                  elseif ($class == "Белая") :
                     $btnClass = "btn_white";
                  endif;
   
                  if ($btnType == "Ссылка на страницу") :
                     echo '<div class="cta__button"><a href="'. $btnLink['url'] .'" class="btn '. $btnClass .'" target="'. $btnLink['target'] .'">'. $btnLink['title'] .'</a></div>';
                  elseif ($btnType == "Якорная ссылка") :
                     $btnGoto = $ctaButton['button_goto'];
   
                     echo '<div class="cta__button"><a href="'. $btnGoto .'" class="btn '. $btnClass .'" data-goto="'. $btnGoto .'">'. $btnCaption .'</a></div>';
                  elseif ($btnType == "Модальное окно") :
                     $btnPopup = $ctaButton['button_popup'];
                     
                     if ($btnPopup == "Оставьте заявку") :
                        $btnPopupID = "#request";
                     endif;
   
                     echo '<div class="cta__button"><button type="button" class="btn btn_bg" data-popup="'. $btnPopupID .'">'. $btnCaption .'</button></div>';
                  endif;
               echo '</div>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template24') :
      $bgColor = get_sub_field('partners_bg-color');
      $heading = get_sub_field('partners_heading');
      $image = get_sub_field('partners_image');
      $text = get_sub_field('partners_text');
      $caption = get_sub_field('partners_caption');
      $text3 = get_sub_field('partners_text3');
      $button = get_sub_field('partners_button');

      echo '<section id="partners-' . $i . '" class="partners" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="partners__container">';
            echo $heading != '' ? '<div class="partners__heading _content">' . $heading . '</div>' : '';

            echo '<div class="partners__top">';
               echo '<div class="partners__image"><img src="'. $image['url'] .'" alt="'. $image['alt'] .'"></div>';
               echo $text != '' ? '<div class="partners__text _content">'. $text .'</div>' : '';
            echo '</div>';

            echo '<div class="partners__main">';
               echo $caption != '' ? '<div class="partners__caption">'. $caption .'</div>' : '';
               echo $text3 != '' ? '<div class="partners__text _content">'. $text3 .'</div>' : '';
            echo '</div>';

            echo $button != '' ? '<div class="partners__button"><a href="'. $button['url'] .'" class="btn btn_bg" target="'. $button['target'] .'">'. $button['title'] .'</a></div>' : '';
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template25') :
      $bgColor = get_sub_field('services_bg-color');
      $heading = get_sub_field('services_heading');
      $items = get_sub_field('services_items');

      echo '<section id="services-' . $i . '" class="services" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="services__container">';
            echo $heading != '' ? '<div class="services__heading _content">' . $heading . '</div>' : '';

            if ($items) :
               echo '<div class="services__items">';
                  foreach ($items as $item) :
                     $itemImage = $item['service-item_image'];
                     $itemCaption = $item['service-item_caption'];
                     $itemExcerpt = $item['service-item_excerpt'];
                     $itemButton = $item['service-item_button'];

                     echo '<div class="services__item service-item">';
                        echo $itemButton != '' ? '<a href="'. $itemButton['url'] .'" class="service-item__image"><img src="'. $itemImage['url'] .'" alt="'. $itemImage['alt'] .'" loading="lazy"></a>' : '<div class="service-item__image"><img src="'. $itemImage['url'] .'" alt="'. $itemImage['alt'] .'" loading="lazy"></div>';
                        echo '<div class="service-item__body">';
                           echo $itemButton != '' ? '<a href="'. $itemButton['url'] .'" class="service-item__caption">'. $itemCaption .'</a>' : '<div class="service-item__caption">'. $itemCaption .'</div>';
                           echo $itemExcerpt != '' ? '<div class="service-item__excerpt _content">'. $itemExcerpt .'</div>' : '';
                           echo $itemButton != '' ? '<div class="service-item__button"><a href="'. $itemButton['url'] .'" class="btn btn_bg">'. $itemButton['title'] .'</a></div>' : '';
                        echo '</div>';
                     echo '</div>';
                  endforeach;
               echo '</div>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template26') :
      $bgColor = get_sub_field('template26_bg-color');
      $heading = get_sub_field('template26_heading');
      $text = get_sub_field('template26_text');
      $image = get_sub_field('template26_img');
      $services = get_sub_field('template26-services');
      $servicesHeading = $services['template26-services_heading'];
      $servicesColumns = $services['template26-services_columns'];

      echo '<section id="template26-' . $i . '" class="template26" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="template26__container">';
            echo $heading != '' ? '<div class="template26__heading _content">' . $heading . '</div>' : '';

            if ($text || $image) :
               echo '<div class="template26__row">';
                  echo $text != '' ? '<div class="template26__text _content">'. $text .'</div>' : '';
                  echo $image != '' ? '<div class="template26__img"><img src="'. $image['url'] .'" alt="'. $image['alt'] .'" loading="lazy"></div>' : '';
               echo '</div>';
            endif;

            if ($servicesHeading || $servicesColumns) :
               echo '<div class="template26__services template26-services">';
                  echo $servicesHeading != '' ? '<div class="template26-services__heading _content">' . $servicesHeading . '</div>' : '';

                  if ($servicesColumns) :
                     echo '<div class="template26-services__columns">';
                        foreach ($servicesColumns as $column) :
                           $items = $column['template26-services_items'];
                           echo '<div class="template26-services__column">';
                              foreach ($items as $item) :
                                 echo '<div class="template26-services__item">'. $item['template26-services_item'] .'</div>';
                              endforeach;
                           echo '</div>';
                        endforeach;
                     echo '</div>';
                  endif;
               echo '</div>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template27') :
      $bgColor = get_sub_field('template27_bg-color');
      $heading = get_sub_field('template27_heading');
      $items = get_sub_field('template27_items');

      echo '<section id="steps2-' . $i . '" class="steps2 steps2_benefits" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="steps2__container">';
            echo $heading != '' ? '<div class="steps2__heading _content">' . $heading . '</div>' : '';

            if ($items) :
               echo '<div class="steps2__items">';
                  foreach ($items as $item) :
                     $itemImg = $item['steps2_img'];
                     $itemText = $item['steps2_text'];

                     echo '<div class="steps2__item">';
                        echo '<div class="steps2__img"><img src="'. $itemImg['url'] .'" alt="'. $itemImg['alt'] .'"></div>';
                        echo '<div class="steps2__body">';
                           echo '<div class="steps2__text _content">'. $itemText .'</div>';
                        echo '</div>';
                     echo '</div>';
                  endforeach;
               echo '</div>';
            endif;
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template28') :
      $bgColor = get_sub_field('template28_bg-color');
      $heading = get_sub_field('template28_heading');
      $text = get_sub_field('template28_text');

      echo '<section id="template28-' . $i . '" class="template28" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="template28__container">';
            echo '<div class="template28__row">';
               echo $heading != '' ? '<h3 class="template28__heading">' . $heading . '</h3>' : '';
               echo $text != '' ? '<div class="template28__text _content">' . $text . '</div>' : '';
            echo '</div>';
         echo '</div>';
      echo '</section>';
   elseif (get_row_layout() == 'template0') :
      $bgColor = get_sub_field('template0_bg-color');
      $heading = get_sub_field('template0_heading');

      echo '<section id="template0-' . $i . '" class="template0" '. ($bgColor ? 'style="background-color: #eaeef2"' : '') .'>';
         echo '<div class="template0__container">';
            echo $heading != '' ? '<div class="template0__heading _content">' . $heading . '</div>' : '';
         echo '</div>';
      echo '</section>';
   endif;
