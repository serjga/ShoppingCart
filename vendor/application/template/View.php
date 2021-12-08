<?php
namespace lib\template;

use lib\config\Config;
use lib\request\Request;
use lib\session\Session;

/**
 * Class View render templates
 *
 * @package lib\template
 */
class View
{
    /**
     * Page layout
     *
     * @var string
     */
    public $layout;

    /**
     * Path to page layout file
     *
     * @var string
     */
    public $layoutPath;

    /**
     * View constructor.
     * @param string $layout set page layout
     */
    function __construct(string $layout)
    {
        $this->layout = implode('/', explode('.', $layout));
    }

    /**
     * Render page
     *
     * @param string $templateRoute The page path is separated by dots
     * @param array $arguments php variables
     */
    public function render(string $templateRoute, array $arguments = [])
    {
        foreach($arguments as $var => $val) $$var = $val;

        $config = new Config("files");

        $templates = $config->get("templates");

        $page = implode('/', explode('.', $templateRoute));

        $this->layoutPath = $templates . "/". $this->layout . ".php";

        $path = $templates . "/". $page . ".php";

        if(file_exists($this->layoutPath)) {

            eval("?>\n" . preg_replace('/<content>(.*?)<\/content>/', file_get_contents($path), file_get_contents($this->layoutPath)));
        }
    }
}