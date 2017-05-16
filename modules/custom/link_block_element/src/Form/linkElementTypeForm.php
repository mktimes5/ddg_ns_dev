<?php

namespace Drupal\link_block_element\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class linkElementTypeForm.
 *
 * @package Drupal\link_block_element\Form
 */
class linkElementTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $link_element_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $link_element_type->label(),
      '#description' => $this->t("Label for the Link element type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $link_element_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\link_block_element\Entity\linkElementType::load',
      ],
      '#disabled' => !$link_element_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $link_element_type = $this->entity;
    $status = $link_element_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Link element type.', [
          '%label' => $link_element_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Link element type.', [
          '%label' => $link_element_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($link_element_type->toUrl('collection'));
  }

}
