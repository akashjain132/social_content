<?php

/**
 * @file
 * Contains \Drupal\social_content\Controller\SocialContent.
 */

namespace Drupal\social_content\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Defines a controller for the social_content module.
 */
class SocialContentListInstance extends ControllerBase {

  public function overView($instance) {
    return array('#markup' => $instance);
  }

  public function getPageTitle($instance) {
    return $instance;
  }

}
