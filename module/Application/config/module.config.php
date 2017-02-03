<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
	'router' => [
		'routes' => [
			'home' => [
				'type' => Literal::class,
				'options' => [
					'route' => '/',
					'defaults' => [
						'controller' => Controller\IndexController::class,
						'action' => 'index',
					],
				],
			],
			'aboutme' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/about-me',
					'defaults' => array(
						'controller' => Controller\IndexController::class,
						'action' => 'aboutme',
					),
				),
			),
			'album' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/album[/:id]',
					'contraints' => array(
						'id' => '[0-9]+'
					),
					'defaults' => array(
						'controller' => Controller\IndexController::class,
						'action' => 'album',
						'id' => 1,
					),
				),
			),
			'team' => array(
				'type' => 'segment',
				'options' => array(
					'route'=>'/team[/:name]',
					'contraints' => array(
						'name' => '[a-z]+'
					),
					'defaults' => array(
						'controller' => Controller\IndexController::class,
						'action' => 'team',
						'name'=>'',
					),
				),
			),
			'application' => [
				'type' => Segment::class,
				'options' => [
					'route' => '/application[/:action]',
					'defaults' => [
						'controller' => Controller\IndexController::class,
						'action' => 'index',
					],
				],
			],
		],
	],
	'controllers' => [
		'factories' => [
			Controller\IndexController::class => InvokableFactory::class,
		],
	],
	'view_manager' => [
		'display_not_found_reason' => true,
		'display_exceptions' => true,
		'doctype' => 'HTML5',
		'not_found_template' => 'error/404',
		'exception_template' => 'error/index',
		'template_map' => [
			'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
			'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
			'error/404' => __DIR__ . '/../view/error/404.phtml',
			'error/index' => __DIR__ . '/../view/error/index.phtml',
		],
		'template_path_stack' => [
			__DIR__ . '/../view',
		],
	],
];
