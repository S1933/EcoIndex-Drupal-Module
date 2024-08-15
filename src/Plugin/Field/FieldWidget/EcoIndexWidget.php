<?php

namespace Drupal\ecoindex\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Plugin implementation of the 'ecoindex' widget.
 *
 * @FieldWidget(
 *   id = "ecoindex_widget",
 *   label = @Translation("EcoIndex widget"),
 *   field_types = {
 *     "ecoindex"
 *   }
 * )
 */
class EcoIndexWidget extends WidgetBase implements ContainerFactoryPluginInterface {

  /**
   * The request stack.
   */
  protected RequestStack $requestStack;

  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * Constructs a EcoIndexWidget object.
   *
   * @param string $plugin_id
   *   The plugin_id for the widget.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the widget is associated.
   * @param array $settings
   *   The widget settings.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The current route match.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, array $third_party_settings, RequestStack $request_stack, RouteMatchInterface $route_match) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);
    $this->requestStack = $request_stack;
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['third_party_settings'],
      $container->get('request_stack'),
      $container->get('current_route_match')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    /** @var \Drupal\ecoindex\Plugin\Field\FieldType\EcoIndexItem $item */
    $item = $items[$delta];

    $element['score'] = [
      '#title' => $this->t('EcoIndex Score'),
      '#type' => 'number',
      '#min' => 0,
      '#max' => 100,
      '#default_value' => $item->getScore(),
    ];

    $element['grade'] = [
      '#title' => $this->t('EcoIndex Grade'),
      '#type' => 'select',
      '#options' => [
        '' => '',
        'A' => 'A',
        'B' => 'B',
        'C' => 'C',
        'D' => 'D',
        'E' => 'E',
        'F' => 'F',
        'G' => 'G',
      ],
      '#default_value' => $items[$delta]->getGrade(),
      '#description' => '<p>' . $this->t('<a href="/admin/help/ecoindex" target="_blank">Contributor guidelines</a>') . '</p>',
    ];

    return $element;
  }

}
