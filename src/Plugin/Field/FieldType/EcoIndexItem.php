<?php

namespace Drupal\ecoindex\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
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
 *   default_formatter = "ecoindex_formatter"
 * )
 */
class EcoIndexItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('integer')
      ->setLabel(t('EcoIndex value'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'value' => [
          'type' => 'int',
          'size' => 'tiny',
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraints = parent::getConstraints();
    $constraint_manager = $this->getTypedDataManager()->getValidationConstraintManager();
    $constraints[] = $constraint_manager->create('EcoIndexFieldConstraint', []);

    return $constraints;
  }

}
