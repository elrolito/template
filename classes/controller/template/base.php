<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Controller_Template_Base controller class
 *
 * @package    Template
 * @category   Controller
 * @author     Rolando Henry
 * @copyright (c) 2010 Rolando Henry
 * @license    http://creativecommons.org/licenses/BSD/
 */
abstract class Controller_Template_Base extends  Controller_Template {

    public $template = 'templates/'.Template::$theme;

    public function __construct(Request $req)
    {
        parent::__construct($req);

        $this->_config = Template::instance()->config();
    }

    public function before()
    {
        // open external links in new window
        HTML::$windowed_urls = true;

        parent::before();

        if ($this->auto_render)
        {
            $config = $this->_config;

            $this->template->title = $config['title'];

            $this->template->meta = array(
                    'description' => '',
                    'keywords'    => '',
                    'robots'      => ''
                );

            $this->template->styles = array();

            $this->template->scripts = array(
                    'head' => array(),
                    'body' => array()
                );
        }
    }

    public function after()
    {
        if (Request::$is_ajax OR $this->request !== Request::instance())
        {
            $this->auto_render = false;
            $this->request->response = $this->template->content;
        }

        if ($this->auto_render)
        {
            $this->_compile_assets();
        }

        parent::after();
    }

    protected function _compile_assets()
    {
        $config = $this->_config;

        $styles = Arr::merge($this->template->styles, $config['styles']);
        $scripts = Arr::merge($this->template->scripts, $config['scripts']);

        $style_assets = array();

        foreach ($styles as $file => $media)
        {
            $style_assets[] = HTML::style($file, array('media' => $media));
        }

        $script_assets = array('head' => array(), 'body' => array());

        foreach ($scripts['head'] as $file)
        {
            $script_assets['head'][] = HTML::script($file);
        }

        foreach ($scripts['body'] as $file)
        {
            $script_assets['body'][] = HTML::script($file);
        }

        $this->template->styles = "\n    ".implode("\n    ", $style_assets);
        $this->template->scripts['head'] = "\n    ".implode("\n    ", $script_assets['head']);
        $this->template->scripts['body'] = "\n    ".implode("\n    ", $script_assets['body']);
    }
} // End Controller_Template_Base