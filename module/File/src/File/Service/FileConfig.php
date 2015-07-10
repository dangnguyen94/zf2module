<?php

namespace File\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FileConfig implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $s)
	{
		$config = $s->getServiceLocator()->get('Config');
		$file_manager = $config['file_manager']['dir'];
		return $file_manager;
	}
}