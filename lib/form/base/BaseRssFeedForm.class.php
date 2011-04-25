<?php

/**
 * RssFeed form base class.
 *
 * @method RssFeed getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseRssFeedForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'name'    => new sfWidgetFormInputText(),
      'hash'    => new sfWidgetFormInputText(),
      'user_id' => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'    => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'hash'    => new sfValidatorString(array('max_length' => 45)),
      'user_id' => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id')),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'RssFeed', 'column' => array('hash')))
    );

    $this->widgetSchema->setNameFormat('rss_feed[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RssFeed';
  }


}
