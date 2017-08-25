<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		
	}

	public function masuk()
    {
        $this->form_validation->set_rules("username", "Username", "required|trim|xss_clean");
        $this->form_validation->set_rules("password", "Password", "required|trim|xss_clean|min_length[5]");

        if ($this->form_validation->run() == FALSE) {
            redirect('login','refresh');
        } else {
			$sqlAdmin = $this->db->get_where('admin',
				array(
					"username_admin" => $this->input->post('username', TRUE),
					"password_admin" => $this->input->post('password', TRUE)
					)
				);
    		
    		if ($sqlAdmin->num_rows() > 0) {
    			$row = $sqlAdmin->result_array();

    			$session = array(
    				'id' => $row[0]["id_admin"],
    				'username' => $row[0]["username_admin"],
    				'email' => $row[0]["email_admin"],
                    'kategori' => $row[0]["kategori_admin"],
    				'bisa_buat_berita' => $row[0]['bisa_buat_berita'],
    				'bisa_lihat_berita' => $row[0]['bisa_lihat_berita'],
    				'bisa_ubah_berita' => $row[0]['bisa_ubah_berita'],
    				'bisa_hapus_berita' => $row[0]['bisa_hapus_berita'],
    				'bisa_buat_blog' => $row[0]['bisa_buat_blog'],
    				'bisa_lihat_blog' => $row[0]['bisa_lihat_blog'],
    				'bisa_ubah_blog' => $row[0]['bisa_ubah_blog'],
    				'bisa_hapus_blog' => $row[0]['bisa_hapus_blog'],
    				'bisa_buat_galeri' => $row[0]['bisa_buat_galeri'],
    				'bisa_lihat_galeri' => $row[0]['bisa_lihat_galeri'],
    				'bisa_ubah_galeri' => $row[0]['bisa_ubah_galeri'],
    				'bisa_hapus_galeri' => $row[0]['bisa_hapus_galeri'],
    				'bisa_buat_newsletter' => $row[0]['bisa_buat_newsletter'],
    				'bisa_lihat_newsletter' => $row[0]['bisa_lihat_newsletter'],
    				'bisa_ubah_newsletter' => $row[0]['bisa_ubah_newsletter'],
    				'bisa_hapus_newsletter' => $row[0]['bisa_hapus_newsletter'],
                    'bisa_buat_user' => $row[0]['bisa_buat_user'],
                    'bisa_lihat_user' => $row[0]['bisa_lihat_user'],
                    'bisa_ubah_user' => $row[0]['bisa_ubah_user'],
                    'bisa_hapus_user' => $row[0]['bisa_hapus_user'],
    				'bisa_lihat_pesan' => $row[0]['bisa_lihat_pesan'],
    				'bisa_balas_pesan' => $row[0]['bisa_balas_pesan'],
    				'bisa_lihat_info' => $row[0]['bisa_lihat_info'],
    				'bisa_ubah_info' => $row[0]['bisa_ubah_info'],
                    'bisa_ubah_halaman' => $row[0]['bisa_ubah_halaman'],
    			);

    			$this->session->set_userdata($session);
    			echo "login sukses";
    		} else {
    			$this->session->set_flashdata('error', 'Error! Coba lagi kembali.');
    			echo "login gagal";
    		}
        }
    }

    public function logout()
	{
		$session = array(
            'id' => "",
            'username' => "",
            'email' => "",
            'kategori' => "",
			'bisa_buat_berita' => "",
			'bisa_lihat_berita' => "",
			'bisa_ubah_berita' => "",
			'bisa_hapus_berita' => "",
			'bisa_buat_blog' => "",
			'bisa_lihat_blog' => "",
			'bisa_ubah_blog' => "",
			'bisa_hapus_blog' => "",
			'bisa_buat_galeri' => "",
			'bisa_lihat_galeri' => "",
			'bisa_ubah_galeri' => "",
			'bisa_hapus_galeri' => "",
			'bisa_buat_newsletter' => "",
			'bisa_lihat_newsletter' => "",
			'bisa_ubah_newsletter' => "",
			'bisa_hapus_newsletter' => "",
            'bisa_buat_user' => "",
            'bisa_lihat_user' => "",
            'bisa_ubah_user' => "",
            'bisa_hapus_user' => "",
			'bisa_lihat_pesan' => "",
			'bisa_balas_pesan' => "",
			'bisa_lihat_info' => "",
			'bisa_ubah_info' => "",
            'bisa_ubah_halaman' => "",
        );
        
        $this->session->set_userdata($session);
        $this->session->unset_userdata($session);
        $this->session->sess_destroy();

        redirect("beranda", "refresh");
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */