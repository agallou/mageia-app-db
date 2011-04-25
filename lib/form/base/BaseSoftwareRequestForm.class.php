<?php

/**
 * SoftwareRequest form base class.
 *
 * @method SoftwareRequest getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSoftwareRequestForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                             => new sfWidgetFormInputHidden(),
      'name'                           => new sfWidgetFormInputText(),
      'url'                            => new sfWidgetFormInputText(),
      'text'                           => new sfWidgetFormTextarea(),
      'user_id'                        => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => false)),
      'backport_to'                    => new sfWidgetFormTextarea(),
      'status'                         => new sfWidgetFormInputText(),
      'user_has_software_request_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'User')),
    ));

    $this->setValidators(array(
      'id'                             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                           => new sfValidatorString(array('max_length' => 255)),
      'url'                            => new sfValidatorString(array('max_length' => 2048)),
      'text'                           => new sfValidatorString(),
      'user_id'                        => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id')),
      'backport_to'                    => new sfValidatorString(array('required' => false)),
      'status'                         => new sfValidatorString(array('max_length' => 45)),
      'user_has_software_request_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'User', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('software_request[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SoftwareRequest';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['user_has_software_request_list']))
    {
      $values = array();
      foreach ($this->object->getUserHasSoftwareRequests() as $obj)
      {
        $values[] = $obj->getUserId();
      }

      $this->setDefault('user_has_software_request_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveUserHasSoftwareRequestList($con);
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
    $c->add(UserHasSoftwareRequestPeer::SOFTWARE_REQUEST_ID, $this->object->getPrimaryKey());
    UserHasSoftwareRequestPeer::doDelete($c, $con);

    $values = $this->getValue('user_has_software_request_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new UserHasSoftwareRequest();
        $obj->setSoftwareRequestId($this->object->getPrimaryKey());
        $obj->setUserId($value);
        $obj->save();
      }
    }
  }

}
