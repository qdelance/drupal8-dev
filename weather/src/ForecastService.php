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
    $this->config = $config_factory->get('weather.settings');
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
        ->info('Get forecast for city "%city".',
          array(
            '%city' => $city,
          ));

      // First we are looking for data in cache
      // We are NOT using Cache API to avoid hitting database (default)
      // We are only relying to State API to keep things in memory
      // Dunno if it's a good choice
      // Anyway we have to store - for each city - 1 key for value + 1 key for cache time

      $json = $this->state->get($city . '-value');
      if ($json != NULL) {
        \Drupal::logger('weather')
          ->info('Data found in cache');
        $cache_time = $this->state->get($city . '-life_time');
        $current_time = time();
        if (($current_time - $cache_time) > $this->cache_lifetime) {
          \Drupal::logger('weather')
            ->info('Data is too old, we\'ll have to refresh it');
        } else {
          \Drupal::logger('weather')
            ->info('Data from the cache is OK');
          return $json;
        }
      }

      // Nothing in cache => we have to query the API
      $api_key = $this->config->get('openweathermap_apikey');
      $api_str = '';

      if (!isset($api_key) || $api_key == '') {
        \Drupal::logger('weather')
          ->warning('No API key defined, you should configure one');
      }
      else {
        $api_str = '&APPID=' . $api_key;
      }

      try {
        $request = $this->http_client->createRequest('GET', 'http://api.openweathermap.org/data/2.5/weather?q=' . $city . '&units=metric' . $api_str);
        $response = $this->http_client->send($request);
        $json = $response->json();

        if ($json != NULL) {
          // Store in cache for future requests
          $this->state->set($city . '-value', $json);
          $this->state->set($city . '-life_time', time());
        }
      } catch (\Exception $e) {
        \Drupal::logger('weather')
          ->error('Exception during API call for city "$city": ' . $e->getMessage());
      }
    }
    return $json;
  }
}