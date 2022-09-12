// Подключение функционала 
import { isMobile, _slideToggle, _slideDown, _slideUp, menuClose, bodyLock, bodyUnlock } from "./functions.js";
// Подключение списка активных модулей
import { flsModules } from "./modules.js";

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger.js';
gsap.registerPlugin(ScrollTrigger);

/* spollers */
const spollersArray = document.querySelectorAll('[data-spollers]');
if (spollersArray.length > 0) {
    // Получение обычных слойлеров
    const spollersRegular = Array.from(spollersArray).filter(function (item, index, self) {
        return !item.dataset.spollers.split(",")[0];
    });
    // Инициализация обычных слойлеров
    if (spollersRegular.length) {
        initSpollers(spollersRegular);
    }
    // Получение слойлеров с медиа запросами
    let mdQueriesArray = dataMediaQueries(spollersArray, "spollers");
    if (mdQueriesArray && mdQueriesArray.length) {
        mdQueriesArray.forEach(mdQueriesItem => {
            // Событие
            mdQueriesItem.matchMedia.addEventListener("change", function () {
                initSpollers(mdQueriesItem.itemsArray, mdQueriesItem.matchMedia);
            });
            initSpollers(mdQueriesItem.itemsArray, mdQueriesItem.matchMedia);
        });
    }
    // Инициализация
    function initSpollers(spollersArray, matchMedia = false) {
        spollersArray.forEach(spollersBlock => {
            spollersBlock = matchMedia ? spollersBlock.item : spollersBlock;
            if (matchMedia.matches || !matchMedia) {
                spollersBlock.classList.add('_spoller-init');
                initSpollerBody(spollersBlock);
                spollersBlock.addEventListener("click", setSpollerAction);
            } else {
                spollersBlock.classList.remove('_spoller-init');
                initSpollerBody(spollersBlock, false);
                spollersBlock.removeEventListener("click", setSpollerAction);
            }
        });
    }
    // Работа с контентом
    function initSpollerBody(spollersBlock, hideSpollerBody = true) {
        let spollerTitles = spollersBlock.querySelectorAll('[data-spoller]');
        if (spollerTitles.length) {
            spollerTitles = Array.from(spollerTitles).filter(item => item.closest('[data-spollers]') === spollersBlock);
            spollerTitles.forEach(spollerTitle => {
                if (hideSpollerBody) {
                    spollerTitle.removeAttribute('tabindex');
                    if (!spollerTitle.classList.contains('_spoller-active')) {
                        spollerTitle.nextElementSibling.hidden = true;
                    }
                } else {
                    spollerTitle.setAttribute('tabindex', '-1');
                    spollerTitle.nextElementSibling.hidden = false;
                }
            });
        }
    }
    function setSpollerAction(e) {
        const el = e.target;
        if (el.closest('[data-spoller]')) {
            const spollerTitle = el.closest('[data-spoller]');
            const spollersBlock = spollerTitle.closest('[data-spollers]');
            const oneSpoller = spollersBlock.hasAttribute('data-one-spoller');
            const spollerSpeed = spollersBlock.dataset.spollersSpeed ? parseInt(spollersBlock.dataset.spollersSpeed) : 500;
            if (!spollersBlock.querySelectorAll('._slide').length) {
                if (oneSpoller && !spollerTitle.classList.contains('_spoller-active')) {
                    hideSpollersBody(spollersBlock);
                }
                spollerTitle.classList.toggle('_spoller-active');
                _slideToggle(spollerTitle.nextElementSibling, spollerSpeed);
            }
            e.preventDefault();
        }
    }
    function hideSpollersBody(spollersBlock) {
        const spollerActiveTitle = spollersBlock.querySelector('[data-spoller]._spoller-active');
        const spollerSpeed = spollersBlock.dataset.spollersSpeed ? parseInt(spollersBlock.dataset.spollersSpeed) : 500;
        if (spollerActiveTitle && !spollersBlock.querySelectorAll('._slide').length) {
            spollerActiveTitle.classList.remove('_spoller-active');
            _slideUp(spollerActiveTitle.nextElementSibling, spollerSpeed);
        }
    }
    // Закрытие при клике вне спойлера
    const spollersClose = document.querySelectorAll('[data-spoller-close]');
    if (spollersClose.length) {
        document.addEventListener("click", function (e) {
            const el = e.target;
            if (!el.closest('[data-spollers]')) {
                spollersClose.forEach(spollerClose => {
                    const spollersBlock = spollerClose.closest('[data-spollers]');
                    const spollerSpeed = spollersBlock.dataset.spollersSpeed ? parseInt(spollersBlock.dataset.spollersSpeed) : 500;
                    spollerClose.classList.remove('_spoller-active');
                    _slideUp(spollerClose.nextElementSibling, spollerSpeed);
                });
            }
        });
    }
}

/* showmore */
function showMore() {
    const showMoreBlocks = document.querySelectorAll('[data-showmore]');
    let showMoreBlocksRegular;
    let mdQueriesArray;
    if (showMoreBlocks.length) {
        // Получение обычных объектов
        showMoreBlocksRegular = Array.from(showMoreBlocks).filter(function (item, index, self) {
            return !item.dataset.showmoreMedia;
        });
        // Инициализация обычных объектов
        showMoreBlocksRegular.length ? initItems(showMoreBlocksRegular) : null;

        document.addEventListener("click", showMoreActions);
        window.addEventListener("resize", showMoreActions);

        // Получение объектов с медиа запросами
        mdQueriesArray = dataMediaQueries(showMoreBlocks, "showmoreMedia");
        if (mdQueriesArray && mdQueriesArray.length) {
            mdQueriesArray.forEach(mdQueriesItem => {
                // Событие
                mdQueriesItem.matchMedia.addEventListener("change", function () {
                    initItems(mdQueriesItem.itemsArray, mdQueriesItem.matchMedia);
                });
            });
            initItemsMedia(mdQueriesArray);
        }
    }
    function initItemsMedia(mdQueriesArray) {
        mdQueriesArray.forEach(mdQueriesItem => {
            initItems(mdQueriesItem.itemsArray, mdQueriesItem.matchMedia);
        });
    }
    function initItems(showMoreBlocks, matchMedia) {
        showMoreBlocks.forEach(showMoreBlock => {
            initItem(showMoreBlock, matchMedia);
        });
    }
    function initItem(showMoreBlock, matchMedia = false) {
        showMoreBlock = matchMedia ? showMoreBlock.item : showMoreBlock;
        let showMoreContent = showMoreBlock.querySelectorAll('[data-showmore-content]');
        let showMoreButton = showMoreBlock.querySelectorAll('[data-showmore-button]');
        showMoreContent = Array.from(showMoreContent).filter(item => item.closest('[data-showmore]') === showMoreBlock)[0];
        showMoreButton = Array.from(showMoreButton).filter(item => item.closest('[data-showmore]') === showMoreBlock)[0];
        const hiddenHeight = getHeight(showMoreBlock, showMoreContent);
        if (matchMedia.matches || !matchMedia) {
            if (hiddenHeight < getOriginalHeight(showMoreContent)) {
                _slideUp(showMoreContent, 0, hiddenHeight);
                showMoreButton.hidden = false;
            } else {
                _slideDown(showMoreContent, 0, hiddenHeight);
                showMoreButton.hidden = true;
            }
        } else {
            _slideDown(showMoreContent, 0, hiddenHeight);
            showMoreButton.hidden = true;
        }
    }
    function getHeight(showMoreBlock, showMoreContent) {
        let hiddenHeight = 0;
        const showMoreType = showMoreBlock.dataset.showmore ? showMoreBlock.dataset.showmore : 'size';
        if (showMoreType === 'items') {
            const showMoreTypeValue = showMoreContent.dataset.showmoreContent ? showMoreContent.dataset.showmoreContent : 3;
            const showMoreItems = showMoreContent.children;
            for (let index = 1; index < showMoreItems.length; index++) {
                const showMoreItem = showMoreItems[index - 1];
                hiddenHeight += showMoreItem.offsetHeight;
                if (index == showMoreTypeValue) break
            }
        } else {
            const showMoreTypeValue = showMoreContent.dataset.showmoreContent ? showMoreContent.dataset.showmoreContent : 150;
            hiddenHeight = showMoreTypeValue;
        }
        return hiddenHeight;
    }
    function getOriginalHeight(showMoreContent) {
        let parentHidden;
        let hiddenHeight = showMoreContent.offsetHeight;
        showMoreContent.style.removeProperty('height');
        if (showMoreContent.closest(`[hidden]`)) {
            parentHidden = showMoreContent.closest(`[hidden]`);
            parentHidden.hidden = false;
        }
        let originalHeight = showMoreContent.offsetHeight;
        parentHidden ? parentHidden.hidden = true : null;
        showMoreContent.style.height = `${hiddenHeight}px`;
        return originalHeight;
    }
    function showMoreActions(e) {
        const targetEvent = e.target;
        const targetType = e.type;
        if (targetType === 'click') {
            if (targetEvent.closest('[data-showmore-button]')) {
                const showMoreButton = targetEvent.closest('[data-showmore-button]');
                const showMoreBlock = showMoreButton.closest('[data-showmore]');
                const showMoreContent = showMoreBlock.querySelector('[data-showmore-content]');
                const showMoreSpeed = showMoreBlock.dataset.showmoreButton ? showMoreBlock.dataset.showmoreButton : '500';
                const hiddenHeight = getHeight(showMoreBlock, showMoreContent);
                if (!showMoreContent.classList.contains('_slide')) {
                    showMoreBlock.classList.contains('_showmore-active') ? _slideUp(showMoreContent, showMoreSpeed, hiddenHeight) : _slideDown(showMoreContent, showMoreSpeed, hiddenHeight);
                    showMoreBlock.classList.toggle('_showmore-active');
                }
            }
        } else if (targetType === 'resize') {
            showMoreBlocksRegular && showMoreBlocksRegular.length ? initItems(showMoreBlocksRegular) : null;
            mdQueriesArray && mdQueriesArray.length ? initItemsMedia(mdQueriesArray) : null;
        }
    }
}

