<?php

namespace Drupal\foo_wrap\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Foowrap entities.
 *
 * @ingroup foo_wrap
 */
interface foowrapInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Foowrap name.
   *
   * @return string
   *   Name of the Foowrap.
   */
  public function getName();

  /**
   * Sets the Foowrap name.
   *
   * @param string $name
   *   The Foowrap name.
   *
   * @return \Drupal\foo_wrap\Entity\foowrapInterface
   *   The called Foowrap entity.
   */
  public function setName($name);

  /**
   * Gets the Foowrap creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Foowrap.
   */
  public function getCreatedTime();

  /**
   * Sets the Foowrap creation timestamp.
   *
   * @param int $timestamp
   *   The Foowrap creation timestamp.
   *
   * @return \Drupal\foo_wrap\Entity\foowrapInterface
   *   The called Foowrap entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Foowrap published status indicator.
   *
   * Unpublished Foowrap are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Foowrap is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Foowrap.
   *
   * @param bool $published
   *   TRUE to set this Foowrap to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\foo_wrap\Entity\foowrapInterface
   *   The called Foowrap entity.
   */
  public function setPublished($published);

  /**
   * Gets the Foowrap revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Foowrap revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\foo_wrap\Entity\foowrapInterface
   *   The called Foowrap entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Foowrap revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Foowrap revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\foo_wrap\Entity\foowrapInterface
   *   The called Foowrap entity.
   */
  public function setRevisionUserId($uid);

}
