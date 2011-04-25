<?php

/**
 * Rpm form base class.
 *
 * @method Rpm getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseRpmForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'package_id'      => new sfWidgetFormPropelChoice(array('model' => 'Package', 'add_empty' => false)),
      'distrelease_id'  => new sfWidgetFormPropelChoice(array('model' => 'Distrelease', 'add_empty' => false)),
      'media_id'        => new sfWidgetFormPropelChoice(array('model' => 'Media', 'add_empty' => false)),
      'rpm_group_id'    => new sfWidgetFormPropelChoice(array('model' => 'RpmGroup', 'add_empty' => false)),
      'licence'         => new sfWidgetFormInputText(),
      'name'            => new sfWidgetFormInputText(),
      'md5_name'        => new sfWidgetFormInputText(),
      'filename'        => new sfWidgetFormInputText(),
      'short_name'      => new sfWidgetFormInputText(),
      'evr'             => new sfWidgetFormInputText(),
      'version'         => new sfWidgetFormInputText(),
      'release'         => new sfWidgetFormInputText(),
      'summary'         => new sfWidgetFormInputText(),
      'description'     => new sfWidgetFormTextarea(),
      'url'             => new sfWidgetFormTextarea(),
      'rpm_pkgid'       => new sfWidgetFormInputText(),
      'build_time'      => new sfWidgetFormDateTime(),
      'size'            => new sfWidgetFormInputText(),
      'realarch'        => new sfWidgetFormInputText(),
      'arch_id'         => new sfWidgetFormPropelChoice(array('model' => 'Arch', 'add_empty' => false)),
      'is_source'       => new sfWidgetFormInputCheckbox(),
      'source_rpm_id'   => new sfWidgetFormPropelChoice(array('model' => 'Rpm', 'add_empty' => true)),
      'source_rpm_name' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'package_id'      => new sfValidatorPropelChoice(array('model' => 'Package', 'column' => 'id')),
      'distrelease_id'  => new sfValidatorPropelChoice(array('model' => 'Distrelease', 'column' => 'id')),
      'media_id'        => new sfValidatorPropelChoice(array('model' => 'Media', 'column' => 'id')),
      'rpm_group_id'    => new sfValidatorPropelChoice(array('model' => 'RpmGroup', 'column' => 'id')),
      'licence'         => new sfValidatorString(array('max_length' => 255)),
      'name'            => new sfValidatorString(array('max_length' => 900)),
      'md5_name'        => new sfValidatorString(array('max_length' => 32)),
      'filename'        => new sfValidatorString(array('max_length' => 900)),
      'short_name'      => new sfValidatorString(array('max_length' => 255)),
      'evr'             => new sfValidatorString(array('max_length' => 255)),
      'version'         => new sfValidatorString(array('max_length' => 255)),
      'release'         => new sfValidatorString(array('max_length' => 255)),
      'summary'         => new sfValidatorString(array('max_length' => 255)),
      'description'     => new sfValidatorString(),
      'url'             => new sfValidatorString(),
      'rpm_pkgid'       => new sfValidatorString(array('max_length' => 32)),
      'build_time'      => new sfValidatorDateTime(),
      'size'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'realarch'        => new sfValidatorString(array('max_length' => 45)),
      'arch_id'         => new sfValidatorPropelChoice(array('model' => 'Arch', 'column' => 'id')),
      'is_source'       => new sfValidatorBoolean(),
      'source_rpm_id'   => new sfValidatorPropelChoice(array('model' => 'Rpm', 'column' => 'id', 'required' => false)),
      'source_rpm_name' => new sfValidatorString(array('max_length' => 900, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Rpm', 'column' => array('md5_name', 'distrelease_id', 'media_id', 'arch_id')))
    );

    $this->widgetSchema->setNameFormat('rpm[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Rpm';
  }


}
