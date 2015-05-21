<?php

namespace Drupal\weather\Controller;

/**
 * Simple controller, more advanced use cases will implement ContainerInjectionInterface
 */
class WeatherController {

  public function content() {
    return array(
      '#markup' => t('Sunny.'),
    );
  }

  public function helpPage() {
    return array(
      '#theme' => 'weather_help_page',
      '#test_msg' => 'This message comes from a variable'
    );
  }
}
