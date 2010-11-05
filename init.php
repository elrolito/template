<?php defined('SYSPATH') or die('No direct script access.');

$config = Kohana::config('template.'.Template::$theme);

Route::set('static', '(<page>)', array('page' => $config['pages']['regex']))
        ->defaults(array(
            'controller' => 'static',
            'action'     => 'view',
            'page'       => $config['pages']['default']
        ));