// Подключение функционала 
import { isMobile } from "./functions.js";
// Подключение списка активных модулей
import { flsModules } from "./modules.js";

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger.js';
gsap.registerPlugin(ScrollTrigger);

// Отправляемся в начало страницы при перезагрузке т.к. иначе неправильно считает координаты
window.onbeforeunload = function () {
    window.scrollTo(0, 0);
}

// подстраиваем размер первого экрана под шапку
const header = document.querySelector('header.header');
let headerOffsetHeight = header.offsetHeight;

const firstscreen = document.querySelector('._firstscreen');
if (firstscreen) {
    window.addEventListener('load', firstscreenResize)
    window.addEventListener('resize', firstscreenResize);

    function firstscreenResize() {
        headerOffsetHeight = header.offsetHeight

        firstscreen.style.marginTop = -headerOffsetHeight + 'px';
        firstscreen.style.paddingTop = headerOffsetHeight + 'px';
    }
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

const phones = document.querySelectorAll('.form__input_phone');
if (phones.length > 0) {
    phones.forEach(element => {
        element.addEventListener('input', function () {
            const value = element.value;

            if (!validatePhone(value)) {
                element.classList.add('_error');
                element.classList.remove('_success');
            } else {
                element.classList.remove('_error');
                element.classList.add('_success');
            }
        })
    });
}

// Валидация телефона
function validatePhone(phone) {
    var re = /^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/g;
    return re.test(phone);
}

// Добавляем класс "_disabled" кнопке отправки, если одно из полей формы не прошло валидацию
const forms = document.querySelectorAll('.form');
if (forms.length > 0) {
    forms.forEach(element => {
        const elementInput = element.querySelectorAll('.form__input');
        let error = 0;

        elementInput.forEach(input => {
            const inputForm = input.closest('.form');
            const submit = inputForm.querySelector('.form__submit');

            input.addEventListener('input', function () {
                if (input.classList.contains('_error')) {
                    error = 1;
                } else {
                    error = 0;
                }

                const errorInputs = document.querySelectorAll('._error');

                if (error == 0 && errorInputs.length == 0) {
                    submit.classList.remove('_disabled');
                } else {
                    submit.classList.add('_disabled');
                }
            })
        });
    });
}

/* Анимации */
/* Секция About */
const personAbout = document.querySelectorAll('.person-about');
if (personAbout.length) {
    personAbout.forEach(element => {
        ScrollTrigger.matchMedia({
            "(min-width: 319.98px)": function () {
                let elementTL = gsap.timeline({
                    scrollTrigger: {
                        trigger: element,
                        start: `${-headerOffsetHeight} bottom`,
                        end: "top top",
                    },
                })

                elementTL.from(element.querySelector('.person-about__body'), { x: "-70%", opacity: 0, duration: 1 });
            }
        });
    });
}
const aboutRow = document.querySelector('.about__bottom-row');
const aboutImage = document.querySelector('.about__image-thumb');
const aboutIndicators = document.querySelectorAll('.indicator-about');

if (aboutRow) {
    ScrollTrigger.matchMedia({
        "(min-width: 319.98px)": function () {
            let aboutRowTL = gsap.timeline({
                scrollTrigger: {
                    trigger: aboutRow,
                    start: `${-headerOffsetHeight} bottom`,
                    end: "top top",
                },
            })

            aboutRowTL.to(aboutImage, { width: 0, duration: 0.7 })

            if (aboutIndicators.length) {
                aboutIndicators.forEach(element => {
                    aboutRowTL.from(element, { opacity: 0, height: 0, duration: 0.5, }, "-=0.1")
                });
            }
        }
    });
}


/* Отправка почты */
const form = document.getElementById("form");

form.addEventListener('submit', formSend);

async function formSend(e) {
    e.preventDefault();

    let formData = new FormData(form);
    form.classList.add('_sending');
    let response = await fetch('sendmail.php', {
        method: 'POST',
        body: formData
    })

    if (response.ok) {
        let result = await response.json();
        alert(result.message);
        form.reset();
        form.classList.remove('_sending');
    } else {
        alert("Ошибка");
        form.classList.remove('_sending');
    }
}

const callBackform = document.querySelector(".callback__form form");

if (callBackform) {
    callBackform.addEventListener('submit', callBackformSend);

    async function callBackformSend(e) {
        e.preventDefault();

        let formData = new FormData(callBackform);
        callBackform.classList.add('_sending');
        let response = await fetch('sendmail.php', {
            method: 'POST',
            body: formData
        })

        if (response.ok) {
            let result = await response.json();
            alert(result.message);
            callBackform.reset();
            callBackform.classList.remove('_sending');
        } else {
            alert("Ошибка");
            callBackform.classList.remove('_sending');
        }
    }
}

/* Отключаем скролл у яндекс карты */
/* var map = document.querySelector('#map-wrap iframe')
if (map) {
    document.addEventListener('click', function (e) {
        if (e.target.id === 'map-wrap') {
            map.style.pointerEvents = 'all'
        } else {
            map.style.pointerEvents = 'none'
        }
    })
} */
