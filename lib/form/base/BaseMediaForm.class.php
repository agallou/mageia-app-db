<?php

/**
 * Media form base class.
 *
 * @method Media getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMediaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'name'           => new sfWidgetFormInputText(),
      'vendor'         => new sfWidgetFormInputText(),
      'is_updates'     => new sfWidgetFormInputCheckbox(),
      'is_backports'   => new sfWidgetFormInputCheckbox(),
      'is_testing'     => new sfWidgetFormInputCheckbox(),
      'is_third_party' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'           => new sfValidatorString(array('max_length' => 45)),
      'vendor'         => new sfValidatorString(array('max_length' => 255)),
      'is_updates'     => new sfValidatorBoolean(),
      'is_backports'   => new sfValidatorBoolean(),
      'is_testing'     => new sfValidatorBoolean(),
      'is_third_party' => new sfValidatorBoolean(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Media', 'column' => array('name', 'vendor')))
    );

    $this->widgetSchema->setNameFormat('media[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Media';
  }


}
