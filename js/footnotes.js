/*global dotclear */
'use strict';

dotclear.ready(() => {
  const data = dotclear.getData('flightnotes');

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
        if (child.tagName === 'HR' || child.tagName.match(/H[1-6]/) || child.tagName === 'HEADER') {
          child.remove();
        }
      }

      if (data?.background) {
        // Set a color background to clone
        const getDefaultBackground = () => {
          // have to add to the document in order to use getComputedStyle
          const div = document.createElement('div');
          document.head.appendChild(div);
          const bg = globalThis.getComputedStyle(div).backgroundColor;
          div.remove();
          return bg;
        };
        const getInheritedBackgroundColor = (el) => {
          // get default style for current browser
          const defaultStyle = getDefaultBackground(); // typically "rgba(0, 0, 0, 0)"
          // get computed color for el
          const { backgroundColor } = globalThis.getComputedStyle(el);
          // if we got a real value, return it
          if (backgroundColor !== defaultStyle) return backgroundColor;
          // if we've reached the top parent el without getting an explicit color, return default
          if (!el.parentElement) return defaultStyle;
          // otherwise, recurse and try again on parent element
          return getInheritedBackgroundColor(el.parentElement);
        };
        clone.style.backgroundColor = getInheritedBackgroundColor(footnotes);
      }

      // Add clone after standard footnotes div
      clone.classList.add('flightnotes');
      footnotes.classList.add('cloned');
      footnotes.after(clone);

      // Add intersection observer for each of found links (see above)
      const callback_link = (entries, _observer) => {
        for (const entry of entries) {
          const idnote = entry.target.getAttribute('href').replace(/^.*#/, '');
          let iidnote = clone.querySelector(`.flightnotes #${CSS.escape(idnote)}`);
          if (iidnote.tagName === 'A') iidnote = iidnote.parentNode;
          if (entry.isIntersecting) {
            iidnote.classList.add('flightnotes_note_show');
            iidnote.classList.remove('flightnotes_note_hide');
          } else {
            iidnote.classList.add('flightnotes_note_hide');
            iidnote.classList.remove('flightnotes_note_show');
          }
        }
        if (clone.querySelectorAll('.flightnotes_note_show').length > 0) clone.classList.add('flightnotes_show');
        else clone.classList.remove('flightnotes_show');
      };
      const io_link = new IntersectionObserver(callback_link, {
        threshold: [1],
        trackVisibility: true,
        delay: 100, // Set a minimum delay between notifications
      });
      for (const link of links) io_link.observe(link);

      // Add intersection observer for cloned footnotes (if visible no need to display on the fly)
      const callback_notes = (entries, _observer) => {
        for (const entry of entries) {
          if (entry.isIntersecting) clone.classList.add('flightnotes_hide');
          else clone.classList.remove('flightnotes_hide');
        }
      };
      const io_notes = new IntersectionObserver(callback_notes);
      io_notes.observe(footnotes);
    }
  }
});
