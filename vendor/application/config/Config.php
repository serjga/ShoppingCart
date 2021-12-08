<?php
namespace lib\config;

/**
 * Class Config for working with application configuration files.
 *
 * @package lib\config
 */
class Config
{
    /**
     * Configuration file data
     *
     * @var array
     */
    private $config = [];

    function __construct($configGroup)
    {
       if(file_exists(__DIR__ . "/../../../config/$configGroup.php"))
       {
           eval('$this->config = require(__DIR__ . "/../../../config/$configGroup.php");');
       }
    }

    /**
     * Get config value
     *
     * @param string $configPath can be specified using a point.
     * @return array|string
     */
    public function get(string $configPath)
    {
        $arrConfig = explode(".", $configPath);
        return $this->search($arrConfig, $this->config);
    }

    /**
     * Search config in array data
     *
     * @param $stack
     * @param $arr
     * @return array|mixed|string
     */
    private function search($stack, $arr)
    {
        $searchKey = array_shift($stack);

        if(is_array($arr))
        {
            foreach($arr as $configKey => $valConfig)
            {
                if($configKey === $searchKey)
                {
                    if(is_array($valConfig) && count($stack) > 0) return $this->search($stack, $valConfig);

                    else return $valConfig;
                }
            }
        }

        return '';
    }
}