window.addEventListener("load", showMore());

// Уникализация массива
function uniqArray(array) {
    return array.filter(function (item, index, self) {
        return self.indexOf(item) === index;
    });
}

// Обработа медиа запросов из атрибутов 
function dataMediaQueries(array, dataSetValue) {
    // Получение объектов с медиа запросами
    const media = Array.from(array).filter(function (item, index, self) {
        if (item.dataset[dataSetValue]) {
            return item.dataset[dataSetValue].split(",")[0];
        }
    });
    // Инициализация объектов с медиа запросами
    if (media.length) {
        const breakpointsArray = [];
        media.forEach(item => {
            const params = item.dataset[dataSetValue];
            const breakpoint = {};
            const paramsArray = params.split(",");
            breakpoint.value = paramsArray[0];
            breakpoint.type = paramsArray[1] ? paramsArray[1].trim() : "max";
            breakpoint.item = item;
            breakpointsArray.push(breakpoint);
        });
        // Получаем уникальные брейкпоинты
        let mdQueries = breakpointsArray.map(function (item) {
            return '(' + item.type + "-width: " + item.value + "px)," + item.value + ',' + item.type;
        });
        mdQueries = uniqArray(mdQueries);
        const mdQueriesArray = [];

        if (mdQueries.length) {
            // Работаем с каждым брейкпоинтом
            mdQueries.forEach(breakpoint => {
                const paramsArray = breakpoint.split(",");
                const mediaBreakpoint = paramsArray[1];
                const mediaType = paramsArray[2];
                const matchMedia = window.matchMedia(paramsArray[0]);
                // Объекты с нужными условиями
                const itemsArray = breakpointsArray.filter(function (item) {
                    if (item.value === mediaBreakpoint && item.type === mediaType) {
                        return true;
                    }
                });
                mdQueriesArray.push({
                    itemsArray,
                    matchMedia
                })
            });
            return mdQueriesArray;
        }
    }
}

// Slider
import Swiper, { Autoplay, EffectFade, Mousewheel, Pagination, Navigation, Grid } from 'swiper';

import "../../scss/base/swiper.scss";

