<?php

class Reddogs_DynamicSidebar
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

	public function __call($method, $params = array())
	{
		if (0 === strpos($method, 'dynamic_sidebar_')) {
		    $id = reddogs_dash_to_underscore(substr($method, 16));
			reddogs_dynamic_sidebar(substr($method, 16));
		}
	}
}