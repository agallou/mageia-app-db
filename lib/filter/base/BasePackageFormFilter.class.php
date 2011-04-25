<?php

/**
 * Package filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePackageFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'md5_name'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_application' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_source'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'summary'        => new sfWidgetFormFilterInput(),
      'description'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'           => new sfValidatorPass(array('required' => false)),
      'md5_name'       => new sfValidatorPass(array('required' => false)),
      'is_application' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_source'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'summary'        => new sfValidatorPass(array('required' => false)),
      'description'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('package_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Package';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'name'           => 'Text',
      'md5_name'       => 'Text',
      'is_application' => 'Boolean',
      'is_source'      => 'Boolean',
      'summary'        => 'Text',
      'description'    => 'Text',
    );
  }
}
