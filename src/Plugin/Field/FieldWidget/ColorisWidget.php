<?php

namespace Drupal\coloris\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\StringTextfieldWidget;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'options_colors' widget.
 *
 * @FieldWidget(
 *   id = "text_coloris",
 *   label = @Translation("Color selection"),
 *   field_types = {
 *     "string",
 *   },
 *   multiple_values = TRUE
 * )
 */
class ColorisWidget extends StringTextfieldWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['value'] = $element + [
        '#type' => 'coloriswidget',
        '#default_value' => $items[$delta]->value ?? NULL,
        '#size' => $this->getSetting('size'),
        '#placeholder' => $this->getSetting('placeholder'),
        '#maxlength' => $this->getFieldSetting('max_length'),
        '#attributes' => ['class' => ['js-text-full', 'text-full']],
      ];
    return $element;
  }

}
