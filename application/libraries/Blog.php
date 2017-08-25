<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Library untuk memproses artikel Berita, dipindahkan dari controller
*/
class Blog {
	var $CI;
	var $nav;
	var $incNav;
	var $menu;
	var $incMenu;
	var $art_thumbnail_height;
	var $art_thumbnail_width;
	var $art_page_height;
	var $art_page_width;
	var $art_list_height;
	var $art_list_width;
	
	function __construct()
	{
		$this->CI =& get_instance();

        $this->CI->load->database();
        $this->CI->load->model('ModelArtikel');
        $this->CI->load->library('session');
        $this->CI->load->library('Analitik');
        $this->CI->load->library('Info');
        $this->CI->load->library('Notifikasi');

        $this->nav = array(
			"notif" => $this->CI->analitik->daftar_notifikasi(),
			"review" => $this->CI->analitik->review_artikel(),
			"pesan" => $this->CI->analitik->review_pesan(),
			"nama" => $this->CI->info->nama_situs(),
		);

		$this->incNav = $this->CI->load->view('backend/dashboard/include/nav', $this->nav, TRUE);

		$this->menu = array();

		$this->incMenu = $this->CI->load->view('backend/dashboard/include/menu', $this->menu, TRUE);

		$this->art_thumbnail_width = '270';
		$this->art_thumbnail_height = '170';
		
		$this->art_page_width = '590';
		$this->art_page_height = '340';
		
		$this->art_list_width = '290';
		$this->art_list_height = '250';
	}

	public function data_blog()
	{
		$total_rows = $this->CI->db->select('artikel.*')->from('artikel')->where('artikel.jenis_artikel', 'Blog')->count_all_results();

		$this->CI->load->library('pagination');
		$config['base_url'] = site_url('dashboard/data-blog');
		
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

		$data['data1'] = $this->CI->ModelArtikel->gabung_semua_artikel_blog_dengan_semua_nama_penulis($config['per_page'], ($this->CI->uri->segment(3)) ? $this->CI->uri->segment(3) : 0);
		
		$data['data2'] = $this->CI->pagination->create_links();

		$data['data3'] = $total_rows;

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/data_blog', $data);
	}

	public function tambah_blog()
	{
		$data['data1'] = $this->CI->db->get('tags')->result_array();
		$data['data2'] = $this->CI->db->get('kategori')->result_array();

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/tambah_blog', $data);
	}

