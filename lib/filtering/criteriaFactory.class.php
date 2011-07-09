<?php
class criteriaFactory
{

  public function createFromContext(madbContext $context, $targetPerimeter)
  {
    $criteria              = new Criteria();
    $filtersIteratorFactory = new filtersIteratorFactory();
    $filterIterator        = $filtersIteratorFactory->create();

    $perimeters            = new filterPerimeters();
    $perimeter             = $perimeters->get($targetPerimeter);

    $criteria              = $perimeter->addSelectColumns($criteria);

    foreach ($perimeters->getAll() as $perimeter)
    {
      $perimeterFilters = $filterIterator->getByPerimeter($perimeter);
      if ($perimeter == $targetPerimeter)
      {
        $criteria = $this->applyCurrentPerimeterFilters($perimeterFilters, $criteria, $context);
      }
      else
      {
        $criteria = $this->applyOtherPerimeterFilters($perimeterFilters, $criteria, $context, $perimeters->get($perimeter));
      }
    }

    return $criteria;
  }

  private function applyCurrentPerimeterFilters(filtersIterator $filters, $criteria, $context)
  {
    $criteria = clone $criteria;
    foreach ($filters as $filter)
    {
      $filter->setCriteria($criteria);
      $filter->setMadbContext($context);
      $criteria = $filter->getFilteredCriteria();
    }
    return $criteria;
  }

  protected function getConnection()
  {
    return Propel::getConnection();
  }

  private function applyOtherPerimeterFilters(filtersIterator $filters, Criteria $criteria, $context, basePerimeter $perimeter)
  {
    $criteriaOrig = clone $criteria;
    $criteria     = new Criteria();
    $criteria->setDistinct();
    $criteria = $perimeter->addTemporayTableColumns($criteria);
    $criteria = $this->applyCurrentPerimeterFilters($filters, $criteria, $context);


    $tablename = 'tmp_filtrage_' . md5(serialize($filters));//TODO better filtertablename
    //TODO do not delete every time this table
    $this->getConnection()->exec(sprintf('DROP TABLE IF EXISTS %s', $tablename));


    $database    = new postgresqlDatabase($this->getConnection());
    $tableFields = $database->createTableFromCriteria($criteria, $tablename);

    $sql = 'ALTER TABLE %s ADD INDEX (id)';
    //TODO
 //   $this->getConnection()->exec(sprintf($sql, $tablename));

    $criteria = $criteriaOrig;

    //TODO by perumeter join

    //deux mthodes getTargetId ?
    if (get_class($perimeter) != 'rpmPerimeter')
    {
      $criteria->addJoin(RpmPeer::PACKAGE_ID, $tableFields->getField('id'), Criteria::JOIN);
    }
    else
    {
      $criteria->addJoin(PackagePeer::ID, $tableFields->getField('id'), Criteria::JOIN);
    }

     return $criteria;
  }

}
