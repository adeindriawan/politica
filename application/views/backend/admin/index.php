<!-- Last edited: 2016-07-01 11:39 -->
<?php $this->load->view('backend/admin/include/header'); ?>
<?php echo $nav; ?>
<div class="container-fluid-full">
	<div class="row-fluid">
		<?php $this->load->view('backend/admin/include/menu'); ?>
		<noscript>
			<div class="alert alert-block span10">
				<h4 class="alert-heading">Warning!</h4>
				<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
			</div>
		</noscript>
		<!-- start: Content -->
		<div id="content" class="span10">
			<?php $this->load->view('backend/admin/include/breadcrumb'); ?>
			<div class="row-fluid">
				<div class="span3 statbox purple" onTablet="span6" onDesktop="span3">
					<div class="boxchart">5,6,7,2,0,4,2,4,8,2,3,3,2</div>
					<div class="number"><?php echo $jumlah_berita_dibaca; ?><i class="icon-arrow-up"></i></div>
					<div class="title">berita dibaca</div>
					<div class="footer">
						<a href="#"> read full report</a>
					</div>	
				</div>
				<div class="span3 statbox green" onTablet="span6" onDesktop="span3">
					<div class="boxchart">1,2,6,4,0,8,2,4,5,3,1,7,5</div>
					<div class="number"><?php echo $jumlah_blog_dibaca; ?><i class="icon-arrow-up"></i></div>
					<div class="title">blog dibaca</div>
					<div class="footer">
						<a href="#"> read full report</a>
					</div>
				</div>
				<div class="span3 statbox blue noMargin" onTablet="span6" onDesktop="span3">
					<div class="boxchart">5,6,7,2,0,-4,-2,4,8,2,3,3,2</div>
					<div class="number"><?php echo $jumlah_komentar_artikel; ?><i class="icon-arrow-up"></i></div>
					<div class="title">komentar artikel</div>
					<div class="footer">
						<a href="#"> read full report</a>
					</div>
				</div>
				<div class="span3 statbox yellow" onTablet="span6" onDesktop="span3">
					<div class="boxchart">7,2,2,2,1,-4,-2,4,8,,0,3,3,5</div>
					<div class="number"><?php echo $jumlah_komentar_album ?><i class="icon-arrow-down"></i></div>
					<div class="title">komentar album</div>
					<div class="footer">
						<a href="#"> read full report</a>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span8 widget blue" onTablet="span7" onDesktop="span8">
					<div id="stats-chart2"  style="height:282px" ></div>
				</div>
				<div class="sparkLineStats span4 widget green" onTablet="span5" onDesktop="span4">
                    <ul class="unstyled">
                        <li><span class="sparkLineStats3"></span> 
                            Posts views: 
                            <span class="number" title="Jumlah baca seluruh artikel (berita & blog)" data-rel="tooltip"><?php echo $total_view_artikel; ?></span>
                        </li>
                        <li><span class="sparkLineStats4"></span>
                            Pages per visit: 
                            <span class="number" title="Rata-rata halaman yang dikunjungi dalam sekali visit" data-rel="tooltip"><?php echo $halaman_per_visit; ?></span>
                        </li>
                        <li><span class="sparkLineStats5"></span>
                            Avg. Visit Duration: 
                            <span class="number" title="Rata-rata waktu yang dihabiskan dalam sekali visit" data-rel="tooltip"><?php echo $rerata_durasi_visit ?></span>
                        </li>
                        <li><span class="sparkLineStats6"></span>
                            Bounce Rate: <span class="number" title="Rasio pengunjung yang langsung meninggalkan situs setelah hanya mengunjungi 1 halaman" data-rel="tooltip"><?php echo $tingkat_pantulan ?></span>
                        </li>
                        <li><span class="sparkLineStats7"></span>
                            % New Visits: 
                            <span class="number" title="Rasio kunjungan dari pengunjung baru" data-rel="tooltip"><?php echo $kunjungan_baru ?></span>
                        </li>
                        <li><span class="sparkLineStats8"></span>
                            % Returning Visitor: 
                            <span class="number" title="Rasio kunjungan dari pengunjung lama" data-rel="tooltip"><?php echo $kunjungan_kembali ?></span>
                        </li>
                    </ul>
					<div class="clearfix"></div>
                </div><!-- End .sparkStats -->
			</div>
			<div class="row-fluid">
				<a class="quick-button metro yellow span2">
					<i class="icon-file-alt"></i>
					<p>Artikel</p>
					<span class="badge"><?php echo $jumlah_artikel; ?></span>
				</a>
				<a class="quick-button metro red span2">
					<i class="icon-film"></i>
					<p>Album</p>
					<span class="badge"><?php echo $jumlah_album; ?></span>
				</a>
				<a class="quick-button metro blue span2">
					<i class="icon-comments-alt"></i>
					<p>Komentar</p>
					<span class="badge"><?php echo $jumlah_komentar; ?></span>
				</a>
				<a class="quick-button metro green span2">
					<i class="icon-map-marker"></i>
					<p>Visit</p>
					<span class="badge"><?php echo $jumlah_visit; ?></span>
				</a>
				<a class="quick-button metro pink span2">
					<i class="icon-group"></i>
					<p>Subscribers</p>
					<span class="badge"><?php echo $jumlah_pelanggan; ?></span>
				</a>
				<a class="quick-button metro black span2">
					<i class="icon-search"></i>
					<p>Pencarian</p>
					<span class="badge"><?php echo $jumlah_pencarian; ?></span>
				</a>
				<div class="clearfix"></div>		
			</div><!--/row-fluid -->
		</div><!--/.fluid-container-->
			<!-- end: Content -->
	</div><!--/#content.span10-->
