/**
 * @file
 * JavaScript file for the coloris module.
 */

(function ($, Drupal) {

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
            let id = el.getAttribute('id');
            let swatchesString = el.getAttribute("data-swatches");
            let swatchesObject = JSON.parse(decodeURIComponent(swatchesString));

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

})(jQuery, Drupal);
