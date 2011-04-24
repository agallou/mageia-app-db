<?php

/**
 * Notification form base class.
 *
 * @method Notification getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseNotificationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'user_id'               => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => false)),
      'update'                => new sfWidgetFormInputCheckbox(),
      'new_version'           => new sfWidgetFormInputCheckbox(),
      'update_candidate'      => new sfWidgetFormInputCheckbox(),
      'new_version_candidate' => new sfWidgetFormInputCheckbox(),
      'comments'              => new sfWidgetFormInputCheckbox(),
      'mail_notification'     => new sfWidgetFormInputCheckbox(),
      'mail_prefix'           => new sfWidgetFormInputText(),
      'rss_feed_id'           => new sfWidgetFormPropelChoice(array('model' => 'RssFeed', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'               => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id')),
      'update'                => new sfValidatorBoolean(),
      'new_version'           => new sfValidatorBoolean(),
      'update_candidate'      => new sfValidatorBoolean(),
      'new_version_candidate' => new sfValidatorBoolean(),
      'comments'              => new sfValidatorBoolean(),
      'mail_notification'     => new sfValidatorBoolean(),
      'mail_prefix'           => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'rss_feed_id'           => new sfValidatorPropelChoice(array('model' => 'RssFeed', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('notification[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Notification';
  }


}
