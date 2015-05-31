<?php

/**
* @file
* Contains \Drupal\weather\Plugin\Block\WeatherBlock.
*/

namespace Drupal\weather\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Http\Client;

/**
* Provides a 'Weather' block.
*
* @Block(
* id = "weather_block",
* admin_label = @Translation("Weather block"),
* module = "weather"
* )
*/
class WeatherBlock extends BlockBase {

  /**
  * Implements \Drupal\block\BlockBase::build().
  */
  public function build() {
    $city = $this->configuration['weather_city'];
    $result = NULL;

    // FIXME add cast here
    $default_conf = $this->defaultConfiguration();
    $default_city = $default_conf['weather_city'];
    if (isset($city) && $city !== $default_city) {
      $result = array(
        '#markup' => t('Display the weather for city <strong>@city</strong>', array ('@city' => $city)),
      );

      $forecast_service = \Drupal::service('weather.forecast_service');
      $json = $forecast_service->getForecast($city);

      $weather = $json['weather'][0]['main'];
      $temp = $json['main']['temp'];
      $result[] = array(
        '#markup' => 'Temperature: ' . $temp . '&deg;C ; Weather: ' . $weather,
      );
    } else {
      $result = array(
        '#markup' => t('City not yet configured'),
      );
    }
    return $result;
  }

  /**
  * Implements \Drupal\block\BlockBase::access().
  */
  public function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
  * Implements \Drupal\block\BlockBase:: blockForm().
  */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['weather_city'] = array(
                    '#type' => 'textfield',
                    '#title' => t('City'),
                    '#size' => 15,
                    '#description' => t('Weather of the following city will be displayed'),
                    '#default_value' => $this->configuration['weather_city'],
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'weather_city' => t('Default city'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['weather_city'] = $form_state->getValue('weather_city');
  }


}
