<?php

namespace Drupal\ecoindex\Plugin\rest\resource;

use Drupal\node\NodeInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Update EcoIndex value.
 *
 * @RestResource(
 *   id = "update_ecoindex",
 *   label = @Translation("Update EcoIndex value for a given uuid"),
 *   uri_paths = {
 *     "canonical" = "/api/ecoindex/{uuid}/{value}"
 *   }
 * )
 */
class UpdateEcoIndexResource extends ResourceBase {

  /**
   * Responds to get media URL by type GET requests.
   *
   * @param string $uuid
   *   The entity uuid.
   * @param string $value
   *   The EcoIndex value.
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The incoming request.
   *
   * @return \Drupal\rest\ResourceResponse
   *   The response containing the entity with its accessible fields.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   */
  public function get(string $uuid, int $value, Request $request) {
    // Check permission.
    if (!\Drupal::currentUser()->hasPermission('update ecoindex field')) {
      throw new NotFoundHttpException("Forbidden access.");
    }

    // Check node.
    $node = \Drupal::service('entity.repository')->loadEntityByUuid('node', $uuid);
    if (!$node instanceof NodeInterface) {
      throw new NotFoundHttpException("Node not found.");
    }

    $field_name = NULL;
    foreach ($node->getFieldDefinitions() as $field_name => $definition) {
      if ($definition->getType() === 'ecoindex') {
        $field_name = $field_name;
        break;
      }
    }

    // Check field.
    if (!$field_name) {
      throw new NotFoundHttpException("EcoIndex field not found.");
    }

    // Check value.
    if ($value < 0 || $value > 100) {
      throw new NotFoundHttpException("EcoIndex score should be between 0 and 100.");
    }

    // Save EcoIndex data.
    $node->set($field_name, $value);
    $node->save();

    return new ResourceResponse([]);
  }
}
