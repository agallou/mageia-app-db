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
   return $this->filter($this->getCriteria(), $this->getValue(true));
  }


  /**
   * 
   * Get and format the relevant context parameters
   * Temporary filters values and persistent filter values are merged if $use_temp_filters is true
   * (e.g. t_group and group). Returns an empty array if the intersection is empty.
   * Returns null if there's no value at all
   * 
   * @param madbContext $context
   * @param bool $use_temp_filters
   */  
  abstract public function getValueFromContext(madbContext $context, $use_temp_filters=false);

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

  /**
   * returns either the value found in context, or the default
   * 
   * TODO: add $use_temp_filters parameter like in getValueFromContext?
   * 
   * @return array of values (if only one value, array of one element)
   */
  public function getValue($use_temp_filters = false)
  {
    $value = $this->getValueFromContext($this->getMadbContext(), $use_temp_filters);
    if ($value !== null)
    {
      return $value;
    }
    elseif ($this->hasDefault())
    {
      return array($this->getDefault());
    }
    return $value;
  }
}
