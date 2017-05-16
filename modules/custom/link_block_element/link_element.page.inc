<?php

/**
 * @file
 * Contains link_element.page.inc.
 *
 * Page callback for Link element entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Link element templates.
 *
 * Default template: link_element.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_link_element(array &$variables) {
  // Fetch linkElement Entity Object.
  $link_element = $variables['elements']['#link_element'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
