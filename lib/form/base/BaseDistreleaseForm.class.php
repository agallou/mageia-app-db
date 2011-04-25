<?php

/**
 * Distrelease form base class.
 *
 * @method Distrelease getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseDistreleaseForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'name'           => new sfWidgetFormInputText(),
      'is_meta'        => new sfWidgetFormInputCheckbox(),
      'is_latest'      => new sfWidgetFormInputCheckbox(),
      'is_dev_version' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'           => new sfValidatorString(array('max_length' => 45)),
      'is_meta'        => new sfValidatorBoolean(),
      'is_latest'      => new sfValidatorBoolean(),
      'is_dev_version' => new sfValidatorBoolean(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Distrelease', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('distrelease[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Distrelease';
  }


}
