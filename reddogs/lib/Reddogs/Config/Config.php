<?php

class Reddogs_Config_Config
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function merge(array $config)
    {
        $this->config = $this->mergeArrays($this->config, $config);
        return $this->config;
    }

    private function mergeArrays(array $base, array $merge)
    {
        foreach ($merge as $key => $value) {
        	if (is_int($key)) {
        		$base[] = $value;
        	} else {
	            if (array_key_exists($key, $base)) {
	                if (is_array($value)) {
	                    $base[$key] = $this->mergeArrays($base[$key], $merge[$key]);
	                } else {
	                    $base[$key] = $merge[$key];
	                }
	            } else {
	                $base[$key] = $value;
	            }
        	}
        }
        return $base;
    }
}