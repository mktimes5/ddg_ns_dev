<?php

namespace Drupal\foo_wrap\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Foowrap type entity.
 *
 * @ConfigEntityType(
 *   id = "foowrap_type",
 *   label = @Translation("Foowrap type"),
 *   handlers = {
 *     "list_builder" = "Drupal\foo_wrap\foowrapTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\foo_wrap\Form\foowrapTypeForm",
 *       "edit" = "Drupal\foo_wrap\Form\foowrapTypeForm",
 *       "delete" = "Drupal\foo_wrap\Form\foowrapTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\foo_wrap\foowrapTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "foowrap_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "foowrap",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/foowrap_type/{foowrap_type}",
 *     "add-form" = "/admin/structure/foowrap_type/add",
 *     "edit-form" = "/admin/structure/foowrap_type/{foowrap_type}/edit",
 *     "delete-form" = "/admin/structure/foowrap_type/{foowrap_type}/delete",
 *     "collection" = "/admin/structure/foowrap_type"
 *   }
 * )
 */
class foowrapType extends ConfigEntityBundleBase implements foowrapTypeInterface {

  /**
   * The Foowrap type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Foowrap type label.
   *
   * @var string
   */
  protected $label;

}
