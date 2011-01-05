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

    public function __construct(Request $req, Response $response)
    {
        parent::__construct($req, $response);

        $this->_config = Template::instance()->config();
    }

    public function before()
    {
        $this->template = 'templates/'.Template::$theme;
        
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

            $this->template->styles = array(
                    'css'  => array(),
                    'less' => array()
                );

            $this->template->scripts = array(
                    'head' => array(),
                    'body' => array()
                );
        }
    }

    public function after()
    {
        if ($this->request->is_ajax() OR ! $this->request->is_initial())
        {
            $this->auto_render = false;
            $this->response->body($this->template->content);
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
        
        // Styles
        $styles = $config['styles'];
        $css_styles = Arr::merge($styles['css'], $this->template->styles['css']);
        
        $style_assets = array();
        
        if ( ! empty($styles['less']))
        {
            $style_assets[] = HTML::style(LESS::compile($styles['less'], 'styles'), array('media' => 'all'));
        }
        
        if ( ! empty($this->template->styles['less']))
        {
            foreach ($this->template->styles['less'] as $less)
            {
                $style_assets[] = HTML::style(LESS::compile(array('base', $less), $less), array('media' => 'all'));
            }
        }
        
        foreach ($css_styles as $file => $media)
        {
            $style_assets[] = HTML::style($file, array('media' => $media));
        }
        
        // Scripts
        $scripts = Arr::merge($config['scripts'], $this->template->scripts);

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