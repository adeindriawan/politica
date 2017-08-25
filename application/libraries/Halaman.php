<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Library untuk memproses Halaman, dipindahkan dari Controller
*/
class Halaman {
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

	public function data_halaman()
	{
		$jumlah_halaman = $this->CI->db->select('id_halaman')->from('halaman')->count_all_results();
		
		$this->CI->load->library('pagination');
		$config['base_url'] = site_url('dashboard/data-halaman');
		
		$config['total_rows'] = $jumlah_halaman;
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

		$data['data1'] = $this->CI->db->get('halaman', $config['per_page'], ($this->CI->uri->segment(3)) ? $this->CI->uri->segment(3) : 0);
		
		$data['data2'] = $this->CI->pagination->create_links();

		$data['data3'] = $jumlah_halaman;

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/data_halaman', $data);
	}

	public function detail_halaman($id)
	{
		$data['data1'] = $this->CI->db->get_where('halaman', array('id_halaman' => $id))->result_array();
	
		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
    	$this->CI->load->view('backend/dashboard/detail_halaman', $data);
	}

	public function ubah_halaman($id)
	{
		if ($this->CI->input->post('isi', TRUE)) {
	      	$this->CI->form_validation->set_rules('isi', 'Isi Artikel', 'trim|required|xss_clean');
	      	$this->CI->form_validation->set_rules('judul', 'Judul Artikel', 'trim|required|xss_clean');
	        if ($this->CI->form_validation->run() == FALSE) {
	          $this->CI->session->set_flashdata('error_form_validation', 'Semua isian harus diisi!');
	          redirect('dashboard/detail-halaman/'.$id,'refresh');
	        	} else {
		        	$data = array(
			          "nama_halaman" => $this->CI->input->post('judul', TRUE),
			          "isi_halaman" => $this->CI->input->post('isi', TRUE),
			          "keterangan_halaman" => $this->CI->input->post('keterangan', TRUE),
			          "tanggal_halaman" => date('Y-m-d H:i:s'),
			        );

			        $this->CI->db->update('halaman', $data, array('id_halaman' => $id));

		        $this->CI->load->library('upload');

		        $config['upload_path'] = './uploads/images/halaman/original/';
		        $config['file_name'] = str_replace(" ", "_", $this->CI->input->post('judul')) . "_" . $this->CI->session->userdata('username') . '.jpg';
		        $config['overwrite'] = TRUE;
		        $config['allowed_types'] = 'gif|jpg|jpeg|png';
		        $config['max_size'] = '2000';
		        $config['max_width'] = '2500';
		        $config['max_height'] = '2500';

		        $this->CI->upload->initialize($config);

		        if (! $this->CI->upload->do_upload('gambar')) {
		        	$this->CI->session->set_flashdata('insert_success_no_upload', 'Sukses Membuat Halaman Baru! <br/>' . $this->CI->upload->display_errors());
		        	redirect('dashboard/detail-halaman/'.$id,'refresh');
			        } else {
			        	$uploaddata = $this->CI->upload->data();
						$this->CI->load->library('image_lib');

						/* resize and crop slider */
			        	$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = $uploaddata['full_path'];
						$config_thumbnail['new_image'] = './uploads/images/halaman/slider/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = TRUE;
						$config_thumbnail['width'] = '960';
						$config_thumbnail['height'] = '350';
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_thumbnail['width'] / $config_thumbnail['height']);
						$config_thumbnail['master_dim'] = ($dim > 0)? "height" : "width";

						$this->CI->image_lib->initialize($config_thumbnail); 
						if (! $this->CI->image_lib->resize()) {
							$this->CI->session->set_flashdata('error_resize_thumbnail', 'Error resize thumbnail:' . $this->CI->image_lib->display_errors());
							}

						$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = './uploads/images/halaman/slider/' . $uploaddata['file_name'];
						$config_thumbnail['new_image'] = './uploads/images/halaman/slider/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = FALSE;
						$config_thumbnail['width'] = '960';
						$config_thumbnail['height'] = '350';
						$config_thumbnail['x_axis'] = '0';
						$config_thumbnail['y_axis'] = '0';

						$this->CI->image_lib->initialize($config_thumbnail); 
						if (! $this->CI->image_lib->crop()) {
							$this->CI->session->set_flashdata('error_crop_thumbnail', 'Error crop thumbnail:' . $this->CI->image_lib->display_errors());
							}

						/* resize and crop sidebar */
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = $uploaddata['full_path'];
						$config_gambar['new_image'] = './uploads/images/halaman/sidebar/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = TRUE;
						$config_gambar['width'] = '220';
						$config_gambar['height'] = '95';
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_gambar['width'] / $config_gambar['height']);
						$config_gambar['master_dim'] = ($dim > 0)? "height" : "width";

						$this->CI->image_lib->initialize($config_gambar); 
						if (! $this->CI->image_lib->resize()) {
							$this->CI->session->set_flashdata('error_resize_gambar', 'Error resize sidebar:' . $this->CI->image_lib->display_errors());
							}
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = './uploads/images/halaman/sidebar/' . $uploaddata['file_name'];
						$config_gambar['new_image'] = './uploads/images/halaman/sidebar/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = FALSE;
						$config_gambar['width'] = '220';
						$config_gambar['height'] = '95';
						$config_gambar['x_axis'] = '0';
						$config_gambar['y_axis'] = '0';

						$this->CI->image_lib->clear();
						$this->CI->image_lib->initialize($config_gambar); 
						if (! $this->CI->image_lib->crop()) {
							$this->CI->session->set_flashdata('error_crop_gambar', 'Error crop sidebar:' . $this->CI->image_lib->display_errors());
							}

						/* resize and crop page */
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = $uploaddata['full_path'];
						$config_gambar['new_image'] = './uploads/images/halaman/page/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = TRUE;
						$config_gambar['width'] = '590';
						$config_gambar['height'] = '340';
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_gambar['width'] / $config_gambar['height']);
						$config_gambar['master_dim'] = ($dim > 0)? "height" : "width";

						$this->CI->image_lib->initialize($config_gambar); 
						if (! $this->CI->image_lib->resize()) {
							$this->CI->session->set_flashdata('error_resize_gambar', 'Error resize page:' . $this->CI->image_lib->display_errors());
							}
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = './uploads/images/halaman/page/' . $uploaddata['file_name'];
						$config_gambar['new_image'] = './uploads/images/halaman/page/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = FALSE;
						$config_gambar['width'] = '590';
						$config_gambar['height'] = '340';
						$config_gambar['x_axis'] = '0';
						$config_gambar['y_axis'] = '0';

						$this->CI->image_lib->clear();
						$this->CI->image_lib->initialize($config_gambar); 
						if (! $this->CI->image_lib->crop()) {
							$this->CI->session->set_flashdata('error_crop_gambar', 'Error crop page:' . $this->CI->image_lib->display_errors());
							}

						$gambar = array(
							"gambar_halaman" => str_replace(" ", "_", $this->CI->input->post('judul')) . "_" . $this->CI->session->userdata('username') . '.jpg',
						);

						$this->CI->db->update('halaman', $gambar, array('id_halaman' => $id));

				        $this->CI->session->set_flashdata('success_insert_with_upload', 'Sukses Membuat Artikel dan Gambar Baru!');
				        redirect('dashboard/detail-halaman/'.$id,'refresh');
	        	}  
	        }
	    }
	}
}