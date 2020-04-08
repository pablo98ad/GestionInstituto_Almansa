document.body.addEventListener("mousemove", volverPaginaPrincipal);
document.body.addEventListener("click", volverPaginaPrincipal);
document.body.addEventListener("keypress", quitarEventos);
document.body.addEventListener("scroll", volverPaginaPrincipal);
document.body.addEventListener("touchmove", volverPaginaPrincipal);

let actual = 0;
//let anchoHTML = document.documentElement.offsetHeight;
let anchoHTML = document.body.scrollHeight-950;
console.log('Ancho pagina: '+anchoHTML);
let inter = scrollParaAbajo();
let timeout;

function quitarEventos(e) {
  if (e.keyCode == 13) {
    document.body.removeEventListener("mousemove", volverPaginaPrincipal);
    document.body.removeEventListener("click", volverPaginaPrincipal);
    document.body.removeEventListener("scroll", volverPaginaPrincipal);
    document.body.removeEventListener("touchmove", volverPaginaPrincipal);
    clearInterval(inter);
    anunciosParados();
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
    if (actual >= anchoHTML/* - 500*/) {
      clearInterval(inter);
      inter = scrollParaArriba();
      
    }
    console.log('abajo: '+actual)
    window.scrollTo(0, actual);
  }, velocidad);
}

function scrollParaArriba() {
  return setInterval(function() {
    actual -= 1;
    if (actual <= 0/* -500*/) {
      clearInterval(inter);
      inter = scrollParaAbajo();
    }
    console.log('arriba: '+actual)
    window.scrollTo(0, actual);
  }, velocidad);
}

  //Para cuando estas tiempo inactivo, y con los anuncios parados se valla a la pagina anterior
function anunciosParados(){
  document.body.addEventListener('mousemove', resetearTimeout);
  document.body.addEventListener('click', resetearTimeout);
  timeout = activarTimeout();
 
}

function activarTimeout() {
  return setTimeout(function() {
      window.location.href = paginaAnterior;
  }, 180000) //3 minutos
}
function resetearTimeout() {
  clearTimeout(timeout);
  timeout = activarTimeout();
}