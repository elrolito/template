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
        $page = $this->request->param('page');

        if (Kohana::find_file('views', 'pages/'.$page))
        {
            $this->template->title = ucfirst($page).' | '.  Template::instance()->title();

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
            }
        }
        /*
        if (isset($meta[$page]['description']))
        {
            $this->_meta['description'] = $meta[$page]['description'];
        }
        if (isset($meta[$page]['keywords']))
        {
            $this->_meta['keywords'] = $meta[$page]['keywords'];
        }
        if (isset($meta[$page]['robots']))
        {
            $this->_meta['robots'] = $meta[$page]['robots'];
        }
        */
    }
} // End Controller_Static