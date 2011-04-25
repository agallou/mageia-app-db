<?php

/**
 * User form base class.
 *
 * @method User getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                                => new sfWidgetFormInputHidden(),
      'sf_guard_user_id'                  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'first_name'                        => new sfWidgetFormInputText(),
      'last_name'                         => new sfWidgetFormInputText(),
      'mail'                              => new sfWidgetFormInputText(),
      'user_has_software_request_list'    => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'SoftwareRequest')),
      'user_has_new_version_request_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'NewVersionRequest')),
    ));

    $this->setValidators(array(
      'id'                                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'sf_guard_user_id'                  => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'first_name'                        => new sfValidatorString(array('max_length' => 20)),
      'last_name'                         => new sfValidatorString(array('max_length' => 20)),
      'mail'                              => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'user_has_software_request_list'    => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'SoftwareRequest', 'required' => false)),
      'user_has_new_version_request_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'NewVersionRequest', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'User', 'column' => array('sf_guard_user_id')))
    );

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['user_has_software_request_list']))
    {
      $values = array();
      foreach ($this->object->getUserHasSoftwareRequests() as $obj)
      {
        $values[] = $obj->getSoftwareRequestId();
      }

      $this->setDefault('user_has_software_request_list', $values);
    }

    if (isset($this->widgetSchema['user_has_new_version_request_list']))
    {
      $values = array();
      foreach ($this->object->getUserHasNewVersionRequests() as $obj)
      {
        $values[] = $obj->getNewVersionRequestId();
      }

      $this->setDefault('user_has_new_version_request_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveUserHasSoftwareRequestList($con);
    $this->saveUserHasNewVersionRequestList($con);
  }

  public function saveUserHasSoftwareRequestList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['user_has_software_request_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(UserHasSoftwareRequestPeer::USER_ID, $this->object->getPrimaryKey());
    UserHasSoftwareRequestPeer::doDelete($c, $con);

    $values = $this->getValue('user_has_software_request_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new UserHasSoftwareRequest();
        $obj->setUserId($this->object->getPrimaryKey());
        $obj->setSoftwareRequestId($value);
        $obj->save();
      }
    }
  }

  public function saveUserHasNewVersionRequestList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['user_has_new_version_request_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(UserHasNewVersionRequestPeer::USER_ID, $this->object->getPrimaryKey());
    UserHasNewVersionRequestPeer::doDelete($c, $con);

    $values = $this->getValue('user_has_new_version_request_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new UserHasNewVersionRequest();
        $obj->setUserId($this->object->getPrimaryKey());
        $obj->setNewVersionRequestId($value);
        $obj->save();
      }
    }
  }

}
