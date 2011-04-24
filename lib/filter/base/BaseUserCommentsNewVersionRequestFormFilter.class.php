<?php

/**
 * UserCommentsNewVersionRequest filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseUserCommentsNewVersionRequestFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'                => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'new_version_request_id' => new sfWidgetFormPropelChoice(array('model' => 'NewVersionRequest', 'add_empty' => true)),
      'comment'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'user_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'User', 'column' => 'id')),
      'new_version_request_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'NewVersionRequest', 'column' => 'id')),
      'comment'                => new sfValidatorPass(array('required' => false)),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('user_comments_new_version_request_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserCommentsNewVersionRequest';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'user_id'                => 'ForeignKey',
      'new_version_request_id' => 'ForeignKey',
      'comment'                => 'Text',
      'created_at'             => 'Date',
    );
  }
}
