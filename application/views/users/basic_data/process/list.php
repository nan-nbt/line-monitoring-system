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
							<h1>Step Process Data</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Basic Data</li>
							</ol>
						</div>
					</div>
				</div>
				<!-- /.container-fluid -->
			</section>

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<!-- <div class="card-header">
                <h3 class="card-title">DataTable with minimal features & hover style</h3>
              </div> -->
								<?php if ($this->session->userdata('level') == 'S') : ?>
									<!-- <div class="card-header">
                <button type="button" class="form-control btn btn-default col-md-2 float-right" data-toggle="modal" data-target="#modal-input-process" id="input-col">
                  <i class="fas fa-plus-circle"></i> Add Step Process Data
                </button>
              </div> -->
								<?php endif; ?>
								<!-- /.card-header -->
								<div class="card-body">
									<table id="example2" class="table table-bordered table-hover table-striped table-head-fixed nowrap text-nowrap" style="width: 100%;">
										<thead>
											<tr>
												<th>NO</th>
												<th>PROCESS NO</th>
												<th>PROCESS NAME</th>
												<th>LINE TYPE</th>
												<th>STOP MARK</th>
												<?php if ($this->session->userdata('level') == 'S') : ?>
													<!-- <th>ACTION</th> -->
												<?php endif; ?>
											</tr>
										</thead>
										<tbody id="list-process">
											<!-- using jQuery to get data list process -->
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

				<!-- Modal Form Input Data Collection -->
				<div class="modal fade" id="modal-input-process">
					<div class="modal-dialog modal-xl">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Input Step Process Data</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<!-- form start -->
							<form class="form-horizontal" id="form-input-process" method="POST">
								<div class="modal-body">
									<!-- <p>One fine body&hellip;</p> -->
									<div class="card-body">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="process_no" class="col-form-label"><span class="text-danger">*</span>Process NO :</label>
													<input type="text" class="form-control" id="process_no" name="process_no" placeholder="ex: 012 (prefix code-main process code-sub process code)" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
												</div>
												<!-- /.form-group -->
												<div class="form-group">
													<label for="process_name" class="col-form-label">Process Name :</label>
													<input type="text" class="form-control" id="process_name" name="process_name" placeholder="process name description" required>
												</div>
												<!-- /.form-group -->
											</div>
											<!-- /.col-md-6 -->
											<div class="col-md-6">
												<div class="form-group">
													<label for="line_type" class="col-form-label"><span class="text-danger">*</span>Line Type :</label>
													<select class="form-control select2bs4" id="line_type" name="line_type" required>
														<option value="" selected disabled>-- Option --</option>
														<option value="1" <?php // if($tra_process->line_type == '1'){ echo 'selected'; } 
																							?>>1 (Small)</option>
														<option value="2" <?php // if($tra_process->line_type == '2'){ echo 'selected'; } 
																							?>>2 (Large)</option>
													</select>
												</div>
												<!-- /.form-group -->
												<div class="form-group">
													<label for="stop_mk" class="col-form-label"><span class="text-danger">*</span>Stop Mark :</label>
													<select class="form-control select2bs4" id="stop_mk" name="stop_mk" required>
														<option value="" selected disabled>-- Option --</option>
														<option value="Y" <?php // if($process_id->stop_mk == 'Y'){ echo 'selected'; } 
																							?>>Y</option>
														<option value="N" <?php // if($process_id->stop_mk == 'N'){ echo 'selected'; } 
																							?>>N</option>
													</select>
												</div>
												<!-- /.form-group -->
											</div>
											<!-- /.col-md-6 -->
										</div>
										<!-- /.row -->
									</div>
									<!-- /.card-body -->
								</div>
								<!-- /.modal-body -->
								<div class="modal-footer justify-content-between">
									<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
									<button type="button" class="btn btn-default" id="reset">Cancel</button>
									<button type="submit" class="btn btn-primary" id="submit-process">Submit</button>
								</div>
							</form>
							<!-- /.form -->
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->

				<!-- Modal Form Edit Data Collection -->
				<div class="modal fade" id="modal-edit-process">
					<div class="modal-dialog modal-xl" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Edit Step Process Data</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<!-- form start -->
							<form class="form-horizontal" id="form-edit-process" method="POST">
								<div class="modal-body">
									<!-- <p>One fine body&hellip;</p> -->
									<div class="card-body">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="edit_process_no" class="col-form-label"><span class="text-danger">*</span>Process NO :</label>
													<input type="text" class="form-control" id="edit_process_no" name="edit_process_no" placeholder="ex: 012 (prefix code-main process code-sub process code)" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required readonly>
												</div>
												<!-- /.form-group -->
												<div class="form-group">
													<label for="edit_process_name" class="col-form-label">Process Name :</label>
													<input type="text" class="form-control" id="edit_process_name" name="edit_process_name" placeholder="process name description" required readonly>
												</div>
												<!-- /.form-group -->
											</div>
											<!-- /.col-md-6 -->
											<div class="col-md-6">
												<div class="form-group">
													<label for="edit_line_type" class="col-form-label"><span class="text-danger">*</span>Line Type :</label>
													<!-- <input type="hidden" class="form-control" id="edit_line_type" name="edit_line_type" required readonly> -->
													<select class="form-control select2bs4" id="edit_line_type" name="edit_line_type" required disabled>
														<option value="" selected disabled>-- Option --</option>
														<option value="1">1 (Small)</option>
														<option value="2">2 (Large)</option>
													</select>
												</div>
												<!-- /.form-group -->
												<div class="form-group">
													<label for="edit_stop_mk" class="col-form-label"><span class="text-danger">*</span>Stop Mark :</label>
													<select class="form-control select2bs4" id="edit_stop_mk" name="edit_stop_mk" required>
														<option value="" selected disabled>-- Option --</option>
														<option value="Y">Y</option>
														<option value="N">N</option>
													</select>
												</div>
												<!-- /.form-group -->
											</div>
											<!-- /.col-md-6 -->
										</div>
										<!-- /.row -->
									</div>
									<!-- /.card-body -->
								</div>
								<!-- /.modal-body -->
								<div class="modal-footer justify-content-between">
									<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
									<button type="button" class="btn btn-default" id="edit_reset">Cancel</button>
									<button type="submit" class="btn btn-primary" id="update-process">Update</button>
								</div>
							</form>
							<!-- /.form -->
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->

				<!-- Modal Form Delete Data Process -->
				<div class="modal fade" id="modal-delete-process">
					<div class="modal-dialog modal-default">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Delete Process Data</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<!-- form start -->
							<form class="form-horizontal" id="form-delete-process" method="POST">
								<div class="modal-body">
									<!-- <p>One fine body&hellip;</p> -->
									<input type="hidden" class="form-control" id="id-process" name="id-process">
									<span>Are sure to delete this process data?</span>
									<!-- /.card-body -->
								</div>
								<!-- /.modal-body -->
								<div class="modal-footer justify-content-between">
									<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
									<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">No</button>
									<button type="submit" class="btn btn-primary">Yes</button>
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
		var g_eno;
		var g_enm;
		var g_elt;
		var g_esm;

		$(document).ready(function() {
			// call function on page ready
			loadData();
		});

		// pace-progress when ajax request
		$(document).ajaxStart(function() {
			Pace.restart();
		});

		// function load list process data
		function loadData() {
			$.ajax({
				url: "<?php echo base_url('users/Process/ajaxShow'); ?>",
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var htmlData = '';
					var no = 1;
					var i;

					if (data.length > 0) {
						for (i = 0; i < data.length; i++) {
							// set display line type
							if (data[i].line_type == '1') {
								var line = data[i].line_type + ' (Small)';
							} else {
								var line = data[i].line_type + ' (Large)';
							}

							htmlData += '<tr>' +
								'<td>' + no++ + '</td>' +
								'<td>' + data[i].process_no + '</td>' +
								'<td>' + data[i].process_name + '</td>' +
								'<td>' + line + '</td>' +
								'<td>' + data[i].stop_mk + '</td>' +
								'<?php if ($this->session->userdata('level') == 'S') : ?>' +
								// '<td>'+
								//   '<a href="javascript:void(0);" class="btn btn-sm p-0 edit-row" data-id="'+data[i].process_no+data[i].line_type+'" data-process_no="'+data[i].process_no+'" data-process_name="'+data[i].process_name+'" data-line_type="'+data[i].line_type+'" data-stop_mk="'+data[i].stop_mk+'"><i class="fas fa-edit"></i></a>  | '+
								//   '<a href="javascript:void(0);" class="btn btn-sm p-0 delete-row" data-id="'+data[i].process_no+data[i].line_type+'"><i class="fas fa-trash"></i></a>'+
								// '</td>'+
								'<?php endif; ?>' +
								'</tr>';
						}

						$('#example2').DataTable().destroy();
						$('#list-process').html(htmlData);

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
						$('#list-process').html(htmlData);

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

		// control for input format process_no 
		// $('#process_no').on('input', function(){
		//   var process_no = $('#process_no').val();
		//   var line_type = $('#line_type').val();

		//   if(line_type == '1'){
		//     if(parseInt(process_no.substr(1,1)) > 7){
		//       $('#process_no').val("");
		//     }
		//   }else{
		//     if(parseInt(process_no.substr(1,1)) > 9){
		//       $('#process_no').val("");
		//     }
		//   }
		// });

		// function add new process list
		$('#form-input-process').submit('click', function() {
			var process_no = $('#process_no').val();
			var process_name = $('#process_name').val();
			var line_type = $('#line_type').val();
			var stop_mk = $('#stop_mk').val();

			$.ajax({
				url: "<?php echo base_url('users/Process/ajaxAdd'); ?>",
				type: "POST",
				dataType: "JSON",
				data: {
					process_no: process_no,
					process_name: process_name,
					line_type: line_type,
					stop_mk: stop_mk
				},
				success: function(data) {
					$('#process_no').val("");
					$('#process_name').val("");
					$('#line_type').val("");
					$('#stop_mk').val("");

					$('#select2-line_type-container').text("-- Option --");
					$('#select2-stop_mk-container').text("-- Option --");

					$('#select2-line_type-container').removeAttr("title", true);
					$('#select2-stop_mk-container').removeAttr("title", true);

					$('#modal-input-process').modal('hide');

					if (data == true) {
						// load alert message
						var Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000
						});
						Toast.fire({
							icon: 'success',
							title: 'Alert! \n save successfull!'
						});

						loadData();
					}
				}
			});
			return false;
		});

		// function edit list process
		$('#list-process').on('click', '.edit-row', function() {
			$('#modal-edit-process').modal('show');
			$("#edit_process_no").val($(this).data('process_no'));
			$("#edit_process_name").val($(this).data('process_name'));
			$("#edit_line_type").val($(this).data('line_type')).change();
			$("#edit_stop_mk").val($(this).data('stop_mk')).change();

			// set default value for reset form edit (global variable)
			g_eno = $(this).data('process_no');
			g_enm = $(this).data('process_name');
			g_elt = $(this).data('line_type');
			g_esm = $(this).data('stop_mk');
		});

		// submit edit data
		$('#form-edit-process').on('submit', function() {
			// declare local variable
			var process_no = $('#edit_process_no').val();
			var process_name = $('#edit_process_name').val();
			var line_type = $('#edit_line_type').val();
			var stop_mk = $('#edit_stop_mk').val();

			$.ajax({
				url: "<?php echo base_url('users/Process/ajaxEdit'); ?>",
				type: "POST",
				dataType: 'JSON',
				data: {
					process_no: process_no,
					process_name: process_name,
					line_type: line_type,
					stop_mk: stop_mk
				},
				success: function(data) {

					// reset input form value
					$("#edit_process_no").val("");
					$("#edit_process_name").val("");
					$('#edit_line_type').val("");
					$("#edit_stop_mk").val("");

					$('#select2-edit_line_type-container').text("-- Option --");
					$('#select2-edit_stop_mk-container').text("-- Option --");

					$('#select2-edit_line_type-container').removeAttr("title", true);
					$('#select2-edit_stop_mk-container').removeAttr("title", true);

					$('#modal-edit-process').modal('hide');

					if (data == true) {
						// load alert message success
						var Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000
						});
						Toast.fire({
							icon: 'success',
							title: 'Alert! \n update successfull!'
						});

						loadData();
					} else {
						// load alert message success
						var Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000
						});
						Toast.fire({
							icon: 'error',
							title: 'Alert! \n update failed!'
						});
					}
				}
			});
			return false;
		});

		// function delete list process
		$('#list-process').on('click', '.delete-row', function() {
			// declare local variable
			var id = $(this).data('id');
			$('#modal-delete-process').modal('show');
			$('#id-process').val(id);
		});

		// delete emp record
		$('#form-delete-process').on('submit', function() {
			// declare local variable
			var id = $('#id-process').val();
			var process_no = $('#id-process').val().substr(0, 3);
			var line_type = $('#id-process').val().substr(3, 1);

			$.ajax({
				url: "<?php echo base_url('users/Process/ajaxDelete/'); ?>" + process_no + line_type,
				type: "POST",
				dataType: 'JSON',
				data: {
					process_no: process_no,
					line_type: line_type
				},
				success: function(data) {
					// reset id-process filed value
					$("#" + id).remove();
					$('#id-process').val("");

					$('#modal-delete-process').modal('hide');

					if (data == true) {
						// load alert message success
						var Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000
						});
						Toast.fire({
							icon: 'success',
							title: 'Alert! \n delete successfull!'
						});

						loadData();
					} else {
						// load alert message error
						var Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000
						});
						Toast.fire({
							icon: 'error',
							title: 'Alert! \n delete failed! unable to delete, data is already used on data collection!'
						});
					}
				}
			});
			return false;
		});

		// function reset form-modal-add
		$('#reset').on('click', function() {
			//set default
			$('#process_no').val("");
			$('#process_name').val("");
			$('#line_type').val("");
			$('#stop_mk').val("");

			$('#select2-line_type-container').text("-- Option --");
			$('#select2-stop_mk-container').text("-- Option --");

			$('#select2-line_type-container').removeAttr("title", true);
			$('#select2-stop_mk-container').removeAttr("title", true);
		});

		// function reset form-modal-edit
		$('#edit_reset').on('click', function() {
			//set default
			$('#edit_process_no').val(g_eno);
			$('#edit_process_name').val(g_enm);
			$('#edit_line_type').val(g_elt).change();
			$('#edit_stop_mk').val(g_esm).change();
		});
	</script>

</body>

</html>
