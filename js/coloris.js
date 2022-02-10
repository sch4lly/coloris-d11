/**
 * @file
 * JavaScript file for the coloris module.
 */

(function ($, Drupal, drupalSettings, DrupalCoffee) {

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
      console.log('COLORIS');
    }
  };

})(jQuery, Drupal, drupalSettings);
