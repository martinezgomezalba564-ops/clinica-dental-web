 
/* MENU RESPONSIVE */
const toggle = document.getElementById("menu-toggle");
const nav = document.getElementById("nav");

toggle.addEventListener("click", () => {
  nav.classList.toggle("active");
});

/* EFECTO SCROLL HEADER */
window.addEventListener("scroll", () => {
  const header = document.querySelector(".header");
  header.classList.toggle("scrolled", window.scrollY > 10);
});

/** BOTON PARA MOSTAR LOS ENLACES DEL LIBRO */
function mostrarTiendas(){
  const tiendas = document.getElementById("tiendas-libro");

  if(tiendas.style.display === "block"){
    tiendas.style.display = "none";
  }else{
    tiendas.style.display = "block";
  }
}
