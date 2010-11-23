<?php
class criteriaFactory
{

  public static function createFromContext(madbContext $context, $perimeter)
  {
    $criteria   = new Criteria();
    $filterList = filterCollection::getAll();

    //TODO rpm
    if ($perimeter == filterPerimeters::PACKAGE)
    {
      PackagePeer::addSelectColumns($criteria);
    }
   
    foreach ($filterList as $filterName)
    {
      $filter = new $filterName();
      $filter->setCriteria($criteria);
      $filter->setMadbContext($context);
      if ($filter->getPerimeter() == $perimeter)
      {
        $criteria = $filter->getFilteredCriteria();
      }
      else
      {
        $criteria = self::applyFilterOnOtherPerimeter($filter, $criteria);
      }
    }

    return $criteria;
  }

  protected static function applyFilterOnOtherPerimeter($filter, $criteria)
  {
    return $filter->getFilteredCriteria();
  }

}
