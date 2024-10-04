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
 *     "coloris_color",
 *   }
 * )
 */
class ColorisWidget extends StringTextfieldWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $element['value'] = $element + [
      '#type' => 'coloriswidget',
      '#default_value' => $items[$delta]->value ?? NULL,
      '#size' => $this->getSetting('size'),
      '#placeholder' => $this->getSetting('placeholder'),
      '#maxlength' => $this->getFieldSetting('max_length'),
      '#attributes' => ['class' => ['js-text-full', 'text-full']],
      '#parent' => FALSE,
      '#alpha' => $this->getFieldSetting('alpha'),
      '#clear_button' => $this->getFieldSetting('clear_button'),
      '#clear_label' => $this->getFieldSetting('clear_label'),
      '#close_button' => $this->getFieldSetting('close_button'),
      '#close_label' => $this->getFieldSetting('close_label'),
      '#data_theme' => $this->getFieldSetting('data_theme'),
      '#default_color' => $this->getFieldSetting('default_color'),
      '#focus_input' => $this->getFieldSetting('focus_input'),
      '#force_alpha' => $this->getFieldSetting('force_alpha'),
      '#format' => $this->getFieldSetting('format'),
      '#format_toggle' => $this->getFieldSetting('format_toggle'),
      '#inline' => $this->getFieldSetting('inline'),
      '#margin' => $this->getFieldSetting('margin'),
      '#swatches' => $this->getFieldSetting('swatches'),
      '#swatches_only' => $this->getFieldSetting('swatches_only'),
      '#theme_mode' => $this->getFieldSetting('theme_mode'),
      '#wrap' => $this->getFieldSetting('wrap'),
    ];
    return $element;
  }

}
