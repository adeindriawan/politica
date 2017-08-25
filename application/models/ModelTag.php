<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelTag extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function search_tag($id, $limit, $offset)
	{
		$this->db->select('artikel.*, tags_artikel.*, tags.*, admin.username_admin');
		$this->db->from('tags_artikel');
		$this->db->where('tags_artikel.id_tag', $id);

		$this->db->join('artikel', 'artikel.id_artikel = tags_artikel.id_artikel', 'left');
		$this->db->join('tags', 'tags.id_tag = tags_artikel.id_tag', 'left');
		$this->db->join('admin', 'admin.id_admin = artikel.id_penulis_artikel', 'left');

		$this->db->order_by('tanggal_artikel', 'desc');
		$this->db->limit($limit, $offset);
		return $this->db->get();
	}

}

/* End of file ModelTag.php */
/* Location: ./application/models/ModelTag.php */