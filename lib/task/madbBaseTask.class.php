<?php
abstract class madbBaseTask extends sfBaseTask
{
  protected $propel = false;

  public function initialize(sfEventDispatcher $dispatcher, sfFormatter $formatter)
  {
    /*
    if ($this->propel === true)
    {
      sfContext::createInstance($this->createConfiguration('frontend', 'prod'));
    }
    */
    parent::initialize($dispatcher, $formatter);
    $this->addOption('env', null, sfCommandOption::PARAMETER_OPTIONAL, 'Changes the environment this task is run in', 'prod');
  }

}
