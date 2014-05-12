<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['mysitemap.aliases']	=	array(         
		'home'					=> 'Home',
		'units'					=> 'Units',
		'training'				=> 'Training',
		'funding'				=> 'Funding',
		'media'					=> 'Media'
	);

$config['mysitemap.insert']		= array(
		'training/exams'		=> array('title' => 'Online Exams', 'parent' => 'training', 'offset' => 1),
		'blog'					=> array('title' => 'Blog', 'parent' => 'calendar', 'offset' => 0)
	);

$config['mysitemap.exclude']	= array(
		'rad'
	);

