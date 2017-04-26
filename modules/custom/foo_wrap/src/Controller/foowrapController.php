<?php

namespace Drupal\foo_wrap\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\foo_wrap\Entity\foowrapInterface;

/**
 * Class foowrapController.
 *
 *  Returns responses for Foowrap routes.
 *
 * @package Drupal\foo_wrap\Controller
 */
class foowrapController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Foowrap  revision.
   *
   * @param int $foowrap_revision
   *   The Foowrap  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($foowrap_revision) {
    $foowrap = $this->entityManager()->getStorage('foowrap')->loadRevision($foowrap_revision);
    $view_builder = $this->entityManager()->getViewBuilder('foowrap');

    return $view_builder->view($foowrap);
  }

  /**
   * Page title callback for a Foowrap  revision.
   *
   * @param int $foowrap_revision
   *   The Foowrap  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($foowrap_revision) {
    $foowrap = $this->entityManager()->getStorage('foowrap')->loadRevision($foowrap_revision);
    return $this->t('Revision of %title from %date', ['%title' => $foowrap->label(), '%date' => format_date($foowrap->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Foowrap .
   *
   * @param \Drupal\foo_wrap\Entity\foowrapInterface $foowrap
   *   A Foowrap  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(foowrapInterface $foowrap) {
    $account = $this->currentUser();
    $langcode = $foowrap->language()->getId();
    $langname = $foowrap->language()->getName();
    $languages = $foowrap->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $foowrap_storage = $this->entityManager()->getStorage('foowrap');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $foowrap->label()]) : $this->t('Revisions for %title', ['%title' => $foowrap->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all foowrap revisions") || $account->hasPermission('administer foowrap entities')));
    $delete_permission = (($account->hasPermission("delete all foowrap revisions") || $account->hasPermission('administer foowrap entities')));

    $rows = [];

    $vids = $foowrap_storage->revisionIds($foowrap);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\foo_wrap\foowrapInterface $revision */
      $revision = $foowrap_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $foowrap->getRevisionId()) {
          $link = $this->l($date, new Url('entity.foowrap.revision', ['foowrap' => $foowrap->id(), 'foowrap_revision' => $vid]));
        }
        else {
          $link = $foowrap->link($date);
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
              Url::fromRoute('entity.foowrap.translation_revert', ['foowrap' => $foowrap->id(), 'foowrap_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.foowrap.revision_revert', ['foowrap' => $foowrap->id(), 'foowrap_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.foowrap.revision_delete', ['foowrap' => $foowrap->id(), 'foowrap_revision' => $vid]),
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

    $build['foowrap_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
