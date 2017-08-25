<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelKategori extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function hitung_jumlah_artikel_perkategori($limit, $offset) //dipakai di Admin/data-kategori
	{
		$query = $this->db->get('kategori', $limit, $offset)->result_array();

		foreach ($query as $key => $value) {
			$jumlah = $this->db->select('artikel.id_artikel')->from('artikel')->where('artikel.id_kategori', $value['id_kategori'])->count_all_results();

			$query[$key]['jumlah_artikel'] = $jumlah;
		}

		return $query;
	}

	public function cari_kategori($id, $limit, $offset) // dipakai di Beranda/cari_kategori
	{
		$this->db->select('artikel.*, kategori.*, admin.username_admin');
		$this->db->from('kategori');
		$this->db->where('kategori.id_kategori', $id);

		$this->db->join('artikel', 'artikel.id_kategori = kategori.id_kategori', 'left');
		$this->db->join('admin', 'admin.id_admin = artikel.id_penulis_artikel', 'left');

		$this->db->order_by('tanggal_artikel', 'desc');
		$this->db->limit($limit, $offset);
		$query = $this->db->get()->result_array();

		foreach ($query as $key => $value) {
			$this->db->select('komentar.id_komentar');
			$this->db->from('komentar');
			$this->db->where('komentar.id_artikel', $value['id_artikel']);

			$query[$key]['jumlah_komentar'] = $this->db->count_all_results();
		}

		return $query;
	}

}

/* End of file ModelKategori.php */
/* Location: ./application/models/ModelKategori.php */