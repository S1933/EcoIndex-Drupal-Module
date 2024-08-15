<?php

namespace Drupal\ecoindex;

/**
 * Service to provide helper functions for EcoIndex module.
 */
class EcoIndexHelper {

  /**
   * Get EcoIndex field name from array of fields.

   * @return string|null
   *   Field name if exists.
   */
  public function getEcoIndexFieldName(array $fields): ?string {
    foreach ($fields as $field_name => $field) {
      if ($field->getFieldDefinition()->getType() == 'ecoindex') {
        return $field_name;
      }
    }

    return NULL;
  }

}
