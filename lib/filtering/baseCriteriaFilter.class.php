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
   * @param $use_temp_filters if set to true, temporary versions of the filters (t_xxx params) are used too
   * @param $use_default_values if set to true, when there's no value for the filter the default value is returned
   *
   * @return Criteria
   */
  public function getFilteredCriteria($use_temp_filters = true, $use_default_values = true)
  {
   return $this->filter($this->getCriteria(), $this->getValue($use_temp_filters, $use_default_values));
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
    //null means no default value.
    return null;
  }

  public function hasDefault()
  {
    return $this->getDefault() !== null;
  }

  /**
   * returns either the value found in context, or the default
   * 
   * @param $use_temp_filters if set to true, temporary versions of the filters (t_xxx params) are used too
   * @param $use_default_values if set to true, when there's no value for the filter the default value is returned
   *
   * @return array of values (if only one value, array of one element)
   */
  public function getValue($use_temp_filters = false, $use_default_values = true)
  {
    $value = $this->getValueFromContext($this->getMadbContext(), $use_temp_filters);
    if ($value !== null)
    {
      return $value;
    }
    elseif ($use_default_values && $this->hasDefault())
    {
      return array($this->getDefault());
    }
    return $value;
  }
}
