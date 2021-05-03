<?php

namespace Drupal\cmodule\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Defines RespuestaInscripcionController class.
 */
class RespuestaInscripcionController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function content() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('<h1 class="destacado">Gracias por participar!</h1>'),
    ];
  }

}