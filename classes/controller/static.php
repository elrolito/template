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

        if (Kohana::find_file('views', 'pages/static/'.$page))
        {
            $this->template->title = ucfirst($page).' | '.  Template::instance()->title();

            $this->_content = View::factory('pages/static/'.$page);

            $this->_get_meta($page);
        }
        
    }

    private function _get_meta($page)
    {
        // load config for current theme
        $meta = Kohana::config('static_page_meta.'.Template::$theme);

        // check for meta for current page
        if (isset($meta[$page]['description']))
        {
            $this->_meta['description'] = $meta[$page]['description'];
        }
        if (isset($meta[$page]['keywords']))
        {
            $this->_meta['keywords'] = $meta[$page]['keywords'];
        }
    }
} // End Controller_Static