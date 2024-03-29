<?php

namespace Drupal\openy_session_instance\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Session Instance edit forms.
 *
 * @ingroup openy_session_instance
 */
class SessionInstanceForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\openy_session_instance\Entity\SessionInstance $entity */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $messenger = \Drupal::messenger();
    $entity = &$this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        $messenger->addMessage($this->t('Created the %label Session Instance.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        $messenger->addMessage($this->t('Saved the %label Session Instance.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.session_instance.canonical', ['session_instance' => $entity->id()]);
  }

}
