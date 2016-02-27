<?php

/**
 * @file
 * Hooks provided by the Social content module.
 */

/**
 * Define social content classes.
 *
 * This hook enables modules to register their own social content classes which
 *   instances can be created from.
 *
 * All social content imports belong to an instance and that instance is from a
 *  class which is defined by this hook. You classes should extend the abstract
 *  SocialContent class. Refer to the class for documentation.
 *
 * $return $info
 *   An array of social content classes, in machine_name => class format.
 *    Machine name must be unique and not defined anywhere else. To override
 *    a specific class use hook_social_content_class_info_alter.
 */
function hook_social_content_class_info() {
  return array(
    'twitter' => 'SocialContentTwitter',
  );
}
