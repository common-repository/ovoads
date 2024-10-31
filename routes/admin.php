<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

use Ovoads\BackOffice\Router\Router;
use Ovoads\Controllers\Admin\AdDomainListController;
use Ovoads\Controllers\Admin\AdKeywordsController;
use Ovoads\Controllers\Admin\AdminController;
use Ovoads\Controllers\Admin\AdvertiseController;
use Ovoads\Controllers\Admin\GeneralSettingController;

$router = new Router;

$router->router([
    'admin.ovoads' => [
        'method'       => 'get',
        'query_string' => 'ovoads',
        'action'       => [AdminController::class, 'dashboard'],
    ],
]);

$router->router([
    'admin.deactivate.plugin' => [
        'method'       => 'post',
        'query_string' => 'deactivate_plugin',
        'action'       => [AdminController::class, 'deactivatePlugin'],
    ],
]);
$router->router([
    'admin.get.support' => [
        'method'       => 'get',
        'query_string' => 'get_support',
        'action'       => [AdminController::class, 'getSupport'],
    ],
]);

$router->router([
    'admin.advertise.index' => [
        'method'       => 'get',
        'query_string' => 'ovoads_advertise',
        'action'       => [AdvertiseController::class, 'index'],
    ],
]);

$router->router([
    'admin.advertise.create' => [
        'method'       => 'get',
        'query_string' => 'ovoads_advertise_create',
        'action'       => [AdvertiseController::class, 'create'],
    ],
]);
$router->router([
    'admin.advertise.store' => [
        'method'       => 'post',
        'query_string' => 'advertise_store',
        'action'       => [AdvertiseController::class, 'store'],
    ],
]);
$router->router([
    'admin.advertise.status' => [
        'method'       => 'get',
        'query_string' => 'advertise_status',
        'action'       => [AdvertiseController::class, 'status'],
    ],
]);
$router->router([
    'admin.advertise.edit' => [
        'method'       => 'get',
        'query_string' => 'advertise_edit',
        'action'       => [AdvertiseController::class, 'edit'],
    ],
]);
$router->router([
    'admin.advertise.update' => [
        'method'       => 'post',
        'query_string' => 'advertise_update',
        'action'       => [AdvertiseController::class, 'update'],
    ],
]);
$router->router([
    'admin.advertise.detail' => [
        'method'       => 'get',
        'query_string' => 'advertise_detail',
        'action'       => [AdvertiseController::class, 'detail'],
    ],
]);
$router->router([
    'admin.advertise.delete' => [
        'method'       => 'get',
        'query_string' => 'advertise_delete',
        'action'       => [AdvertiseController::class, 'delete'],
    ],
]);
$router->router([
    'admin.ad.domain.index' => [
        'method'       => 'get',
        'query_string' => 'ovoads_domain_list',
        'action'       => [AdDomainListController::class, 'index'],
    ],
]);
$router->router([
    'admin.ad.domain.store' => [
        'method'       => 'post',
        'query_string' => 'ovoads_domain_store',
        'action'       => [AdDomainListController::class, 'store'],
    ],
]);
$router->router([
    'admin.ad.domain.status' => [
        'method'       => 'get',
        'query_string' => 'ovoads_domain_status',
        'action'       => [AdDomainListController::class, 'status'],
    ],
]);
$router->router([
    'admin.ad.domain.update' => [
        'method'       => 'post',
        'query_string' => 'ovoads_domain_update',
        'action'       => [AdDomainListController::class, 'update'],
    ],
]);
$router->router([
    'admin.ad.report.ip.status' => [
        'method'       => 'get',
        'query_string' => 'ovoads_ip_status',
        'action'       => [AdvertiseController::class, 'ipStatus'],
    ],
]);
$router->router([
    'admin.ad.ip.log.index' => [
        'method'       => 'get',
        'query_string' => 'ovoads_ip_logs',
        'action'       => [AdvertiseController::class, 'ipLogs'],
    ],
]);
$router->router([
    'admin.ad.keyword.index' => [
        'method'       => 'get',
        'query_string' => 'ovoads_keywords',
        'action'       => [AdKeywordsController::class, 'index'],
    ],
]);
$router->router([
    'admin.ad.keyword.store' => [
        'method'       => 'post',
        'query_string' => 'ovoads_keywords_store',
        'action'       => [AdKeywordsController::class, 'store'],
    ],
]);
$router->router([
    'admin.ad.keyword.update' => [
        'method'       => 'post',
        'query_string' => 'ovoads_keywords_update',
        'action'       => [AdKeywordsController::class, 'update'],
    ],
]);
$router->router([
    'admin.ad.keyword.status' => [
        'method'       => 'get',
        'query_string' => 'ovoads_keywords_status',
        'action'       => [AdKeywordsController::class, 'status'],
    ],
]);


//setting
$router->router([
    'admin.setting.index' => [
        'method'       => 'get',
        'query_string' => 'ovoads_settings',
        'action'       => [GeneralSettingController::class, 'index'],
    ],
]);

$router->router([
    'admin.setting.store' => [
        'method'       => 'post',
        'query_string' => 'setting_store',
        'action'       => [GeneralSettingController::class, 'store'],
    ],
]);

