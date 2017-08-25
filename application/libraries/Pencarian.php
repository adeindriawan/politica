<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Library untuk memproses Pencarian
*/
class Pencarian {
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
			"nama" => $this->CI->info->nama_situs(),
		);

		$this->incNav = $this->CI->load->view('backend/dashboard/include/nav', $this->nav, TRUE);

		$this->menu = array();

		$this->incMenu = $this->CI->load->view('backend/dashboard/include/menu', $this->menu, TRUE);
	}

	public function data_pencarian()
	{
		$num_pencarian = $this->CI->db->select('id_pencarian')->from('pencarian')->count_all_results();

		$this->CI->load->library('pagination');
		
		$config['base_url'] = site_url('dashboard/data-pencarian');
		$config['total_rows'] = $num_pencarian;
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['num_links'] = 3;
		$config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';

        $config['full_tag_open']   = "<div class='pagination'><ul>";
        $config['full_tag_close']  = '</ul></div>';

        $config['num_tag_open']  = '<li>';
        $config['num_tag_close']  = '</li>';

        $config['cur_tag_open']    = "<li class='active'><a href='#'>";
        $config['cur_tag_close']   = "<span class='sr-only'></span></a></li>";

        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = '</li>';

        $config['prev_tag_open']   = '<li>';
        $config['prev_tag_close']  = '</li>';

        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
		
		$this->CI->pagination->initialize($config);

		$data['data1'] = $this->CI->db->get('pencarian', $config['per_page'], ($this->CI->uri->segment(3)) ? $this->CI->uri->segment(3) : 0);
		
		$data['data2'] = $this->CI->pagination->create_links();

		$data['data3'] = $num_pencarian;

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/data_pencarian', $data);
	}

	public function detail_pencarian($kata_kunci)
	{
		$num_kata_kunci = $this->CI->db->select('kata_kunci')->from('pencarian')->like('kata_kunci', $kata_kunci, 'both')->count_all_results();
		
		$this->CI->load->library('pagination');
		
		$config['base_url'] = site_url($this->user_type.'/detail-pencarian');
		$config['total_rows'] = 10;
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['num_links'] = 3;
		$config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';

        $config['full_tag_open']   = "<div class='pagination'><ul>";
        $config['full_tag_close']  = '</ul></div>';

        $config['num_tag_open']  = '<li>';
        $config['num_tag_close']  = '</li>';

        $config['cur_tag_open']    = "<li class='active'><a href='#'>";
        $config['cur_tag_close']   = "<span class='sr-only'></span></a></li>";

        $config['next_tag_open']   = '<li>';
        $config['next_tagl_close']  = '</li>';

        $config['prev_tag_open']   = '<li>';
        $config['prev_tagl_close']  = '</li>';

        $config['first_tag_open']  = '<li>';
        $config['first_tagl_close'] = '</li>';

        $config['last_tag_open']   = '<li>';
        $config['last_tagl_close']  = '</li>';
		
		$this->CI->pagination->initialize($config);

		$data['data1'] = $this->CI->db->select('pencarian.*')->from('pencarian')->like('kata_kunci', $kata_kunci, 'both')->limit($config['per_page'], ($this->CI->uri->segment(3)) ? $this->CI->uri->segment(3) : 0)->get();
		
		$data['data2'] = $this->CI->pagination->create_links();
		$data['data3'] = $num_kata_kunci;

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/detail_pencarian', $data);
	}
}