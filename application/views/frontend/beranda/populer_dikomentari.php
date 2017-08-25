<div class="widget-container widget_popular_posts">
				
	<h3 class="widget-title">Artikel Populer Dikomentari</h3>
	
	<ul>
		<?php if ($dikomentari->num_rows() > 0) { ?>
			<?php foreach ($dikomentari->result_array() as $value) { ?>
				<li>
					<?php $kategori = strtolower($value['jenis_artikel']); ?>
					<?php $tanggal = date_format(date_create($value['tanggal_artikel']), "d/m/Y") ?>
					<a href="<?php echo site_url($kategori.'/artikel/'.$value['id_artikel']) ?>"><h6><?php echo $value['judul_artikel'] ?></h6></a>
					<span class="widget-date"><?php echo $tanggal ?>, <?php echo ($value['jumlah_komentar'] == NULL) ? 0 : $value['jumlah_komentar'] ?> komentar</span>
				</li>
			<?php } ?>
		<?php } else { ?>
			<li>
				<p><small><em>Belum ada artikel populer dikomentari</em></small></p>
			</li>
		<?php } ?>
	</ul>
	
</div><!--/ .widget-container-->