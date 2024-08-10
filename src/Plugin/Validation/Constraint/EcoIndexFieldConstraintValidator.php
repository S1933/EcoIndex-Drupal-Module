<?php

namespace Drupal\ecoindex\Plugin\Validation\Constraint;

use Drupal\Core\Entity\EntityPublishedInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the EcoIndexFieldConstraintValidator constraint.
 */
class EcoIndexFieldConstraintValidator extends ConstraintValidator {

  /**
  * {@inheritdoc}
  */
  public function validate($value, Constraint $constraint) {
    /** @var \Drupal\Core\Entity\ContentEntityInterface $entity */
    $entity = $this->context->getRoot()->getValue();
    $ecoindx_settings = \Drupal::config('ecoindex.settings');
    $minimum_score = $ecoindx_settings->get('minimum_score');
    $required_to_publish = $ecoindx_settings->get('required_to_publish');

    if ($required_to_publish === TRUE &&
      $minimum_score > $value->getValue() &&
      $entity instanceof EntityPublishedInterface &&
      $entity->isPublished()
    ) {
    $this->context->addViolation($constraint->needsValue, [
      '%$value' => $minimum_score,
      '%field' => $value->getFieldDefinition()->getLabel(),
    ]);
    }
  }

}
