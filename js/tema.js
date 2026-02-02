const botonTema = document.getElementById("btn-tema");
const body = document.body;

const temaGuardado = localStorage.getItem("tema");

if (temaGuardado === "oscuro") {
  body.classList.add("dark-mode");
  botonTema.textContent = "☀️";
}

botonTema.addEventListener("click", () => {
  body.classList.toggle("dark-mode");

  if (body.classList.contains("dark-mode")) {
    localStorage.setItem("tema", "oscuro");
    botonTema.textContent = "☀️";
  } else {
    localStorage.setItem("tema", "claro");
    botonTema.textContent = "🌙";
  }
});
