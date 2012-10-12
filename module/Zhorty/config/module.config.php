<?php
return array(
	'controllers' => array(
        'invokables' => array(
            'Zhorty\Controller\Trim' => 'Zhorty\Controller\TrimController'
        ),
    ),   
    'router' => array(
        'routes' => array(
            'zhorty-trim' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/trim',
                    'defaults' => array(
                        'controller' => 'Zhorty\Controller\Trim',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                     'zhorty-trim-list' => array(
                     	'type'    => 'Segment',
                        'options' => array(
                        	'route'    => '/list',
                            'defaults' => array(
                            	'action' => 'list',
                            ),
                         ),
                     ),
                     'zhorty-trim-delete' => array(
                     	'type'    => 'Segment',
                        'options' => array(
                        	'route'    => '/delete/[:id]',
                            'defaults' => array(
                            	'action' => 'delete',
                            ),
     	                    'constraints' => array(
        	                    'id' => '[0-9]+',
                             ),
                         ),
                     ),
                 ),
            ),
        ),
    ), 
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),    
);