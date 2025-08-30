document.addEventListener("DOMContentLoaded", () => {
  console.log("Página del CBPM cargada 🚀");
  const countdown = document.getElementById("countdown");

  // Fecha y hora del partido
  const partidoFecha = new Date("2025-09-15T18:00:00").getTime();

  if (!countdown) {
    console.error("No se encontró el elemento #countdown");
    return;
  }

  // Función que actualiza el contador
  function actualizarContador() {
    const ahora = new Date().getTime();
    const distancia = partidoFecha - ahora;

    if (distancia > 0) {
      const dias = Math.floor(distancia / (1000 * 60 * 60 * 24));
      const horas = Math.floor((distancia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutos = Math.floor((distancia % (1000 * 60 * 60)) / (1000 * 60));
      const segundos = Math.floor((distancia % (1000 * 60)) / 1000);

      countdown.textContent = `${dias}d ${horas}h ${minutos}m ${segundos}s`;
    } else {
      countdown.textContent = "¡El partido ya comenzó! 🏀🔥";
    }
  }

  // Actualizar inmediatamente y luego cada segundo
  actualizarContador();
  setInterval(actualizarContador, 1000);
});
