<?php

namespace Drupal\left_subdivision\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\RevisionableContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Left Sub Division entity.
 *
 * @ingroup left_subdivision
 *
 * @ContentEntityType(
 *   id = "left_subdivision",
 *   label = @Translation("Left Sub Division"),
 *   handlers = {
 *     "storage" = "Drupal\left_subdivision\left_subdivisionStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\left_subdivision\left_subdivisionListBuilder",
 *     "views_data" = "Drupal\left_subdivision\Entity\left_subdivisionViewsData",
 *     "translation" = "Drupal\left_subdivision\left_subdivisionTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\left_subdivision\Form\left_subdivisionForm",
 *       "add" = "Drupal\left_subdivision\Form\left_subdivisionForm",
 *       "edit" = "Drupal\left_subdivision\Form\left_subdivisionForm",
 *       "delete" = "Drupal\left_subdivision\Form\left_subdivisionDeleteForm",
 *     },
 *     "access" = "Drupal\left_subdivision\left_subdivisionAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\left_subdivision\left_subdivisionHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "left_subdivision",
 *   data_table = "left_subdivision_field_data",
 *   revision_table = "left_subdivision_revision",
 *   revision_data_table = "left_subdivision_field_revision",
 *   translatable = TRUE,
 *   admin_permission = "administer left sub Division entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/left_subdivision/{left_subdivision}",
 *     "add-form" = "/admin/structure/left_subdivision/add",
 *     "edit-form" = "/admin/structure/left_subdivision/{left_subdivision}/edit",
 *     "delete-form" = "/admin/structure/left_subdivision/{left_subdivision}/delete",
 *     "version-history" = "/admin/structure/left_subdivision/{left_subdivision}/revisions",
 *     "revision" = "/admin/structure/left_subdivision/{left_subdivision}/revisions/{left_subdivision_revision}/view",
 *     "revision_revert" = "/admin/structure/left_subdivision/{left_subdivision}/revisions/{left_subdivision_revision}/revert",
 *     "translation_revert" = "/admin/structure/left_subdivision/{left_subdivision}/revisions/{left_subdivision_revision}/revert/{langcode}",
 *     "revision_delete" = "/admin/structure/left_subdivision/{left_subdivision}/revisions/{left_subdivision_revision}/delete",
 *     "collection" = "/admin/structure/left_subdivision",
 *   },
 *   field_ui_base_route = "left_subdivision.settings"
 * )
 */
class left_subdivision extends RevisionableContentEntityBase implements left_subdivisionInterface {

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

    // If no revision author has been set explicitly, make the left_subdivision owner the
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
      ->setDescription(t('The user ID of author of the Left Sub Division entity.'))
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
      ->setDescription(t('The name of the Left Sub Division entity.'))
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
      ->setDescription(t('A boolean indicating whether the Left Sub Division is published.'))
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
