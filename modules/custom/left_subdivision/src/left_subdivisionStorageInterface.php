<?php

namespace Drupal\left_subdivision;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface left_subdivisionStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Left Sub Division revision IDs for a specific Left Sub Division.
   *
   * @param \Drupal\left_subdivision\Entity\left_subdivisionInterface $entity
   *   The Left Sub Division entity.
   *
   * @return int[]
   *   Left Sub Division revision IDs (in ascending order).
   */
  public function revisionIds(left_subdivisionInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Left Sub Division author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Left Sub Division revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\left_subdivision\Entity\left_subdivisionInterface $entity
   *   The Left Sub Division entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(left_subdivisionInterface $entity);

  /**
   * Unsets the language for all Left Sub Division with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
