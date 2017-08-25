<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Dashboard extends CI_Controller {

	var $nav;
	var $incNav;
	var $menu;
	var $incMenu;
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
		$this->load->library('Berita');
		$this->load->library('Blog');
		$this->load->library('Galeri');
		$this->load->library('User');
		$this->load->library('Newsletter');
		$this->load->library('Pesan');
		$this->load->library('Pencarian');
		$this->load->library('Halaman');

		if (! $this->session->userdata('username')) {
            $this->session->set_flashdata('sesi_habis', 'Sesi Anda sudah habis, silakan login kembali!');
            redirect('beranda','refresh');
        }
        
        $this->nav = array(
			"notif" => $this->analitik->daftar_notifikasi(),
			"review" => $this->analitik->review_artikel(),
			"pesan" => $this->analitik->review_pesan(),
			"nama" => $this->info->nama_situs(),
		);

		$this->incNav = $this->load->view('backend/dashboard/include/nav', $this->nav, TRUE);

		$this->menu = array();

		$this->incMenu = $this->load->view('backend/dashboard/include/menu', $this->menu, TRUE);

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

		$data['nav'] = $this->incNav;
		$data['menu'] = $this->incMenu;
		$this->load->view('backend/dashboard/index', $data);
	}

	public function cek_notifikasi()
	{
		$this->notifikasi->cek_notifikasi();
	}

	public function pageviews_and_visit_chart()
	{
		$this->analitik->pageviews_and_visit_chart();
	}

	public function data_info()
	{
		if (is_null($this->session->userdata('bisa_lihat_info')) && is_null($this->session->userdata('bisa_ubah_info'))) {
			$this->session->set_flashdata('akses_ditolak', 'Anda tidak memiliki akses untuk melihat dan/atau mengubah data info situs.');
			redirect('dashboard','refresh');
		}
		
		$this->info->data_info();
	}

	public function ubah_info()
	{
		if (is_null($this->session->userdata('bisa_ubah_info'))) {
			$this->session->set_flashdata('akses_ditolak', 'Anda tidak memiliki akses untuk mengubah data info situs.');
			redirect('dashboard','refresh');
		}

		$this->info->ubah_info();
	}

	public function data_halaman()
	{
		$this->halaman->data_halaman();
	}

	public function detail_halaman($id)
	{
		$this->halaman->detail_halaman();
	}

	public function ubah_halaman($id)
	{
		$this->halaman->ubah_halaman($id);
	}

	public function data_berita() // filter akses: lihat dan hapus (di halaman data-berita)
	{
		if (is_null($this->session->userdata('bisa_buat_berita')) && is_null($this->session->userdata('bisa_lihat_berita')) && is_null($this->session->userdata('bisa_ubah_berita')) && is_null($this->session->userdata('bisa_hapus_berita'))) {
			$this->session->set_flashdata('akses_ditolak', 'Anda tidak memiliki akses untuk melihat data berita.');
			redirect('dashboard','refresh');
		}
		$this->berita->data_berita();
	}

	public function tambah_berita() // filter akses: buat
	{
		if (is_null($this->session->userdata('bisa_buat_berita'))) {
			$this->session->set_flashdata('akses_ditolak', 'Anda tidak memiliki akses untuk membuat berita baru.');
			redirect('dashboard','refresh');
		}
		$this->berita->tambah_berita();
	}

	public function buat_berita()
	{
		$this->berita->buat_berita();
	}

	public function detail_berita($id) // filter akses: ubah
	{
		$this->berita->detail_berita($id);
	}

	public function ubah_berita($id)
	{
		$this->berita->ubah_berita($id);
	}

	public function hapus_berita($id)
	{
		$this->berita->hapus_berita($id);
	}

	public function data_blog()
	{
		if (is_null($this->session->userdata('bisa_lihat_blog')) && is_null($this->session->userdata('bisa_buat_blog')) && is_null($this->session->userdata('bisa_ubah_blog')) && is_null($this->session->userdata('bisa_hapus_blog'))) {
			$this->session->set_flashdata('akses_ditolak', 'Anda tidak memiliki akses untuk melihat data blog.');
			redirect('dashboard','refresh');
		}
		$this->blog->data_blog();
	}

	public function tambah_blog()
	{
		if (is_null($this->session->userdata('bisa_buat_blog'))) {
			$this->session->set_flashdata('akses_ditolak', 'Anda tidak memiliki akses untuk menambah blog.');
			redirect('dashboard','refresh');
		}
		$this->blog->tambah_blog();
	}

	public function buat_blog()
	{
		$this->blog->buat_blog();
	}

	public function detail_blog($id)
	{
		$this->blog->detail_blog($id);
	}

	public function ubah_blog($id)
	{
		$this->blog->ubah_blog($id);
	}

	public function hapus_blog($id)
	{
		$this->blog->hapus_blog($id);
	}

	public function data_galeri()
	{
		if (is_null($this->session->userdata('bisa_lihat_galeri')) && is_null($this->session->userdata('bisa_ubah_galeri')) && is_null($this->session->userdata('bisa_hapus_galeri'))) {
			$this->session->set_flashdata('akses_ditolak', 'Anda tidak memiliki akses untuk melihat data galeri.');
			redirect('dashboard','refresh');
		}

		$this->galeri->data_galeri();
	}

	public function tambah_galeri()
	{
		$this->galeri->tambah_galeri();
	}

	public function buat_galeri()
	{
		$this->galeri->buat_galeri();
	}

	public function detail_galeri($id)
	{
		$this->galeri->detail_galeri($id);
	}

	public function ubah_galeri($id)
	{
		$this->galeri->ubah_galeri($id);
	}

	public function hapus_galeri($id)
	{
		$this->galeri->hapus_galeri($id);
	}

	public function data_newsletter()
	{
		if (is_null($this->session->userdata('bisa_lihat_newsletter')) && is_null($this->session->userdata('bisa_ubah_newsletter')) && is_null($this->session->userdata('bisa_hapus_newsletter'))) {
			$this->session->set_flashdata('akses_ditolak', 'Anda tidak memiliki akses untuk melihat data newsletter.');
			redirect('dashboard','refresh');
		}
		$this->newsletter->data_newsletter();
	}

	public function tambah_newsletter()
	{
		if (is_null($this->session->userdata('bisa_buat_newsletter'))) {
			$this->session->set_flashdata('akses_ditolak', 'Anda tidak memiliki akses untuk menambah newsletter.');
			redirect('dashboard','refresh');
		}
		$this->newsletter->tambah_newsletter();
	}

	public function buat_newsletter()
	{
		$this->newsletter->buat_newsletter();
	}

	public function detail_newsletter($id)
	{
		$this->newsletter->detail_newsletter($id);
	}

	public function ubah_newsletter($id)
	{
		$this->newsletter->ubah_newsletter($id);
	}

	public function hapus_newsletter($id)
	{
		$this->newsletter->hapus_newsletter($id);
	}

	public function data_pelanggan()
	{
		if (is_null($this->session->userdata('bisa_lihat_newsletter')) && is_null($this->session->userdata('bisa_ubah_newsletter')) && is_null($this->session->userdata('bisa_hapus_newsletter'))) {
			$this->session->set_flashdata('akses_ditolak', 'Anda tidak memiliki akses untuk melihat data newsletter.');
			redirect('dashboard','refresh');
		}

		$this->newsletter->data_pelanggan();
	}

	public function hapus_pelanggan($id)
	{
		$this->newsletter->hapus_pelanggan($id);
	}

	public function data_pesan()
	{
		if (is_null($this->session->userdata('bisa_lihat_pesan')) && is_null($this->session->userdata('bisa_balas_pesan'))) {
			$this->session->set_flashdata('akses_ditolak', 'Anda tidak memiliki akses untuk melihat data pesan.');
			redirect('dashboard','refresh');
		}

		$this->pesan->data_pesan();
	}

	public function detail_pesan($id)
	{
		$this->pesan->detail_pesan($id);
	}

	public function balas_pesan($id)
	{
		$this->pesan->balas_pesan($id);
	}

	public function data_pencarian()
	{
		$this->pencarian->data_pencarian();
	}

	public function detail_pencarian($kata_kunci)
	{
		$this->pencarian->detail_pencarian($kata_kunci);
	}

	public function data_notifikasi()
	{
		$this->notifikasi->data_notifikasi();
	}

	public function data_user()
	{
		if (is_null($this->session->userdata('bisa_lihat_user')) && is_null($this->session->userdata('bisa_ubah_user'))) {
			$this->session->set_flashdata('akses_ditolak', 'Anda tidak memiliki akses untuk melihat data user.');
			redirect('dashboard','refresh');
		}
		
		$this->user->data_user();
	}

	public function tambah_user()
	{
		if (is_null($this->session->userdata('bisa_buat_user'))) {
			$this->session->set_flashdata('akses_ditolak', 'Anda tidak memiliki akses untuk menambah data user.');
			redirect('dashboard','refresh');
		}

		$this->user->tambah_user();
	}

	public function buat_user()
	{
		$this->user->buat_user();
	}

	public function detail_user($id)
	{
		if (is_null($this->session->userdata('bisa_lihat_user')) && is_null($this->session->userdata('bisa_ubah_user'))) {
			$this->session->set_flashdata('akses_ditolak', 'Anda tidak memiliki akses untuk melihat detail dan/atau mengubah user.');
			redirect('dashboard','refresh');
		}
		
		$this->user->detail_user($id);
	}

	public function ubah_user($id)
	{
		if (is_null($this->session->userdata('bisa_ubah_user')) && $this->uri->segment(3) != $this->session->userdata('id')) {
			$this->session->set_flashdata('akses_ditolak', 'Anda tidak memiliki akses untuk mengubah user.');
			redirect('dashboard','refresh');
		}
		
		$this->user->ubah_user($id);
	}

	public function hapus_user($id)
	{
		$this->user->hapus_user($id);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */