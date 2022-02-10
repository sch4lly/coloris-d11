<?php

namespace Drupal\coloris\Element;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\FormElement;

/**
 * Renders coloris widget.
 *
 * @FormElement("coloriswidget")
 */
class ColorisWidget extends FormElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#process' => [
        [$class, 'processFormElement'],
      ],
      '#pre_render' => [
        [$class, 'preRenderGroup'],
      ],
      '#input' => TRUE,

    ];
  }

  /**
   * Process render array.
   *
   * @param array $element
   *   Render array.
   *
   * @return array
   *   Render array.
   */
  public static function processFormElement(&$element, FormStateInterface $form_state, &$complete_form) {

    $element['coloris'] = [
      '#prefix' => '<div class="coloris">',
      '#suffix' => '</div>',
      '#type' => 'radios',
      '#required' => $element['#required'],
      '#default_value' => $element['#default_value'],
      '#title' => $element['#title']
    ];

    foreach ($element['#options'] as $key => $title) {
      if (strpos($title, '/') !== FALSE) {
        [$title, $color] = explode('/', $title);
        $element['coloris']['#options'][$key] = $title;
        $element['coloris'][$key]['#attributes']['class'][] = "color-name--{$key}";

        if (substr($color, 1) != '#') {
          $element['coloris'][$key]['#attributes']['class'][] = "color-css--{$color}";
        }

        if ($color != 'transparent') {
          $element['coloris'][$key]['#attributes']['style'] = "background:{$color};";
        }
      }
    }

    $element['colorwidget']['#attached']['library'][] = 'coloris/element.coloris';
    return $element;
  }

}
