<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analitik {
	var $CI;
	var $nama_cookie;

	public function __construct()
	{
		$this->CI =& get_instance();

        $this->CI->load->database();
        $this->CI->load->library('session');

        $this->nama_cookie = 'politica';
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi blogview()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk mengembalikan data jumlah berapa kali seluruh
	| artikel Blog dibaca. Fungsi ini dipanggil di fungsi index() yang akan menambilkan
	| nilai yang dikembalikan oleh fungsi ini di dalam Dashboard Admin.
	| 
	| Last edited: 2016-06-22 16:00
	*/

	public function blogview()
	{
		$query_jumlah_view_blog = $this->CI->db->select('jumlah_view_artikel')->from('artikel')->where('jenis_artikel', 'Blog')->get();
		
		if ($query_jumlah_view_blog->num_rows() == 0) {
			return 0;
		} else {
			foreach ($query_jumlah_view_blog->result_array() as $key => $vwbl) {
				$array_jumlah_view_blog[] = $vwbl['jumlah_view_artikel'];
			}
			$jumlah_view_blog = array_sum($array_jumlah_view_blog);
			return $jumlah_view_blog;
		}
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi newsview()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk mengembalikan data jumlah berapa kali seluruh
	| artikel Berita dibaca. Fungsi ini dipanggil di fungsi index() yang akan menambilkan
	| nilai yang dikembalikan oleh fungsi ini di dalam Dashboard Admin.
	| 
	| Last edited: 2016-06-22 16:00
	*/

	public function newsview()
	{
		$query_jumlah_view_berita = $this->CI->db->select('jumlah_view_artikel')->from('artikel')->where('jenis_artikel', 'Berita')->get();
		
		if ($query_jumlah_view_berita->num_rows() == 0) {
			return 0;
		} else {
			foreach ($query_jumlah_view_berita->result_array() as $key => $vwbr) {
				$array_jumlah_view_berita[] = $vwbr['jumlah_view_artikel'];
			}
			$jumlah_view_berita = array_sum($array_jumlah_view_berita);
			return $jumlah_view_berita;
		}
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi article_comments()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menghitung jumlah komentar yang ada pada seluruh
	| artikel yang ada. Fungsi ini dipanggil di fungsi index() yang akan menambilkan
	| nilai yang dikembalikan oleh fungsi ini di dalam Dashboard Admin.
	| 
	| Last edited: 2016-07-01 11:18
	*/

	public function article_comments()
	{
		$jumlah_komentar_artikel = $this->CI->db->select('id_komentar')->from('komentar')->where('komentar.id_artikel !=', NULL)->count_all_results();
	
		return $jumlah_komentar_artikel;
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi album_comments()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menghitung jumlah komentar yang ada pada seluruh
	| album yang ada. Fungsi ini dipanggil di fungsi index() yang akan menambilkan
	| nilai yang dikembalikan oleh fungsi ini di dalam Dashboard Admin.
	| 
	| Last edited: 2016-07-01 11:18
	*/

	public function album_comments()
	{
		$jumlah_komentar_album = $this->CI->db->select('id_komentar')->from('komentar')->where('komentar.id_album !=', NULL)->count_all_results();
	
		return $jumlah_komentar_album;
	}

	public function pageviews_and_visit_chart()
	{
		if ($this->CI->input->post('ajax') == 1) {
			$hari_ini = date('d');
			for ($i=1; $i <= $hari_ini; $i++) { 
				$rentang = array('MONTH(visit.waktu_visit)' => date('m'), 'DAY(visit.waktu_visit)' => $i);
				$this->CI->db->select('id_visit')->from('visit');
				$this->CI->db->where($rentang);
				$chart[] = array('Tanggal' => $i, 'Visit' => $this->CI->db->count_all_results());

				$rentang = array('MONTH(visit.waktu_visit)' => date('m'), 'DAY(visit.waktu_visit)' => $i);
				$this->CI->db->select('jumlah_halaman')->from('visit');
				$this->CI->db->where($rentang);
				$query_jumlah_halaman[] = $this->CI->db->get()->result_array(); // isinya array dengan isi field jumlah_halaman
			}

			// untuk menjumlahkan jumlah halaman dari tiap visit yang ada pada tanggal yang sama
			foreach ($query_jumlah_halaman as $key => $halaman) {
					if (count($halaman) > 0) {
						$jml_hlmn = array(); // deklarasikan dulu variabelnya, sekaligus untuk mereset nilainya kembali menjadi 0 setiap iterasi
						foreach ($halaman as $hlmn) {
							$jml_hlmn[] = $hlmn['jumlah_halaman'];
						}
						$chart[$key]['Pageviews'] = array_sum($jml_hlmn);
					} else {
						$chart[$key]['Pageviews'] = 0;
					}
				}
			$encoded_data = json_encode($chart);
			echo $encoded_data;
		} else {
			echo 'false';
		}
	}

	public function pageviews()
	{
		$this->CI->db->select('artikel.jumlah_view_artikel');
		$this->CI->db->from('artikel');
		$query_jumlah_view_artikel = $this->CI->db->get();

		if ($query_jumlah_view_artikel->num_rows() == 0) {
			return 0;
		} else {
			foreach ($query_jumlah_view_artikel->result_array() as $jumlah_view) {
				$jumlah_view_artikel[] = $jumlah_view['jumlah_view_artikel'];
			}

			$pageviews = array_sum($jumlah_view_artikel);

			return $pageviews;
		}
	}

	public function pages_per_visit()
	{
		$query_total_jumlah_halaman = $this->CI->db->select('jumlah_halaman')->from('visit')->get();
		$query_jumlah_visit = $this->CI->db->select('id_visit')->from('visit')->count_all_results();
		if ($query_total_jumlah_halaman->num_rows() == 0) {
			return 0;
		} else {
			foreach ($query_total_jumlah_halaman->result_array() as $key => $jumlah_halaman) {
				$jumlah_halaman_total[] = $jumlah_halaman['jumlah_halaman'];
			}

			$pages_per_visit = number_format(array_sum($jumlah_halaman_total)/$query_jumlah_visit, 2);

			return $pages_per_visit;
		}
	}

	public function average_visit_duration()
	{
		$query_durasi_visit = $this->CI->db->select('durasi_visit')->from('visit')->get();
		$query_jumlah_visit = $query_jumlah_visit = $this->CI->db->select('id_visit')->from('visit')->count_all_results();
		if ($query_durasi_visit->num_rows() == 0) {
			return 0;
		} else {
			foreach ($query_durasi_visit->result_array() as $key => $durasi) {
				$total_durasi[] = $durasi['durasi_visit'];
			}

			$average_visit_duration = intval(array_sum($total_durasi)/$query_jumlah_visit);
			$this->CI->load->helper('konversi_detik_ke_jam_digital');
			$format_jam_digital = konversi_detik_ke_jam_digital($average_visit_duration);
			return $format_jam_digital;
		}
	}

	public function bounce_rate()
	{
		$this->CI->db->select('id_visit')->from('visit');
		$jumlah_visit = $this->CI->db->count_all_results();
		$this->CI->db->select('id_visit')->from('visit');
		$this->CI->db->where('jumlah_halaman', 1);
		$jumlah_visit_satu_halaman = $this->CI->db->count_all_results();

		$bounce_rate = number_format(($jumlah_visit_satu_halaman/$jumlah_visit)*100, 2) . '%';
		return $bounce_rate;
	}

	public function new_visits()
	{
		$this->CI->db->select('id_visit')->from('visit');
		$jumlah_visit = $this->CI->db->count_all_results();
		$this->CI->db->select('id_visit')->from('visit')->where('jumlah_visit', 1);
		$jumlah_visit_baru = $this->CI->db->count_all_results();

		$new_visits = number_format(($jumlah_visit_baru/$jumlah_visit)*100, 2) . '%';
		return $new_visits;
	}

	public function returning_visitors()
	{
		$this->CI->db->select('id_visit')->from('visit');
		$jumlah_visit = $this->CI->db->count_all_results();
		$this->CI->db->select('id_visit')->from('visit')->where('jumlah_visit !=', 1);
		$jumlah_pengunjung_kembali = $this->CI->db->count_all_results();

		$returning_visitors = number_format(($jumlah_pengunjung_kembali/$jumlah_visit)*100, 2) . '%';
		return $returning_visitors;
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi jumlah_artikel()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menghitung jumlah artikel. Fungsi ini 
	| dipanggil di fungsi index() yang akan menambilkan
	| nilai yang dikembalikan oleh fungsi ini di dalam Dashboard Admin.
	| 
	| Last edited: 2016-07-06 19:37
	*/

	public function jumlah_artikel()
	{
		$jmlart = $this->CI->db->select('id_artikel')->from('artikel')->count_all_results();

		return $jmlart;
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi jumlah_album()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menghitung jumlah album. Fungsi ini 
	| dipanggil di fungsi index() yang akan menambilkan
	| nilai yang dikembalikan oleh fungsi ini di dalam Dashboard Admin.
	| 
	| Last edited: 2016-07-06 19:37
	*/

	public function jumlah_album()
	{
		$jmlalb = $this->CI->db->select('id_album')->from('album')->count_all_results();

		return $jmlalb;
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi jumlah_visit()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menghitung jumlah visit. Fungsi ini 
	| dipanggil di fungsi index() yang akan menambilkan
	| nilai yang dikembalikan oleh fungsi ini di dalam Dashboard Admin.
	| 
	| Last edited: 2016-07-06 19:37
	*/

	public function jumlah_visit()
	{
		$jmlvst = $this->CI->db->select('id_visit')->from('visit')->count_all_results();

		return $jmlvst;
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi jumlah_subscriber()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menghitung jumlah subscriber. Fungsi ini 
	| dipanggil di fungsi index() yang akan menambilkan
	| nilai yang dikembalikan oleh fungsi ini di dalam Dashboard Admin.
	| 
	| Last edited: 2016-07-06 19:37
	*/

	public function jumlah_subscriber()
	{
		$jmlsub = $this->CI->db->select('id_pelanggan')->from('pelanggan')->count_all_results();

		return $jmlsub;
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi jumlah_pencarian()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menghitung jumlah pencarian. Fungsi ini 
	| dipanggil di fungsi index() yang akan menambilkan
	| nilai yang dikembalikan oleh fungsi ini di dalam Dashboard Admin.
	| 
	| Last edited: 2016-07-06 19:37
	*/

	public function jumlah_pencarian()
	{
		$jmlpcr = $this->CI->db->select('id_pencarian')->from('pencarian')->count_all_results();

		return $jmlpcr;
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi jumlah_komentar()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menghitung jumlah komentar. Fungsi ini 
	| dipanggil di fungsi index() yang akan menambilkan
	| nilai yang dikembalikan oleh fungsi ini di dalam Dashboard Admin.
	| 
	| Last edited: 2016-07-06 19:37
	*/

	public function jumlah_komentar()
	{
		$jmlkom = $this->CI->db->select('id_komentar')->from('komentar')->count_all_results();

		return $jmlkom;
	}

	/*
	|--------------------------------------------------------------------------
	| Fungsi daftar_notifikasi()
	|--------------------------------------------------------------------------
	|
	| Fungsi di bawah ini adalah untuk menampilkan 5 notifikasi teratas.
	| Notifikasi terdiri dari dua jenis: notifikasi komentar dan notifikasi persetujuan.
	| Notifikasi komentar muncul ketika ada komentar baru yang ditambahkan pada artikel
	| atau album. Khusus untuk notifikasi komentar, perlu dibuat query terlebih dahulu untuk
	| mengetahui jenis dari masing-artikel (Berita/Blog), untuk membuat link menuju
	| artikel tersebut (lihat foreach() di bawah untuk lebih jelasnya).
	| 
	| Sementara itu, notifikasi persetujuan adalah notifikasi yang muncul ketika ada artikel
	| blog yang telah disetujui oleh admin untuk dipublikasikan.
	|
	| Last edited: 2016-06-29 22:36
	*/

	public function daftar_notifikasi()
	{
		$this->CI->db->select('notifikasi.tipe_notifikasi, notifikasi.untuk_id, notifikasi.id_artikel, notifikasi.id_album');
		$this->CI->db->from('notifikasi');
		$this->CI->db->where('untuk_id', $this->CI->session->userdata('id'), FALSE);
		$this->CI->db->limit(5, 0);
		$query_notifikasi = $this->CI->db->get()->result_array();

		$array_notifikasi = array();
		foreach ($query_notifikasi as $key => $notif) {
			if ($notif['id_artikel'] != NULL) {
				$array_notifikasi[$key]['tipe_notifikasi'] = $notif['tipe_notifikasi'];
				$array_notifikasi[$key]['id_artikel'] = $notif['id_artikel'];
				$query_jenis_artikel = $this->CI->db->select('jenis_artikel')->from('artikel')->where('id_artikel', $notif['id_artikel'])->get()->result_array();
				$array_notifikasi[$key]['jenis_artikel'] = strtolower($query_jenis_artikel[0]['jenis_artikel']);
				$array_notifikasi[$key]['id_album'] = NULL;
			} else {
				$array_notifikasi[$key]['tipe_notifikasi'] = $notif['tipe_notifikasi'];
				$array_notifikasi[$key]['id_artikel'] = NULL;
				$array_notifikasi[$key]['jenis_artikel'] = NULL;
				$array_notifikasi[$key]['id_album'] = $notif['id_album'];
			}
		}

		return $array_notifikasi;
	}

	public function review_artikel()
	{
		$this->CI->db->select('artikel.id_artikel');
		$this->CI->db->from('artikel');
		$this->CI->db->where('artikel.status_artikel', 'Pending');
		$this->CI->db->limit(5, 0);

		return $this->CI->db->get();
	}

	public function review_pesan()
	{
		$this->CI->db->select('pesan.id_pesan');
		$this->CI->db->from('pesan');
		$this->CI->db->where('pesan.status_pesan', 'Pending');
		$this->CI->db->limit(5, 0);

		return $this->CI->db->get();
	}

	public function atur_cookie()
	{
    	if (!isset($_COOKIE[$this->nama_cookie])) { 
			//setcookie($name, $value, $expire, $path); // notice time() function
			if (!array_key_exists('HTTP_REFERER', $_SERVER)) {
				$referer = NULL;
			} else {
				$referer = $_SERVER['HTTP_REFERER'];
			}
			
			$jumlah_visit_awal = 1;
			$jumlah_halaman_awal = 1;
			$visit = array(
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'browser' => $_SERVER['HTTP_USER_AGENT'],
				'referer' => $referer,
				'waktu_visit' => date('Y-m-d H:i:s'),
				'jumlah_visit' => $jumlah_visit_awal,
				'jumlah_halaman' => $jumlah_halaman_awal,
				'durasi_visit' => 1,
				);
			$this->CI->db->insert('visit', $visit); // insert cookie tersebut ke dalam database
			$idVisit = $this->CI->db->insert_id('visit'); // dapatkan id visit dari cookie tersebut	
			
			$name = $this->nama_cookie;
			$value = $idVisit . '_' . $jumlah_visit_awal . '-' . $jumlah_halaman_awal . '^' . 1; // format nilai cookie: (id_visit)_(jumlah_visit)-(jumlah_halaman)^(jumlah_durasi)
			$expire = time()+2592000;
			$path = '/';
			setcookie($name, $value, $expire, $path);
			
			// echo $idVisit;
		} else { // jika sudah ada cookie
			$id_visit = intval(substr($_COOKIE[$this->nama_cookie], 0, strpos($_COOKIE[$this->nama_cookie], '_'))); // mengekstrak id_visit dari cookie tersebut dengan cara mengambil nilai yang ada sebelum karakter '_' dan menjadikannya integer
			$this->CI->db->select('DAY(visit.waktu_visit)')->from('visit')->where('id_visit', $id_visit);
			$hari_visit = $this->CI->db->get()->result_array();
			if ($hari_visit[0]['DAY(visit.waktu_visit)'] != date('d')) { // kalau harinya beda, tambahkan nilai jumlah_visit nya
				$jumlah_visit = intval(substr($_COOKIE[$this->nama_cookie], strpos($_COOKIE[$this->nama_cookie], '_') + 1, strpos($_COOKIE[$this->nama_cookie], '-') - 1)); // mengekstrak jumlah_visit dari cookie tersebut dengan cara mengambil nilai yang ada di antara karakter '_' dan '-' lalu menjadikannya integer 
				$jumlah_visit_baru = $jumlah_visit + 1;

				if (!array_key_exists('HTTP_REFERER', $_SERVER)) {
					$referer = NULL;
				} else {
					$referer = $_SERVER['HTTP_REFERER'];
				}
				
				$visit = array(
					'ip_address' => $_SERVER['REMOTE_ADDR'],
					'browser' => $_SERVER['HTTP_USER_AGENT'],
					'referer' => $referer,
					'waktu_visit' => date('Y-m-d H:i:s'),
					'jumlah_visit' => $jumlah_visit_baru,
					'jumlah_halaman' => 1,
					'durasi_visit' => 1,
					);
				$this->CI->db->insert('visit', $visit);
				
				$id_visit_baru = $this->CI->db->insert_id('visit');
				
				$name = $this->nama_cookie;
				$value_baru = $id_visit_baru . '_' . $jumlah_visit_baru . '-' . 1 . '^' . 1; // jumlah_halaman dan durasi_visit direset menjadi 0
				$expire = time()+2592000;
				$path = '/';
				setcookie($name, $value_baru, $expire, $path);
				
				// echo $id_visit_baru;
				// echo "harinya beda";
			} else { // jika harinya sama, cukup tambahkan nilai jumlah_halamannya saja
				$id_visit = intval(substr($_COOKIE[$this->nama_cookie], 0, strpos($_COOKIE[$this->nama_cookie], '_'))); // mengekstrak id_visit dari cookie tersebut dengan cara mengambil nilai yang ada sebelum karakter '_' dan menjadikannya integer
				$jumlah_visit = intval(substr($_COOKIE[$this->nama_cookie], strpos($_COOKIE[$this->nama_cookie], '_') + 1, strpos($_COOKIE[$this->nama_cookie], '-') - 1)); // mengambil nilai yang ada di antara karakter '_' dan '-' lalu menjadikannya integer 
				$jumlah_halaman = intval(substr($_COOKIE[$this->nama_cookie], strpos($_COOKIE[$this->nama_cookie], '-') + 1, strpos($_COOKIE[$this->nama_cookie], '^') - 1)); // mengambil nilai yang ada setelah karakter '-' lalu menjadikannya integer
				$jumlah_halaman_baru = $jumlah_halaman + 1;
				$jumlah_durasi = intval(substr($_COOKIE[$this->nama_cookie], strpos($_COOKIE[$this->nama_cookie], '^') + 1));
				
				$this->CI->db->update('visit', array('jumlah_halaman' => $jumlah_halaman_baru), array('id_visit' => $id_visit));
				
				$name = $this->nama_cookie;
				$value_baru = $id_visit . '_' . $jumlah_visit . '-' . $jumlah_halaman_baru . '^' . $jumlah_durasi;
				$expire = time()+2592000;
				$path = '/';
				setcookie($name, $value_baru, $expire, $path);
				
				// $pesan = $id_visit . '|' . $jumlah_visit . '|' . $jumlah_halaman_baru . '|' . $jumlah_durasi . '|' . $jumlah_halaman;
				// echo $pesan;
			}
		}
	}

	public function cekKeaktifan()
	{
		// if (!isset($_COOKIE[$this->nama_cookie])) {
		// 	echo 'belum ada cookie';
		// } else {
			if ($this->CI->input->post('ajax') != 1) {
				echo 'tidak ada ajax';
			} else {
				$id_visit = intval(substr($_COOKIE[$this->nama_cookie], 0, strpos($_COOKIE[$this->nama_cookie], '_'))); // mengekstrak id_visit dari cookie tersebut dengan cara mengambil nilai yang ada sebelum karakter '_' dan menjadikannya integer
				$jumlah_visit = intval(substr($_COOKIE[$this->nama_cookie], strpos($_COOKIE[$this->nama_cookie], '_') + 1, strpos($_COOKIE[$this->nama_cookie], '-') - 1)); // mengambil nilai yang ada di antara karakter '_' dan '-' lalu menjadikannya integer 
				$jumlah_halaman = intval(substr($_COOKIE[$this->nama_cookie], strpos($_COOKIE[$this->nama_cookie], '-') + 1, strpos($_COOKIE[$this->nama_cookie], '^') - 1)); // mengambil nilai yang ada setelah karakter '-' lalu menjadikannya integer
				$jumlah_durasi = intval(substr($_COOKIE[$this->nama_cookie], strpos($_COOKIE[$this->nama_cookie], '^') + 1));
				$jumlah_durasi_baru = $jumlah_durasi + 1;
				$this->CI->db->update('visit', array('durasi_visit' => $jumlah_durasi_baru), array('id_visit' => $id_visit));

				$name = $this->nama_cookie;
				$value_baru = $id_visit . '_' . $jumlah_visit . '-' . $jumlah_halaman . '^' . $jumlah_durasi_baru;
				$expire = time()+2592000;
				$path = '/';
				setcookie($name, $value_baru, $expire, $path);

				echo 'true';
			}
		// }
	}
}