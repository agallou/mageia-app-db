<?php

/**
 * NewVersionRequest filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseNewVersionRequestFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'                           => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'package_id'                        => new sfWidgetFormPropelChoice(array('model' => 'Package', 'add_empty' => true)),
      'version_needed'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'status'                            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'user_has_new_version_request_list' => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'user_id'                           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'User', 'column' => 'id')),
      'package_id'                        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Package', 'column' => 'id')),
      'version_needed'                    => new sfValidatorPass(array('required' => false)),
      'status'                            => new sfValidatorPass(array('required' => false)),
      'user_has_new_version_request_list' => new sfValidatorPropelChoice(array('model' => 'User', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('new_version_request_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
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

    $criteria->addJoin(UserHasNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, NewVersionRequestPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(UserHasNewVersionRequestPeer::USER_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(UserHasNewVersionRequestPeer::USER_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'NewVersionRequest';
  }

  public function getFields()
  {
    return array(
      'id'                                => 'Number',
      'user_id'                           => 'ForeignKey',
      'package_id'                        => 'ForeignKey',
      'distrelease_id'                    => 'ForeignKey',
      'version_needed'                    => 'Text',
      'status'                            => 'Text',
      'user_has_new_version_request_list' => 'ManyKey',
    );
  }
}
