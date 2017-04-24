<?php

namespace Drupal\left_subdivision;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Left Sub Division entity.
 *
 * @see \Drupal\left_subdivision\Entity\left_subdivision.
 */
class left_subdivisionAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\left_subdivision\Entity\left_subdivisionInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished left sub Division entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published left sub Division entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit left sub Division entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete left sub Division entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add left sub Division entities');
  }

}
