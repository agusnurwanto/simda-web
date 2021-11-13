<?php namespace Aksara\Modules\Administrative\Controllers\Connections;
/**
 * Administrative > Connections
 *
 * @author			Aby Dahana
 * @profile			abydahana.github.io
 * @website			www.aksaracms.com
 * @since			version 4.0.0
 * @copyright		(c) 2021 - Aksara Laboratory
 */
class Connections extends \Aksara\Laboratory\Core
{
	private $_table									= 'app__connections';
	
	function __construct()
	{
		parent::__construct();
		
		$this->restrict_on_demo();
		
		$this->set_permission(1);
		$this->set_theme('backend');
	}
	
	public function index()
	{
		$this->set_title(phrase('third_party_connections'))
		->set_icon('mdi mdi-power-plug')
		->unset_column('hostname, port, username, password, database_name, dsn')
		
		->add_action('option', 'connect', phrase('check_connection'), 'btn btn-success --xhr show-progress', 'mdi mdi-sync', array('year' => 'year', 'driver' => 'database_driver'))
		
		->set_field
		(
			array
			(
				'description'						=> 'textarea',
				'hostname'							=> 'encryption',
				'username'							=> 'encryption',
				'password'							=> 'encryption',
				'database_name'						=> 'encryption',
				'port'								=> 'encryption',
				'dsn'								=> 'encryption',
				'status'							=> 'boolean'
			)
		)
		->set_field
		(
			'database_driver',
			'dropdown',
			array
			(
				'MySQLi'							=> 'MySQLi',
				'SQLSRV'							=> 'Microsoft SQL Server',
				'Postgre'							=> 'PostgreSQL',
				'SQLite3'							=> 'SQLite',
				'pdo'								=> 'PDO ODBC'
			)
		)
		->set_relation
		(
			'year',
			'app__years.year',
			'{app__years.year AS year_label}',
			array
			(
				'app__years.status'					=> 1
			)
		)
		->field_position
		(
			array
			(
				'database_driver'					=> 2,
				'hostname'							=> 2,
				'port'								=> 2,
				'username'							=> 2,
				'password'							=> 2,
				'database_name'						=> 2,
				'dsn'								=> 2,
				'status'							=> 2
			)
		)
		->merge_field('hostname, port')
		->merge_field('username, password')
		->field_size
		(
			array
			(
				'hostname'							=> 'col-sm-8',
				'port'								=> 'col-sm-4',
				'username'							=> 'col-sm-6',
				'password'							=> 'col-sm-6'
			)
		)
		->set_validation
		(
			array
			(
				'year'								=> 'required',
				'name'								=> 'required'
			)
		)
		->set_alias
		(
			array
			(
				'year'								=> phrase('year'),
				'year_label'						=> phrase('year'),
				'name'								=> phrase('connection_name'),
				'description'						=> phrase('description'),
				'database_driver'					=> phrase('database_driver'),
				'username'							=> phrase('username'),
				'password'							=> phrase('password'),
				'database_name'						=> phrase('initial_database'),
				'dsn'								=> 'DSN untuk Koneksi Driver PDO ODBC'
			)
		)
		->render($this->_table);
	}
	
	public function connect()
	{
		$query										= $this->model->get_where
		(
			$this->_table,
			array
			(
				'year'								=> service('request')->getGet('year'),
				'database_driver'					=> service('request')->getGet('driver')
			),
			1
		)
		->row();

		// script ini untuk debug query di CI4
		// $query = $this->model->get_where(
		// 	$this->_table,
		// 	array(
		// 		'year'				=> service('request')->getGet('year'),
		// 		'database_driver'	=> service('request')->getGet('driver')
		// 	),
		// 	1
		// );
		// $q = $this->model->last_query();
		// $sql = $q->getQuery();
		// print_r($sql);
		// die($sql);
		
		if(empty($query))
		{
			return throw_exception(404, phrase('the_database_connection_is_not_found'));
		}
		
		$port = service('encrypter')->decrypt(base64_decode($query->port));
		if($port == '-')
		{
			$port = '';
		}

		$password = service('encrypter')->decrypt(base64_decode($query->password));
		if($password == '-')
		{
			$password = '';
		}

		$connection									= array
		(
			'DBDriver'								=> $query->database_driver,
			'dsn'									=> service('encrypter')->decrypt(base64_decode($query->dsn)),
			'hostname'								=> service('encrypter')->decrypt(base64_decode($query->hostname)),
			'port'									=> $port,
			'username'								=> service('encrypter')->decrypt(base64_decode($query->username)),
			'password'								=> $password,
			'database'								=> service('encrypter')->decrypt(base64_decode($query->database_name))
		);

		$this->connector							= $this->model->database_config($connection);
		// print_r($this->connector); die('tes2');
		
		if(!empty($this->connector->code))
		{
			return throw_exception(403, $this->connector['message']);
		}
		
		return throw_exception(200, phrase('the_database_was_successfully_connected'));
	}
}
