# Dotclear 2 plugin

[![Release](https://img.shields.io/github/v/release/franck-paul/bigfoot)](https://github.com/franck-paul/bigfoot/releases)
[![Date](https://img.shields.io/github/release-date/franck-paul/bigfoot)](https://github.com/franck-paul/bigfoot/releases)
[![Issues](https://img.shields.io/github/issues/franck-paul/bigfoot)](https://github.com/franck-paul/bigfoot/issues)
[![Dotaddict](https://img.shields.io/badge/dotaddict-official-green.svg)](https://plugins.dotaddict.org/dc2/details/bigfoot)
[![License](https://img.shields.io/github/license/franck-paul/bigfoot)](https://github.com/franck-paul/bigfoot/blob/master/LICENSE)

## Notes

L'option de mise en place du fond des notes de bas de page peut ne pas fonctionner correctement avec certains thèmes. Dans ce cas, il vaut mieux décocher l'option et ajouter la ou les règles correspondantes dans la feuille de style du thème, par exemple :

```css
.flightnotes {
  background-color: var(--main-background-color);
}
```

Par ailleurs cet affichage peut poser problème sur petits écrans ; dans ce cas on peut ajouter ceci dans la feuille de style :

```css
@media (width <= 40em) {
  .flightnotes {
    display: none !important;
  }
}
```

À ajuster en fonction du thème utilisé.
