<?php

// This file has been auto-generated by the Symfony Routing Component.

return [
    '_preview_error' => [['code', '_format'], ['_controller' => 'error_controller::preview', '_format' => 'html'], ['code' => '\\d+'], [['variable', '.', '[^/]++', '_format', true], ['variable', '/', '\\d+', 'code', true], ['text', '/_error']], [], [], []],
    'app.swagger' => [[], ['_controller' => 'nelmio_api_doc.controller.swagger'], [], [['text', '/api/doc.json']], [], [], []],
    'app.swagger_ui' => [[], ['_controller' => 'nelmio_api_doc.controller.swagger_ui'], [], [['text', '/api/doc']], [], [], []],
    'brand' => [[], ['_controller' => 'App\\Controller\\BrandController::getBrandList'], [], [['text', '/api/brands']], [], [], []],
    'detailBrand' => [['id'], ['_controller' => 'App\\Controller\\BrandController::getDetailBrand'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/brands']], [], [], []],
    'deleteBrand' => [['id'], ['_controller' => 'App\\Controller\\BrandController::deleteBrand'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/brands']], [], [], []],
    'createBrand' => [[], ['_controller' => 'App\\Controller\\BrandController::createBrand'], [], [['text', '/api/brands']], [], [], []],
    'updateBrand' => [['id'], ['_controller' => 'App\\Controller\\BrandController::updateBrand'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/brands']], [], [], []],
    'client' => [[], ['_controller' => 'App\\Controller\\ClientController::getClientList'], [], [['text', '/api/clients']], [], [], []],
    'detailClient' => [['id'], ['_controller' => 'App\\Controller\\ClientController::getDetailClient'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/clients']], [], [], []],
    'deleteClient' => [['id'], ['_controller' => 'App\\Controller\\ClientController::deleteClient'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/clients']], [], [], []],
    'updateClient' => [['id'], ['_controller' => 'App\\Controller\\ClientController::updateClient'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/clients']], [], [], []],
    'mobiles' => [[], ['_controller' => 'App\\Controller\\MobileController::getAllMobiles'], [], [['text', '/api/mobiles']], [], [], []],
    'detailMobile' => [['id'], ['_controller' => 'App\\Controller\\MobileController::getDetailMobile'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/mobiles']], [], [], []],
    'deleteMobile' => [['id'], ['_controller' => 'App\\Controller\\MobileController::deleteMobile'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/mobiles']], [], [], []],
    'createMobile' => [[], ['_controller' => 'App\\Controller\\MobileController::createMobile'], [], [['text', '/api/mobiles']], [], [], []],
    'updateMobile' => [['id'], ['_controller' => 'App\\Controller\\MobileController::updateMobile'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/mobiles']], [], [], []],
    'users' => [[], ['_controller' => 'App\\Controller\\UserController::getUserList'], [], [['text', '/api/users']], [], [], []],
    'detailUser' => [['id'], ['_controller' => 'App\\Controller\\UserController::getDetailUser'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/users']], [], [], []],
    'deleteUser' => [['id'], ['_controller' => 'App\\Controller\\UserController::deleteUser'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/users']], [], [], []],
    'createUser' => [[], ['_controller' => 'App\\Controller\\UserController::createUser'], [], [['text', '/api/users']], [], [], []],
    'updateUser' => [['id'], ['_controller' => 'App\\Controller\\UserController::updateUser'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/users']], [], [], []],
    'createClient' => [[], ['_controller' => 'App\\Controller\\UserController::createClient'], [], [['text', '/api/users/clients']], [], [], []],
    'api_login_check' => [[], [], [], [['text', '/api/login_check']], [], [], []],
];
