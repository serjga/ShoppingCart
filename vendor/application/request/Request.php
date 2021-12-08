<?php
namespace lib\request;

/**
 * Class Request
 *
 * @package lib\request
 */
class Request
{
    /**
     * $_GET parameters
     * @var array
     */
    protected $get = [];

    /**
     * $_POST parameters
     *
     * @var array
     */
    protected $post = [];

    /**
     * Request method
     *
     * @var string
     */
    protected $method;

    /**
     * Request scheme
     *
     * @var string HTTP or HTTPS
     */
    protected $scheme;

    /**
     * Host
     *
     * @var mixed
     */
    protected $host;

    /**
     * Port
     *
     * @var mixed|string
     */
    protected $port;

    /**
     * Url path
     *
     * @var mixed|string
     */
    protected $path;

    /**
     * Url parameters
     *
     * @var mixed|string
     */
    protected $query;

    /**
     * Url parameters array
     *
     * @var array|false|int|string|null
     */
    protected $parseUrl;

    /**
     * Request constructor.
     */
    function __construct()
    {
        $this->parseGet();

        $this->parsePost();

        $this->parseUrl = parse_url($_SERVER['REQUEST_URI']);

        $this->scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

        $this->host = $_SERVER['HTTP_HOST'];

        $this->port = $this->parseUrl['port']??'';

        $this->path = $this->parseUrl['path']??'';

        $this->query = $this->parseUrl['query']??'';

        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get request parameters
     *
     * @return array|false|int|string|null
     */
    public function request()
    {
        $this->serfHistory();

        $url = $_SERVER['REQUEST_URI'];

        $parts = parse_url($url);

        parse_str($parts['query'], $parts['query']);

        $parts['method'] = $_SERVER['REQUEST_METHOD'];

        return $parts;
    }

    /**
     * Save the history of visits
     */
    public function serfHistory()
    {
        $currentPage = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        if(!empty($_SESSION['current_page'])) $_SESSION['previews_page'] = $_SESSION['current_page'];

        $_SESSION['current_page'] = $currentPage;
    }

    /**
     * Parse $_GET parameters
     */
    protected function parseGet()
    {
        $url = $_SERVER['REQUEST_URI'];

        $parts = parse_url($url);

        $get = [];

        parse_str($parts['query'], $get);

        foreach($get as $name => $value)
        {
            $this->get[$name] = htmlspecialchars($value);
        }
    }

    /**
     * Get $_GET parameters
     */
    public function get():array
    {
        return $this->get;
    }

    /**
     * Parse $_POST parameters
     */
    protected function parsePost()
    {
        $this->post = $this->safeParameters($_POST);
    }

    /**
     * Get $_POST parameters
     */
    public function post(): array
    {
        return $this->post;
    }

    /**
     * Create safe parameters
     *
     * @param $parameters
     * @return array
     */
    protected function safeParameters($parameters): array
    {
        $result = [];

        foreach($parameters as $name => $value)
        {
            $result[$name] = htmlspecialchars(trim($value));
        }

        return $result;
    }

    /**
     * Get request method
     *
     * @return string
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * Get url path
     *
     * @return mixed|string
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * Get current url
     *
     * @return string
     */
    public function currentUrl()
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    /**
     * Create url
     * @param $url
     * @return string
     */
    public function createUrl($url)
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$url";
    }
}