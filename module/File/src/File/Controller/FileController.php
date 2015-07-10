<?php

namespace File\Controller;

//use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use File\Form\UploadForm;
use Application\Controller\EntityController;
use File\Entity\File;

class FileController extends EntityController
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
		// $this->init();
		// $files = array();
		// if (is_dir($this->dir)) {
		// 	$handle = opendir($this->dir);
		// 	if ($handle) {
		// 		while (false!==($entry=readdir($handle))) {
		// 			if ($entry!="." && $entry!="..") {
		// 				$files[] = $entry;
		// 			}
		// 		}
		// 		closedir($handle);
		// 	}
		// }
		//var_dump($files);
		$files = $this->getEntityManager()->getRepository('File\Entity\File')->findBy(array());

		return new ViewModel(array('files'=>$files));

	}

	public function uploadAction()
	{
		// $this->init();
		// if(!is_dir($this->dir)) {
		// 	mkdir($this->dir,0777);
		// }
		$form = new UploadForm($this->getEntityManager());
		$file = new File();
		$form->setHydrator(new DoctrineEntity($this->getEntityManager(),'File\Entity\File'));
		$form->bind($file);

		$request = $this->getRequest();
		if ($request->isPost()) {
			//$post = array_merge_recursive($request->getPost()->toArray(),$request->getFiles()->toArray());
			$post = $request->getFiles()->toArray();
			
			$upload = "/var/www/zf2module/public/uploads";
			$bool = move_uploaded_file($post["file"][0]["tmp_name"], $upload."/".$post["file"][0]["name"]);
			if ($bool) {
				// $url = $upload."/".$post["file"][0]["name"];
				$file->setUrl($post["file"][0]["name"]);
				$file->setThumbnail();

				$em = $this->getEntityManager();
				$em->persist($file);
				$em->flush();
				return $this->redirect()->toUrl('/file');
			}
 			
		}
		return new ViewModel(array('form'=>$form));
	}
	

	private function getBaseURL()
	{
		$uri = $this->getRequest()->getUri();
        return sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
	}
}