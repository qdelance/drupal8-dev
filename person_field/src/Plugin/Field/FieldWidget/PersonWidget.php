<?php

/**
 * @file
 * Contains \Drupal\person_field\Plugin\Field\FieldWidget\PersonWidget.
 */

namespace Drupal\person_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'person_default_widget' widget.
 *
 * @FieldWidget(
 *   id = "person_default_widget",
 *   label = @Translation("Person default"),
 *   field_types = {
 *     "person"
 *   }
 * )
 */
class PersonWidget extends WidgetBase {

  // FIXME settingsForm() and settingsSumary()

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $element['forename'] = array(
      '#title' => t('Forename'),
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]->forename) ? $items[$delta]->forename : NULL,
    );
    $element['surname'] = array(
      '#title' => t('Surname'),
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]->surname) ? $items[$delta]->surname : NULL,
    );
    $element['age'] = array(
      '#title' => t('Age'),
      '#type' => 'number',
      '#default_value' => isset($items[$delta]->age) ? $items[$delta]->age : NULL,
    );
    return $element;
  }
}

