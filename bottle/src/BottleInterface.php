<?php
/**
 * @file
 * Contains \Drupal\bottle\BottleInterface.
 */

namespace Drupal\bottle;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a Bottle entity.
 */
interface BottleInterface extends ContentEntityInterface, EntityOwnerInterface {

}
