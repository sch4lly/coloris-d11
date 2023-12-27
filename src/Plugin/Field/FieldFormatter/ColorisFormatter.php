<?php

namespace Drupal\coloris\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldFilteredMarkup;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Coloris field formatter which returns the color.
 *
 * @FieldFormatter(
 *   id = "coloris_color",
 *   label = @Translation("Coloris color"),
 *   description = @Translation("Coloris color formatter"),
 *   field_types = { "coloris_color" }
 * )
 */
class ColorisFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) : array {
    $elements = [];

    // Only collect allowed options if there are actually items to display.
    if ($items->count()) {

      foreach ($items as $delta => $item) {
        $value = $item->value;
        // If the stored value is in the current set of allowed values, display
        // the associated label, otherwise just display the raw value.
        $output = $options[$value] ?? $value;

        if (strpos($output, '/') !== FALSE) {
          // Get the first part of the label.
          [$output] = explode('/', $output);
        }

        $elements[$delta] = [
          '#markup' => $output,
          '#allowed_tags' => FieldFilteredMarkup::allowedTags(),
        ];
      }

    }
    return $elements;
  }

}