	public function buat_blog()
	{
		if ($this->CI->input->post('isi', TRUE)) {
	      	$this->CI->form_validation->set_rules('isi', 'Isi Artikel', 'trim|required|xss_clean');
	      	$this->CI->form_validation->set_rules('judul', 'Judul Artikel', 'trim|required|xss_clean');
	      	$this->CI->form_validation->set_rules('tags[]', 'Tags Artikel', 'required');
	        if ($this->CI->form_validation->run() == FALSE) {
	          $this->CI->session->set_flashdata('error_form_validation', 'Semua isian harus diisi!');
	          redirect('dashboard/tambah-blog','refresh');
	        	} else {
		        	$data = array(
			          "judul_artikel" => $this->CI->input->post('judul', TRUE),
			          "isi_artikel" => $this->CI->input->post('isi', TRUE),
			          "id_kategori" => $this->CI->input->post('kategori', TRUE),
			          "jenis_artikel" => "Blog",
			          "tanggal_artikel" => date("Y-m-d H:i:s"),
			          "status_artikel" => "Pending",
			          "id_penulis_artikel" => $this->CI->session->userdata('id'),
			        );

			        $this->CI->db->insert('artikel', $data);

			        $idArtikel = $this->CI->db->insert_id("artikel");

			        $tags_artikel['id_artikel'] = $idArtikel;
	                foreach ($_POST['tags'] as $selected) {
	                $tags_artikel['id_tag'] = $selected;
	                $this->CI->db->insert("tags_artikel", $tags_artikel);
	                }

	            $this->kirim_notifikasi_blog_baru_ke_staf_atau_admin($idArtikel, $this->CI->input->post('judul'), 'blog');

		        $this->CI->load->library('upload');

		        $config['upload_path'] = './uploads/images/artikel/original/';
		        $config['file_name'] = str_replace(" ", "_", $this->CI->input->post('judul')) . "_" . $this->CI->session->userdata('username') . '.jpg';
		        $config['overwrite'] = TRUE;
		        $config['allowed_types'] = 'gif|jpg|jpeg|png';
		        $config['max_size'] = '4000';
		        $config['max_width'] = '6000';
		        $config['max_height'] = '4000';

		        $this->CI->upload->initialize($config);

		        if (! $this->CI->upload->do_upload('gambar')) {
		        	$this->CI->session->set_flashdata('insert_success_no_upload', 'Sukses mengirim artikel blog, tunggu konfirmasi dari Admin/Staf!  <br/>' . $this->CI->upload->display_errors());
		        	redirect('dashboard/tambah-blog','refresh');
			        } else {
			        	$uploaddata = $this->CI->upload->data();
						$this->CI->load->library('image_lib');

						/* resize and crop thumbnail */
			        	$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = $uploaddata['full_path'];
						$config_thumbnail['new_image'] = './uploads/images/artikel/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = TRUE;
						$config_thumbnail['width'] = $this->art_thumbnail_width;
						$config_thumbnail['height'] = $this->art_thumbnail_height;
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_thumbnail['width'] / $config_thumbnail['height']);
						$config_thumbnail['master_dim'] = ($dim > 0)? "height" : "width";

						$this->CI->image_lib->initialize($config_thumbnail); 
						if (! $this->CI->image_lib->resize()) {
							$this->CI->session->set_flashdata('error_resize_thumbnail', 'Error resize thumbnail:' . $this->CI->image_lib->display_errors());
							}

						$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = './uploads/images/artikel/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['new_image'] = './uploads/images/artikel/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = FALSE;
						$config_thumbnail['width'] = $this->art_thumbnail_width;
						$config_thumbnail['height'] = $this->art_thumbnail_height;
						$config_thumbnail['x_axis'] = '0';
						$config_thumbnail['y_axis'] = '0';

						$this->CI->image_lib->initialize($config_thumbnail); 
						if (! $this->CI->image_lib->crop()) {
							$this->CI->session->set_flashdata('error_crop_thumbnail', 'Error crop thumbnail:' . $this->CI->image_lib->display_errors());
							}

						/* resize and crop page */
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = $uploaddata['full_path'];
						$config_gambar['new_image'] = './uploads/images/artikel/page/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = TRUE;
						$config_gambar['width'] = $this->art_page_width;
						$config_gambar['height'] = $this->art_page_height;
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_gambar['width'] / $config_gambar['height']);
						$config_gambar['master_dim'] = ($dim > 0)? "height" : "width";

						$this->CI->image_lib->initialize($config_gambar); 
						if (! $this->CI->image_lib->resize()) {
							$this->CI->session->set_flashdata('error_resize_gambar', 'Error resize page:' . $this->CI->image_lib->display_errors());
							}
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = './uploads/images/artikel/page/' . $uploaddata['file_name'];
						$config_gambar['new_image'] = './uploads/images/artikel/page/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = FALSE;
						$config_gambar['width'] = $this->art_page_width;
						$config_gambar['height'] = $this->art_page_height;
						$config_gambar['x_axis'] = '0';
						$config_gambar['y_axis'] = '0';

						$this->CI->image_lib->clear();
						$this->CI->image_lib->initialize($config_gambar); 
						if (! $this->CI->image_lib->crop()) {
							$this->CI->session->set_flashdata('error_crop_gambar', 'Error crop page:' . $this->CI->image_lib->display_errors());
							}

						/* resize and crop list */
						$config_list['image_library'] = 'gd2';
						$config_list['source_image'] = $uploaddata['full_path'];
						$config_list['new_image'] = './uploads/images/artikel/list/' . $uploaddata['file_name'];
						$config_list['maintain_ratio'] = TRUE;
						$config_list['width'] = $this->art_list_width;
						$config_list['height'] = $this->art_list_height;
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_list['width'] / $config_list['height']);
						$config_list['master_dim'] = ($dim > 0)? "height" : "width";

						$this->CI->image_lib->initialize($config_list); 
						if (! $this->CI->image_lib->resize()) {
							$this->CI->session->set_flashdata('error_resize_list', 'Error resize list:' . $this->CI->image_lib->display_errors());
							}
						$config_list['image_library'] = 'gd2';
						$config_list['source_image'] = './uploads/images/artikel/list/' . $uploaddata['file_name'];
						$config_list['new_image'] = './uploads/images/artikel/list/' . $uploaddata['file_name'];
						$config_list['maintain_ratio'] = FALSE;
						$config_list['width'] = $this->art_list_width;
						$config_list['height'] = $this->art_list_height;
						$config_list['x_axis'] = '0';
						$config_list['y_axis'] = '0';

						$this->CI->image_lib->clear();
						$this->CI->image_lib->initialize($config_list); 
						if (! $this->CI->image_lib->crop()) {
							$this->CI->session->set_flashdata('error_crop_list', 'Error crop list:' . $this->CI->image_lib->display_errors());
							}

						$gambar = array(
							"gambar_artikel" => str_replace(" ", "_", $this->CI->input->post('judul')) . "_" . $this->CI->session->userdata('username') . '.jpg',
						);

						$this->CI->db->update('artikel', $gambar, array('id_artikel' => $idArtikel));

				        $this->CI->session->set_flashdata('success_insert_with_upload', 'Sukses mengirim artikel blog, tunggu konfirmasi dari Admin/Staf!');
				        redirect('dashboard/tambah-blog','refresh');
	        	}  
	        }
	    } 
	}

	public function detail_blog($id)
	{
		$data['data1'] = $this->CI->db->get_where('artikel', array('id_artikel' => $id))->result_array();
		$query = $this->CI->ModelArtikel->gabung_artikel_tertentu_dengan_tag_dirinya($id)->result_array();
    	foreach ($query as $value) {
    		$query1[] = $value['tag'];
    	}
    	$data['data2'] = $query1;
    	$data['data3'] = $this->CI->db->get('tags')->result_array();
    	$data['data4'] = $this->CI->db->get('kategori')->result_array();

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
    	$this->CI->load->view('backend/dashboard/detail_blog', $data);
	}

	public function ubah_blog($id)
	{
		if ($this->CI->input->post('isi', TRUE)) {
	      	$this->CI->form_validation->set_rules('isi', 'Isi Artikel', 'trim|required|xss_clean');
	      	$this->CI->form_validation->set_rules('judul', 'Judul Artikel', 'trim|required|xss_clean');
	      	$this->CI->form_validation->set_rules('tags[]', 'Tags Artikel', 'required');
	        if ($this->CI->form_validation->run() == FALSE) {
	          	$this->CI->session->set_flashdata('error_form_validation', 'Error Form Validation!');
	          	redirect('dashboard/detail-blog/'.$id,'refresh');
	        	} else {
		        $data_blog_for_staf = array(
		          	"judul_artikel" => $this->CI->input->post('judul', TRUE),
		          	"isi_artikel" => $this->CI->input->post('isi', TRUE),
		          	"id_kategori" => $this->CI->input->post('kategori', TRUE),
		          	"tanggal_artikel" => date('Y-m-d H:i:s'),
		          	"status_artikel" => 'Published',
		        );

		        $data_blog_for_kontributor = array(
		          	"judul_artikel" => $this->CI->input->post('judul', TRUE),
		          	"isi_artikel" => $this->CI->input->post('isi', TRUE),
		          	"id_kategori" => $this->CI->input->post('kategori', TRUE),
		          	"tanggal_artikel" => date('Y-m-d H:i:s'),
		          	"status_artikel" => 'Pending',
		        );

		        // cek kategori admin pada session, lalu update sesuai konfig masing2
		        ($this->CI->session->userdata('kategori') == 'staf' ? $this->CI->db->update('artikel', $data_blog_for_staf, array('id_artikel' => $id)) : $this->CI->db->update('artikel', $data_blog_for_kontributor, array('id_artikel' => $id)));

		        $this->CI->db->delete('tags_artikel', array("id_artikel" => $id));

		        $tags_artikel['id_artikel'] = $id;
                foreach ($_POST['tags'] as $selected) {
                $tags_artikel['id_tag'] = $selected;
                $this->CI->db->insert("tags_artikel", $tags_artikel);
                }

                if ($this->CI->session->userdata('kategori') == 'staf') {
                	$this->kirim_notifikasi_ke_penulis_blog($this->CI->input->post('judul'), $id);	
                }

		        $this->CI->load->library('upload');

		        $config['upload_path'] = './uploads/images/artikel/original/';
		        $config['file_name'] = str_replace(" ", "_", $this->CI->input->post('judul')) . "_" . $this->CI->session->userdata('username') . '.jpg';
		        $config['overwrite'] = TRUE;
		        $config['allowed_types'] = 'gif|jpg|jpeg|png';
		        $config['max_size'] = '4000';
		        $config['max_width'] = '6000';
		        $config['max_height'] = '4000';

		        $this->CI->upload->initialize($config);

		        if (! $this->CI->upload->do_upload('gambar')) {
		        	$this->CI->session->set_flashdata('success_no_upload', "Sukses Mengedit/Mempublikasikan Blog! <br/>" . $this->CI->upload->display_errors());
		        	redirect('dashboard/detail-blog/'.$id,'refresh');
			        } else {
			        	$uploaddata = $this->CI->upload->data();
						$this->CI->load->library('image_lib');

						/* resize and crop thumbnail */
			        	$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = $uploaddata['full_path'];
						$config_thumbnail['new_image'] = './uploads/images/artikel/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = TRUE;
						$config_thumbnail['width'] = $this->art_thumbnail_width;
						$config_thumbnail['height'] = $this->art_thumbnail_height;
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_thumbnail['width'] / $config_thumbnail['height']);
						$config_thumbnail['master_dim'] = ($dim > 0)? "height" : "width";

						$this->CI->image_lib->initialize($config_thumbnail); 
						if (! $this->CI->image_lib->resize()) {
							$this->CI->session->set_flashdata('error_resize_thumbnail', 'Error resize thumbnail:' . $this->CI->image_lib->display_errors());
							}

						$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = './uploads/images/artikel/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['new_image'] = './uploads/images/artikel/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = FALSE;
						$config_thumbnail['width'] = $this->art_thumbnail_width;
						$config_thumbnail['height'] = $this->art_thumbnail_height;
						$config_thumbnail['x_axis'] = '0';
						$config_thumbnail['y_axis'] = '0';

						$this->CI->image_lib->initialize($config_thumbnail); 
						if (! $this->CI->image_lib->crop()) {
							$this->CI->session->set_flashdata('error_crop_thumbnail', 'Error crop thumbnail:' . $this->CI->image_lib->display_errors());
							}

						/* resize and crop page */
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = $uploaddata['full_path'];
						$config_gambar['new_image'] = './uploads/images/artikel/page/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = TRUE;
						$config_gambar['width'] = $this->art_page_width;
						$config_gambar['height'] = $this->art_page_height;
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_gambar['width'] / $config_gambar['height']);
						$config_gambar['master_dim'] = ($dim > 0)? "height" : "width";

						$this->CI->image_lib->initialize($config_gambar); 
						if (! $this->CI->image_lib->resize()) {
							$this->CI->session->set_flashdata('error_resize_gambar', 'Error resize page:' . $this->CI->image_lib->display_errors());
							}
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = './uploads/images/artikel/page/' . $uploaddata['file_name'];
						$config_gambar['new_image'] = './uploads/images/artikel/page/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = FALSE;
						$config_gambar['width'] = $this->art_page_width;
						$config_gambar['height'] = $this->art_page_height;
						$config_gambar['x_axis'] = '0';
						$config_gambar['y_axis'] = '0';

						$this->CI->image_lib->clear();
						$this->CI->image_lib->initialize($config_gambar); 
						if (! $this->CI->image_lib->crop()) {
							$this->CI->session->set_flashdata('error_crop_gambar', 'Error crop page:' . $this->CI->image_lib->display_errors());
							}

						/* resize and crop list */
						$config_list['image_library'] = 'gd2';
						$config_list['source_image'] = $uploaddata['full_path'];
						$config_list['new_image'] = './uploads/images/artikel/list/' . $uploaddata['file_name'];
						$config_list['maintain_ratio'] = TRUE;
						$config_list['width'] = $this->art_list_width;
						$config_list['height'] = $this->art_list_height;
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_list['width'] / $config_list['height']);
						$config_list['master_dim'] = ($dim > 0)? "height" : "width";

						$this->CI->image_lib->initialize($config_list); 
						if (! $this->CI->image_lib->resize()) {
							$this->CI->session->set_flashdata('error_resize_list', 'Error resize list:' . $this->CI->image_lib->display_errors());
							}
						$config_list['image_library'] = 'gd2';
						$config_list['source_image'] = './uploads/images/artikel/list/' . $uploaddata['file_name'];
						$config_list['new_image'] = './uploads/images/artikel/list/' . $uploaddata['file_name'];
						$config_list['maintain_ratio'] = FALSE;
						$config_list['width'] = $this->art_list_width;
						$config_list['height'] = $this->art_list_height;
						$config_list['x_axis'] = '0';
						$config_list['y_axis'] = '0';

						$this->CI->image_lib->clear();
						$this->CI->image_lib->initialize($config_list); 
						if (! $this->CI->image_lib->crop()) {
							$this->CI->session->set_flashdata('error_crop_list', 'Error crop list:' . $this->CI->image_lib->display_errors());
							}

						$gambar = array(
							"gambar_artikel" => str_replace(" ", "_", $this->CI->input->post('judul')) . "_" . $this->CI->session->userdata('username') . '.jpg',
						);

						$this->CI->db->update('artikel', $gambar, array("id_artikel" => $id));

						$this->CI->session->set_flashdata('success_with_upload', 'Sukses Mengedit/Mempublikasikan Blog dan Gambarnya!');
				        redirect('dashboard/detail-blog/'.$id,'refresh');
	        	}  
	        }
	    }
	}

	public function hapus_blog($id)
	{
		// Check if user has javascript enabled
        if($this->CI->input->post('ajax') != '1'){
            echo 'false';
            } else { 
                if ($this->CI->input->post('id_artikel', TRUE)) {

                	// #1. Hapus foto-foto yang terasosiasi dengan artikel yang mau dihapus
                	$arr_criteria = array('id_artikel' => $id);
                	$query_hapus_foto_artikel = $this->CI->db->get_where('artikel', $arr_criteria)->result_array();
					
					if ($query_hapus_foto_artikel[0]['gambar_artikel']) {
						unlink('uploads/images/artikel/list/' . $query_hapus_foto_artikel[0]['gambar_artikel']);
						unlink('uploads/images/artikel/original/' . $query_hapus_foto_artikel[0]['gambar_artikel']);
						unlink('uploads/images/artikel/page/' . $query_hapus_foto_artikel[0]['gambar_artikel']);
						unlink('uploads/images/artikel/thumbnail/' . $query_hapus_foto_artikel[0]['gambar_artikel']);
					}

                    // #2. Hapus artikel yang ingin dihapus
                    $this->CI->db->delete('artikel', array("id_artikel" => $id));
                    
                    // #3. Hapus tags artikel yang terasosiasi dengan artikel yang dihapus
                    $this->CI->db->delete('tags_artikel', array("id_artikel" => $id));
                    
                    // #4. Hapus notifikasi yang terasosiasi dengan artikel yang dihapus
                    $this->CI->db->delete('notifikasi', array("id_artikel" => $id));
                    echo 'true';
                } else {
                    echo 'false';
                }   
            }
	}

	public function kirim_notifikasi_ke_penulis_blog($judul, $id)
	{
		$this->CI->notifikasi->kirim_notifikasi_ke_penulis_blog($judul, $id);
	}

	public function kirim_notifikasi_blog_baru_ke_staf_atau_admin($id_artikel, $judul_artikel, $kategori_artikel)
	{
		$this->CI->notifikasi->kirim_notifikasi_blog_baru_ke_staf_atau_admin($id_artikel, $judul_artikel, $kategori_artikel);
	}
}