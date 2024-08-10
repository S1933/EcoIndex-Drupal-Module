<?php

namespace Drupal\ecoindex\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'ecoindex' field type.
 *
 * @FieldType(
 *   id = "ecoindex",
 *   label = @Translation("EcoIndex field"),
 *   module = "ecoindex",
 *   description = @Translation("EcoIndex."),
 *   default_widget = "ecoindex_widget",
 *   default_formatter = "ecoindex_grade_formatter",
 *   constraints = {"EcoIndexFieldConstraint" = {}}
 * )
 */
class EcoIndexItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['score'] = DataDefinition::create('integer')
    ->setLabel(new TranslatableMarkup('EcoIndex score'));

    $properties['grade'] = DataDefinition::create('string')
    ->setLabel(new TranslatableMarkup('EcoIndex grade'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'score' => [
          'description' => 'EcoIndex score.',
          'type' => 'int',
          'size' => 'tiny',
        ],
        'grade' => [
          'description' => 'EcoIndex grade.',
          'type' => 'varchar',
          'length' => 1,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getGrade(): ?string {
    return $this->grade ?: NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getScore(): ?int {
    return $this->score ?: NULL;
  }

}
