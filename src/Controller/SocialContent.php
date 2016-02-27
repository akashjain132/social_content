<?php

/**
 * @file
 * Contains \Drupal\social_content\Controller\SocialContent.
 */

namespace Drupal\social_content\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

/**
 * Defines a controller for the social_content module.
 */
class SocialContent extends ControllerBase {

  public function overView() {

    $content['node_table'] = array(
      '#type' => 'table',
      '#header' => $this->node_table_header(),
      '#title' => 'Movie List',
      '#rows' => $this->node_table_row(),
      '#empty' => $this->t('No Social Content submodules are enabled. You must enable at least one.'),
    );

    return $content;
  }

  public function node_table_header() {
    return array($this->t('name'), $this->t('instances'), $this->t('settings'));
  }

  public function node_table_row() {
    $instances = \Drupal::moduleHandler()->invokeAll('social_content_class_info');
    $instances = array_keys($instances);

    $rows = array();
    foreach ($instances as $key => $instance) {
      $rows[$key][] = $instance;
      $rows[$key][] = \Drupal::l('Instances', Url::fromRoute('social_content.list_instance', array('instance' => $instance)));
      $rows[$key][] = \Drupal::l('Add template', new Url('social_content.add_instance', array('instance' => $instance)));
    }

    return $rows;
  }

}
