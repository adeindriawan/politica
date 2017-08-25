<div class="widget-container widget_categories">
				
	<h3 class="widget-title">Kategori Artikel</h3>
	
	<ul>
		<?php if ($kategori->num_rows() > 0) { ?>
			<?php foreach ($kategori->result_array() as $nom => $kat) { ?>
				<li><a href="<?php echo site_url('beranda/cari-kategori/'.$kat['id_kategori']) ?>"><?php echo $kat['kategori']; ?></a></li>
			<?php } ?>
		<?php } else { ?>
			<li><p><small><em>Belum ada kategori artikel</em></small></p></li>
		<?php } ?>
	</ul>
	
</div><!--/ .widget-container-->