function initSliders() {
    if (document.querySelector('.frontpage__slider')) {
        // Создаем слайдер
        let frontpageSlider = new Swiper('.frontpage__slider', {
            modules: [Autoplay, EffectFade, Mousewheel],
            observer: true,
            observeParents: true,
            slidesPerView: 1,
            spaceBetween: 10,
            autoHeight: false,
            speed: 1000,
            watchOverflow: true,

            mousewheel: {
                sensitivity: 1,
                eventsTarget: ".frontpage"
            },

            // Эффекты
            effect: 'fade',

            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },

            // События
            on: {
                slideChange: function () {
                    ScrollTrigger.refresh();
                },
            }
        });

        /* Анимации на главной */
        const frontpage = document.querySelector('.frontpage');
        const logo = document.querySelector('.logo');
        const headerContainer = document.querySelector('.header__container');
        const headerStyle = getComputedStyle(headerContainer);
        const headerRight = document.querySelector('.header__right');

        /* Останавливаем авто переключение слайдера */
        frontpageSlider.autoplay.stop();

        /* Создаем таймлайн для анимаций */
        let frontpageTL = gsap.timeline()

        /* Высчитываем координаты центра */
        let height = window.innerHeight / 2;
        let width = parseInt(headerStyle.width) / 2;

        let logoWidth = logo.clientWidth / 2;
        let logoHeight = logo.clientHeight / 2;

        // 24 - padding-top
        height = height - logoHeight - 24;
        width = width - logoWidth;

        /* Размещаем логотип по центру страницы */
        frontpageTL.to(logo, { y: height, x: width, duration: 0 });

        /* Анимируем появление логотипа */
        const logoEllipse = logo.querySelector('.logo__ellipse');
        frontpageTL.from(logoEllipse, { opacity: 0, x: "-64px", duration: 0.3 }, "+=0.3");
        const logoEllipseLine = logo.querySelector('.logo__ellipse-line');
        frontpageTL.from(logoEllipseLine, { opacity: 0 });
        const logoFigure = logo.querySelector('.logo__figure path');
        frontpageTL.from(logoFigure, { opacity: 0, yPercent: -120 });
        const logoText = logo.querySelector('.logo__text');
        frontpageTL.from(logoText, { opacity: 0, skewY: 10, y: 10 });

        /* Возвращаем логотип на место */
        frontpageTL.to(logo, { y: 0, x: 0, scale: 0.7, duration: 1.2 });
        frontpageTL.from(headerRight, { opacity: 0 });

        /* Анимируем элементы страницы */
        const frontpageTitle = frontpage.querySelector('.frontpage__title span');
        if (frontpageTitle) {
            frontpageTL.from(frontpageTitle, { opacity: 0, yPercent: 100 }, "-=0.3");
        }
        const frontpageDescription = frontpage.querySelector('.frontpage__description span');
        if (frontpageDescription) {
            frontpageTL.from(frontpageDescription, { opacity: 0, yPercent: 100 }, "-=0.3");
        }
        const frontpageSubtitle = frontpage.querySelector('.frontpage__subtitle span');
        if (frontpageSubtitle) {
            frontpageTL.from(frontpageSubtitle, { opacity: 0, yPercent: 100 }, "-=0.3");
        }
        const frontpageSocial = frontpage.querySelector('.frontpage__social');
        if (frontpageSocial) {
            frontpageTL.from(frontpageSocial, { opacity: 0, xPercent: 100, duration: 0.8 }, "-=0.3");
        }
        const frontpageIndicators = document.querySelectorAll('.frontpage__indicator');
        if (frontpageIndicators.length) {
            frontpageIndicators.forEach(element => {
                frontpageTL.from(element, { opacity: 0, scale: 0, duration: 0.3, }, "-=0.1")
            });
        }

        /* Включаем авто переключение слайдера */
        frontpageTL.add(function () {
            frontpageSlider.autoplay.start();
            document.querySelector('.frontpage__slider').classList.add('_start');
            document.querySelector('.frontpage__go').classList.add('_active');
        });

        const frontpageGraphic = document.querySelector('.frontpage__graphic');
        if (frontpageGraphic) {

            frontpageTL.add(function () {
                frontpageGraphic.classList.add('_active');
            })

            const rGraphic = frontpageGraphic.querySelector('.frontpage__r');
            if (rGraphic) {
                frontpageTL.from(rGraphic, { opacity: 0, scale: 1.5, duration: 1 }, "-=0.5");
            }
            const lineOne = frontpageGraphic.querySelector('.frontpage__line_one');
            if (lineOne) {
                frontpageTL.fromTo(lineOne, { opacity: 0, top: 0 }, { opacity: 1, top: '50%', duration: 5 }, "-=2");
                frontpageTL.add(function () {
                    lineOne.classList.add('_active');
                })
            }
            const lineTwo = frontpageGraphic.querySelector('.frontpage__line_two');
            if (lineTwo) {
                frontpageTL.fromTo(lineTwo, { opacity: 0, top: "100%" }, { opacity: 1, top: '60%', duration: 5 }, "-=3");
                frontpageTL.add(function () {
                    lineTwo.classList.add('_active');
                })
            }
            const dGraphic = frontpageGraphic.querySelector('.frontpage__d');
            if (dGraphic) {
                frontpageTL.fromTo(dGraphic, { opacity: 0, bottom: "0%" }, { opacity: 1, bottom: '34%', duration: 6 }, "-=3");
                frontpageTL.add(function () {
                    dGraphic.classList.add('_active');
                })
            }
        }
    }
    if (document.querySelector('.tariffs__slider')) {
        // Создаем слайдер
        new Swiper('.tariffs__slider', {

            modules: [Pagination],
            observer: true,
            observeParents: true,
            slidesPerView: 1,
            spaceBetween: 10,
            autoHeight: true,
            speed: 800,
            watchOverflow: true,

            //touchRatio: 0,
            //simulateTouch: false,
            //loop: true,
            //preloadImages: false,
            //lazy: true,

            /*
            // Эффекты
            effect: 'fade',
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            */

            // Пагинация
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },


            // Скроллбар
            /*
            scrollbar: {
                el: '.swiper-scrollbar',
                draggable: true,
            },
            */

            // Кнопки "влево/вправо"
            /* navigation: {
                prevEl: '.swiper-button-prev',
                nextEl: '.swiper-button-next',
            }, */

            // Брейкпоинты
            /*
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    autoHeight: true,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1268: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
            */
            // События
            on: {
                slideChange: function () {
                    ScrollTrigger.refresh();
                },
            }
        });
    }
    if (document.querySelector('.reviews__slider')) {
        // Создаем слайдер
        new Swiper('.reviews__slider', {

            modules: [Pagination, Navigation],
            observer: true,
            observeParents: true,
            slidesPerView: 1,
            spaceBetween: 40,
            autoHeight: true,
            speed: 800,
            watchOverflow: true,

            //touchRatio: 0,
            //simulateTouch: false,
            loop: true,
            //preloadImages: false,
            //lazy: true,

            /*
            // Эффекты
            effect: 'fade',
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            */

            // Пагинация
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },


            // Скроллбар
            /*
            scrollbar: {
                el: '.swiper-scrollbar',
                draggable: true,
            },
            */

            // Кнопки "влево/вправо"
            navigation: {
                prevEl: '.reviews__slider .swiper__arrow_left',
                nextEl: '.reviews__slider .swiper__arrow_right',
            },

            // Брейкпоинты
            breakpoints: {
                743.98: {
                    slidesPerView: 1.2,
                    spaceBetween: 40,
                },
                991.98: {
                    slidesPerView: 1.4,
                    spaceBetween: 60,
                },
                1209.98: {
                    slidesPerView: 1.4,
                    spaceBetween: 120,
                },
            },

            // События
            on: {
                slideChange: function () {
                    ScrollTrigger.refresh();
                },
            }
        });
    }
    if (document.querySelector('.reviews2__slider')) {
        // Создаем слайдер
        new Swiper('.reviews2__slider', {

            modules: [Pagination, Navigation],
            observer: true,
            observeParents: true,
            slidesPerView: 1,
            spaceBetween: 40,
            // autoHeight: true,
            speed: 800,
            watchOverflow: true,

            //touchRatio: 0,
            //simulateTouch: false,
            loop: true,
            //preloadImages: false,
            //lazy: true,

            /*
            // Эффекты
            effect: 'fade',
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            */

            // Пагинация
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },


            // Скроллбар
            /*
            scrollbar: {
                el: '.swiper-scrollbar',
                draggable: true,
            },
            */

            // Кнопки "влево/вправо"
            navigation: {
                prevEl: '.reviews2__slider .swiper__arrow_left',
                nextEl: '.reviews2__slider .swiper__arrow_right',
            },

            // Брейкпоинты
            breakpoints: {
                479.98: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                743.98: {
                    slidesPerView: 3,
                    spaceBetween: 25,
                },
                991.98: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1209.98: {
                    slidesPerView: 4,
                    spaceBetween: 40,
                },
            },

            // События
            on: {
                slideChange: function () {
                    ScrollTrigger.refresh();
                },
            }
        });
    }
    if (document.querySelector('.clients__slider')) { // Указываем скласс нужного слайдера

        let clientSlider;

        let clientsMd2 = window.matchMedia('(max-width: 743.98px)');
        function clientsHandleMd2Change(e) {
            if (e.matches) {
                clientSlider = new Swiper('.clients__slider', {
                    modules: [Grid, Autoplay],
                    observer: true,
                    observeParents: true,
                    slidesPerView: 2,
                    // spaceBetween: 20,
                    autoHeight: false,
                    speed: 800,
                    watchOverflow: true,
                    grid: {
                        rows: 2,
                    },

                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                    },

                    // Брейкпоинты

                    breakpoints: {
                        474.98: {
                            slidesPerView: 3,
                        },
                    },

                    // События
                    on: {
                        slideChange: function () {
                            ScrollTrigger.refresh();
                        },
                    }
                });
            }
        }
        clientsMd2.addEventListener('change', clientsHandleMd2Change);
        clientsHandleMd2Change(clientsMd2);
    }
}

window.addEventListener("load", function (e) {
    initSliders();
});

/* Gallery */
import lightGallery from 'lightgallery';
import '@scss/libs/gallery/lightgallery.scss';

