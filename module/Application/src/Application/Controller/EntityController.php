<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DOctrine\ORM\EntityManager as DoctrineEntity;

class EntityController extends AbstractActionController
{
	/**
	* @var EntitManager 
	*/
	protected $entityManager;

	/**
	* Set entityManager
	*/
	protected function setEntityManager(DoctrineEntity $em)
	{
		$this->entityManager = $em;
	}

	/**
	* Get entitymanager
	*
	*/
	protected function getEntityManager()
	{
		if (null === $this->entityManager)
		{
			$this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
		}
		return $this->entityManager;
	}
}