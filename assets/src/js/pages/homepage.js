// IMPORT LES COMPOSANTS (comme navbar ou bouton)
import 'owl.carousel/dist/owl.carousel.min.js';

export default {
  init() { // JS déclanché en premier
    // Appel des fonctions provenant des composants
    $('.owl-carousel').owlCarousel({
      dots: false,
      autoplay: true,
      nav: true,
      navText: [''],
      items: 1
    });
  },
  finalize() {
    // JS déclanché après le JS du init()
  },
};
