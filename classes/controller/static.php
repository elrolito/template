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

            $this->_content = View::factory('pages/'.$page);
        }
        
    }
} // End Controller_Static