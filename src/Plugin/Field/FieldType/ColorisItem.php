<?php

namespace Drupal\coloris\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'coloris' field type.
 *
 * @FieldType(
 *   id = "coloris_color",
 *   label = @Translation("Coloris Color"),
 *   category = @Translation("Text"),
 *   default_widget = "text_coloris",
 *   default_formatter = "coloris_color"
 * )
 */
class ColorisItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings() {
    return [
      'wrap' => TRUE,
      'data_theme' => 'default',
      'theme_mode' => 'light',
      'margin' => 2,
      'format' => 'hex',
      'format_toggle' => FALSE,
      'alpha' => TRUE,
      'force_alpha' => FALSE,
      'swatches_only' => FALSE,
      'focus_input' => TRUE,
      'select_input' => FALSE,
      'clear_button' => TRUE,
      'clear_label' => t('Clear'),
      'swatches' => [],
      'inline' => FALSE,
      'default_color' => '',
    ] + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) :array {

    $element['wrap'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Wrap'),
      '#description' => $this->t('If you wish to keep your fields unaltered, uncheck this option, in which case you will lose the color thumbnail and the accessible button (not recommended).'),
      '#default_value' => $this->getSetting('wrap') ?? TRUE,
    ];

    $element['data_theme'] = [
      '#type' => 'select',
      '#title' => $this->t('Theme', [], ['context' => 'coloris']),
      '#default_value' => $this->getSetting('data_theme') ?? 'default',
      '#options' => [
        'default' => $this->t('Default'),
        'large' => $this->t('Large'),
        'polaroid' => $this->t('Polaroid'),
      ],
      '#required' => TRUE,
    ];

    $element['theme_mode'] = [
      '#type' => 'select',
      '#title' => $this->t('Theme mode'),
      '#description' => $this->t('Set the theme to light or dark mode.'),
      '#default_value' => $this->getSetting('theme_mode') ?? 'light',
      '#options' => [
        'light' => $this->t('Light mode'),
        'dark' => $this->t('Dark mode'),
        'Auto' => $this->t('Auto'),
      ],
      '#required' => TRUE,
    ];

    $element['margin'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Margin'),
      '#description' => $this->t("The margin in pixels between the input fields and the color picker's dialog."),
      '#default_value' => $this->getSetting('margin') ?? 2,
      '#required' => TRUE,
    ];

    $element['format'] = [
      '#type' => 'select',
      '#title' => $this->t('Format'),
      '#description' => $this->t('Set the preferred color string format.'),
      '#default_value' => $this->getSetting('format') ?? 'hex',
      '#options' => [
        'hex' => $this->t('HEX'),
        'rgb' => $this->t('RGB or RGBA'),
        'hsl' => $this->t('HSL or HSLA'),
        'auto' => $this->t('Auto (Guess the format, default HEX)'),
        'mixed' => $this->t('HEX when alpha is 1, otherwise RGBA'),
      ],
      '#required' => TRUE,
    ];

    $element['format_toggle'] = [
      '#type' => 'checkbox',
      '#description' => $this->t('Whether to enable format toggle buttons in the color picker dialog.'),
      '#title' => $this->t('Format toggle'),
      '#default_value' => $this->getSetting('format_toggle') ?? FALSE,
    ];

    $element['alpha'] = [
      '#type' => 'checkbox',
      '#description' => $this->t('When disabled, it will strip the alpha value from the existing color value in all formats.'),
      '#title' => $this->t('Alpha'),
      '#default_value' => $this->getSetting('alpha') ?? TRUE,
    ];

    $element['force_alpha'] = [
      '#type' => 'checkbox',
      '#description' => $this->t('Whether to always include the alpha value in the color value even if the opacity is 100%.'),
      '#title' => $this->t('Force alpha'),
      '#default_value' => $this->getSetting('force_alpha') ?? FALSE,
    ];

    $element['swatches_only'] = [
      '#type' => 'checkbox',
      '#description' => $this->t('Whether to hide all the color picker widgets (spectrum, hue, ...) except the swatches.'),
      '#title' => $this->t('Swatches only'),
      '#default_value' => $this->getSetting('swatches_only') ?? FALSE,
    ];

    $element['focus_input'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Focus Input'),
      '#description' => $this->t('Focus the color value input when the color picker dialog is opened.'),
      '#default_value' => $this->getSetting('focus_input') ?? TRUE,
    ];

    $element['select_input'] = [
      '#type' => 'checkbox',
      '#description' => $this->t('Select and focus the color value input when the color picker dialog is opened.'),
      '#title' => $this->t('Select input'),
      '#default_value' => $this->getSetting('select_input') ?? FALSE,
    ];

    $element['clear_button'] = [
      '#type' => 'checkbox',
      '#description' => $this->t('Show an optional clear button.'),
      '#title' => $this->t('Clear button'),
      '#default_value' => $this->getSetting('clear_button') ?? TRUE,
    ];

    $element['clear_label'] = [
      '#type' => 'textfield',
      '#description' => $this->t('Set the label of the clear button.'),
      '#title' => $this->t('Clear label'),
      '#default_value' => $this->getSetting('clear_label') ?? $this->t('Clear'),
      '#required' => TRUE,
    ];

    // Gather the number of swatches in the form already.
    $swatches = $form_state->getValue('settings')['swatches'] ?? NULL;
    if (empty($swatches)) {
      $swatches = $this->getSetting('swatches');
    }
    $num_swatches = count($swatches);
    // We have to ensure that there is at least one swatch field.
    if ($num_swatches === 0) {
      $num_swatches = 1;
    }

    $element['swatches_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Swatches'),
      '#prefix' => '<div id="swatches-fieldset-wrapper">',
      '#suffix' => '</div>',
    ];

    for ($i = 0; $i < $num_swatches; $i++) {
      $element['swatches_fieldset']['swatches'][$i] = [
        '#type' => 'coloriswidget',
        '#default_value' => $swatches[$i] ?? '',
      ];
    }

    $element['swatches_fieldset']['actions'] = [
      '#type' => 'actions',
    ];

    $element['swatches_fieldset']['actions']['add_swatch'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add another item'),
      '#submit' => [[$this, 'addOne']],
      '#ajax' => [
        'callback' => [$this, 'addmoreCallback'],
        'wrapper' => 'swatches-fieldset-wrapper',
      ],
    ];

    // If there is more than one swatch, add the remove button.
    if ($num_swatches > 1) {
      $element['swatches_fieldset']['actions']['remove_swatch'] = [
        '#type' => 'submit',
        '#value' => $this->t('Remove one'),
        '#submit' => [[$this, 'removeCallback']],
        '#ajax' => [
          'callback' => [$this, 'addmoreCallback'],
          'wrapper' => 'swatches-fieldset-wrapper',
        ],
      ];
    }

    $element['inline'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Inline'),
      '#description' => $this->t('Whether to use the color picker as an inline widget. In this mode the color picker is always visible and positioned statically within its container, which is by default the body of the document.'),
      '#default_value' => $this->getSetting('inline') ?? FALSE,
    ];

    $element['default_color'] = [
      '#type' => 'coloriswidget',
      '#title' => $this->t('Default color'),
      '#description' => $this->t('In inline mode, this is the default color that is set when the picker is initialized.'),
      '#default_value' => $this->getSetting('default_color') ?? '',
    ];

    $element['#element_validate'][] = [$this, 'validateElement'];

    return $element;
  }

  /**
   * Callback for both ajax-enabled buttons.
   *
   * Selects and returns the fieldset with the swatches in it.
   */
  public function addmoreCallback(array &$form, FormStateInterface $form_state) {
    return $form['settings']['swatches_fieldset'];
  }

  /**
   * Submit handler for the "add-one-more" button.
   *
   * Increments the max counter and causes a rebuild.
   */
  public function addOne(array &$form, FormStateInterface $form_state) {
    $settings = $form_state->getValue('settings');
    $settings['swatches'][] = '';
    $form_state->setValue('settings', $settings);
    $form_state->setRebuild();
  }

  /**
   * Submit handler for the "remove one" button.
   *
   * Decrements the max counter and causes a form rebuild.
   */
  public function removeCallback(array &$form, FormStateInterface $form_state) {
    $settings = $form_state->getValue('settings');
    if (count($settings['swatches']) > 1) {
      array_pop($settings['swatches']);
      $form_state->setValue('settings', $settings);
    }
    $form_state->setRebuild();
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() :bool {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) : array {

    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Color'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() : array {
    $constraints = parent::getConstraints();

    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();

    $options['value']['Length']['max'] = 36;

    $constraints[] = $constraint_manager->create('ComplexData', $options);
    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) : array {

    $columns = [
      'value' => [
        'type' => 'varchar',
        'not null' => FALSE,
        'description' => 'Value.',
        'length' => 255,
      ],
    ];

    return [
      'columns' => $columns,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) : array {
    $values['value'] = '#' . substr(md5(mt_rand()), 0, 6);
    return $values;
  }

  /**
   * Validate the fields.
   *
   * @param array $form
   *   Form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   */
  public function validateElement(array $form, FormStateInterface $form_state) {
    $settings = &$form_state->getValue('settings');
    $settings['swatches'] = $settings['swatches_fieldset']['swatches'];
    $this->set('swatches', $settings['swatches']);
    return TRUE;
  }

}
