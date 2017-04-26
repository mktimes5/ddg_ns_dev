<?php

/**
 * @file
 * Contains foowrap.page.inc.
 *
 * Page callback for Foowrap entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Foowrap templates.
 *
 * Default template: foowrap.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_foowrap(array &$variables) {
  // Fetch foowrap Entity Object.
  $foowrap = $variables['elements']['#foowrap'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
