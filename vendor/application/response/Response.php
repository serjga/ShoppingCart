<?php
namespace lib\response;

/**
 * Class Response
 *
 * @package lib\response
 */
class Response
{
    /**
     * Create success response
     *
     * @param array $data
     */
    public function success($data = [])
    {
        $result = (empty($data)) ? ['success' => 'ok'] : $data;

        print json_encode($result);
    }
}