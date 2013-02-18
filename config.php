<?php
class Config
{
    private $config = array();

    public function __construct($iniPath)
    {
        $ini = parse_ini_file($iniPath);
        if (!$ini) {
            throw new Exception('No valid config file found');
        }

        $this->config = $ini;
    }

    public function get($var)
    {
        return isset($this->config[$var]) ? $this->config[$var] : null;
    }
}