<?php

namespace Drupal\left_subdivision;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Left Sub Division entities.
 *
 * @ingroup left_subdivision
 */
class left_subdivisionListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Left Sub Division ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\left_subdivision\Entity\left_subdivision */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.left_subdivision.edit_form', [
          'left_subdivision' => $entity->id(),
        ]
      )
    );
    return $row + parent::buildRow($entity);
  }

}
