<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Berita extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ModelArtikel');
		$this->load->model('FrontendArtikel');
		$this->load->model('ModelFoto');
		$this->load->model('ModelTag');
		$this->load->library('Analitik');
		$this->load->library('Info');
	}

	public function index()
	{
		$this->atur_cookie();
		$this->db->select('artikel.id_artikel');
		$this->db->where('artikel.jenis_artikel', 'Berita');
		$this->db->from('artikel');
		$num = $this->db->count_all_results();

		$this->load->library('pagination');
		$config['base_url'] = site_url('berita/index');
		
		$config['total_rows'] = $num;
		$config['per_page'] = 6;
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;

		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';

		$config['num_tag_open']  = '<li>';
		$config['num_tag_close']  = '</li>';

		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['prev_link'] = '&larr; Prev';
		$config['next_link'] = 'Next &rarr;';

		$config['first_tag_open'] = "<li>";
		$config['first_tag_close'] = "</li>";
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';


		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		
		$config['prev_tag_open'] = '<li><a class="prevpostslink">';
		$config['prev_tag_close'] = '</a></li>';

		$config['cur_tag_open'] = "<li class='current'><a class='nextpostslink'>";
		$config['cur_tag_close'] = "</a></li>";
		
		$this->pagination->initialize($config);
		
		$data['data1'] = $this->FrontendArtikel->gabung_artikel_dengan_kategorinya($config['per_page'], ($this->uri->segment(3)) ? $this->uri->segment(3) : 0)->result_array();
		$data['data2'] = $this->pagination->create_links();

		$info['nama'] = $this->info->nama_situs();
		$info['tagline'] = $this->info->tagline_situs();

		$info['alamat'] = $this->info->alamat();
		$info['kota'] = $this->info->kota();
		$info['kodepos'] = $this->info->kodepos();
		$info['telepon'] = $this->info->telepon();
		$info['email'] = $this->info->email();
		$info['facebook'] = $this->info->facebook();
		$info['twitter'] = $this->info->twitter();
		$info['instagram'] = $this->info->instagram();
		$info['youtube'] = $this->info->youtube();

		$data['header'] = $this->load->view('frontend/beranda/include/header', $info, TRUE);
		$data['footer'] = $this->load->view('frontend/beranda/include/footer', $info, TRUE);

		$this->load->view('frontend/beranda/berita', $data);
	}

	public function atur_cookie()
	{
    	$this->analitik->atur_cookie();
	}

	public function artikel($id, $slug=NULL)
	{
		$this->atur_cookie();
		$data['data1'] = $this->ModelArtikel->gabung_artikel_tertentu_dengan_nama_penulisnya($id)->result_array();
		$data['data2'] = $this->ModelArtikel->gabung_artikel_tertentu_dengan_tag_dirinya($id)->result_array();
		$this->db->select('komentar.*');
		$this->db->from('komentar');
		$this->db->where('id_artikel', $id);
		$this->db->order_by('tanggal_komentar', 'desc');
		$data['data3'] = $this->db->get();
		$this->tambah_jumlah_baca($id);

		$data['data4'] = $this->jumlah_komentar($id);
		$data['data5'] = $this->FrontendArtikel->gabung_artikel_tertentu_dengan_kategorinya($id)->result_array();

		$pop['dibaca'] = $this->populer_dibaca();
		$pop['dikomentari'] = $this->populer_dikomentari();

		$data['populer_dibaca'] = $this->load->view('frontend/beranda/populer_dibaca', $pop, TRUE);
		$data['populer_dikomentari'] = $this->load->view('frontend/beranda/populer_dikomentari', $pop, TRUE);

		$info['nama'] = $this->info->nama_situs();
		$info['tagline'] = $this->info->tagline_situs();

		$info['alamat'] = $this->info->alamat();
		$info['kota'] = $this->info->kota();
		$info['kodepos'] = $this->info->kodepos();
		$info['telepon'] = $this->info->telepon();
		$info['email'] = $this->info->email();
		$info['facebook'] = $this->info->facebook();
		$info['twitter'] = $this->info->twitter();
		$info['instagram'] = $this->info->instagram();
		$info['youtube'] = $this->info->youtube();

		$data['header'] = $this->load->view('frontend/beranda/include/header', $info, TRUE);
		$data['footer'] = $this->load->view('frontend/beranda/include/footer', $info, TRUE);
		$this->load->view('frontend/beranda/artikel', $data);
	}

	public function jumlah_komentar($id)
	{
		$this->db->select('komentar.id_komentar');
		$this->db->from('komentar');
		$this->db->where('komentar.id_artikel', $id);

		return $this->db->count_all_results();
	}

	public function tambah_jumlah_baca($id)
	{
		$this->db->select('artikel.id_artikel, artikel.jumlah_view_artikel');
		$this->db->from('artikel');
		$this->db->where('artikel.id_artikel', $id);

		$query = $this->db->get()->result_array();

		$tambah_jumlah = array(
			'jumlah_view_artikel' => $query[0]['jumlah_view_artikel'] + 1,
		);

		$this->db->update('artikel', $tambah_jumlah, array('id_artikel' => $id));
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi populer_dibaca()
	|--------------------------------------------------------------------------
	|
	| Fungsi populer_dibaca() di bawah ini adalah untuk menampilkan 
	| artikel-artikel yang paling sering dibaca.
	| Untuk penyederhanaan, dipilih 3 artikel yang paling sering dibaca. 
	|
	*/
	
	public function populer_dibaca()
	{
		$limit = 3;
		$offset = 0;
		return $this->ModelArtikel->ambil_artikel_paling_sering_dibaca($limit, $offset);
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi populer_dikomentari()
	|--------------------------------------------------------------------------
	|
	| Fungsi populer_dikomentari() di bawah ini adalah untuk menampilkan 
	| artikel-artikel yang paling banyak mendapat komentar.
	| Untuk penyederhanaan, dipilih 3 artikel yang paling banyak mendapat komentar. 
	|
	*/

	public function populer_dikomentari()
	{
		$limit = 3;
		$offset = 0;
		return $this->ModelArtikel->ambil_artikel_paling_sering_dikomentari($limit, $offset);
	}

}

/* End of file Berita.php */
/* Location: ./application/controllers/Berita.php */