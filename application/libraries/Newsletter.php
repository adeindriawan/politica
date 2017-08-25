<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Library untuk memproses artikel Newsletter, dipindahkan dari Controller
*/
class Newsletter {
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
        $this->CI->load->model('ModelArtikel');

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

	public function data_newsletter()
	{
		$total_rows = $this->CI->db->select('newsletter.*')->from('newsletter')->count_all_results();

		$this->CI->load->library('pagination');
		$config['base_url'] = site_url('dashboard/data-newsletter');
		
		$config['total_rows'] = $total_rows;
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

		$data['data1'] = $this->CI->ModelArtikel->gabung_semua_newsletter_dengan_semua_nama_penulis($config['per_page'], ($this->CI->uri->segment(3)) ? $this->CI->uri->segment(3) : 0);
		
		$data['data2'] = $this->CI->pagination->create_links();

		$data['data3'] = $total_rows;

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/data_newsletter', $data);
	}

	public function tambah_newsletter()
	{
		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/tambah_newsletter', $data);
	}

	public function buat_newsletter()
	{
		if ($this->CI->input->post('isi', TRUE)) {
	      	$this->CI->form_validation->set_rules('isi', 'Isi Newsletter', 'trim|required|xss_clean');
	      	$this->CI->form_validation->set_rules('judul', 'Judul Newsletter', 'trim|required|xss_clean');
	      	
	        if ($this->CI->form_validation->run() == FALSE) {
	          $this->CI->session->set_flashdata('error_form_validation', 'Semua isian harus diisi!');
	          redirect('dashboard/tambah-newsletter','refresh');
	        	} else {
		        	$data = array(
			          "judul_newsletter" => $this->CI->input->post('judul', TRUE),
			          "isi_newsletter" => $this->CI->input->post('isi', TRUE),
			          "tanggal_newsletter" => date("Y-m-d H:i:s"),
			          "id_penulis_newsletter" => $this->CI->session->userdata('id'),
			          "status_newsletter" => 'Created',
			        );

			        $this->CI->db->insert('newsletter', $data);

			        $idNewsletter = $this->CI->db->insert_id("newsletter");

		        $this->CI->load->library('upload');

		        $config['upload_path'] = './uploads/images/newsletter/original/';
		        $config['file_name'] = str_replace(" ", "_", $this->CI->input->post('judul')) . "_" . $this->CI->session->userdata('username') . '.jpg';
		        $config['overwrite'] = TRUE;
		        $config['allowed_types'] = 'gif|jpg|jpeg|png';
		        $config['max_size'] = '2000';
		        $config['max_width'] = '2500';
		        $config['max_height'] = '2500';

		        $this->CI->upload->initialize($config);

		        if (! $this->CI->upload->do_upload('gambar')) {
		        	$this->CI->session->set_flashdata('insert_success_no_upload', 'Sukses Menyimpan Newsletter Baru! <br/>' . $this->CI->upload->display_errors());
		        	redirect('dashboard/tambah-newsletter','refresh');
			        } else {
			        	$uploaddata = $this->CI->upload->data();
						$this->CI->load->library('image_lib');

						/* resize and crop pic for email */
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = $uploaddata['full_path'];
						$config_gambar['new_image'] = './uploads/images/newsletter/email/' . $uploaddata['file_name'];
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
						$config_gambar['source_image'] = './uploads/images/newsletter/email/' . $uploaddata['file_name'];
						$config_gambar['new_image'] = './uploads/images/newsletter/email/' . $uploaddata['file_name'];
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
							"gambar_newsletter" => str_replace(" ", "_", $this->CI->input->post('judul')) . "_" . $this->CI->session->userdata('username') . '.jpg',
						);

						$this->CI->db->update('newsletter', $gambar, array('id_newsletter' => $idNewsletter));

				        $this->CI->session->set_flashdata('success_insert_with_upload', 'Sukses Membuat Newsletter dan Gambar Baru!');
				        redirect('dashboard/tambah-newsletter','refresh');
	        	}  
	        }
	    }
	}

	public function detail_newsletter($id)
	{
		$data['data1'] = $this->CI->db->get_where('newsletter', array('id_newsletter' => $id))->result_array();
	

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/detail_newsletter', $data);
	}

	public function ubah_newsletter($id)
	{
		if ($this->CI->input->post('isi', TRUE)) {
	      	$this->CI->form_validation->set_rules('isi', 'Isi Newsletter', 'trim|required|xss_clean');
	      	$this->CI->form_validation->set_rules('judul', 'Judul Newsletter', 'trim|required|xss_clean');
	      	
	        if ($this->CI->form_validation->run() == FALSE) {
	          $this->CI->session->set_flashdata('error_form_validation', 'Semua isian harus diisi!');
	          redirect('dashboard/detail-newsletter/'.$id,'refresh');
	        	} else {
		        	$data = array(
			          "judul_newsletter" => $this->CI->input->post('judul', TRUE),
			          "isi_newsletter" => $this->CI->input->post('isi', TRUE),
			          "tanggal_newsletter" => date("Y-m-d H:i:s"),
			          "id_penulis_newsletter" => $this->CI->session->userdata('id'),
			          "status_newsletter" => 'Created',
			        );

			        $this->CI->db->update('newsletter', $data, array('id_newsletter' => $id));

		        $this->CI->load->library('upload');

		        $config['upload_path'] = './uploads/images/newsletter/original/';
		        $config['file_name'] = str_replace(" ", "_", $this->CI->input->post('judul')) . "_" . $this->CI->session->userdata('username') . '.jpg';
		        $config['overwrite'] = TRUE;
		        $config['allowed_types'] = 'gif|jpg|jpeg|png';
		        $config['max_size'] = '2000';
		        $config['max_width'] = '2500';
		        $config['max_height'] = '2500';

		        $this->CI->upload->initialize($config);

		        if (! $this->CI->upload->do_upload('gambar')) {
		        	$this->CI->session->set_flashdata('insert_success_no_upload', 'Sukses Mengedit Newsletter! <br/>' . $this->CI->upload->display_errors());
		        	redirect('dashboard/detail-newsletter/'.$id,'refresh');
			        } else {
			        	$uploaddata = $this->CI->upload->data();
						$this->CI->load->library('image_lib');

						/* resize and crop pic for email */
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = $uploaddata['full_path'];
						$config_gambar['new_image'] = './uploads/images/newsletter/email/' . $uploaddata['file_name'];
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
						$config_gambar['source_image'] = './uploads/images/newsletter/email/' . $uploaddata['file_name'];
						$config_gambar['new_image'] = './uploads/images/newsletter/email/' . $uploaddata['file_name'];
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
							"gambar_newsletter" => str_replace(" ", "_", $this->CI->input->post('judul')) . "_" . $this->CI->session->userdata('username') . '.jpg',
						);

						$this->CI->db->update('newsletter', $gambar, array('id_newsletter' => $id));

				        $this->CI->session->set_flashdata('success_insert_with_upload', 'Sukses Mengedit Newsletter!');
				        redirect('dashboard/detail-newsletter/'.$id,'refresh');
	        	}  
	        }
	    }
	}

	public function hapus_newsletter($id)
	{
		// Check if user has javascript enabled
        if($this->CI->input->post('ajax') != '1'){
            echo 'false';
            } else { 
                if ($this->CI->input->post('id_newsletter', TRUE)) {

                	// #1. Hapus foto-foto yang terasosiasi dengan artikel yang mau dihapus
                	$arr_criteria = array('id_newsletter' => $id);
                	$query_hapus_foto_newsletter = $this->db->get_where('newsletter', $arr_criteria)->result_array();
					if ($query_hapus_foto_newsletter[0]['gambar_newsletter']) {
						unlink('uploads/images/newsletter/original/' . $query_hapus_foto_newsletter[0]['gambar_newsletter']);
						unlink('uploads/images/newsletter/email/' . $query_hapus_foto_newsletter[0]['gambar_newsletter']);	
					}

                    // #2. Hapus artikel yang ingin dihapus
                    $this->CI->db->delete('newsletter', array("id_newsletter" => $id));
                    
                    echo 'true';
                } else {
                    echo 'false';
                }   
            }
	}

	public function kirim_newsletter($id)
	{
		if ($this->CI->input->post('ajax') != 1) {
			echo 'false';
		} else {
			$arr_criteria = array("id_newsletter" => $id);
			$query_newsletter = $this->CI->db->get_where('newsletter', $arr_criteria)->result_array();

			$url = base_url();
			$judul = $query_newsletter[0]['judul_newsletter'];
			$isi = $query_newsletter[0]['isi_newsletter'];
			$gambar = $query_newsletter[0]['gambar_newsletter'];
			$tanggal = $query_newsletter[0]['tanggal_newsletter'];

			$pesan = "{$judul}
						<br>
						<br>
						{$isi}
						<br>
						<br>

						<small><em>ditulis pada tanggal {$tanggal}</em></small>";


			$recipients = $this->CI->db->get('pelanggan')->result_array();

			// Jangan lupa setting di akun gmailnya untuk security -> allow access from less security apps dinyalakan
			$config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => 465,
                'smtp_user' => $this->email_situs,
                'smtp_pass' => $this->password,
                'mailtype'  => 'html', 
                'charset' => 'utf-8',
                'wordwrap' => TRUE

            );

			foreach ($recipients as $value) {
				$this->CI->load->library('email');
				$this->CI->email->set_newline("\r\n");
   			 	$this->CI->email->initialize($config);
			
				$this->CI->email->from('noreply@academica.com', 'Academica Newsletter');
				$this->CI->email->to($value['email_pelanggan']);
				$this->CI->email->subject('[Academica Newsletter] ' . $judul);
				$this->CI->email->message($pesan);
				
				$this->CI->email->send();
			}

			$this->CI->db->update('newsletter', array('status_newsletter' => 'Published', 'tanggal_publish' => date('Y-m-d H:i:s')), array('id_newsletter' => $id));
			echo $this->CI->email->print_debugger();
		}
	}

	public function data_pelanggan()
	{
		$num_pelanggan = $this->CI->db->select('id_pelanggan')->from('pelanggan')->count_all_results();

		$this->CI->load->library('pagination');
		
		$config['base_url'] = site_url('dashboard/data-pelanggan');
		$config['total_rows'] = $num_pelanggan;
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

		$data['data1'] = $this->CI->db->get('pelanggan', $config['per_page'], ($this->CI->uri->segment(3)) ? $this->CI->uri->segment(3) : 0);
		
		$data['data2'] = $this->CI->pagination->create_links();

		$data['data3'] = $num_pelanggan;

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/data_pelanggan', $data);
	}

	public function hapus_pelanggan($id)
	{
		// Check if user has javascript enabled
        if($this->CI->input->post('ajax') != '1'){
            echo 'false';
            } else { 
                if ($this->CI->input->post('id_pelanggan', TRUE)) {
                    
                    $this->CI->db->delete('pelanggan', array("id_pelanggan" => $id));
                    echo 'true';
                } else {
                    echo 'false';
                }   
            }
	}
}