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
							<h1>Data Collection Report</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Traffic Light Report</li>
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
								<div class="card-header">
									<!-- form start -->
									<form class="form-horizontal" id="report-query">
										<div class="row">
											<div class="col-md-2">
												<!-- Date -->
												<div class="form-group">
													<label for="startdate"><span class="text-danger">*</span>Date Start :</label>
													<div class="input-group date" id="startdate" data-target-input="nearest">
														<input type="text" class="form-control datetimepicker-input" data-target="#startdate" id="startdate_query" name="startdate" value="<?php echo date('Y/m/d'); ?>" required />
														<div class="input-group-append" data-target="#startdate" data-toggle="datetimepicker">
															<div class="input-group-text"><i class="fa fa-calendar"></i></div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label for="enddate"><span class="text-danger">*</span>Date End :</label>
													<div class="input-group date" id="enddate" data-target-input="nearest">
														<input type="text" class="form-control datetimepicker-input" data-target="#enddate" id="enddate_query" name="enddate" value="<?php echo date('Y/m/d'); ?>" required />
														<div class="input-group-append" data-target="#enddate" data-toggle="datetimepicker">
															<div class="input-group-text"><i class="fa fa-calendar"></i></div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label for="area" style="margin-bottom:9px;">Area :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="area" name="area">
														<option value="" selected>-- Option --</option>
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="build" style="margin-bottom:9px;">Building :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="build" name="build">
														<option value="" selected>-- Option --</option>
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="query" style="margin-top:13px;"></label>
													<button type="submit" class="form-control btn btn-primary" id="query">Query</button>
												</div>
											</div>
										</div>
									</form>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<table id="example2" class="table table-bordered table-striped table-head-fixed nowrap text-nowrap" style="width: 100%;">
										<thead>
											<tr>
												<th>NO</th>
												<!-- <th>ACTION</th> -->
												<!-- <th>FACT NO</th> -->
												<th>AREA</th>
												<th>BUILDING</th>
												<th>SECTION</th>
												<th>CHECK QTY</th>
												<th>PASS QTY</th>
												<th>PASS RATE (%)</th>
												<th>DEFECT QTY</th>
												<th>DEFECT RATE (%)</th>
											</tr>
										</thead>
										<tbody id="data-collection">

										</tbody>
									</table>
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
		// page onload function
		$(document).ready(function() {
			loadData(); // call function loadData
			loadActiveArea();
		});

		// pace-progress when ajax request
		$(document).ajaxStart(function() {
			Pace.restart();
		});

		// function onclick button query
		$('#report-query').on('submit', function() {
			var area = $('#area').val();
			$('#query').html('<i class="fas fa-circle-notch fa-spin"></i>');

			loadData(); // call function loadData

			return false;
		});

		// function load data on datatable plugin
		function loadData() {
			var area = $('#area').val();
			var build = $('#build').val();
			var startdate = $('#startdate_query').val();
			var enddate = $('#enddate_query').val();

			$.ajax({
				url: "<?php echo base_url('users/Collection/getReport'); ?>",
				method: "POST",
				data: {
					area: area,
					build: build,
					startdate: startdate,
					enddate: enddate
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var htmlData = '';
					var no = 1;
					var light = '';
					var cell = '';
					var table;
					var i;
					if (data.length > 0) {
						for (i = 0; i < data.length; i++) {
							var sum_pass_rate = (data[i].sum_pass_qty / data[i].sum_check_qty * 100).toFixed(2);
							var sum_defect_rate = (data[i].sum_defect_qty / data[i].sum_check_qty * 100).toFixed(2);

							if (sum_pass_rate >= 90) {
								light = '<i class="fas fa-circle" style="color:#28a745;"></i>';
								cell = 'cell-green';
								bg_cell = 'bg-success';
							} else if (sum_pass_rate < 90 && sum_pass_rate >= 60) {
								light = '<i class="fas fa-circle" style="color:#ffc107;"></i>';
								cell = 'cell-yellow';
								bg_cell = 'bg-warning';
							} else if (sum_pass_rate < 60) {
								light = '<i class="fas fa-circle blink-sm-ft" style="color:#dc3545;"></i>';
								cell = 'cell-red';
								bg_cell = 'bg-danger';
							}

							// htmlData += '<tr>'+
							//               '<td class="'+cell+'">'+no+++' | '+light+'</td>'+
							//               '<td>'+data[i].area_no+' | '+data[i].area_nm+'</td>'+
							//               '<td>'+data[i].build_no+' | '+data[i].build_nm+'</td>'+
							//               '<td>'+data[i].sec_no+' | '+data[i].sec_nm+'</td>'+
							//               '<td>'+data[i].sum_check_qty+'</td>'+
							//               '<td>'+data[i].sum_pass_qty+'</td>'+
							//               '<td>'+sum_pass_rate+'</td>'+
							//               '<td>'+data[i].sum_defect_qty+'</td>'+
							//               '<td>'+sum_defect_rate+'</td>'+
							//             '</tr>';

							htmlData += '<tr>' +
								'<td>' + no++ + '</td>' +
								'<td>' + data[i].area_nm + '</td>' +
								'<td>' + data[i].build_nm + '</td>' +
								'<td>' + data[i].sec_nm + '</td>' +
								'<td>' + data[i].sum_check_qty + '</td>' +
								'<td>' + data[i].sum_pass_qty + '</td>' +
								'<td class="' + bg_cell + '">' + sum_pass_rate + '</td>' +
								'<td>' + data[i].sum_defect_qty + '</td>' +
								'<td>' + sum_defect_rate + '</td>' +
								'</tr>';

						}
						$('#example2').DataTable().destroy();
						$('#data-collection').html(htmlData);
						$('#query').text('Query');

						table = $('#example2').DataTable({
							"pagging": true,
							"lengthChange": true,
							"searching": true,
							"ordering": true,
							"info": true,
							"autoWidth": true,
							"responsive": false,
							"scrollY": 400,
							"scrollX": true,
							// "columnDefs": [
							//                 {"className": "dt-center", "targets": "_all"}
							//               ],
							"buttons": [{
									extend: 'excelHtml5',
									text: 'Export data (.xlsx)',
									filename: 'Pouchen_<?php echo $this->session->userdata('sap_factory'); ?>_Traffic Light System Collection_<?php echo date('YmdHis'); ?>',
									messageTop: 'Data Collection Report | Area: ' + area + ' | Building: ' + build + ' | Date: ' + startdate + ' - ' + enddate,
									// customize: function(xlsx){
									//   debugger
									//   var sheet = xlsx.xl.worksheets['sheet1.xml'];
									//   var row = 0;

									//   $('row', sheet).each(function(x){
									//     if(x > 0){ row++ };
									//     debugger
									//       if($(table.cell(':eq('+row+')', 0).node()).hasClass('cell-green')){
									//         $('row:nth-child('+(x+4)+') c:nth-child(7)', sheet).attr('s', '15');
									//       }else if ($(table.cell(':eq('+row+')', 0).node()).hasClass('cell-yellow')){
									//         $('row:nth-child('+(x+4)+') c:nth-child(7)', sheet).attr('s', '5');
									//       }else{
									//         $('row:nth-child('+(x+4)+') c:nth-child(7)', sheet).attr('s', '10');
									//       }

									//       // else if ($('c[r=D'+x+'] t', sheet).text() === 'C35A | S-10-4A') {
									//       //   $('row:nth-child('+x+') c', sheet).attr('s', '39');
									//       // }
									//   });
									// }
								},
								{
									extend: 'pdf',
									text: 'Export data (.pdf)',
									filename: 'Pouchen_<?php echo $this->session->userdata('sap_factory'); ?>_Traffic Light System Collection_<?php echo date('YmdHis'); ?>',
									messageTop: 'Data Collection Report | Area: ' + area + ' | Building: ' + build + ' | Date: ' + startdate + ' - ' + enddate,
								}
							],
						});
						table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
					} else {
						$('#example2').DataTable().destroy();
						$('#data-collection').html(htmlData);
						$('#query').text('Query');

						table = $('#example2').DataTable({
							"pagging": true,
							"lengthChange": true,
							"searching": true,
							"ordering": true,
							"info": true,
							"autoWidth": true,
							"responsive": false,
							"scrollY": 400,
							"scrollX": true,
							"buttons": [{
									extend: 'excel',
									text: 'Export data (.xlsx)',
									messageTop: 'Data Collection Report | Area: ' + area + ' | Building: ' + build + ' | Date: ' + startdate + ' - ' + enddate
								},
								{
									extend: 'pdf',
									text: 'Export data (.pdf)',
									messageTop: 'Data Collection Report | Area: ' + area + ' | Building: ' + build + ' | Date: ' + startdate + ' - ' + enddate
								}
							],
						});
						table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
					}
				}
			});
		}

		// function to get data section/line for dropdowon list 
		function loadActiveArea() {
			$.ajax({
				url: "<?php echo base_url('users/Collection/listActiveArea'); ?>",
				method: "POST",
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var htmlArea = '';
					var i;

					htmlArea += '<option value="" selected>-- Option --</option>';

					for (i = 0; i < data.length; i++) {
						htmlArea += '<option value=' + data[i].prod_fact + '>' + data[i].prod_fact + ' | ' + data[i].prod_fact_nm + '</option>';
					}

					// set dropdown list section/line on field query
					$('#area').html(htmlArea);
					$('#area').val("");

				}
			});
		}

		// function onchange option area
		$('#area').on('change', function() {
			$('#build').val("");
			$('#select2-build-container').text("-- Option --");
			loadBuild(); // call function loadBuild
		});

		// filter option building by area
		function loadBuild() {
			var area = $('#area').val();
			$.ajax({
				url: "<?php echo base_url('users/Collection/getBuild'); ?>",
				method: "POST",
				data: {
					area: area
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var htmlBuild = '<option value="">-- Option --</option>';
					var i;
					for (i = 0; i < data.length; i++) {
						htmlBuild += '<option value=' + data[i].build_no + '>' + data[i].build_no + ' | ' + data[i].build_eng_nm + '</option>';
					}
					$('#build').html(htmlBuild);
					$('#build').val("");
				}
			});
		}
	</script>

</body>

</html>
