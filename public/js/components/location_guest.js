import { url } from "../variables.js";

const $SIDEBAR_ITEM_LINKS = document.querySelectorAll(".sidebar__menu-item >a");

 if (url.href.includes("guest/dashboard") == true) {
  console.info("data");
  $SIDEBAR_ITEM_LINKS[0].classList.add("sidebar__menu-item--selected");
} else if (url.href.includes("guest/data") == true) {
  console.info("data2");
  $SIDEBAR_ITEM_LINKS[1].classList.add("sidebar__menu-item--selected");
}  
