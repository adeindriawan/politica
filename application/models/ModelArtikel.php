<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelArtikel extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function gabung_empat_artikel_berita_terbaru_dengan_nama_penulisnya_untuk_halaman_beranda() //dipakai di Beranda/index
	{
		$this->db->select('artikel.*, admin.username_admin');
		$this->db->from('artikel');
		$this->db->where('artikel.jenis_artikel', 'Berita');

		$this->db->join('admin', 'artikel.id_penulis_artikel = admin.id_admin', 'left');
		$this->db->limit(3, 0);
		$this->db->order_by('tanggal_artikel', 'desc');

		return $this->db->get();
	}

	public function gabung_semua_artikel_berita_dengan_semua_nama_penulis($limit, $offset) //dipakai di Staf/data_berita
	{
		$this->db->select('artikel.id_artikel, artikel.judul_artikel, artikel.id_penulis_artikel, artikel.tanggal_artikel, artikel.status_artikel, admin.username_admin');
		$this->db->from('artikel');
		$this->db->where('artikel.jenis_artikel', 'Berita');

		$this->db->join('admin', 'artikel.id_penulis_artikel = admin.id_admin', 'left');
		$this->db->limit($limit, $offset);
		return $this->db->get();
	}

	public function gabung_semua_artikel_blog_dengan_semua_nama_penulis($limit, $offset) //dipakai di Guru/data_blog
	{
		$this->db->select('artikel.id_artikel, artikel.judul_artikel, artikel.id_penulis_artikel, artikel.tanggal_artikel, artikel.status_artikel, admin.username_admin');
		$this->db->from('artikel');
		$this->db->where('artikel.jenis_artikel', 'Blog');

		$this->db->join('admin', 'artikel.id_penulis_artikel = admin.id_admin', 'left');
		$this->db->limit($limit, $offset);
		return $this->db->get();
	}

	public function gabung_artikel_tertentu_dengan_tag_dirinya($id)//dipakai di Staf/edit_berita, Beranda/artikel
	{
		$this->db->select('tags_artikel.*, artikel.id_artikel, tags.*');
		$this->db->from('artikel');
		$this->db->where('artikel.id_artikel', $id);

		$this->db->join('tags_artikel', 'tags_artikel.id_artikel = artikel.id_artikel', 'left');
		$this->db->join('tags', 'tags_artikel.id_tag = tags.id_tag', 'left');

		$query = $this->db->get();

		return $query;
	}

	public function gabung_artikel_tertentu_dengan_nama_penulisnya($id)//dipakai di Beranda/artikel
	{
		$this->db->select('artikel.*, admin.username_admin');
		$this->db->from('artikel');
		$this->db->where('id_artikel', $id);

		$this->db->join('admin', 'artikel.id_penulis_artikel = admin.id_admin', 'left');

		return $this->db->get();
	}

	public function gabung_artikel_berita_dengan_nama_penulisnya_untuk_halaman_berita($limit, $offset)//dipakai di Beranda/berita
	{
		$this->db->select('artikel.*, admin.id_admin, admin.username_admin');
		$this->db->from('artikel');
		$this->db->where('artikel.jenis_artikel', 'Berita');

		$this->db->join('admin', 'artikel.id_penulis_artikel = admin.id_admin', 'left');

		$this->db->order_by('tanggal_artikel', 'desc');
		$this->db->limit($limit, $offset);
		return $this->db->get();
	}

	public function gabung_artikel_blog_dengan_nama_penulisnya_untuk_halaman_blog($limit, $offset)//dipakai di Beranda/blog
	{
		$this->db->select('artikel.*, admin.id_admin, admin.username_admin');
		$this->db->from('artikel');
		$this->db->where('artikel.jenis_artikel', 'Blog');
		$this->db->where('artikel.status_artikel', 'Published');

		$this->db->join('admin', 'artikel.id_penulis_artikel = admin.id_admin', 'left');

		$this->db->order_by('tanggal_artikel', 'desc');
		$this->db->limit($limit, $offset);
		return $this->db->get();
	}

	public function gabung_semua_artikel_dengan_nama_penulisnya_berdasarkan_kata_kunci($kata_kunci, $limit=NULL, $offset=NULL) // dipakai di Beranda/cari
	{
		$this->db->select('artikel.*, admin.username_admin');
		$this->db->from('artikel');

		$this->db->join('admin', 'admin.id_admin = artikel.id_penulis_artikel', 'left');

		$this->db->like('artikel.isi_artikel', $kata_kunci, 'both');
		$this->db->or_like('artikel.judul_artikel', $kata_kunci, 'both');

		$this->db->order_by('tanggal_artikel', 'desc');
		$this->db->limit($limit, $offset);
		return $this->db->get();
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi gabung_semua_artikel_blog_pending_dengan_semua_nama_penulis()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini mirip dengan fungsi gabung_semua_artikel_blog_dengan_semua_nama_penulis()
	| di atas yang digunakan pada fungsi Admin/data_blog, hanya saja fungsi ini ditambahkan where clause
	| tambahan untuk menyaring artikel yang berstatus pending.
	| 
	| Last edited: 2016-07-01 10:11
	*/

	public function gabung_semua_artikel_blog_pending_dengan_semua_nama_penulis($limit, $offset) //dipakai di Guru/data_blog
	{
		$this->db->select('artikel.id_artikel, artikel.judul_artikel, artikel.id_penulis_artikel, artikel.tanggal_artikel, artikel.status_artikel, admin.username_admin');
		$this->db->from('artikel');
		$this->db->where('artikel.jenis_artikel', 'Blog');
		$this->db->where('artikel.status_artikel', 'Pending');

		$this->db->join('admin', 'artikel.id_penulis_artikel = admin.id_admin', 'left');
		$this->db->limit($limit, $offset);
		return $this->db->get();
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi gabung_semua_newsletter_dengan_semua_nama_penulis()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini mirip dengan fungsi gabung_semua_artikel_berita_dengan_semua_nama_penulis()
	| di atas yang digunakan pada fungsi Admin/data_blog, hanya saja fungsi ini untuk newsletter
	| dan tidak ada where clause.
	| 
	| Last edited: 2016-07-02 12:14
	*/

	public function gabung_semua_newsletter_dengan_semua_nama_penulis($limit, $offset) //dipakai di Staf/data_berita
	{
		$this->db->select('newsletter.id_newsletter, newsletter.judul_newsletter, newsletter.id_penulis_newsletter, newsletter.tanggal_newsletter, newsletter.status_newsletter, admin.username_admin');
		$this->db->from('newsletter');

		$this->db->join('admin', 'newsletter.id_penulis_newsletter = admin.id_admin', 'left');
		$this->db->limit($limit, $offset);
		return $this->db->get();
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi ambil_artikel_paling_sering_dibaca()
	|--------------------------------------------------------------------------
	|
	| Fungsi tersebut mengambil 3 artikel dari tabel 'artikel' dengan field 'jumlah_view_artikel' yang paling banyak.
	| Fungsi ini dipakai di Beranda/populer_dibaca(). 
	|
	*/

	public function ambil_artikel_paling_sering_dibaca($limit, $offset)
	{
		$this->db->select('artikel.*')->from('artikel')->order_by('jumlah_view_artikel', 'desc');
		$this->db->limit($limit, $offset);
		return $this->db->get();
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi ambil_artikel_paling_sering_dikomentari()
	|--------------------------------------------------------------------------
	|
	| Fungsi tersebut mengambil 3 artikel dari tabel 'artikel' dengan jumlah komentar yang paling banyak.
	| Fungsi ini dipakai di Beranda/populer_dikomentari(). 
	|
	*/

	public function ambil_artikel_paling_sering_dikomentari($limit, $offset)
	{
		$this->db->select('artikel.*')->from('artikel')->order_by('jumlah_komentar', 'desc');
		$this->db->limit($limit, $offset);
		return $this->db->get();
	}

}

/* End of file  */
/* Location: ./application/models/ */