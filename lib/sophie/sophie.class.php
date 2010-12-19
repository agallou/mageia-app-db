<?php

// ugly hack without which XML_RPC2_Client::create fails with php 5.3
if(!function_exists('dl')) 
{
  function dl($ignore) 
  {
    return false;
  }
}

class Sophie
{
  protected static $xmlrpc_url = 'http://sophie2.aero.jussieu.fr/rpc';

  protected static function getClientObject($prefix)
  {
    try {
      return XML_RPC2_Client::create(self::$xmlrpc_url, array('prefix' => $prefix));
    }
    catch (Exception $e) 
    {  
      // Other errors (HTTP or networking problems...)
      // TODO: don't die :)
      die('Exception : ' . $e->getMessage());
    }
  }

  protected static function query($prefix, $method_name, $args=array())
  {
    $client_obj = self::getClientObject($prefix);
    try 
    {
      return call_user_func_array(array($client_obj, $method_name), $args); 
    }
    catch (XML_RPC2_FaultException $e) 
    {
      // The XMLRPC server returns a XMLRPC error
      // TODO: don't die :)
      die('XMLRPC Exception #' . $e->getFaultCode() . ' : ' . $e->getFaultString());
    }
    catch (Exception $e) 
    {  
      // Other errors (HTTP or networking problems...)
      // TODO: don't die :)
      die('Exception : ' . $e->getMessage());
    }
  }

  public static function rpmsInfo ($pkgid)
  {
    return self::query('rpms.', 'info', array($pkgid));
  }
}
