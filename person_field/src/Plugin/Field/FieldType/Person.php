<?php
/**
 * @file
 * Contains \Drupal\person_field\Plugin\Field\FieldType\Person.
 */

namespace Drupal\person_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'person' field type.
 *
 * @FieldType(
 *   id = "person",
 *   label = @Translation("Person"),
 *   description = @Translation("Basic details about a person"),
 *   default_widget = "person_default_widget",
 *   default_formatter = "person_default_formatter"
 * )
 */
class Person extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'forename' => array(
          'type' => 'varchar',
          'length' => 256,
          'not null' => TRUE,
        ),
        'surname' => array(
          'type' => 'varchar',
          'length' => 256,
          'not null' => TRUE,
        ),
        'age' => array(
          'type' => 'int',
          'not null' => TRUE,
        ),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('forename')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['forename'] = DataDefinition::create('string')
      ->setLabel(t('Forname'))
      ->setRequired(TRUE);;
    $properties['surname'] = DataDefinition::create('string')
      ->setLabel(t('Surname'))
      ->setRequired(TRUE);;
    $properties['age'] = DataDefinition::create('integer')
      ->setLabel(t('Age'))
      ->addConstraint('Range', ['min' => 0, 'max' => 112]);

    return $properties;
  }

  // FIXME add getConstraints()
}
