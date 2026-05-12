function aceptarCookies() {
  document.getElementById("cookie-banner").style.display = "none";
  localStorage.setItem("cookiesAccepted", "true");
}

window.onload = function () {
  if (localStorage.getItem("cookiesAccepted") === "true") {
    document.getElementById("cookie-banner").style.display = "none";
  }
};