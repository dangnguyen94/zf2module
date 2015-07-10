<?php

namespace File\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use File\Form\UploadForm;

class FileController extends AbstractActionController
{

	private $dir;

	public function init()
	{
		$config = $this->getServiceLocator()->get('Config');
		$fc = $config['file_manager']['dir'];
		if (!is_dir($fc)) {
			mkdir($fc,0777);
		}
		$this->dir = realpath($fc);// . DIRECTORY_SEPARATOR;
		
	}

	public function indexAction()
	{
		$this->init();
		$files = array();
		if (is_dir($this->dir)) {
			$handle = opendir($this->dir);
			if ($handle) {
				while (false!==($entry=readdir($handle))) {
					if ($entry!="." && $entry!="..") {
						$files[] = $entry;
					}
				}
				closedir($handle);
			}
		}
		var_dump($files);
		return new ViewModel(array('files'=>$files));

	}

	public function uploadAction()
	{
		$this->init();
		if(!is_dir($this->dir)) {
			mkdir($this->dir,0777);
		}
		$form = new UploadForm();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$post = array_merge_recursive($request->getPost()->toArray(),$request->getFiles()->toArray());
			$form->setData($post);
		
			var_dump($post);
			exit();
		}
		return new ViewModel(array('form'=>$form));
	}
	public function setFile($data)
	{
		
	}
}