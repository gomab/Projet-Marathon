import * as ScrollReveal from 'scrollreveal/dist/scrollreveal.min.js';

export function init() {
  window.sr = ScrollReveal({ duration: 500 });
  sr.reveal('.card', {
    scale: 1,
    distance: '60px',
    viewFactor: 1,
  }, 100);

}