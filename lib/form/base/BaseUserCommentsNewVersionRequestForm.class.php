<?php

/**
 * UserCommentsNewVersionRequest form base class.
 *
 * @method UserCommentsNewVersionRequest getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseUserCommentsNewVersionRequestForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'user_id'                => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => false)),
      'new_version_request_id' => new sfWidgetFormPropelChoice(array('model' => 'NewVersionRequest', 'add_empty' => false)),
      'comment'                => new sfWidgetFormTextarea(),
      'created_at'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'                => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id')),
      'new_version_request_id' => new sfValidatorPropelChoice(array('model' => 'NewVersionRequest', 'column' => 'id')),
      'comment'                => new sfValidatorString(),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_comments_new_version_request[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserCommentsNewVersionRequest';
  }


}
