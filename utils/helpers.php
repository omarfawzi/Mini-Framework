<?php
/** @var array $config */
global $config;
$config = require_once("../config/config.php");
if (!defined('config')) {
    function config(string $domain, ...$keys)
    {
        $domainConfig = $GLOBALS['config'][$domain];
        foreach ($keys as $key) {
            $domainConfig = $domainConfig[$key];
        }

        return $domainConfig;
    }
}
