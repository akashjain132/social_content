<?php

/**
 * @file
 * Contains \Drupal\pcp\Form\PCPForm.
 */

namespace Drupal\social_content\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\field\FieldConfigInterface;
use \Drupal\node\Entity\NodeType;
use Drupal\user\Entity\User;
use Drupal\Core\Url;

/**
 * Provides a PCP configuration form.
 */
class SocialContentFacebookInstanceForm extends ConfigFormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'social_content_facebook_instance_form';
  }

  /**
  * {@inheritdoc}
  */
  protected function getEditableConfigNames() {
    return ['social_content_facebook.settings'];
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $currentUser = \Drupal::currentUser();

    $config = \Drupal::config('social_content_facebook.settings');

    $form['template'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Facebook'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    );

    $form['template']['instance_template'] = array(
      '#type' => 'details',
      '#title' => $this->t('Instance template'),
      '#description' => $this->t('Template to base new instances on.'),
      '#open' => TRUE,
    );

    $element['title'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#description' => $this->t('Friendly name, only seen by administrators.'),
      '#default_value' => isset($settings['title']) ? $settings['title'] : NULL,
      '#required' => TRUE,
    );

    $types = NodeType::loadMultiple();
    foreach ($types as $type) {
      $content_type_list[$type->id()] = $type->label();
    }

    $element['content_type'] = array(
      '#type' => 'select',
      '#title' => $this->t('Content type'),
      '#options' => $content_type_list,
      '#required' => TRUE,
    );

    $element['author'] = array(
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Authored by'),
      '#maxlength' => 60,
      '#target_type' => 'user',
      '#default_value' => $currentUser->isAnonymous() ? NULL : User::load($currentUser->id()),
      '#description' => $this->t('Leave blank for %anonymous.', ['%anonymous' => $config->get('anonymous')]),
    );

    $element['limit'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Import limit'),
      '#size' => 10,
      '#description' => $this->t('Set the maximum number of posts to import each time. Leave blank for no limit. Some type of instances may not support this.'),
      '#required' => FALSE,
    );

    $element['auto_publish'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Auto publish'),
      '#required' => FALSE,
    );

    $element['enabled'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Enabled on cron'),
      '#required' => FALSE,
    );

    $element['auto_delete'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Auto delete'),
      '#size' => 10,
      '#description' => $this->t('Automatically delete imported content posted after X days. Leave blank to keep it forever.'),
      '#required' => FALSE,
      '#field_suffix' => 'days',
    );

    $element['account'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Facebook Page User ID'),
      '#description' => $this->t('You can use !link to get this. Or leave empty and it will be generated using the Page Name.', array(
        '!link' => \Drupal::l('findmyfacebookid.com', Url::fromUri('http://findmyfacebookid.com/')),
      )),
    );

    $element['page_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Facebook Page Name'),
      '#description' => $this->t("E.g. 'cocacola' for http://facebook.com/cocacola page."),
      '#required' => TRUE,
    );

    $element['min_resolution'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Minimum image resolution'),
      '#description' => $this->t('Only posts that have images that meet the minimum image resolution (in {width}x{height} format) will be imported.'),
      '#required' => FALSE,
    );

    $form['template']['description'] = array(
      '#markup' => $this->t('See !link', array(
        '!link' => \Drupal::l('developers.facebook.com', Url::fromUri('https://developers.facebook.com/apps')),
      )),
    );

    $form['template']['graph_url'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Facebook Graph URL'),
      '#description' => $this->t('Do not include a trailing slash. If not sure, use %url', array(
        '%url' => 'https://graph.facebook.com',
      )),
      '#required' => TRUE,
    );

    $form['template']['access_token'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Access Token'),
      '#description' => $this->t('This is required to interact with Facebook. Use %url to generate one.', array(
        '%url' => 'https://graph.facebook.com/oauth/access_token?client_id=APP_ID&client_secret=APP_SECRET&&grant_type=client_credentials',
      )),
      '#maxlength' => 300,
      '#required' => TRUE,
    );

    $form['template']['instance_template'] += $element;

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::configFactory()->getEditable('social_content_facebook.settings');

    parent::submitForm($form, $form_state);
  }

}
