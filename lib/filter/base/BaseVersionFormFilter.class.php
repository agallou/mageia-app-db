<?php

/**
 * Version filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseVersionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'version' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'version' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('version_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Version';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'version' => 'Text',
    );
  }
}
