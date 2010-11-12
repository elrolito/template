<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Template_Core class
 *
 * @package    Template
 * @author     Rolando Henry
 * @copyright (c) 2010 Rolando Henry
 * @license    http://creativecommons.org/licenses/BSD/
 */
class Template_Core {

    /**
     * @var string default template theme
     */
    public static $theme = 'default';

    /**
     * @var object main template instance
     */
    public static $instances = array();

    /**
     * Get a singleton Template instance, a helper class for templating.
     *
     * @param string template theme name
     * @return Template
     */
    public static function instance($name = NULL, array $config = NULL)
    {
        if ($name === NULL)
        {
            // use default template theme
            $name = Template::$theme;
        }

        if ( ! isset(Template::$instances[$name]))
        {
            if ($config === NULL)
            {
                $config = Kohana::config('template')->$name;

                if (empty($config))
                {
                    throw new Template_Exception('Template theme :name not defined in Template configuration',
                        array(':name' => $name));
                }
            }

            // Create the new Template Theme
            new Template($name, $config);
        }

        return Template::$instances[$name];
    }

    /**
     * Check for the lame Internet Explorer, anything below version 9
     * add the html5 shiv if necessary
     *
     * @uses HTML::script
     * @return string
     */
    public static function ie_shiv()
    {
        $user_agent = Request::instance()->user_agent(array('browser', 'version'));

        if ($user_agent['browser'] === 'Internet Explorer' AND (int) $user_agent['version'] < 9)
        {
            return HTML::script('http://html5shiv.googlecode.com/svn/trunk/html5.js');
        }
    }

    /**
     * @var string instance name
     */
    protected $_instance;

    /**
     * @var array locally stored config array
     */
    protected $_config;

    protected function  __construct($name, array $config)
    {
        // Set the instance name
        $this->_instance = $name;

        // Store the config locally
        $this->_config = $config;

        // Store the template instance
        Template::$instances[$name] = $this;
    }

    /**
     * Get current theme config
     *
     * @return array config
     */
    public function config()
    {
        return $this->_config;
    }

    /**
     * Return regex list of static pages
     *
     * @return string
     */
    public function static_pages()
    {
        return $this->_config['pages']['regex'];
    }

    /**
     * Return the default staic page for root (/)
     *
     * @return string
     */
    public function default_page()
    {
        return $this->_config['pages']['default'];
    }

    /**
     * Return Template instance name
     *
     * @return string instance name
     */
    final public function __toString()
    {
        return $this->_instance;
    }
} // End Template_Core