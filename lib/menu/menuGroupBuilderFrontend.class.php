<?php
class menuGroupBuilderFrontend extends menuGroupBuilder
{

  protected function build()
  {
    // Latest
    $items = array();
    if (MediaPeer::countMediaByType(true, false, false) + count(DistreleasePeer::getDevels()))
    {
      $items[] = $this->createItem('Updates', 'rpm/list', array('extra_parameters' => array('listtype' => 'updates')));
    }
    if (MediaPeer::countMediaByType(true, false, true))
    {
      $items[] = $this->createItem('Update candidates', 'rpm/list', array('extra_parameters' => array('listtype' => 'updates_testing')));
    }
    if (MediaPeer::countMediaByType(false, true, false))
    {
      $items[] = $this->createItem('Backports', 'rpm/list', array('extra_parameters' => array('listtype' => 'backports')));
    }
    if (MediaPeer::countMediaByType(false, true, true))
    {
      $items[] = $this->createItem('Backport candidates', 'rpm/list', array('extra_parameters' => array('listtype' => 'backports_testing')));
    }
    $this->addGroup('Latest', $items, 'icon-bell');

    // Browse
    $this->addGroup('Browse', array(
      $this->createItem('Groups', 'group/list'),
      $this->createItem('Packages/Applications', 'package/list'),
    ), 'icon-tasks');

    // Tools
    $items = array();
    $items[] = $this->createItem('Versions comparison', 'package/comparison');
    $madbConfig = new madbConfig();
    if ($madbConfig->get("distribution") == "mageia")
    {
      $items[] = $this->createItem('QA Updates', 'tools/updates');
      $items[] = $this->createItem('Release blockers for Mga 10', 'tools/blockers');
      $items[] = $this->createItem('Intended for Mga 10', 'tools/milestone');
      $items[] = $this->createItem('High priority for Mga 10', 'tools/highPriority');
    }
    $this->addGroup('Tools', $items, 'icon-puzzle-piece');

    // User
    if ($this->isUserAuthenticated())
    {
      $this->addItem($this->createItem('My account'));
    }
  }

}
