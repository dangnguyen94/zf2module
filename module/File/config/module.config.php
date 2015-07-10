<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'File\Controller\File' => 'File\Controller\FileController'
		)
	),
	'router' => array(
		'routes' => array(
			'file-manager' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/file[/:action][/:id]',
					'defaults' => array(
						'controller' => 'File\Controller\File',
						'action' => 'index'
					)
				),
			)
		)
	),
	'view_manager' => array(
		'template_path_stack' => array(
			__DIR__ . '/../view'
		)
	),
	'file_manager' => array(
		'dir' => '/var/www/zf2module/public/uploads',
	)
);