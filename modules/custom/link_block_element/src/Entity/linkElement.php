<?php

namespace Drupal\link_block_element\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\RevisionableContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Link element entity.
 *
 * @ingroup link_block_element
 *
 * @ContentEntityType(
 *   id = "link_element",
 *   label = @Translation("Link element"),
 *   bundle_label = @Translation("Link element type"),
 *   handlers = {
 *     "storage" = "Drupal\link_block_element\linkElementStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\link_block_element\linkElementListBuilder",
 *     "views_data" = "Drupal\link_block_element\Entity\linkElementViewsData",
 *     "translation" = "Drupal\link_block_element\linkElementTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\link_block_element\Form\linkElementForm",
 *       "add" = "Drupal\link_block_element\Form\linkElementForm",
 *       "edit" = "Drupal\link_block_element\Form\linkElementForm",
 *       "delete" = "Drupal\link_block_element\Form\linkElementDeleteForm",
 *     },
 *     "access" = "Drupal\link_block_element\linkElementAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\link_block_element\linkElementHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "link_element",
 *   data_table = "link_element_field_data",
 *   revision_table = "link_element_revision",
 *   revision_data_table = "link_element_field_revision",
 *   translatable = TRUE,
 *   admin_permission = "administer link element entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/link_element/{link_element}",
 *     "add-page" = "/admin/structure/link_element/add",
 *     "add-form" = "/admin/structure/link_element/add/{link_element_type}",
 *     "edit-form" = "/admin/structure/link_element/{link_element}/edit",
 *     "delete-form" = "/admin/structure/link_element/{link_element}/delete",
 *     "version-history" = "/admin/structure/link_element/{link_element}/revisions",
 *     "revision" = "/admin/structure/link_element/{link_element}/revisions/{link_element_revision}/view",
 *     "revision_revert" = "/admin/structure/link_element/{link_element}/revisions/{link_element_revision}/revert",
 *     "translation_revert" = "/admin/structure/link_element/{link_element}/revisions/{link_element_revision}/revert/{langcode}",
 *     "revision_delete" = "/admin/structure/link_element/{link_element}/revisions/{link_element_revision}/delete",
 *     "collection" = "/admin/structure/link_element",
 *   },
 *   bundle_entity_type = "link_element_type",
 *   field_ui_base_route = "entity.link_element_type.edit_form"
 * )
 */
class linkElement extends RevisionableContentEntityBase implements linkElementInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);

    foreach (array_keys($this->getTranslationLanguages()) as $langcode) {
      $translation = $this->getTranslation($langcode);

      // If no owner has been set explicitly, make the anonymous user the owner.
      if (!$translation->getOwner()) {
        $translation->setOwnerId(0);
      }
    }

    // If no revision author has been set explicitly, make the link_element owner the
    // revision author.
    if (!$this->getRevisionUser()) {
      $this->setRevisionUserId($this->getOwnerId());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Link element entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Link element entity.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Link element is published.'))
      ->setRevisionable(TRUE)
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['revision_translation_affected'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Revision translation affected'))
      ->setDescription(t('Indicates if the last edit of a translation belongs to current revision.'))
      ->setReadOnly(TRUE)
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    return $fields;
  }

}
