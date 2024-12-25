/*global dotclear */
'use strict';

// https://blog.mondediplo.net/la-fin-de-l-innocence#nh1

// Modèle notes
//
// Markdown :
//
// NNNNNNNNNN = timestamp du billet
// n = numéro de la note (1 à n) pour le billet
//
// Appel de note :
// <sup id="fnref:tsNNNNNNNNNN.n">
//   <a href="#fn:tsNNNNNNNNNN.n">n</a>
// </sup>
//
// Note :
// <li id="#fn:tsNNNNNNNNNN.n">
//   ... <a href="#fnref:tsNNNNNNNNNN.n">↩︎</a>
// </li>
//
// Il va falloir masquer le lien de retour dans la note affichée à la volée, CSS : a:[href qui débute par #fnref:ts]
//
// À noter :
// - notes dans l'extrait et notes dans le corps collisionnent (même ids)
//
// Wiki :
//
// n = numéro de la note (1 à n) pour le billet
//
// Appel de note :
// <sup>
//   [<a href="#wiki-footnote-n" id="rev-wiki-footnote-n">n</a>]
// </sup>
// Note :
// <p>
//   [<a href="#rev-wiki-footnote-n" id="wiki-footnote-n"></a>] ...
// </p>
//
// Il va falloir masquer le lien de retour dans la note affichée à la volée, CSS : a:[href qui débute par #rev-wiki-footnote-]
//
// À noter :
// - ne fonctionne qu'en mode billet seul (pas de timestamp dans les ids)
// - notes dans l'extrait et notes dans le corps collisionnent (même ids)
//
// HTML :
//
// ABCDE = aléatoire (5 caractères alphabétiques en minuscule)
// n = numéro de la note (1 à n) pour le billet
//
// Appel de note:
// <sup data-footnote-id="ABCDE">
//   <a href="#footnote-n" id="footnote-marker-n-1" rel="footnote">[n]</a>
// </sup>
// Note :
// <li data-footnote-id="vzsmn" id="footnote-n">
//   <sup><a href="#footnote-marker-n-1">^</a> </sup>...
// </li>
//
// Il va falloir masquer le lien de retour dans la note affichée à la volée, CSS : a:[href qui débute par #footnote-marker-]
//
// À noter :
// - notes dans l'extrait et notes dans le corps collisionnent (même ids)
//
// ----
//
// Notes d'utilisation : Uniquement en mode billet/page seule, pas de notes dans les extraits

dotclear.ready(() => {
  const scope = '.post';
  const anchorPattern = /^#(fn|footnote|wiki-footnote)[:\-_\d]/gi;
  const returnPattern = /^#(fnref|footnote-marker|rev-wiki-footnote)[:\-_\d]/gi;

  // Recherche des appels de note :
  const links = Array.from(document.querySelectorAll(`${scope} a`)).filter(
    (link) => link.href.startsWith(document.location.href) && link.hash.match(anchorPattern) && !link.hash.match(returnPattern),
  );

  // Recherche des notes correspondantes :
  const notes = [];
  for (const link of links) {
    const id = link.hash.slice(1); // ID de la note
    const note = document.getElementById(id);
    if (note) {
      const item = note.tagName === 'A' ? note.parentNode() : note;
      if (item.tagName === 'P' || item.tagName === 'LI') {
        notes[id] = item;
      }
    }
  }

  // Création de la div d'affichage à la volée avec les notes disponibles
});
