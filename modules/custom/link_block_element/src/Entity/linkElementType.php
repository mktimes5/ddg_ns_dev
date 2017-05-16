<?php

namespace Drupal\link_block_element\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Link element type entity.
 *
 * @ConfigEntityType(
 *   id = "link_element_type",
 *   label = @Translation("Link element type"),
 *   handlers = {
 *     "list_builder" = "Drupal\link_block_element\linkElementTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\link_block_element\Form\linkElementTypeForm",
 *       "edit" = "Drupal\link_block_element\Form\linkElementTypeForm",
 *       "delete" = "Drupal\link_block_element\Form\linkElementTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\link_block_element\linkElementTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "link_element_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "link_element",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/link_element_type/{link_element_type}",
 *     "add-form" = "/admin/structure/link_element_type/add",
 *     "edit-form" = "/admin/structure/link_element_type/{link_element_type}/edit",
 *     "delete-form" = "/admin/structure/link_element_type/{link_element_type}/delete",
 *     "collection" = "/admin/structure/link_element_type"
 *   }
 * )
 */
class linkElementType extends ConfigEntityBundleBase implements linkElementTypeInterface {

  /**
   * The Link element type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Link element type label.
   *
   * @var string
   */
  protected $label;

}
