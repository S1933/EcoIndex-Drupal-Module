<?php

namespace Drupal\ecoindex\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure EcoIndex settings for this site.
 *
 * @internal
 */
class EcoIndexSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ecoindex_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['ecoindex.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ecoindex.settings');

    $form['minimum_score'] = [
      '#type' => 'number',
      '#min' => 0,
      '#max' => 100,
      '#title' => $this->t('Minimum score to alert contributor.'),
      '#default_value' => $config->get('minimum_score') ?? 0,
    ];

    $form['required_to_publish'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Is required to publish content ?'),
      '#default_value' => $config->get('required_to_publish') ?? FALSE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('ecoindex.settings')
      ->set('minimum_score', $form_state->getValue('minimum_score'))
      ->set('required_to_publish', $form_state->getValue('required_to_publish'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
