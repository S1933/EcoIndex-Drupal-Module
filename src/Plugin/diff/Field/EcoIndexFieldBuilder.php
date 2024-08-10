<?php

namespace Drupal\ecoindex\Plugin\diff\Field;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\diff\FieldDiffBuilderBase;

/**
 * Plugin to compare the score and grade of EcoIndex fields.
 *
 * @FieldDiffBuilder(
 *   id = "ecoindex_field_diff_builder",
 *   label = @Translation("EcoIndex Field Diff"),
 *   field_types = {
 *     "ecoindex"
 *   },
 * )
 */
class EcoIndexFieldBuilder extends FieldDiffBuilderBase {

  /**
   * {@inheritdoc}
   */
  public function build(FieldItemListInterface $field_items) {
    $result = [];

    // Every item from $field_items is of type FieldItemInterface.
    foreach ($field_items as $field_key => $field_item) {
      if (!$field_item->isEmpty()) {
        // Compare the score if that plugin options is selected.
        if ($this->configuration['compare_score']) {
          $result[$field_key][] = $field_item->getScore();
        }
        // Compare the grade if that plugin options is selected.
        if ($this->configuration['compare_grade']) {
          $result[$field_key][] = $field_item->getGrade();
        }
      }
    }

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['compare_score'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Compare EcoIndex score'),
      '#default_value' => $this->configuration['compare_score'],
    ];
    $form['compare_grade'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Compare EcoIndex grade'),
      '#default_value' => $this->configuration['compare_grade'],
    ];

    return parent::buildConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['compare_score'] = $form_state->getValue('compare_score');
    $this->configuration['compare_grade'] = $form_state->getValue('compare_grade');

    parent::submitConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $default_configuration = [
      'compare_score' => 1,
      'compare_grade' => 1,
    ];
    $default_configuration += parent::defaultConfiguration();

    return $default_configuration;
  }

}
