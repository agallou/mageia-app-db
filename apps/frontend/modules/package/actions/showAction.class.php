<?php
class showAction extends madbActions
{
  public function execute($request)
  {
    $this->forward404Unless($request->hasParameter('id'), 'Package id is required');
    $id = $request->getParameter('id');
    $this->package = PackagePeer::retrieveByPk($id);
    $this->forward404Unless($this->package, 'Erroneous package id');
    
    $criteria = $this->getCriteria(filterPerimeters::RPM);
    $this->rpms = RpmPeer::sortByEvrAndDistrelease($this->package->getRpms($criteria));
    
    if ($this->getUser()->isAuthenticated())
    {
      $user_id=$this->getUser()->getProfile()->getId(); // TODO : get real user ID
      
      // Distrelease : . Default : current subscription if there's one. Otherwise, current distrelease filter.
      // Arch : Default : current subscription if there's one. Otherwise current arch filter.
      // Media : Default : current subscription if there's one. Otherwise none.
      // type of changes : updates, update candidates, backports, backport candidates, (comments)
      
      // Check whether the user has subscribed to this package's changes
      $criteria = new Criteria();
      $criteria->addJoin(SubscriptionPeer::ID, SubscriptionElementPeer::SUBSCRIPTION_ID);
      $criteria->add(SubscriptionElementPeer::PACKAGE_ID, $id);
      $criteria->add(SubscriptionPeer::USER_ID, $user_id);
      $this->subscription = SubscriptionPeer::doSelectOne($criteria);
      if ($this->subscription)
      {
        $parameters = array(
          'distrelease' => array(),
          'arch' => array(),
          'media' => array()
        );
        foreach ($this->subscription->getSubscriptionElements() as $subscriptionElement)
        {
          if (null !== $subscriptionElement->getMediaId())
          {
            $parameters['media'][$subscriptionElement->getMediaId()] = $subscriptionElement->getMediaId();
          } 
          if (null !== $subscriptionElement->getDistreleaseId())
          {
            $parameters['distrelease'][$subscriptionElement->getDistreleaseId()] = $subscriptionElement->getDistreleaseId();
          } 
          if (null !== $subscriptionElement->getArchId())
          {
            $parameters['arch'][$subscriptionElement->getArchId()] = $subscriptionElement->getArchId();
          }
        }
        foreach ($parameters as $key => $value)
        {
          $parameters[$key] = implode(',', $value);
        }
      }
      else
      {
        $parameters = array(
          'distrelease' => $this->madbcontext->getParameter('distrelease'),
          'arch' => $this->madbcontext->getParameter('arch')
        );
      }
      $parameterHolder = new madbParameterHolder();
      $parameterHolder->add($parameters);
      $subscribe_form_madbcontext = new madbContext($parameterHolder);
      $filtersIteratorFactory = new filtersIteratorFactory();
      $filtersIterator = $filtersIteratorFactory->create(array('distrelease', 'media', 'arch'));
      $this->subscribe_form = formFactory::create($filtersIterator, 'subscribe_', $subscribe_form_madbcontext, false);

      // subscription type
      // TODO : adapt the list to the distro's situations
      $this->types = array(
        1 => 'new update',
        2 => 'new update candidate',
        3 => 'new backport',
        4 => 'new backport candidate'
      ); 
      $this->subscribe_form->setWidget('type', new sfWidgetFormChoice(array('choices' => $this->types, 'multiple' => true, 'label' => "Watched events")));
      $this->subscribe_form->setValidator('type', new myValidatorChoice(array('choices' => array_keys($this->types), 'required' => true)));
      $extra_bind_parameters = array();
      if ($this->subscription)
      {
        $extra_bind_parameters['type'] = array();
        if ($this->subscription->getUpdate())
        {
          $extra_bind_parameters['type'][] = 1;
        }
        if ($this->subscription->getUpdateCandidate())
        {
          $extra_bind_parameters['type'][] = 2;
        }
        if ($this->subscription->getNewVersion())
        {
          $extra_bind_parameters['type'][] = 3;
        }
        if ($this->subscription->getNewVersionCandidate())
        {
          $extra_bind_parameters['type'][] = 4;
        }
      }
      else
      {
        $extra_bind_parameters['type'] = array(2,3,4);
      }
      formFactory::bind($this->subscribe_form, $filtersIterator, $subscribe_form_madbcontext, $extra_bind_parameters);
    }
  }

}
