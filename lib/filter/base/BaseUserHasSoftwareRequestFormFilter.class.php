<?php

/**
 * UserHasSoftwareRequest filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseUserHasSoftwareRequestFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('user_has_software_request_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserHasSoftwareRequest';
  }

  public function getFields()
  {
    return array(
      'user_id'             => 'ForeignKey',
      'software_request_id' => 'ForeignKey',
    );
  }
}
