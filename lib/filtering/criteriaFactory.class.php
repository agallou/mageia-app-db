<?php
class criteriaFactory
{

  public static function createFromContext(madbContext $context)
  {
    $criteria = new Criteria();

    $filter = new applicationCriteriaFilter();
    $filter->setCriteria($criteria);
    $filter->setMadbContext($context);
    $criteria = $filter->getFilteredCriteria();
    return $criteria;
  }

}
