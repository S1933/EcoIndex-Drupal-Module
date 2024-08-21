<?php

namespace Drupal\ecoindex\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the EcoIndex field formatter.
 *
 * @FieldFormatter(
 *    id = "ecoindex_grade_formatter",
 *    label = @Translation("EcoIndex grade formatter"),
 *    field_types = {
 *      "ecoindex",
 *    }
 * )
 */
class EcoIndexGradeFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $entity = $items->getEntity();
      $elements[$delta] = [
        '#plain_text' => $item->grade,
        '#cache' => [
          'tags' => $entity->getCacheTags(),
        ],
      ];
    }

    return $elements;
  }

}
