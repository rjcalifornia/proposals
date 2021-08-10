<?php

return [

    'entities' =>[
        [
            'type' => 'object',
            'subtype' => 'proposals',
            'searchable' => true,
        ],
    ],

    //Rutas del plugin (Todos, Ver, Editar)
    'routes' => [

        //Ruta necesaria para el link del menu principal
        'default:object:proposals' => [
			'path' => '/proposals',
			'resource' => 'proposals/all',
		],

        'collection:object:proposals:all' =>[
            'path' => '/proposals/all',
            'resource' => 'proposals/all'
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