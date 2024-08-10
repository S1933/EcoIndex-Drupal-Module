<?php

namespace Drupal\ecoindex;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Service to provide helper functions for EcoIndex module.
 *
 */
class EcoIndexHelper {

  public function getEcoIndexFieldName(array $fields): ?string {
    foreach ($fields as $field_name => $field) {
      if ($field->getFieldDefinition()->getType() == 'ecoindex') {
        return $field_name;
      }
    }

    return NULL;
  }
}
