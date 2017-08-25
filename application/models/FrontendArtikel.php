<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	|--------------------------------------------------------------------------
	| Model FrontendArtikel
	|--------------------------------------------------------------------------
	|
	| Model ini dibuat untuk menangani query yang berkaitan dengan artikel yang
	| yang akan digunakan untuk tampilan frontend. Karena setiap template mem-
	| punyai karakteristik yang berbeda-beda, maka isi dari model ini akan berbeda
	| di setiap template. Oleh karena itu, dibuat adanya pemisahan file model yang
	| khusus untuk menangani tampilan frontend dan untuk tampilan backend.
	| 
	| Last edited: 2016-07-13 16:50
*/
class FrontendArtikel extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	/*
		|--------------------------------------------------------------------------
		| Fungsi gabung_artikel_dengan_kategorinya($limit, $offset)
		|--------------------------------------------------------------------------
		|
		| Fungsi inidipakai di Beranda/index.
		| 
		| Last edited: 2016-07-13 16:50
	*/

	public function gabung_artikel_dengan_kategorinya($limit, $offset)
	{
		$this->db->select('artikel.*, kategori.kategori');
		$this->db->from('artikel');
		$this->db->where('artikel.jenis_artikel', 'Berita');

		$this->db->join('kategori', 'artikel.id_kategori = kategori.id_kategori', 'left');
		$this->db->order_by('tanggal_artikel', 'desc');
		$this->db->limit($limit, $offset);

		return $this->db->get();
	}

	/*
		|--------------------------------------------------------------------------
		| Fungsi gabung_artikel_tertentu_dengan_kategorinya($id)
		|--------------------------------------------------------------------------
		|
		| Fungsi inidipakai di Beranda/index.
		| 
		| Last edited: 2016-07-13 16:50
	*/

	public function gabung_artikel_tertentu_dengan_kategorinya($id)
	{
		$this->db->select('artikel.*, kategori.kategori');
		$this->db->from('artikel');
		$this->db->where('id_artikel', $id);

		$this->db->join('kategori', 'artikel.id_kategori = kategori.id_kategori', 'left');
		return $this->db->get();
	}

}

/* End of file FrontendArtikel.php */
/* Location: ./application/models/FrontendArtikel.php */