// Подключение функционала 
import { isMobile } from "./functions.js";
// Подключение списка активных модулей
import { flsModules } from "./modules.js";

// Отправляемся в начало страницы при перезагрузке т.к. иначе неправильно считает координаты
window.onbeforeunload = function () {
    window.scrollTo(0, 0);
}

// подстраиваем размер первого экрана под шапку
window.addEventListener('load', firstscreenResize)
window.addEventListener('resize', firstscreenResize);

function firstscreenResize() {
    const firstscreen = document.querySelector('.firstscreen');
    const header = document.querySelector('header.header');
    const headerOffsetHeight = header.offsetHeight;

    if (firstscreen) {
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