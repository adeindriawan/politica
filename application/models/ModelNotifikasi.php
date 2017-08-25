<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelNotifikasi extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function gabung_notifikasi_dengan_nama_admin($limit, $offset, $id)
	{
		$this->db->select('notifikasi.*, admin.username_admin');
		$this->db->from('notifikasi');
		$this->db->where('notifikasi.untuk_id', $id);
		$this->db->where('notifikasi.status_notifikasi', 'Sent');
		$this->db->limit($limit, $offset);

		$this->db->join('admin', 'notifikasi.dari_id = admin.id_admin', 'left');

		return $this->db->get()->result_array();
	}

	public function ambil_notifikasi_untuk_staf_atau_admin($limit, $offset)
	{
		$this->db->select('notifikasi.*, admin.username_admin');
		$this->db->from('notifikasi');
		$this->db->where('notifikasi.untuk_id', NULL);
		$this->db->where('notifikasi.status_notifikasi', 'Sent');
		$this->db->limit($limit, $offset);

		$this->db->join('admin', 'notifikasi.dari_id = admin.id_admin', 'left');

		return $this->db->get()->result_array();
	}

}

/* End of file ModelNotifikasi.php */
/* Location: ./application/models/ModelNotifikasi.php */