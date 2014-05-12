<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MySitemap extends Public_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('mysitemap_m');

	}

	private function flatten_mdarray( $set )
	{
		$rows = array();

		foreach ($set as $r)
		{
			if ( array_key_exists( 'children', $r ))
			{
				$c = $r['children'];
				unset($r['children']);
				$rows[] = $r;
				$rows = array_merge( $rows, $this->flatten_mdarray( $c ));
			}
			else
			{
				$rows[] = $r;
			}
		}
		
		return $rows;
	}

	public function index()
	{
		$links = array();

		/*
		 * If we are on the development environment,
		 * we should get rid of the cache.
		 */
		if ( ENVIRONMENT != PYRO_PRODUCTION )
		{
			$this->pyrocache->delete_all('mysitemap_m');
		}

		/*
		 * Lets replace the orginal model-call, with a cached call. We'll
		 * have it refresh itself every 24-hours.
		 * 
		 * 		$n = $this->mysitemap_m->get_page_tree();
		 */
		$n = $this->pyrocache->model('mysitemap_m', 'get_page_tree', array(), 7200);

		$pages = $this->flatten_mdarray( $n );
		$aliases = $this->config->item('mysitemap.aliases');
		$exclude = $this->config->item('mysitemap.exclude');
		foreach ($pages as $page)
		{
			if ( in_array( $page['uri'], $exclude )) continue;
			$links[$page['uri']] = @array_key_exists( $page['uri'], $aliases ) ? $aliases[$page['uri']] : $page['title'];
		}
		
		foreach ($this->config->item('mysitemap.insert') as $key => $value)
		{
			$i = array_search( $value['parent'], array_keys($links) );
			if ( $i )
			{
				$array_lead = array_slice( $links, 0, $i+1+$value['offset'] );
				$array_tail = array_slice( $links, $i+1+$value['offset'] );
				$array_lead[$key] = $value['title'];
				$links =  $array_lead + $array_tail;
			}
		}

		// var_dump( $array_lead );

		$this->template
			->title( 'Site Map' )
			->set('links', $links)
        	->build('index');
	}	
}