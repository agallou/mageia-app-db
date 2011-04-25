<?php

/**
 * UserHasNewVersionRequest form base class.
 *
 * @method UserHasNewVersionRequest getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseUserHasNewVersionRequestForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'                => new sfWidgetFormInputHidden(),
      'new_version_request_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'user_id'                => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id', 'required' => false)),
      'new_version_request_id' => new sfValidatorPropelChoice(array('model' => 'NewVersionRequest', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_has_new_version_request[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserHasNewVersionRequest';
  }


}
