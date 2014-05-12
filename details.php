<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_MySitemap extends Module {

	public $version = '1.0';

    public function __construct()
    {
        parent::__construct();

        $this->config->load('mysitemap/mysitemap');
        $this->template->active_section = 'mysitemap';
    }

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'MySitemap',
			),
			'description' => array(
				'en' => 'The mysitemap module creates an index of all pages.',
			),
			'frontend' => true,
			'backend' => false,
			'menu' => 'content'
		);
	}

	public function install()
	{
		return true;
	}

	public function uninstall()
	{
		return true;
	}

	public function upgrade($old_version)
	{
		return true;
	}
}