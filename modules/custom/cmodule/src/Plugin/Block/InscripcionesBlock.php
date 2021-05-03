<?php

namespace Drupal\cmodule\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Inscripciones' Block.
 *
 * @Block(
 *   id = "inscripciones_block",
 *   admin_label = @Translation("Inscripciones block"),
 *   category = @Translation("Inscripciones IPCC"),
 * )
 */
class InscripcionesBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return \Drupal::formBuilder()->getForm('Drupal\cmodule\Form\InscripcionesForm');
  }

}