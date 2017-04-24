<?php

namespace Drupal\left_subdivision;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\left_subdivision\Entity\left_subdivisionInterface;

/**
 * Defines the storage handler class for Left Sub Division entities.
 *
 * This extends the base storage class, adding required special handling for
 * Left Sub Division entities.
 *
 * @ingroup left_subdivision
 */
class left_subdivisionStorage extends SqlContentEntityStorage implements left_subdivisionStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(left_subdivisionInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {left_subdivision_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {left_subdivision_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(left_subdivisionInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {left_subdivision_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('left_subdivision_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
