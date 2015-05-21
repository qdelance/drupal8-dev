<?php

namespace Drupal\weather\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class WeatherSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'weather_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['weather.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('weather.settings');

    $units = array('celcius' => t('Celcius (°C)'), 'farenheit' => t('Farenheit (°F)'));

    $form['unit'] = array(
      '#type' => 'select',
      '#title' => $this->t('Select temperature unit'),
      '#default_value' => $config->get('unit'),
      '#options' => $units,
    );
    $form['openweathermap_apikey'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('OpenWeatherMap API Key'),
      '#default_value' => $config->get('openweathermap_apikey'),
      '#size' => 30,
      '#required' => TRUE,
      '#description' => t('API key provided by OpenWeatherMap website needed for API calls'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('weather.settings')
        ->set('unit', $form_state->getValue('weather_unit'))
        ->set('openweathermap_apikey', $form_state->getValue('openweathermap_apikey'))
        ->save();

    parent::submitForm($form, $form_state);
  }

}
