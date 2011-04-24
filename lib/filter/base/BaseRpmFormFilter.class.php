<?php

/**
 * Rpm filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseRpmFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'package_id'      => new sfWidgetFormPropelChoice(array('model' => 'Package', 'add_empty' => true)),
      'distrelease_id'  => new sfWidgetFormPropelChoice(array('model' => 'Distrelease', 'add_empty' => true)),
      'media_id'        => new sfWidgetFormPropelChoice(array('model' => 'Media', 'add_empty' => true)),
      'rpm_group_id'    => new sfWidgetFormPropelChoice(array('model' => 'RpmGroup', 'add_empty' => true)),
      'licence'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'md5_name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'filename'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'short_name'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'evr'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'version'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'release'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'summary'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'url'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'rpm_pkgid'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'build_time'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'size'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'realarch'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'arch_id'         => new sfWidgetFormPropelChoice(array('model' => 'Arch', 'add_empty' => true)),
      'is_source'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'source_rpm_id'   => new sfWidgetFormPropelChoice(array('model' => 'Rpm', 'add_empty' => true)),
      'source_rpm_name' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'package_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Package', 'column' => 'id')),
      'distrelease_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Distrelease', 'column' => 'id')),
      'media_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Media', 'column' => 'id')),
      'rpm_group_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'RpmGroup', 'column' => 'id')),
      'licence'         => new sfValidatorPass(array('required' => false)),
      'name'            => new sfValidatorPass(array('required' => false)),
      'md5_name'        => new sfValidatorPass(array('required' => false)),
      'filename'        => new sfValidatorPass(array('required' => false)),
      'short_name'      => new sfValidatorPass(array('required' => false)),
      'evr'             => new sfValidatorPass(array('required' => false)),
      'version'         => new sfValidatorPass(array('required' => false)),
      'release'         => new sfValidatorPass(array('required' => false)),
      'summary'         => new sfValidatorPass(array('required' => false)),
      'description'     => new sfValidatorPass(array('required' => false)),
      'url'             => new sfValidatorPass(array('required' => false)),
      'rpm_pkgid'       => new sfValidatorPass(array('required' => false)),
      'build_time'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'size'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'realarch'        => new sfValidatorPass(array('required' => false)),
      'arch_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Arch', 'column' => 'id')),
      'is_source'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'source_rpm_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Rpm', 'column' => 'id')),
      'source_rpm_name' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('rpm_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Rpm';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'package_id'      => 'ForeignKey',
      'distrelease_id'  => 'ForeignKey',
      'media_id'        => 'ForeignKey',
      'rpm_group_id'    => 'ForeignKey',
      'licence'         => 'Text',
      'name'            => 'Text',
      'md5_name'        => 'Text',
      'filename'        => 'Text',
      'short_name'      => 'Text',
      'evr'             => 'Text',
      'version'         => 'Text',
      'release'         => 'Text',
      'summary'         => 'Text',
      'description'     => 'Text',
      'url'             => 'Text',
      'rpm_pkgid'       => 'Text',
      'build_time'      => 'Date',
      'size'            => 'Number',
      'realarch'        => 'Text',
      'arch_id'         => 'ForeignKey',
      'is_source'       => 'Boolean',
      'source_rpm_id'   => 'ForeignKey',
      'source_rpm_name' => 'Text',
    );
  }
}
