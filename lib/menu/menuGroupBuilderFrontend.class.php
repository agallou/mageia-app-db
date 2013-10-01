<?php
class menuGroupBuilderFrontend extends menuGroupBuilder
{

  protected function build()
  {
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
    $this->addGroup('Browse', array(
      $this->createItem('By group', 'group/list'),
      $this->createItem('By popularity'),
      $this->createItem('By name', 'package/list'),
    ), 'icon-tasks');
    $this->addGroup('Requests', array(
      $this->createItem('Backports requests'),
      $this->createItem('New soft request'),
    ), 'icon-share');
    $this->addGroup('Tools', array(
      $this->createItem('Comparison with dev branch', 'package/comparison'),
    ), 'icon-puzzle-piece');
    if ($this->isUserAuthenticated())
    {
      $this->addItem($this->createItem('My account'));
    }
  }

}
