<?php namespace Modules\Search\Controllers;
/**
 * Search
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Search extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();
		
		if('autocomplete' == service('request')->getPost('method'))
		{
			return $this->_autocomplete();
		}
	}
	
	public function index()
	{
		$this->set_title('Search')
		->set_icon('mdi mdi-magnify')
		->set_description('Search result for ' . htmlspecialchars((service('request')->getGet('q') ? service('request')->getGet('q') : 'all')))
		->select
		('
			ref__sekolah.id,
			ref__sekolah.sekolah,
			ta__detail_sekolah.alamat,
			ta__detail_sekolah.status,
			ta__detail_sekolah.akreditasi
		')
		->join
		(
			'ta__detail_sekolah',
			'ta__detail_sekolah.id_sekolah = ref__sekolah.id',
			'left'
		)
		->like('ref__sekolah.sekolah', service('request')->getGet('q'))
		->render('ref__sekolah');
	}
	
	public function _autocomplete()
	{
		$query										= $this->model->select
		('
			ref__sekolah.id,
			ref__sekolah.sekolah,
			ta__detail_sekolah.alamat
		')
		->join
		(
			'ta__detail_sekolah',
			'ta__detail_sekolah.id_sekolah = ref__sekolah.id',
			'left'
		)
		->like('ref__sekolah.sekolah', service('request')->getPost('q'))
		->get_where
		(
			'ref__sekolah',
			array
			(
				'ref__sekolah.sekolah != '			=> null
			)
		)
		->result();
		
		$suggestions								= array();
		
		if($query)
		{
			foreach($query as $key => $val)
			{
				$suggestions[]						= array
				(
					'label'							=> $val->sekolah,
					'value'							=> $val->sekolah,
					'target'						=> base_url('search/' . $val->id),
					'description'					=> $val->alamat
				);
			}
		}
		
		return make_json
		(
			array
			(
				'suggestions'						=> ($suggestions ? $suggestions : null)
			)
		);
	}
}
