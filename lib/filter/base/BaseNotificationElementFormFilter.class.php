<?php

/**
 * NotificationElement filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseNotificationElementFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'notification_id' => new sfWidgetFormPropelChoice(array('model' => 'Notification', 'add_empty' => true)),
      'package_id'      => new sfWidgetFormPropelChoice(array('model' => 'Package', 'add_empty' => true)),
      'rpm_group_id'    => new sfWidgetFormPropelChoice(array('model' => 'RpmGroup', 'add_empty' => true)),
      'distrelease_id'  => new sfWidgetFormPropelChoice(array('model' => 'Distrelease', 'add_empty' => true)),
      'arch_id'         => new sfWidgetFormPropelChoice(array('model' => 'Arch', 'add_empty' => true)),
      'media_id'        => new sfWidgetFormPropelChoice(array('model' => 'Media', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'notification_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Notification', 'column' => 'id')),
      'package_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Package', 'column' => 'id')),
      'rpm_group_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'RpmGroup', 'column' => 'id')),
      'distrelease_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Distrelease', 'column' => 'id')),
      'arch_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Arch', 'column' => 'id')),
      'media_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Media', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('notification_element_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotificationElement';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'notification_id' => 'ForeignKey',
      'package_id'      => 'ForeignKey',
      'rpm_group_id'    => 'ForeignKey',
      'distrelease_id'  => 'ForeignKey',
      'arch_id'         => 'ForeignKey',
      'media_id'        => 'ForeignKey',
    );
  }
}
