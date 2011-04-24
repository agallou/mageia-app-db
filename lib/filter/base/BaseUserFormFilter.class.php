<?php

/**
 * User filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseUserFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'login'                             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'user_has_software_request_list'    => new sfWidgetFormPropelChoice(array('model' => 'SoftwareRequest', 'add_empty' => true)),
      'user_has_new_version_request_list' => new sfWidgetFormPropelChoice(array('model' => 'NewVersionRequest', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                              => new sfValidatorPass(array('required' => false)),
      'login'                             => new sfValidatorPass(array('required' => false)),
      'user_has_software_request_list'    => new sfValidatorPropelChoice(array('model' => 'SoftwareRequest', 'required' => false)),
      'user_has_new_version_request_list' => new sfValidatorPropelChoice(array('model' => 'NewVersionRequest', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addUserHasSoftwareRequestListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(UserHasSoftwareRequestPeer::USER_ID, UserPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(UserHasSoftwareRequestPeer::SOFTWARE_REQUEST_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(UserHasSoftwareRequestPeer::SOFTWARE_REQUEST_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addUserHasNewVersionRequestListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(UserHasNewVersionRequestPeer::USER_ID, UserPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(UserHasNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(UserHasNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'User';
  }

  public function getFields()
  {
    return array(
      'id'                                => 'Number',
      'name'                              => 'Text',
      'login'                             => 'Text',
      'user_has_software_request_list'    => 'ManyKey',
      'user_has_new_version_request_list' => 'ManyKey',
    );
  }
}
