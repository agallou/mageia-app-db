<?php
abstract class menuGroupBuilder
{

  private $menuGroup = null;
  private $menuGroupFactory = null;
  private $menuItemFactory = null;
  private $sfUser = null;

  public function __construct(menuGroupFactory $menuGroupFactory, menuItemFactory $menuItemFactory, sfUser $user = null)
  {
    $this->build();
  }

  public function getMenuGroup()
  {
    return $this->menuGroup;
  }

  abstract protected function build();

  protected function isUserAuthenticated()
  {
    return false; //TODO
  }

  protected function createItem($name, $internalUri, array $options)
  {
    return $this->menuItemFactory->create($name, $internalUri, $optiondOB);
  }

  protected function addItem(menuItem $item)
  {
    $this->menuGroup->addItem($item);
  }

  protected function addGroup(menuGroup $group)
  {
    $this->menuGroup->addMenuGroup($group);
  }
}