const galleries = document.querySelectorAll('[data-gallery]');
if (galleries.length) {
    let galleyItems = [];
    galleries.forEach(gallery => {
        galleyItems.push({
            gallery,
            galleryClass: lightGallery(gallery, {
                // plugins: [lgZoom, lgThumbnail],
                licenseKey: '7EC452A9-0CFD441C-BD984C7C-17C8456E',
                speed: 500,
            })
        })

        gallery.addEventListener('lgBeforeOpen', () => {
            bodyLock();
        });
        gallery.addEventListener('lgBeforeClose', () => {
            bodyUnlock();
        });
    });
}

// подстраиваем размер первого экрана под шапку
let header = document.querySelector('header.header');
let headerOffsetHeight = header.offsetHeight;

let firstscreen = document.querySelector('._firstscreen');
let main = document.querySelector('main.page');

if (firstscreen) {
    window.addEventListener('load', firstscreenResize)
    window.addEventListener('resize', firstscreenResize);
    header.classList.add('header_white');
}

function firstscreenResize() {
    headerOffsetHeight = header.offsetHeight
    main.style.marginTop = -headerOffsetHeight + 'px';
}

// Обработка инпутов со счетчиком
const counter = document.querySelectorAll('.counter');
if (counter.length > 0) {
    counter.forEach(element => {
        const counterCurrent = element.querySelector('.counter__current');
        const input = element.querySelector('.form__input');

        input.addEventListener('input', function () {
            const value = input.value.trim();
            const valueLength = value.length;
            counterCurrent.innerHTML = valueLength;
        })
    });
}

/* Добавляем текст из #callback-question в форму */
const callbackTxta = document.querySelector('#callback-question');
if (callbackTxta) {
    const callbackTxtaParent = callbackTxta.closest('.form__item');
    callbackTxta.addEventListener('change', function () {
        callbackTxtaParent.querySelector('input[name="your-message"]').value = this.value;
    })
}

/* Добавляем текст из #request-question в форму */
const requestTxta = document.querySelector('#request-question');
if (requestTxta) {
    const requestTxtaParent = requestTxta.closest('.form__item');
    requestTxta.addEventListener('change', function () {
        requestTxtaParent.querySelector('input[name="your-message"]').value = this.value;
    })
}

