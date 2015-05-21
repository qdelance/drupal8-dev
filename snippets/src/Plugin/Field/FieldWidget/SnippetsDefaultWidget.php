<?php

/**
 * @file
 * Contains \Drupal\snippets\Plugin\Field\FieldWidget\SnippetsDefaultWidget.
 */

namespace Drupal\snippets\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'snippets_default' widget.
 *
 * @FieldWidget(
 *   id = "snippets_default",
 *   label = @Translation("Snippets default"),
 *   field_types = {
 *     "snippets_code"
 *   }
 * )
 */
class SnippetsDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    // hljs.listLanguages();
    $options = ["coffeescript", "cpp", "python", "sql", "java", "ruby", "objectivec", "javascript", "nginx", "markdown", "json", "php", "diff", "apache", "http", "css", "cs", "xml", "makefile", "ini", "bash", "perl"];
    // to have "cpp" => "cpp" in the select
    // used to be drupal_map_assoc() https://www.drupal.org/node/2207453
    $options = array_combine($options, $options);
    $element['source_description'] = array(
          '#title' => t('Description'),
          '#type' => 'textfield',
          '#default_value' => isset($items[$delta]->source_description) ? $items[$delta]->source_description : NULL,
        );
    $element['source_code'] = array(
          '#title' => t('Code'),
          '#type' => 'textarea',
          '#default_value' => isset($items[$delta]->source_code) ? $items[$delta]->source_code : NULL,
        );
    $element['source_lang'] = array(
          '#title' => t('Source language'),
          '#type' => 'select',
          '#options' => $options,
          '#default_value' => isset($items[$delta]->source_lang) ? $items[$delta]->source_lang : NULL,
        );
    return $element;
  }
}
