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

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed text-sm">
	<!-- Site wrapper -->
	<div class="wrapper">
		<!-- Header -->
		<?php $this->load->view("layouts/_header.php") ?>

		<!-- Sidebar -->
		<?php $this->load->view("layouts/_sidebar.php") ?>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1>Data Visualization</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Traffic Light Process</li>
							</ol>
						</div>
					</div>
				</div><!-- /.container-fluid -->
			</section>

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<!-- form start -->
								<form class="form-horizontal" action="<?php echo base_url('users/Collection/visual') ?>" method="POST">
									<div class="card-header">
										<div class="row">
											<!-- Date -->
											<div class="col-md-4">
												<div class="form-group">
													<label for="indate"><span class="text-danger">*</span>Date :</label>
													<div class="input-group date" id="indate" data-target-input="nearest">
														<input type="text" class="form-control datetimepicker-input" data-target="#indate" id="indate" name="indate" value="<?php echo date('Ymd'); ?>" onkeydown="return (event.keyCode!=13);" required />
														<div class="input-group-append" data-target="#indate" data-toggle="datetimepicker">
															<div class="input-group-text"><i class="fa fa-calendar"></i></div>
														</div>
													</div>
												</div>
											</div>
											<!-- Line -->
											<div class="col-md-4">
												<div class="form-group">
													<label for="sec_no" style="margin-bottom:9px;"><span class="text-danger">*</span>Section/Line :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="sec_no" name="sec_no" required>
														<option value="" selected disabled>-- Section/Line --</option>
													</select>
												</div>
											</div>
											<!-- Overall data by date -->
											<div class="col-md-4">
												<div class="form-group">
													<label for="overall" style="margin-bottom:9px;"></span>Overall data Visualization by Date :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="overall" name="overall">
														<option value="1" selected>ON | Get overall data visualization by date</option>
														<option value="0">OFF | Get data visualization by the last 2 hours</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
							<!-- /.card -->
							<!-- PIE CHART -->
							<div class="card card-default" id="card-layout">
								<div class="card-header">
									<h3 class="card-title" id="h3-title">Layout: </h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
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
												<div class="row">
													<div class="col-md-12 p-0" id="pass-rate-status">
														<!-- using JQuery AJAX set status fieldset -->
													</div>
												</div>
											</div>
											<!-- /.card-body -->
											<div id="detail">
												<!-- using JQuery AJAX set detail form -->
											</div>
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
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

		<!-- Footer -->
		<?php $this->load->view("layouts/_footer.php") ?>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->

	<!-- Javascript -->
	<?php $this->load->view("layouts/_js.php") ?>

	<!-- Page specific script -->
	<script>
		// auto run function using setTimeout
		$(document).ready(function() {
			// loadAllSec();
			setInterval(loadData, 30000);
		});

		// pace-progress when ajax request
		$(document).ajaxStart(function() {
			Pace.restart();
		});

		// JQuery function get result visual when overall checked or not
		// if (event.cancelable) event.preventDefault();
		$('#overall-checkbox').on('switchChange.bootstrapSwitch', function(event) {
			loadData();
			return false;
		});

		// JQuery function get result visual when section selected
		$('#overall').on('change', function() {
			loadData();
			return false;
		});

		// JQuery function get result visual when section selected
		$('#sec_no').on('change', function() {
			loadData();
			return false;
		});

		// JQuery function get result visual when date selected
		$('#indate').on('input', function() {
			loadData();
			loadSecByDate();
			return false;
		});

		// function to get data section/line for dropdowon list 
		function loadAllSec() {
			$.ajax({
				url: "<?php echo base_url('users/Section/listActiveSection'); ?>",
				method: "POST",
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var htmlSection = '';
					var i;

					htmlSection += '<option value="" selected>-- Section/Line --</option>';

					for (i = 0; i < data.length; i++) {
						htmlSection += '<option value=' + data[i].sec_no + '>' + data[i].sec_no + ' | ' + data[i].sec_name + '</option>';
					}

					// set dropdown list section/line on field query
					$('#sec_no').html(htmlSection);
					$('#sec_no').val("");

				}
			});
		}

		// function to get data section/line for dropdowon list 
		function loadSecByDate() {
			convIndate = $('[name=indate]').val().split('/');
			var inDate = convIndate[0] + convIndate[1] + convIndate[2];

			$.ajax({
				url: "<?php echo base_url('users/Section/listSectionDate'); ?>",
				method: "POST",
				data: {
					indate: inDate
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var htmlSection = '';
					var i;

					htmlSection += '<option value="" selected>-- Section/Line --</option>';

					for (i = 0; i < data.length; i++) {
						htmlSection += '<option value=' + data[i].sec_no + '>' + data[i].sec_no + ' | ' + data[i].sec_name + '</option>';
					}

					// set dropdown list section/line on field query
					$('#sec_no').html(htmlSection);
					$('#sec_no').val("");

				}
			});
		}

		// function JQuery Ajax get result [sec_no, indate]
		function loadData() {
			// check query method by checkbox overall data visualization
			// if ($('#overall-checkbox').is(":checked")){
			// 	var overall = 'on';
			// }else{
			// 	var overall = 'off';
			// }

			convIndate = $('[name=indate]').val().split('/');
			var inDate = convIndate[0] + convIndate[1] + convIndate[2];
			var secNo = $('#sec_no').val();
			var overall = $('#overall').val();

			$.ajax({
				url: "<?php echo base_url('users/Collection/visual'); ?>",
				method: "POST",
				data: {
					sec_no: secNo,
					indate: inDate,
					overall: overall
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {

					var htmlData = [];
					var tempData = '';
					// var htmlLine = '';
					var htmlTitle = '';
					var htmlLayout = '';
					var htmlForm = '';
					var htmlStatus = '';
					var i;

					if (data.length > 0) {
						for (i = 0; i < data.length; i++) {
							var rate = (data[i].e / data[i].d * 100).toFixed(2);
							var sec_name = data[i].a;
							var line = data[i].b;
							var process_no = data[i].c;

							if (data[i].b == '1') {
								if (data[i].c == '1') {
									var light = 'light1-1 ';
								};
								if (data[i].c == '2') {
									var light = 'light1-2 ';
								};
								if (data[i].c == '3') {
									var light = 'light1-3 ';
								};
								if (data[i].c == '4') {
									var light = 'light1-4 ';
								};
								if (data[i].c == '5') {
									var light = 'light1-5 ';
								};
								if (data[i].c == '6') {
									var light = 'light1-6 ';
								};
								if (data[i].c == '7') {
									var light = 'light1-7 ';
								};
							} else {
								if (data[i].c == '1') {
									var light = 'light2-1 ';
								};
								if (data[i].c == '2') {
									var light = 'light2-2 ';
								};
								if (data[i].c == '3') {
									var light = 'light2-3 ';
								};
								if (data[i].c == '4') {
									var light = 'light2-4 ';
								};
								if (data[i].c == '5') {
									var light = 'light2-5 ';
								};
								if (data[i].c == '6') {
									var light = 'light2-6 ';
								};
								if (data[i].c == '7') {
									var light = 'light2-7 ';
								};
								if (data[i].c == '8') {
									var light = 'light2-8 ';
								};
								if (data[i].c == '9') {
									var light = 'light2-9 ';
								};
							}

							if (rate >= 90.00) {
								tempData = '<div class="bs-stepper-circle border border-dark bg-success ' + light + ' t-tooltip text-center">' +
									'<strong style="cursor:default;">' + process_no + '</strong>' +
									'<span class="t-tooltiptext">P' + process_no + ': ' + rate + '%</span>' +
									'</div>';
							} else if (rate >= 60.00 && rate < 90.00) {
								tempData = '<div class="bs-stepper-circle border border-dark bg-warning ' + light + ' t-tooltip text-center">' +
									'<strong style="cursor:default;">' + process_no + '</strong>' +
									'<span class="t-tooltiptext">P' + process_no + ': ' + rate + '%</span>' +
									'</div>';
							} else if (rate < 60.00) {
								tempData = '<div class="bs-stepper-circle border border-dark bg-danger blink-sm-ft ' + light + ' t-tooltip text-center">' +
									'<strong style="cursor:default;">' + process_no + '</strong>' +
									'<span class="t-tooltiptext">P' + process_no + ': ' + rate + '%</span>' +
									'</div>';
							}


							if (!htmlData.includes(tempData)) {
								if (rate >= 90.00) {
									htmlData.push('<div class="bs-stepper-circle border border-dark bg-success ' + light + ' t-tooltip text-center">' +
										'<strong style="cursor:default;">' + process_no + '</strong>' +
										'<span class="t-tooltiptext">P' + process_no + ': ' + rate + '%</span>' +
										'</div>');
								} else if (rate >= 60.00 && rate < 90.00) {
									htmlData.push('<div class="bs-stepper-circle border border-dark bg-warning ' + light + ' t-tooltip text-center">' +
										'<strong style="cursor:default;">' + process_no + '</strong>' +
										'<span class="t-tooltiptext">P' + process_no + ': ' + rate + '%</span>' +
										'</div>');
								} else if (rate < 60.00) {
									htmlData.push('<div class="bs-stepper-circle border border-dark bg-danger blink-sm-ft ' + light + ' t-tooltip text-center">' +
										'<strong style="cursor:default;">' + process_no + '</strong>' +
										'<span class="t-tooltiptext">P' + process_no + ': ' + rate + '%</span>' +
										'</div>');
								}
							}

						}

						if (line < 2) {
							htmlTitle += 'Layout: ' + sec_name + ' Line Type ' + line + ' (Small)';
						} else {
							htmlTitle += 'Layout: ' + sec_name + ' Line Type ' + line + ' (Large)';
						}

						// htmlLine += '<div class="ribbon-wrapper ribbon-lg">'+
						//               '<div class="ribbon bg-success text-lg">'+sec_name+'</div>'+
						//             '</div>';
						htmlLayout += '<img src="<?php echo base_url(); ?>assets/dist/img/layout-line-type-' + line + '.png" alt="layout-line-type-' + line + '" class="img-fluid">';
						htmlForm += '<div class="col-md-12">' +
							'<form action="<?php echo base_url('users/Collection/detail'); ?>" method="POST" target="trafficlight_detail">' +
							'<input type="hidden" id="sec_no" name="sec_no" value="' + secNo + '"/>' +
							'<input type="hidden" id="indate" name="indate" value="' + inDate + '"/>' +
							'<input type="hidden" id="overall" name="overall" value="' + overall + '"/>' +
							'<button type="submit" class="nav-item nav-link btn btn-lg btn-primary float-right col-md-12">View Detail <i class="fas fa-arrow-right"></i></button>' +
							// '<a href="<?php echo base_url('users/Collection/detail'); ?>" target="trafficlight_detail" class="nav-item nav-link btn btn-lg btn-primary float-right col-md-12">Detail</a>'+
							'</form>' +
							'</div>';
						htmlStatus = '<fieldset style="border-radius: 8px;">' +
							'<legend style="padding: 2px 4px; font-size: 15px;">Pass Rate Traffic Light Status</legend>' +
							'<!-- inner css style | note: &#13;&#10 = new line using php in element <textarea> -->' +
							'<style>.area-text { width: 100%; height: 90px; padding: 12px 20px; box-sizing: border-box; border: 2px solid #ccc; border-radius: 8px; background-color: #f8f8f8; font-size: 14px; resize: none; }</style>' +
							'<div class="area-text">' +
							'<i class="fas fa-circle" style="color:#28a745;"></i>: >= 90.00% <br>' +
							'<i class="fas fa-circle" style="color:#ffc107;"></i>: >= 60.00% < 90.00% <br>' +
							'<i class="fas fa-circle" style="color:#dc3545;"></i>: < 60.00% <br>' +
							'</div>' +
							'</fieldset>';

						$('#h3-title').html(htmlTitle);
						$('#data-traffic').html(htmlData);
						// $('#section').html(htmlLine);
						$('#layout').html(htmlLayout);
						$('#detail').html(htmlForm);
						$('#pass-rate-status').html(htmlStatus);
					} else {
						htmlTitle += 'Layout: ';
						htmlLayout = '<span class="text center">No data available in the layout! Please select other section/line!</span>';
						$('#h3-title').html(htmlTitle);
						$('#data-traffic').html(htmlData);
						// $('#section').html(htmlLine);
						$('#layout').html(htmlLayout);
						$('#detail').html(htmlForm);
						$('#pass-rate-status').html(htmlStatus);
					}
				}
			});
		}
	</script>
</body>

</html>
