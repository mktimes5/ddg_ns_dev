<?php

namespace Drupal\left_subdivision\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Left Sub Divison entities.
 */
class left_subdivisionViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
