<?php
class showAction extends madbActions
{
  public function execute($request)
  {
    $this->forward404Unless($request->hasParameter('name'), 'Package name is required');
    $name = $request->getParameter('name');
    $is_source = $this->madbcontext->getRealFilterValue('source');
    $is_source = $is_source[0];
    $this->package = PackagePeer::retrieveByNameAndIsSource($name, $is_source);
    $this->forward404Unless($this->package, $is_source ? "There's no source package called: $name." : "There's no package called: $name.");

    $criteria = $this->getCriteria(filterPerimeters::RPM);
    $this->rpms = array();
    foreach ($this->package->getRpms($criteria) as $rpm)
    {
      $this->rpms[] = $rpm;
    }
    $this->rpms = RpmPeer::sortByEvrAndDistrelease($this->rpms);

    $packageLicense = null;
    $packageUrl = null;
    if (count($this->rpms) && isset($this->rpms[0]))
    {
      $packageLicense = $this->rpms[0]->getLicense();
      if (strlen($url = $this->rpms[0]->getUrl(true)))
      {
        $packageUrl = $url;
      }
    }

    $madbConfig = new madbConfig();
    $this->allow_install = $madbConfig->get('allow_install');
    $this->allow_download = $madbConfig->get('allow_download');

    $screenshots = new madbScreenshots($name);
    $this->setVar('first_screenshot', $screenshots->getFirst());
    $this->setVar('other_screenshots', $screenshots->getOthers());
    $this->setVar('license', $packageLicense);
    $this->setVar('url', $packageUrl);

    // Subscription
    if ($this->getUser()->isAuthenticated())
    {
      $user_id=$this->getUser()->getProfile()->getId();

      // Distrelease : . Default : current subscription if there's one. Otherwise, current distrelease filter.
      // Arch : Default : current subscription if there's one. Otherwise current arch filter.
      // Media : Default : current subscription if there's one. Otherwise none.
      // type of changes : updates, update candidates, backports, backport candidates, (comments)

      // Check whether the user has subscribed to this package's changes
      $criteria = new Criteria();
      $criteria->addJoin(SubscriptionPeer::ID, SubscriptionElementPeer::SUBSCRIPTION_ID);
      $criteria->add(SubscriptionElementPeer::PACKAGE_ID, $this->package->getId());
      $criteria->add(SubscriptionPeer::MADB_USER_ID, $user_id);
      $this->subscription = SubscriptionPeer::doSelectOne($criteria);
      if ($this->subscription)
      {
        $parameters = array(
          'release' => array(),
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
            $distrelease = DistreleasePeer::retrieveByPK($subscriptionElement->getDistreleaseId());
            $parameters['release'][$distrelease->getName()] = $distrelease->getName();
          }
          if (null !== $subscriptionElement->getArchId())
          {
            $arch = ArchPeer::retrieveByPK($subscriptionElement->getArchId());
            $parameters['arch'][$arch->getName()] = $arch->getName();
          }
        }
        foreach ($parameters as $key => $value)
        {
          if (empty($value))
          {
            unset($parameters[$key]);
          }
          else
          {
            $parameters[$key] = implode(',', $value);
          }
        }
      }
      else
      {
        $keyvalue_release = $this->madbcontext->getRealFilterValue('release');
        $keyvalue_arch = $this->madbcontext->getRealFilterValue('arch');
        $parameters = array(
          'release' => array_shift($keyvalue_release),
          'arch' => array_shift($keyvalue_arch)
        );
      }
      $parameterHolder = new madbParameterHolder();
      $parameterHolder->add($parameters);
      $subscribe_form_madbcontext = new madbContext($parameterHolder);
      $filtersIteratorFactory = new filtersIteratorFactory();
      $filtersIterator = $filtersIteratorFactory->create(array('release', 'media', 'arch'));
      $this->subscribe_form = formFactory::create($filtersIterator, 'subscribe_', $subscribe_form_madbcontext, false);

      // subscription type
      // TODO : adapt the list to the distro's situations
      // TODO : use constants instead of plain numbers
      $this->types = array(
        1 => 'new update',
        2 => 'new update candidate',
        3 => 'new backport',
        4 => 'new backport candidate'
      );
      $this->subscribe_form->setWidget('package_id', new sfWidgetFormInputHidden(array(), array('value' => $this->package->getId())));
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
      formFactory::bind($this->subscribe_form, $filtersIterator, $subscribe_form_madbcontext, $extra_bind_parameters, false);
    }
  }

}
