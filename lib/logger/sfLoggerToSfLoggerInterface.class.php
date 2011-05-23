<?php
class sfLoggerToSfLoggerInterface implements sfLoggerInterface
{

  protected $logger;

  public function __construct(sfLogger $logger)
  {
    $this->logger = $logger;
  }

  public function log($message, $log = sfLogger::INFO)
  {
    $this->logger->log($message);
  }

}
