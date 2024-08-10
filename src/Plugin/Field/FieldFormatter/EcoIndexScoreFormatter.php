<?php

namespace Drupal\ecoindex\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the EcoIndex field formatter.
 *
 * @FieldFormatter(
 *    id = "ecoindex_score_formatter",
 *    label = @Translation("EcoIndex score formatter"),
 *    field_types = {
 *      "ecoindex",
 *    }
 * )
 */
class EcoIndexScoreFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $entity = $items->getEntity();
      $elements[$delta] = [
        '#plain_text' => $item->getScore(),
        '#cache' => [
          'tags' => $entity->getCacheTags(),
        ],
      ];
    }

    return $elements;
  }
}
