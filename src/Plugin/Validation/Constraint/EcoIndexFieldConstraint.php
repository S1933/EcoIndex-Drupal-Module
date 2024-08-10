<?php

namespace Drupal\ecoindex\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Requires a minimum value when the entity is published.
 *
 * @Constraint(
 * id = "EcoIndexFieldConstraint",
 * label = @Translation("Check minimum score for EcoIndex field.", context = "Validation"),
 * type = "string"
 * )
 */
class EcoIndexFieldConstraint extends Constraint {

public $needsValue = 'Minimum %value is required for this field: %field.';

}