// Анимации
function sectionAnimation() {
    /* Секция About */
    const personAbout = document.querySelectorAll('.person-about');
    if (personAbout.length) {
        personAbout.forEach(element => {
            let elementTL = gsap.timeline({
                scrollTrigger: {
                    trigger: element,
                    start: `${-headerOffsetHeight} bottom`,
                    end: "top top",
                    toggleActions: "restart resume resume resume"
                },
            })

            elementTL.from(element.querySelector('.person-about__body'), { x: "-70%", opacity: 0, duration: 1 });
        });
    }
    const aboutRow = document.querySelector('.about__bottom-row');
    const aboutImage = document.querySelector('.about__image-thumb');
    const aboutIndicators = document.querySelectorAll('.indicator-about');

    if (aboutRow) {
        let aboutRowTL = gsap.timeline({
            scrollTrigger: {
                trigger: aboutRow,
                start: `${-headerOffsetHeight} bottom`,
                end: "top top",
                toggleActions: "restart resume resume resume"
            },
        })

        aboutRowTL.to(aboutImage, { width: 0, duration: 0.7 })

        if (aboutIndicators.length) {
            aboutIndicators.forEach(element => {
                aboutRowTL.from(element, { opacity: 0, scale: 0, duration: 0.5, }, "-=0.1")
            });
        }
    }

    /* Секция company */
    const company = document.querySelector('.company');
    if (company) {
        let companyTL = gsap.timeline({
            scrollTrigger: {
                trigger: company,
                start: "top 90%",
                end: "bottom top",
                toggleActions: "restart resume resume resume"
            }
        })

        const companyRoadHeading = company.querySelector('.road__heading');
        if (companyRoadHeading) {
            companyTL.from(companyRoadHeading, { opacity: 0, yPercent: 10, duration: 0.3 })
        }

        const companyRoadItems = company.querySelectorAll('.road__item');
        if (companyRoadItems.length > 0) {
            companyRoadItems.forEach(element => {
                companyTL.from(element, { opacity: 0, yPercent: 10, duration: 0.3 }, "-=0.2")
            });
        }

        const companyImage = company.querySelector('.company__image');
        if (companyImage) {
            companyTL.from(companyImage, { opacity: 0, xPercent: -15, duration: 0.5 })
        }

        const companyHeading = company.querySelector('.company__heading');
        if (companyHeading) {
            companyTL.from(companyHeading, { opacity: 0, xPercent: 15, duration: 0.5 }, "-=0.2")
        }

        const companyIndicator = company.querySelector('.company__indicator');
        if (companyIndicator) {
            companyTL.from(companyIndicator, { opacity: 0, yPercent: 15, duration: 0.5 }, "-=0.2")
        }

        const companyText = company.querySelector('.company__text');
        if (companyText) {
            companyTL.from(companyText, { opacity: 0, yPercent: 15, duration: 0.5 }, "-=0.2")
        }

        companyTL.add(function () {
            company.classList.add('_show');
        });
    }

    /* Секция clients */
    const clients = document.querySelector('.clients');
    if (clients) {
        let clientsTL = gsap.timeline({
            scrollTrigger: {
                trigger: clients,
                start: "top 90%",
                end: "bottom top",
                // markers: true,
                toggleActions: "restart resume resume resume"
            }
        })

        const clientsHeading = clients.querySelector('.clients__heading');
        if (clientsHeading) {
            clientsTL.from(clientsHeading, { opacity: 0, yPercent: 15, duration: 0.5 })
        }

        const clientsItems = clients.querySelectorAll('.clients__slide');
        if (clientsItems) {
            clientsItems.forEach(element => {
                clientsTL.from(element, { opacity: 0, yPercent: 15, duration: 0.3 }, "-=0.2")
            });
        }
    }

    /* Секция team */
    const team = document.querySelector('.team');
    if (team) {
        let teamTL = gsap.timeline({
            scrollTrigger: {
                trigger: team,
                start: "top 90%",
                end: "bottom top",
                toggleActions: "restart resume resume resume"
            }
        })

        const teamHeading = team.querySelector('.team__heading');
        if (teamHeading) {
            teamTL.from(teamHeading, { opacity: 0, yPercent: 15, duration: 0.3 })
        }

        const teamItems = team.querySelectorAll('.team__item');
        if (teamItems.length > 0) {
            teamItems.forEach(element => {
                teamTL.from(element, { opacity: 0, yPercent: 15, duration: 0.3 }, "-=0.2")
            });
        }

        const teamCaption = team.querySelector('.team__caption');
        if (teamCaption) {
            teamTL.add(
                function () {
                    gsap.to(teamCaption, {
                        scrollTrigger: {
                            trigger: teamCaption,
                            start: "top 90%",
                            end: "bottom top",
                            toggleActions: "restart resume resume resume"
                        },
                        opacity: 1,
                        y: 0,
                        duration: 0.3
                    })
                },
                {
                    duration: 0.3
                }
            )
        }

        const teamFounderAbout = team.querySelector('.team__founder-about');
        if (teamFounderAbout) {
            teamTL.add(
                function () {
                    gsap.to(teamFounderAbout, {
                        scrollTrigger: {
                            trigger: teamFounderAbout,
                            start: "top 90%",
                            end: "bottom top",
                        },
                        opacity: 1,
                        y: 0,
                        duration: 0.3
                    })
                },
                {
                    duration: 0.3
                }
            )
        }

        const teamFounderQuote = team.querySelector('.team__founder-quote');
        if (teamFounderQuote) {
            teamTL.add(
                function () {
                    gsap.to(teamFounderQuote, {
                        scrollTrigger: {
                            trigger: teamFounderQuote,
                            start: "top 90%",
                            end: "bottom top",
                        },
                        opacity: 1,
                        y: 0,
                        duration: 0.3
                    })
                },
                {
                    duration: 0.3
                }
            )
        }

        const teamPerson = team.querySelector('.team__person');
        if (teamPerson) {
            teamTL.add(
                function () {
                    gsap.to(teamPerson, {
                        scrollTrigger: {
                            trigger: teamPerson,
                            start: "top 90%",
                            end: "bottom top",
                        },
                        opacity: 1,
                        y: 0,
                        duration: 0.5
                    })
                    team.classList.add('_active');
                },
                {
                    duration: 0.5
                }
            )
        }
    }

    /* Секция awards */
    const awards = document.querySelector('.awards');
    if (awards) {
        let awardsTL = gsap.timeline({
            scrollTrigger: {
                trigger: awards,
                start: "top 90%",
                end: "bottom top",
            }
        })

        const awardsHeading = awards.querySelector('.awards__heading');
        if (awardsHeading) {
            awardsTL.from(awardsHeading, { opacity: 0, yPercent: 15, duration: 0.3 })
        }

        const awardsItems = awards.querySelectorAll('.awards__item');
        if (awardsItems.length > 0) {
            awardsItems.forEach(element => {
                awardsTL.from(element, { opacity: 0, yPercent: 15, duration: 0.3 }, "-=0.2")
            });
        }

        const awardsButton = awards.querySelector('.awards__button');
        if (awardsButton) {
            awardsTL.from(awardsButton, { opacity: 0, yPercent: 15, duration: 0.3 })
        }
    }

    /* Секция steps2 */
    const steps2 = document.querySelector('.steps2');
    if (steps2) {
        let steps2TL = gsap.timeline({
            scrollTrigger: {
                trigger: steps2,
                start: "top 90%",
                end: "bottom top",
            }
        })

        const steps2Heading = steps2.querySelector('.steps2__heading');
        if (steps2Heading) {
            steps2TL.from(steps2Heading, { opacity: 0, yPercent: 15, duration: 0.3 })
        }

        const steps2Items = steps2.querySelectorAll('.steps2__item');
        if (steps2Items.length > 0) {
            steps2TL.add(
                function () {
                    steps2Items.forEach(element => {
                        gsap.from(element, {
                            scrollTrigger: {
                                trigger: element,
                                start: "top 85%",
                                end: "bottom top",
                            },
                            opacity: 0,
                            yPercent: 15,
                            duration: 0.5,
                        })
                    });
                },
                {
                    duration: 0.5,
                }
            )
        }
    }

    /* Секция cta */
    const cta = document.querySelectorAll('.cta');
    if (cta.length > 0) {
        cta.forEach(ctaElement => {
            let ctaTL = gsap.timeline({
                scrollTrigger: {
                    trigger: ctaElement,
                    start: "top 90%",
                    end: "bottom top",
                }
            })

            const ctaText = ctaElement.querySelector('.cta__text');
            if (ctaText) {
                ctaTL.from(ctaText, { opacity: 0, yPercent: 15, duration: 0.3 })
            }
            const ctaButton = ctaElement.querySelector('.cta__button');
            if (ctaButton) {
                ctaTL.from(ctaButton, { opacity: 0, yPercent: 15, duration: 0.3 })
            }
        });
    }

    /* Секция partners */
    const partners = document.querySelector('.partners');
    if (partners) {
        let partnersTL = gsap.timeline({
            scrollTrigger: {
                trigger: partners,
                start: "top 90%",
                end: "bottom top",
            }
        })

        const partnersHeading = partners.querySelector('.partners__heading');
        if (partnersHeading) {
            partnersTL.from(partnersHeading, { opacity: 0, yPercent: 15, duration: 0.3 })
        }

        const partnersImage = partners.querySelector('.partners__image');
        if (partnersImage) {
            partnersTL.add(
                function () {
                    gsap.to(partnersImage, {
                        scrollTrigger: {
                            trigger: partnersImage,
                            start: "top 90%",
                            end: "bottom top",
                        },
                        opacity: 1,
                        x: 0,
                        duration: 0.5
                    })

                    partners.classList.add('_active');
                },
                {
                    duration: 0.5
                }
            )
        }

        const partnersText1 = partners.querySelector('.partners__top .partners__text');
        if (partnersText1) {
            partnersTL.add(
                function () {
                    gsap.to(partnersText1, {
                        scrollTrigger: {
                            trigger: partnersText1,
                            start: "top 90%",
                            end: "bottom top",
                        },
                        opacity: 1,
                        x: 0,
                        duration: 0.5
                    })
                },
                {
                    duration: 0.5,
                    delay: "-=0.2"
                }
            )
        }

        const partnersCaption = partners.querySelector('.partners__caption');
        if (partnersCaption) {
            partnersTL.add(
                function () {
                    gsap.to(partnersCaption, {
                        scrollTrigger: {
                            trigger: partnersCaption,
                            start: "top 90%",
                            end: "bottom top",
                        },
                        opacity: 1,
                        y: 0,
                        duration: 0.5
                    })
                },
                {
                    duration: 0.5,
                }
            )
        }

        const partnersText2 = partners.querySelector('.partners__main .partners__text');
        if (partnersText2) {
            partnersTL.add(
                function () {
                    gsap.to(partnersText2, {
                        scrollTrigger: {
                            trigger: partnersText2,
                            start: "top 90%",
                            end: "bottom top",
                        },
                        opacity: 1,
                        y: 0,
                        duration: 0.5
                    })
                },
                {
                    duration: 0.5,
                }
            )
        }

        const partnersButton = partners.querySelector('.partners__button');
        if (partnersButton) {
            partnersTL.add(
                function () {
                    gsap.to(partnersButton, {
                        scrollTrigger: {
                            trigger: partnersButton,
                            start: "top 90%",
                            end: "bottom top",
                        },
                        opacity: 1,
                        y: 0,
                        duration: 0.3
                    })
                },
                {
                    duration: 0.3,
                }
            )
        }
    }

    /* Секция services */
    const services = document.querySelector('.services');
    if (services) {
        const servicesHeading = services.querySelector('.services__heading');
        if (servicesHeading) {
            gsap.from(servicesHeading, {
                scrollTrigger: {
                    trigger: servicesHeading,
                    start: "top 90%",
                    end: "bottom top",
                },
                opacity: 0,
                yPercent: 15,
                duration: 0.3
            })
        }

        const servicesItems = services.querySelectorAll('.services__item');
        if (servicesItems.length > 0) {
            let j = 0;
            servicesItems.forEach(element => {
                let elementTL = gsap.timeline({
                    scrollTrigger: {
                        trigger: element,
                        start: "top 90%",
                        end: "bottom top",
                    }
                })

                const elementImage = element.querySelector('.service-item__image');
                const elementBody = element.querySelector('.service-item__body');

                if (j % 2 == 0) {
                    if (elementImage) {
                        elementTL.from(elementImage, { opacity: 0, xPercent: -15, duration: 0.5 })
                    }
                    if (elementBody) {
                        elementTL.from(elementBody, { opacity: 0, xPercent: 15, duration: 0.5 })
                    }
                } else {
                    if (elementImage) {
                        elementTL.from(elementImage, { opacity: 0, xPercent: 15, duration: 0.5 })
                    }
                    if (elementBody) {
                        elementTL.from(elementBody, { opacity: 0, xPercent: -15, duration: 0.5 })
                    }
                }

                j++;
            });
        }
    }

    /* Секция blog */
    const blog = document.querySelector('.blog');
    if (blog) {
        let blogTL = gsap.timeline({
            scrollTrigger: {
                trigger: blog,
                start: "top 90%",
                end: "bottom top",
            }
        })

        const blogTitle = blog.querySelector('.blog__title');
        if (blogTitle) {
            blogTL.from(blogTitle, { opacity: 0, yPercent: 15, duration: 0.3 })
        }

        const blogText = blog.querySelector('.blog__text');
        if (blogText) {
            blogTL.from(blogText, { opacity: 0, yPercent: 15, duration: 0.4 })
        }

        const blogMailing = blog.querySelector('.blog__mailing');
        if (blogMailing) {
            blogTL.from(blogMailing, { opacity: 0, yPercent: 15, duration: 0.5 })
        }

        const blogCategories = blog.querySelectorAll('.portfolio-categories__item');
        if (blogCategories.length > 0) {
            blogCategories.forEach(element => {
                blogTL.from(element, { opacity: 0, yPercent: 15, duration: 0.3 }, "-=0.2")
            });
        }
    }

    /* Секция article */
    const article = document.querySelector('.single-article');
    if (article) {
        let articleTL = gsap.timeline({
            scrollTrigger: {
                trigger: article,
                start: "top 90%",
                end: "bottom top",
            }
        })

        const articleBack = article.querySelector('.back');
        if (articleBack) {
            articleTL.from(articleBack, { opacity: 0, yPercent: 15, duration: 0.3 }, "0.3")
        }

        const articleWrapper = article.querySelector('.single-article__wrapper');
        if (articleWrapper) {
            articleTL.from(articleWrapper, { opacity: 0, yPercent: 15, duration: 0.4 })
        }

        const articlePreview = article.querySelector('.single-article__preview');
        if (articlePreview) {
            articleTL.from(articlePreview, { opacity: 0, yPercent: 15, duration: 0.3 })
        }

        const articleContent = article.querySelector('.single-article__content');
        if (articleContent) {
            articleTL.from(articleContent, { opacity: 0, yPercent: 5, duration: 0.5 }, "-=0.2")
        }
    }

    /* Секция job */
    const job = document.querySelector('.job');
    if (job) {
        let jobTL = gsap.timeline({
            scrollTrigger: {
                trigger: job,
                start: "top 90%",
                end: "bottom top",
            }
        })

        const jobHeading = job.querySelector('.job__heading');
        if (jobHeading) {
            jobTL.from(jobHeading, { opacity: 0, yPercent: 15, duration: 0.3 })
        }

        const jobItems = job.querySelectorAll('.job__item');
        if (jobItems.length > 0) {
            jobItems.forEach(element => {
                jobTL.from(element, { opacity: 0, xPercent: 15, duration: 0.5 }, "-=0.2s")
            });
        }
    }

    /* Секция addresses */
    const addresses = document.querySelector('.addresses');
    if (addresses) {
        let addressesTL = gsap.timeline({
            scrollTrigger: {
                trigger: addresses,
                start: "top 90%",
                end: "bottom top",
                // markers: true,
            }
        })

        const addressesText = addresses.querySelector('.addresses__text');
        if (addressesText) {
            addressesTL.from(addressesText, { opacity: 0, yPercent: 15, duration: 0.3 })
        }

        const addressesContacts = addresses.querySelectorAll('.contacts__item');
        if (addressesContacts.length > 0) {
            addressesContacts.forEach(element => {
                addressesTL.from(element, { opacity: 0, yPercent: 15, duration: 0.4 }, "-=0.2")
            });
        }

        const addressesMap = addresses.querySelector('.addresses__map');
        if (addressesMap) {
            addressesTL.from(addressesMap, { opacity: 0, xPercent: 15, duration: 0.4 }, "-=0.2")
        }
    }

    /* Секция portfolio */
    const portfolio = document.querySelector('.portfolio');
    if (portfolio) {
        let portfolioTL = gsap.timeline({
            scrollTrigger: {
                trigger: portfolio,
                start: "top 90%",
                end: "bottom top",
            }
        })

        const portfolioHeading = portfolio.querySelectorAll('.portfolio__heading ._content *');
        if (portfolioHeading.length > 0) {
            portfolioHeading.forEach(element => {
                portfolioTL.from(element, { opacity: 0, yPercent: 15, duration: 0.3 })
            });
        }

        const portfolioCategories = portfolio.querySelectorAll('.portfolio-categories__item');
        if (portfolioCategories.length > 0) {
            portfolioCategories.forEach(element => {
                portfolioTL.from(element, { opacity: 0, yPercent: 15, duration: 0.4 }, "-=0.2")
            });
        }

        const portfolioItems = portfolio.querySelectorAll('.portfolio__item');
        if (portfolioItems.length > 0) {
            portfolioItems.forEach(element => {
                gsap.to(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top 90%",
                        end: "bottom top",
                    },
                    opacity: 1,
                    x: 0,
                    duration: 0.5
                })
            });
        }

        const portfolioPagination = portfolio.querySelector('.portfolio__pagination');
        if (portfolioPagination) {
            portfolioTL.add(
                function () {
                    gsap.to(portfolioPagination, {
                        scrollTrigger: {
                            trigger: portfolioPagination,
                            start: "top 90%",
                            end: "bottom top",
                        },
                        opacity: 1,
                        y: 0,
                        duration: 0.5
                    })
                },
                {
                    duration: 0.5
                }
            )
        }
    }

    /* Секция case-details */
    const caseDetails = document.querySelector('.case-details');
    if (caseDetails) {
        let caseDetailsTL = gsap.timeline({
            scrollTrigger: {
                trigger: caseDetails,
                start: "top 90%",
                end: "bottom top",
            }
        })

        const caseDetailsCaption = caseDetails.querySelectorAll('.item-details__caption');
        if (caseDetailsCaption.length > 0) {
            caseDetailsCaption.forEach(element => {
                gsap.to(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top 90%",
                    },
                    opacity: 1,
                    yPercent: 0,
                    duration: 0.3
                })
            });
        }

        const caseDetailsIndicators = caseDetails.querySelectorAll('.item-details__indicator');
        if (caseDetailsIndicators.length > 0) {
            caseDetailsIndicators.forEach(element => {
                caseDetailsTL.add(
                    function () {
                        gsap.from(element, {
                            scrollTrigger: {
                                trigger: element,
                                start: "top 97%",
                            },
                            opacity: 0,
                            yPercent: 15,
                            duration: 0.3
                        })
                    },
                    {
                        duration: 0.3,
                    }
                )
            });
        }

        const caseDetailsGallery = caseDetails.querySelectorAll('.item-details__gallery>a');
        if (caseDetailsGallery.length > 0) {
            caseDetailsGallery.forEach(element => {
                caseDetailsTL.add(
                    function () {
                        gsap.from(element, {
                            scrollTrigger: {
                                trigger: element,
                                start: "top 95%",
                                end: "bottom top",
                            },
                            opacity: 0,
                            yPercent: 5,
                            duration: 0.3
                        })
                    },
                    {
                        duration: 0.3
                    }
                )
            });
        }

        const caseDetailsBodyContent = caseDetails.querySelectorAll('.item-details__body ._content');
        if (caseDetailsBodyContent.length > 0) {
            caseDetailsBodyContent.forEach(element => {
                caseDetailsTL.add(
                    function () {
                        gsap.from(element, {
                            scrollTrigger: {
                                trigger: element,
                                start: "top 95%",
                                end: "bottom top",
                            },
                            opacity: 0,
                            yPercent: 15,
                            duration: 0.3
                        })
                    },
                    {
                        duration: 0.3
                    }
                )
            });
        }
    }

    /* Секция case-navigation */
    const caseNavigation = document.querySelector('.case-navigation');
    if (caseNavigation) {
        const caseNavigationItems = caseNavigation.querySelectorAll('.case-navigation__item');
        if (caseNavigationItems.length > 0) {
            caseNavigationItems.forEach(element => {
                gsap.to(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top 90%",
                    },
                    opacity: 1,
                    x: 0,
                    duration: 0.5
                })
            });
        }
    }

    /* Секция firstscreen */
    const firstscreen = document.querySelector('.firstscreen');
    if (firstscreen) {
        let firstscreenTL = gsap.timeline({
            scrollTrigger: {
                trigger: firstscreen,
                start: "top 90%",
                end: "bottom top",
            }
        })

        const firstscreenText = firstscreen.querySelectorAll('.firstscreen__text *');
        if (firstscreenText.length > 0) {
            firstscreenText.forEach(element => {
                firstscreenTL.from(element, { opacity: 0, yPercent: 15, duration: 0.3 })
            });
        }

        const firstscreenButtons = firstscreen.querySelectorAll('.firstscreen__btn');
        if (firstscreenButtons.length > 0) {
            firstscreenButtons.forEach(element => {
                firstscreenTL.from(element, { opacity: 0, yPercent: 15, duration: 0.3 })
            });
        }

        const firstscreenSocial = firstscreen.querySelectorAll('.social__item');
        if (firstscreenSocial.length > 0) {
            firstscreenSocial.forEach(element => {
                firstscreenTL.from(element, { opacity: 0, yPercent: 15, duration: 0.3 })
            });
        }
    }

    /* Секция timeline */
    const timeline = document.querySelector('.timeline');
    if (timeline) {
        const timelineHeading = timeline.querySelectorAll('.timeline__heading *');
        if (timelineHeading.length > 0) {
            timelineHeading.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top 90%",
                        end: "bottom top",
                    },
                    opacity: 0,
                    y: 15,
                    duration: 0.3
                })
            });
        }

        const timelineItems = timeline.querySelectorAll('.timeline__item');
        if (timelineItems.length > 0) {
            timelineItems.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top bottom",
                        end: "bottom top",
                    },
                    opacity: 0,
                    y: 15,
                    duration: 0.3
                })
            });
        }
    }

    /* Секция steps */
    const steps = document.querySelector('.steps');
    if (steps) {
        const stepsTitle = steps.querySelectorAll('.steps__title *');
        if (stepsTitle.length > 0) {
            stepsTitle.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top 90%",
                        end: "bottom top",
                    },
                    opacity: 0,
                    y: 15,
                    duration: 0.3
                })
            });
        }

        const stepsItems = steps.querySelectorAll('.steps__item');
        if (stepsItems.length > 0) {
            stepsItems.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top bottom",
                        end: "bottom top",
                    },
                    opacity: 0,
                    y: 15,
                    duration: 0.3
                })
            });
        }
    }

    /* Секция cost */
    const cost = document.querySelector('.cost');
    if (cost) {
        const costTitle = cost.querySelector('.cost__title');
        if (costTitle) {
            gsap.from(costTitle, {
                scrollTrigger: {
                    trigger: costTitle,
                    start: "top 90%",
                    end: "bottom top",
                },
                opacity: 0,
                y: 15,
                duration: 0.3
            })
        }

        const costText = cost.querySelectorAll('.cost__text *');
        if (costText.length > 0) {
            costText.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top 90%",
                        end: "bottom top",
                    },
                    opacity: 0,
                    y: 15,
                    duration: 0.3
                })
            });
        }

        const costItems = cost.querySelectorAll('.cost__item');
        if (costItems.length > 0) {
            costItems.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top 90%",
                        end: "bottom top",
                    },
                    opacity: 0,
                    y: 15,
                    duration: 0.3
                })
            });
        }
    }

    /* Секция image-full */
    const imageFull = document.querySelector('.image-full');
    if (imageFull) {
        const imageFullImage = imageFull.querySelector('.image-full__image');
        if (imageFullImage) {
            gsap.from(imageFullImage, {
                scrollTrigger: {
                    trigger: imageFullImage,
                    start: "top 90%",
                    end: "bottom top",
                },
                opacity: 0,
                xPercent: -15,
                duration: 0.3
            })
        }
        const imageFullBody = imageFull.querySelectorAll('.image-full__body *');
        if (imageFullBody.length > 0) {
            imageFullBody.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top 90%",
                        end: "bottom top",
                    },
                    opacity: 0,
                    yPercent: 15,
                    duration: 0.3
                })
            });
        }
    }

    /* Секция features */
    const features = document.querySelector('.features');
    if (features) {
        const featuresTitle = features.querySelector('.features__title');
        if (featuresTitle) {
            gsap.from(featuresTitle, {
                scrollTrigger: {
                    trigger: featuresTitle,
                    start: "top 90%",
                    end: "bottom top",
                },
                opacity: 0,
                yPercent: 15,
                duration: 0.3,
            })
        }

        const featuresItems = features.querySelectorAll('.features__item');
        if (featuresItems.length > 0) {
            featuresItems.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top 90%",
                        end: "bottom top",
                    },
                    opacity: 0,
                    yPercent: 15,
                    duration: 0.3
                })
            });
        }
    }

    /* Секция features2 */
    const features2 = document.querySelector('.features2');
    if (features2) {
        const features2Heading = features2.querySelectorAll('.features2__heading *');
        if (features2Heading.length > 0) {
            features2Heading.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top 90%",
                        end: "bottom top",
                    },
                    opacity: 0,
                    yPercent: 15,
                    duration: 0.3
                })
            });
        }

        const features2Items = features2.querySelectorAll('.features2__item');
        if (features2Items.length > 0) {
            features2Items.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top 90%",
                        end: "bottom top",
                    },
                    opacity: 0,
                    yPercent: 15,
                    duration: 0.3
                })
            });
        }
    }

    /* Секция cta2 */
    const cta2 = document.querySelectorAll('.cta2');
    if (cta2.length > 0) {
        cta2.forEach(element => {
            const cta2Text = element.querySelectorAll('.cta2__text *');
            if (cta2Text.length > 0) {
                cta2Text.forEach(p => {
                    gsap.from(p, {
                        scrollTrigger: {
                            trigger: p,
                            start: "top bottom",
                            end: "bottom top",
                        },
                        opacity: 0,
                        yPercent: 15,
                        duration: 0.3
                    })
                });
            }

            const cta2Button = element.querySelector('.cta2__button');
            if (cta2Button) {
                gsap.from(cta2Button, {
                    scrollTrigger: {
                        trigger: cta2Button,
                        start: "top 90%",
                        end: "bottom top",
                    },
                    opacity: 0,
                    yPercent: 15,
                    duration: 0.3
                })
            }
        });
    }

    /* Секция reviews2 */
    const reviews2 = document.querySelector('.reviews2');
    if (reviews2) {
        const reviews2Heading = reviews2.querySelector('.reviews2__heading');
        if (reviews2Heading) {
            gsap.from(reviews2Heading, {
                scrollTrigger: {
                    trigger: reviews2Heading,
                    start: "top 90%",
                    end: "bottom top",
                },
                opacity: 0,
                yPercent: 15,
                duration: 0.3
            })
        }

        const reviews2Items = reviews2.querySelectorAll('.reviews2__slide');
        if (reviews2Items.length > 0) {
            reviews2Items.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top 90%",
                        end: "bottom top",
                    },
                    opacity: 0,
                    yPercent: 15,
                    duration: 0.3
                })
            });
        }
    }

    /* Секция banner */
    const banner = document.querySelector('.banner');
    if (banner) {
        const bannerText = banner.querySelectorAll('.banner__text *');
        if (bannerText.length > 0) {
            bannerText.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top 90%",
                        end: "bottom top",
                    },
                    opacity: 0,
                    yPercent: 15,
                    duration: 0.3
                })
            });
        }

        const bannerBtn = banner.querySelector('.banner__btn');
        if (bannerBtn) {
            gsap.from(bannerBtn, {
                scrollTrigger: {
                    trigger: bannerBtn,
                    start: "top 90%",
                    end: "bottom top",
                },
                opacity: 0,
                yPercent: 15,
                duration: 0.3
            })
        }
    }

    /* Секция template26 */
    const template26 = document.querySelector('.template26');
    if (template26) {
        const template26Heading = template26.querySelectorAll('.template26__heading *');
        if (template26Heading.length > 0) {
            template26Heading.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top 85%",
                        end: "bottom top",
                    },
                    opacity: 0,
                    yPercent: 15,
                    duration: 0.5,
                })
            });
        }

        const template26Text = template26.querySelectorAll('.template26__text *');
        if (template26Text.length > 0) {
            template26Text.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top bottom",
                        end: "bottom top",
                    },
                    opacity: 0,
                    yPercent: 15,
                    duration: 0.5,
                })
            });
        }

        const template26Img = template26.querySelector('.template26__img');
        if (template26Img) {
            gsap.from(template26Img, {
                scrollTrigger: {
                    trigger: template26Img,
                    start: "top bottom",
                    end: "bottom top",
                },
                opacity: 0,
                xPercent: 15,
                duration: 0.5,
            })
        }

        const template26ServicesHeading = template26.querySelectorAll('.template26-services__heading *');
        if (template26ServicesHeading.length > 0) {
            template26ServicesHeading.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top bottom",
                        end: "bottom top",
                    },
                    opacity: 0,
                    yPercent: 15,
                    duration: 0.5,
                })
            });
        }

        const template26ServicesItems = template26.querySelectorAll('.template26-services__item');
        if (template26ServicesItems.length > 0) {
            template26ServicesItems.forEach(element => {
                gsap.from(element, {
                    scrollTrigger: {
                        trigger: element,
                        start: "top bottom",
                        end: "bottom top",
                    },
                    opacity: 0,
                    yPercent: 15,
                    duration: 0.5,
                })
            });
        }
    }
}

