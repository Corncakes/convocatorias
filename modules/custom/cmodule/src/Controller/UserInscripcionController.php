<?php

namespace Drupal\cmodule\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Render\FormattableMarkup;

/**
 * Defines RespuestaInscripcionController class.
 */
class UserInscripcionController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function content($user) {
    $header = [
        ['data' => 'id'],
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
        ->condition('i.uid', $user, '=')
        ->fields('i', array('cvid'))
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
        '#markup' => '<br><br><h2>' . t('Lista de inscripciones a convocatorias.') . '</h2>',
      ];
      $build['table'] = [
        '#theme' => 'table',
        '#header' => $header,
        '#rows' => $rows,
      ];
  
      return $build;
  }

}