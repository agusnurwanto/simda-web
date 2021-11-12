<?php namespace Modules\Home\Controllers;
/**
 * Welcome Page
 * The default landing page of default routes. This module is override the
 * original source in the application folder.
 *
 * @version			2.1.0
 * @author			Aby Dahana
 * @profile			abydahana.github.io
 */
class Home extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->set_title(phrase('welcome'))
		->set_description(get_setting('app_description'))
		->set_output
		(
			array
			(
				/* get highlighed articles */
				'spotlight'							=> $this->_get_spotlight(),
				
				/* get the latest galleries */
				'galleries'							=> $this->_get_galleries(),
				
				/* get the latest peoples */
				'latest_peoples'					=> $this->model->get_where
				(
					'peoples',
					array
					(
						'status'					=> 1
					),
					4
				)
				->result(),
				
				'testimonials'						=> $this->model->get_where
				(
					'testimonials',
					array
					(
						'status'					=> 1
					)
				)
				->result()
			)
		)
		->render();
	}
	
	private function _get_spotlight()
	{
		$query										= $this->model->select
		('
			blogs.post_id,
			blogs.post_slug,
			blogs.post_title,
			blogs.post_excerpt,
			blogs.featured_image,
			blogs.updated_timestamp,
			blogs__categories.category_title,
			blogs__categories.category_slug,
			app__users.username,
			app__users.first_name,
			app__users.last_name,
			app__users.photo
		')
		->join
		(
			'blogs__categories',
			'blogs__categories.category_id = blogs.post_category'
		)
		->join
		(
			'app__users',
			'app__users.user_id = blogs.author'
		)
		->order_by('updated_timestamp', 'DESC')
		->get_where
		(
			'blogs',
			array
			(
				'blogs.status'						=> 1,
				'blogs.headline'					=> 1
			),
			9
		)
		->result();
		
		$output										= array();
		
		if($query)
		{
			foreach($query as $key => $val)
			{
				$output[]							= $val;
			}
		}
		
		return $output;
	}
	
	private function _get_galleries()
	{
		$query										= $this->model->get_where
		(
			'galleries',
			array
			(
				'status'							=> 1
			),
			4
		)
		->result();
		
		return $query;
	}
}
