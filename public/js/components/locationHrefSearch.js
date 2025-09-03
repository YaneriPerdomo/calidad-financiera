export function locationHrefSearch(url = {}, value = '') {
   if (value != "") {
    return (window.location.href = url.urlData);
  } else {
    return (window.location.href = url.urlRelative);
  }
}