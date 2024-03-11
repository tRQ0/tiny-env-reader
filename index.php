<?php

namespace Utils;

/**
 * A simple laravel style .env reader
 * 
 * @return array
 */
class TinyEnvParser
{
    private string $_path;

    public $env;

    public function __construct(string $path)
    {
        $this->_path = $path;
        $this->_getEnv();
    }

    /**
     * Load environment file from the given path
     * and return an associative array of the env constants
     * as array keys
     * 
     * @param null
     * 
     * @return array
     */
    private function _getEnv()
    {

        $str = file_get_contents($this->_path);

        $str = explode("\n", $str);

        $env = [];
        foreach ($str as &$s) {
            $s = trim($s);

            if (empty($s) || $s[0] == '#') {
                $s = null;
                continue;
            }
            parse_str($s, $res);
            $env[] = $res;
        }
        $env = array_filter($env);

        $tmpArr = [];
        foreach ($env as &$value) {
            $tmpArr[array_key_first($value)] = $value[array_key_first($value)];
        }
        $env = $tmpArr;

        return $this->env = $env;
    }

    /**
     * Validates if the file path is valid
     * and file exists
     * 
     * @return \Utils\TinyEnvParser
     */
    private function _validateFile()
    {
        if (!file_exists($this->path)) {
            throw new \RunTimeException("File Error: '$path' not found");
        }

        if (!is_readable($this->path)) {
            throw new \RunTimeException("File Error: Unable to read '$path'. Check file permissions");
        }

        return $this;
    }
}
