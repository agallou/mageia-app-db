<?php

/**
 * NewVersionRequest form base class.
 *
 * @method NewVersionRequest getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseNewVersionRequestForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                                => new sfWidgetFormInputHidden(),
      'user_id'                           => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => false)),
      'package_id'                        => new sfWidgetFormPropelChoice(array('model' => 'Package', 'add_empty' => false)),
      'distrelease_id'                    => new sfWidgetFormInputHidden(),
      'version_needed'                    => new sfWidgetFormInputText(),
      'status'                            => new sfWidgetFormInputText(),
      'user_has_new_version_request_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'User')),
    ));

    $this->setValidators(array(
      'id'                                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'                           => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id')),
      'package_id'                        => new sfValidatorPropelChoice(array('model' => 'Package', 'column' => 'id')),
      'distrelease_id'                    => new sfValidatorPropelChoice(array('model' => 'Distrelease', 'column' => 'id', 'required' => false)),
      'version_needed'                    => new sfValidatorString(array('max_length' => 45)),
      'status'                            => new sfValidatorString(array('max_length' => 45)),
      'user_has_new_version_request_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'User', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('new_version_request[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'NewVersionRequest';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['user_has_new_version_request_list']))
    {
      $values = array();
      foreach ($this->object->getUserHasNewVersionRequests() as $obj)
      {
        $values[] = $obj->getUserId();
      }

      $this->setDefault('user_has_new_version_request_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveUserHasNewVersionRequestList($con);
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
    $c->add(UserHasNewVersionRequestPeer::NEW_VERSION_REQUEST_ID, $this->object->getPrimaryKey());
    UserHasNewVersionRequestPeer::doDelete($c, $con);

    $values = $this->getValue('user_has_new_version_request_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new UserHasNewVersionRequest();
        $obj->setNewVersionRequestId($this->object->getPrimaryKey());
        $obj->setUserId($value);
        $obj->save();
      }
    }
  }

}
