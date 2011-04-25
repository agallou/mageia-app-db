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
      'sf_guard_user_id'                  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'first_name'                        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'last_name'                         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mail'                              => new sfWidgetFormFilterInput(),
      'user_has_software_request_list'    => new sfWidgetFormPropelChoice(array('model' => 'SoftwareRequest', 'add_empty' => true)),
      'user_has_new_version_request_list' => new sfWidgetFormPropelChoice(array('model' => 'NewVersionRequest', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'sf_guard_user_id'                  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'first_name'                        => new sfValidatorPass(array('required' => false)),
      'last_name'                         => new sfValidatorPass(array('required' => false)),
      'mail'                              => new sfValidatorPass(array('required' => false)),
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
      'sf_guard_user_id'                  => 'ForeignKey',
      'first_name'                        => 'Text',
      'last_name'                         => 'Text',
      'mail'                              => 'Text',
      'user_has_software_request_list'    => 'ManyKey',
      'user_has_new_version_request_list' => 'ManyKey',
    );
  }
}
