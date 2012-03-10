<?php
class listAction extends madbActions
{
  public function execute($request)
  {
    $this->t_group = $request->hasParameter('t_group') ? $request->getParameter('t_group') : null;
    $this->level = $request->hasParameter('level') ? (int) $request->getParameter('level') : 1;
    $this->group_name = $request->hasParameter('group_name') ? str_replace('|', '/', $request->getParameter('group_name')) : null;
    
    if (!is_null($this->t_group) and count(explode(',', $this->t_group))==1)
    {
      $this->redirect($this->madburl->urlFor( 'package/list', 
                                              $this->madbcontext, 
                                              array(
                                                'keep_all_parameters' => true, // keep t_search
                                                'extra_parameters' => array(
                                                  't_group' => $this->t_group
                                                ),
                                                'ignored_parameters' => array(
                                                  'level',
                                                  'group_name'
                                                )
                                              )
                                            )
                      );
    }
    $helperFactory = new criteriaHelperFactory();
    $helper        = $helperFactory->createDefault();
    
    $criteria = $this->getCriteria(filterPerimeters::RPM);
    $criteria->addJoin(RpmPeer::RPM_GROUP_ID, RpmGroupPeer::ID, Criteria::JOIN);
    
    $criteria->clearSelectColumns();
    
    $criteria->addAsColumn('the_name', $helper->substringIndex(RpmGroupPeer::NAME, '/', $this->level));
    $criteria->addGroupByColumn('the_name');
    $criteria->addAsColumn( 'nb_of_packages', 'COUNT(DISTINCT(' . RpmPeer::PACKAGE_ID . '))');
    $criteria->addAscendingOrderByColumn('the_name');
    
    $stmt = RpmGroupPeer::doSelectStmt($criteria);
    $this->results = $stmt->fetchAll();
  }

}
