document.addEventListener("DOMContentLoaded", function () {

  // Inicializar EmailJS
  emailjs.init("TU_PUBLIC_KEY");

  const form = document.getElementById("form-cancelacion");

  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();

      emailjs.sendForm("TU_SERVICE_ID", "TU_TEMPLATE_ID", this)
        .then(function () {
          form.innerHTML = "<p>Solicitud enviada correctamente.</p>";

          form.reset();
        })
        .catch(function (error) {
          console.error("Error:", error);
          alert("Error al enviar la solicitud");
        });
    });
  }

});