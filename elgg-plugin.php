<?php

require_once(__DIR__ . '/lib/functions.php');

return [

    'entities' =>[

        //Declarar Proposal Entity
        [
            'type' => 'object',
            'subtype' => 'proposals',
            'searchable' => true,
        ],

        //Declarar entity de la imagen de cover. No necesitamos mostrar en las busquedas
        [
            'type' => 'object',
            'subtype' => 'proposals_descriptive_image',
            'class' => 'ProposalFeatured',
            'searchable' => false,
        ],

        //Declarar entity de los documentos
        [
            'type' => 'object',
            'subtype' => 'proposals_documents',
            'class' => 'ProposalPaper',
            'searchable' => false,
        ],
       
    ],

    

    //Acciones (Guardar la propuesta, marcar designada, etc)
    'actions' => [
		'proposals/save' => [],
        'proposals/select' => [],
        'proposals/supports' => [],
	],

    //Rutas del plugin (Todos, Ver, Editar)
    'routes' => [

        //Ruta necesaria para el link del menu principal
        'default:object:proposals' => [
			'path' => '/proposals',
			'resource' => 'proposals/all',
		],

        //Ruta para todas las propuestas
        'collection:object:proposals:all' =>[
            'path' => '/proposals/all',
            'resource' => 'proposals/all'
        ],

        //Ruta para agregar una nueva propuesta
        'add:object:proposals' => [
			'path' => '/proposals/add/{guid}',
			'resource' => 'proposals/add',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],

        //Ver la propuesta que se ha publicado
        'view:object:proposals' => [
			'path' => '/proposals/view/{guid}/{title?}',
			'resource' => 'proposals/view',
		],

        //Editar la propuesta
        'edit:object:proposals' => [
			'path' => '/proposals/edit/{guid}',
			'resource' => 'proposals/edit',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],

        //Ver propuestas seleccionadas
        'selected:object:proposals' => [
			'path' => '/proposals/selected',
			'resource' => 'proposals/selected',
			
		],

        

    ],

    'view_extensions' => [
        'elgg.css' => [
			'custom/proposals.css' => [],
		],
    ],

    'hooks' =>[

        //Agregar menus del plugin al sitio
        'register' =>[
            
            //Registrar menu del sitio. Debe irse a la carpeta classes/Elgg/Proposals/Menus y abrir el site.php
            'menu:site' => [
                'Elgg\Proposals\Menus\Site::register' => [],
            ],
            'menu:title:object:proposals' => [
                \Elgg\Notifications\RegisterSubscriptionMenuItemsHandler::class => [],
            ],
        ],
],

];