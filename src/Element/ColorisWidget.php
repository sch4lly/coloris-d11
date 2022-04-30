<?php

namespace Drupal\coloris\Element;

use Drupal\Component\Utility\Html;
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
  public function getInfo() : array {
    $class = get_class($this);
    return [
      '#process' => [
        [$class, 'processFormElement'],
        [$class, 'processGroup'],
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
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   * @param bool $complete_form
   *   Unused variable.
   *
   * @return array
   *   Render array.
   */
  public static function processFormElement(array &$element, FormStateInterface $form_state, &$complete_form) : array {

    $swatches = $element['#swatches'] ?? [];
    $element['coloris'] = [
      '#prefix' => '<div class="coloris-wrapper">',
      '#suffix' => '</div>',
      '#type' => 'textfield',
      '#attributes' => [
        'class' => ['coloris'],
        'id' => Html::getUniqueId('coloris'),
        'data-swatches' => json_encode($swatches),
      ],
      '#required' => $element['#required'],
      '#default_value' => $element['#default_value'],
      '#title' => $element['#title'],
      '#description' => $element['#description'],
    ];

    $element['coloris']['#attached']['library'][] = 'coloris/element.coloris';
    return $element;
  }

}
