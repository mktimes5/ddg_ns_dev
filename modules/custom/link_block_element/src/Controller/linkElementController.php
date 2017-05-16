<?php

namespace Drupal\link_block_element\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\link_block_element\Entity\linkElementInterface;

/**
 * Class linkElementController.
 *
 *  Returns responses for Link element routes.
 *
 * @package Drupal\link_block_element\Controller
 */
class linkElementController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Link element  revision.
   *
   * @param int $link_element_revision
   *   The Link element  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($link_element_revision) {
    $link_element = $this->entityManager()->getStorage('link_element')->loadRevision($link_element_revision);
    $view_builder = $this->entityManager()->getViewBuilder('link_element');

    return $view_builder->view($link_element);
  }

  /**
   * Page title callback for a Link element  revision.
   *
   * @param int $link_element_revision
   *   The Link element  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($link_element_revision) {
    $link_element = $this->entityManager()->getStorage('link_element')->loadRevision($link_element_revision);
    return $this->t('Revision of %title from %date', ['%title' => $link_element->label(), '%date' => format_date($link_element->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Link element .
   *
   * @param \Drupal\link_block_element\Entity\linkElementInterface $link_element
   *   A Link element  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(linkElementInterface $link_element) {
    $account = $this->currentUser();
    $langcode = $link_element->language()->getId();
    $langname = $link_element->language()->getName();
    $languages = $link_element->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $link_element_storage = $this->entityManager()->getStorage('link_element');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $link_element->label()]) : $this->t('Revisions for %title', ['%title' => $link_element->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all link element revisions") || $account->hasPermission('administer link element entities')));
    $delete_permission = (($account->hasPermission("delete all link element revisions") || $account->hasPermission('administer link element entities')));

    $rows = [];

    $vids = $link_element_storage->revisionIds($link_element);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\link_block_element\linkElementInterface $revision */
      $revision = $link_element_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $link_element->getRevisionId()) {
          $link = $this->l($date, new Url('entity.link_element.revision', ['link_element' => $link_element->id(), 'link_element_revision' => $vid]));
        }
        else {
          $link = $link_element->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.link_element.translation_revert', ['link_element' => $link_element->id(), 'link_element_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.link_element.revision_revert', ['link_element' => $link_element->id(), 'link_element_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.link_element.revision_delete', ['link_element' => $link_element->id(), 'link_element_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['link_element_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
