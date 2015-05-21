<?php

/**
 * @file
 * Contains \Drupal\snippets\Plugin\Field\FieldType\SnippetsItem.
 */

namespace Drupal\snippets\Plugin\Field\FieldType;

use Drupal\Core\Field\ConfigFieldItemBase;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\field\FieldInterface;

/**
 * Plugin implementation of the 'snippets' field type.
 *
 * @FieldType(
 *   id = "snippets_code",
 *   label = @Translation("Snippets field"),
 *   description = @Translation("This field stores code snippets in the database."),
 *   default_widget = "snippets_default",
 *   default_formatter = "snippets_default"
 * )
 */
class SnippetsItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  static $propertyDefinitions;

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'source_description' => array(
          'type' => 'varchar',
          'length' => 256,
          'not null' => FALSE,
        ),
        'source_code' => array(
          'type' => 'text',
          'size' => 'big',
          'not null' => FALSE,
        ),
        'source_lang' => array(
          'type' => 'varchar',
          'length' => 256,
          'not null' => FALSE,
        ),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {

    $properties['source_description'] = DataDefinition::create('string')
      ->setLabel(t('Snippet description'));
    $properties['source_code'] = DataDefinition::create('string')
      ->setLabel(t('Snippet code'));
    $properties['source_lang'] = DataDefinition::create('string')
      ->setLabel(t('Snippet code language'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('source_code')->getValue();
    return $value === NULL || $value === '';
  }
}
