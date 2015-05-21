<?php

/**
 * @file
 * Contains \Drupal\person_field\Plugin\Field\FieldFormatter\PersonFormatter.
 */

namespace Drupal\person_field\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\SafeMarkup;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'person_default_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "person_default_formatter",
 *   label = @Translation("Person default"),
 *   field_types = {
 *     "person"
 *   }
 * )
 */
class PersonFormatter extends FormatterBase {

  // FIXME settingsForm() and settingsSummary()

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = array();

    foreach ($items as $delta => $item) {
      // Render output using person_default theme.
      $elements[$delta] = array(
        '#theme' => 'person_default',
        '#forename' => SafeMarkup::checkPlain($item->forename),
        '#surname' => SafeMarkup::checkPlain($item->surname),
        '#age' => SafeMarkup::checkPlain($item->age),
      );
    }
    return $elements;
  }
}
