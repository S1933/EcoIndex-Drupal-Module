<?php

namespace Drupal\ecoindex\Plugin\Validation\Constraint;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the EcoIndexFieldConstraintValidator constraint.
 */
class EcoIndexFieldConstraintValidator extends ConstraintValidator implements ContainerInjectionInterface {

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The current Request object.
   *
   * @var \Symfony\Component\HttpFoundation\Request
   */
  protected $request;

  /**
   * Constructs a EcoIndexFieldConstraintValidator object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request.
   */
  public function __construct(ConfigFactoryInterface $config_factory, Request $request) {
    $this->configFactory = $config_factory;
    $this->request = $request;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('request_stack')->getCurrentRequest()
    );
  }

  /**
   * {@inheritdoc}
   */
  public function validate($value, Constraint $constraint) {
    /** @var \Drupal\Core\Entity\ContentEntityInterface $entity */
    $entity = $this->context->getRoot()->getValue();
    if (!$entity instanceof EntityPublishedInterface) {
      return NULL;
    }

    $ecoindexSettings = $this->configFactory->get('ecoindex.settings');
    // Do nothing if required settings is disable and Preview operation.
    if (!$entity->id() ||
      !$ecoindexSettings->get('required_to_publish') ||
      $this->request->get('op') === 'Preview') {
      return NULL;
    }

    if ($entity->isPublished()) {
      $minimum_score = $this->configFactory
        ->get('ecoindex.settings')
        ->get('minimum_score');
      $score = $value->getScore();
      if ($value > 0 && $minimum_score > $score) {
        $this->context->addViolation($constraint->needsValue, [
          '%value' => $minimum_score,
        ]);
      }
    }
  }

}
