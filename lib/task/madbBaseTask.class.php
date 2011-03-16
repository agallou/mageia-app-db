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
  }

  public function getFilesystem()
  {
    if (!isset($this->filesystem))
    {
      if (null == $this->commandApplication || $this->commandApplication->isVerbose())
      {
        $this->filesystem = new madbFilesystem($this->dispatcher, $this->formatter);
      }
      else
      {
        $this->filesystem = new madbFilesystem();
      }
    }
    return $this->filesystem;
  }

}
