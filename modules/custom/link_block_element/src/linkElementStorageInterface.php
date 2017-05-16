<?php

namespace Drupal\link_block_element;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface linkElementStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Link element revision IDs for a specific Link element.
   *
   * @param \Drupal\link_block_element\Entity\linkElementInterface $entity
   *   The Link element entity.
   *
   * @return int[]
   *   Link element revision IDs (in ascending order).
   */
  public function revisionIds(linkElementInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Link element author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Link element revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\link_block_element\Entity\linkElementInterface $entity
   *   The Link element entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(linkElementInterface $entity);

  /**
   * Unsets the language for all Link element with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
