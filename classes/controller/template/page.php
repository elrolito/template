<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Controller_Template_Page controller class
 *
 * @package    Template
 * @category   Controller
 * @author     Rolando Henry
 * @copyright (c) 2010 Rolando Henry
 * @license    http://creativecommons.org/licenses/BSD/
 */
class Controller_Template_Page extends Controller_Template_Base {

	/**
	 * Automatically executed before the controller action. Can be used to set
	 * class properties, do authorization checks, and execute other custom code.
	 *
	 */
	public function before()
	{
		// Before code here
		parent::before();

        // automatically set content view
        $this->_content = $this->_get_content();
	}

	/**
	 * Default action method for the controller
	 *
	 * @return  void
	 */
	public function action_index()
	{
		// Default action code here
		$this->template->title = ucfirst($this->request->controller).' | '.  Template::instance()->title();
	}

	/**
	 * Automatically executed after the controller action. Can be used to apply
	 * transformation to the request response, add extra output, and execute
	 * other custom code.
	 *
	 */
	public function after()
	{
		// After code here
		parent::after();
	}

    /**
     * Try to set template content to view based on controller and action
     *
     * @return view content based on controller
     */
    private function _get_content()
    {
        $directory = $this->request->directory;

        if ($directory != '')
            $directory .= '/';

        $controller = $this->request->controller;
        $action = $this->request->action;

        if (Kohana::find_file('views', 'pages/'.$directory.$controller.'/'.$action))
        {
            if ($action != 'index')
                $this->template->title = ucwords($action.' | '.$controller).' | '.Template::instance()->title();

            return View::factory('pages/'.$directory.$controller.'/'.$action);
        }
    }

} // End Controller_Template_Page