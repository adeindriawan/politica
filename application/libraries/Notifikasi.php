<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifikasi {
	var $CI;
	var $nav;
	var $incNav;
	var $menu;
	var $incMenu;

	public function __construct()
	{
		$this->CI =& get_instance();

        $this->CI->load->database();
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

	public function cek_notifikasi()
	{
		$session_id = $this->CI->input->post('session_id', TRUE);
		$id_notifikasi = $this->CI->input->post('id_notifikasi', TRUE);

		// cek user terlebih dahulu apakah seorang Staf
		if ($this->CI->session->userdata('kategori') == 'staf') {
			// jika benar Staf/Admin, cek lagi apakah ada $id_notifikasi
			if ($id_notifikasi) {
				$notif = array(
					"status_notifikasi" => "Read",
					);
				$this->CI->db->update('notifikasi', $notif, array('id_notifikasi' => $id_notifikasi));

				$query = $this->CI->ModelNotifikasi->ambil_notifikasi_untuk_staf_atau_admin(1, 0);
				$encode_data = json_encode($query);

				echo $encode_data;
			} else {
				$query = $this->CI->ModelNotifikasi->ambil_notifikasi_untuk_staf_atau_admin(1, 0);
				$encode_data = json_encode($query);

				echo $encode_data;
			}
		} else {
			if ($this->CI->input->post('session_id') && !$this->CI->input->post('id_notifikasi')) {

				$query = $this->CI->ModelNotifikasi->gabung_notifikasi_dengan_nama_admin(1, 0, $session_id);
				$encode_data = json_encode($query);

				echo $encode_data;
			} else if ($this->CI->input->post('session_id') && $this->CI->input->post('id_notifikasi')) {
				$notif = array(
					"status_notifikasi" => "Read",
					"untuk_id" => $this->CI->session->userdata('id'),
				);

				$this->CI->db->update('notifikasi', $notif, array("id_notifikasi" => $id_notifikasi));

				$query = $this->CI->ModelNotifikasi->gabung_notifikasi_dengan_nama_admin(1, 0, $session_id);
				$encode_data = json_encode($query);

				echo $encode_data;
			} else {
				echo "false";
			}
		}
	}

	public function kirim_notifikasi_ke_penulis_blog($judul, $id)
	{
		$query = $this->CI->db->get_where('artikel', array('id_artikel' => $id))->result_array();
		$penulis = $query[0]['id_penulis_artikel'];

        $base_url = base_url();
        $notif = array(
        	"id_artikel" => $id,
        	"dari_id" => $this->CI->session->userdata('id'),
        	"untuk_id" => $penulis,
        	"tipe_notifikasi" => "persetujuan",
        	"isi_notifikasi" => "Artikel Anda yang berjudul {$judul} telah ditampilkan. Cek <a href='{$base_url}blog/artikel/{$id}'>artikelnya</a> untuk melilhat lebih lanjut.",
        	"tanggal_notifikasi" => date("Y-m-d H:i:s"),
        	"status_notifikasi" => "Sent",
        );

        $this->CI->db->insert('notifikasi', $notif);
	}

	// untuk memberi notifikasi ke penulis artikel ybs (jika artikelnya berupa blog)
	public function kirim_notifikasi_ke_penulis_artikel($id_artikel, $id_penulis, $judul_artikel, $kategori_artikel)
	{
		$base_url = base_url();
		$notif = array(
        	"id_artikel" => $id_artikel,
        	"dari_id" => $this->CI->session->userdata('id'),
        	"untuk_id" => $id_penulis,
        	"tipe_notifikasi" => 'komentar',
        	"isi_notifikasi" => "Ada komentar baru di artikel yang berjudul {$judul_artikel}. Cek <a href='{$base_url}{$kategori_artikel}/artikel/{$id_artikel}'>artikelnya</a> untuk melilhat lebih lanjut.",
        	"tanggal_notifikasi" => date("Y-m-d H:i:s"),
        	"status_notifikasi" => "Sent",
        );

        $this->CI->db->insert('notifikasi', $notif);
	}

	//untuk memberi notifikasi ke admin/staf (jika artikelnya berupa berita)
	public function kirim_notifikasi_ke_staf_atau_admin($id_artikel, $judul_artikel, $kategori_artikel)
	{
		$base_url = base_url();
		$notif = array(
        	"id_artikel" => $id_artikel,
        	"dari_id" => $this->CI->session->userdata('id'),
        	"untuk_id" => NULL,
        	"tipe_notifikasi" => 'komentar',
        	"isi_notifikasi" => "Ada komentar baru di artikel yang berjudul {$judul_artikel}. Cek <a href='{$base_url}{$kategori_artikel}/artikel/{$id_artikel}'>artikelnya</a> untuk melilhat lebih lanjut.",
        	"tanggal_notifikasi" => date("Y-m-d H:i:s"),
        	"status_notifikasi" => "Sent",
        );

        $this->CI->db->insert('notifikasi', $notif);
	}

	public function kirim_notifikasi_ke_pengunggah_album($id_galeri, $id_pengunggah, $judul)
	{
		$base_url = base_url();
		$notif = array(
        	"id_galeri" => $galeri,
        	"dari_id" => $this->CI->session->userdata('id'),
        	"untuk_id" => $penulis,
        	"tipe_notifikasi" => 'komentar',
        	"isi_notifikasi" => "Ada komentar baru di album yang berjudul {$judul}. Cek <a href='{$base_url}galeri/{$id_galeri}'>albumnya</a> untuk melilhat lebih lanjut.",
        	"tanggal_notifikasi" => date("Y-m-d H:i:s"),
        	"status_notifikasi" => "Sent",
        );

        $this->CI->db->insert('notifikasi', $notif);
	}

	public function kirim_notifikasi_blog_baru_ke_staf_atau_admin($id_artikel, $judul_artikel, $kategori_artikel)
	{
		$base_url = base_url();
		$kategori = $this->CI->session->userdata('kategori');
		$notif = array(
        	"id_artikel" => $id_artikel,
        	"dari_id" => $this->CI->session->userdata('id'),
        	"untuk_id" => NULL,
        	"tipe_notifikasi" => 'artikel',
        	"isi_notifikasi" => "Ada artikel blog yang baru saja ditambahkan yang berjudul {$judul_artikel}. Cek Data Blog untuk melilhat lebih lanjut.",
        	"tanggal_notifikasi" => date("Y-m-d H:i:s"),
        	"status_notifikasi" => "Sent",
        );

        $this->CI->db->insert('notifikasi', $notif);
	}

	public function kirim_notifikasi_pesan_baru_ke_staf_atau_admin($id_pesan)
	{
		$base_url = base_url();
		$kategori = $this->CI->session->userdata('kategori');
		$notif = array(
        	"id_artikel" => NULL,
        	"dari_id" => NULL,
        	"untuk_id" => NULL,
        	"id_pesan" => $id_pesan,
        	"tipe_notifikasi" => 'pesan',
        	"isi_notifikasi" => "Ada pesan yang baru saja dikirimkan. Cek <a href='{$base_url}{$kategori}/detail-pesan/{$id_pesan}'>detail pesan</a> untuk melilhat lebih lanjut.",
        	"tanggal_notifikasi" => date("Y-m-d H:i:s"),
        	"status_notifikasi" => "Sent",
        );

        $this->CI->db->insert('notifikasi', $notif);
	}

	public function data_notifikasi()
	{
		$num_notif = $this->CI->db->select('id_notifikasi')->from('notifikasi')->count_all_results();

		$this->CI->load->library('pagination');
		
		$config['base_url'] = site_url('dashboard/data-notifikasi');
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
        $config['next_tag_close']  = '</li>';

        $config['prev_tag_open']   = '<li>';
        $config['prev_tag_close']  = '</li>';

        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
		
		$this->CI->pagination->initialize($config);

		$data['data1'] = $this->CI->db->get('notifikasi', $config['per_page'], ($this->CI->uri->segment(3)) ? $this->CI->uri->segment(3) : 0);
		
		$data['data2'] = $this->CI->pagination->create_links();

		$data['data3'] = $num_notif;

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->CI->load->view('backend/dashboard/data_notifikasi', $data);
	}

}