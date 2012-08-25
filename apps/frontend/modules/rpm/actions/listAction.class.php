<?php
class listAction extends madbActions
{

  protected function getDefaultParameters()
  {
    return array_merge(parent::getDefaultParameters(), array('page' => 1));
  }

  public function execute($request)
  {
    $this->forward404Unless($request->hasParameter('listtype'), 'listtype parameter is required.');
    $this->listtype = $request->getParameter('listtype');
    $this->forward404Unless(in_array($this->listtype, array('updates', 'updates_testing', 'backports', 'backports_testing')), 'listtype value \'' . $this->listtype . '\' is not valid.');
    $this->page = $request->getParameter('page', 1);
    // FIXME: mageia-specific
    $this->show_bug_links = $request->hasParameter('show_bug_links'); // experimental
    $this->show_all_bug_links = $request->hasParameter('show_all_bug_links'); // experimental
    switch ($this->listtype)
    {
      case 'updates':
        $this->title = 'Updates (security and bugfix)';
        break;
      case 'updates_testing':
        $this->title = 'Updates awaiting your testing';
        break;
      case 'backports':
        $this->title = 'Backports (new soft versions)';
        break;
      case 'backports_testing':
        $this->title = 'Backports awaiting your testing';
        break;
      default : 
        throw new Exception('Unknown value for listtype : \'' . $this->listtype . '\'');
        break;
    }

  }

}
