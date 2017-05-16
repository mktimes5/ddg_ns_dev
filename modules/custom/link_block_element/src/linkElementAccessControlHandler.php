<?php

namespace Drupal\link_block_element;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Link element entity.
 *
 * @see \Drupal\link_block_element\Entity\linkElement.
 */
class linkElementAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\link_block_element\Entity\linkElementInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished link element entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published link element entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit link element entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete link element entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add link element entities');
  }

}
