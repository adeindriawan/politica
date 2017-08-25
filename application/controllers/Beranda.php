<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Beranda extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ModelArtikel');
		$this->load->model('FrontendArtikel');
		$this->load->model('ModelTag');
		$this->load->model('ModelFoto');
		$this->load->model('ModelKomentar');
		$this->load->model('ModelKategori');
		$this->load->library('Analitik');
		$this->load->library('Info');
		$this->load->library('Notifikasi');
	}

	public function atur_cookie()
	{
    	$this->analitik->atur_cookie();
	}

	public function cekKeaktifan()
	{
		$this->analitik->cekKeaktifan();
	}

	public function index()
	{
		$this->atur_cookie();
		$data['data1'] = $this->db->get('halaman', 5, 0)->result_array();
		$data['data2'] = $this->FrontendArtikel->gabung_artikel_dengan_kategorinya(5, 0)->result_array();
		
		$pop['dibaca'] = $this->populer_dibaca();
		$pop['dikomentari'] = $this->populer_dikomentari();
		$pop['kategori'] = $this->kategori_artikel();

		$info['nama'] = $this->info->nama_situs();
		$info['tagline'] = $this->info->tagline_situs();

		$info['alamat'] = $this->info->alamat();
		$info['kota'] = $this->info->kota();
		$info['kodepos'] = $this->info->kodepos();
		$info['telepon'] = $this->info->telepon();
		$info['email'] = $this->info->email();
		$info['facebook'] = $this->info->facebook();
		$info['twitter'] = $this->info->twitter();
		$info['instagram'] = $this->info->instagram();
		$info['youtube'] = $this->info->youtube();

		$data['header'] = $this->load->view('frontend/beranda/include/header', $info, TRUE);
		$data['footer'] = $this->load->view('frontend/beranda/include/footer', $info, TRUE);
		$data['populer_dibaca'] = $this->load->view('frontend/beranda/populer_dibaca', $pop, TRUE);
		$data['populer_dikomentari'] = $this->load->view('frontend/beranda/populer_dikomentari', $pop, TRUE);
		$data['kategori_artikel'] = $this->load->view('frontend/beranda/kategori_artikel', $pop, TRUE);
		$this->load->view('frontend/beranda/beranda', $data);
	}

	public function halaman($id, $slug=NULL)
	{
		$this->atur_cookie();
		$data['data1'] = $this->db->select('halaman.*')->from('halaman')->where('id_halaman', $id)->get()->result_array();
	
		$pop['dibaca'] = $this->populer_dibaca();
		$pop['dikomentari'] = $this->populer_dikomentari();

		$data['populer_dibaca'] = $this->load->view('frontend/beranda/populer_dibaca', $pop, TRUE);
		$data['populer_dikomentari'] = $this->load->view('frontend/beranda/populer_dikomentari', $pop, TRUE);

		$info['nama'] = $this->info->nama_situs();
		$info['tagline'] = $this->info->tagline_situs();

		$info['alamat'] = $this->info->alamat();
		$info['kota'] = $this->info->kota();
		$info['kodepos'] = $this->info->kodepos();
		$info['telepon'] = $this->info->telepon();
		$info['email'] = $this->info->email();
		$info['facebook'] = $this->info->facebook();
		$info['twitter'] = $this->info->twitter();
		$info['instagram'] = $this->info->instagram();
		$info['youtube'] = $this->info->youtube();

		$data['header'] = $this->load->view('frontend/beranda/include/header', $info, TRUE);
		$data['footer'] = $this->load->view('frontend/beranda/include/footer', $info, TRUE);
		$this->load->view('frontend/beranda/halaman', $data);
	}

	public function login()
	{
		$this->load->view('backend/login');
	}

	public function tambah_komentar()
	{
		if ($this->input->post('artikel')) {
			$artikel = $this->input->post('artikel', TRUE);
			$nama = $this->input->post('nama', TRUE);
			$website = $this->input->post('website', TRUE);
			$email = $this->input->post('email', TRUE);
			$komentar = $this->input->post('komentar', TRUE);
			$avatar = $this->input->post('avatar', TRUE);
			$judul = $this->input->post('judul', TRUE);
			$kategori = $this->input->post('kategori', TRUE);

			// mengambil id penulis sebagai parameter ke fungsi yang mengirim notifikasi ke penulis ybs
			$query = $this->db->get_where('artikel', array("id_artikel" => $artikel))->result_array();
			$penulis = $query[0]['id_penulis_artikel'];

			$this->kirim_notifikasi_ke_penulis_artikel($artikel, $penulis, $judul, $kategori);

			$query2 = $this->db->select('artikel.jumlah_komentar')->from('artikel')->where('id_artikel', $artikel)->get()->result_array();
			$jumlah_komentar = $query2[0]['jumlah_komentar'];

	        // Check if user has javascript enabled
	        if($this->input->post('ajax') != '1'){
	            //redirect('cart'); // If javascript is not enabled, reload the page with new data
	            	echo 'no javascript';
	            } else { 
	                if ($komentar && $nama && $email) {
	                    $data = array(
	                    	'id_artikel' => $artikel,
	                        'nama_komentator' => $nama,
	                        'website_komentator' => $website,
	                        'email_komentator' => $email,
	                        'isi_komentar' => $komentar,
	                        'avatar_komentator' => $avatar,
	                        'tanggal_komentar' => date("Y-m-d H:i:s"),
	                    );

	                    $this->db->insert('komentar', $data);

	                    $tambah_jumlah_komentar = array(
	                    	'jumlah_komentar' => $jumlah_komentar + 1,
	                    	);

	                    $this->db->update('artikel', $tambah_jumlah_komentar, array('id_artikel' => $artikel));

	                    echo "true";
	                } else {
	                    echo 'false';
	                }   
	            }
		}
		if ($this->input->post('album')) {
			$album = $this->input->post('album', TRUE);
			$nama = $this->input->post('nama', TRUE);
			$website = $this->input->post('website', TRUE);
			$email = $this->input->post('email', TRUE);
			$komentar = $this->input->post('komentar', TRUE);
			$avatar = $this->input->post('avatar', TRUE);
			$judul = $this->input->post('judul', TRUE);

			// untuk tabel komentar
			$query = $this->db->get_where('album', array("id_album" => $album))->result_array();
			$penulis = $query[0]['id_admin'];

			$this->kirim_notifikasi_ke_pengunggah_album($album, $penulis, $judul);

	        // Check if user has javascript enabled
	        if($this->input->post('ajax') != '1'){
	            //redirect('cart'); // If javascript is not enabled, reload the page with new data
	            } else { 
	                if ($this->input->post('komentar', TRUE)) {
	                    $data = array(
	                    	'id_album' => $album,
	                        'nama_komentator' => $nama,
	                        'website_komentator' => $website,
	                        'email_komentator' => $email,
	                        'isi_komentar' => $komentar,
	                        'avatar_komentator' => $avatar,
	                        'tanggal_komentar' => date("Y-m-d H:i:s"),
	                    );

	                    $this->db->insert('komentar', $data);
	                    	    
	                    echo "true";
	                } else {
	                    echo 'false';
	                }   
	            }
		}
	}

	public function kirim_notifikasi_ke_penulis_artikel($id_artikel, $id_penulis, $judul_artikel, $kategori_artikel)
	{
		$this->notifikasi->kirim_notifikasi_ke_penulis_artikel($id_artikel, $id_penulis, $judul_artikel, $kategori_artikel);
	}

	public function kirim_notifikasi_ke_pengunggah_album($id_album, $id_pengunggah, $judul)
	{
		$this->notifikasi->kirim_notifikasi_ke_pengunggah_album($id_album, $id_pengunggah, $judul);
	}

	public function cari_tag($id)
	{
		$this->atur_cookie();
		$this->db->select('tags_artikel.id_tags_artikel');
		$this->db->from('tags_artikel');
		$this->db->where('id_tag', $id);
		$num = $this->db->count_all_results();

		$this->load->library('pagination');
		$config['base_url'] = site_url('beranda/cari-tag/'.$id);
		
		$config['total_rows'] = $num;
		$config['per_page'] = 6;
		$config['uri_segment'] = 4;
		$config['num_links'] = 2;

		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';

		$config['num_tag_open']  = '<li>';
		$config['num_tag_close']  = '</li>';

		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['prev_link'] = '&larr; Prev';
		$config['next_link'] = 'Next &rarr;';

		$config['first_tag_open'] = "<li>";
		$config['first_tag_close'] = "</li>";
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';


		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		
		$config['prev_tag_open'] = '<li><a class="prevpostslink">';
		$config['prev_tag_close'] = '</a></li>';

		$config['cur_tag_open'] = "<li class='current'><a class='nextpostslink'>";
		$config['cur_tag_close'] = "</a></li>";
		
		$this->pagination->initialize($config);
		
		$data['links'] = $this->pagination->create_links();
		$data['value'] = $this->ModelTag->cari_tag($id, $config['per_page'], ($this->uri->segment(4)) ? $this->uri->segment(4) : 0);

		$info['nama'] = $this->info->nama_situs();
		$info['tagline'] = $this->info->tagline_situs();

		$info['alamat'] = $this->info->alamat();
		$info['kota'] = $this->info->kota();
		$info['kodepos'] = $this->info->kodepos();
		$info['telepon'] = $this->info->telepon();
		$info['email'] = $this->info->email();
		$info['facebook'] = $this->info->facebook();
		$info['twitter'] = $this->info->twitter();
		$info['instagram'] = $this->info->instagram();
		$info['youtube'] = $this->info->youtube();

		$data['header'] = $this->load->view('frontend/beranda/include/header', $info, TRUE);
		$data['footer'] = $this->load->view('frontend/beranda/include/footer', $info, TRUE);
		$this->load->view('frontend/beranda/cari_tag', $data);
	}

	public function cari() // menampung kata kunci yang diketik pada tab searc lalu dienkripsi
	{
		$this->form_validation->set_rules("teks_cari", "Pencarian", "required|trim|xss_clean");
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('pencarian_tidak_benar', 'Harap mengisi materi pencarian dengan benar.');
			redirect('beranda','refresh');
		} else {
			$dicari = $this->input->post('teks_cari', TRUE);
			$enkrip = $this->encryptIt($dicari);
			redirect('beranda/hasil/'.$enkrip,'refresh');
		}
	}

	public function encryptIt($q) { // mengenkripsi kata kunci yang diketik di tab search
	    // $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
	    // $qEncoded = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
	    // $safeEncoded = strtr($qEncoded, '+/=', '-_~');
	    return strtr(base64_encode($q), '+/=', '-_~');
	}

	public function decryptIt($q) { // mendekripsi kata kunci yang telah dienkripsi
	    // $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
	    // $qDecoded = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
	    // $safeDecoded = strtr($qDecoded, '-_~', '+/=');
	    return base64_decode(strtr($q, '-_~', '+/='));
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi hasil()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk mengolah (mendekripsi) kata pencarian yang dimasukkan oleh
	| user dan menampilkannya. Juga menyimpan kata kunci yang diinput oleh user ke dalam database.
	| 
	| Last edited: 2016-06-29 22:31
	*/

	public function hasil($keyword) // mengolah kata kunci yang diinput dan menampilkannya
	{
		$this->atur_cookie();
		$dekrip = $this->decryptIt($keyword);
		$result = $this->ModelArtikel->gabung_semua_artikel_dengan_nama_penulisnya_berdasarkan_kata_kunci($dekrip);
		
		// masukkan kata kunci ke dalam database pencarian
		$pencarian = array(
			"kata_kunci" => $dekrip,
			"waktu_pencarian" => date("Y-m-d H:i:s"),
			);

		$this->db->insert('pencarian', $pencarian);

		$found = $result->num_rows();
		$result_in_array = $result->result_array();
		
		$this->load->library('pagination');
		
		$config['base_url'] = site_url('beranda/hasil/' . $keyword);
		
		$config['total_rows'] = $found;
		$config['per_page'] = 6;
		$config['uri_segment'] = 4;
		$config['num_links'] = 2;

		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';

		$config['num_tag_open']  = '<li>';
		$config['num_tag_close']  = '</li>';

		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['prev_link'] = '&larr; Prev';
		$config['next_link'] = 'Next &rarr;';

		$config['first_tag_open'] = "<li>";
		$config['first_tag_close'] = "</li>";
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';


		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		
		$config['prev_tag_open'] = '<li><a class="prevpostslink">';
		$config['prev_tag_close'] = '</a></li>';

		$config['cur_tag_open'] = "<li class='current'><a class='nextpostslink'>";
		$config['cur_tag_close'] = "</a></li>";
		
		$this->pagination->initialize($config);
		
		$data['links'] = $this->pagination->create_links();
		$data['value'] = $this->ModelArtikel->gabung_semua_artikel_dengan_nama_penulisnya_berdasarkan_kata_kunci($dekrip, $config['per_page'], ($this->uri->segment(4)) ? $this->uri->segment(4) : 0);
		$data['kata_kunci'] = $dekrip;
		$data['jumlah_hasil'] = $found;

		$info['nama'] = $this->info->nama_situs();
		$info['tagline'] = $this->info->tagline_situs();

		$info['alamat'] = $this->info->alamat();
		$info['kota'] = $this->info->kota();
		$info['kodepos'] = $this->info->kodepos();
		$info['telepon'] = $this->info->telepon();
		$info['email'] = $this->info->email();
		$info['facebook'] = $this->info->facebook();
		$info['twitter'] = $this->info->twitter();
		$info['instagram'] = $this->info->instagram();

		$data['header'] = $this->load->view('frontend/beranda/include/header', $info, TRUE);
		$data['footer'] = $this->load->view('frontend/beranda/include/footer', $info, TRUE);

		$this->load->view('frontend/beranda/hasil', $data);
	}

	public function cari_kategori($id)
	{
		$this->atur_cookie();
		$this->db->select('artikel.id_kategori');
		$this->db->from('artikel');
		$this->db->where('artikel.id_kategori', $id);
		$num = $this->db->count_all_results();

		$this->load->library('pagination');
		$config['base_url'] = site_url('beranda/cari-kategori/'.$id);
		
		$config['total_rows'] = $num;
		$config['per_page'] = 6;
		$config['uri_segment'] = 4;
		$config['num_links'] = 2;

		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';

		$config['num_tag_open']  = '<li>';
		$config['num_tag_close']  = '</li>';

		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['prev_link'] = '&larr; Prev';
		$config['next_link'] = 'Next &rarr;';

		$config['first_tag_open'] = "<li>";
		$config['first_tag_close'] = "</li>";
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';


		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		
		$config['prev_tag_open'] = '<li><a class="prevpostslink">';
		$config['prev_tag_close'] = '</a></li>';

		$config['cur_tag_open'] = "<li class='current'><a class='nextpostslink'>";
		$config['cur_tag_close'] = "</a></li>";
		
		$this->pagination->initialize($config);
		
		$data['links'] = $this->pagination->create_links();
		$data['value'] = $this->ModelKategori->cari_kategori($id, $config['per_page'], ($this->uri->segment(4)) ? $this->uri->segment(4) : 0);

		$info['nama'] = $this->info->nama_situs();
		$info['tagline'] = $this->info->tagline_situs();

		$info['alamat'] = $this->info->alamat();
		$info['kota'] = $this->info->kota();
		$info['kodepos'] = $this->info->kodepos();
		$info['telepon'] = $this->info->telepon();
		$info['email'] = $this->info->email();
		$info['facebook'] = $this->info->facebook();
		$info['twitter'] = $this->info->twitter();
		$info['instagram'] = $this->info->instagram();
		$info['youtube'] = $this->info->youtube();

		$data['header'] = $this->load->view('frontend/beranda/include/header', $info, TRUE);
		$data['footer'] = $this->load->view('frontend/beranda/include/footer', $info, TRUE);

		$this->load->view('frontend/beranda/cari_kategori', $data);
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi populer_dibaca()
	|--------------------------------------------------------------------------
	|
	| Fungsi populer_dibaca() di bawah ini adalah untuk menampilkan 
	| artikel-artikel yang paling sering dibaca.
	| Untuk penyederhanaan, dipilih 3 artikel yang paling sering dibaca. 
	|
	*/
	
	public function populer_dibaca()
	{
		$limit = 3;
		$offset = 0;
		return $this->ModelArtikel->ambil_artikel_paling_sering_dibaca($limit, $offset);
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi populer_dikomentari()
	|--------------------------------------------------------------------------
	|
	| Fungsi populer_dikomentari() di bawah ini adalah untuk menampilkan 
	| artikel-artikel yang paling banyak mendapat komentar.
	| Untuk penyederhanaan, dipilih 3 artikel yang paling banyak mendapat komentar. 
	|
	*/

	public function populer_dikomentari()
	{
		$limit = 3;
		$offset = 0;
		return $this->ModelArtikel->ambil_artikel_paling_sering_dikomentari($limit, $offset);
	}

	public function kategori_artikel()
	{
		return $this->db->get('kategori');
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi newsletter()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menyimpan alamat-alamat email yang berlangganan
	| newsletter.
	| 
	| Last edited: 2016-06-29 22:30
	*/

	public function newsletter()
	{
		if ($this->input->post('ajax') != 1) {
			//redirect('beranda','refresh');
		} else {
			if ($this->input->post('email')) {
				$data = array(
					"email_pelanggan" => $this->input->post('email'),
					"waktu_berlangganan" => date("Y-m-d H:i:s"),
				);

				$this->db->insert('pelanggan', $data);

				echo 'true';
			} else {
				echo 'false';
			}
			
		}
	}

	public function pesan()
	{
		if ($this->input->post('ajax') != 1) {
			//redirect('beranda','refresh');
		} else {
			if ($this->input->post('email') && $this->input->post('nama') && $this->input->post('pesan')) {
				$data = array(
					"nama_pemberi_pesan" => $this->input->post('nama'),
					"email_pemberi_pesan" => $this->input->post('email'),
					"isi_pesan" => $this->input->post('pesan'),
					"tanggal_pesan" => date("Y-m-d H:i:s"),
					"status_pesan" => 'Pending',
				);

				$this->db->insert('pesan', $data);
				$idp = $this->db->insert_id('pesan');
				$this->notifikasi->kirim_notifikasi_pesan_baru_ke_staf_atau_admin($idp);

				echo 'true';
			} else {
				echo 'false';
			}
			
		}
	}

}

/* End of file Beranda.php */
/* Location: ./application/controllers/Beranda.php */