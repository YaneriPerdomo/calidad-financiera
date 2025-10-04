const fullCurrentURL = window.location.href;
let newState = {}
let urlAfterCleanup = fullCurrentURL.replace('/public/', '/');
const targetURL = urlAfterCleanup;
history.replaceState(newState, '', targetURL);