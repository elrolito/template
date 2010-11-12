<?php defined('SYSPATH') or die('No direct script access.');

/**
 * return Array of theme defaults for the template controller
 */
return array(
    'default' => array(
        'title' => 'Website Title',
        'styles' => array(
                // 'file' => 'media'
            ),
        'scripts' => array(
            'head' => array(
                // 'file'
            ),
            'body' => array(
                //'file'
            ),
        ),
        'pages' => array(
            // 'regex' => 'page1|page2|etc'
            'regex' => '',
            'default' => ''
        ),
    ),
);