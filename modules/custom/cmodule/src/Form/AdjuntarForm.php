<?php

namespace Drupal\cmodule\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Implements a form.
 */
class AdjuntarForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'inscripciones_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $nid = \Drupal::request()->query->get('node');
    $node = \Drupal\node\Entity\Node::load($nid);
    
    if (\Drupal::currentUser()->hasPermission('adjuntar permission')) {
      $paraAdjuntar = $node->get('field_archivos_para_adjuntar')->getValue(); 
      
      $form['inscripciones_files']['#tree'] = TRUE;
      
      foreach ($paraAdjuntar as  $value) {
        $labelName = strtolower($value['value']);
        $labelName = str_replace(' ', '-', $labelName);
        $labelName = preg_replace('/[^A-Za-z0-9\-]/', '', $labelName);
        $labelName = preg_replace('/-+/', '-', $labelName);
        
        $form['inscripciones_files'][$labelName] = [
          '#type' => 'managed_file',
          '#title' => $this->t($value['value']),
          '#upload_location' => 'public://docs-convocatoria',
          '#upload_validators' => [
            'file_validate_extensions' => ['pdf'],
          ],
        ];
      }
      $form['actions'] = [
        '#type' => 'submit',
        '#value' => $this->t('Enviar'),
      ];
      return $form;
    } else {
      $response = new RedirectResponse("/user/login?destination=/node/".$nid);
      $response->send();
      return;
    }
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
    $uid = \Drupal::request()->query->get('user');
    $nid = \Drupal::request()->query->get('node');
    $ltid = \Drupal::request()->query->get('line');

    $connection = \Drupal::service('database');

    $inscription = $connection->insert('inscripciones')
      ->fields(['uid', 'nid', 'created', 'ltid'])
      ->values([
        'uid' => $uid,
        'nid' => $nid,
        'created' => time(),
        'ltid' => $ltid,
      ])
      ->execute();

      foreach ($form_state->getValue('inscripciones_files') as $value) {
        $fid = reset($value);
        $file = File::load($fid);
  
        $file->setPermanent();
        $file->save();

        $result = $connection->insert('inscripciones_files')
        ->fields(['cvid', 'fid', 'created'])
        ->values([
          'cvid' => $inscription,
          'fid' => $fid,
          'created' => time(),
        ])
        ->execute();
      }

    $url = \Drupal\Core\Url::fromRoute('cmodule.respuesta_inscripcion');

    $form_state->setRedirectUrl($url);
  }
}