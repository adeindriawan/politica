<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Info {
	var $CI;
	var $nav;
	var $incNav;
	var $menu;
	var $incMenu;
	
	function __construct()
	{
		$this->CI =& get_instance();

        $this->CI->load->database();
        $this->CI->load->library('session');

        $this->nav = array(
			"notif" => $this->CI->analitik->daftar_notifikasi(),
			"review" => $this->CI->analitik->review_artikel(),
			"pesan" => $this->CI->analitik->review_pesan(),
			"nama" => $this->nama_situs(),
		);

		$this->incNav = $this->CI->load->view('backend/dashboard/include/nav', $this->nav, TRUE);

		$this->menu = array();

		$this->incMenu = $this->CI->load->view('backend/dashboard/include/menu', $this->menu, TRUE);
	}

	public function nama_situs()
	{
		$file = base_url() . 'info.json';
		$content = file_get_contents($file);
		$json = json_decode($content, TRUE);
		$nama_situs = $json['name'];
		
		return $nama_situs;
	}

	public function tagline_situs()
	{
		$file = base_url() . 'info.json';
		$content = file_get_contents($file);
		$json = json_decode($content, TRUE);
		$tagline_situs = $json['tagline'];

		return $tagline_situs;
	}

	public function alamat()
	{
		$file = base_url() . 'info.json';
		$content = file_get_contents($file);
		$json = json_decode($content, TRUE);
		$alamat = $json['alamat'];

		return $alamat;
	}

	public function kota()
	{
		$file = base_url() . 'info.json';
		$content = file_get_contents($file);
		$json = json_decode($content, TRUE);
		$kota = $json['kota'];

		return $kota;
	}

	public function kodepos()
	{
		$file = base_url() . 'info.json';
		$content = file_get_contents($file);
		$json = json_decode($content, TRUE);
		$kodepos = $json['kodepos'];

		return $kodepos;
	}

	public function telepon()
	{
		$file = base_url() . 'info.json';
		$content = file_get_contents($file);
		$json = json_decode($content, TRUE);
		$telepon = $json['telepon'];

		return $telepon;
	}

	public function email()
	{
		$file = base_url() . 'info.json';
		$content = file_get_contents($file);
		$json = json_decode($content, TRUE);
		$email = $json['email'];

		return $email;
	}

	public function password()
	{
		$file = base_url() . 'info.json';
		$content = file_get_contents($file);
		$json = json_decode($content, TRUE);
		$password = $json['password'];

		return $password;
	}

	public function facebook()
	{
		$file = base_url() . 'info.json';
		$content = file_get_contents($file);
		$json = json_decode($content, TRUE);
		$facebook = $json['facebook'];

		return $facebook;
	}

	public function twitter()
	{
		$file = base_url() . 'info.json';
		$content = file_get_contents($file);
		$json = json_decode($content, TRUE);
		$twitter = $json['twitter'];

		return $twitter;
	}

	public function instagram()
	{
		$file = base_url() . 'info.json';
		$content = file_get_contents($file);
		$json = json_decode($content, TRUE);
		$instagram = $json['instagram'];

		return $instagram;
	}

	public function youtube()
	{
		$file = base_url() . 'info.json';
		$content = file_get_contents($file);
		$json = json_decode($content, TRUE);
		$youtube = $json['youtube'];

		return $youtube;
	}

	public function data_info()
	{
		$file = base_url() . 'info.json';
		$content = file_get_contents($file);
		$json = json_decode($content, TRUE);
		$data['data1'] = $json;

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/data_info', $data);
	}

	public function ubah_info()
	{
		if ($this->CI->input->post('simpan', TRUE)) {
			$this->CI->form_validation->set_rules('name', 'Nama Situs', 'required|trim|xss_clean');
            $this->CI->form_validation->set_rules('tagline', 'Tagline Situs', 'required|trim|xss_clean');
            $this->CI->form_validation->set_rules('email', 'Email Situs', 'required');
            $this->CI->form_validation->set_rules('password', 'Password Email', 'required');

            if ($this->CI->form_validation->run() == FALSE) {
            	$this->CI->session->set_flashdata('validasi_eror', 'Nama, Tagline & Email Situs wajib diisi!');
				redirect('dashboard/data-info/','refresh');
				} else {
					$data = array(
						"name" => $this->CI->input->post('name', TRUE),
						"tagline" => $this->CI->input->post('tagline', TRUE),
						"alamat" => $this->CI->input->post('alamat', TRUE),
						"kota" => $this->CI->input->post('kota', TRUE),
						"kodepos" => $this->CI->input->post('kodepos', TRUE),
						"telepon" => $this->CI->input->post('telepon', TRUE),
						"email" => $this->CI->input->post('email', TRUE),
						"password" => $this->CI->input->post('password', TRUE),
						"facebook" => $this->CI->input->post('facebook', TRUE),
						"twitter" => $this->CI->input->post('twitter', TRUE),
						"instagram" => $this->CI->input->post('instagram', TRUE),
						"youtube" => $this->CI->input->post('youtube', TRUE),
					);

					$file = 'info.json';

					file_put_contents($file, json_encode($data));

					$this->CI->session->set_flashdata('sukses_ubah_info', 'Sukses Mengubah Info Situs!');
					redirect('dashboard/data-info/','refresh');
			        }
			        
				}
	}
}