<?php

namespace Drupal\left_subdivision\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\left_subdivision\Entity\left_subdivisionInterface;

/**
 * Class left_subdivisionController.
 *
 *  Returns responses for Left Sub Division routes.
 *
 * @package Drupal\left_subdivision\Controller
 */
class left_subdivisionController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Left Sub Division  revision.
   *
   * @param int $left_subdivision_revision
   *   The Left Sub Division  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($left_subdivision_revision) {
    $left_subdivision = $this->entityManager()->getStorage('left_subdivision')->loadRevision($left_subdivision_revision);
    $view_builder = $this->entityManager()->getViewBuilder('left_subdivision');

    return $view_builder->view($left_subdivision);
  }

  /**
   * Page title callback for a Left Sub Division  revision.
   *
   * @param int $left_subdivision_revision
   *   The Left Sub Division  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($left_subdivision_revision) {
    $left_subdivision = $this->entityManager()->getStorage('left_subdivision')->loadRevision($left_subdivision_revision);
    return $this->t('Revision of %title from %date', ['%title' => $left_subdivision->label(), '%date' => format_date($left_subdivision->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Left Sub Division .
   *
   * @param \Drupal\left_subdivision\Entity\left_subdivisionInterface $left_subdivision
   *   A Left Sub Division  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(left_subdivisionInterface $left_subdivision) {
    $account = $this->currentUser();
    $langcode = $left_subdivision->language()->getId();
    $langname = $left_subdivision->language()->getName();
    $languages = $left_subdivision->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $left_subdivision_storage = $this->entityManager()->getStorage('left_subdivision');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $left_subdivision->label()]) : $this->t('Revisions for %title', ['%title' => $left_subdivision->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all left sub Division revisions") || $account->hasPermission('administer left sub Division entities')));
    $delete_permission = (($account->hasPermission("delete all left sub Division revisions") || $account->hasPermission('administer left sub Division entities')));

    $rows = [];

    $vids = $left_subdivision_storage->revisionIds($left_subdivision);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\left_subdivision\left_subdivisionInterface $revision */
      $revision = $left_subdivision_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $left_subdivision->getRevisionId()) {
          $link = $this->l($date, new Url('entity.left_subdivision.revision', ['left_subdivision' => $left_subdivision->id(), 'left_subdivision_revision' => $vid]));
        }
        else {
          $link = $left_subdivision->link($date);
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
              Url::fromRoute('entity.left_subdivision.translation_revert', ['left_subdivision' => $left_subdivision->id(), 'left_subdivision_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.left_subdivision.revision_revert', ['left_subdivision' => $left_subdivision->id(), 'left_subdivision_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.left_subdivision.revision_delete', ['left_subdivision' => $left_subdivision->id(), 'left_subdivision_revision' => $vid]),
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

    $build['left_subdivision_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
