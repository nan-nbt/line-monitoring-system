<!-- Session login check -->
<?php if ($this->session->userdata('factory') == null && $this->session->userdata('username') == null) {
	redirect(base_url('users/Log'));
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<!-- meta tag -->
	<?php $this->load->view("layouts/_meta.php") ?>

	<!-- title tag -->
	<?php $this->load->view("layouts/_title.php") ?>

	<!-- link stylesheet -->
	<?php $this->load->view("layouts/_css.php") ?>

</head>

<body class="hold-transition layout-top-nav text-sm">
	<!-- Site wrapper -->
	<div class="wrapper">
		<!-- Header -->
		<?php $this->load->view("layouts/_header.php") ?>

		<!-- Main content -->
		<section class="content" style="margin-top:10px;">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<!-- PIE CHART -->
						<div class="card card-navy" id="card-layout">
							<div class="card-header">
								<?php foreach ($tra_collection as $collection) {
									$indate = $collection->submit_date;
									$sec_no = $collection->sec_no;

									if ($overall == '1') {
										$interval = 'Overall';
									} else {
										$interval = 'Last 2 Hours';
									}

									if ($collection->line_type == '1') {
										$layout = $collection->sec_name . ' Line Type ' . $collection->line_type . ' (Small) - ' . date('Y/m/d', strtotime($collection->submit_date)) . ' (' . $interval . ')';
									} else {
										$layout = $collection->sec_name . ' Line Type ' . $collection->line_type . ' (Large) - ' . date('Y/m/d', strtotime($collection->submit_date)) . ' (' . $interval . ')';
									}
								} ?>
								<h3 class="card-title" id="h3-title">Layout: <?php echo $layout; ?></h3>
								<input type="hidden" name="indate" value="<?php echo $indate; ?>">
								<input type="hidden" name="sec_no" value="<?php echo $sec_no; ?>">
								<input type="hidden" name="overall" value="<?php echo $overall; ?>">
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
									<!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button> -->
								</div>
							</div>
							<div class="card-body">
								<!-- <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas> -->
								<!-- layout line -->
								<div class="row mt-12">
									<div class="col-sm-12">
										<div class="position-relative">
											<div class="top-animation" id="data-layout">
												<div id="data-traffic">
													<!-- using JQuery AJAX set data traffic -->
												</div>
												<div id="layout">
													<!-- using JQuery AJAX set layout -->
												</div>
												<div id="section">
													<!-- using JQuery AJAX set line name -->
												</div>
											</div>
										</div>
										<div class="card-body">
											<!-- inner css style | note: &#13;&#10 = new line using php in element <textarea> -->
											<style>
												.area-text {
													width: 100%;
													height: 125px;
													padding: 12px 20px;
													box-sizing: border-box;
													border: 2px solid #ccc;
													border-radius: 8px;
													background-color: #f8f8f8;
													font-size: 14px;
													resize: none;
												}
											</style>
											<div class="row">
												<div class="col-md-4">
													<fieldset style="border-radius: 8px;">
														<legend style="padding: 2px 4px; font-size: 15px;">Pass Rate Traffic Light Status</legend>
														<div class="area-text">
															<i class="fas fa-circle" style="color:#28a745;"></i>: >= 90.00% <br>
															<i class="fas fa-circle" style="color:#ffc107;"></i>: >= 60.00% < 90.00% <br>
																<i class="fas fa-circle" style="color:#dc3545;"></i>: < 60.00% <br>
														</div>
													</fieldset>
												</div>
												<div class="col-md-4">
													<fieldset style="border-radius: 8px;">
														<legend style="padding: 2px 4px; font-size: 15px;">Defect List</legend>
														<textarea class="area-text" id="data-deflist" readonly><!-- using JQuery to get data defect list --></textarea>
													</fieldset>
												</div>
												<div class="col-md-4">
													<fieldset style="border-radius:8px;">
														<legend style="padding: 2px 4px; font-size: 15px;">Suggestion List</legend>
														<textarea class="area-text" id="data-suglist" readonly><!-- using JQuery to get data suggest list --></textarea>
													</fieldset>
												</div>
											</div>
										</div>
										<!-- /.card-body -->
									</div>
								</div>
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.container-fluid -->

			<div class="container-fluid">
				<div class="row">
					<div class="col-6">
						<!-- BAR CHART -->
						<div class="card card-navy" id="card-layout">
							<div class="card-header">
								<h3 class="card-title">RFT Trend : <?php foreach ($tra_collection as $collection) {
																											$month = date('Y/m', strtotime($collection->submit_date));
																										}
																										echo $month; ?> (Month)</h3>

								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>
							<div class="card-body">
								<canvas id="barChart" style="min-height: 200px; height: 200px; max-height: 200px; max-width: 100%;"></canvas>
							</div>
							<!-- /.card-body -->
						</div>
					</div>
					<div class="col-6">
						<!-- PIE CHART -->
						<div class="card card-navy" id="card-layout">
							<div class="card-header">
								<h3 class="card-title">Most Defect By Overall Process : <?php foreach ($tra_collection as $collection) {
																																					$date = date('Y/m/d', strtotime($collection->submit_date));
																																				}
																																				echo $date; ?> (Date | <?php echo $interval; ?>)</h3>

								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>
							<div class="card-body" id="graph-container">
								<canvas id="pieChart" style="min-height: 200px; height: 200px; max-height: 200px; max-width: 100%;"></canvas>
							</div>
							<!-- /.card-body -->
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- /.content -->

		<!-- Footer -->
		<?php //require_once('_footer.php'); 
		?>
		<?php $this->load->view("layouts/_footer.php") ?>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->

	<!-- Javascript -->
	<?php //require_once('_js.php'); 
	?>
	<?php $this->load->view("layouts/_js.php") ?>

	<!-- Page specific script -->
	<script>
		// static variable
		var in_date = $('[name=indate]').val();
		var sec_no = $('[name=sec_no]').val();
		var overall = $('[name=overall]').val();

		/*** PAGE AUTO REFRESH AND GET CURENT SCROLL POSTION ***/
		// auto run function using setTimeout
		$(document).ready(function() {
			loadMostDef();
			loadRFT();
			loadData();
			loadDefList();
			loadSugList();
		});

		// // pace-progress when ajax request
		// $(document).ajaxStart(function(){ 
		//   Pace.restart(); 
		// });

		// function JQuery Ajax get result trafficlight [sec_no, indate]
		function loadData() {
			$.ajax({
				url: "<?php echo base_url('users/Collection/ajaxLayout'); ?>",
				method: "POST",
				data: {
					sec_no: sec_no,
					indate: in_date,
					overall: overall
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {
					// var htmlTitle = '';
					var htmlData = [];
					var tempData = '';
					// var htmlLine = '';
					var htmlLayout = '';
					var i;
					var x;

					if (data.length > 0) {
						for (i = 0; i < data.length; i++) {
							var rate = (data[i].total_pass_qty / data[i].total_check_qty * 100).toFixed(2);
							var sec_name = data[i].sec_name;
							var line = data[i].line_type;
							var process_no = data[i].process;
							var process_subno = data[i].process_no;
							var process_name = data[i].process_name;

							if (data[i].line_type == '1') {
								if (data[i].process == '1') {
									var light = 'light1-1 ';
								};
								if (data[i].process == '2') {
									var light = 'light1-2 ';
								};
								if (data[i].process == '3') {
									var light = 'light1-3 ';
								};
								if (data[i].process == '4') {
									var light = 'light1-4 ';
								};
								if (data[i].process == '5') {
									var light = 'light1-5 ';
								};
								if (data[i].process == '6') {
									var light = 'light1-6 ';
								};
								if (data[i].process == '7') {
									var light = 'light1-7 ';
								};
							} else {
								if (data[i].process == '1') {
									var light = 'light2-1 ';
								};
								if (data[i].process == '2') {
									var light = 'light2-2 ';
								};
								if (data[i].process == '3') {
									var light = 'light2-3 ';
								};
								if (data[i].process == '4') {
									var light = 'light2-4 ';
								};
								if (data[i].process == '5') {
									var light = 'light2-5 ';
								};
								if (data[i].process == '6') {
									var light = 'light2-6 ';
								};
								if (data[i].process == '7') {
									var light = 'light2-7 ';
								};
								if (data[i].process == '8') {
									var light = 'light2-8 ';
								};
								if (data[i].process == '9') {
									var light = 'light2-9 ';
								};
							}

							// method to get tooltips data (desc)
							var description = [];
							for (x = 0; x < data.length; x++) {
								if (data[x].process == data[i].process) {
									description.push(data[x].process_no + ': ' + data[x].process_name);
								}
							}

							if (rate >= 90.00) {
								tempData = '<div class="bs-stepper-circle border border-dark t-tooltip bg-success ' + light + ' text-center" onclick="loadDefListPro(' + process_no + '); loadSugListPro(' + process_no + ');">' +
									'<strong style="cursor:default;">' + process_no + '</strong>' +
									'<span class="t-tooltiptext">P' + process_no + ': ' + rate + '% (' + description.toString() + ')</span>' +
									'</div>';
							} else if (rate >= 60.00 && rate < 90.00) {
								tempData = '<div class="bs-stepper-circle border border-dark t-tooltip bg-warning ' + light + ' text-center" onclick="loadDefListPro(' + process_no + '); loadSugListPro(' + process_no + ');">' +
									'<strong style="cursor:default;">' + process_no + '</strong>' +
									'<span class="t-tooltiptext">P' + process_no + ': ' + rate + '% (' + description.toString() + ')</span>' +
									'</div>';
							} else if (rate < 60.00) {
								tempData = '<div class="bs-stepper-circle border border-dark t-tooltip bg-danger blink-sm-ft ' + light + ' text-center" onclick="loadDefListPro(' + process_no + '); loadSugListPro(' + process_no + ');">' +
									'<strong style="cursor:default;">' + process_no + '</strong>' +
									'<span class="t-tooltiptext">P' + process_no + ': ' + rate + '% (' + description.toString() + ')</span>' +
									'</div>';
							}

							if (!htmlData.includes(tempData)) {
								if (rate >= 90.00) {
									htmlData.push('<div class="bs-stepper-circle border border-dark t-tooltip bg-success ' + light + ' text-center" onclick="loadDefListPro(' + process_no + '); loadSugListPro(' + process_no + ');">' +
										'<strong style="cursor:default;">' + process_no + '</strong>' +
										'<span class="t-tooltiptext">P' + process_no + ': ' + rate + '% (' + description.toString() + ')</span>' +
										'</div>');
								} else if (rate >= 60.00 && rate < 90.00) {
									htmlData.push('<div class="bs-stepper-circle border border-dark t-tooltip bg-warning ' + light + ' text-center" onclick="loadDefListPro(' + process_no + '); loadSugListPro(' + process_no + ');">' +
										'<strong style="cursor:default;">' + process_no + '</strong>' +
										'<span class="t-tooltiptext">P' + process_no + ': ' + rate + '% (' + description.toString() + ')</span>' +
										'</div>');
								} else if (rate < 60.00) {
									htmlData.push('<div class="bs-stepper-circle border border-dark t-tooltip bg-danger blink-sm-ft ' + light + ' text-center" onclick="loadDefListPro(' + process_no + '); loadSugListPro(' + process_no + ');">' +
										'<strong style="cursor:default;">' + process_no + '</strong>' +
										'<span class="t-tooltiptext">P' + process_no + ': ' + rate + '% (' + description.toString() + ')</span>' +
										'</div>');
								}
							}

						}

						// htmlLine += '<div class="ribbon-wrapper ribbon-lg">'+
						//               '<div class="ribbon bg-success text-lg">'+sec_name+'</div>'+
						//             '</div>';
						htmlLayout += '<img src="<?php echo base_url(); ?>assets/dist/img/layout-line-type-' + line + '.png" alt="layout-line-type-' + line + '" class="img-fluid">';

						$('#data-traffic').html(htmlData);
						// $('#section').html(htmlLine);
						$('#layout').html(htmlLayout);
					} else {
						$('#data-traffic').html(htmlData);
						// $('#section').html(htmlLine);
						$('#layout').html(htmlLayout);
					}
				}
			});
		}
		// get new data every 2 minutes
		setInterval(loadData, 120000);

		// function JQuery Ajax get result defect list [sec_no, indate]
		function loadDefList() {

			$.ajax({
				url: "<?php echo base_url('users/Collection/ajaxDefList'); ?>",
				method: "POST",
				data: {
					sec_no: sec_no,
					indate: in_date,
					overall: overall
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {

					var htmlDefList = [];
					var tempDeflist = '';
					var i;
					var x;

					if (data.length > 0) {
						for (i = 0; i < data.length; i++) {
							var pro_no = data[i].process_no;
							var pro_nm = data[i].process_name;
							var defect = data[i].defect;
							var check_qty = data[i].check_qty;
							var pass_qty = data[i].pass_qty;

							tempDefList = 'Process: (P' + pro_no.substring(2, 1) + '-' + pro_no + ') ' + pro_nm + ' &#13;&#10; - Defect Reason: &#13;&#10;  ' + defect + ' &#13;&#10; - Check QTY: ' + check_qty + ' &#13;&#10; - Pass QTY: ' + pass_qty + ' &#13;&#10; &#13;&#10;';

							// check duplicate data looping result
							if (!htmlDefList.includes(tempDefList)) {
								htmlDefList.push('Process: (P' + pro_no.substring(2, 1) + '-' + pro_no + ') ' + pro_nm + ' &#13;&#10; - Defect Reason: &#13;&#10;  ' + defect + ' &#13;&#10; - Check QTY: ' + check_qty + ' &#13;&#10; - Pass QTY: ' + pass_qty + ' &#13;&#10; &#13;&#10;');
							}
						}

						$('#data-deflist').html(htmlDefList.join('').toString());
					} else {
						$('#data-deflist').html(htmlDefList.join('').toString());
					}
				}
			});
		}
		// get new data every 2 minutes
		setInterval(loadDefList, 120000);

		// function load defect list by process
		function loadDefListPro(p) {
			$.ajax({
				url: "<?php echo base_url('users/Collection/ajaxDefListPro'); ?>",
				method: "POST",
				data: {
					sec_no: sec_no,
					indate: in_date,
					process_no: p,
					overall: overall
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var htmlDefList = [];
					var tempDeflist = '';
					var i;
					var x;

					if (data.length > 0) {
						debugger
						for (i = 0; i < data.length; i++) {
							var pro_no = data[i].process_no;
							var pro_nm = data[i].process_name;
							var defect = data[i].defect;
							var check_qty = data[i].check_qty;
							var pass_qty = data[i].pass_qty;

							tempDefList = 'Process: (P' + pro_no.substring(2, 1) + '-' + pro_no + ') ' + pro_nm + ' &#13;&#10; - Defect Reason: &#13;&#10;  ' + defect + ' &#13;&#10; - Check QTY: ' + check_qty + ' &#13;&#10; - Pass QTY: ' + pass_qty + ' &#13;&#10; &#13;&#10;';

							// check duplicate data looping result
							if (!htmlDefList.includes(tempDefList)) {
								htmlDefList.push('Process: (P' + pro_no.substring(2, 1) + '-' + pro_no + ') ' + pro_nm + ' &#13;&#10; - Defect Reason: &#13;&#10;  ' + defect + ' &#13;&#10; - Check QTY: ' + check_qty + ' &#13;&#10; - Pass QTY: ' + pass_qty + ' &#13;&#10; &#13;&#10;');
							}
						}

						$('#data-deflist').html(htmlDefList.join('').toString());
					} else {
						$('#data-deflist').html(htmlDefList.join('').toString());
					}
				}
			});
		}

		// function JQuery Ajax get result suggest list [sec_no, indate]
		function loadSugList() {
			$.ajax({
				url: "<?php echo base_url('users/Collection/ajaxSugList'); ?>",
				method: "POST",
				data: {
					sec_no: sec_no,
					indate: in_date,
					overall: overall
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var htmlSugList = [];
					var tempSugList = '';
					var i;

					if (data.length > 0) {
						for (i = 0; i < data.length; i++) {
							var pro_no = data[i].process_no;
							var pro_nm = data[i].process_name;
							var sug_nm = data[i].suggest_name;

							var listSuggest = [];
							for (x = 0; x < data.length; x++) {
								if (data[x].process_no == data[i].process_no) {
									listSuggest.push(' - ' + data[x].suggest_name + ' &#13;&#10; ');
								}
							}

							tempSugList = 'Process: (P' + pro_no.substring(2, 1) + '-' + pro_no + ') ' + pro_nm + ' &#13;&#10; ' + listSuggest.join("").toString() + ' &#13;&#10;';

							// check duplicate data looping result
							if (!htmlSugList.includes(tempSugList)) {
								htmlSugList.push('Process: (P' + pro_no.substring(2, 1) + '-' + pro_no + ') ' + pro_nm + ' &#13;&#10; ' + listSuggest.join("").toString() + ' &#13;&#10;');
							}
						}

						$('#data-suglist').html(htmlSugList.join('').toString());
					} else {
						$('#data-suglist').html(htmlSugList.join('').toString());
					}
				}
			});
		}
		// get new data every 2 minutes
		setInterval(loadSugList, 120000);

		// function load suggest list by process
		function loadSugListPro(p) {
			// alert(p);
			$.ajax({
				url: "<?php echo base_url('users/Collection/ajaxSugListPro'); ?>",
				method: "POST",
				data: {
					sec_no: sec_no,
					indate: in_date,
					process_no: p,
					overall: overall
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var htmlSugList = [];
					var tempSuglist = '';
					var i;
					var x;

					if (data.length > 0) {
						for (i = 0; i < data.length; i++) {
							var pro_no = data[i].process_no;
							var pro_nm = data[i].process_name;
							var sug_nm = data[i].suggest_name;

							var listSuggest = [];
							for (x = 0; x < data.length; x++) {
								if (data[x].process_no == data[i].process_no) {
									listSuggest.push(' - ' + data[x].suggest_name + ' &#13;&#10; ');
								}
							}

							tempSugList = 'Process: (P' + pro_no.substring(2, 1) + '-' + pro_no + ') ' + pro_nm + ' &#13;&#10; ' + listSuggest.join("").toString() + ' &#13;&#10;';

							// check duplicate data looping result
							if (!htmlSugList.includes(tempSugList)) {
								htmlSugList.push('Process: (P' + pro_no.substring(2, 1) + '-' + pro_no + ') ' + pro_nm + ' &#13;&#10; ' + listSuggest.join("").toString() + ' &#13;&#10;');
							}
						}

						$('#data-suglist').html(htmlSugList.join('').toString());
					} else {
						// htmlSugList.push('Process: (P'+p+') &#13;&#10; - No need Suggestion List data!');
						$('#data-suglist').html(htmlSugList.join('').toString());
					}
				}
			});
		}

		// auto refresh page
		function autoRefresh(t) {
			setTimeout("location.reload(true);", t);
		}

		// set event onload get scroll position
		document.addEventListener("DOMContentLoaded", function(event) {
			var scrollpos = localStorage.getItem("scrollpos");
			if (scrollpos) window.scrollTo(0, scrollpos);
		});

		// function page onscroll
		window.onscroll = function(e) {
			localStorage.setItem("scrollpos", window.scrollY);
		};
		/*** END OF PAGE AUTO REFRESH AND GET CURENT SCROLL POSTION ***/


		/*** PIE CHART - MOST DEFECT BY PROCESS ***/
		var canvasMD = $('#pieChart');
		var data = {
			labels: [<?php foreach ($tra_mostdef as $mostdef) {
									echo '"P' . $mostdef->process . ' (%)",';
								} ?>],
			datasets: [{
				data: [<?php foreach ($tra_mostdef as $mostdef) {
									if ($mostdef->total_defect_qty != 0) {
										echo round($mostdef->sum_defect_qty / $mostdef->total_defect_qty * 100, 2) . ',';
									}
								} ?>],
				backgroundColor: ['#2596be', '#2187ab', '#1e7898', '#1a6985', '#165a72', '#134b5f', '#0f3c4c', '#0b2d39', '#071e26'],
			}]
		};

		var option = {
			maintainAspectRatio: false,
			responsive: true,
		};

		var myPieChart = Chart.Doughnut(canvasMD, {
			data: data,
			options: option
		});

		// logic to get new data
		function loadMostDef() {
			$.ajax({
				url: '<?php echo base_url('users/Collection/ajaxMostDef'); ?>',
				method: "POST",
				data: {
					sec_no: sec_no,
					indate: in_date,
					overall: overall
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var labelMostDef = [];
					var dataMostDef = [];

					if (data.length > 0) {
						for (i = 0; i < data.length; i++) {
							labelMostDef.push('P' + data[i].process + ' (%)');
							if (data[i].total_defect_qty != 0) {
								dataMostDef.push((data[i].sum_defect_qty / data[i].total_defect_qty * 100).toFixed(2));
							}
						}
					}

					myPieChart.data.labels = labelMostDef;
					myPieChart.data.datasets[0].data = dataMostDef;
					myPieChart.update();
				}
			});
		};

		// get new data every 2 minutes
		setInterval(loadMostDef, 120000);
		/*** END OF PIE CHART - MOST DEFECT BY PROCESS ***/

		/*** BAR CHART - RFT TREND BY MONTH ***/
		var canvasRFT = $('#barChart');
		var data = {
			// labels: [<?php // foreach($tra_RFT as $RFT){ echo $RFT->submit_date.','; } 
									?>],
			labels: [],
			datasets: [{
					label: 'Pass Rate (%)',
					backgroundColor: 'rgba(60,141,188,0.9)',
					borderColor: 'rgba(60,141,188,0.8)',
					pointRadius: false,
					pointColor: '#3b8bba',
					pointStrokeColor: 'rgba(60,141,188,1)',
					pointHighlightFill: '#fff',
					pointHighlightStroke: 'rgba(60,141,188,1)',
					// data: [<?php // foreach($tra_RFT as $RFT){ if($RFT->total_check_qty){ echo number_format($RFT->total_pass_qty/$RFT->total_check_qty*100,2).','; }} 
										?>],
					data: []
				},
				{
					label: 'Defect Rate (%)',
					backgroundColor: 'rgba(210, 214, 222, 1)',
					borderColor: 'rgba(210, 214, 222, 1)',
					pointRadius: false,
					pointColor: 'rgba(210, 214, 222, 1)',
					pointStrokeColor: '#c1c7d1',
					pointHighlightFill: '#fff',
					pointHighlightStroke: 'rgba(220,220,220,1)',
					data: []
				}
			]
		};

		var option = {
			maintainAspectRatio: false,
			responsive: true,
			datasetFill: false,
		};

		var myBarChart = Chart.Bar(canvasRFT, {
			data: data,
			options: option
		});

		// logic to get new data
		function loadRFT() {
			/*************************************************************************
			  control barchart label to display data from first date until last date input 
			*************************************************************************/
			var submit_date = '<?php foreach ($tra_collection as $collection) {
														$day = date('Y-m-d', strtotime($collection->submit_date));
													}
													echo $day; ?>';
			// var date = new Date();
			// var month = date.getMonth();
			var date = new Date(submit_date);
			var day = date.getDate();
			date.setDate(1);
			var labelRFT = [];

			// while (date.getMonth() == month) {
			while (date.getDate() <= day) {
				// var d = date.getFullYear() + '-' + date.getMonth().toString().padStart(2, '0') + '-' + date.getDate().toString().padStart(2, '0');
				var d = date.getDate().toString().padStart(2, '0');
				labelRFT.push(d);
				date.setDate(date.getDate() + 1);
			}
			/*************************************************************************
			  .end control barchart label to display data from first date until last date input 
			*************************************************************************/

			$.ajax({
				url: '<?php echo base_url('users/Collection/ajaxRFT'); ?>',
				method: "POST",
				data: {
					sec_no: sec_no,
					indate: in_date
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {
					// var labelRFT = [];
					// var passRFT = [];

					if (data.length > 0) {
						for (i = 0; i < data.length; i++) {
							// labelRFT.push(data[i].submit_date);    
							// if(data[i].total_check_qty != 0){
							//   passRFT.push((data[i].total_pass_qty/data[i].total_check_qty*100).toFixed(2));
							// }

							passRFT = [
								data[i].pass_rate1, data[i].pass_rate2, data[i].pass_rate3, data[i].pass_rate4, data[i].pass_rate5, data[i].pass_rate6, data[i].pass_rate7, data[i].pass_rate8, data[i].pass_rate9, data[i].pass_rate10,
								data[i].pass_rate11, data[i].pass_rate12, data[i].pass_rate13, data[i].pass_rate14, data[i].pass_rate15, data[i].pass_rate16, data[i].pass_rate17, data[i].pass_rate18, data[i].pass_rate19, data[i].pass_rate20,
								data[i].pass_rate21, data[i].pass_rate22, data[i].pass_rate23, data[i].pass_rate24, data[i].pass_rate25, data[i].pass_rate26, data[i].pass_rate27, data[i].pass_rate28, data[i].pass_rate29, data[i].pass_rate30, data[i].pass_rate31
							];

							defectRFT = [
								data[i].defect_rate1, data[i].defect_rate2, data[i].defect_rate3, data[i].defect_rate4, data[i].defect_rate5, data[i].defect_rate6, data[i].defect_rate7, data[i].defect_rate8, data[i].defect_rate9, data[i].defect_rate10,
								data[i].defect_rate11, data[i].defect_rate12, data[i].defect_rate13, data[i].defect_rate14, data[i].defect_rate15, data[i].defect_rate16, data[i].defect_rate17, data[i].defect_rate18, data[i].defect_rate19, data[i].defect_rate20,
								data[i].defect_rate21, data[i].defect_rate22, data[i].defect_rate23, data[i].defect_rate24, data[i].defect_rate25, data[i].defect_rate26, data[i].defect_rate27, data[i].defect_rate28, data[i].defect_rate29, data[i].defect_rate30, data[i].defect_rate31
							];

						}
					}

					myBarChart.data.labels = labelRFT;
					myBarChart.data.datasets[0].data = passRFT;
					myBarChart.data.datasets[1].data = defectRFT;
					myBarChart.update();
				}
			});
		};

		// get new data every 2 minutes
		setInterval(loadRFT, 120000);
		/*** END OF BAR CHART - RFT TREND BY MONTH ***/
	</script>
</body>

</html>
