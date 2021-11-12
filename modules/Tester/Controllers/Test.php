<?php namespace Modules\Tester\Controllers;

class Test extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$custom = [
		    'DSN'      => '',
			'hostname' => '103.119.138.1',
			'username' => 'simdabpkp',
			'password' => 'RemoteAc3',
			'database' => 'Simkeu_Ktbks_2021_dummy',
			'DBDriver' => 'SQLSRV',
			'DBPrefix' => '',
			'pConnect' => false,
			'DBDebug'  => (ENVIRONMENT !== 'production'),
			'charset'  => 'utf8',
			'DBCollat' => 'utf8_general_ci',
			'swapPre'  => '',
			'encrypt'  => false,
			'compress' => false,
			'strictOn' => false,
			'failover' => [],
			'port'     => 1433,
		];
		$db = \Config\Database::connect($custom);
		print_r($db);exit;
		$query										= $db->query
		(
			'BEGIN SET NOCOUNT ON EXEC RptLRA_SumberDana ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? END',
			array
			(
				2021,
				1,
				1,
				1,
				1,
				'',
				'',
				'',
				4,
				'2021-01-01',
				'2021-12-31'
			)
		)
		->getResult();
		
        print_r($query); exit;
	}
}
