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
    attach: function (context) {
      window.setTimeout(function () {
        document.querySelectorAll('.coloris').forEach(el => {
          if (!el.getAttribute('data-coloris-once')) {
            el.setAttribute('data-coloris-once', 'true');
          } else {
            return;
          }
          if (!el.classList.contains('coloris--processed')) {
            let id = el.getAttribute('id');
            let parentString = el.getAttribute("data-parent");
            let wrapString = el.getAttribute("data-wrap");
            let themeString = el.getAttribute("data-theme");
            let themeModeString = el.getAttribute("data-theme-mode");
            let marginString = el.getAttribute("data-margin");
            let formatString = el.getAttribute("data-format");
            let formatToggleString = el.getAttribute("data-format-toggle");
            let alphaString = el.getAttribute("data-alpha");
            let swatchesOnlyString = el.getAttribute("data-swatches-only");
            let focusInputString = el.getAttribute("data-focus-input");
            let clearButtonShowString = el.getAttribute("data-clear-button-show");
            let clearButtonLabelString = el.getAttribute("data-clear-button-label");
            let inlineString = el.getAttribute("data-inline");
            let defaultColorString = el.getAttribute("data-default-color");
            let swatchesString = el.getAttribute("data-swatches");
            let swatchesObject = JSON.parse(decodeURIComponent(swatchesString));

            let settings = {
              el: '#' + id,
              wrap: wrapString === 'true',
              theme: themeString,
              themeMode: themeModeString,
              margin: marginString,
              format: formatString,
              formatToggle: formatToggleString === 'true',
              alpha: alphaString === 'true',
              swatchesOnly: swatchesOnlyString === 'true',
              focusInput: focusInputString === 'true',
              clearButton: {
                show: clearButtonShowString === 'true',
                label: clearButtonLabelString
              },
              swatches: swatchesObject,
              inline: inlineString === 'true',
              defaultColor: defaultColorString
            }

            if (parentString !== null) {
              settings.parent = parentString;
            }

            Coloris(settings);

          }
        }
        );
      },2000);
    }
  };

})(jQuery, Drupal);
