<?php 
class searchCriteriaFilter extends baseCriteriaFilter
{

  public function getPerimeter()
  {
    return filterPerimeters::PACKAGE;
  }

  /**
   * doFilterChoice 
   * 
   * @param Criteria             $criteria 
   * @param                      $value 
   * @return Criteria
   */
  protected function doFilter(Criteria $criteria, $value)
  {
    $criterion = $criteria->getNewCriterion(PackagePeer::NAME, sprintf('%%%s%%', $value), Criteria::LIKE);
    $criterion->addOr($criteria->getNewCriterion(PackagePeer::SUMMARY, sprintf('%%%s%%', $value), Criteria::LIKE));
    $criteria->addAnd($criterion);
    $criteria->setIgnoreCase(true); // I don't like it because it could render some parts of the query case insensitive when not needed
                                    // But it's needed to make the search case insensitive in postgresql
    return $criteria;
  }

  //TODO delete ? (used by filteringComponent)
  //(should only be used on filterhcoice)
  public function getValues()
  {
    return array();
  }

  public function getValueFromContext(madbContext $context, $use_temp_filters = false)
  {
    if (!$context->hasParameter($this->getCode()) and (!$use_temp_filters or !$context->hasParameter("t_" . $this->getCode())))
    {
      return null;
    }
    if ($use_temp_filters && $context->hasParameter("t_" . $this->getCode()))
    {
      return $context->getParameter("t_" . $this->getCode());
    }
    else
    {
      return $context->getParameter($this->getCode());
    }
  }

  public function configureForm(sfForm $form)
  {
    $form->setWidget($this->getCode(), new sfWidgetFormInputHidden());
    $form->setValidator($this->getCode(), new sfValidatorPass());
    return $form;
  }

  public function getCode()
  {
    return 'search';
  }

  /**
   * name 
   * 
   * @return void
   */
  public function getName()
  {
    return 'Search'; //Internationalisation ? outside, allways in english here.
  }

}
