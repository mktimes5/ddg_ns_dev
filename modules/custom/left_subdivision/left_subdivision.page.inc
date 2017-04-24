<?php

/**
 * @file
 * Contains left_subdivision.page.inc.
 *
 * Page callback for Left Sub Divison entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Left Sub Divison templates.
 *
 * Default template: left_subdivision.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_left_subdivision(array &$variables) {
  // Fetch left_subdivision Entity Object.
  $left_subdivision = $variables['elements']['#left_subdivision'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
