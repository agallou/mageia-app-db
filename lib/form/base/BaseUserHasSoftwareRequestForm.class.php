<?php

/**
 * UserHasSoftwareRequest form base class.
 *
 * @method UserHasSoftwareRequest getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseUserHasSoftwareRequestForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'             => new sfWidgetFormInputHidden(),
      'software_request_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'user_id'             => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id', 'required' => false)),
      'software_request_id' => new sfValidatorPropelChoice(array('model' => 'SoftwareRequest', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_has_software_request[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserHasSoftwareRequest';
  }


}
