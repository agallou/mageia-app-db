<?php

/**
 * Package form base class.
 *
 * @method Package getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePackageForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'name'           => new sfWidgetFormInputText(),
      'md5_name'       => new sfWidgetFormInputText(),
      'is_application' => new sfWidgetFormInputCheckbox(),
      'is_source'      => new sfWidgetFormInputCheckbox(),
      'summary'        => new sfWidgetFormInputText(),
      'description'    => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'           => new sfValidatorString(array('max_length' => 900)),
      'md5_name'       => new sfValidatorString(array('max_length' => 32)),
      'is_application' => new sfValidatorBoolean(),
      'is_source'      => new sfValidatorBoolean(),
      'summary'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'    => new sfValidatorString(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Package', 'column' => array('md5_name', 'is_source')))
    );

    $this->widgetSchema->setNameFormat('package[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Package';
  }


}
