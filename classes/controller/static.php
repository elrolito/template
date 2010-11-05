<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Controller_Static controller class
 *
 * @package    Template
 * @category   Controller
 * @author     Rolando Henry
 * @copyright (c) 2010 Rolando Henry
 * @license    http://creativecommons.org/licenses/BSD/
 */
class Controller_Static extends Controller_Template_Base {

    public function action_view()
    {
        $page = $this->request->param('page', Template::instance()->default_page());

        if (Kohana::find_file('views', 'pages/'.$page))
        {
            $this->template->title = ucwords(Inflector::humanize($page)).' | '.  Template::instance()->title();

            $this->_content = View::factory('pages/'.$page);
            
            $this->_get_meta($page);
        }
        
    }

    private function _get_meta($page)
    {
        // load config for current theme
        $meta = Kohana::config('static_page_meta.'.Template::$theme);

        // check for meta for current page
        if (isset($meta[$page]))
        {
            foreach ($meta[$page] as $key => $value)
            {
                if (preg_match('/description|keywords|robots/', $key))
                {
                    $this->_meta[$key] = $value;
                }
                else if ($key == 'title')
                {
                    // override default template title
                    $this->template->title = $value;
                }
            }
        }
    }
} // End Controller_Static