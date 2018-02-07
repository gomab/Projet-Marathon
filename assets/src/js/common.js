// JS commun à toutes les pages
import * as navbar from './components/navbar';
import * as scrollreveal from './lib/scrollreveal';

export default {
  init() {
    navbar.open();
    navbar.close();
    scrollreveal.init();
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
