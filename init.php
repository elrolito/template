<?php defined('SYSPATH') or die('No direct script access.');

Route::set('static', '(<page>)', array('page' => Template::instance()->static_pages()))
        ->defaults(array(
            'directory'  => 'template',
            'controller' => 'page',
            'action'     => 'static',
            'page'       => Template::instance()->default_page()
        ));