</div><!--/fluid-row-->
	
<div class="clearfix"></div>
<?php $this->load->view('backend/admin/include/footer'); ?>
<script type="text/javascript">
    $(document).ready(function() {
      var link = "<?php echo base_url() ?>";
      var session_id = "<?php echo $this->session->userdata('id') ?>";
      function cek_notifikasi_lagi (id) {
        $.post(link + 'admin/cek_notifikasi', {id_notifikasi: id, session_id: session_id, ajax: 1}, function(data, textStatus, xhr) {
          /*optional stuff to do after success */
          if (data == "false") {
            $.gritter.add({
              title: "Notifikasi",
              text: "Tidak ada notifikasi baru!",
              sticky: false,
            });
          } else {
            response = $.parseJSON(data);
            if (response.length == 0) {
              $.gritter.add({
                title: "Notifikasi",
                text: "Tidak ada notifikasi baru!",
                sticky: false,
              });
            } else {
              $(function(){
                $.each(response, function(index, val) {
                   /* iterate through array or object */
                   if (val.username == null) { val.username = "(User tidak log in)"} else{val.username};
                   $.gritter.add({
                    title: "Notifikasi",
                    text: "Dari : " + val.username + "<br>" + 
                          "Tanggal : " + val.tanggal_notifikasi + "<br>" +
                          "Isi : " + val.isi_notifikasi + "<br><small><em>Klik (x) untuk menutup notifikasi ini.</em></small>",
                    sticky: true,
                    after_close: function() {
                      cek_notifikasi_lagi(val.id_notifikasi);
                    }
                  });
                });
              });
            };
          };
        });
      } // end function cek_notifikasi_lagi
      $.post(link + 'admin/cek_notifikasi', {session_id: session_id, ajax: 1}, function(data) {
        /*optional stuff to do after success */
        if (data == "false") {
          $.gritter.add({
            title: "Notifikasi",
            text: "Tidak ada notifikasi baru!",
            sticky: false,
          });
        } else {
          response = $.parseJSON(data);
          if (response.length == 0) {
            $.gritter.add({
                title: "Notifikasi",
                text: "Tidak ada notifikasi baru!",
                sticky: false,
              });
          } else {
            $(function(){
              $.each(response, function(index, val) {
                 /* iterate through array or object */
                 if (val.username_admin == null) { val.username_admin = "(User tidak log in)"} else{val.username_admin};
                 $.gritter.add({
                  title: "Notifikasi",
                  text: "Dari : " + val.username_admin + "<br>" +
                        "Tanggal : " + val.tanggal_notifikasi + "<br>" +
                        "Isi : " + val.isi_notifikasi + "<br><small><em>Klik (x) untuk menutup notifikasi ini.</em></small>",
                  sticky: true,
                  after_close: function() {
                    cek_notifikasi_lagi(val.id_notifikasi);
                  }
                });
              });
            });
          };
        };
      });
    });
</script>
<script type="text/javascript">
/* ---------- Charts ---------- */

