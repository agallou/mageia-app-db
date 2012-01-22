<?php
class subscribeAction extends madbActions
{
  public function execute($request)
  {
    $this->getResponse()->sethttpHeader('Content-type','application/json');

    // TODO : check if user authentication check can be done at a higher level
    $params = $request->getParameter('params');
    $package_id = $request->getParameter('package_id');
    $real_action = $request->getParameter('real_action');
    if ($this->returnErrorUnless($this->getUser()->isAuthenticated(), "Only an authenticated user can do that")
        or $this->returnErrorUnless($request->hasParameter('real_action'), 'real_action is required')
        or $this->returnErrorUnless(in_array($real_action, array('add', 'remove')))
        or $this->returnErrorUnless($request->hasParameter('package_id'), 'Package id is required')
        or $this->returnErrorUnless($real_action == 'remove' || isset($params['type']))
        or $this->returnErrorUnless($real_action == 'remove' || isset($params['distrelease']))
        or $this->returnErrorUnless($real_action == 'remove' || isset($params['arch']))
        or $this->returnErrorUnless($real_action == 'remove' || isset($params['media']))
        or $this->returnErrorUnless($package=PackagePeer::retrieveByPK($package_id), 'No package found for id ' . $package_id)
    )
    {
      return;
    }
    $user_id = $this->getUser()->getProfile()->getId();

    // Check if the user has a subscription for this package already
    $criteria = new Criteria();
    $criteria->add(SubscriptionPeer::USER_ID, $user_id);
    $criteria->addJoin(SubscriptionPeer::ID, SubscriptionElementPeer::SUBSCRIPTION_ID);
    $criteria->add(SubscriptionElementPeer::PACKAGE_ID, $package_id);
    $existing_subscription = SubscriptionPeer::doSelectOne($criteria);
    
    // *** Action : remove ***
    if ($real_action == 'remove')
    {
      // nullify the reference from existing notifications to the removed subscription    
      // remove the subscription
      if ($this->returnErrorUnless($existing_subscription, "There is no subscription to remove for this package."))
      {
        return;
      }
      $existing_subscription->deleteFully();
      $message = "Subscription removed";
    }
    
    // *** Action : add/change ***
    if ($real_action == 'add')
    {
      // If the user already has a subscription for this package :
      if ($existing_subscription)
      {
        // nullify the reference from existing notifications to the removed subscription
        // remove the old subscription, add the new one
        $existing_subscription->deleteFully();
        $message = "Subscription changed.";
      }
      else
      {
        $message = "Subscription added.";
      }
      
      // FIXME : Possible race condition here if the same user updates twice at the same time, 
      //         with as a consequence possibility of 2 subscriptions for the same package instead of one.
      //         Quite unlikely and not very harmful, though
      // Add the new subscription
      
      $subscription = new Subscription();
      $subscription->setUserId($user_id);
      // TODO : allow to tweak mail prefix 
      // TODO : allow to choose another notification type (RSS feed for example), or both
      $subscription->setMailNotification(true);
      if (!is_array($params['type']))
      {
        // TODO : adapt the list to the distro's situations
        $subscription->setUpdate(true);
        $subscription->setUpdateCandidate(true);
        $subscription->setNewVersion(true);
        $subscription->setNewVersionCandidate(true);
      }
      else
      {
        foreach ($params['type'] as $type)
        {
          // TODO : use constants instead of plain numbers
          switch ($type)
          {
            case 1:
              $subscription->setUpdate(true);
              break;
            case 2:
              $subscription->setUpdateCandidate(true);
              break;
            case 3:
              $subscription->setNewVersion(true);
              break;
            case 4:
              $subscription->setNewVersionCandidate(true);
              break;
            default: break;
          }
        }
      }
      $subscription->save();
      
      $elements = array(array()); // empty array means "all archs, all distreleases, all media"
      foreach (array('distrelease', 'arch', 'media') as $param)
      {
        $elements = $this->updateElementsWithParamValues($elements, $param, $params[$param]);
      }
      foreach ($elements as $element)
      {
        $subscription_element = new SubscriptionElement();
        $subscription_element->setSubscription($subscription);
        $subscription_element->setPackageId($package_id);
        if (isset($element['distrelease']))
        {
          $subscription_element->setDistreleaseId($element['distrelease']);
        }
        if (isset($element['arch']))
        {
          $subscription_element->setArchId($element['arch']);
        }
        if (isset($element['media']))
        {
          $subscription_element->setMediaId($element['media']);
        }
        $subscription_element->save();
      }
    }
    $this->message = $message;
    $this->status = 'SUCCESS';
  }

  // FIXME : inherit from a new madbAjaxActions class so that we don't have to override this method ?
  public function getDefaultParameters()
  {
    return array();
  }

  public function updateElementsWithParamValues($elements, $name, $values)
  {
    if (is_array($values))
    {
      foreach ($elements as $key => $element)
      {
        foreach ($values as $value)
        {
          unset($elements[$key]);
          $elements[] = array_merge($element, array($name => $value));
        }
      }
    }
    return $elements;
  }
  
  public function returnErrorUnless($condition, $message=null)
  {
    if (!$condition)
    {
      $this->status = 'ERROR';
      $this->message = $message;
      return true;
    }
    return false;
  }
}