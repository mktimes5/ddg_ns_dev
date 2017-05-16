<?php

namespace Drupal\link_block_element;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\link_block_element\Entity\linkElementInterface;

/**
 * Defines the storage handler class for Link element entities.
 *
 * This extends the base storage class, adding required special handling for
 * Link element entities.
 *
 * @ingroup link_block_element
 */
class linkElementStorage extends SqlContentEntityStorage implements linkElementStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(linkElementInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {link_element_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {link_element_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(linkElementInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {link_element_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('link_element_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
