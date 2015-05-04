<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	function __construct()
	{
		parent::__construct();
		$this->load->model('pesan_model','pesan');
	}
	
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	function data()
	{
		$pesan = $this->pesan;
		
		$pesan->page	= Request::post('page','int',1);
		$pesan->rows	= Request::post('rows','int',20);
		$pesan->sort	= Request::post('sort','string','nama');
		$pesan->order	= Request::post('order','string','asc');
		$pesan->nama	= Request::post('nama','upper');
		
		$data = $pesan->getData();
		echo json_encode($data);
	}
	
	function crud($action)
	{
		$id  		= Request::post('id','int',0);
		$nama		= Request::post('nama','upper');
		$alamat		= Request::post('alamat','string');
		$no_telp	= Request::post('no_telp','string');
		$email		= Request::post('email','string');
		$jekel		= Request::post('jenis_kelamin','upper');
		$pesan		= Request::post('pesan','string');
		
		$data		= array(
						'nama'			=>$nama,
						'alamat'		=>$alamat,
						'no_telp'		=>$no_telp,
						'email'			=>$email,
						'jenis_kelamin'	=>$jekel,
						'pesan'			=>$pesan,
					);
		if ($action == 'simpan')
		{
			$sql	= $this->pesan->simpan($data);
		}
		else
		{
			if ($action == 'ubah')
			{
				$sql = $this->pesan->ubah($id,$data);
			}
			else
			{
				$sql = $this->pesan->hapus($id);
			}
		}
		
		if ($sql)
		{
			echo 'success';
		}
		else
		{
			echo 'gagal';
		}
	}
}
