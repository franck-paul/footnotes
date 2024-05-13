/*global $, dotclear */
'use strict';

$(() => {
  const options = {
    anchorPattern: /(fn|footnote|note|wiki-footnote)[:\-_\d]/gi,
    footnoteTagname: 'p, li',
    numberResetSelector: '.post',
    scope: '.post',
  };
});
