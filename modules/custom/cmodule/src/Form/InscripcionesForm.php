<?php

namespace Drupal\cmodule\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements a form.
 */
class InscripcionesForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'adjuntar_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['actions'] = [
      '#type' => 'submit',
      '#value' => $this->t('Participar'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Validate submitted form data.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $node = \Drupal::routeMatch()->getParameter('node');
    $user = \Drupal::currentUser()->id();

    $termId = $node->get('field_linea_estrategica')->target_id;
    
    $params = [
      'node' => $node->Id(),
      'user' => $user,
      'line' => $termId,
    ];

    //drupal_set_message($this->t('@candidate_name! Wow! Nice choice! Thanks for telling us!', array('@candidate_name' => 'Wilbert')));

    $url = \Drupal\Core\Url::fromRoute('cmodule.adjuntar')->setRouteParameters($params);

    $form_state->setRedirectUrl($url);
    
  }

}