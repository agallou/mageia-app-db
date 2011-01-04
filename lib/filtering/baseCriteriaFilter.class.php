<?php
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

  protected function filter(Criteria $criteria, $value)
  {
    return (null !== $value) ? $this->doFilter($criteria, $value) : $criteria;
  }
  
  abstract protected function doFilter(Criteria $criteria, $value);
  
  abstract public function getName();

  /**
   * getCriteria 
   * 
   * @return Criteria
   */
  public function getFilteredCriteria()
  {
   return $this->filter($this->getCriteria(), $this->getValueFromContext($this->getMadbContext(), true));
  }

  abstract public function getValueFromContext(madbContext $context);

  abstract public function configureForm(sfForm $form);

  abstract public function getPerimeter();

  public function getDefault()
  {
    //null is no default value.
    return null;
  }

  public function hasDefault()
  {
    return $this->getDefault() !== null;
  }
}
