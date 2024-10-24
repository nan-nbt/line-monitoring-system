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
							<h1>Section/Line Data</h1>
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
												<th>SEC NO</th>
												<th>SEC NAME</th>
												<th>DEPT NO</th>
												<th>WEB SEQ</th>
												<th>BUILD NO</th>
												<th>SEC SCNAME</th>
												<th>STOP MARK</th>
												<th>FEE FACT</th>
												<th>WORK CENTER</th>
												<?php if ($this->session->userdata('level') == 'S') : ?>
													<th>LINE TYPE</th>
												<?php endif; ?>
											</tr>
										</thead>
										<tbody id="list-section">
											<!-- using JQuery ajax for get data list section -->
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

				<!-- modal form setup line type -->
				<div class="modal fade" id="modal-setup">
					<div class="modal-dialog modal-default">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Setup Section/Line Type</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<!-- form start -->
							<form class="form-horizontal" id="form-setup" method="POST">
								<div class="modal-body">
									<!-- <p>One fine body&hellip;</p> -->
									<div class="card-body">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<input type="hidden" class="form-control" id="id-section" name="id-section">
													<label for="sec-name" class="col-form-label"><span class="text-danger">*</span>Section/Line :</label>
													<input type="text" class="form-control" id="sec-name" name="sec-name" readonly>
												</div>
												<!-- /.form-group -->
											</div>
											<!-- /.col-md-6 -->
											<div class="col-md-6">
												<div class="form-group">
													<input type="hidden" class="form-control" id="id-section" name="id-section">
													<label for="line-type" class="col-form-label"><span class="text-danger">*</span>Line Type :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="line-type" name="line-type" required>
														<option value="" selected disabled>-- Option --</option>
														<option value="1">1 (Small)</option>
														<option value="2">2 (Large)</option>
													</select>
												</div>
												<!-- /.form-group -->
											</div>
											<!-- /.col-md-6 -->
										</div>
										<!-- /.row -->
									</div>
									<span>Note: This setup will be permanent and can not modify!</span>
									<!-- /.card-body -->
								</div>
								<!-- /.modal-body -->
								<div class="modal-footer justify-content-between">
									<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
									<button type="button" class="btn btn-default" id="reset">Cancel</button>
									<button type="submit" class="btn btn-primary" id="submit">Submit</button>
								</div>
							</form>
							<!-- /.form -->
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->

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
				url: "<?php echo base_url('users/Section/listActiveSection'); ?>",
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
								var display = '<a href="javascript:void(0);" class="btn btn-sm p-0 setup" data-id="' + data[i].sec_no + '" data-nm="' + data[i].sec_name + '"><i class="fas fa-cog"></i> Setting</a>';
							}

							htmlData += '<tr>' +
								'<td>' + no++ + '</td>' +
								'<td>' + data[i].sec_no + '</td>' +
								'<td>' + data[i].sec_name + '</td>' +
								'<td>' + data[i].dept_no + '</td>' +
								'<td>' + data[i].web_seq + '</td>' +
								'<td>' + data[i].build_no + '</td>' +
								'<td>' + data[i].sec_sname + '</td>' +
								'<td>' + data[i].stop_mk + '</td>' +
								'<td>' + data[i].fee_fact + '</td>' +
								'<td>' + data[i].arbpl + '</td>' +
								'<?php if ($this->session->userdata('level') == 'S') : ?>' +
								'<td>' + display + '</td>' +
								'<?php endif; ?>' +
								'</tr>';
						}

						$('#example2').DataTable().destroy();
						$('#list-section').html(htmlData);

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
						$('#example2 tbody').on('click', 'tr', function() {
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
						$('#list-section').html(htmlData);

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

		// function setup line type small
		$('#list-section').on('click', '.setup', function() {
			// declare local variable
			var id = $(this).data('id');
			var nm = $(this).data('nm');
			$('#modal-setup').modal('show');
			$('#id-section').val(id);
			$('#sec-name').val(nm);

			$('#line-type').val("");
			$('#select2-line-type-container').text("-- Option --");
			$('#select2-line-type-container').removeAttr("title", true);
		});

		// setup line type small on submit
		$('#form-setup').on('submit', function() {
			var sec_no = $('#id-section').val();
			var sec_nm = $('#sec-name').val();
			var line_type = $('#line-type').val();

			$.ajax({
				url: "<?php echo base_url('users/Section/updateLine'); ?>",
				method: "POST",
				data: {
					sec_no: sec_no,
					line_type: line_type
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {

					// reset id-section filed value
					$("#" + sec_no).remove();
					$("#" + sec_nm).remove();
					$('#id-section').val("");
					$('#sec-name').val("");

					$('#line-type').val("");
					$('#select2-line-type-container').text("-- Option --");
					$('#select2-line-type-container').removeAttr("title", true);

					$('#modal-setup').modal('hide');

					// setup alert success input data
					if (data == true || data > 0) {
						// load alert message
						var Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000
						});
						Toast.fire({
							icon: 'success',
							title: 'Alert! \n setup section/line successfull!'
						});

						loadData();
					}
				}
			});
			return false;
		});

		// function reset form-modal-add
		$('#reset').on('click', function() {
			//set default
			$('#line-type').val("");
			$('#select2-line-type-container').text("-- Option --");
			$('#select2-line-type-container').removeAttr("title", true);
		});
	</script>

</body>

</html>