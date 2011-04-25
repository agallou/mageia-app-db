<?php

/**
 * UserHasNewVersionRequest filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseUserHasNewVersionRequestFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('user_has_new_version_request_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserHasNewVersionRequest';
  }

  public function getFields()
  {
    return array(
      'user_id'                => 'ForeignKey',
      'new_version_request_id' => 'ForeignKey',
    );
  }
}
