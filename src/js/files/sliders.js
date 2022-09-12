/*
Документация слайдера: https://swiperjs.com/
Сниппет(HTML): swiper
*/

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger.js';
gsap.registerPlugin(ScrollTrigger);

// Подключаем слайдер Swiper из node_modules
// При необходимости подключаем дополнительные модули слайдера, указывая их в {} через запятую
// Пример: { Navigation, Autoplay }
import Swiper, { Autoplay, EffectFade, Mousewheel, Pagination, Navigation, Grid } from 'swiper';
/*
Основниые модули слайдера:
Navigation, Pagination, Autoplay, 
EffectFade, Lazy, Manipulation
Подробнее смотри https://swiperjs.com/
*/

// Стили Swiper
// Базовые стили
import "../../scss/base/swiper.scss";
// Полный набор стилей из scss/libs/swiper.scss
// import "../../scss/libs/swiper.scss";
// Полный набор стилей из node_modules
// import 'swiper/css';

// Инициализация слайдеров
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

					}
				});
			}
		}
		clientsMd2.addEventListener('change', clientsHandleMd2Change);
		clientsHandleMd2Change(clientsMd2);
	}
}
// Скролл на базе слайдера (по классу swiper_scroll для оболочки слайдера)
function initSlidersScroll() {
	let sliderScrollItems = document.querySelectorAll('.swiper_scroll');
	if (sliderScrollItems.length > 0) {
		for (let index = 0; index < sliderScrollItems.length; index++) {
			const sliderScrollItem = sliderScrollItems[index];
			const sliderScrollBar = sliderScrollItem.querySelector('.swiper-scrollbar');
			const sliderScroll = new Swiper(sliderScrollItem, {
				observer: true,
				observeParents: true,
				direction: 'vertical',
				slidesPerView: 'auto',
				freeMode: {
					enabled: true,
				},
				scrollbar: {
					el: sliderScrollBar,
					draggable: true,
					snapOnRelease: false
				},
				mousewheel: {
					releaseOnEdges: true,
				},
			});
			sliderScroll.scrollbar.updateSize();
		}
	}
}

window.addEventListener("load", function (e) {
	// Запуск инициализации слайдеров
	initSliders();
	// Запуск инициализации скролла на базе слайдера (по классу swiper_scroll)
	//initSlidersScroll();
});