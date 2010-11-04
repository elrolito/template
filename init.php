<?php defined('SYSPATH') or die('No direct script access.');

Route::set('static', '(<page>)', array('page' => Kohana::config('template.default.pages.regex')))
        ->defaults(array(
            'controller' => 'static',
            'action'     => 'view'
        ));