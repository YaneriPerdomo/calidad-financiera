import { url } from "../variables.js";

console.info(true);
const $SIDEBAR_ITEM_LINKS = document.querySelectorAll(".sidebar__menu-item >a");

if (url.href.includes("dashboard") == true) {
    console.info('holass')
  $SIDEBAR_ITEM_LINKS[0].classList.add("sidebar__menu-item--selected");
} else if (url.href.includes("guest") == true) {
  $SIDEBAR_ITEM_LINKS[2].classList.add("sidebar__menu-item--selected");
} else if (url.href.includes("about") == true) {
  console.info("acerca de ");
  $SIDEBAR_ITEM_LINKS[3].classList.add("sidebar__menu-item--selected");
} else if (url.href.includes("about") == true) {
  console.info("data2");
  $SIDEBAR_ITEM_LINKS[4].classList.add("sidebar__menu-item--selected");
} else if (
  url.href.includes("indicators") == true ||
  url.href.includes("indicator") == true
) {
  $SIDEBAR_ITEM_LINKS[1].classList.add("sidebar__menu-item--selected");
} else if (
  url.href.includes("data") == true ||
  url.href.includes("add-transaction") == true
) {
  $SIDEBAR_ITEM_LINKS[1].classList.add("sidebar__menu-item--selected");
}
