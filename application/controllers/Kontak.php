<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Kontak extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Info');
		$this->load->library('Analitik');
	}

	public function index()
	{
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
		$data['alamat'] = $this->info->alamat();
		$data['kota'] = $this->info->kota();
		$data['kodepos'] = $this->info->kodepos();
		$data['telepon'] = $this->info->telepon();
		$data['email'] = $this->info->email();
		$this->load->view('frontend/beranda/kontak', $data);
	}

	public function atur_cookie()
	{
		$this->analitik->atur_cookie();
	}

}

/* End of file Kontak.php */
/* Location: ./application/controllers/Kontak.php */