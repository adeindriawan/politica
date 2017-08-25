<div class="widget-container widget_popular_posts">
				
	<h3 class="widget-title">Artikel Populer Dibaca</h3>
	
	<ul>
		<?php if ($dibaca->num_rows() > 0) { ?>
			<?php foreach ($dibaca->result_array() as $value) { ?>
				<li>
					<?php $kategori = strtolower($value['jenis_artikel']); ?>
					<?php $tanggal = date_format(date_create($value['tanggal_artikel']), "d/m/Y") ?>
					<a href="<?php echo site_url($kategori.'/artikel/'.$value['id_artikel']) ?>"><h6><?php echo $value['judul_artikel'] ?></h6></a>
					<span class="widget-date"><?php echo $tanggal ?>, <?php echo ($value['jumlah_view_artikel'] == NULL) ? 0 : $value['jumlah_view_artikel'] ?> kali dibaca</span>
				</li>
			<?php } ?>
		<?php } else { ?>
			<li>
				<p><small><em>Belum ada artikel populer dibaca</em></small></p>
			</li>
		<?php } ?>
	</ul>
	
</div><!--/ .widget-container-->