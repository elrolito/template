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

    public $template = 'templates/default';

    protected $_content;

    protected $_styles = array();
    protected $_scripts = array('head' => array(), 'body' => array());

    protected $_meta = array('description' => '', 'keywords' => '');

    private $_template = array(
            'head' => '',
            'body_scripts' => ''
        );

	/**
	 * Automatically executed before the controller action. Can be used to set
	 * class properties, do authorization checks, and execute other custom code.
	 *
	 */
	public function before()
	{
		HTML::$windowed_urls = true;
        
		parent::before();

        if ($this->auto_render)
        {
            // init the template and bind variables
            $this->template->title = Template::instance()->title();

            $this->template->bind('content', $this->_content)
                    ->bind('head', $_template['head'])
                    ->bind('meta', $this->_meta)
                    ->bind('body_scripts', $_template['body_scripts']);
        }
	}

	/**
	 * Automatically executed after the controller action. Can be used to apply
	 * transformation to the request response, add extra output, and execute
	 * other custom code.
	 *
	 */
	public function after()
	{
		// Set all template info
        if ($this->auto_render)
        {
            $this->_template['head'] = Template::instance()->head($this->_styles, $this->_scripts['head']);
            $this->_template['body_scripts'] = Template::instance()->body_scripts($this->_scripts['body']);
        }
        else if (Request::$is_ajax OR $this->request !== Request::instance())
        {
            // just show the content view
            $this->request->response = $this->_content;
        }

		parent::after();
    }
} // End Controller_Template_Base