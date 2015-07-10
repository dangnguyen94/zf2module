<?php

namespace File\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class UploadForm extends Form
{
	public function __construct()
	{
		parent::__construct('form-upload');
		$this->setAttribute('enctype','multipart/form-data');

		$this->add(array(
			'name' => 'file',
			'attributes' => array(
				'type' => 'file',
				'multiple' => true
			),
			'options' => array(
				'label' => "Upload File"
			)
		));

		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'Upload',
				'class' => 'btn'
			)
		));
	}
}