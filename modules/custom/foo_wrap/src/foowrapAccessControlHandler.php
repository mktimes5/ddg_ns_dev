<?php

namespace Drupal\foo_wrap;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Foowrap entity.
 *
 * @see \Drupal\foo_wrap\Entity\foowrap.
 */
class foowrapAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\foo_wrap\Entity\foowrapInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished foowrap entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published foowrap entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit foowrap entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete foowrap entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add foowrap entities');
  }

}
