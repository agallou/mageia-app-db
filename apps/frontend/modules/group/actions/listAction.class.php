<?php
class listAction extends madbActions
{
  public function execute($request)
  {
    $criteria = $this->getCriteria(filterPerimeters::RPM);
    $criteria->addJoin(RpmPeer::RPM_GROUP_ID, RpmGroupPeer::ID, Criteria::JOIN);
    
    $criteria->clearSelectColumns(); // why is it needed ?
    
    $criteria->addAsColumn( 'the_name',
                            sprintf("SUBSTRING_INDEX(%s, '/',1)", 
                                    RpmGroupPeer::NAME,
                                    RpmGroupPeer::NAME
                            )
    );
    $criteria->addGroupByColumn('the_name');
    $criteria->addAsColumn( 'nb_of_packages', 'COUNT(DISTINCT(' . RpmPeer::PACKAGE_ID . '))');
    $criteria->addAscendingOrderByColumn('the_name');
    
    $stmt = RpmGroupPeer::doSelectStmt($criteria);
    $this->results = $stmt->fetchAll(); 
  }

}
