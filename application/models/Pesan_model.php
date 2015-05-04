<?php 

class Pesan_model extends CI_Model
{
	public $page,$rows,$sort,$order,$nama;
	
	function __construct()
	{
		parent::__construct();
	}
	
	function getData()
	{
		$result = array();
		$items	= array();
		$offset = ($this->page-1)*$this->rows;
		$like	= array('nama'=>$this->nama);
		
		$sql				 = $this->db->like($like)->get('pesan');
		$result['total']	 = $sql->num_rows();
		$sql				 = $this->db->like($like)->order_by($this->sort,$this->order)->offset($offset)->limit($this->rows)->get('pesan');
		foreach($sql->result() as $row)
		{
			array_push($items,$row);
		}
		$result['rows'] = $items;
		return $result;
	}
	
	function simpan($data)
	{
		return $this->db->insert('pesan',$data);
	}
	
	function ubah($id,$data)
	{
		return $this->db->where('id',$id)->update('pesan',$data);
	}
	
	function hapus($id)
	{
		return $this->db->where('id',$id)->delete('pesan');
	}
}