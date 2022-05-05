<?php

namespace Drupal\coloris\Element;

use Drupal\Component\Utility\Html;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\FormElement;
use Drupal\Core\Render\Element\Textfield;

/**
 * Renders coloris widget.
 *
 * @FormElement("coloriswidget")
 */
class ColorisWidget extends Textfield {

  /**
   * {@inheritdoc}
   */
  public function getInfo() : array {
    $info = parent::getInfo();
    $class = static::class;
    $info['#process'][] = [$class, 'processFormElement'];
    return $info;
  }

  /**
   * Process render array.
   *
   * @param array $element
   *   Render array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   * @param bool $complete_form
   *   Unused variable.
   *
   * @return array
   *   Render array.
   */
  public static function processFormElement(array &$element, FormStateInterface $form_state, &$complete_form) : array {

    $parent = $element['#parent'] ?? FALSE;
    $wrap = isset($element['#wrap']) && $element['#wrap'] === FALSE ? 'false' : 'true';
    $theme = $element['#theme'] ?? 'default';
    $theme_mode = $element['#theme_mode'] ?? 'light';
    $margin = $element['#margin'] ?? 2;
    $format = $element['#format'] ?? 'hex';
    $format_toggle = isset($element['#format_toggle']) && $element['#format_toggle'] === TRUE ? 'true' : 'false';
    $alpha = isset($element['#alpha']) && $element['#alpha'] === FALSE ? 'false' : 'true';
    $swatches_only = isset($element['#swatches_only']) && $element['#swatches_only'] === TRUE ? 'true' : 'false';
    $focus_input = isset($element['#focus_input']) && $element['#focus_input'] === FALSE ? 'false' : 'true';
    $clear_button_show = isset($element['#clear_button_show']) && $element['#clear_button_show'] === TRUE ? 'true' : 'false';
    $clear_button_label = $element['#clear_button_label'] ?? t('Clear');
    $swatches = $element['#swatches'] ?? [];
    $inline = isset($element['#inline']) && $element['#inline'] === TRUE ? 'true' : 'false';
    $element = [
      '#prefix' => '<div class="coloris-wrapper">',
      '#suffix' => '</div>',
      '#type' => 'textfield',
      '#attributes' => [
        'class' => ['coloris'],
        'id' => Html::getUniqueId('coloris'),
        'data-wrap' => $wrap,
        'data-theme' => $theme,
        'data-theme-mode' => $theme_mode,
        'data-margin' => $margin,
        'data-format' => $format,
        'data-format-toggle' => $format_toggle,
        'data-alpha' => $alpha,
        'data-swatches-only' => $swatches_only,
        'data-focus-input' => $focus_input,
        'data-clear-button-show' => $clear_button_show,
        'data-clear-button-label' => $clear_button_label,
        'data-swatches' => json_encode($swatches),
        'data-inline' => $inline,
      ],
      '#required' => $element['#required'],
      '#default_value' => $element['#default_value'],
      '#title' => $element['#title'],
      '#description' => $element['#description'],
    ] + $element;

    if ($parent !== FALSE) {
      $element['#attributes']['data-parent'] = $parent;
    }

    if (isset($element['#default_color'])) {
      $element['#attributes']['data-default-color'] = $element['#default_color'];
    }

    $element['#attached']['library'][] = 'coloris/element.coloris';
    return $element;
  }

}
