<?php

/**
 * Notification filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseNotificationFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'               => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'update'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'new_version'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'update_candidate'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'new_version_candidate' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'comments'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'mail_notification'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'mail_prefix'           => new sfWidgetFormFilterInput(),
      'rss_feed_id'           => new sfWidgetFormPropelChoice(array('model' => 'RssFeed', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'user_id'               => new sfValidatorPropelChoice(array('required' => false, 'model' => 'User', 'column' => 'id')),
      'update'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'new_version'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'update_candidate'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'new_version_candidate' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'comments'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'mail_notification'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'mail_prefix'           => new sfValidatorPass(array('required' => false)),
      'rss_feed_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'RssFeed', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('notification_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Notification';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'user_id'               => 'ForeignKey',
      'update'                => 'Boolean',
      'new_version'           => 'Boolean',
      'update_candidate'      => 'Boolean',
      'new_version_candidate' => 'Boolean',
      'comments'              => 'Boolean',
      'mail_notification'     => 'Boolean',
      'mail_prefix'           => 'Text',
      'rss_feed_id'           => 'ForeignKey',
    );
  }
}
