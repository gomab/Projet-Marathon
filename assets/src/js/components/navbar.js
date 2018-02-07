// Création d'une fonction pour le composant : "navbar"
export function open() {
  $('.js-open-nav').click(function (e) {
    e.preventDefault();
    $('.main-nav').addClass('open');
  });
}
export function close() {
  $('.main-nav .overlay').click(function (e) {
    e.preventDefault();
    console.log(this);
    $('.main-nav').removeClass('open');
  });
}





// Autres fonctions ...