<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Staf extends CI_Controller {

	var $user_type;
	var $nav;
	var $menu;
	var $email_situs;
	var $password;
	var $art_thumbnail_height;
	var $art_thumbnail_width;
	var $art_page_height;
	var $art_page_width;
	var $art_list_height;
	var $art_list_width;
	var $gal_thumbnail_width;
	var $gal_thumbnail_height;
	var $gal_view_width;
	var $gal_view_height;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ModelArtikel');
		$this->load->model('ModelFoto');
		$this->load->model('ModelNotifikasi');
		$this->load->model('ModelKategori');
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
			"review" => $this->analitik->review_artikel(),
			"pesan" => $this->analitik->review_pesan(),
			"nama" => $this->info->nama_situs(),
			"tipe" => $this->user_type,
		);

		$this->menu = array(
			"tipe" => $this->user_type,
		);

		$this->email_situs = $this->info->email();
		$this->password = $this->info->password();

		$this->art_thumbnail_width = '270';
		$this->art_thumbnail_height = '170';
		
		$this->art_page_width = '590';
		$this->art_page_height = '340';
		
		$this->art_list_width = '290';
		$this->art_list_height = '250';

		$this->gal_thumbnail_width = '201';
		$this->gal_thumbnail_height = '201';

		$this->gal_view_width = '960';
		$this->gal_view_height = '480';
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

	public function data_halaman()
	{
		$jumlah_halaman = $this->db->select('id_halaman')->from('halaman')->count_all_results();
		
		$this->load->library('pagination');
		$config['base_url'] = site_url($this->user_type.'/data-halaman');
		
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
        $config['next_tagl_close']  = '</li>';

        $config['prev_tag_open']   = '<li>';
        $config['prev_tagl_close']  = '</li>';

        $config['first_tag_open']  = '<li>';
        $config['first_tagl_close'] = '</li>';

        $config['last_tag_open']   = '<li>';
        $config['last_tagl_close']  = '</li>';
		
		$this->pagination->initialize($config);

		$data['data1'] = $this->db->get('halaman', $config['per_page'], ($this->uri->segment(3)) ? $this->uri->segment(3) : 0);
		
		$data['data2'] = $this->pagination->create_links();

		$data['data3'] = $jumlah_halaman;

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/data_halaman', $data);
	}

	public function tambah_halaman()
	{

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/tambah_halaman', $data);
	}

	public function buat_halaman()
	{
		if ($this->input->post('isi', TRUE)) {
	      	$this->form_validation->set_rules('isi', 'Isi Artikel', 'trim|required|xss_clean');
	      	$this->form_validation->set_rules('judul', 'Judul Artikel', 'trim|required|xss_clean');
	        if ($this->form_validation->run() == FALSE) {
	          $this->session->set_flashdata('error_form_validation', 'Semua isian harus diisi!');
	          redirect($this->user_type.'/tambah-halaman','refresh');
	        	} else {
		        	$data = array(
			          "nama_halaman" => $this->input->post('judul', TRUE),
			          "isi_halaman" => $this->input->post('isi', TRUE),
			          "keterangan_halaman" => $this->input->post('keterangan', TRUE),
			        );

			        $this->db->insert('halaman', $data);

			        $idHalaman = $this->db->insert_id("halaman");

		        $this->load->library('upload');

		        $config['upload_path'] = './uploads/images/halaman/original/';
		        $config['file_name'] = str_replace(" ", "_", $this->input->post('judul')) . "_" . $this->session->userdata('username') . '.jpg';
		        $config['overwrite'] = TRUE;
		        $config['allowed_types'] = 'gif|jpg|jpeg|png';
		        $config['max_size'] = '2000';
		        $config['max_width'] = '2500';
		        $config['max_height'] = '2500';

		        $this->upload->initialize($config);

		        if (! $this->upload->do_upload('gambar')) {
		        	$this->session->set_flashdata('insert_success_no_upload', 'Sukses Membuat Halaman Baru! <br/>' . $this->upload->display_errors());
		        	redirect($this->user_type.'/tambah-halaman','refresh');
			        } else {
			        	$uploaddata = $this->upload->data();
						$this->load->library('image_lib');

						/* resize and crop beranda */
			        	$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = $uploaddata['full_path'];
						$config_thumbnail['new_image'] = './uploads/images/halaman/beranda/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = TRUE;
						$config_thumbnail['width'] = '960';
						$config_thumbnail['height'] = '350';
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_thumbnail['width'] / $config_thumbnail['height']);
						$config_thumbnail['master_dim'] = ($dim > 0)? "height" : "width";

						$this->image_lib->initialize($config_thumbnail); 
						if (! $this->image_lib->resize()) {
							$this->session->set_flashdata('error_resize_thumbnail', 'Error resize thumbnail:' . $this->image_lib->display_errors());
							}

						$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = './uploads/images/halaman/beranda/' . $uploaddata['file_name'];
						$config_thumbnail['new_image'] = './uploads/images/halaman/beranda/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = FALSE;
						$config_thumbnail['width'] = '960';
						$config_thumbnail['height'] = '350';
						$config_thumbnail['x_axis'] = '0';
						$config_thumbnail['y_axis'] = '0';

						$this->image_lib->initialize($config_thumbnail); 
						if (! $this->image_lib->crop()) {
							$this->session->set_flashdata('error_crop_thumbnail', 'Error crop thumbnail:' . $this->image_lib->display_errors());
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

						$this->image_lib->initialize($config_gambar); 
						if (! $this->image_lib->resize()) {
							$this->session->set_flashdata('error_resize_gambar', 'Error resize page:' . $this->image_lib->display_errors());
							}
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = './uploads/images/halaman/page/' . $uploaddata['file_name'];
						$config_gambar['new_image'] = './uploads/images/halaman/page/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = FALSE;
						$config_gambar['width'] = '590';
						$config_gambar['height'] = '340';
						$config_gambar['x_axis'] = '0';
						$config_gambar['y_axis'] = '0';

						$this->image_lib->clear();
						$this->image_lib->initialize($config_gambar); 
						if (! $this->image_lib->crop()) {
							$this->session->set_flashdata('error_crop_gambar', 'Error crop page:' . $this->image_lib->display_errors());
							}

						$gambar = array(
							"gambar_halaman" => str_replace(" ", "_", $this->input->post('judul')) . '.jpg',
						);

						$this->db->update('halaman', $gambar, array('id_halaman' => $idHalaman));

				        $this->session->set_flashdata('success_insert_with_upload', 'Sukses Membuat Artikel dan Gambar Baru!');
				        redirect($this->user_type.'/tambah-halaman','refresh');
	        	}  
	        }
	    } 
	}

	public function edit_halaman($id)
	{
		$data['data1'] = $this->db->get_where('halaman', array('id_halaman' => $id))->result_array();
	
		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
    	$this->load->view('backend/'.$this->user_type.'/edit_halaman', $data);
	}

	public function ubah_halaman($id)
	{
		if ($this->input->post('isi', TRUE)) {
	      	$this->form_validation->set_rules('isi', 'Isi Artikel', 'trim|required|xss_clean');
	      	$this->form_validation->set_rules('judul', 'Judul Artikel', 'trim|required|xss_clean');
	        if ($this->form_validation->run() == FALSE) {
	          $this->session->set_flashdata('error_form_validation', 'Semua isian harus diisi!');
	          redirect($this->user_type.'/edit-halaman/'.$id,'refresh');
	        	} else {
		        	$data = array(
			          "nama_halaman" => $this->input->post('judul', TRUE),
			          "isi_halaman" => $this->input->post('isi', TRUE),
			          "keterangan_halaman" => $this->input->post('keterangan', TRUE),
			        );

			        $this->db->update('halaman', $data, array('id_halaman' => $id));

		        $this->load->library('upload');

		        $config['upload_path'] = './uploads/images/halaman/original/';
		        $config['file_name'] = str_replace(" ", "_", $this->input->post('judul')) . "_" . $this->session->userdata('username') . '.jpg';
		        $config['overwrite'] = TRUE;
		        $config['allowed_types'] = 'gif|jpg|jpeg|png';
		        $config['max_size'] = '2000';
		        $config['max_width'] = '2500';
		        $config['max_height'] = '2500';

		        $this->upload->initialize($config);

		        if (! $this->upload->do_upload('gambar')) {
		        	$this->session->set_flashdata('insert_success_no_upload', 'Sukses Membuat Halaman Baru! <br/>' . $this->upload->display_errors());
		        	redirect($this->user_type.'/edit-halaman/'.$id,'refresh');
			        } else {
			        	$uploaddata = $this->upload->data();
						$this->load->library('image_lib');

						/* resize and crop beranda */
			        	$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = $uploaddata['full_path'];
						$config_thumbnail['new_image'] = './uploads/images/halaman/beranda/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = TRUE;
						$config_thumbnail['width'] = '960';
						$config_thumbnail['height'] = '350';
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_thumbnail['width'] / $config_thumbnail['height']);
						$config_thumbnail['master_dim'] = ($dim > 0)? "height" : "width";

						$this->image_lib->initialize($config_thumbnail); 
						if (! $this->image_lib->resize()) {
							$this->session->set_flashdata('error_resize_thumbnail', 'Error resize thumbnail:' . $this->image_lib->display_errors());
							}

						$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = './uploads/images/halaman/beranda/' . $uploaddata['file_name'];
						$config_thumbnail['new_image'] = './uploads/images/halaman/beranda/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = FALSE;
						$config_thumbnail['width'] = '960';
						$config_thumbnail['height'] = '350';
						$config_thumbnail['x_axis'] = '0';
						$config_thumbnail['y_axis'] = '0';

						$this->image_lib->initialize($config_thumbnail); 
						if (! $this->image_lib->crop()) {
							$this->session->set_flashdata('error_crop_thumbnail', 'Error crop thumbnail:' . $this->image_lib->display_errors());
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

						$this->image_lib->initialize($config_gambar); 
						if (! $this->image_lib->resize()) {
							$this->session->set_flashdata('error_resize_gambar', 'Error resize page:' . $this->image_lib->display_errors());
							}
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = './uploads/images/halaman/page/' . $uploaddata['file_name'];
						$config_gambar['new_image'] = './uploads/images/halaman/page/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = FALSE;
						$config_gambar['width'] = '590';
						$config_gambar['height'] = '340';
						$config_gambar['x_axis'] = '0';
						$config_gambar['y_axis'] = '0';

						$this->image_lib->clear();
						$this->image_lib->initialize($config_gambar); 
						if (! $this->image_lib->crop()) {
							$this->session->set_flashdata('error_crop_gambar', 'Error crop page:' . $this->image_lib->display_errors());
							}

						$gambar = array(
							"gambar_halaman" => str_replace(" ", "_", $this->input->post('judul')) . '.jpg',
						);

						$this->db->update('halaman', $gambar, array('id_halaman' => $id));

				        $this->session->set_flashdata('success_insert_with_upload', 'Sukses Membuat Artikel dan Gambar Baru!');
				        redirect($this->user_type.'/edit-halaman/'.$id,'refresh');
	        	}  
	        }
	    } 
	}

	public function detail_halaman($id)
	{
		$data['data1'] = $this->db->get_where('halaman', array('id_halaman' => $id))->result_array();
	
		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/detail_halaman', $data);
	}

	public function hapus_halaman($id)
	{
		// Check if user has javascript enabled
        if($this->input->post('ajax') != '1'){
            echo 'false';
            } else { 
                if ($this->input->post('id_halaman', TRUE)) {

                	// #1. Hapus foto-foto yang terasosiasi dengan halaman yang mau dihapus
                	$arr_criteria = array('id_halaman' => $id);
                	$query_hapus_foto_halaman = $this->db->get_where('halaman', $arr_criteria)->result_array();
					
					unlink('uploads/images/halaman/beranda/' . $query_hapus_foto_halaman[0]['gambar_halaman']);
					unlink('uploads/images/halaman/original/' . $query_hapus_foto_halaman[0]['gambar_halaman']);
					unlink('uploads/images/halaman/page/' . $query_hapus_foto_halaman[0]['gambar_halaman']);

                    // #2. Hapus halaman yang ingin dihapus
                    $this->db->delete('halaman', array("id_halaman" => $id));
                    
                    echo 'true';
                } else {
                    echo 'false';
                }   
            }
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi data_berita()
	|--------------------------------------------------------------------------
	|
	| Last edited: 2016-07-08 00:44 
	*/

	public function data_berita()
	{
		$total_rows = $this->db->select('artikel.*')->from('artikel')->where('artikel.jenis_artikel', 'Berita')->count_all_results();

		$this->load->library('pagination');
		$config['base_url'] = site_url($this->user_type.'/data-berita');
		
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

		$data['data1'] = $this->ModelArtikel->gabung_semua_artikel_berita_dengan_semua_nama_penulis($config['per_page'], ($this->uri->segment(3)) ? $this->uri->segment(3) : 0);
		
		$data['data2'] = $this->pagination->create_links();

		$data['data3'] = $total_rows;

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/data_berita', $data);
	}

	public function tambah_berita()
	{
		$data['data1'] = $this->db->get('tags')->result_array();
		$data['data2'] = $this->db->get('kategori')->result_array();

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/tambah_berita', $data);
	}

	public function pasang_berita()
	{
		if ($this->input->post('isi', TRUE)) {
	      	$this->form_validation->set_rules('isi', 'Isi Artikel', 'trim|required|xss_clean');
	      	$this->form_validation->set_rules('judul', 'Judul Artikel', 'trim|required|xss_clean');
	      	$this->form_validation->set_rules('tags[]', 'Tags Artikel', 'required');
	        if ($this->form_validation->run() == FALSE) {
	          $this->session->set_flashdata('error_form_validation', 'Semua isian harus diisi!');
	          redirect($this->user_type.'/tambah_berita','refresh');
	        	} else {
		        	$data = array(
			          "judul_artikel" => $this->input->post('judul', TRUE),
			          "isi_artikel" => $this->input->post('isi', TRUE),
			          "id_kategori" => $this->input->post('kategori', TRUE),
			          "jenis_artikel" => "Berita",
			          "tanggal_artikel" => date("Y-m-d H:i:s"),
			          "status_artikel" => "Published",
			          "id_penulis_artikel" => $this->session->userdata('id'),
			        );

			        $this->db->insert('artikel', $data);

			        $idArtikel = $this->db->insert_id("artikel");

			        $tags_artikel['id_artikel'] = $idArtikel;
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
		        	$this->session->set_flashdata('insert_success_no_upload', 'Sukses Menyimpan Artikel Baru! <br/>' . $this->upload->display_errors());
		        	redirect($this->user_type.'/tambah_berita','refresh');
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

				        $this->session->set_flashdata('success_insert_with_upload', 'Sukses Membuat Artikel dan Gambar Baru!');
				        redirect($this->user_type.'/tambah_berita','refresh');
	        	}  
	        }
	    } 
	}

	public function edit_berita($id)
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
    	$this->load->view('backend/'.$this->user_type.'/edit_berita', $data);
	}

	public function ubah_berita($id)
	{
		if ($this->input->post('isi', TRUE)) {
	      	$this->form_validation->set_rules('isi', 'Isi Artikel', 'trim|required|xss_clean');
	      	$this->form_validation->set_rules('judul', 'Judul Artikel', 'trim|required|xss_clean');
	      	$this->form_validation->set_rules('tags[]', 'Tags Artikel', 'required');
	        if ($this->form_validation->run() == FALSE) {
	          	$this->session->set_flashdata('error_form_validation', 'Error Form Validation!');
	          	redirect($this->user_type.'/edit_berita/'.$id,'refresh');
	        	} else {
		        $data = array(
			          "judul_artikel" => $this->input->post('judul', TRUE),
			          "isi_artikel" => $this->input->post('isi', TRUE),
			          "id_kategori" => $this->input->post('kategori', TRUE),
			          "tanggal_artikel" => date('Y-m-d H:i:s'),
			          "status_artikel" => 'Edited',
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
		        	redirect($this->user_type.'/edit_berita/'.$id,'refresh');
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
				        redirect($this->user_type.'/edit_berita/'.$id,'refresh');
	        	}  
	        }
	    } 
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi data_blog()
	|--------------------------------------------------------------------------
	|
	| Last edited: 2016-07-08 00:44 
	*/

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
	          	redirect($this->user_type.'/edit_blog/'.$id,'refresh');
	        	} else {
		        $data = array(
			          "judul_artikel" => $this->input->post('judul', TRUE),
			          "isi_artikel" => $this->input->post('isi', TRUE),
			          "id_kategori" => $this->input->post('kategori', TRUE),
			          "tanggal_artikel" => date('Y-m-d H:i:s'),
			          "status_artikel" => 'Published',
			        );

			        $this->db->update('artikel', $data, array('id_artikel' => $id));

			        $this->db->delete('tags_artikel', array("id_artikel" => $id));

			        $tags_artikel['id_artikel'] = $id;
	                foreach ($_POST['tags'] as $selected) {
	                $tags_artikel['id_tag'] = $selected;
	                $this->db->insert("tags_artikel", $tags_artikel);
	                }

	            	$this->kirim_notifikasi_ke_penulis_blog($this->input->post('judul'), $id);

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
		        	redirect($this->user_type.'/edit_blog/'.$id,'refresh');
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
				        redirect($this->user_type.'/edit_blog/'.$id,'refresh');
	        	}  
	        }
	    } 
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi kirim_notifikasi_ke_penulis_blog($judul, $id)
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk memasukkan notifikasi baru ke dalam database 
	| setelah sebuah blog disetujui oleh Staf/Admin.
	| 
	| Fungsi ini dipakai di ubah_blog($id).
	|
	| Last edited: 2016-07-04 20:43 
	*/

	public function kirim_notifikasi_ke_penulis_blog($judul, $id)
	{
		$this->notifikasi->kirim_notifikasi_ke_penulis_blog($judul, $id);
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
	| Last edited: 2016-06-22 15:45 
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

	/*
	|--------------------------------------------------------------------------
	| Fungsi data_album()
	|--------------------------------------------------------------------------
	|
	| Last edited: 2016-07-08 00:46 
	*/
	
	public function data_album()
	{
		$total_rows = $this->db->select('id_album')->from('album')->count_all_results();

		$this->load->library('pagination');
		$config['base_url'] = site_url($this->user_type.'/data-album');
		
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

		$data['data1'] = $this->ModelFoto->gabung_album_dengan_nama_admin($config['per_page'], ($this->uri->segment(3)) ? $this->uri->segment(3) : 0);
		
		$data['data2'] = $this->pagination->create_links();

		$data['data3'] = $total_rows;

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/data_album', $data);
	}

	public function tambah_album()
	{
		$data['data1'] = $this->input->post('jumlah', TRUE);

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/tambah_album', $data);
	}

	public function pasang_album()
	{
		if ($this->input->post('judul', TRUE)) {
	      	$this->form_validation->set_rules('judul', 'Judul album', 'trim|required|xss_clean');
	        if ($this->form_validation->run() == FALSE) {
	          $this->session->set_flashdata('error_form_validation', 'Error Form Validation!');
	          redirect($this->user_type.'/data-album','refresh');
	        	} else {
		        	$data = array(
			          "judul_album" => $this->input->post('judul', TRUE),
			          "deskripsi_album" => $this->input->post('isi', TRUE),
			          "tanggal_album" => date("Y-m-d H:i:s"),
			          "status_album" => 'Published',
			          "id_admin" => $this->session->userdata('id'),
			        );

			        $this->db->insert('album', $data);

			        $idalbum = $this->db->insert_id("album");

			        $foto_album['id_album'] = $idalbum;
	                if ($this->input->post('submit') && !empty($_FILES['foto']['name'])) {
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
				                $config['file_name'] = str_replace(" ", "_", $this->input->post('judul')) . "_" . $i . '.jpg';
				                $config['overwrite'] = TRUE;
				                $config['max_size'] = '4000';
						        $config['max_width'] = '6000';
						        $config['max_height'] = '4000';

				                $this->load->library('upload', $config);
				                $this->upload->initialize($config);
				                if(!$this->upload->do_upload('userFile')){
				                    $this->session->set_flashdata('insert_success_no_upload', 'Sebagian/semua foto tidak bisa tersimpan, pembuatan album gagal! <br/>' . $this->upload->display_errors());
		        					redirect($this->user_type.'/data-album','refresh');
				                } else {
				                	$uploaddata = $this->upload->data();
									$this->load->library('image_lib');

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

									$this->image_lib->initialize($config_thumbnail); 
									if (! $this->image_lib->resize()) {
										$this->session->set_flashdata('error_resize_thumbnail', 'Error resize thumbnail:' . $this->image_lib->display_errors());
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

									$this->image_lib->initialize($config_thumbnail); 
									if (! $this->image_lib->crop()) {
										$this->session->set_flashdata('error_crop_thumbnail', 'Error crop thumbnail:' . $this->image_lib->display_errors());
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

									$this->image_lib->initialize($config_view); 
									if (! $this->image_lib->resize()) {
										$this->session->set_flashdata('error_resize_view', 'Error resize view:' . $this->image_lib->display_errors());
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

									$this->image_lib->initialize($config_view); 
									if (! $this->image_lib->crop()) {
										$this->session->set_flashdata('error_crop_view', 'Error crop view:' . $this->image_lib->display_errors());
										}

				                    $foto_album['path_view'] = $config['file_name'];
				                    $this->db->insert('foto_album', $foto_album);
				                } // end if this->upload
				            } // end for
	                	} // end foreach

			            if(!empty($uploadData)){
			                $statusMsg = 'Some problem occurred, please try again.';
			                $this->session->set_flashdata('statusMsg',$statusMsg);
			            }
	                } // end if this->input->post
	            $this->session->set_flashdata('success_insert_with_upload', 'Sukses membuat album baru!');
	            redirect($this->user_type.'/data-album','refresh');
	        } // end ifelse validation run
	    } // end if this->input->post description
	}

	public function edit_album($id)
	{
		$data['data1'] = $this->ModelFoto->lihat_album_tertentu($id);

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/edit_album', $data);
	}

	public function ubah_album($id)
	{
		if ($this->input->post('judul', TRUE)) {
	      	$this->form_validation->set_rules('judul', 'Judul album', 'trim|required|xss_clean');
	        if ($this->form_validation->run() == FALSE) {
	          $this->session->set_flashdata('error_form_validation', 'Error Form Validation!');
	          redirect($this->user_type.'/data-album','refresh');
	        	} else {
		        	$data = array(
			          "judul_album" => $this->input->post('judul', TRUE),
			          "deskripsi_album" => $this->input->post('isi', TRUE),
			          "tanggal_album" => date("Y-m-d H:i:s"),
			          "status_album" => 'Edited',
			          "id_admin" => $this->session->userdata('id'),
			        );

			        $this->db->update('album', $data, array('id_album' => $id));

			        $idalbum = $id;

			        $foto_album['id_album'] = $idalbum;

	                if ($this->input->post('submit') && !empty($_FILES['foto']['name'])) {
	                	$files = $_FILES;

	                	// untuk mendapatkan id_foto_album masing-masing foto yang akan diupdate
				        $this->db->select('id_foto_album')->from('foto_album')->where('id_album', $id);
				        $id_foto_album = $this->db->get()->result_array();

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
				                $config['file_name'] = str_replace(" ", "_", $this->input->post('judul')) . "_" . $i . '.jpg';
				                $config['max_size'] = '4000';
						        $config['max_width'] = '6000';
						        $config['max_height'] = '4000';

				                $this->load->library('upload', $config);
				                $this->upload->initialize($config);
				                if(!$this->upload->do_upload('userFile')){
				                    $this->session->set_flashdata('insert_success_no_upload', 'Sebagian/semua foto tidak bisa tersimpan, pembuatan album gagal! <br/>' . $this->upload->display_errors());
		        					redirect($this->user_type.'/data-album','refresh');
				                } else {
				                	$uploaddata = $this->upload->data();
									$this->load->library('image_lib');

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

									$this->image_lib->initialize($config_thumbnail); 
									if (! $this->image_lib->resize()) {
										$this->session->set_flashdata('error_resize_thumbnail', 'Error resize thumbnail:' . $this->image_lib->display_errors());
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

									$this->image_lib->initialize($config_thumbnail); 
									if (! $this->image_lib->crop()) {
										$this->session->set_flashdata('error_crop_thumbnail', 'Error crop thumbnail:' . $this->image_lib->display_errors());
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

									$this->image_lib->initialize($config_view); 
									if (! $this->image_lib->resize()) {
										$this->session->set_flashdata('error_resize_view', 'Error resize view:' . $this->image_lib->display_errors());
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

									$this->image_lib->initialize($config_view); 
									if (! $this->image_lib->crop()) {
										$this->session->set_flashdata('error_crop_view', 'Error crop view:' . $this->image_lib->display_errors());
										}

				                    $foto_album['path_view'] = $config['file_name'];
				                    $this->db->update('foto_album', $foto_album, array('id_foto_album' => $id_foto_album[$i]['id_foto_album']));
				                } // end if this->upload
				            } // end for
	                	} // end foreach

			            if(!empty($uploadData)){
			                $statusMsg = 'Some problem occurred, please try again.';
			                $this->session->set_flashdata('statusMsg',$statusMsg);
			            }
	                } // end if this->input->post
	            $this->session->set_flashdata('success_insert_with_upload', 'Sukses mengedit album!');
	            redirect($this->user_type.'/data-album','refresh');
	        } // end ifelse validation run
	    } // end if this->input->post description
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi hapus_album($id)
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menghapus album yang ada serta hal-hal 
	| lain yang terasosiasi dengan album tersebut.
	| 
	| Fungsi ini menjalankan 4 eksekusi, seperti yang dijelaskan di fungsi tsb.
	|
	| Last edited: 2016-06-22 15:44 
	*/

	public function hapus_album($id)
	{
		// Check if user has javascript enabled
        if($this->input->post('ajax') != '1'){
            echo 'false';
            } else { 
                if ($this->input->post('id_album', TRUE)) {
                	$arr_criteria = array('id_album' => $id);
                    $query_foto_album = $this->db->get_where('foto_album', $arr_criteria);

                    #1. Hapus foto-foto yang ada di dalam server
                    foreach ($query_foto_album->result_array() as $key => $foto) {
                    	if ($foto['path_view']) {
                    		unlink('uploads/images/album/original/' . $foto['path_view']);
	                    	unlink('uploads/images/album/thumbnail/' . $foto['path_view']);
	                    	unlink('uploads/images/album/view/' . $foto['path_view']);
                    	}
                    }
                    
                    #2. Hapus data yang terasosiasi dengan album yang ingin dihapus di tabel album
                    $this->db->delete('album', array("id_album" => $id));
                    #3. Hapus data yang terasosiasi dengan album yang ingin dihapus di tabel foto_album
                    $this->db->delete('foto_album', array("id_album" => $id));
                    #4. Hapus data yang terasosiasi dengan album yang ingin dihapus di tabel notifikasi
                    $this->db->delete('notifikasi', array("id_album" => $id));
                    echo 'true';
                } else {
                    echo 'false';
                }   
            }
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi data_kategori()
	|--------------------------------------------------------------------------
	|
	| Last edited: 2016-07-08 00:49 
	*/

	public function data_kategori()
	{
		$total_rows = $this->db->select('kategori.*')->from('kategori')->count_all_results();

		$this->load->library('pagination');
		$config['base_url'] = site_url($this->user_type.'/data-kategori');
		
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

		$data['data1'] = $this->ModelKategori->hitung_jumlah_artikel_perkategori($config['per_page'], ($this->uri->segment(3)) ? $this->uri->segment(3) : 0);
		
		$data['data2'] = $this->pagination->create_links();

		$data['data3'] = $total_rows;

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/data_kategori', $data);
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

	public function edit_kategori($id)
	{
        $id_kategori = $this->input->post('id_kategori', TRUE);
        $kategori = $this->input->post('kategori', TRUE);

        // Check if user has javascript enabled
        if($this->input->post('ajax') != '1'){
            echo 'false..';
            } else { 
                if ($this->input->post('kategori', TRUE)) {
                    $data = array(
                        'kategori' => $kategori,
                    );
                    $condition = array(
                    	'id_kategori' => $id,
                    );

                    $this->db->update('kategori', $data, $condition);;
                        
                    echo 'true';
                } else {
                    echo 'false';
                }   
            }
	}

	public function hapus_kategori($id)
	{
		// Check if user has javascript enabled
        if($this->input->post('ajax') != '1'){
            echo 'false..';
            } else { 
                if ($this->input->post('id_kategori', TRUE)) {
                	// #1. Cari artikel yang terasosiasi dengan kategori yang akan dihapus, lalu delete tags yang terasosiasi dengan artikel2 tersebut
                	// dan gambar artikel yang ada di server
                	$arr_criteria = array('id_kategori' => $id);
                	$query_artikel = $this->db->get_where('artikel', $arr_criteria);
                	foreach ($query_artikel->result_array() as $artikel) {
                		unlink('uploads/images/artikel/list/' . $artikel['gambar_artikel']);
                		unlink('uploads/images/artikel/original/' . $artikel['gambar_artikel']);
                		unlink('uploads/images/artikel/page/' . $artikel['gambar_artikel']);
                		unlink('uploads/images/artikel/thumbnail/' . $artikel['gambar_artikel']);
                		$array_id_artikel = array('id_artikel' => $artikel['id_artikel']);
                		$this->db->delete('tags_artikel', $array_id_artikel);
                	}

                	// #2. Cari dan hapus artikel yang terasosiasi dengan kategori yang akan dihapus
                    $array_artikel = array('id_kategori' => $id);
                    $this->db->delete('artikel', $array);

                    // #3. Cari dan hapus kategori yang ingin dihapus
                    $array_kategori = array('id_kategori' => $id);
                    $this->db->delete('kategori', $array_kategori);

                    echo 'true';
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
	| Fungsi di bawah ini adalah untuk menampilkan seluruh notifikasi yang ada.
	| 
	| Last edited: 2016-07-01 10:43
	*/

	public function data_notifikasi()
	{
		$num_notif = $this->db->select('id_notifikasi')->from('notifikasi')->count_all_results();

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

		$data['data1'] = $this->db->get('notifikasi', $config['per_page'], ($this->uri->segment(3)) ? $this->uri->segment(3) : 0);
		
		$data['data2'] = $this->pagination->create_links();

		$data['data3'] = $num_notif;

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/data_notifikasi', $data);
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi data_tugas()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menampilkan seluruh artikel yang pending.
	| 
	| Last edited: 2016-07-08 01:03
	*/

	public function data_tugas()
	{
		$total_rows = $this->db->select('artikel.*')->from('artikel')->where('artikel.status_artikel', 'Pending')->count_all_results();

		$this->load->library('pagination');
		$config['base_url'] = site_url($this->user_type.'/data-tugas');
		
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

		$data['data1'] = $this->ModelArtikel->gabung_semua_artikel_blog_pending_dengan_semua_nama_penulis($config['per_page'], ($this->uri->segment(3)) ? $this->uri->segment(3) : 0);
		
		$data['data2'] = $this->pagination->create_links();

		$data['data3'] = $total_rows;

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/data_tugas', $data);
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi data_pelanggan()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menampilkan seluruh pelanggan yang berlangganan newsletter.
	| 
	| Last edited: 2016-07-08 00:57
	*/

	public function data_pelanggan()
	{
		$num_pelanggan = $this->db->select('id_pelanggan')->from('pelanggan')->count_all_results();

		$this->load->library('pagination');
		
		$config['base_url'] = site_url($this->user_type.'/data-pelanggan');
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
        $config['next_tagl_close']  = '</li>';

        $config['prev_tag_open']   = '<li>';
        $config['prev_tagl_close']  = '</li>';

        $config['first_tag_open']  = '<li>';
        $config['first_tagl_close'] = '</li>';

        $config['last_tag_open']   = '<li>';
        $config['last_tagl_close']  = '</li>';
		
		$this->pagination->initialize($config);

		$data['data1'] = $this->db->get('pelanggan', $config['per_page'], ($this->uri->segment(3)) ? $this->uri->segment(3) : 0);
		
		$data['data2'] = $this->pagination->create_links();

		$data['data3'] = $num_pelanggan;

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/data_pelanggan', $data);
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi data_newsletter()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menampilkan seluruh newsletter.
	| 
	| Last edited: 2016-07-08 00:51
	*/

	public function data_newsletter()
	{
		$total_rows = $this->db->select('newsletter.*')->from('newsletter')->count_all_results();

		$this->load->library('pagination');
		$config['base_url'] = site_url($this->user_type.'/data-newsletter');
		
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

		$data['data1'] = $this->ModelArtikel->gabung_semua_newsletter_dengan_semua_nama_penulis($config['per_page'], ($this->uri->segment(3)) ? $this->uri->segment(3) : 0);
		
		$data['data2'] = $this->pagination->create_links();

		$data['data3'] = $total_rows;

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/data_newsletter', $data);
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi tambah_newsletter()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menampilkan halaman untuk membuat 
	| newsletter ke pelanggan yang berlangganan newsletter.
	| 
	| Last edited: 2016-07-04 20:57
	*/

	public function tambah_newsletter()
	{
		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/tambah_newsletter', $data);
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi buat_newsletter()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menampilkan halaman untuk membuat 
	| newsletter ke pelanggan yang berlangganan newsletter.
	| 
	| Last edited: 2016-07-04 20:57
	*/

	public function buat_newsletter()
	{
		if ($this->input->post('isi', TRUE)) {
	      	$this->form_validation->set_rules('isi', 'Isi Artikel', 'trim|required|xss_clean');
	      	$this->form_validation->set_rules('judul', 'Judul Artikel', 'trim|required|xss_clean');
	      	
	        if ($this->form_validation->run() == FALSE) {
	          $this->session->set_flashdata('error_form_validation', 'Semua isian harus diisi!');
	          redirect($this->user_type.'/tambah-newsletter','refresh');
	        	} else {
		        	$data = array(
			          "judul_newsletter" => $this->input->post('judul', TRUE),
			          "isi_newsletter" => $this->input->post('isi', TRUE),
			          "tanggal_newsletter" => date("Y-m-d H:i:s"),
			          "id_penulis_newsletter" => $this->session->userdata('id'),
			          "status_newsletter" => 'Created',
			        );

			        $this->db->insert('newsletter', $data);

			        $idNewsletter = $this->db->insert_id("newsletter");

		        $this->load->library('upload');

		        $config['upload_path'] = './uploads/images/newsletter/original/';
		        $config['file_name'] = str_replace(" ", "_", $this->input->post('judul')) . "_" . $this->session->userdata('username') . '.jpg';
		        $config['overwrite'] = TRUE;
		        $config['allowed_types'] = 'gif|jpg|jpeg|png';
		        $config['max_size'] = '2000';
		        $config['max_width'] = '2500';
		        $config['max_height'] = '2500';

		        $this->upload->initialize($config);

		        if (! $this->upload->do_upload('gambar')) {
		        	$this->session->set_flashdata('insert_success_no_upload', 'Sukses Menyimpan Newsletter Baru! <br/>' . $this->upload->display_errors());
		        	redirect($this->user_type.'/tambah-newsletter','refresh');
			        } else {
			        	$uploaddata = $this->upload->data();
						$this->load->library('image_lib');

						/* resize and crop pic for email */
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = $uploaddata['full_path'];
						$config_gambar['new_image'] = './uploads/images/newsletter/email/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = TRUE;
						$config_gambar['width'] = '590';
						$config_gambar['height'] = '340';
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_gambar['width'] / $config_gambar['height']);
						$config_gambar['master_dim'] = ($dim > 0)? "height" : "width";

						$this->image_lib->initialize($config_gambar); 
						if (! $this->image_lib->resize()) {
							$this->session->set_flashdata('error_resize_gambar', 'Error resize page:' . $this->image_lib->display_errors());
							}
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = './uploads/images/newsletter/email/' . $uploaddata['file_name'];
						$config_gambar['new_image'] = './uploads/images/newsletter/email/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = FALSE;
						$config_gambar['width'] = '590';
						$config_gambar['height'] = '340';
						$config_gambar['x_axis'] = '0';
						$config_gambar['y_axis'] = '0';

						$this->image_lib->clear();
						$this->image_lib->initialize($config_gambar); 
						if (! $this->image_lib->crop()) {
							$this->session->set_flashdata('error_crop_gambar', 'Error crop page:' . $this->image_lib->display_errors());
							}

						$gambar = array(
							"gambar_newsletter" => str_replace(" ", "_", $this->input->post('judul')) . "_" . $this->session->userdata('username') . '.jpg',
						);

						$this->db->update('newsletter', $gambar, array('id_newsletter' => $idNewsletter));

				        $this->session->set_flashdata('success_insert_with_upload', 'Sukses Membuat Newsletter dan Gambar Baru!');
				        redirect($this->user_type.'/tambah-newsletter','refresh');
	        	}  
	        }
	    } 
	}

	public function detail_newsletter($id)
	{
		$data['data1'] = $this->db->get_where('newsletter', array('id_newsletter' => $id))->result_array();
	
		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/detail_newsletter', $data);
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi kirim_newsletter()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk mengirimkan newsletter ke email-email 
	| pelanggan yang telah berlangganan newsletter.
	| 
	| Last edited: 2016-07-04 20:20
	*/

	public function kirim_newsletter($id)
	{
		if ($this->input->post('ajax') != 1) {
			echo 'false';
		} else {
			$arr_criteria = array("id_newsletter" => $id);
			$query_newsletter = $this->db->get_where('newsletter', $arr_criteria)->result_array();

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


			$recipients = $this->db->get('pelanggan')->result_array();

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

			$this->load->library('email');
			$this->email->set_newline("\r\n");
			$this->email->initialize($config);
			foreach ($recipients as $value) {
			
				$this->email->from('noreply@academica.com', 'Academica Newsletter');
				$this->email->to($value['email_pelanggan']);
				$this->email->subject('[Academica Newsletter] ' . $judul);
				$this->email->message($pesan);
				
				$this->email->send();
			}

			$this->db->update('newsletter', array('status_newsletter' => 'Published', 'tanggal_publish' => date('Y-m-d H:i:s')), array('id_newsletter' => $id));
			echo $this->email->print_debugger();
		}
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi hapus_newsletter($id)
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menghapus 
	| newsletter yang masih berstatus 'Created'.
	| 
	| Last edited: 2016-07-02 12:25
	*/

	public function hapus_newsletter($id)
	{
		// Check if user has javascript enabled
        if($this->input->post('ajax') != '1'){
            echo 'false';
            } else { 
                if ($this->input->post('id_newsletter', TRUE)) {

                	// #1. Hapus foto-foto yang terasosiasi dengan artikel yang mau dihapus
                	$arr_criteria = array('id_newsletter' => $id);
                	$query_hapus_foto_newsletter = $this->db->get_where('newsletter', $arr_criteria)->result_array();
					if ($query_hapus_foto_newsletter[0]['gambar_newsletter']) {
						unlink('uploads/images/newsletter/original/' . $query_hapus_foto_newsletter[0]['gambar_newsletter']);
						unlink('uploads/images/newsletter/email/' . $query_hapus_foto_newsletter[0]['gambar_newsletter']);
					}

                    // #2. Hapus artikel yang ingin dihapus
                    $this->db->delete('newsletter', array("id_newsletter" => $id));
                    
                    echo 'true';
                } else {
                    echo 'false';
                }   
            }
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi hapus_pelanggan()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menghapus pelanggan yang berlangganan newsletter.
	| 
	| Last edited: 2016-07-01 21:32
	*/

	public function hapus_pelanggan($id)
	{
		// Check if user has javascript enabled
        if($this->input->post('ajax') != '1'){
            echo 'false';
            } else { 
                if ($this->input->post('id_pelanggan', TRUE)) {
                    
                    $this->db->delete('pelanggan', array("id_pelanggan" => $id));
                    echo 'true';
                } else {
                    echo 'false';
                }   
            }
	}

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

	public function data_pesan()
	{
		$num_pesan = $this->db->select('id_pesan')->from('pesan')->count_all_results();

		$this->load->library('pagination');
		
		$config['base_url'] = site_url($this->user_type.'/data-pesan');
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
        $config['next_tagl_close']  = '</li>';

        $config['prev_tag_open']   = '<li>';
        $config['prev_tagl_close']  = '</li>';

        $config['first_tag_open']  = '<li>';
        $config['first_tagl_close'] = '</li>';

        $config['last_tag_open']   = '<li>';
        $config['last_tagl_close']  = '</li>';
		
		$this->pagination->initialize($config);

		$data['data1'] = $this->db->get('pesan', $config['per_page'], ($this->uri->segment(3)) ? $this->uri->segment(3) : 0);
		
		$data['data2'] = $this->pagination->create_links();

		$data['data3'] = $num_pesan;

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/data_pesan', $data);
	}

	public function detail_pesan($id)
	{
		$data['data1'] = $this->db->get_where('pesan', array('id_pesan' => $id))->result_array();

		$data['nav'] = $this->load->view('backend/'.$this->user_type.'/include/nav', $this->nav, TRUE);
		$data['menu'] = $this->load->view('backend/'.$this->user_type.'/include/menu', $this->menu, TRUE);
		$this->load->view('backend/'.$this->user_type.'/detail_pesan', $data);
	}

	public function balas_pesan()
	{
		if ($this->input->post('ajax') != 1) {
			echo 'false';
		} else {
			if ($this->input->post('email') && $this->input->post('isi')) {
				$this->db->update('pesan', array('status_pesan' => 'Answered'), array('id_pesan' => $this->input->post('id_pesan')));

				$this->load->library('email');
				
				$this->email->from($this->email_situs);
				$this->email->to($this->input->post('email'));
				
				$this->email->subject('[BALAS]');
				$this->email->message($this->input->post('isi'));
				
				$this->email->send();
				
				echo $this->email->print_debugger();

				echo '<br> true';
			} else {
				echo 'false';
			}
			
		}
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

/* End of file Staf.php */
/* Location: ./application/controllers/Staf.php */