<?php
class Config
{
    public $config = array();

    public function __construct($iniPath)
    {
        $ini = parse_ini_file($iniPath);
        if (!$ini) {
            throw new Exception('No valid config file found');
        }

        $this->config = $ini;
    }
}