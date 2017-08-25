<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Library untuk memproses album Galeri, dipindahkan dari controller
*/
class Galeri {
	var $CI;
	var $nav;
	var $incNav;
	var $menu;
	var $incMenu;
	var $gal_thumbnail_width;
	var $gal_thumbnail_height;
	var $gal_view_width;
	var $gal_view_height;
	
	function __construct()
	{
		$this->CI =& get_instance();

        $this->CI->load->database();
        $this->CI->load->model('ModelFoto');
        $this->CI->load->library('session');
        $this->CI->load->library('Analitik');
        $this->CI->load->library('Info');

        $this->nav = array(
			"notif" => $this->CI->analitik->daftar_notifikasi(),
			"review" => $this->CI->analitik->review_artikel(),
			"pesan" => $this->CI->analitik->review_pesan(),
			"nama" => $this->CI->info->nama_situs(),
		);

		$this->incNav = $this->CI->load->view('backend/dashboard/include/nav', $this->nav, TRUE);

		$this->menu = array();

		$this->incMenu = $this->CI->load->view('backend/dashboard/include/menu', $this->menu, TRUE);

		$this->gal_thumbnail_width = '201';
		$this->gal_thumbnail_height = '201';

		$this->gal_view_width = '960';
		$this->gal_view_height = '480';
	}

	public function data_galeri()
	{
		$total_rows = $this->CI->db->select('id_album')->from('album')->count_all_results();

		$this->CI->load->library('pagination');
		$config['base_url'] = site_url('dashboard/data-galeri');
		
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

		$data['data1'] = $this->CI->ModelFoto->gabung_album_dengan_nama_admin($config['per_page'], ($this->CI->uri->segment(3)) ? $this->CI->uri->segment(3) : 0);
		
		$data['data2'] = $this->CI->pagination->create_links();

		$data['data3'] = $total_rows;

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/data_galeri', $data);
	}

	public function tambah_galeri()
	{
		$data['data1'] = $this->CI->input->post('jumlah', TRUE);

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/tambah_galeri', $data);
	}

