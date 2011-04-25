<?php

/**
 * PackageScreenshots filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePackageScreenshotsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'path_to_screenshot' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'version_from'       => new sfWidgetFormFilterInput(),
      'package_id'         => new sfWidgetFormPropelChoice(array('model' => 'Package', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'path_to_screenshot' => new sfValidatorPass(array('required' => false)),
      'version_from'       => new sfValidatorPass(array('required' => false)),
      'package_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Package', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('package_screenshots_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PackageScreenshots';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'path_to_screenshot' => 'Text',
      'version_from'       => 'Text',
      'package_id'         => 'ForeignKey',
    );
  }
}
