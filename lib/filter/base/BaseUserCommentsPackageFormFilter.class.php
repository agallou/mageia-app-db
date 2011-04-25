<?php

/**
 * UserCommentsPackage filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseUserCommentsPackageFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'package_id' => new sfWidgetFormPropelChoice(array('model' => 'Package', 'add_empty' => true)),
      'user_id'    => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'comment'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'package_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Package', 'column' => 'id')),
      'user_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'User', 'column' => 'id')),
      'comment'    => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('user_comments_package_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserCommentsPackage';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'package_id' => 'ForeignKey',
      'user_id'    => 'ForeignKey',
      'comment'    => 'Text',
      'created_at' => 'Date',
    );
  }
}
