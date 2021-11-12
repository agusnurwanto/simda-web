<?php namespace Modules\S\Controllers;
/**
 * S (stand for Shortlink)
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class S extends \Aksara\Laboratory\Core
{
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// get the existing link
		$query										= $this->model->get_where('app__shortlink', array('hash' => service('request')->uri->getSegment(2)), 1)->row();

		if($query)
		{
			// set the one time temporary session
			if(!get_userdata('is_logged'))
			{
				$session							= json_decode($query->session, true);
				$session['sess_destroy_after']		= 'once';

				set_userdata($session);
			}

			// redirect to real URL
			redirect()->to($query->url);
		}

		// existing link is not found, throw the exception
		return throw_exception(404, phrase('the_page_you_requested_does_not_exists'), base_url());
	}
}
