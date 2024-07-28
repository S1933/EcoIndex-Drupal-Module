<?php

namespace Drupal\ecoindex\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the EcoIndex field formatter.
 *
 * @FieldFormatter(
 *    id = "ecoindex_formatter",
 *    label = @Translation("EcoIndex formatter"),
 *    field_types = {
 *      "ecoindex",
 *    }
 * )
 */
class EcoIndexFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $entity = $items->getEntity();
      $elements[$delta] = [
        '#plain_text' => $item->value,
        '#cache' => [
          'tags' => $entity->getCacheTags(),
        ],
      ];
    }

    return $elements;
  }
}
