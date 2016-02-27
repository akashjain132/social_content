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
class SocialContentAddInstance extends ControllerBase {

  public function overView($instance) {

    switch ($instance) {
      case 'Facebook':
        $form = \Drupal::formBuilder()->getForm('Drupal\social_content\Form\SocialContentFacebookInstanceForm');
        break;

      case 'Flickr':
        # code...
        break;

      case 'Instagram':
        # code...
        break;

      case 'Linkedin':
        # code...
        break;

      case 'Picasa':
        # code...
        break;

      case 'SoundCloud':
        # code...
        break;

      case 'Twitter':
        # code...
        break;

      case 'Tumblr':
        # code...
        break;

      case 'VK':
        # code...
        break;

      case 'Youtube':
        # code...
        break;

      default:
        # code...
        break;
    }
    $form = drupal_render($form);

    return array('#markup' => $form);
  }

  public function getPageTitle($instance) {
    return $instance;
  }

}
