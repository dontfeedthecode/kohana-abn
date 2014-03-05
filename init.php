<?php defined('SYSPATH') or die('No direct script access.');

 Route::set('abn', 'abn(/<abn>)')
    ->defaults(array(
        'controller' => 'Abn',
        'abn'        => '',
        'action'     => 'index',
    ));