	public function buat_galeri()
	{
		if ($this->CI->input->post('judul', TRUE)) {
	      	$this->CI->form_validation->set_rules('judul', 'Judul album', 'trim|required|xss_clean');
	        if ($this->CI->form_validation->run() == FALSE) {
	          $this->CI->session->set_flashdata('error_form_validation', 'Error Form Validation!');
	          redirect('dashboard/data-galeri','refresh');
	        	} else {
		        	$data = array(
			          "judul_album" => $this->CI->input->post('judul', TRUE),
			          "deskripsi_album" => $this->CI->input->post('isi', TRUE),
			          "tanggal_album" => date("Y-m-d H:i:s"),
			          "status_album" => 'Published',
			          "id_admin" => $this->CI->session->userdata('id'),
			        );

			        $this->CI->db->insert('album', $data);

			        $idalbum = $this->CI->db->insert_id("album");

			        $foto_album['id_album'] = $idalbum;
	                if ($this->CI->input->post('submit') && !empty($_FILES['foto']['name'])) {
	                	$files = $_FILES;
	                	foreach ($files as $key => $value) {
	                		$filesCount = count($files['foto']['name']);
		                	for($i = 0; $i < $filesCount; $i++){
				                $_FILES['userFile']['name'] = $value['name'][$i];
				                $_FILES['userFile']['type'] = $value['type'][$i];
				                $_FILES['userFile']['tmp_name'] = $value['tmp_name'][$i];
				                $_FILES['userFile']['error'] = $value['error'][$i];
				                $_FILES['userFile']['size'] = $value['size'][$i];

				                $foto_album['caption'] = $_POST['caption'][$i];

				                $uploadPath = './uploads/images/album/original/';
				                $config['upload_path'] = $uploadPath;
				                $config['allowed_types'] = 'gif|jpg|png|jpeg';
				                $config['file_name'] = str_replace(" ", "_", $this->CI->input->post('judul')) . "_" . $i . '.jpg';
				                $config['overwrite'] = TRUE;
				                $config['max_size'] = '4000';
						        $config['max_width'] = '6000';
						        $config['max_height'] = '4000';

				                $this->CI->load->library('upload', $config);
				                $this->CI->upload->initialize($config);
				                if(!$this->CI->upload->do_upload('userFile')){
				                    $this->CI->session->set_flashdata('insert_success_no_upload', 'Sebagian/semua foto tidak bisa tersimpan, pembuatan album gagal! <br/>' . $this->CI->upload->display_errors());
		        					redirect('dashboard/data-galeri','refresh');
				                } else {
				                	$uploaddata = $this->CI->upload->data();
									$this->CI->load->library('image_lib');

									/* resize and crop thumbnail */
						        	$config_thumbnail['image_library'] = 'gd2';
									$config_thumbnail['source_image'] = $uploaddata['full_path'];
									$config_thumbnail['new_image'] = './uploads/images/album/thumbnail/' . $uploaddata['file_name'];
									$config_thumbnail['maintain_ratio'] = TRUE;
									$config_thumbnail['overwrite'] = TRUE;
									$config_thumbnail['width'] = $this->gal_thumbnail_width;
									$config_thumbnail['height'] = $this->gal_thumbnail_height;
									$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_thumbnail['width'] / $config_thumbnail['height']);
									$config_thumbnail['master_dim'] = ($dim > 0)? "height" : "width";

									$this->CI->image_lib->initialize($config_thumbnail); 
									if (! $this->CI->image_lib->resize()) {
										$this->CI->session->set_flashdata('error_resize_thumbnail', 'Error resize thumbnail:' . $this->CI->image_lib->display_errors());
										}

									$config_thumbnail['image_library'] = 'gd2';
									$config_thumbnail['source_image'] = './uploads/images/album/thumbnail/' . $uploaddata['file_name'];
									$config_thumbnail['new_image'] = './uploads/images/album/thumbnail/' . $uploaddata['file_name'];
									$config_thumbnail['maintain_ratio'] = FALSE;
									$config_thumbnail['overwrite'] = TRUE;
									$config_thumbnail['width'] = $this->gal_thumbnail_width;
									$config_thumbnail['height'] = $this->gal_thumbnail_height;
									$config_thumbnail['x_axis'] = '0';
									$config_thumbnail['y_axis'] = '0';

									$this->CI->image_lib->initialize($config_thumbnail); 
									if (! $this->CI->image_lib->crop()) {
										$this->CI->session->set_flashdata('error_crop_thumbnail', 'Error crop thumbnail:' . $this->CI->image_lib->display_errors());
										}

									/* resize and crop view */
						        	$config_view['image_library'] = 'gd2';
									$config_view['source_image'] = $uploaddata['full_path'];
									$config_view['new_image'] = './uploads/images/album/view/' . $uploaddata['file_name'];
									$config_view['maintain_ratio'] = TRUE;
									$config_view['overwrite'] = TRUE;
									$config_view['width'] = $this->gal_view_width;
									$config_view['height'] = $this->gal_view_height;
									$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_view['width'] / $config_view['height']);
									$config_view['master_dim'] = ($dim > 0)? "height" : "width";

									$this->CI->image_lib->initialize($config_view); 
									if (! $this->CI->image_lib->resize()) {
										$this->CI->session->set_flashdata('error_resize_view', 'Error resize view:' . $this->CI->image_lib->display_errors());
										}

									$config_view['image_library'] = 'gd2';
									$config_view['source_image'] = './uploads/images/album/view/' . $uploaddata['file_name'];
									$config_view['new_image'] = './uploads/images/album/view/' . $uploaddata['file_name'];
									$config_view['maintain_ratio'] = FALSE;
									$config_view['overwrite'] = TRUE;
									$config_view['width'] = $this->gal_view_width;
									$config_view['height'] = $this->gal_view_height;
									$config_view['x_axis'] = '0';
									$config_view['y_axis'] = '0';

									$this->CI->image_lib->initialize($config_view); 
									if (! $this->CI->image_lib->crop()) {
										$this->CI->session->set_flashdata('error_crop_view', 'Error crop view:' . $this->CI->image_lib->display_errors());
										}

				                    $foto_album['path_view'] = $config['file_name'];
				                    $this->CI->db->insert('foto_album', $foto_album);
				                } // end if this->upload
				            } // end for
	                	} // end foreach

			            if(!empty($uploadData)){
			                $statusMsg = 'Some problem occurred, please try again.';
			                $this->CI->session->set_flashdata('statusMsg',$statusMsg);
			            }
	                } // end if this->input->post
	            $this->CI->session->set_flashdata('success_insert_with_upload', 'Sukses membuat album baru!');
	            redirect('dashboard/data-galeri','refresh');
	        } // end ifelse validation run
	    } // end if this->input->post description
	}

	public function detail_galeri($id)
	{
		$data['data1'] = $this->CI->ModelFoto->lihat_album_tertentu($id);

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/detail_galeri', $data);
	}

	public function ubah_galeri($id)
	{
		if ($this->CI->input->post('judul', TRUE)) {
	      	$this->CI->form_validation->set_rules('judul', 'Judul album', 'trim|required|xss_clean');
	        if ($this->CI->form_validation->run() == FALSE) {
	          $this->CI->session->set_flashdata('error_form_validation', 'Error Form Validation!');
	          redirect('dashboard/data-galeri','refresh');
	        	} else {
		        	$data = array(
			          "judul_album" => $this->CI->input->post('judul', TRUE),
			          "deskripsi_album" => $this->CI->input->post('isi', TRUE),
			          "tanggal_album" => date("Y-m-d H:i:s"),
			          "status_album" => 'Edited',
			          "id_admin" => $this->CI->session->userdata('id'),
			        );

			        $this->CI->db->update('album', $data, array('id_album' => $id));

			        $idalbum = $id;

			        $foto_album['id_album'] = $idalbum;

	                if (!empty($_FILES['foto']['name'])) {
	                	$files = $_FILES;

	                	// untuk mendapatkan id_foto_album masing-masing foto yang akan diupdate
				        $this->CI->db->select('id_foto_album')->from('foto_album')->where('id_album', $id);
				        $id_foto_album = $this->CI->db->get()->result_array();

	                	foreach ($files as $key => $value) {
	                		$filesCount = count($files['foto']['name']);
		                	for($i = 0; $i < $filesCount; $i++){
				                $_FILES['userFile']['name'] = $value['name'][$i];
				                $_FILES['userFile']['type'] = $value['type'][$i];
				                $_FILES['userFile']['tmp_name'] = $value['tmp_name'][$i];
				                $_FILES['userFile']['error'] = $value['error'][$i];
				                $_FILES['userFile']['size'] = $value['size'][$i];

				                $foto_album['caption'] = $_POST['caption'][$i];

				                $uploadPath = './uploads/images/album/original/';
				                $config['upload_path'] = $uploadPath;
				                $config['allowed_types'] = 'gif|jpg|png|jpeg';
				                $config['overwrite'] = TRUE;
				                $config['file_name'] = str_replace(" ", "_", $this->CI->input->post('judul')) . "_" . $i . '.jpg';
				                $config['max_size'] = '4000';
						        $config['max_width'] = '6000';
						        $config['max_height'] = '4000';

				                $this->CI->load->library('upload', $config);
				                $this->CI->upload->initialize($config);
				                if(!$this->CI->upload->do_upload('userFile')){
				                    $this->CI->session->set_flashdata('insert_success_no_upload', 'Sebagian/semua foto tidak bisa tersimpan, foto-foto baru tidak terunggah. <br/>' . $this->CI->upload->display_errors());
		        					redirect('dashboard/data-galeri','refresh');
				                } else {
				                	$uploaddata = $this->CI->upload->data();
									$this->CI->load->library('image_lib');

									/* resize and crop thumbnail */
						        	$config_thumbnail['image_library'] = 'gd2';
									$config_thumbnail['source_image'] = $uploaddata['full_path'];
									$config_thumbnail['new_image'] = './uploads/images/album/thumbnail/' . $uploaddata['file_name'];
									$config_thumbnail['maintain_ratio'] = TRUE;
									$config_thumbnail['overwrite'] = TRUE;
									$config_thumbnail['width'] = $this->gal_thumbnail_width;
									$config_thumbnail['height'] = $this->gal_thumbnail_height;
									$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_thumbnail['width'] / $config_thumbnail['height']);
									$config_thumbnail['master_dim'] = ($dim > 0)? "height" : "width";

									$this->CI->image_lib->initialize($config_thumbnail); 
									if (! $this->CI->image_lib->resize()) {
										$this->CI->session->set_flashdata('error_resize_thumbnail', 'Error resize thumbnail:' . $this->CI->image_lib->display_errors());
										}

									$config_thumbnail['image_library'] = 'gd2';
									$config_thumbnail['source_image'] = './uploads/images/album/thumbnail/' . $uploaddata['file_name'];
									$config_thumbnail['new_image'] = './uploads/images/album/thumbnail/' . $uploaddata['file_name'];
									$config_thumbnail['maintain_ratio'] = FALSE;
									$config_thumbnail['overwrite'] = TRUE;
									$config_thumbnail['width'] = $this->gal_thumbnail_width;
									$config_thumbnail['height'] = $this->gal_thumbnail_height;
									$config_thumbnail['x_axis'] = '0';
									$config_thumbnail['y_axis'] = '0';

									$this->CI->image_lib->initialize($config_thumbnail); 
									if (! $this->CI->image_lib->crop()) {
										$this->CI->session->set_flashdata('error_crop_thumbnail', 'Error crop thumbnail:' . $this->CI->image_lib->display_errors());
										}

									/* resize and crop view */
						        	$config_view['image_library'] = 'gd2';
									$config_view['source_image'] = $uploaddata['full_path'];
									$config_view['new_image'] = './uploads/images/album/view/' . $uploaddata['file_name'];
									$config_view['maintain_ratio'] = TRUE;
									$config_view['overwrite'] = TRUE;
									$config_view['width'] = $this->gal_view_width;
									$config_view['height'] = $this->gal_view_height;
									$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_view['width'] / $config_view['height']);
									$config_view['master_dim'] = ($dim > 0)? "height" : "width";

									$this->CI->image_lib->initialize($config_view); 
									if (! $this->CI->image_lib->resize()) {
										$this->CI->session->set_flashdata('error_resize_view', 'Error resize view:' . $this->CI->image_lib->display_errors());
										}

									$config_view['image_library'] = 'gd2';
									$config_view['source_image'] = './uploads/images/album/view/' . $uploaddata['file_name'];
									$config_view['new_image'] = './uploads/images/album/view/' . $uploaddata['file_name'];
									$config_view['maintain_ratio'] = FALSE;
									$config_view['overwrite'] = TRUE;
									$config_view['width'] = $this->gal_view_width;
									$config_view['height'] = $this->gal_view_height;
									$config_view['x_axis'] = '0';
									$config_view['y_axis'] = '0';

									$this->CI->image_lib->initialize($config_view); 
									if (! $this->CI->image_lib->crop()) {
										$this->CI->session->set_flashdata('error_crop_view', 'Error crop view:' . $this->CI->image_lib->display_errors());
										}

				                    $foto_album['path_view'] = $config['file_name'];
				                    $this->CI->db->update('foto_album', $foto_album, array('id_foto_album' => $id_foto_album[$i]['id_foto_album']));
				                } // end if this->upload
				            } // end for
	                	} // end foreach

			            if(!empty($uploadData)){
			                $statusMsg = 'Some problem occurred, please try again.';
			                $this->CI->session->set_flashdata('statusMsg',$statusMsg);
			            }
	                } // end if this->input->post
	            $this->CI->session->set_flashdata('success_insert_with_upload', 'Sukses mengedit album!');
	            redirect('dashboard/data-album','refresh');
	        } // end ifelse validation run
	    } // end if this->input->post description
	}

	public function hapus_galeri($id)
	{
		// Check if user has javascript enabled
        if($this->CI->input->post('ajax') != '1'){
            echo 'false';
            } else { 
                if ($this->CI->input->post('id_album', TRUE)) {
                	$arr_criteria = array('id_album' => $id);
                    $query_foto_album = $this->CI->db->get_where('foto_album', $arr_criteria);

                    foreach ($query_foto_album->result_array() as $key => $foto) {
                    	if ($foto['path_view']) {
                    		unlink('uploads/images/album/original/' . $foto['path_view']);
	                    	unlink('uploads/images/album/thumbnail/' . $foto['path_view']);
	                    	unlink('uploads/images/album/view/' . $foto['path_view']);
                    	}
                    }
                    
                    $this->CI->db->delete('album', array("id_album" => $id));
                    $this->CI->db->delete('foto_album', array("id_album" => $id));
                    $this->CI->db->delete('notifikasi', array("id_album" => $id));
                    echo 'true';
                } else {
                    echo 'false';
                }   
            }
	}
}