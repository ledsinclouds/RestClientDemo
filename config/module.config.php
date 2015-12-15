<?php
return array(
	'session' => array(
		'use_cookies' => true,
		'use_only_cookies' => true,
		'cookie_httponly' => true,
		'cookie_secure' => false,
		'name' => 'ZF2_SESSION',
		'save_path' => __DIR__ . '/../../../../data/session'		
	),
    'controllers' => array(
        'invokables' => array(
            'RestClientDemo\Controller\Index' => 'RestClientDemo\Controller\IndexController',
            'RestClientDemo\Controller\Song' => 'RestClientDemo\Controller\SongController',            
        ),
    ),
     'router' => array(
        'routes' => array(
            'album' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/api/albums[/:action][/:album_id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'user-id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'RestClientDemo\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'songs' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/api/album[/:album_id]/songs[/:action][/:song_id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'album_id' => '[0-9]+',
                        'song_id' => '[0-9]+',                        
                    ),
                    'defaults' => array(
                        'controller' => 'RestClientDemo\Controller\Song',
                        'action' => 'index',
                    ),
                ),
            ),            
        ),
    ),
 	'view_manager' => array(
		'template_path_stack' => array(
			__DIR__ . '/../view'
		),
		'template_map' => array(
			//'testajax' => __DIR__ . '/../view/blog/template/testajax.phtml',
			//'login-settings' => __DIR__ . '/../view/blog/template/login-settings.phtml',			
		),
		'strategies' => array(
			'ViewJsonStrategy',
		),
	),
);
