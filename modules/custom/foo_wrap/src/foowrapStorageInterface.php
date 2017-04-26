<?php

namespace Drupal\foo_wrap;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface foowrapStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Foowrap revision IDs for a specific Foowrap.
   *
   * @param \Drupal\foo_wrap\Entity\foowrapInterface $entity
   *   The Foowrap entity.
   *
   * @return int[]
   *   Foowrap revision IDs (in ascending order).
   */
  public function revisionIds(foowrapInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Foowrap author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Foowrap revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\foo_wrap\Entity\foowrapInterface $entity
   *   The Foowrap entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(foowrapInterface $entity);

  /**
   * Unsets the language for all Foowrap with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
