 
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
  const boton = document.getElementById("btn-ver-mas");

 // Mostrar enlaces
  tiendas.style.display = "flex";

  // Ocultar botón
  boton.style.display = "none";

}

//Acordeón de preguntas frecuentes
const botones = document.querySelectorAll(".acordeon-titulo");

botones.forEach(boton => {
    boton.addEventListener("click", () => {
        const contenido = boton.nextElementSibling;

        contenido.style.display =
            contenido.style.display === "block" ? "none" : "block";
    });
});