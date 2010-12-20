<?php
class criteriaFactory
{

  public function createFromContext(madbContext $context, $perimeter)
  {
    $criteria   = new Criteria();
    $filterList = filterCollection::getAll();

    $perimeters = new filterPerimeters();
    $perimeter  = $perimeters->get($perimeter);

    $criteria = $perimeter->addSelectColumns($criteria);

    foreach ($filterList as $filter)
    {
      $filter->setCriteria($criteria);
      $filter->setMadbContext($context);
      if ($filter->getPerimeter() == $perimeter)
      {
        $criteria = $filter->getFilteredCriteria();
      }
      else
      {
        $criteria = $this->applyFilterOnOtherPerimeter($filter, $criteria);
      }
    }
    return $criteria;
  }

  protected function applyFilterOnOtherPerimeter($filter, $criteria)
  {
    $criteriaOrig = $criteria;
    $criteria = clone $criteria;
    $criteria->clearSelectColumns();
    //TODO by perimeter select
    $criteria->addSelectColumn(PackagePeer::ID);
    $criteria->setDistinct();
    $filter->setCriteria($criteria);
    $filter->getFilteredCriteria();
    $tablename = 'tmp_filtrage_' . md5(get_class($filter));
    $toTmp = new criteriaToTemporaryTable($criteria, $tablename);
    $pdo = Propel::getConnection();
    $toTmp->setConnection(Propel::getConnection());
    $toTmp->execute();
    $sql = 'ALTER TABLE %s ADD INDEX (id)';
    $pdo->exec(sprintf($sql, $tablename));
    $criteria = $criteriaOrig;
    //TODO by perumeter join
    $criteria->addJoin(PackagePeer::ID, $toTmp->getField('id'), Criteria::JOIN);
    return $criteria;
  }

}
