<?php
class listAction extends madbActions
{
  public function execute($request)
  {
    $this->t_group = $request->hasParameter('t_group') ? str_replace('|', '/', $request->getParameter('t_group')) : null;
    $this->t_level = $request->hasParameter('t_level') ? (int) $request->getParameter('t_level') : 1;
    
    $criteria = $this->getCriteria(filterPerimeters::RPM);
    $criteria->addJoin(RpmPeer::RPM_GROUP_ID, RpmGroupPeer::ID, Criteria::JOIN);
    if (!is_null($this->t_group))
    {
      $criteria->add(RpmGroupPeer::NAME, $this->t_group . '/%', Criteria::LIKE);
    }
    
    $criteria->clearSelectColumns();
    
    $criteria->addAsColumn( 'the_name',
                            sprintf("SUBSTRING_INDEX(%s, '/',". $this->t_level . ")", 
                                    RpmGroupPeer::NAME
                            )
    );
    $criteria->addGroupByColumn('the_name');
    $criteria->addAsColumn( 'nb_of_packages', 'COUNT(DISTINCT(' . RpmPeer::PACKAGE_ID . '))');
    $criteria->addAscendingOrderByColumn('the_name');
    
    $stmt = RpmGroupPeer::doSelectStmt($criteria);
    $this->results = $stmt->fetchAll();

    if (empty($this->results))
    {
      $this->redirect($this->madburl->urlFor( 'package/list', 
                                              $this->madbcontext, 
                                              array( 
                                                'extra_parameters' => array(
                                                  't_group' => str_replace('/', '|', $this->t_group)
//                                                  't_level' => $this->t_level
                                                )
                                              )
                                            )
                      );
    }
  }

}
