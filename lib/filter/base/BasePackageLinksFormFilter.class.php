<?php

/**
 * PackageLinks filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePackageLinksFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'URL'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'language_id' => new sfWidgetFormPropelChoice(array('model' => 'Language', 'add_empty' => true)),
      'package_id'  => new sfWidgetFormPropelChoice(array('model' => 'Package', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'URL'         => new sfValidatorPass(array('required' => false)),
      'language_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Language', 'column' => 'id')),
      'package_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Package', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('package_links_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PackageLinks';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'URL'         => 'Text',
      'language_id' => 'ForeignKey',
      'package_id'  => 'ForeignKey',
    );
  }
}
