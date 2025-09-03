import { ItemButttonSearh, ItemInputName } from "../variables.js";
import { locationHrefSearch } from "./locationHrefSearch.js";

ItemButttonSearh.addEventListener("click", async (e) => {
  return locationHrefSearch(
    {
      urlData:
        ItemInputName.getAttribute("data-url") +
        "/" +
        ItemInputName.value.trim() +
        "/1",
      urlRelative: ItemInputName.getAttribute("data-url") + "/1",
    },
    ItemInputName.value
  );
});
