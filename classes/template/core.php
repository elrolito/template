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
                $config = Kohana::config('template.'.$name);

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
     * Return Template instance name
     *
     * @return string instance name
     */
    final public function __toString()
	{
		return $this->_instance;
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
     * Return the default template title for site
     *
     * @return string title
     */
    public function title($page_title = null, $use_uppercase = false)
    {
        if ($page_title === null)
            return $this->_config['title'];
        else
        {
            $title = $page_title.$this->_config['title'];
            return $use_uppercase ? strtoupper($title) : ucwords($title);
        }
    }

    /**
     * Creates HTML links for css and scripts
     *
     * @uses HTML::style
     * @uses HTML::script
     * @param array additional styles to add
     * @param array additional scripts to add
     * @return string stylesheets and scripts for head
     */
    public function head(array $additional_styles = NULL, array $additional_scripts = NULL)
    {
        $style_html = '';
        $script_html = '';

        // merge page styles to template styles if passed
        if ( ! empty($additional_styles) AND Arr::is_assoc($additional_styles))
            $styles = Arr::merge($this->_config['styles'], $additional_styles);
        else
            $styles = $this->_config['styles'];

        foreach ($styles as $file => $media)
        {
            $style_html .= HTML::style($file, array('media' => $media))."\r\n\t\t";
        }

        // merge page scripts to template scripts if passed
        if ( isset($additional_scripts['top']) AND ! empty($additional_scripts['top']))
            $scripts = Arr::merge ($this->_config['scripts']['top'], $additional_scripts);
        else
            $scripts = $this->_config['scripts']['top'];

        foreach ($scripts as $file)
        {
            $script_html .= HTML::script($file)."\r\n\t\t";
        }

        $this->_head_html = $style_html.$script_html;

        return $this->_head_html;
    }

    /**
     * Create HTML scripts for use at the bottom, just before </body>
     *
     * @uses HTML::script
     * @param array additional scripts to add
     * @return string scripts for bottom of body
     */
    public function body_scripts(array $additional_scripts = NULL)
    {
        $script_html = '';

        // merge page scripts to template scripts if passed
        if ( isset($additional_scripts['bottom']) AND ! empty($additional_scripts['bottom']))
            $scripts = Arr::merge ($this->_config['scripts']['bottom'], $additional_scripts);
        else
            $scripts = $this->_config['scripts']['bottom'];

        foreach ($scripts as $file)
        {
            $script_html .= HTML::script($file)."\r\n\t\t";
        }

        return $script_html;
    }
} // End Template_Core