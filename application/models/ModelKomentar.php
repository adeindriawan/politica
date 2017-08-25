<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelKomentar extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function hitung_jumlah_komentar_dalam_satu_artikel($id) //dipakai di mana ya???
	{
		$this->db->select('komentar.id_komentar');
		$this->db->from('komentar');
		$this->db->where('komentar.id_artikel', $id);

		return $this->db->count_all_results();
	}

}

/* End of file ModelKomentar.php */
/* Location: ./application/models/ModelKomentar.php */