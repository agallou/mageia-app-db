<?php

/**
 * PackageScreenshots form base class.
 *
 * @method PackageScreenshots getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePackageScreenshotsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'path_to_screenshot' => new sfWidgetFormInputText(),
      'version_from'       => new sfWidgetFormInputText(),
      'package_id'         => new sfWidgetFormPropelChoice(array('model' => 'Package', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'path_to_screenshot' => new sfValidatorString(array('max_length' => 1024)),
      'version_from'       => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'package_id'         => new sfValidatorPropelChoice(array('model' => 'Package', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('package_screenshots[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PackageScreenshots';
  }


}
