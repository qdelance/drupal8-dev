<?php

/**
 * @file
 * Contains \Drupal\snippets\Plugin\field\formatter\SnippetsDefaultFormatter.
 */

namespace Drupal\snippets\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\SafeMarkup;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'snippets_default' formatter.
 *
 * @FieldFormatter(
 *   id = "snippets_default",
 *   label = @Translation("Snippets default"),
 *   field_types = {
 *     "snippets_code"
 *   }
 * )
 */
class SnippetsDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = array();
    foreach ($items as $delta => $item) {
      $elements[$delta] = array(
        '#theme' => 'snippets_default',
        '#source_description' => SafeMarkup::checkPlain($item->source_description),
        '#source_code' => SafeMarkup::checkPlain($item->source_code),
        '#source_lang' => SafeMarkup::checkPlain($item->source_lang),
        '#attached' => array(
          'library' =>  array(
            'snippets/highlightjs', 'snippets/snippets'
          ),
        ),
      );
    }

    return $elements;
  }
}
