<?php

/**
 * PackageDescription filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePackageDescriptionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'version_from' => new sfWidgetFormFilterInput(),
      'package_id'   => new sfWidgetFormPropelChoice(array('model' => 'Package', 'add_empty' => true)),
      'language_id'  => new sfWidgetFormPropelChoice(array('model' => 'Language', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'version_from' => new sfValidatorPass(array('required' => false)),
      'package_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Package', 'column' => 'id')),
      'language_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Language', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('package_description_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PackageDescription';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'version_from' => 'Text',
      'package_id'   => 'ForeignKey',
      'language_id'  => 'ForeignKey',
    );
  }
}
