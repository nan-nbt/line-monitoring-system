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
							<h1>Suggestion List Data</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Basic Data</li>
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
								<div class="card-body">
									<table id="example2" class="table table-bordered table-hover table-striped table-head-fixed nowrap text-nowrap" style="width: 100%;">
										<thead>
											<tr>
												<th>NO</th>
												<th>SUGGESTION NO</th>
												<th>SUGGESTION DESC</th>
												<th>LINE TYPE</th>
												<th>PROCESS NO</th>
												<th>STOP MARK</th>
											</tr>
										</thead>
										<tbody id="list-suggest">
											<!-- using JQuery ajax for get data list suggest -->
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
		// declare global variable
		var g_table;

		$(document).ready(function() {
			loadData();
		});

		// pace-progress when ajax request
		$(document).ajaxStart(function() {
			Pace.restart();
		});

		// function load list section data
		function loadData() {
			$.ajax({
				url: "<?php echo base_url('users/Suggest/getList'); ?>",
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var htmlData = '';
					var no = 1;
					var i;

					if (data.length > 0) {
						for (i = 0; i < data.length; i++) {
							// set disable for line type not null
							if (data[i].line_type != null) {
								if (data[i].line_type == '1') {
									var display = data[i].line_type + ' (Small)';
								} else {
									var display = data[i].line_type + ' (Large)';
								}
							} else {
								var display = '<a href="javascript:void(0);" class="btn btn-sm p-0 setup" data-id="' + data[i].suggest_no + '" data-nm="' + data[i].suggest_name + '"><i class="fas fa-cog"></i> Setting</a>';
							}

							htmlData += '<tr>' +
								'<td>' + no++ + '</td>' +
								'<td>' + data[i].suggest_no + '</td>' +
								'<td>' + data[i].suggest_name + '</td>' +
								'<td>' + display + '</td>' +
								'<td>' + data[i].process_no + '</td>' +
								'<td>' + data[i].stop_mk + '</td>' +
								'</tr>';
						}

						$('#example2').DataTable().destroy();
						$('#list-suggest').html(htmlData);

						// set value object of datatables
						g_table = $('#example2').DataTable({
							"pagging": true,
							"lengthChange": true,
							"searching": true,
							"ordering": true,
							"info": true,
							"autoWidth": true,
							"responsive": false,
							"scrollY": 500,
							"scrollX": true,
							// "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],

							/************************************************************
							  set load data in current page: datatable pagination load   
							************************************************************/
							"bStateSave": true,
							"fnStateSave": function(oSettings, oData) {
								localStorage.setItem('offersDataTables', JSON.stringify(oData));
							},
							"fnStateLoad": function(oSettings) {
								return JSON.parse(localStorage.getItem('offersDataTables'));
							}
							/****************************************************************
							  .end set load data in current page: datatable pagination load   
							****************************************************************/
						});

						g_table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

						// function on row data click get data row
						$('#example2 tbody').off('click').on('click', 'tr', function() {
							/* note: add .off('click') to set no multiple selected */
							// set background color row selected
							// if($(this).hasClass('selected')){
							//   $(this).removeClass('selected');
							// }else{
							g_table.$('tr.selected').removeClass('selected');
							$(this).addClass('selected');
							// }
						});

					} else {
						$('#example2').DataTable().destroy();
						$('#list-suggest').html(htmlData);

						// set value object of datatables
						g_tablem = $('#example2').DataTable({
							"paging": true,
							"lengthChange": true,
							"searching": false,
							"ordering": true,
							"info": true,
							"autoWidth": true,
							"responsive": false,
							// "scrollY": 150,
							"scrollX": true,
							// "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
						});

						// add button wrapper in datatable
						g_tablem.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

					}
				}
			});
		}
	</script>

</body>

</html>
