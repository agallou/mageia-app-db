<?php

/**
 * Media filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseMediaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'vendor'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_updates'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_backports'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_testing'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_third_party' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'name'           => new sfValidatorPass(array('required' => false)),
      'vendor'         => new sfValidatorPass(array('required' => false)),
      'is_updates'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_backports'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_testing'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_third_party' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('media_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Media';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'name'           => 'Text',
      'vendor'         => 'Text',
      'is_updates'     => 'Boolean',
      'is_backports'   => 'Boolean',
      'is_testing'     => 'Boolean',
      'is_third_party' => 'Boolean',
    );
  }
}
