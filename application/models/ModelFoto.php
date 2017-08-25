<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelFoto extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function gabung_album_dengan_nama_admin() // untuk fungsi Staf/data_album
	{
		$this->db->select('album.*, admin.id_admin, admin.username_admin');
		$this->db->from('album');

		$this->db->join('admin', 'album.id_admin = admin.id_admin', 'left');

		return $this->db->get();
	}

	public function gabung_album_dengan_foto($limit, $offset)
	{
		$this->db->select('album.*');
		$this->db->from('album');
		$this->db->order_by('tanggal_album', 'desc');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();

		$sql = array();
		foreach ($query->result_array() as $value) {
			$this->db->select('album.*, foto_album.*');
			$this->db->from('album');
			$this->db->where('album.id_album', $value["id_album"]);

			$this->db->join('foto_album', 'album.id_album = foto_album.id_album', 'left');
			$sql[] = $this->db->get()->result_array();
		}
		return $sql;
	}

	public function lihat_album_tertentu($id)
	{
		$this->db->select('album.*, foto_album.*')->from('album')->where('album.id_album', $id);
		$this->db->join('foto_album', 'album.id_album = foto_album.id_album', 'left');

		return $this->db->get()->result_array();
	}
}

/* End of file ModelFoto.php */
/* Location: ./application/models/ModelFoto.php */