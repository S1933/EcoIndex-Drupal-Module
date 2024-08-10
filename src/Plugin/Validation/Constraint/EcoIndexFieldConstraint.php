<?php

namespace Drupal\ecoindex\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Requires a minimum value when the entity is published.
 *
 * @Constraint(
 * id = "EcoIndexField",
 * label = @Translation("Check minimum score for EcoIndex field.", context = "Validation"),
 * )
 */
class EcoIndexFieldConstraint extends Constraint {

  public $needsValue = 'Minimum EcoIndex %value it required to published.';

}
