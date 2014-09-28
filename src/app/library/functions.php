<?php

/**
 * @param string $str
 *
 * @return string
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * @return Phalcon\Config
 */
function get_config()
{
    static $config;
    if (is_null($config)) {
        $config = require APP_PATH . '/app/config/config.php';
    }

    return $config;
}

/**
 * @param bool $rtrim
 *
 * @return string
 */
function base_uri($rtrim = false)
{
    $config = get_config();
    if (!isset($config['application']['baseUri'])) {
        throw new \RuntimeException('baseUri is not set');
    }
    $base_uri = $config['application']['baseUri'];
    if (empty($base_uri) || $base_uri === '/') {
        return '';
    }
    if ($rtrim) {
        $base_uri = rtrim($base_uri, '/');
    }

    return $base_uri;
}
