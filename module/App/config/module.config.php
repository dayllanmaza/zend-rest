<?php
namespace App;

return array(
	'controllers' => array(
		'invokables' => array(
			// 'App\Controller\Restaurant' => 'App\Controller\RestaurantController'
		),
		'factories' =>array(
			'App\Controller\Reservation' => 'App\Factory\ReservationControllerFactory',
			'App\Controller\Restaurant' => 'App\Factory\RestaurantControllerFactory'
		)
	),
	'service_manager' => array(
		'invokables' => array(
			'App\Service\ReservationServiceInterface' => 'App\Service\ReservationService',
			'App\Service\RestaurantServiceInterface' => 'App\Service\RestaurantService',
		)
	),
	'router' => array(
		'routes' => array(
			'restaurant' => array(
				'type' => 'literal',
				'options' => array(
					'route' => '/restaurant',
					'defaults' => array(
						'controller' => 'App\Controller\Restaurant',
					)
				)
			),
			'reservation' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/reservation[/:id]',
					'defaults' => array(
						'controller' => 'App\Controller\Reservation',
					),
					'constraints' => array(
						'id' => '\d+'
					)
				),
			),
		)
	),
	'doctrine' => array(
		'driver' => array(
			__NAMESPACE__ . '_driver' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
			),
			'orm_default' => array(
				'drivers' => array(
					__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
				)
			)
		)
	),
	'view_manager' => array(
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
		'strategies' => array(
			'ViewJsonStrategy',
		),
	),
);