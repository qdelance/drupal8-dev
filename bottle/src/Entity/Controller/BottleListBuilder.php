<?php

/**
 * @file
 * Contains \Drupal\bottle\Entity\Controller\BottleListController.
 */

namespace Drupal\bottle\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Url;

/**
 * Provides a list controller for bottle entity.
 */
class BottleListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build['description'] = array(
      '#markup' => $this->t('Bottle Entity implements a bottle model. These bottles are fieldable entities. You can manage the fields on the <a href="@adminlink">Bottles admin page</a>.', array(
        '@adminlink' => \Drupal::urlGenerator()->generateFromRoute('bottle.settings'),
      )),
    );
    $build['table'] = parent::render();
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Bottle ID');
    $header['label'] = $this->t('Label');
    $header['description'] = $this->t('Description');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\bottle\Entity\Bottle */
    $row['id'] = $entity->id();
    $row['label'] = \Drupal::l($this->getLabel($entity), Url::fromRoute('entity.bottle.canonical', array(
      'bottle' => $entity->id(), // param defined in *.routing.yml, corresponds to the ID
    )));
    $row['description'] = $entity->description->value;
    return $row + parent::buildRow($entity);
  }

}
