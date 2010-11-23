<?php
/**
  Methods that can be implemened : 
  getOrderByColumns();
  getGroupByColumns();
  getSelectColumns();
  getAsColumns();
  getJoins();
*/
abstract class baseCriteriaFilter
{
  protected $criteria = null;

  protected $madbcontext = null;

  public function setCriteria(Criteria $criteria)
  {
    $this->criteria = $criteria;
  }

  public function setMadbContext(madbContext $context)
  {
    $this->madbcontext = $context;
  }

  protected function getCriteria()
  {
    if (null === $this->criteria)
    {
      throw new sfException('Criteria must be set before getting it');
    }
    return $this->criteria;
  }

  protected function getMadbContext()
  {
    if (null === $this->madbcontext)
    {
      throw new sfException('madbcontext must be set before getting it');
    }
    return $this->madbcontext;
  }

  abstract protected function filter(Criteria $criteria, madbContext $context);
  abstract public function getName();

  /**
   * getCriteria 
   * 
   * @return Criteria
   */
  public function getFilteredCriteria()
  {
   return $this->filter($this->getCriteria(), $this->getMadbContext());
  }

  abstract public function configureForm(sfForm $form);

  abstract public function getPerimeter();
}
