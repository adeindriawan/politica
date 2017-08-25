<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Galeri extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ModelArtikel');
		$this->load->model('ModelFoto');
		$this->load->model('ModelTag');
		$this->load->library('Analitik');
		$this->load->library('Info');
		$this->load->library('Notifikasi');
	}

	public function index()
	{
		$this->atur_cookie();
		$this->db->select('album.id_album');
		$this->db->from('album');
		$num = $this->db->count_all_results();

		$this->load->library('pagination');
		$config['base_url'] = site_url('galeri/index');
		
		$config['total_rows'] = $num;
		$config['per_page'] = 1;
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;

		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';

		$config['num_tag_open']  = '<li>';
		$config['num_tag_close']  = '</li>';

		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['prev_link'] = 'Prev';
		$config['next_link'] = 'Next';

		$config['first_tag_open'] = "<li>";
		$config['first_tag_close'] = "</li>";
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';


		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = "<li class='current'><a class='nextpostslink'>";
		$config['cur_tag_close'] = "</a></li>";
		
		$this->pagination->initialize($config);
		
		$data['data2'] = $this->pagination->create_links();
		$data['data1'] = $this->ModelFoto->gabung_album_dengan_foto($config['per_page'], ($this->uri->segment(3)) ? $this->uri->segment(3) : 0);

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
		$this->load->view('frontend/beranda/galeri', $data);
	}

	public function atur_cookie()
	{
    	$this->analitik->atur_cookie();
	}

	public function album($id, $slug=NULL)
	{
		$this->atur_cookie();
		$data['data1'] = $this->ModelFoto->lihat_album_tertentu($id);
		$this->db->select('komentar.*');
		$this->db->from('komentar');
		$this->db->where('id_album', $id);
		$this->db->order_by('tanggal_komentar', 'desc');
		$data['data2'] = $this->db->get();

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

		$this->load->view('frontend/beranda/album', $data);
	}

}

/* End of file Galeri.php */
/* Location: ./application/controllers/Galeri.php */