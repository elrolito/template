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

    public function before()
    {
        parent::before();

        if ($this->auto_render)
        {
            $this->template->content = $this->_get_view();
        }
    }

    public function action_static()
    {
        $page = $this->request->param('page', 'home');

        $this->template->title = ucwords(Inflector::humanize($page)).' | '.$this->template->title;

        $this->_get_meta($page);
    }

    /**
     * Try to set template content to view based on request
     *
     * @return view content
     */
    protected function _get_view()
    {
        $directory = $this->request->directory;

        if ($directory != '')
            $directory .= '/';

        $controller = $this->request->controller;
        $action = $this->request->action;

        if ($action != 'static')
            $view_file = $directory.$controller.'/'.$action;
        else
            $view_file = $this->request->param('page', 'home');

        if (Kohana::find_file('views', 'pages/'.$view_file))
        {
            return View::factory('pages/'.$view_file);
        }
    }

    private function _get_meta($page)
    {
        // load config for current theme
        $meta = Kohana::config('static_page_meta');

        // check for meta for current page
        if (isset($meta[$page]))
        {
            foreach ($meta[$page] as $key => $value)
            {
                if (preg_match('/description|keywords|robots/', $key))
                {
                    $this->template->meta[$key] = $value;
                }
                else if ($key == 'title')
                {
                    // override default template title
                    $this->template->title = $value;
                }
            }
        }
    }
} // End Controller_Template_Page