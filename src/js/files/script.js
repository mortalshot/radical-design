// Подключение функционала 
import { isMobile } from "./functions.js";
// Подключение списка активных модулей
import { flsModules } from "./modules.js";

// Отправляемся в начало страницы при перезагрузке т.к. иначе неправильно считает координаты
window.onbeforeunload = function () {
    window.scrollTo(0, 0);
}


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