<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

use Ovoads\BackOffice\Router\Router;
use Ovoads\Controllers\AdController;
$router = new Router;

$router->router([
    'get.ad' => [
        'method'    => 'get',
        'uri'       => 'ovoads-show',
        'action'    => [AdController::class, 'displayAd'],
    ],
]);
$router->router([
    'ad.click.count' => [
        'method'    => 'get',
        'uri'       => 'ovoads-click',
        'action'    => [AdController::class, 'updateClick'],
    ],
]);
