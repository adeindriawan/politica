<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Kontributor extends CI_Controller {

	var $user_type;
	var $nav;
	var $menu;
	var $art_thumbnail_height;
	var $art_thumbnail_width;
	var $art_page_height;
	var $art_page_width;
	var $art_list_height;
	var $art_list_width;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ModelArtikel');
		$this->load->model('ModelNotifikasi');
		$this->load->library('Analitik');
		$this->load->library('Notifikasi');
		$this->load->library('Info');

		if (! $this->session->userdata('username')) {
            $this->session->set_flashdata('sesi_habis', 'Sesi Anda sudah habis, silakan login kembali!');
            redirect('beranda','refresh');
        }

        if ($this->session->userdata('type') != $this->uri->segment(1)) {
            $session = array(
            'id' => "",
            'username' => "",
            'email' => "",
            );
        
        $this->session->set_userdata($session);
        $this->session->unset_userdata($session);
        $this->session->sess_destroy();
        redirect('beranda','refresh');
        }

        $this->user_type = $this->session->userdata('type');

        $this->nav = array(
			"notif" => $this->analitik->daftar_notifikasi(),
			"nama" => $this->info->nama_situs(),
			"tipe" => $this->user_type,
		);

		$this->menu = array(
			"tipe" => $this->user_type,
		);

		$this->art_thumbnail_width = '120';
		$this->art_thumbnail_height = '120';
		
		$this->art_page_width = '1000';
		$this->art_page_height = '415';
		
		$this->art_list_width = '460';
		$this->art_list_height = '200';
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi index()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menampilkan data-data yang akan muncul pada
	| dashboard Staf.
	| Data yang ditampilkan diambil dari fungsi-fungsi yang ada pada library Analitik
	| seperti yang dijelaskan oleh nama variabel masing-masing data.
	| 
	| Last edited: 2016-07-09 09:44
	*/

	public function index()
	{	
		$data['total_view_artikel'] = $this->analitik->pageviews();
		$data['halaman_per_visit'] = $this->analitik->pages_per_visit();
		$data['rerata_durasi_visit'] = $this->analitik->average_visit_duration();
		$data['tingkat_pantulan'] = $this->analitik->bounce_rate();
		$data['kunjungan_baru'] = $this->analitik->new_visits();
		$data['kunjungan_kembali'] = $this->analitik->returning_visitors();
		$data['jumlah_blog_dibaca'] = $this->analitik->blogview();
		$data['jumlah_berita_dibaca'] = $this->analitik->newsview();
		$data['jumlah_komentar_artikel'] = $this->analitik->article_comments();
		$data['jumlah_komentar_album'] = $this->analitik->album_comments();

		$data['jumlah_artikel'] = $this->analitik->jumlah_artikel();
		$data['jumlah_album'] = $this->analitik->jumlah_album();
		$data['jumlah_komentar'] = $this->analitik->jumlah_komentar();
		$data['jumlah_visit'] = $this->analitik->jumlah_visit();
		$data['jumlah_pelanggan'] = $this->analitik->jumlah_subscriber();
		$data['jumlah_pencarian'] = $this->analitik->jumlah_pencarian();

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/index', $data);
	}

	public function pageviews_and_visit_chart()
	{
		$this->analitik->pageviews_and_visit_chart();
	}

	public function cek_notifikasi()
	{
		$this->notifikasi->cek_notifikasi();
	}

	public function logout()
	{
		$session = array(
            'id' => "",
            'username' => "",
            'type' => "",
        );
        
        $this->session->set_userdata($session);
        $this->session->unset_userdata($session);
        $this->session->sess_destroy();

        redirect("beranda", "refresh");
	}

	public function data_blog()
	{
		$total_rows = $this->db->select('artikel.*')->from('artikel')->where('artikel.jenis_artikel', 'Blog')->count_all_results();

		$this->load->library('pagination');
		$config['base_url'] = site_url($this->user_type.'/data-blog');
		
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
        $config['next_tagl_close']  = '</li>';

        $config['prev_tag_open']   = '<li>';
        $config['prev_tagl_close']  = '</li>';

        $config['first_tag_open']  = '<li>';
        $config['first_tagl_close'] = '</li>';

        $config['last_tag_open']   = '<li>';
        $config['last_tagl_close']  = '</li>';
		
		$this->pagination->initialize($config);

		$data['data1'] = $this->ModelArtikel->gabung_semua_artikel_blog_dengan_semua_nama_penulis($config['per_page'], ($this->uri->segment(3)) ? $this->uri->segment(3) : 0);
		
		$data['data2'] = $this->pagination->create_links();

		$data['data3'] = $total_rows;

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/data_blog', $data);
	}

	public function tambah_blog()
	{
		$data['data1'] = $this->db->get('tags')->result_array();
		$data['data2'] = $this->db->get('kategori')->result_array();

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/tambah_blog', $data);
	}

	public function pasang_blog()
	{
		if ($this->input->post('isi', TRUE)) {
	      	$this->form_validation->set_rules('isi', 'Isi Artikel', 'trim|required|xss_clean');
	      	$this->form_validation->set_rules('judul', 'Judul Artikel', 'trim|required|xss_clean');
	      	$this->form_validation->set_rules('tags[]', 'Tags Artikel', 'required');
	        if ($this->form_validation->run() == FALSE) {
	          $this->session->set_flashdata('error_form_validation', 'Semua isian harus diisi!');
	          redirect($this->user_type.'/tambah-blog','refresh');
	        	} else {
		        	$data = array(
			          "judul_artikel" => $this->input->post('judul', TRUE),
			          "isi_artikel" => $this->input->post('isi', TRUE),
			          "id_kategori" => $this->input->post('kategori', TRUE),
			          "jenis_artikel" => "Blog",
			          "tanggal_artikel" => date("Y-m-d H:i:s"),
			          "status_artikel" => "Pending",
			          "id_penulis_artikel" => $this->session->userdata('id'),
			        );

			        $this->db->insert('artikel', $data);

			        $idArtikel = $this->db->insert_id("artikel");

			        $tags_artikel['id_artikel'] = $idArtikel;
	                foreach ($_POST['tags'] as $selected) {
	                $tags_artikel['id_tag'] = $selected;
	                $this->db->insert("tags_artikel", $tags_artikel);
	                }

	            $this->kirim_notifikasi_blog_baru_ke_staf_atau_admin($idArtikel, $this->input->post('judul'), 'blog');

		        $this->load->library('upload');

		        $config['upload_path'] = './uploads/images/artikel/original/';
		        $config['file_name'] = str_replace(" ", "_", $this->input->post('judul')) . "_" . $this->session->userdata('username') . '.jpg';
		        $config['overwrite'] = TRUE;
		        $config['allowed_types'] = 'gif|jpg|jpeg|png';
		        $config['max_size'] = '4000';
		        $config['max_width'] = '6000';
		        $config['max_height'] = '4000';

		        $this->upload->initialize($config);

		        if (! $this->upload->do_upload('gambar')) {
		        	$this->session->set_flashdata('insert_success_no_upload', 'Sukses mengirim artikel blog, tunggu konfirmasi dari Admin/Staf!  <br/>' . $this->upload->display_errors());
		        	redirect($this->user_type.'/tambah-blog','refresh');
			        } else {
			        	$uploaddata = $this->upload->data();
						$this->load->library('image_lib');

						/* resize and crop thumbnail */
			        	$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = $uploaddata['full_path'];
						$config_thumbnail['new_image'] = './uploads/images/artikel/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = TRUE;
						$config_thumbnail['width'] = $this->art_thumbnail_width;
						$config_thumbnail['height'] = $this->art_thumbnail_height;
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_thumbnail['width'] / $config_thumbnail['height']);
						$config_thumbnail['master_dim'] = ($dim > 0)? "height" : "width";

						$this->image_lib->initialize($config_thumbnail); 
						if (! $this->image_lib->resize()) {
							$this->session->set_flashdata('error_resize_thumbnail', 'Error resize thumbnail:' . $this->image_lib->display_errors());
							}

						$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = './uploads/images/artikel/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['new_image'] = './uploads/images/artikel/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = FALSE;
						$config_thumbnail['width'] = $this->art_thumbnail_width;
						$config_thumbnail['height'] = $this->art_thumbnail_height;
						$config_thumbnail['x_axis'] = '0';
						$config_thumbnail['y_axis'] = '0';

						$this->image_lib->initialize($config_thumbnail); 
						if (! $this->image_lib->crop()) {
							$this->session->set_flashdata('error_crop_thumbnail', 'Error crop thumbnail:' . $this->image_lib->display_errors());
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

						$this->image_lib->initialize($config_gambar); 
						if (! $this->image_lib->resize()) {
							$this->session->set_flashdata('error_resize_gambar', 'Error resize page:' . $this->image_lib->display_errors());
							}
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = './uploads/images/artikel/page/' . $uploaddata['file_name'];
						$config_gambar['new_image'] = './uploads/images/artikel/page/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = FALSE;
						$config_gambar['width'] = $this->art_page_width;
						$config_gambar['height'] = $this->art_page_height;
						$config_gambar['x_axis'] = '0';
						$config_gambar['y_axis'] = '0';

						$this->image_lib->clear();
						$this->image_lib->initialize($config_gambar); 
						if (! $this->image_lib->crop()) {
							$this->session->set_flashdata('error_crop_gambar', 'Error crop page:' . $this->image_lib->display_errors());
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

						$this->image_lib->initialize($config_list); 
						if (! $this->image_lib->resize()) {
							$this->session->set_flashdata('error_resize_list', 'Error resize list:' . $this->image_lib->display_errors());
							}
						$config_list['image_library'] = 'gd2';
						$config_list['source_image'] = './uploads/images/artikel/list/' . $uploaddata['file_name'];
						$config_list['new_image'] = './uploads/images/artikel/list/' . $uploaddata['file_name'];
						$config_list['maintain_ratio'] = FALSE;
						$config_list['width'] = $this->art_list_width;
						$config_list['height'] = $this->art_list_height;
						$config_list['x_axis'] = '0';
						$config_list['y_axis'] = '0';

						$this->image_lib->clear();
						$this->image_lib->initialize($config_list); 
						if (! $this->image_lib->crop()) {
							$this->session->set_flashdata('error_crop_list', 'Error crop list:' . $this->image_lib->display_errors());
							}

						$gambar = array(
							"gambar_artikel" => str_replace(" ", "_", $this->input->post('judul')) . "_" . $this->session->userdata('username') . '.jpg',
						);

						$this->db->update('artikel', $gambar, array('id_artikel' => $idArtikel));

				        $this->session->set_flashdata('success_insert_with_upload', 'Sukses mengirim artikel blog, tunggu konfirmasi dari Admin/Staf!');
				        redirect($this->user_type.'/tambah-blog','refresh');
	        	}  
	        }
	    } 
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi kirim_notifikasi_ke_staf_atau_admin()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk mencatat tiap kali ada yang komentar pada artikel Berita ke dalam database
	| notifikasi ke penulis artikel yang bersangkutan
	| 
	| Last edited: 2016-07-11 15:00
	*/

	public function kirim_notifikasi_blog_baru_ke_staf_atau_admin($id_artikel, $judul_artikel, $kategori_artikel)
	{
		$this->notifikasi->kirim_notifikasi_blog_baru_ke_staf_atau_admin($id_artikel, $judul_artikel, $kategori_artikel);
	}

	public function edit_blog($id)
	{
		$data['data1'] = $this->db->get_where('artikel', array('id_artikel' => $id))->result_array();
		$query = $this->ModelArtikel->gabung_artikel_tertentu_dengan_tag_dirinya($id)->result_array();
    	foreach ($query as $value) {
    		$query1[] = $value['tag'];
    	}
    	$data['data2'] = $query1;
    	$data['data3'] = $this->db->get('tags')->result_array();
    	$data['data4'] = $this->db->get('kategori')->result_array();

    	

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
    	$this->load->view('backend/'.$this->user_type.'/edit_blog', $data);
	}

	public function ubah_blog($id)
	{
		if ($this->input->post('isi', TRUE)) {
	      	$this->form_validation->set_rules('isi', 'Isi Artikel', 'trim|required|xss_clean');
	      	$this->form_validation->set_rules('judul', 'Judul Artikel', 'trim|required|xss_clean');
	      	$this->form_validation->set_rules('tags[]', 'Tags Artikel', 'required');
	        if ($this->form_validation->run() == FALSE) {
	          	$this->session->set_flashdata('error_form_validation', 'Error Form Validation!');
	          	redirect($this->user_type.'/edit-blog/'.$id,'refresh');
	        	} else {
		        $data = array(
			          "judul_artikel" => $this->input->post('judul', TRUE),
			          "isi_artikel" => $this->input->post('isi', TRUE),
			          "id_kategori" => $this->input->post('kategori', TRUE),
			          "tanggal_artikel" => date('Y-m-d H:i:s'),
			          "status_artikel" => 'Pending',
			        );

			        $this->db->update('artikel', $data, array('id_artikel' => $id));

			        $this->db->select('tags_artikel.*');
			        $this->db->delete('tags_artikel', array("id_artikel" => $id));

			        $tags_artikel['id_artikel'] = $id;
	                foreach ($_POST['tags'] as $selected) {
	                $tags_artikel['id_tag'] = $selected;
	                $this->db->insert("tags_artikel", $tags_artikel);
	                }

		        $this->load->library('upload');

		        $config['upload_path'] = './uploads/images/artikel/original/';
		        $config['file_name'] = str_replace(" ", "_", $this->input->post('judul')) . "_" . $this->session->userdata('username') . '.jpg';
		        $config['overwrite'] = TRUE;
		        $config['allowed_types'] = 'gif|jpg|jpeg|png';
		        $config['max_size'] = '4000';
		        $config['max_width'] = '6000';
		        $config['max_height'] = '4000';

		        $this->upload->initialize($config);

		        if (! $this->upload->do_upload('gambar')) {
		        	$this->session->set_flashdata('success_no_upload', "Sukses Mengedit Artikel! <br/>" . $this->upload->display_errors());
		        	redirect($this->user_type.'/edit-blog/'.$id,'refresh');
			        } else {
			        	$uploaddata = $this->upload->data();
						$this->load->library('image_lib');

						/* resize and crop thumbnail */
			        	$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = $uploaddata['full_path'];
						$config_thumbnail['new_image'] = './uploads/images/artikel/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = TRUE;
						$config_thumbnail['width'] = $this->art_thumbnail_width;
						$config_thumbnail['height'] = $this->art_thumbnail_height;
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_thumbnail['width'] / $config_thumbnail['height']);
						$config_thumbnail['master_dim'] = ($dim > 0)? "height" : "width";

						$this->image_lib->initialize($config_thumbnail); 
						if (! $this->image_lib->resize()) {
							$this->session->set_flashdata('error_resize_thumbnail', 'Error resize thumbnail:' . $this->image_lib->display_errors());
							}

						$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = './uploads/images/artikel/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['new_image'] = './uploads/images/artikel/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = FALSE;
						$config_thumbnail['width'] = $this->art_thumbnail_width;
						$config_thumbnail['height'] = $this->art_thumbnail_height;
						$config_thumbnail['x_axis'] = '0';
						$config_thumbnail['y_axis'] = '0';

						$this->image_lib->initialize($config_thumbnail); 
						if (! $this->image_lib->crop()) {
							$this->session->set_flashdata('error_crop_thumbnail', 'Error crop thumbnail:' . $this->image_lib->display_errors());
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

						$this->image_lib->initialize($config_gambar); 
						if (! $this->image_lib->resize()) {
							$this->session->set_flashdata('error_resize_gambar', 'Error resize page:' . $this->image_lib->display_errors());
							}
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = './uploads/images/artikel/page/' . $uploaddata['file_name'];
						$config_gambar['new_image'] = './uploads/images/artikel/page/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = FALSE;
						$config_gambar['width'] = $this->art_page_width;
						$config_gambar['height'] = $this->art_page_height;
						$config_gambar['x_axis'] = '0';
						$config_gambar['y_axis'] = '0';

						$this->image_lib->clear();
						$this->image_lib->initialize($config_gambar); 
						if (! $this->image_lib->crop()) {
							$this->session->set_flashdata('error_crop_gambar', 'Error crop page:' . $this->image_lib->display_errors());
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

						$this->image_lib->initialize($config_list); 
						if (! $this->image_lib->resize()) {
							$this->session->set_flashdata('error_resize_list', 'Error resize list:' . $this->image_lib->display_errors());
							}
						$config_list['image_library'] = 'gd2';
						$config_list['source_image'] = './uploads/images/artikel/list/' . $uploaddata['file_name'];
						$config_list['new_image'] = './uploads/images/artikel/list/' . $uploaddata['file_name'];
						$config_list['maintain_ratio'] = FALSE;
						$config_list['width'] = $this->art_list_width;
						$config_list['height'] = $this->art_list_height;
						$config_list['x_axis'] = '0';
						$config_list['y_axis'] = '0';

						$this->image_lib->clear();
						$this->image_lib->initialize($config_list); 
						if (! $this->image_lib->crop()) {
							$this->session->set_flashdata('error_crop_list', 'Error crop list:' . $this->image_lib->display_errors());
							}

						$gambar = array(
							"gambar_artikel" => str_replace(" ", "_", $this->input->post('judul')) . "_" . $this->session->userdata('username') . '.jpg',
						);

						$this->db->update('artikel', $gambar, array("id_artikel" => $id));

						$this->session->set_flashdata('success_with_upload', 'Sukses Mengedit Artikel dan Gambar!');
				        redirect($this->user_type.'/edit-blog/'.$id,'refresh');
	        	}  
	        }
	    } 
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi hapus_artikel($id)
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menghapus artikel yang ada serta hal-hal 
	| lain yang terasosiasi dengan artikel tersebut.
	| 
	| Fungsi ini menjalankan 4 eksekusi, seperti yang dijelaskan di fungsi tsb.
	|
	| Last edited: 2016-07-05 10:45 
	*/

	public function hapus_artikel($id)
	{
		// Check if user has javascript enabled
        if($this->input->post('ajax') != '1'){
            echo 'false';
            } else { 
                if ($this->input->post('id_artikel', TRUE)) {

                	// #1. Hapus foto-foto yang terasosiasi dengan artikel yang mau dihapus
                	$arr_criteria = array('id_artikel' => $id);
                	$query_hapus_foto_artikel = $this->db->get_where('artikel', $arr_criteria)->result_array();
					
					if ($query_hapus_foto_artikel[0]['gambar_artikel']) {
						unlink('uploads/images/artikel/list/' . $query_hapus_foto_artikel[0]['gambar_artikel']);
						unlink('uploads/images/artikel/original/' . $query_hapus_foto_artikel[0]['gambar_artikel']);
						unlink('uploads/images/artikel/page/' . $query_hapus_foto_artikel[0]['gambar_artikel']);
						unlink('uploads/images/artikel/thumbnail/' . $query_hapus_foto_artikel[0]['gambar_artikel']);
					}

                    // #2. Hapus artikel yang ingin dihapus
                    $this->db->delete('artikel', array("id_artikel" => $id));
                    
                    // #3. Hapus tags artikel yang terasosiasi dengan artikel yang dihapus
                    $this->db->delete('tags_artikel', array("id_artikel" => $id));
                    
                    // #4. Hapus notifikasi yang terasosiasi dengan artikel yang dihapus
                    $this->db->delete('notifikasi', array("id_artikel" => $id));
                    echo 'true';
                } else {
                    echo 'false';
                }   
            }
	}

	public function tambah_tag()
	{
		$tag = $this->input->post('tag', TRUE);

        // Check if user has javascript enabled
        if($this->input->post('ajax') != '1'){
            echo 'false..';
            } else { 
                if ($this->input->post('tag', TRUE)) {
                    $data = array(
                        'tag' => $tag,
                    );

                    $this->db->insert('tags', $data);
                        
                    echo $this->db->insert_id('tags');
                } else {
                    echo 'false';
                }   
            }
	}

	public function tambah_kategori()
	{
		$kategori = $this->input->post('kategori', TRUE);

        // Check if user has javascript enabled
        if($this->input->post('ajax') != '1'){
            echo 'false..';
            } else { 
                if ($this->input->post('kategori', TRUE)) {
                    $data = array(
                        'kategori' => $kategori,
                    );

                    $this->db->insert('kategori', $data);
                        
                    echo $this->db->insert_id('kategori');
                } else {
                    echo 'false';
                }   
            }
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi data_notifikasi()
	|--------------------------------------------------------------------------
	| 
	| Mirip seperti fungsi data_notifikasi() pada Admin/Staf, namun hanya
	| mengambil query notifikasi dengan field untuk_id yang memiliki nilai yang
	| sama dengan nilai session->userdata('id');
	|
	| Last edited: 2016-07-08 10:48
	*/

	public function data_notifikasi()
	{
		$num_notif = $this->db->select('id_notifikasi')->from('notifikasi')->where('notifikasi.untuk_id', $this->session->userdata('id'))->count_all_results();

		$this->load->library('pagination');
		
		$config['base_url'] = site_url($this->user_type.'/data-notifikasi');
		$config['total_rows'] = $num_notif;
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
		
		$this->pagination->initialize($config);

		$data['data1'] = $this->db->get_where('notifikasi', array('notifikasi.untuk_id', $this->session->userdata('id')), $config['per_page'], ($this->uri->segment(3)) ? $this->uri->segment(3) : 0);
		
		$data['data2'] = $this->pagination->create_links();

		$data['data3'] = $num_notif;

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/data_notifikasi', $data);
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi data_pencarian()
	|--------------------------------------------------------------------------
	| 
	| Last edited: 2016-07-08 01:00
	*/

	public function data_pencarian()
	{
		$num_pencarian = $this->db->select('id_pencarian')->from('pencarian')->count_all_results();

		$this->load->library('pagination');
		
		$config['base_url'] = site_url($this->user_type.'/data-pencarian');
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
        $config['next_tagl_close']  = '</li>';

        $config['prev_tag_open']   = '<li>';
        $config['prev_tagl_close']  = '</li>';

        $config['first_tag_open']  = '<li>';
        $config['first_tagl_close'] = '</li>';

        $config['last_tag_open']   = '<li>';
        $config['last_tagl_close']  = '</li>';
		
		$this->pagination->initialize($config);

		$data['data1'] = $this->db->get('pencarian', $config['per_page'], ($this->uri->segment(3)) ? $this->uri->segment(3) : 0);
		
		$data['data2'] = $this->pagination->create_links();

		$data['data3'] = $num_pencarian;

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/data_pencarian', $data);
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi detail_pencarian($kata_kunci)
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menampilkan kata kunci yang mirip dengan kata kunci
	| yang ingin dicari detailnya.
	| 
	| Last edited: 2016-07-02 11:01
	*/

	public function detail_pencarian($kata_kunci)
	{
		$num_kata_kunci = $this->db->select('kata_kunci')->from('pencarian')->like('kata_kunci', $kata_kunci, 'both')->count_all_results();
		
		$this->load->library('pagination');
		
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
		
		$this->pagination->initialize($config);

		$data['data1'] = $this->db->select('pencarian.*')->from('pencarian')->like('kata_kunci', $kata_kunci, 'both')->limit($config['per_page'], ($this->uri->segment(3)) ? $this->uri->segment(3) : 0)->get();
		
		$data['data2'] = $this->pagination->create_links();
		$data['data3'] = $num_kata_kunci;

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/detail_pencarian', $data);
	}

	public function profil($id)
	{
		$data['data1'] = $this->db->get_where('admin', array('id_admin' =>$id))->result_array();

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/profil', $data);
	}

	public function ubah_profil($id)
	{
		if ($this->input->post('simpan', TRUE)) {
			$this->form_validation->set_rules('username', 'Nama Peneliti', 'required|trim|xss_clean');
            $this->form_validation->set_rules('password', 'Jenis Kelamin', 'required|trim|min_length[6]');

            if ($this->form_validation->run() == FALSE) {
            	$this->session->set_flashdata('validasi_eror', 'Username & Password wajib diisi!');
				redirect($this->user_type.'/profil/'.$id,'refresh');
				} else {
					$data = array(
						"nama_admin" => $this->input->post('nama', TRUE),
						"username_admin" => $this->input->post('username', TRUE),
						"password_admin" => $this->input->post('password', TRUE),
						"tanggal_lahir_admin" => $this->input->post('lahir', TRUE),
						"deskripsi_admin" => $this->input->post('deskripsi', TRUE),
					);

					$this->db->update('admin', $data, array('id_admin' => $id));

					$this->load->library('upload');

			        $config['upload_path'] = './uploads/images/profil/original/';
			        $config['file_name'] = $this->session->userdata('type') . "_" . $this->session->userdata('username') . '.jpg';
			        $config['overwrite'] = TRUE;
			        $config['allowed_types'] = 'gif|jpg|jpeg|png';
			        $config['max_size'] = '2000';
			        $config['max_width'] = '5000';
			        $config['max_height'] = '5000';

			        $this->upload->initialize($config);

			        if (! $this->upload->do_upload('foto')) {
			        	$this->session->set_flashdata('update_no_upload', 'Sukses Memperbarui Profil! <br/>' . $this->upload->display_errors());
			        	redirect($this->user_type.'/profil/'.$id,'refresh');
			        } else {
			        	$uploaddata = $this->upload->data();
						$this->load->library('image_lib');

						/* resize and crop thumbnail */
			        	$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = $uploaddata['full_path'];
						$config_thumbnail['new_image'] = './uploads/images/profil/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = TRUE;
						$config_thumbnail['width'] = '64';
						$config_thumbnail['height'] = '64';
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_thumbnail['width'] / $config_thumbnail['height']);
						$config_thumbnail['master_dim'] = ($dim > 0)? "height" : "width";

						$this->image_lib->initialize($config_thumbnail); 
						if (! $this->image_lib->resize()) {
							$this->session->set_flashdata('error_resize_thumbnail', 'Error resize thumbnail:' . $this->image_lib->display_errors());
							redirect($this->user_type.'/profil/'.$id,'refresh');
							}

						$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = './uploads/images/profil/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['new_image'] = './uploads/images/profil/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = FALSE;
						$config_thumbnail['width'] = '64';
						$config_thumbnail['height'] = '64';
						$config_thumbnail['x_axis'] = '0';
						$config_thumbnail['y_axis'] = '0';

						$this->image_lib->initialize($config_thumbnail); 
						if (! $this->image_lib->crop()) {
							$this->session->set_flashdata('error_crop_thumbnail', 'Error crop thumbnail:' . $this->image_lib->display_errors());
							redirect($this->user_type.'/profil/'.$id,'refresh');
							}

						/* resize and crop avatar */
			        	$config_avatar['image_library'] = 'gd2';
						$config_avatar['source_image'] = $uploaddata['full_path'];
						$config_avatar['new_image'] = './uploads/images/profil/avatar/' . $uploaddata['file_name'];
						$config_avatar['maintain_ratio'] = TRUE;
						$config_avatar['width'] = '32';
						$config_avatar['height'] = '32';
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_avatar['width'] / $config_avatar['height']);
						$config_avatar['master_dim'] = ($dim > 0)? "height" : "width";

						$this->image_lib->initialize($config_avatar); 
						if (! $this->image_lib->resize()) {
							$this->session->set_flashdata('error_resize_avatar', 'Error resize avatar:' . $this->image_lib->display_errors());
							redirect($this->user_type.'/profil/'.$id,'refresh');
							}

						$config_avatar['image_library'] = 'gd2';
						$config_avatar['source_image'] = './uploads/images/profil/avatar/' . $uploaddata['file_name'];
						$config_avatar['new_image'] = './uploads/images/profil/avatar/' . $uploaddata['file_name'];
						$config_avatar['maintain_ratio'] = FALSE;
						$config_avatar['width'] = '32';
						$config_avatar['height'] = '32';
						$config_avatar['x_axis'] = '0';
						$config_avatar['y_axis'] = '0';

						$this->image_lib->initialize($config_avatar); 
						if (! $this->image_lib->crop()) {
							$this->session->set_flashdata('error_crop_avatar', 'Error crop avatar:' . $this->image_lib->display_errors());
							redirect($this->user_type.'/profil/'.$id,'refresh');
							}

						/* resize and crop gambar */
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = $uploaddata['full_path'];
						$config_gambar['new_image'] = './uploads/images/profil/page/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = TRUE;
						$config_gambar['width'] = '225';
						$config_gambar['height'] = '320';
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_gambar['width'] / $config_gambar['height']);
						$config_gambar['master_dim'] = ($dim > 0)? "height" : "width";

						$this->image_lib->initialize($config_gambar); 
						if (! $this->image_lib->resize()) {
							$this->session->set_flashdata('error_resize_gambar', 'Error resize gambar:' . $this->image_lib->display_errors());
							redirect($this->user_type.'/profil/'.$id,'refresh');
							}
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = './uploads/images/profil/page/' . $uploaddata['file_name'];
						$config_gambar['new_image'] = './uploads/images/profil/page/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = FALSE;
						$config_gambar['width'] = '225';
						$config_gambar['height'] = '320';
						$config_gambar['x_axis'] = '0';
						$config_gambar['y_axis'] = '0';

						$this->image_lib->clear();
						$this->image_lib->initialize($config_gambar); 
						if (! $this->image_lib->crop()) {
							$this->session->set_flashdata('error_crop_gambar', 'Error crop gambar:' . $this->image_lib->display_errors());
							redirect($this->user_type.'/profil/'.$id,'refresh');
							}

						$gambar = array(
							"foto_admin" => $this->session->userdata('type') . "_" . $this->session->userdata('username') . '.jpg',
						);

						$this->db->update('admin', $gambar, array("id_admin" => $id));

						$this->session->set_flashdata('update_with_upload', 'Sukses Memperbarui Profil dan Foto!');
						redirect($this->user_type.'/profil/'.$id,'refresh');
			        }
			        
				}
		} 
	}

}

/* End of file Kontributor.php */
/* Location: ./application/controllers/Kontributor.php */