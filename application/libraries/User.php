<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Library untuk memproses data User, dipindahkan dari controller
*/
class User
{
	var $CI;
	var $nav;
	var $incNav;
	var $menu;
	var $incMenu;
	
	function __construct()
	{
		$this->CI =& get_instance();

        $this->CI->load->database();
        $this->CI->load->model('ModelArtikel');
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
	}

	public function data_user()
	{
		$total_rows = $this->CI->db->select('id_admin')->from('admin')->count_all_results();

		$this->CI->load->library('pagination');
		$config['base_url'] = site_url('dashboard/data-user');
		
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

		$data['data1'] = $this->CI->db->select('admin.*')->from('admin')->get();
		
		$data['data2'] = $this->CI->pagination->create_links();

		$data['data3'] = $total_rows;

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/data_user', $data);
	}

	public function tambah_user()
	{
		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/tambah_user', $data);
	}

	public function buat_user()
	{
		if ($this->CI->input->post('username')) {
			$this->CI->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean');
			$this->CI->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
			$this->CI->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean');
			if ($this->CI->form_validation->run() == FALSE) {
				$this->CI->session->set_flashdata('error_form_validation', 'Semua isian harus diisi!');
				redirect('dashboard/tambah-user','refresh');
			} else {
				$data = array(
					'nama_admin' => $this->CI->input->post('nama'),
					'username_admin' => $this->CI->input->post('username'),
					'password_admin' => $this->CI->input->post('password'),
					'kategori_admin' => $this->CI->input->post('kategori'),
					'email_admin' => $this->CI->input->post('email'),
					"tanggal_lahir_admin" => $this->CI->input->post('lahir', TRUE),
					"deskripsi_admin" => $this->CI->input->post('deskripsi', TRUE),
					"bisa_buat_berita" => $this->CI->input->post('bisa-buat-berita', TRUE),
					"bisa_lihat_berita" => $this->CI->input->post('bisa-lihat-berita', TRUE),
					"bisa_ubah_berita" => $this->CI->input->post('bisa-ubah-berita', TRUE),
					"bisa_hapus_berita" => $this->CI->input->post('bisa-hapus-berita', TRUE),
					"bisa_buat_blog" => $this->CI->input->post('bisa-buat-blog', TRUE),
					"bisa_lihat_blog" => $this->CI->input->post('bisa-lihat-blog', TRUE),
					"bisa_ubah_blog" => $this->CI->input->post('bisa-ubah-blog', TRUE),
					"bisa_hapus_blog" => $this->CI->input->post('bisa-hapus-blog', TRUE),
					"bisa_buat_galeri" => $this->CI->input->post('bisa-buat-galeri', TRUE),
					"bisa_lihat_galeri" => $this->CI->input->post('bisa-lihat-galeri', TRUE),
					"bisa_ubah_galeri" => $this->CI->input->post('bisa-ubah-galeri', TRUE),
					"bisa_hapus_galeri" => $this->CI->input->post('bisa-hapus-galeri', TRUE),
					"bisa_buat_newsletter" => $this->CI->input->post('bisa-buat-newsletter', TRUE),
					"bisa_lihat_newsletter" => $this->CI->input->post('bisa-lihat-newsletter', TRUE),
					"bisa_ubah_newsletter" => $this->CI->input->post('bisa-ubah-newsletter', TRUE),
					"bisa_hapus_newsletter" => $this->CI->input->post('bisa-hapus-newsletter', TRUE),
					"bisa_buat_user" => $this->CI->input->post('bisa-buat-user', TRUE),
					"bisa_lihat_user" => $this->CI->input->post('bisa-lihat-user', TRUE),
					"bisa_ubah_user" => $this->CI->input->post('bisa-ubah-user', TRUE),
					"bisa_hapus_user" => $this->CI->input->post('bisa-hapus-user', TRUE),
					"bisa_lihat_pesan" => $this->CI->input->post('bisa-lihat-pesan', TRUE),
					"bisa_balas_pesan" => $this->CI->input->post('bisa-balas-pesan', TRUE),
					"bisa_lihat_info" => $this->CI->input->post('bisa-lihat-info', TRUE),
					"bisa_ubah_info" => $this->CI->input->post('bisa-ubah-info', TRUE),
					"bisa_ubah_halaman" => $this->CI->input->post('bisa-ubah-halaman', TRUE),
				);

				$this->CI->db->insert('admin', $data);
				$idAdmin = $this->CI->db->insert_id('admin');

				$this->CI->load->library('upload');

		        $config['upload_path'] = './uploads/images/profil/original/';
		        $config['file_name'] = $this->CI->input->post('username') . '.jpg';
		        $config['overwrite'] = TRUE;
		        $config['allowed_types'] = 'gif|jpg|jpeg|png';
		        $config['max_size'] = '2000';
		        $config['max_width'] = '2500';
		        $config['max_height'] = '2500';

		        $this->CI->upload->initialize($config);

		        if (!$this->CI->upload->do_upload('foto')) {
		        	$this->CI->session->set_flashdata('insert_success_no_upload', 'Sukses Menambah User Baru! <br/>' . $this->CI->upload->display_errors());
		        	redirect('dashboard/tambah-user','refresh');
		        } else {
		        	$uploaddata = $this->CI->upload->data();
					$this->CI->load->library('image_lib');

					/* resize and crop thumbnail */
		        	$config_thumbnail['image_library'] = 'gd2';
					$config_thumbnail['source_image'] = $uploaddata['full_path'];
					$config_thumbnail['new_image'] = './uploads/images/profil/thumbnail/' . $uploaddata['file_name'];
					$config_thumbnail['maintain_ratio'] = TRUE;
					$config_thumbnail['width'] = '64';
					$config_thumbnail['height'] = '64';
					$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_thumbnail['width'] / $config_thumbnail['height']);
					$config_thumbnail['master_dim'] = ($dim > 0)? "height" : "width";

					$this->CI->image_lib->initialize($config_thumbnail); 
					if (! $this->CI->image_lib->resize()) {
						$this->CI->session->set_flashdata('error_resize_thumbnail', 'Error resize thumbnail:' . $this->CI->image_lib->display_errors());
						redirect('dashboard/detail-user/'.$id,'refresh');
						}

					$config_thumbnail['image_library'] = 'gd2';
					$config_thumbnail['source_image'] = './uploads/images/profil/thumbnail/' . $uploaddata['file_name'];
					$config_thumbnail['new_image'] = './uploads/images/profil/thumbnail/' . $uploaddata['file_name'];
					$config_thumbnail['maintain_ratio'] = FALSE;
					$config_thumbnail['width'] = '64';
					$config_thumbnail['height'] = '64';
					$config_thumbnail['x_axis'] = '0';
					$config_thumbnail['y_axis'] = '0';

					$this->CI->image_lib->initialize($config_thumbnail); 
					if (! $this->CI->image_lib->crop()) {
						$this->CI->session->set_flashdata('error_crop_thumbnail', 'Error crop thumbnail:' . $this->CI->image_lib->display_errors());
						redirect('dashboard/detail-user/'.$id,'refresh');
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

					$this->CI->image_lib->initialize($config_avatar); 
					if (! $this->CI->image_lib->resize()) {
						$this->CI->session->set_flashdata('error_resize_avatar', 'Error resize avatar:' . $this->CI->image_lib->display_errors());
						redirect('dashboard/detail-user/'.$id,'refresh');
						}

					$config_avatar['image_library'] = 'gd2';
					$config_avatar['source_image'] = './uploads/images/profil/avatar/' . $uploaddata['file_name'];
					$config_avatar['new_image'] = './uploads/images/profil/avatar/' . $uploaddata['file_name'];
					$config_avatar['maintain_ratio'] = FALSE;
					$config_avatar['width'] = '32';
					$config_avatar['height'] = '32';
					$config_avatar['x_axis'] = '0';
					$config_avatar['y_axis'] = '0';

					$this->CI->image_lib->initialize($config_avatar); 
					if (! $this->CI->image_lib->crop()) {
						$this->CI->session->set_flashdata('error_crop_avatar', 'Error crop avatar:' . $this->CI->image_lib->display_errors());
						redirect('dashboard/detail-user/'.$id,'refresh');
						}

					/* resize and crop gambar */
					$config_gambar['image_library'] = 'gd2';
					$config_gambar['source_image'] = $uploaddata['full_path'];
					$config_gambar['new_image'] = './uploads/images/profil/gambar/' . $uploaddata['file_name'];
					$config_gambar['maintain_ratio'] = TRUE;
					$config_gambar['width'] = '225';
					$config_gambar['height'] = '320';
					$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_gambar['width'] / $config_gambar['height']);
					$config_gambar['master_dim'] = ($dim > 0)? "height" : "width";

					$this->CI->image_lib->initialize($config_gambar); 
					if (! $this->CI->image_lib->resize()) {
						$this->CI->session->set_flashdata('error_resize_gambar', 'Error resize gambar:' . $this->CI->image_lib->display_errors());
						redirect('dashboard/detail-user/'.$id,'refresh');
						}
					$config_gambar['image_library'] = 'gd2';
					$config_gambar['source_image'] = './uploads/images/profil/gambar/' . $uploaddata['file_name'];
					$config_gambar['new_image'] = './uploads/images/profil/gambar/' . $uploaddata['file_name'];
					$config_gambar['maintain_ratio'] = FALSE;
					$config_gambar['width'] = '225';
					$config_gambar['height'] = '320';
					$config_gambar['x_axis'] = '0';
					$config_gambar['y_axis'] = '0';

					$this->CI->image_lib->clear();
					$this->CI->image_lib->initialize($config_gambar); 
					if (! $this->CI->image_lib->crop()) {
						$this->CI->session->set_flashdata('error_crop_gambar', 'Error crop gambar:' . $this->CI->image_lib->display_errors());
						redirect('dashboard/detail-user/'.$id,'refresh');
						}

		        	$foto = array(
							"foto_admin" => $config['file_name'],
						);

					$this->CI->db->update('admin', $foto, array('id_admin' => $idAdmin));

			        $this->CI->session->set_flashdata('success_insert_with_upload', 'Sukses Menambah User dan Foto Profil!');
			        redirect('dashboard/tambah-user','refresh');
		        }
			}
			
		} else {
			$this->CI->session->set_flashdata('error_form_validation', 'Semua isian harus diisi!');
			redirect('dashboard/tambah-user','refresh');
		}
	}

	public function detail_user($id)
	{
		$data['data1'] = $this->CI->db->get_where('admin', array('id_admin' =>$id))->result_array();

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/detail_user', $data);
	}

	public function ubah_user($id)
	{
		if ($this->CI->input->post('simpan', TRUE)) {
			$this->CI->form_validation->set_rules('username', 'Nama Peneliti', 'required|trim|xss_clean');
            $this->CI->form_validation->set_rules('password', 'Jenis Kelamin', 'required|trim|min_length[6]');

            if ($this->CI->form_validation->run() == FALSE) {
            	$this->CI->session->set_flashdata('validasi_eror', 'Username & Password wajib diisi!');
				redirect('dashboard/detail-user/'.$id,'refresh');
				} else {
					$data = array(
						"nama_admin" => $this->CI->input->post('nama', TRUE),
						"username_admin" => $this->CI->input->post('username', TRUE),
						"password_admin" => $this->CI->input->post('password', TRUE),
						"kategori_admin" => $this->CI->input->post('kategori', TRUE),
						"email_admin" => $this->CI->input->post('email', TRUE),
						"tanggal_lahir_admin" => $this->CI->input->post('lahir', TRUE),
						"deskripsi_admin" => $this->CI->input->post('deskripsi', TRUE),
						"bisa_buat_berita" => $this->CI->input->post('bisa-buat-berita', TRUE),
						"bisa_lihat_berita" => $this->CI->input->post('bisa-lihat-berita', TRUE),
						"bisa_ubah_berita" => $this->CI->input->post('bisa-ubah-berita', TRUE),
						"bisa_hapus_berita" => $this->CI->input->post('bisa-hapus-berita', TRUE),
						"bisa_buat_blog" => $this->CI->input->post('bisa-buat-blog', TRUE),
						"bisa_lihat_blog" => $this->CI->input->post('bisa-lihat-blog', TRUE),
						"bisa_ubah_blog" => $this->CI->input->post('bisa-ubah-blog', TRUE),
						"bisa_hapus_blog" => $this->CI->input->post('bisa-hapus-blog', TRUE),
						"bisa_buat_galeri" => $this->CI->input->post('bisa-buat-galeri', TRUE),
						"bisa_lihat_galeri" => $this->CI->input->post('bisa-lihat-galeri', TRUE),
						"bisa_ubah_galeri" => $this->CI->input->post('bisa-ubah-galeri', TRUE),
						"bisa_hapus_galeri" => $this->CI->input->post('bisa-hapus-galeri', TRUE),
						"bisa_buat_newsletter" => $this->CI->input->post('bisa-buat-newsletter', TRUE),
						"bisa_lihat_newsletter" => $this->CI->input->post('bisa-lihat-newsletter', TRUE),
						"bisa_ubah_newsletter" => $this->CI->input->post('bisa-ubah-newsletter', TRUE),
						"bisa_hapus_newsletter" => $this->CI->input->post('bisa-hapus-newsletter', TRUE),
						"bisa_buat_user" => $this->CI->input->post('bisa-buat-user', TRUE),
						"bisa_lihat_user" => $this->CI->input->post('bisa-lihat-user', TRUE),
						"bisa_ubah_user" => $this->CI->input->post('bisa-ubah-user', TRUE),
						"bisa_hapus_user" => $this->CI->input->post('bisa-hapus-user', TRUE),
						"bisa_lihat_pesan" => $this->CI->input->post('bisa-lihat-pesan', TRUE),
						"bisa_balas_pesan" => $this->CI->input->post('bisa-balas-pesan', TRUE),
						"bisa_lihat_info" => $this->CI->input->post('bisa-lihat-info', TRUE),
						"bisa_ubah_info" => $this->CI->input->post('bisa-ubah-info', TRUE),
						"bisa_ubah_halaman" => $this->CI->input->post('bisa-ubah-halaman', TRUE),
					);

					$this->CI->db->update('admin', $data, array('id_admin' => $id));

					if ($this->CI->session->userdata('id') == $id) { // jika si admin mengubah akses pada dirinya sendiri
						$session = array(
							"id" => $id,
							"username" => $this->CI->input->post('username', TRUE),
							"email" => $this->CI->input->post('email', TRUE),
							"kategori" => $this->CI->input->post('kategori', TRUE),
							"bisa_buat_berita" => $this->CI->input->post('bisa-buat-berita', TRUE),
							"bisa_lihat_berita" => $this->CI->input->post('bisa-lihat-berita', TRUE),
							"bisa_ubah_berita" => $this->CI->input->post('bisa-ubah-berita', TRUE),
							"bisa_hapus_berita" => $this->CI->input->post('bisa-hapus-berita', TRUE),
							"bisa_buat_blog" => $this->CI->input->post('bisa-buat-blog', TRUE),
							"bisa_lihat_blog" => $this->CI->input->post('bisa-lihat-blog', TRUE),
							"bisa_ubah_blog" => $this->CI->input->post('bisa-ubah-blog', TRUE),
							"bisa_hapus_blog" => $this->CI->input->post('bisa-hapus-blog', TRUE),
							"bisa_buat_galeri" => $this->CI->input->post('bisa-buat-galeri', TRUE),
							"bisa_lihat_galeri" => $this->CI->input->post('bisa-lihat-galeri', TRUE),
							"bisa_ubah_galeri" => $this->CI->input->post('bisa-ubah-galeri', TRUE),
							"bisa_hapus_galeri" => $this->CI->input->post('bisa-hapus-galeri', TRUE),
							"bisa_buat_newsletter" => $this->CI->input->post('bisa-buat-newsletter', TRUE),
							"bisa_lihat_newsletter" => $this->CI->input->post('bisa-lihat-newsletter', TRUE),
							"bisa_ubah_newsletter" => $this->CI->input->post('bisa-ubah-newsletter', TRUE),
							"bisa_hapus_newsletter" => $this->CI->input->post('bisa-hapus-newsletter', TRUE),
							"bisa_buat_user" => $this->CI->input->post('bisa-buat-user', TRUE),
							"bisa_lihat_user" => $this->CI->input->post('bisa-lihat-user', TRUE),
							"bisa_ubah_user" => $this->CI->input->post('bisa-ubah-user', TRUE),
							"bisa_hapus_user" => $this->CI->input->post('bisa-hapus-user', TRUE),
							"bisa_lihat_pesan" => $this->CI->input->post('bisa-lihat-pesan', TRUE),
							"bisa_balas_pesan" => $this->CI->input->post('bisa-balas-pesan', TRUE),
							"bisa_lihat_info" => $this->CI->input->post('bisa-lihat-info', TRUE),
							"bisa_ubah_info" => $this->CI->input->post('bisa-ubah-info', TRUE),
							"bisa_ubah_halaman" => $this->CI->input->post('bisa-ubah-halaman', TRUE),
						);

						$this->CI->session->set_userdata($session);
					}

					$this->CI->load->library('upload');

			        $config['upload_path'] = './uploads/images/profil/original/';
			        $config['file_name'] = $this->CI->session->userdata('type') . "_" . $this->CI->session->userdata('username') . '.jpg';
			        $config['overwrite'] = TRUE;
			        $config['allowed_types'] = 'gif|jpg|jpeg|png';
			        $config['max_size'] = '2000';
			        $config['max_width'] = '5000';
			        $config['max_height'] = '5000';

			        $this->CI->upload->initialize($config);

			        if (! $this->CI->upload->do_upload('foto')) {
			        	$this->CI->session->set_flashdata('update_no_upload', 'Sukses Memperbarui Profil! <br/>' . $this->CI->upload->display_errors());
			        	redirect('dashboard/detail-user/'.$id,'refresh');
			        } else {
			        	$uploaddata = $this->CI->upload->data();
						$this->CI->load->library('image_lib');

						/* resize and crop thumbnail */
			        	$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = $uploaddata['full_path'];
						$config_thumbnail['new_image'] = './uploads/images/profil/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = TRUE;
						$config_thumbnail['width'] = '64';
						$config_thumbnail['height'] = '64';
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_thumbnail['width'] / $config_thumbnail['height']);
						$config_thumbnail['master_dim'] = ($dim > 0)? "height" : "width";

						$this->CI->image_lib->initialize($config_thumbnail); 
						if (! $this->CI->image_lib->resize()) {
							$this->CI->session->set_flashdata('error_resize_thumbnail', 'Error resize thumbnail:' . $this->CI->image_lib->display_errors());
							redirect('dashboard/detail-user/'.$id,'refresh');
							}

						$config_thumbnail['image_library'] = 'gd2';
						$config_thumbnail['source_image'] = './uploads/images/profil/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['new_image'] = './uploads/images/profil/thumbnail/' . $uploaddata['file_name'];
						$config_thumbnail['maintain_ratio'] = FALSE;
						$config_thumbnail['width'] = '64';
						$config_thumbnail['height'] = '64';
						$config_thumbnail['x_axis'] = '0';
						$config_thumbnail['y_axis'] = '0';

						$this->CI->image_lib->initialize($config_thumbnail); 
						if (! $this->CI->image_lib->crop()) {
							$this->CI->session->set_flashdata('error_crop_thumbnail', 'Error crop thumbnail:' . $this->CI->image_lib->display_errors());
							redirect('dashboard/detail-user/'.$id,'refresh');
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

						$this->CI->image_lib->initialize($config_avatar); 
						if (! $this->CI->image_lib->resize()) {
							$this->CI->session->set_flashdata('error_resize_avatar', 'Error resize avatar:' . $this->CI->image_lib->display_errors());
							redirect('dashboard/detail-user/'.$id,'refresh');
							}

						$config_avatar['image_library'] = 'gd2';
						$config_avatar['source_image'] = './uploads/images/profil/avatar/' . $uploaddata['file_name'];
						$config_avatar['new_image'] = './uploads/images/profil/avatar/' . $uploaddata['file_name'];
						$config_avatar['maintain_ratio'] = FALSE;
						$config_avatar['width'] = '32';
						$config_avatar['height'] = '32';
						$config_avatar['x_axis'] = '0';
						$config_avatar['y_axis'] = '0';

						$this->CI->image_lib->initialize($config_avatar); 
						if (! $this->CI->image_lib->crop()) {
							$this->CI->session->set_flashdata('error_crop_avatar', 'Error crop avatar:' . $this->CI->image_lib->display_errors());
							redirect('dashboard/detail-user/'.$id,'refresh');
							}

						/* resize and crop gambar */
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = $uploaddata['full_path'];
						$config_gambar['new_image'] = './uploads/images/profil/gambar/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = TRUE;
						$config_gambar['width'] = '225';
						$config_gambar['height'] = '320';
						$dim = (intval($uploaddata["image_width"]) / intval($uploaddata["image_height"])) - ($config_gambar['width'] / $config_gambar['height']);
						$config_gambar['master_dim'] = ($dim > 0)? "height" : "width";

						$this->CI->image_lib->initialize($config_gambar); 
						if (! $this->CI->image_lib->resize()) {
							$this->CI->session->set_flashdata('error_resize_gambar', 'Error resize gambar:' . $this->CI->image_lib->display_errors());
							redirect('dashboard/detail-user/'.$id,'refresh');
							}
						$config_gambar['image_library'] = 'gd2';
						$config_gambar['source_image'] = './uploads/images/profil/gambar/' . $uploaddata['file_name'];
						$config_gambar['new_image'] = './uploads/images/profil/gambar/' . $uploaddata['file_name'];
						$config_gambar['maintain_ratio'] = FALSE;
						$config_gambar['width'] = '225';
						$config_gambar['height'] = '320';
						$config_gambar['x_axis'] = '0';
						$config_gambar['y_axis'] = '0';

						$this->CI->image_lib->clear();
						$this->CI->image_lib->initialize($config_gambar); 
						if (! $this->CI->image_lib->crop()) {
							$this->CI->session->set_flashdata('error_crop_gambar', 'Error crop gambar:' . $this->CI->image_lib->display_errors());
							redirect('dashboard/detail-user/'.$id,'refresh');
							}

						$gambar = array(
							"foto_admin" => $this->CI->session->userdata('username') . '.jpg',
						);

						$this->CI->db->update('admin', $gambar, array("id_admin" => $id));

						$this->CI->session->set_flashdata('update_with_upload', 'Sukses Memperbarui Profil dan Foto!');
						redirect('dashboard/detail-user/'.$id,'refresh');
			        }
			        
				}
		} 
	}

	public function hapus_user($id)
	{
		// Check if user has javascript enabled
        if($this->CI->input->post('ajax') != '1'){
            echo 'false';
        } else { 
            if ($this->CI->input->post('id_admin', TRUE)) {
                
                $this->CI->db->delete('admin', array("id_admin" => $id));
                echo 'true';
            } else {
                echo 'false';
            }   
        }
	}
}