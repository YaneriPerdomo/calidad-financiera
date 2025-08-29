import { url } from "../variables.js";

function location() {
  const $SIDEBAR_ITEM_LINKS = document.querySelectorAll(
    ".sidebar__menu-item >a"
  );
  if (url.href.includes("welcome") == true) {
    return $SIDEBAR_ITEM_LINKS[0].classList.add("sidebar__menu-item--selected");
  }
  if (
    url.href.includes("indicators") == true ||
    url.href.includes("indicator") == true ||
    url.href.includes("egreso") == true ||
    url.href.includes("ingreso") == true
  ) {
    return $SIDEBAR_ITEM_LINKS[2].classList.add("sidebar__menu-item--selected");
  }
  if (url.href.includes("users") == true || url.href.includes("user") == true) {
    return $SIDEBAR_ITEM_LINKS[1].classList.add("sidebar__menu-item--selected");
  }
  if (url.href.includes("admin/about") == true) {
    console.info("data");
    return $SIDEBAR_ITEM_LINKS[3].classList.add("sidebar__menu-item--selected");
  }
  if (url.href.includes("about") == true) {
    console.info("data2");
    return $SIDEBAR_ITEM_LINKS[4].classList.add("sidebar__menu-item--selected");
  }
}

location();
