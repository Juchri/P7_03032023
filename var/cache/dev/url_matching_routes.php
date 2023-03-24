<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/brands' => [
            [['_route' => 'brand', '_controller' => 'App\\Controller\\BrandController::getBrandList'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'createBrand', '_controller' => 'App\\Controller\\BrandController::createBrand'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/clients' => [
            [['_route' => 'client', '_controller' => 'App\\Controller\\ClientController::getClientList'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'createClient', '_controller' => 'App\\Controller\\ClientController::createClient'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/mobiles' => [
            [['_route' => 'mobile', '_controller' => 'App\\Controller\\MobileController::getMobileList'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'createMobile', '_controller' => 'App\\Controller\\MobileController::createMobile'], null, ['POST' => 0], null, false, false, null],
        ],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/api/(?'
                    .'|brands/([^/]++)(?'
                        .'|(*:68)'
                    .')'
                    .'|clients/([^/]++)(?'
                        .'|(*:95)'
                    .')'
                    .'|mobiles/([^/]++)(?'
                        .'|(*:122)'
                    .')'
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
            [['_route' => 'detailClient', '_controller' => 'App\\Controller\\ClientController::getDetailClient'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'deleteClient', '_controller' => 'App\\Controller\\ClientController::deleteClient'], ['id'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'updateClient', '_controller' => 'App\\Controller\\ClientController::updateClient'], ['id'], ['PUT' => 0], null, false, true, null],
        ],
        122 => [
            [['_route' => 'detailMobile', '_controller' => 'App\\Controller\\MobileController::getDetailMobile'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'deleteMobile', '_controller' => 'App\\Controller\\MobileController::deleteMobile'], ['id'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'updateMobile', '_controller' => 'App\\Controller\\MobileController::updateMobile'], ['id'], ['PUT' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
