<?php

namespace Drupal\foo_wrap;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\foo_wrap\Entity\foowrapInterface;

/**
 * Defines the storage handler class for Foowrap entities.
 *
 * This extends the base storage class, adding required special handling for
 * Foowrap entities.
 *
 * @ingroup foo_wrap
 */
class foowrapStorage extends SqlContentEntityStorage implements foowrapStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(foowrapInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {foowrap_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {foowrap_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(foowrapInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {foowrap_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('foowrap_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
