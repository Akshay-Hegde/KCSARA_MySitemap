<?php defined('BASEPATH') or exit('No direct script access allowed');

class MySitemap_m extends MY_Model {

	public function get_page_tree()
	{
		$all_pages = $this->db
			->select('id, parent_id, title, status, uri')
			->where('status','live')
			->order_by('`order`')
			->get('pages')
			->result_array();

		// First, re-index the array.
		foreach ($all_pages as $row)
		{
			$pages[$row['id']] = $row;
		}

		unset($all_pages);

		// Build a multidimensional array of parent > children.
		foreach ($pages as $row)
		{
			if (array_key_exists($row['parent_id'], $pages))
			{
				// Add this page to the children array of the parent page.
				$pages[$row['parent_id']]['children'][] =& $pages[$row['id']];
			}

			// This is a root page.
			if ($row['parent_id'] == 0)
			{
				$page_array[] =& $pages[$row['id']];
			}
		}
		
		/*
			// 1. Place all of the root pages into a separate array.
			// 1a. Remove the root pages from this array.
			// 2. Place pages in the current order, into the new array, following their parent.
			
		*/

		unset($pages);

		return $page_array;
	}

}