<?php

/**
 * @file
 * Contains \Drupal\bottle\BottleAccessControlHandler
 */

namespace Drupal\bottle;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Access controller for the Bottle entity.
 *
 * @see \Drupal\bottle\Entity\Bottle
 */
class BottleAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   *
   * Link the activities to the permissions. checkAccess is called with the
   * $operation as defined in the routing.yml file.
   */
  protected function checkAccess(EntityInterface $entity, $operation, $langcode, AccountInterface $account) {
    switch ($operation) {
      case 'view':
        return $account->hasPermission('view bottle entity');

      case 'edit':
        return $account->hasPermission('edit bottle entity');

      case 'delete':
        return $account->hasPermission('delete bottle entity');
    }
    return TRUE;
  }

  /**
   * {@inheritdoc}
   *
   * Separate from the checkAccess because the entity does not yet exist, it
   * will be created during the 'add' process.
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return $account->hasPermission('add bottle entity');
  }

}
