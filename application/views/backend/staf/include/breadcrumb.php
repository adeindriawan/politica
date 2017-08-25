<!-- Last edited: 2017-07-01 10:27 -->
<ul class="breadcrumb">
	<?php switch ($this->uri->segment(2)) {
		case '':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-dashboard"></i><a href="' . base_url() .'staf">Dashboard</a></li>';
			break;

		case 'data-halaman':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-list"></i><a href="' . base_url() . 'data-halaman">Data Halaman</a></li>';
			break;

		case 'tambah-halaman':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-plus"></i><a href="' . base_url() . 'tambah-halaman">Tambah Halaman</a></li>';
			break;

		case 'edit-halaman':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-edit"></i><a href="' . base_url() . 'edit-halaman/'.$this->uri->segment(3).'">Edit Halaman</a></li>';
			break;

		case 'detail-halaman':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-zoom-in"></i><a href="' . base_url() . 'detail-halaman/'.$this->uri->segment(3).'">Detail Halaman</a></li>';
			break;

		case 'data-berita':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-list"></i><a href="' . base_url() . 'data-berita">Data Berita</a></li>';
			break;

		case 'tambah-berita':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-plus"></i><a href="' . base_url() . 'tambah-berita">Tambah Berita</a></li>';
			break;

		case 'edit-berita':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-edit"></i><a href="' . base_url() . 'edit-berita/'.$this->uri->segment(3).'">Edit Berita</a></li>';
			break;

		case 'data-blog':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-list"></i><a href="' . base_url() . 'data-blog">Data Blog</a></li>';
			break;

		case 'tambah-blog':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-plus"></i><a href="' . base_url() . 'tambah-blog">Tambah Blog</a></li>';
			break;

		case 'edit-blog':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-edit"></i><a href="' . base_url() . 'edit-blog/'.$this->uri->segment(3).'">Edit Blog</a></li>';
			break;

		case 'data-album':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-list"></i><a href="' . base_url() . 'data-album">Data Album</a></li>';
			break;

		case 'tambah-album':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-plus"></i><a href="' . base_url() . 'tambah-album">Tambah Album</a></li>';
			break;

		case 'edit-album':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-edit"></i><a href="' . base_url() . 'edit-album/'.$this->uri->segment(3).'">Edit Album</a></li>';
			break;

		case 'data-kategori':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-list"></i><a href="' . base_url() . 'data-kategori">Data Kategori</a></li>';
			break;

		case 'tambah-kategori':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-plus"></i><a href="' . base_url() . 'tambah-kategori">Tambah Kategori</a></li>';
			break;

		case 'edit-kategori':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-edit"></i><a href="' . base_url() . 'edit-kategori/'.$this->uri->segment(3).'">Edit Kategori</a></li>';
			break;
		
		case 'data-user':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-list"></i><a href="' . base_url() . 'data-user">Data User</a></li>';
			break;

		case 'tambah-user':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-plus"></i><a href="' . base_url() . 'tambah-user">Tambah User</a></li>';
			break;

		case 'edit-user':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-edit"></i><a href="' . base_url() . 'edit-user/'.$this->uri->segment(3).'">Edit User</a></li>';
			break;

		case 'data-pelanggan':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-group"></i><a href="' . base_url() . 'data-pelanggan/">Data Pelanggan Newsletter</a></li>';
			break;

		case 'tambah-newsletter':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-pencil"></i><a href="' . base_url() . 'tambah-newsletter/">Kirim Newsletter</a></li>';
			break;

		case 'data-newsletter':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-list-alt"></i><a href="' . base_url() . 'data-newsletter/">Data Newsletter</a></li>';
			break;

		case 'detail-newsletter':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-zoom-in"></i><a href="' . base_url() . 'detail-newsletter/ ' . $this->uri->segment(3) .' ">Detail Newsletter</a></li>';
			break;

		case 'data-notifikasi':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-bell"></i><a href="' . base_url() . 'data-notifikasi/">Data Notifikasi</a></li>';
			break;

		case 'data-pencarian':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-zoom-in"></i><a href="' . base_url() . 'data-pencarian/">Data Pencarian</a></li>';
			break;

		case 'detail-pencarian':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-zoom-in"></i><a href="' . base_url() . 'detail-pencarian/ '. $this->uri->segment(3) . '">Detail Pencarian</a></li>';
			break;

		case 'data-tugas':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-table"></i><a href="' . base_url() . 'data-tugas/">Data Tugas</a></li>';
			break;

		case 'data-pesan':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-envelope"></i><a href="' . base_url() . 'data-pesan/">Data Pesan</a></li>';
			break;

		case 'detail-pesan':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-envelope"></i><a href="' . base_url() . 'detail-pesan/">Detail Pesan</a></li>';
			break;

		case 'profil':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-user"></i><a href="' . base_url() . 'profil/'.$this->uri->segment(3).'">Profil</a></li>';
			break;

		default:
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-dashboard"></i><a href="' . base_url() .'staf">Dashboard</a></li>';
			break;
	} ?>
</ul>