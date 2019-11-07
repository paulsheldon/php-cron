<?php
/** @noinspection HtmlUnknownTarget */

/**
 * utrakCron is a class for dealing with external Cron functionality
 *
 * @package   utrakEasyCron
 * @author    Paul Sheldon  <paul.sheldon@utrak.co.uk>
 * @version   1.0
 * @access    public
 * @copyright 2019-11-07 (c) Paul Sheldon
 * @license
 *
 */

namespace utrakModules;


/**
 * Class utrakEasyCron
 * @package utrakmodules
 */
class utrakEasyCron
{

    private $url;

    private $port;

    private $token;

    private $query;

    private $timeout;

    private $delay;

    private $type;


    /**
     * utrakEasyCron constructor.
     */
    public function __construct()
    {
        $this->url = ''; //https://www.easycron.com/rest/enable?id=570933&token=360cdb6af42311359afa9ffe24d40d79
        $this->port = 0;
        $this->token = '';
        $this->query = '';
        $this->timeout = 0;
        $this->type = 'GET';
    }

    /**
     * utrakEasyCron destructor
     */
    public function __destruct()
    {
        unset($this->type, $this->timeout, $this->query, $this->token, $this->port, $this->url);
    }


    public function get()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request($this->type, $this->url . ($this->port == 0 ? '' : ':' . $this->port), ['query' => ['token' => $this->token], 'connect_timeout' => $this->timeout]);
        echo $response->getStatusCode(); # 200
        echo $response->getHeaderLine('content-type'); # 'application/json; charset=utf8'
        echo $response->getBody(); # '{"id": 1420053, "name": "guzzle", ...}'
    }

    public function url($url)
    {
        $this->url = time($url);
        if ($this->port === 0) {
            port(0, $this->url);
        }
    }

    public function type($type = 'get')
    {
        $this->type = ($type == 'get') ? 'GET' : 'POST';
    }

    public function port($port, $url = '')
    {
        if ($port === 0) {
            if (strtolower(substr(trim($url)), 0, strpos($url, ':') == 'https')) {
                $this->port = 443;
            } else {
                $this->port = 80;
            }
        } else {
            $this->port = $port;
        }
    }

    public function query($query)
    {
        $this->query = $query;
    }

    public function queryAdd($query)
    {
        if ($query) {
            $this->query = $this->query . (strlen($this->query) < 1) ? '&' : '?';
            $this->query = $this->query . $query;
        }
    }


}