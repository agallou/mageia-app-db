<?php

/**
 * PackageLinks form base class.
 *
 * @method PackageLinks getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePackageLinksForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'URL'         => new sfWidgetFormTextarea(),
      'language_id' => new sfWidgetFormPropelChoice(array('model' => 'Language', 'add_empty' => false)),
      'package_id'  => new sfWidgetFormPropelChoice(array('model' => 'Package', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'URL'         => new sfValidatorString(),
      'language_id' => new sfValidatorPropelChoice(array('model' => 'Language', 'column' => 'id')),
      'package_id'  => new sfValidatorPropelChoice(array('model' => 'Package', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('package_links[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PackageLinks';
  }


}
