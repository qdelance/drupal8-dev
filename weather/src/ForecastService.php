<?php

namespace Drupal\weather;

use Drupal\Core\Http\Client;
use Drupal\Core\State\StateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Service in charge of requesting weather forecast to the external API
 * Stores results (State API) and returns data to external callers like weather blocks
 */
class ForecastService {
  /**
   * The HTTP client.
   *
   * @var \Drupal\Core\Http\Client
   */
  protected $http_client;
  /**
   * The state API store.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;
  /**
   * Cache lifetime in ms
   *
   * @var string
   */
  protected $cache_lifetime;
  /**
   * Constructs a new Weather object.
   *
   * @param \Drupal\Core\Http\Client $http_client
   *   The HTTP client.
   * @param \Drupal\Core\State\StateInterface $state
   *   The State API store.
   * @param string $cache_lifetime
   *   Cache lifetime in ms
   */
  public function __construct(Client $http_client, StateInterface $state, ConfigFactoryInterface $config_factory, $cache_lifetime) {
    $this->http_client = $http_client;
    $this->state = $state;
    $this->config = $config_factory->get('weather');
    $this->cache_lifetime = $cache_lifetime;
  }

  /**
   * Returns JSON struct as defined per Open Weather Map API
   */
  public function getForecast($city) {

    $json = NULL;
    if (isset($city) && $city != '') {
      // @todo Logger should be injected ?
      \Drupal::logger('weather')
        ->info('Querying Open Weather Map API for city %city.',
          array(
            '%city' => $city,
          ));

      $api_key = $this->config->get('openweathermap_apikey');
      $api_str = '';

      if (!isset($city) || $city == '') {
        \Drupal::logger('weather')
          ->warning('No API key defined, you should configure one');
      }
      else {
        $api_str = '&APPID=' . $api_key;
      }

      $request = $this->http_client->createRequest('GET', 'http://api.openweathermap.org/data/2.5/weather?q=' . $city . '&units=metric' . $api_str);
      $response = $this->http_client->send($request);
      $json = $response->json();

    }
    return $json;
  }
}