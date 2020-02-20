document.body.addEventListener("mousemove", volverPaginaPrincipal);
document.body.addEventListener("click", volverPaginaPrincipal);
document.body.addEventListener("keypress", quitarEventos);
document.body.addEventListener("scroll", volverPaginaPrincipal);
document.body.addEventListener("touchmove", volverPaginaPrincipal);

let actual = 0;
let anchoHTML = document.documentElement.offsetHeight;
let inter = scrollParaAbajo();

function quitarEventos(e) {
  if (e.keyCode == 13) {
    document.body.removeEventListener("mousemove", volverPaginaPrincipal);
    document.body.removeEventListener("click", volverPaginaPrincipal);
    document.body.removeEventListener("scroll", volverPaginaPrincipal);
    document.body.removeEventListener("touchmove", volverPaginaPrincipal);
    clearInterval(inter);
  } else {
    volverPaginaPrincipal();
  }
}

function volverPaginaPrincipal() {
  window.location.href = paginaAnterior;
  document.body.removeEventListener("mousemove", volverPaginaPrincipal);
  document.body.removeEventListener("click", volverPaginaPrincipal);
  document.body.removeEventListener("scroll", volverPaginaPrincipal);
}

function scrollParaAbajo() {
  return setInterval(function() {
    actual += 1;
    if (actual >= anchoHTML - 700) {
      clearInterval(inter);
      inter = scrollParaArriba();
      //console.log(actual)
    }
    window.scrollTo(0, actual);
  }, velocidad);
}

function scrollParaArriba() {
  return setInterval(function() {
    actual -= 1;
    if (actual <= 10) {
      clearInterval(inter);
      inter = scrollParaAbajo();
      //console.log(actual)
    }
    window.scrollTo(0, actual);
  }, velocidad);
}
