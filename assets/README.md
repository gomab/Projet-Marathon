# Intégration HTML / CSS / JS

## Getting start
```
npm i
npm run start
```
CODE !

## Add JS file
1) Ajouter votre fichier JS dans l'une des catégories suivante :
- src/js/<b>components</b>/ (btn, navbar, carrousel...)
- src/js/<b>lib</b>/ (librairie ajouté)
- src/js/<b>pages</b>/ (JS uniquement sur les pages)
- src/js/<b>commun.js</b> (Pour toute les pages)

2) Import ton fichier JS dans le bon fichier main
3) Si tu ajoute une page, Import ton js page dans app.js

## Add SCSS file
1) Ajoute ton fichier SCSS
2) Import ton fichier SCSS dans main.scss

# Technos :
- HTML
- CSS
  - Normalize.css 7.0.0
- SCSS
- JS
  - Jquery 3.2.1
- Webpack
  - [both] Babel (ES6)
  - [dev]  Brower sync (livereload)
  - [dev]  Clean (supprime le dossier ./dist)
  - [dev]  Sourcemap (chemin des fichiers d'origines
  - SCSS
    - [both] Extract text
  - Postcss
    - [both] Autoprefixer (rajoute les prefix pour la compatiblité navigateur (voir browserslist dans package.json) )
    - [both] css-mqpacker (concat les medias query) 
  - Purify
    - [prod] Purify (remove les class useless)
    - [prod] Uglify (minifie)