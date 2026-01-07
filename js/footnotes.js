/*global dotclear */
'use strict';

dotclear.ready(() => {
  const scope = '.post-content';
  const anchorPattern = /^#(fn|footnote|wiki-footnote)[:\-_\d]/gi;
  const returnPattern = /^#(fnref|footnote-marker|rev-wiki-footnote)[:\-_\d]/gi;

  // Recherche des appels de note :
  const links = Array.from(document.querySelectorAll(`${scope} a`)).filter(
    (link) => link.href.startsWith(document.location.href) && link.hash.match(anchorPattern) && !link.hash.match(returnPattern),
  );

  if (links.length > 0) {
    const footnotes = document.querySelector(`${scope} .footnotes`);
    if (footnotes) {
      // Clone footnote div with content
      const clone = footnotes.cloneNode(true);
      // Remove headers and hrs from clone
      for (const child of clone.children) {
        if (child.tagName === 'HR' || child.tagName.match(/H[1-6]/)) {
          child.remove();
        }
      }

      // Add clone after standard footnotes div
      clone.classList.add('notebox');
      footnotes.classList.add('cloned');
      footnotes.after(clone);

      // Offset helper
      const offset = function (el) {
        const box = el.getBoundingClientRect();
        return {
          top: box.top + window.pageYOffset - document.documentElement.clientTop,
          left: box.left + window.pageXOffset - document.documentElement.clientLeft,
        };
      };

      // Notes visibility helper
      // A better solution will be to use intersection observer for each link
      const check = function (note) {
        const noteoff = offset(note);
        const notesoff = offset(document.querySelector(`${scope} .footnotes.cloned`));

        const idnote = note.getAttribute('href').replace(/^.*#/, '');

        let iidnote = clone.querySelector(`.notebox #${CSS.escape(idnote)}`);
        if (iidnote.tagName === 'A') iidnote = iidnote.parentNode;

        const niveau = window.innerHeight / 1.5;
        const nivhaut = window.innerHeight / 10;

        const scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;

        if (
          noteoff && // Valid coordinates
          scrollTop > noteoff.top - niveau &&
          scrollTop < noteoff.top - nivhaut &&
          scrollTop < notesoff.top - niveau
        ) {
          iidnote.classList.add('show_note');
          iidnote.classList.remove('hide_note');
        } else {
          iidnote.classList.add('hide_note');
          iidnote.classList.remove('show_note');
        }
      };

      // Display or hide cloned notes
      const display = function () {
        // Loop on footnotes in content
        for (const link of links) {
          check(link);
        }
        if (clone.querySelectorAll('.show_note').length > 0) clone.classList.add('present');
        else clone.classList.remove('present');
      };

      // 1st display
      display();

      // Check on window scroll
      window.addEventListener('scroll', display());

      // Check on window resize
      window.addEventListener('resize', display());

      // Check every 5 seconds
      setTimeout(() => {
        // display();
      }, 5000);
    }
  }
});
