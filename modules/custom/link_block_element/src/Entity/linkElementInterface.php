<?php

namespace Drupal\link_block_element\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Link element entities.
 *
 * @ingroup link_block_element
 */
interface linkElementInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Link element name.
   *
   * @return string
   *   Name of the Link element.
   */
  public function getName();

  /**
   * Sets the Link element name.
   *
   * @param string $name
   *   The Link element name.
   *
   * @return \Drupal\link_block_element\Entity\linkElementInterface
   *   The called Link element entity.
   */
  public function setName($name);

  /**
   * Gets the Link element creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Link element.
   */
  public function getCreatedTime();

  /**
   * Sets the Link element creation timestamp.
   *
   * @param int $timestamp
   *   The Link element creation timestamp.
   *
   * @return \Drupal\link_block_element\Entity\linkElementInterface
   *   The called Link element entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Link element published status indicator.
   *
   * Unpublished Link element are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Link element is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Link element.
   *
   * @param bool $published
   *   TRUE to set this Link element to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\link_block_element\Entity\linkElementInterface
   *   The called Link element entity.
   */
  public function setPublished($published);

  /**
   * Gets the Link element revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Link element revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\link_block_element\Entity\linkElementInterface
   *   The called Link element entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Link element revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Link element revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\link_block_element\Entity\linkElementInterface
   *   The called Link element entity.
   */
  public function setRevisionUserId($uid);

}
