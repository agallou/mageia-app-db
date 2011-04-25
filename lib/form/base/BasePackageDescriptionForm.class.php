<?php

/**
 * PackageDescription form base class.
 *
 * @method PackageDescription getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePackageDescriptionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'version_from' => new sfWidgetFormInputText(),
      'package_id'   => new sfWidgetFormPropelChoice(array('model' => 'Package', 'add_empty' => false)),
      'language_id'  => new sfWidgetFormPropelChoice(array('model' => 'Language', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'version_from' => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'package_id'   => new sfValidatorPropelChoice(array('model' => 'Package', 'column' => 'id')),
      'language_id'  => new sfValidatorPropelChoice(array('model' => 'Language', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('package_description[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PackageDescription';
  }


}