document.addEventListener("DOMContentLoaded", sectionAnimation())

/* Портфолио. Показать еще */
const portfolioBtn = document.querySelector('.portfolio__btn button');
if (portfolioBtn) {
    let click = 1;

    portfolioBtn.addEventListener('click', function () {
        portfolioBtnClick(click);
        ScrollTrigger.refresh();
        click++;
    })
}

function portfolioBtnClick(click) {
    let hiddenRow = document.querySelector('.portfolio__items_hidden');
    console.log(hiddenRow);

    if (hiddenRow) {
        if (click % 2 == 1) {
            hiddenRow.style.display = "grid";
            _slideDown(hiddenRow);
            portfolioBtn.innerHTML = "Скрыть";
        } else {
            hiddenRow.style.display = "";
            _slideUp(hiddenRow);
            portfolioBtn.innerHTML = "Показать еще";
        }
    }
}

/* Закрываем меню мне клике на Escape */
document.addEventListener("keydown", function (e) {
    if (e.code === 'Escape' && document.querySelector('.menu-open')) {
        menuClose();
    }
})

/* Ajax подгрузка блога */
const blogBtn = document.querySelector('.blog__more .btn');
if (blogBtn) {
    const itemsCount = document.querySelector('.items-count').innerHTML;

    const outputLength = document.querySelectorAll('.blog-item').length;
    if (outputLength >= itemsCount) {
        blogBtn.classList.add('_hidden');
    }

    let paged = 1;
    const output = document.querySelector('.blog__items');
    // const taxonomy = document.querySelector('.portfolio-categories__item ._active').dataset.taxonomy.toLowerCase();

    blogBtn.addEventListener('click', function () {
        // loadMore(taxonomy);
        loadMore();
    });

    function loadMore() {
        output.classList.add('_loading');
        paged += 1;

        fetch(myajax.url, {
            method: "POST",
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            // body: `action=getpost&post_type=blog&page=${paged}&taxonomy=${taxonomy}`
            body: `action=getpost&post_type=blog&page=${paged}`
        }).then(
            res => res.text()
        ).then(
            data => {
                output.insertAdjacentHTML(
                    'beforeend',
                    data
                );

                if (document.querySelectorAll('.blog-item').length >= itemsCount) {
                    blogBtn.classList.add('_hidden');
                }

                output.classList.remove('_loading');
            }
        ).catch(error => {
            alert('Ошибка');
            console.log(error);
            output.classList.remove('_loading');
        })
    }
}

