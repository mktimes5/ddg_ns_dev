<?php

namespace Drupal\left_subdivision\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Left Sub Division entities.
 *
 * @ingroup left_subdivision
 */
interface left_subdivisionInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Left Sub Division name.
   *
   * @return string
   *   Name of the Left Sub Division.
   */
  public function getName();

  /**
   * Sets the Left Sub Division name.
   *
   * @param string $name
   *   The Left Sub Division name.
   *
   * @return \Drupal\left_subdivision\Entity\left_subdivisionInterface
   *   The called Left Sub Division entity.
   */
  public function setName($name);

  /**
   * Gets the Left Sub Division creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Left Sub Division.
   */
  public function getCreatedTime();

  /**
   * Sets the Left Sub Division creation timestamp.
   *
   * @param int $timestamp
   *   The Left Sub Division creation timestamp.
   *
   * @return \Drupal\left_subdivision\Entity\left_subdivisionInterface
   *   The called Left Sub Division entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Left Sub Division published status indicator.
   *
   * Unpublished Left Sub Division are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Left Sub Division is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Left Sub Division.
   *
   * @param bool $published
   *   TRUE to set this Left Sub Division to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\left_subdivision\Entity\left_subdivisionInterface
   *   The called Left Sub Division entity.
   */
  public function setPublished($published);

  /**
   * Gets the Left Sub Division revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Left Sub Division revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\left_subdivision\Entity\left_subdivisionInterface
   *   The called Left Sub Division entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Left Sub Division revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Left Sub Division revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\left_subdivision\Entity\left_subdivisionInterface
   *   The called Left Sub Division entity.
   */
  public function setRevisionUserId($uid);

}