function charts() {
	
	/* ---------- Chart with points ---------- */
	if($("#stats-chart2").length)
	{	
		var link = '<?php echo base_url() ?>';

		$.post(link + 'admin/pageviews_and_visit_chart', {ajax: 1}, function(data) {
			/*optional stuff to do after success */
			if (data == 'false') {
				$('#stats-chart2').hide();
			} else {
				var response = $.parseJSON(data);
				var tanggal = [];
				var pageviews = [];
				var visit = [];
				$.each(response, function(i, item) {
					 /* iterate through array or object */
					tanggal.push([i+1, response[i].Tanggal]);
					pageviews.push([i+1, response[i].Pageviews]);
					visit.push([i+1, response[i].Visit]);
				});

				function doPlot(position) {
					$.plot("#stats-chart2", [
						{ 	data: visit, label: "Visit", 
						  	lines: { show: true, 
									fill: false,
									lineWidth: 2 
								  },
						   	shadowSize: 0 },
						{ 	data: pageviews, label: "Pageviews", yaxis: 2, 
							bars: { show: true,
									fill: false, 
									barWidth: 0.1, 
									align: "center",
									lineWidth: 5,
								} 
						}
					], {series: {
	                        points: {
	                            show: true,
	                            hoverable: true,
	                        }
	                    },
						grid: 	{ 	hoverable: true, 
								   	clickable: true, 
								   	tickColor: "rgba(255,255,255,0.05)",
								   	borderWidth: 0
								},
						legend: { position: "sw" },
						xaxis: {ticks:15, tickDecimals: 0, color: "rgba(255,255,255,0.8)" },
						yaxis: {ticks:5, tickDecimals: 0, color: "rgba(255,255,255,0.8)" },
						yaxes: [ { // align if we are to the right
								alignTicksWithAxis: position == "right" ? 1 : null,
								position: position,
							} ],
						});
				}

				doPlot("right");

				function showTooltip(x, y, contents) {
					$('<div id="tooltip">' + contents + '</div>').css( {
						position: 'absolute',
						display: 'none',
						top: y + 5,
						left: x + 5,
						border: '1px solid #fdd',
						padding: '2px',
						'background-color': '#dfeffc',
						opacity: 0.80
					}).appendTo("body").fadeIn(200);
				}

				var previousPoint = null;
				$("#stats-chart2").bind("plothover", function (event, pos, item) {
					$("#x").text(pos.x.toFixed(2));
					$("#y").text(pos.y.toFixed(2));

					if (item) {
						if (previousPoint != item.dataIndex) {
							previousPoint = item.dataIndex;

							$("#tooltip").remove();
							var x = Math.floor(item.datapoint[0].toFixed(2)),
								y = Math.floor(item.datapoint[1].toFixed(2)).toString().replace(/\B(?=(?:\d{3})+(?!\d))/g, ".");

							showTooltip(item.pageX, item.pageY,
								item.series.label + " di tanggal " + x + " = " + y);
						}
					}
					else {
						$("#tooltip").remove();
						previousPoint = null;
					}
				});
			};
		});
	}

	// we use an inline data source in the example, usually data would
	// be fetched from a server
	var data = [], totalPoints = 300;
	function getRandomData() {
		if (data.length > 0)
			data = data.slice(1);

		// do a random walk
		while (data.length < totalPoints) {
			var prev = data.length > 0 ? data[data.length - 1] : 50;
			var y = prev + Math.random() * 10 - 5;
			if (y < 0)
				y = 0;
			if (y > 100)
				y = 100;
			data.push(y);
		}

		// zip the generated y values with the x values
		var res = [];
		for (var i = 0; i < data.length; ++i)
			res.push([i, data[i]])
		return res;
	}

	// setup control widget
	var updateInterval = 30;
	$("#updateInterval").val(updateInterval).change(function () {
		var v = $(this).val();
		if (v && !isNaN(+v)) {
			updateInterval = +v;
			if (updateInterval < 1)
				updateInterval = 1;
			if (updateInterval > 2000)
				updateInterval = 2000;
			$(this).val("" + updateInterval);
		}
	});

	/* ---------- Realtime chart ---------- */
	if($("#serverLoad").length)
	{	
		var options = {
			series: { shadowSize: 1 },
			lines: { show: true, lineWidth: 3, fill: true, fillColor: { colors: [ { opacity: 0.9 }, { opacity: 0.9 } ] }},
			yaxis: { min: 0, max: 100, tickFormatter: function (v) { return v + "%"; }},
			xaxis: { show: false },
			colors: ["#FA5833"],
			grid: {	tickColor: "#f9f9f9",
					borderWidth: 0, 
			},
		};
		var plot = $.plot($("#serverLoad"), [ getRandomData() ], options);
		function update() {
			plot.setData([ getRandomData() ]);
			// since the axes don't change, we don't need to call plot.setupGrid()
			plot.draw();
			
			setTimeout(update, updateInterval);
		}

		update();
	}
}

charts();
</script>