// No need to protect for jQuery as we do not use it
// Even worse: jQuery not loaded by default for anonymous anymore
// https://www.drupal.org/node/1446420
(function (Drupal) {

/**
 * Drupal specific wrapper to load Highlight.js
 */
Drupal.behaviors.snippets = {
  attach: function(context, settings) {
    hljs.initHighlightingOnLoad();
  }
};

})(Drupal);
