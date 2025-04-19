import { url } from "../variables.js";

const $SIDEBAR_ITEM_LINKS = document.querySelectorAll('.sidebar__menu-item >a');

 if (url.href.includes('dashboard') == true) {
    $SIDEBAR_ITEM_LINKS[0].classList.add('sidebar__menu-item--selected');
} else if (url.href.includes('guest') == true) {
    $SIDEBAR_ITEM_LINKS[2].classList.add('sidebar__menu-item--selected');
}else if(url.href.includes('admin/about') == true) {
    console.info('data');
    $SIDEBAR_ITEM_LINKS[2].classList.add('sidebar__menu-item--selected');
}else if (url.href.includes('about') == true) {
    console.info('data2');
    $SIDEBAR_ITEM_LINKS[4].classList.add('sidebar__menu-item--selected');
} else if (url.href.includes('indicators') == true || url.href.includes('indicator') == true) {
    $SIDEBAR_ITEM_LINKS[1].classList.add('sidebar__menu-item--selected');
}else if (url.href.includes('data') == true ) {
    $SIDEBAR_ITEM_LINKS[1].classList.add('sidebar__menu-item--selected');
}