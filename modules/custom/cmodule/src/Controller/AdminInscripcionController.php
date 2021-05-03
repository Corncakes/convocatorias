<?php

namespace Drupal\cmodule\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Render\FormattableMarkup; 

/**
 * Defines AdminInscripcionController class.
 */
class AdminInscripcionController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function adminList() {
    $header = [
      ['data' => 'id'],
      ['data' => 'Usuario'],
      ['data' => 'Convocatoria'],
      ['data' => 'Fecha inscripción'],
      ['data' => 'Operaciones'],
    ];

    $connection = \Drupal::service('database');

    $query = $connection->select('inscripciones', 'i');
    $query->join('users_field_data', 'ufd', 'i.uid = ufd.uid');
    $query->join('node_field_data', 'nfd', 'i.nid = nfd.nid');
    
    $query
      ->condition('nfd.type', 'convocatoria')
      ->fields('i', array('cvid'))
      ->fields('ufd', array('name'))
      ->fields('nfd', array('title'))
      ->fields('i', array('created'));

    $result = $query->execute()->fetchAll();

    $rows = [];
    foreach ($result as $row) {
      // Normally we would add some nice formatting to our rows
      // but for our purpose we are simply going to add our row
      // to the array.
      $row->operation = new FormattableMarkup(
        '<a href=":link">@name</a>',
        [
          ':link' => '/admin-list/'.$row->cvid, 
          '@name' => 'Ver'
        ]
      );
      $datetime = new \DateTime($row->date);
      $row->created = $datetime->format('d-m-Y H:i:s');
  
      $rows[] = ['data' => (array) $row];
    }


    $build = [
      '#markup' => '<h2>' . t('Lista de inscripciones a convocatorias.') . '</h2>',
    ];
    $build['table'] = [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    ];

    return $build;
  }

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function adminDetail($cvid) {
    $header = [
      ['data' => 'Archivo'],
      ['data' => 'Nombre'],
    ];

    $connection = \Drupal::service('database');

    //Convocatoria
    $query = $connection->select('inscripciones', 'i');
    $query->join('users_field_data', 'ufd', 'i.uid = ufd.uid');
    $query->join('node_field_data', 'nfd', 'i.nid = nfd.nid');

    $query
      ->condition('nfd.type', 'convocatoria')
      ->condition('i.cvid', $cvid, '=')
      ->fields('i', array('cvid'))
      ->fields('ufd', array('name'))
      ->fields('nfd', array('title'))
      ->fields('i', array('created'));

    $result = $query->execute()->fetchObject();

    $datetime = new \DateTime($result->date);
    $fecha = $datetime->format('d-m-Y H:i:s');

    //Files
    $query = $connection->select('inscripciones_files', 'if');
    $query->join('file_managed', 'fm', 'if.fid = fm.fid');
    $query
      ->condition('if.cvid', $cvid, '=')
      ->fields('if', array('fid'))
      ->fields('fm', array('uri'));
    
    $filesConvocatoria = $query->execute()->fetchAll();
    $rows = [];
    foreach ($filesConvocatoria as $row) {
      $documento = \Drupal\file\Entity\File::load($row->fid);
      $path = file_create_url($documento->getFileUri());

      $row->fid = new FormattableMarkup(
        '<a href=":link">@name</a>',
        [
          ':link' => $path, 
          '@name' => 'Ver'
        ]
      );

      $rows[] = ['data' => (array) $row];
    }

    $build = [
      '#markup' => 
        '<h2>' . t('Inscrito: ') . $result->name . '</h2>' . 
        '<h3><strong>' . t('Convocatoria: ') . '</strong>' . $result->title . '</h3>' . 
        '<h3><strong>' . t('Fecha: ') . '</strong>' . $fecha . '</h3>',
    ];
    $build['table'] = [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    ];

    return $build;
  }

}