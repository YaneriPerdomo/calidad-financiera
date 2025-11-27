import { url } from "../variables.js";

const $SIDEBAR_ITEM_LINKS = document.querySelectorAll(".sidebar__menu-item >a");
console.info("acerca de ");
 if (url.href.includes("guest/dashboard") == true) {
  console.info("data");
  $SIDEBAR_ITEM_LINKS[0].classList.add("sidebar__menu-item--selected");
} else if (url.href.includes("transactions") == true) {
  console.info("data2");
  $SIDEBAR_ITEM_LINKS[1].classList.add("sidebar__menu-item--selected");
}  else if (
  url.href.includes("sudgeting-and-savings") == true 
) {
  $SIDEBAR_ITEM_LINKS[2].classList.add("sidebar__menu-item--selected");
}
else if (url.href.includes("about") == true) {
  console.info("data2");
  $SIDEBAR_ITEM_LINKS[3].classList.add("sidebar__menu-item--selected");
}