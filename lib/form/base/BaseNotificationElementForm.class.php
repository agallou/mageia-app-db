<?php

/**
 * NotificationElement form base class.
 *
 * @method NotificationElement getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseNotificationElementForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'notification_id' => new sfWidgetFormPropelChoice(array('model' => 'Notification', 'add_empty' => false)),
      'package_id'      => new sfWidgetFormPropelChoice(array('model' => 'Package', 'add_empty' => true)),
      'rpm_group_id'    => new sfWidgetFormPropelChoice(array('model' => 'RpmGroup', 'add_empty' => true)),
      'distrelease_id'  => new sfWidgetFormPropelChoice(array('model' => 'Distrelease', 'add_empty' => true)),
      'arch_id'         => new sfWidgetFormPropelChoice(array('model' => 'Arch', 'add_empty' => true)),
      'media_id'        => new sfWidgetFormPropelChoice(array('model' => 'Media', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'notification_id' => new sfValidatorPropelChoice(array('model' => 'Notification', 'column' => 'id')),
      'package_id'      => new sfValidatorPropelChoice(array('model' => 'Package', 'column' => 'id', 'required' => false)),
      'rpm_group_id'    => new sfValidatorPropelChoice(array('model' => 'RpmGroup', 'column' => 'id', 'required' => false)),
      'distrelease_id'  => new sfValidatorPropelChoice(array('model' => 'Distrelease', 'column' => 'id', 'required' => false)),
      'arch_id'         => new sfValidatorPropelChoice(array('model' => 'Arch', 'column' => 'id', 'required' => false)),
      'media_id'        => new sfValidatorPropelChoice(array('model' => 'Media', 'column' => 'id', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'NotificationElement', 'column' => array('notification_id', 'package_id', 'rpm_group_id', 'distrelease_id', 'arch_id', 'media_id')))
    );

    $this->widgetSchema->setNameFormat('notification_element[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotificationElement';
  }


}
