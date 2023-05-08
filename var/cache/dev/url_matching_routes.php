<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/doc.json' => [[['_route' => 'app.swagger', '_controller' => 'nelmio_api_doc.controller.swagger'], null, ['GET' => 0], null, false, false, null]],
        '/api/doc' => [[['_route' => 'app.swagger_ui', '_controller' => 'nelmio_api_doc.controller.swagger_ui'], null, ['GET' => 0], null, false, false, null]],
        '/api/brands' => [
            [['_route' => 'brand', '_controller' => 'App\\Controller\\BrandController::getBrandList'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'createBrand', '_controller' => 'App\\Controller\\BrandController::createBrand'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/mobiles' => [
            [['_route' => 'mobiles', '_controller' => 'App\\Controller\\MobileController::getAllMobiles'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'createMobile', '_controller' => 'App\\Controller\\MobileController::createMobile'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/users' => [
            [['_route' => 'usersList', '_controller' => 'App\\Controller\\UserController::getUserList'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'createUser', '_controller' => 'App\\Controller\\UserController::createUser'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/clients' => [[['_route' => 'users', '_controller' => 'App\\Controller\\UserController::getClientList'], null, ['GET' => 0], null, false, false, null]],
        '/api/login_check' => [[['_route' => 'api_login_check'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/api/(?'
                    .'|brands/([^/]++)(?'
                        .'|(*:68)'
                    .')'
                    .'|mobiles/([^/]++)(?'
                        .'|(*:95)'
                    .')'
                    .'|users/(?'
                        .'|([^/]++)(?'
                            .'|(*:123)'
                        .')'
                        .'|clients(*:139)'
                        .'|([^/]++)(*:155)'
                        .'|clients/([^/]++)(*:179)'
                    .')'
                    .'|add\\-client/([^/]++)(*:208)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        68 => [
            [['_route' => 'detailBrand', '_controller' => 'App\\Controller\\BrandController::getDetailBrand'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'deleteBrand', '_controller' => 'App\\Controller\\BrandController::deleteBrand'], ['id'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'updateBrand', '_controller' => 'App\\Controller\\BrandController::updateBrand'], ['id'], ['PUT' => 0], null, false, true, null],
        ],
        95 => [
            [['_route' => 'detailMobile', '_controller' => 'App\\Controller\\MobileController::getDetailMobile'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'deleteMobile', '_controller' => 'App\\Controller\\MobileController::deleteMobile'], ['id'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'updateMobile', '_controller' => 'App\\Controller\\MobileController::updateMobile'], ['id'], ['PUT' => 0], null, false, true, null],
        ],
        123 => [
            [['_route' => 'deleteUser', '_controller' => 'App\\Controller\\UserController::deleteUser'], ['id'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'updateUser', '_controller' => 'App\\Controller\\UserController::updateUser'], ['id'], ['PUT' => 0], null, false, true, null],
        ],
        139 => [[['_route' => 'createClient', '_controller' => 'App\\Controller\\UserController::createClient'], [], ['POST' => 0], null, false, false, null]],
        155 => [[['_route' => 'detailUser', '_controller' => 'App\\Controller\\UserController::getDetailUser'], ['id'], ['GET' => 0], null, false, true, null]],
        179 => [[['_route' => 'deleteClient', '_controller' => 'App\\Controller\\UserController::deleteClient'], ['id'], ['DELETE' => 0], null, false, true, null]],
        208 => [
            [['_route' => 'linkUser', '_controller' => 'App\\Controller\\UserController::linkUser'], ['id'], ['POST' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
