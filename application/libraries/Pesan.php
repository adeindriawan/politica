<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Library untuk memproses Pesan, dipindahkan dari Controller
*/
class Pesan {
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

	public function data_pesan()
	{
		$num_pesan = $this->CI->db->select('id_pesan')->from('pesan')->count_all_results();

		$this->CI->load->library('pagination');
		
		$config['base_url'] = site_url('dashboard/data-pesan');
		$config['total_rows'] = $num_pesan;
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

		$data['data1'] = $this->CI->db->get('pesan', $config['per_page'], ($this->CI->uri->segment(3)) ? $this->CI->uri->segment(3) : 0);
		
		$data['data2'] = $this->CI->pagination->create_links();

		$data['data3'] = $num_pesan;

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/data_pesan', $data);
	}

	public function detail_pesan($id)
	{
		$data['data1'] = $this->CI->db->get_where('pesan', array('id_pesan' => $id))->result_array();

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/'.$this->user_type.'/detail_pesan', $data);
	}

	public function balas_pesan($id)
	{
		if ($this->CI->input->post('ajax') != 1) {
			echo 'false';
		} else {
			if ($this->CI->input->post('email') && $this->CI->input->post('isi')) {
				$this->CI->db->update('pesan', array('status_pesan' => 'Answered'), array('id_pesan' => $this->CI->input->post('id_pesan')));

				$this->CI->load->library('email');
				
				$this->CI->email->from($this->email_situs);
				$this->CI->email->to($this->input->post('email'));
				
				$this->CI->email->subject('[BALAS]');
				$this->CI->email->message($this->input->post('isi'));
				
				$this->CI->email->send();
				
				echo $this->CI->email->print_debugger();

				echo '<br> true';
			} else {
				echo 'false';
			}
			
		}
	}
}