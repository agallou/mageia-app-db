<?php

/**
 * SoftwareRequest filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSoftwareRequestFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'url'                            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'text'                           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'user_id'                        => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'backport_to'                    => new sfWidgetFormFilterInput(),
      'status'                         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'user_has_software_request_list' => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                           => new sfValidatorPass(array('required' => false)),
      'url'                            => new sfValidatorPass(array('required' => false)),
      'text'                           => new sfValidatorPass(array('required' => false)),
      'user_id'                        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'User', 'column' => 'id')),
      'backport_to'                    => new sfValidatorPass(array('required' => false)),
      'status'                         => new sfValidatorPass(array('required' => false)),
      'user_has_software_request_list' => new sfValidatorPropelChoice(array('model' => 'User', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('software_request_filters[%s]');

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

    $criteria->addJoin(UserHasSoftwareRequestPeer::SOFTWARE_REQUEST_ID, SoftwareRequestPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(UserHasSoftwareRequestPeer::USER_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(UserHasSoftwareRequestPeer::USER_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'SoftwareRequest';
  }

  public function getFields()
  {
    return array(
      'id'                             => 'Number',
      'name'                           => 'Text',
      'url'                            => 'Text',
      'text'                           => 'Text',
      'user_id'                        => 'ForeignKey',
      'backport_to'                    => 'Text',
      'status'                         => 'Text',
      'user_has_software_request_list' => 'ManyKey',
    );
  }
}
