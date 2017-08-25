<!-- Last edited: 2017-07-01 10:27 -->
<ul class="breadcrumb">
	<?php switch ($this->uri->segment(2)) {
		case '':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-dashboard"></i><a href="' . base_url() . $this->session->userdata('type') . '">Dashboard</a></li>';
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

		case 'data-notifikasi':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-bell"></i><a href="' . base_url() . 'data-notifikasi">Data Notifikasi</a></li>';
			break;

		case 'data-pencarian':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-search"></i><a href="' . base_url() . 'data-pencarian">Data Pencarian</a></li>';
			break;

		case 'detail-pencarian':
			echo '<li>';
			echo '<i class="icon-home"></i>';
			echo '<a href="'.base_url().$this->session->userdata('type').'">Beranda</a>';
			echo '<i class="icon-angle-right"></i>';
			echo '</li>';
			echo '<li><i class="icon-search"></i><a href="' . base_url() . 'detail-pencarian">Detail Pencarian</a></li>';
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
			echo '<li><i class="icon-dashboard"></i><a href="' . base_url() . $this->session->userdata('type') . '">Dashboard</a></li>';
			break;
	} ?>
</ul>