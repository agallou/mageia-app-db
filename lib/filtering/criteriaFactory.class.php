<?php
class criteriaFactory
{

  public function createFromContext(madbContext $context, $targetPerimeter)
  {
    $criteria   = new Criteria();
    $filterList = filterCollection::getAll();

    $perimeters = new filterPerimeters();
    $perimeter  = $perimeters->get($targetPerimeter);

    $criteria = $perimeter->addSelectColumns($criteria);

    foreach ($filterList as $filter)
    {
      $filter->setCriteria($criteria);
      $filter->setMadbContext($context);
      if ($filter->getPerimeter() == $targetPerimeter)
      {
        $criteria = $filter->getFilteredCriteria();
      }
      else
      {
        $criteria = $this->applyFilterOnOtherPerimeter($filter, $criteria, $perimeter);
      }
    }
    return $criteria;
  }

  protected function applyFilterOnOtherPerimeter($filter, $criteria, basePerimeter $perimeter)
  {
    $criteriaOrig = $criteria;
    $criteria = clone $criteria;
    $criteria->clearSelectColumns();
    $criteria = $perimeter->addTemporayTableColumns($criteria);
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
    if (get_class($perimeter) == 'rpmPerimeter')
    {
      $criteria->addJoin(RpmPeer::ID, $toTmp->getField('id'), Criteria::JOIN);
    }
    else
    {
      $criteria->addJoin(PackagePeer::ID, $toTmp->getField('id'), Criteria::JOIN);
    }
    return $criteria;
  }

}
