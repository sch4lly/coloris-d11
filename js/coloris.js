/**
 * @file
 * JavaScript file for the coloris module.
 */

(function ($, Drupal, drupalSettings) {

  'use strict';

  /**
   * Attaches coloris module behaviors.
   *
   * Handles enable/disable token element.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attach ui coloris functionality to the page.
   *
   */
  Drupal.behaviors.coloris = {
    attach: function () {
      window.setTimeout(function () {
        document.querySelectorAll('.coloris').forEach(el => {
          if (!el.classList.contains('coloris--processed')) {
            var id = el.getAttribute('id');
            var swatchesString = el.getAttribute("data-swatches");
            var swatchesObject = JSON.parse(decodeURIComponent(swatchesString));

            Coloris({
              el: '#' + id,
              swatches: swatchesObject
            });

          }
        }
        );
      },2000);
    }
  };

})(jQuery, Drupal, drupalSettings);
