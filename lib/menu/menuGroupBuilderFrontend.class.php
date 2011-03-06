<?php
class menuGroupBuilderFrontend extends menuGroupBuilder
{

  protected function build()
  {
    $this->addItem($this->createItem('Homepage', '@homepage', array('fiter_parameters' => true)));
    $this->addGroup('Latest', array(
      $this->createItem('Updates', 'rpm/list', array('extra_parameters' => array('listtype' => 'updates'), 'filters_parameters' => true)),
      $this->createItem('Update candidates', 'rpm/list', array('extra_parameters' => array('listtype' => 'updates_testing'), 'filters_parameters' => true)),
      $this->createItem('Backports', 'rpm/list', array('extra_parameters' => array('listtype' => 'backports'), 'filters_parameters' => true)),
      $this->createItem('Backport candidates', 'rpm/list', array('extra_parameters' => array('listtype' => 'backports_testing'), 'filters_parameters' => true))
    );
    $this->addGroup('Browse', array(
      $this->createItem('By group', 'group/list', array('filters_parameters' => true)),
      $this->createItem('By popularity'),
      $this->createItem('By name', 'package/list', array('filters_parameters' => true)),
    );
    $this->addGroup('Requests', array(
      $this->createItem('Backports requests'),
      $this->createItem('New soft request'),
    ));
    if ($this->isUserAuthenticated())
    {
      $this->addItem($this->createItem('My account'));
    }
  }

}