/* Главная. Курсор */
const frontpage = document.querySelector('.frontpage');
if (frontpage) {
    const frontpageGo = frontpage.querySelector('.frontpage__go');
    frontpage.addEventListener('mousemove', function (e) {
        frontpageGo.style.cssText = `--move-x: ${e.clientX}px; --move-y: ${e.clientY}px`;
    })
}

/* swup */
import "../libs/swup.min.js";
import "../libs/SwupScrollPlugin.min.js";

const options = {
    animationSelector: '[class*="transition-fade"]',
    animateHistoryBrowsing: true,
    plugins: [
        new SwupScrollPlugin({
            animateScroll: false
        })
    ]
};

const swup = new Swup(options);
let scrollValues = {};

swup.on('clickLink', function () {
    menuClose();
    scrollValues[window.location.href] = window.scrollY;
    ScrollTrigger.update();
    ScrollTrigger.refresh();
});

swup.on('popState', () => {
    setTimeout(function () {
        window.scrollTo(0, scrollValues[window.location.href]);
        ScrollTrigger.update();
        ScrollTrigger.refresh();
    }, 100);
});

swup.on('contentReplaced', function () {
    ScrollTrigger.update();
    ScrollTrigger.refresh();

    /* подстраиваем размер первого экрана под шапку */
    let header = document.querySelector('header.header');
    let headerOffsetHeight = header.offsetHeight;

    let firstscreen = document.querySelector('._firstscreen');
    let main = document.querySelector('main.page');

    if (firstscreen) {
        headerOffsetHeight = header.offsetHeight
        main.style.marginTop = -headerOffsetHeight + 'px';
    }

    /* slider */
    initSliders();

    /* gallery */
    const galleries = document.querySelectorAll('[data-gallery]');
    if (galleries.length) {
        let galleyItems = [];
        galleries.forEach(gallery => {
            galleyItems.push({
                gallery,
                galleryClass: lightGallery(gallery, {
                    // plugins: [lgZoom, lgThumbnail],
                    licenseKey: '7EC452A9-0CFD441C-BD984C7C-17C8456E',
                    speed: 500,
                })
            })

            gallery.addEventListener('lgBeforeOpen', () => {
                bodyLock();
            });
            gallery.addEventListener('lgBeforeClose', () => {
                bodyUnlock();
            });
        });
    }

    /* Анимации scrollTrigger */
    sectionAnimation();

    /* Портфолио. Показать еще */
    const portfolioBtn = document.querySelector('.portfolio__btn button');
    if (portfolioBtn) {
        let click = 1;

        portfolioBtn.addEventListener('click', function () {
            portfolioBtnClick(click);
            ScrollTrigger.refresh();
            click++;
        })
    }

    showMore();

    ScrollTrigger.update();
    ScrollTrigger.refresh();
});