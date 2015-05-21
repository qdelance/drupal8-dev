<?php

/**
 * @file
 * Contains \Drupal\snippets\Form\SnippetsSettingsForm.
 */

namespace Drupal\snippets\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SnippetsSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'snippets_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['snippets.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('snippets.settings');

    $elements = array('pre', 'code');

    $form['snippets_wrapping_element'] = array(
      '#type' => 'select',
      '#title' => $this->t('Select wrapping element'),
      '#default_value' => $config->get('element'),
      '#options' => $elements,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('snippets.settings')
        ->set('element', $form_state['values']['snippets_wrapping_element'])
        ->save();

    parent::submitForm($form, $form_state);
  }
}
