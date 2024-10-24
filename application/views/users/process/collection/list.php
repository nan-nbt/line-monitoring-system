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
	<div class="wrapper" id="wrapper">
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
							<h1>Data Collection</h1>
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
								<div class="card-header">
									<!-- form start -->
									<form class="form-horizontal" id="collection-query">
										<div class="row">
											<div class="col-md-3">
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
											<div class="col-md-3">
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
											<div class="col-md-3">
												<div class="form-group">
													<label for="sec_no_query" style="margin-bottom:9px;">Section/Line :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="sec_no_query" name="sec_no_query">
														<option value="" selected>-- Section/Line --</option>
														<!-- using JQuery ajax to get dropdown data list -->
													</select>
												</div>
											</div>
											<div class="col-md-1">
												<div class="form-group">
													<label for="query" style="margin-top:13px;"></label>
													<button type="submit" class="form-control btn btn-primary" id="query">Query</button>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label for="input-col" style="margin-top:13px;"></label>
													<button type="button" class="form-control btn btn-default" data-toggle="modal" data-target="#modal-input-collection" id="add">
														<i class="fas fa-plus-circle"></i> Input Data Collection
													</button>
												</div>
											</div>
										</div>
									</form>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<table id="example2" class="display table table-bordered table-hover table-striped table-head-fixed nowrap text-nowrap" style="width: 100%;">
										<thead>
											<tr>
												<th>NO</th>
												<th>ACTION</th>
												<!-- <th>FACT NO</th> -->
												<th>SECTION NO</th>
												<th>LINE TYPE</th>
												<th>PO</th>
												<th>SO</th>
												<th>PROCESS</th>
												<th>CHECK QTY</th>
												<th>PASS QTY</th>
												<th>DEFECT QTY</th>
												<th>PASS RATE (%)</th>
												<th>SUBMIT ID</th>
												<th>SUBMIT DATE</th>
												<th>SUBMIT USER</th>
												<!-- <th>DEFECT RATE</th> -->
											</tr>
										</thead>
										<tbody id="list-collection">
											<!-- Using JQuery Ajax to display data -->
										</tbody>
									</table>
								</div>
								<!-- /.card-body -->

								<div class="card-body">
									<table id="detail-example2" class="display table table-bordered table-hover table-striped table-head-fixed nowrap text-nowrap" style="width: 100%;">
										<thead>
											<tr>
												<th>NO</th>
												<!-- <th>ACTION</th> -->
												<!-- <th>FACT NO</th> -->
												<th>SUBMIT SEQ</th>
												<th>DEFECT NO</th>
												<th>DEFECT DESCRIPTION</th>
												<th>DEFECT QTY</th>
												<th>DEFECT RATE (%)</th>
											</tr>
										</thead>
										<tbody id="list-detail-collection">
											<!-- Using JQuery Ajax to display data -->
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
				<div class="modal fade" id="modal-input-collection">
					<div class="modal-dialog modal-xl">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Input Data Collection</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<!-- form start -->
							<form class="form-horizontal" id="form-input-collection" method="POST">
								<div class="modal-body">
									<!-- <p>One fine body&hellip;</p> -->
									<div class="card-body">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="sec_no" class="col-form-label"><span class="text-danger">*</span>Section/Line :</label>
													<input type="hidden" class="form-control" id="line_type" name="line_type" value="">
													<select class="form-control select2bs4" style="width: 100%;" id="sec_no" name="sec_no" required>
														<option value="" selected disabled>-- Section/Line --</option>
														<!-- using JQuery to get dropdown data section/line -->
													</select>
												</div>
												<!-- /.form-group -->
												<div class="form-group">
													<label for="po_no" class="col-form-label"><span class="text-danger">*</span>PO :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="po_no" name="po_no" required disabled>
														<option value="" data-so="" id="default-po" selected disabled>-- PO --</option>
														<!-- using JQuery to get dropdown data PO -->
													</select>
												</div>
												<!-- /.form-group -->
												<div class="form-group">
													<label for="vbeln" class="col-form-label"><span class="text-danger">*</span>SO :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="vbeln" name="vbeln" required disabled>
														<option value="" data-po="" id="default-so" selected disabled>-- SO --</option>
														<!-- using JQuery to get dropdown data SO -->
													</select>
												</div>
												<!-- /.form-group -->
											</div>
											<!-- /.col-md-6 -->
											<div class="col-md-6">
												<div class="form-group">
													<label for="process_no" class="col-form-label"><span class="text-danger">*</span>Process :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="process_no" name="process_no" required disabled>
														<option value="" selected disabled>-- Option --</option>
														<!-- using JQuery to get dropdown data process -->
													</select>
												</div>
												<!-- /.form-group -->
												<div class="form-group">
													<label for="check_qty" class="col-form-label"><span class="text-danger">*</span>Check QTY :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="check_qty" name="check_qty" required>
														<option value="" selected>-- Option --</option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="6">6</option>
														<option value="7">7</option>
														<option value="8">8</option>
														<option value="9">9</option>
														<option value="10">10</option>
													</select>
												</div>
												<!-- /.form-group -->
												<div class="form-group">
													<label for="pass_qty" class="col-form-label"><span class="text-danger">*</span>Pass QTY :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="pass_qty" name="pass_qty" required>
														<option value="" selected disabled>-- Option --</option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="6">6</option>
														<option value="7">7</option>
														<option value="8">8</option>
														<option value="9">9</option>
														<option value="10">10</option>
													</select>
												</div>
												<!-- /.form-group -->
											</div>
											<!-- /.col-md-6 -->
										</div>
										<!-- /.row -->
										<!-- defect reason input field using JQuery-->
										<div id="defect_label"></div>
										<div id="defect_field"></div>
										<!-- /.row -->
									</div>
									<!-- /.card-body -->
								</div>
								<!-- /.modal-body -->
								<div class="modal-footer justify-content-between">
									<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
									<button type="reset" class="btn btn-default" id="reset">Cancel</button>
									<button type="submit" class="btn btn-primary" id="submit-collection">Submit</button>
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
				<div class="modal fade" id="modal-edit-collection">
					<div class="modal-dialog modal-xl">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Edit Data Collection</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<!-- form start -->
							<form class="form-horizontal" id="form-edit-collection" method="POST">
								<div class="modal-body">
									<!-- <p>One fine body&hellip;</p> -->
									<div class="card-body">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="edit_sec_no" class="col-form-label"><span class="text-danger">*</span>Section/Line :</label>
													<input type="hidden" class="form-control" id="edit_line_type" name="edit_line_type" value="">
													<select class="form-control select2bs4" style="width: 100%;" id="edit_sec_no" name="edit_sec_no" required disabled>
														<option value="" selected disabled>-- Section/Line --</option>
														<!-- using JQuery to get dropdown data section/line -->
													</select>
												</div>
												<!-- /.form-group -->
												<div class="form-group">
													<label for="edit_po_no" class="col-form-label"><span class="text-danger">*</span>PO :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="edit_po_no" name="edit_po_no" required disabled>
														<option value="" data-so="" id="edit_default_po" selected disabled>-- PO --</option>
														<!-- using JQuery to get dropdown data PO -->
													</select>
												</div>
												<!-- /.form-group -->
												<div class="form-group">
													<label for="edit_vbeln" class="col-form-label"><span class="text-danger">*</span>SO :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="edit_vbeln" name="edit_vbeln" required disabled>
														<option value="" data-po="" id="edit_default_so" selected disabled>-- SO --</option>
														<!-- using JQuery to get dropdown data SO -->
													</select>
												</div>
												<!-- /.form-group -->
											</div>
											<!-- /.col-md-6 -->
											<div class="col-md-6">
												<div class="form-group">
													<label for="edit_process_no" class="col-form-label"><span class="text-danger">*</span>Process :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="edit_process_no" name="edit_process_no" required disabled>
														<option value="" selected disabled>-- Option --</option>
														<!-- using JQuery to get dropdown data process -->
													</select>
												</div>
												<!-- /.form-group -->
												<div class="form-group">
													<label for="edit_check_qty" class="col-form-label"><span class="text-danger">*</span>Check QTY :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="edit_check_qty" name="edit_check_qty" required>
														<option value="" selected>-- Option --</option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="6">6</option>
														<option value="7">7</option>
														<option value="8">8</option>
														<option value="9">9</option>
														<option value="10">10</option>
													</select>
												</div>
												<!-- /.form-group -->
												<div class="form-group">
													<label for="edit_pass_qty" class="col-form-label"><span class="text-danger">*</span>Pass QTY :</label>
													<select class="form-control select2bs4" style="width: 100%;" id="edit_pass_qty" name="edit_pass_qty" required>
														<option value="" selected disabled>-- Option --</option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="6">6</option>
														<option value="7">7</option>
														<option value="8">8</option>
														<option value="9">9</option>
														<option value="10">10</option>
													</select>
												</div>
												<!-- /.form-group -->
											</div>
											<!-- /.col-md-6 -->
										</div>
										<!-- /.row -->
										<!-- defect reason input field using JQuery-->
										<div id="edit_defect_label"></div>
										<div id="edit_defect_field"></div>
										<!-- /.row -->
									</div>
									<!-- /.card-body -->
								</div>
								<!-- /.modal-body -->
								<div class="modal-footer justify-content-between">
									<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
									<button type="button" class="btn btn-default" id="edit_reset">Cancel</button>
									<button type="submit" class="btn btn-primary" id="update_collection">Update</button>
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
				<div class="modal fade" id="modal-delete-collection">
					<div class="modal-dialog modal-default">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Delete Collection Data</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<!-- form start -->
							<form class="form-horizontal" id="form-delete-collection" method="POST">
								<div class="modal-body">
									<!-- <p>One fine body&hellip;</p> -->
									<input type="hidden" class="form-control" id="id-collection" name="id-collection">
									<span>Are sure to delete this collection data?</span>
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
		<div id="close-overlay"></div>
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
		var g_tablem;
		var g_tabled;

		// master data variable
		var g_esi;
		var g_esd;
		var g_esu;
		var g_epo;
		var g_eso;
		var g_epn;
		var g_elt;

		// detail data variable
		var g_edq;
		var g_ecq;
		var g_epq;

		// page onload function
		$(document).ready(function() {
			// call function on page ready
			loadData();
			loadDetailData();
			loadActiveSec();

		});

		// pace-progress when ajax request
		$(document).ajaxStart(function() {
			Pace.restart();
		});

		/*************************************************************

		              script action query collection data 

		************************************************************/
		// function onclick button query
		$('#collection-query').on('submit', function() {
			// set icon progress load
			$('#query').html('<i class="fas fa-circle-notch fa-spin"></i>');

			// call function loadData
			loadData();
			loadDetailData();

			// $('#add').attr('disabled', true);

			return false;
		});

		// function to get data section/line for dropdowon list 
		function loadActiveSec() {
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
					$('#sec_no_query').html(htmlSection);
					$('#sec_no_query').val("");

					// set dropdown list section/line on form input collection
					$('#sec_no').html(htmlSection);
					$('#sec_no').val("");

					// set dropdown list section/line on form edit collection
					$('#edit_sec_no').html(htmlSection);
					$('#edit_sec_no').val("");

				}
			});
		}

		/*************************************************************

		            .end script action query collection data 

		************************************************************/

		/*************************************************************

		              script modal input collection data 

		************************************************************/
		// function set default when select section/line
		$('#sec_no').on('change', function() {
			//set default
			$('#po_no').val("");
			$('#vbeln').val("");
			$('#process_no').val("");
			$('#check_qty').val("");
			$('#pass_qty').val("");
			$('#defect_label').html("");
			$('#defect_field').html("");

			$('#select2-po_no-container').text("-- PO --");
			$('#select2-vbeln-container').text("-- SO --");
			$('#select2-process_no-container').text("-- Option --");
			$('#select2-check_qty-container').text("-- Option --");
			$('#select2-pass_qty-container').text("-- Option --");
			$('#select2-po_no-container').removeAttr("title", true);
			$('#select2-vbeln-container').removeAttr("title", true);
			$('#select2-process_no-container').removeAttr("title", true);
			$('#select2-check_qty-container').removeAttr("title", true);
			$('#select2-pass_qty-container').removeAttr("title", true);
			$('#po_no').removeAttr('disabled');
			$('#vbeln').removeAttr('disabled');
			$('#process_no').removeAttr('disabled');

			// call function loadInputPOSO
			loadInputPOSO();

			// check line type setting
			// lineTypeStatus();

			// call function loadPro
			loadInputPro();

			return false;
		});

		// function for action change on PO field
		$('#po_no').on('change', function() {
			// get data from element option choose
			const so = $('#po_no option:selected').data('so');

			// display data to element input
			$('#vbeln').val(so); // get value SO
			$('#select2-vbeln-container').text(so); // boostrap4 set element SO
			$('#select2-vbeln-container').attr('title', so);
		});

		// function for action change on PO field
		$('#vbeln').on('change', function() {
			// get data from element option choose
			const po = $('#vbeln option:selected').data('po');

			// display data to element input
			$('#po_no').val(po); // get value PO
			$('#select2-po_no-container').text(po); // boostrap4 set element SO
			$('#select2-po_no-container').attr('title', po);
		});

		// function for action change on Process
		$('#process_no').on('change', function() {
			// select default option
			$('#check_qty').val("");
			$('#select2-check_qty-container').text("-- Option --");
			$('#pass_qty').val("");
			$('#select2-pass_qty-container').text("-- Option --");

			$('#defect_label').html("");
			$('#defect_field').html("");
		});

		// function for check pass QTY not more than check QTY
		$('#pass_qty').on('change', function() {
			const check_qty = $('#check_qty option:selected').val();
			const pass_qty = $('#pass_qty option:selected').val();

			if ($('#process_no').val() == null || $('#process_no').val() == "") {
				errorAlert();
				$('#pass_qty').val("");
				$('#select2-pass_qty-container').text("-- Option --");
			}

			if (parseInt(pass_qty) > parseInt(check_qty)) {
				// select default option
				$('#pass_qty').val("");
				$('#select2-pass_qty-container').text("-- Option --");
			}

			loadInputDefRes();
		});

		// function set default when select check QTY
		$('#check_qty').on('change', function() {
			$('#pass_qty').val("");
			$('#select2-pass_qty-container').text("-- Option --");
			$('#defect_label').html("");
			$('#defect_field').html("");

			if ($('#process_no').val() == null || $('#process_no').val() == "") {
				errorAlert();
				$('#check_qty').val("");
				$('#select2-check_qty-container').text("-- Option --");
			}
		});

		// function reset modal
		$('#reset').on('click', function() {
			//set default
			$('#sec_no').val("");
			$('#po_no').val("");
			$('#vbeln').val("");
			$('#process_no').val("");
			$('#check_qty').val("");
			$('#pass_qty').val("");

			$('#select2-sec_no-container').text("-- Section/Line --");
			$('#select2-po_no-container').text("-- PO --");
			$('#select2-vbeln-container').text("-- SO --");
			$('#select2-process_no-container').text("-- Option --");
			$('#select2-check_qty-container').text("-- Option --");
			$('#select2-pass_qty-container').text("-- Option --");

			$('#select2-sec_no-container').removeAttr("title", true);
			$('#select2-po_no-container').removeAttr("title", true);
			$('#select2-vbeln-container').removeAttr("title", true);
			$('#select2-process_no-container').removeAttr("title", true);
			$('#select2-check_qty-container').removeAttr("title", true);
			$('#select2-pass_qty-container').removeAttr("title", true);

			$('#po_no').attr('disabled', true);
			$('#vbeln').attr('disabled', true);
			$('#process_no').attr('disabled', true);

			$('#defect_label').html("");
			$('#defect_field').html("");

		});

		// function add new collection list
		$('#form-input-collection').submit('click', function() {
			if (!validationInputDef()) {
				submitAlert();
			} else {
				// master data field input
				var sec_no = $('#sec_no').val();
				var line_type = $('#line_type').val();
				var po_no = $('#po_no').val();
				var vbeln = $('#vbeln').val();
				var process_no = $('#process_no').val();
				var check_qty = $('#check_qty').val();
				var pass_qty = $('#pass_qty').val();

				// detail data field input -- note: using .map() to get data array from input field
				var submit_seq = $('input[name="defect_seq[]"]').map(function() {
					return $(this).val();
				}).get();
				var defect_no = $('input[name="defect_no[]"]').map(function() {
					return $(this).val();
				}).get();
				var detail_def_qty = $('input[name="defect_qty[]"]').map(function() {
					return $(this).val();
				}).get();

				$.ajax({
					url: "<?php echo base_url('users/Collection/add'); ?>",
					type: "POST",
					dataType: "JSON",
					data: {
						sec_no: sec_no,
						line_type: line_type,
						po_no: po_no,
						vbeln: vbeln,
						process_no: process_no,
						check_qty: check_qty,
						pass_qty: pass_qty,
						defect_seq: submit_seq,
						defect_no: defect_no,
						defect_qty: detail_def_qty
					},
					success: function(data) {

						// master data
						$('#sec_no').val("");
						$('#po_no').val("");
						$('#vbeln').val("");
						$('#process_no').val("");
						$('#check_qty').val("");
						$('#pass_qty').val("");
						$('#line_type').val("");

						$('#select2-sec_no-container').text("-- Section/Line --");
						$('#select2-po_no-container').text("-- PO --");
						$('#select2-vbeln-container').text("-- SO --");
						$('#select2-process_no-container').text("-- Option --");
						$('#select2-check_qty-container').text("-- Option --");
						$('#select2-pass_qty-container').text("-- Option --");

						$('#select2-sec_no-container').removeAttr("title", true);
						$('#select2-po_no-container').removeAttr("title", true);
						$('#select2-vbeln-container').removeAttr("title", true);
						$('#select2-process_no-container').removeAttr("title", true);
						$('#select2-check_qty-container').removeAttr("title", true);
						$('#select2-pass_qty-container').removeAttr("title", true);

						$('#po_no').attr('disabled', true);
						$('#vbeln').attr('disabled', true);
						$('#process_no').attr('disabled', true);

						// detail data
						$('#defect_label').html("");
						$('#defect_field').html("");

						$('#modal-input-collection').modal('hide');

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
								title: 'Alert! \n save successfull!'
							});

							loadData();
							loadDetailData();
						}
					}
				});
			}
			return false;
		});

		/*************************************************************

		            .end script modal input collection data 

		************************************************************/


		/*************************************************************

		              script modal edit collection data 

		************************************************************/
		// function edit list process
		$('#list-collection').on('click', '.edit-row', function() {
			$('#modal-edit-collection').modal('show');
			$("#edit_sec_no").val($(this).data('sec_no')).change();
			$("#edit_po_no").val($(this).data('po_no')).change();
			$("#edit_vbeln").val($(this).data('vbeln')).change();

			// set default value for reset form edit (global variable)
			g_esi = $(this).data('submit_id');
			g_esd = $(this).data('submit_date');
			g_esu = $(this).data('submit_user');
			g_epo = $(this).data('po_no');
			g_eso = $(this).data('vbeln');
			g_epn = $(this).data('process_no');
			g_elt = $(this).data('line_type');

			g_edq = $(this).data('defect_qty');
			g_ecq = $(this).data('check_qty');
			g_epq = $(this).data('pass_qty');

			loadEditPOSO();
			loadEditPro();
			filterEditDefRes(g_edq);
		});

		// function for check pass QTY not more than check QTY
		$('#edit_pass_qty').on('change', function() {
			const check_qty = $('#edit_check_qty option:selected').val();
			const pass_qty = $('#edit_pass_qty option:selected').val();

			if ($('#edit_process_no').val() == null || $('#edit_process_no').val() == "") {
				errorAlert();
				$('#edit_pass_qty').val("");
				$('#select2-edit_pass_qty-container').text("-- Option --");
			}

			if (parseInt(pass_qty) > parseInt(check_qty)) {
				// select default option
				$('#edit_pass_qty').val("");
				$('#select2-edit_pass_qty-container').text("-- Option --");
			}

			filterEditDefRes(g_edq);
		});

		// function set default when select check QTY
		$('#edit_check_qty').on('change', function() {
			$('#edit_pass_qty').val("");
			$('#select2-edit_pass_qty-container').text("-- Option --");
			$('#edit_defect_label').html("");
			$('#edit_defect_field').html("");

			if ($('#edit_process_no').val() == null || $('#edit_process_no').val() == "") {
				errorAlert();
				$('#edit_check_qty').val("");
				$('#select2-edit_check_qty-container').text("-- Option --");
			}
		});

		// function reset modal
		$('#edit_reset').on('click', function() {
			//set default
			$('#edit_check_qty').val(g_ecq);
			$('#edit_pass_qty').val(g_epq);

			$('#select2-edit_check_qty-container').text(g_ecq);
			$('#select2-edit_pass_qty-container').text(g_epq);

			$('#select2-edit_check_qty-container').removeAttr("title", true);
			$('#select2-edit_pass_qty-container').removeAttr("title", true);

			filterEditDefRes(g_edq);
		});

		// function add new collection list
		$('#form-edit-collection').submit('click', function() {
			if (!validationEditDef()) {
				submitAlert();
			} else {
				// master data field input
				var submit_id = g_esi;
				var submit_date = g_esd;
				var submit_user = g_esu;
				var sec_no = $('#edit_sec_no').val();
				var line_type = $('#edit_line_type').val();
				var po_no = $('#edit_po_no').val();
				var vbeln = $('#edit_vbeln').val();
				var process_no = $('#edit_process_no').val();
				var check_qty = $('#edit_check_qty').val();
				var pass_qty = $('#edit_pass_qty').val();

				// detail data field input -- note: using .map() to get data array from input field
				var submit_seq = $('input[name="edit_defect_seq[]"]').map(function() {
					return $(this).val();
				}).get();
				var defect_no = $('input[name="edit_defect_no[]"]').map(function() {
					return $(this).val();
				}).get();
				var detail_def_qty = $('input[name="edit_defect_qty[]"]').map(function() {
					return $(this).val();
				}).get();

				$.ajax({
					url: "<?php echo base_url('users/Collection/edit'); ?>",
					type: "POST",
					dataType: "JSON",
					data: {
						submit_id: submit_id,
						submit_date: submit_date,
						submit_user: submit_user,
						sec_no: sec_no,
						line_type: line_type,
						po_no: po_no,
						vbeln: vbeln,
						process_no: process_no,
						check_qty: check_qty,
						pass_qty: pass_qty,
						defect_seq: submit_seq,
						defect_no: defect_no,
						defect_qty: detail_def_qty
					},
					success: function(data) {

						// master data
						$('#edit_sec_no').val("");
						$('#edit_po_no').val("");
						$('#edit_vbeln').val("");
						$('#edit_process_no').val("");
						$('#edit_check_qty').val("");
						$('#edit_pass_qty').val("");
						$('#edit_line_type').val("");

						$('#select2-edit_sec_no-container').text("-- Section/Line --");
						$('#select2-edit_po_no-container').text("-- PO --");
						$('#select2-edit_vbeln-container').text("-- SO --");
						$('#select2-edit_process_no-container').text("-- Option --");
						$('#select2-edit_check_qty-container').text("-- Option --");
						$('#select2-edit_pass_qty-container').text("-- Option --");

						$('#select2-edit_sec_no-container').removeAttr("title", true);
						$('#select2-edit_po_no-container').removeAttr("title", true);
						$('#select2-edit_vbeln-container').removeAttr("title", true);
						$('#select2-edit_process_no-container').removeAttr("title", true);
						$('#select2-edit_check_qty-container').removeAttr("title", true);
						$('#select2-edit_pass_qty-container').removeAttr("title", true);

						$('#edit_po_no').attr('disabled', true);
						$('#edit_vbeln').attr('disabled', true);
						$('#edit_process_no').attr('disabled', true);

						// detail data
						$('#edit_defect_label').html("");
						$('#edit_defect_field').html("");

						$('#modal-edit-collection').modal('hide');

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
								title: 'Alert! \n update successfull!'
							});

							loadData();
							loadDetailData();
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
			}
			return false;
		});

		/*************************************************************

		            .end script edit input collection data 

		************************************************************/


		/*************************************************************

		              script modal delete collection data 

		************************************************************/
		// function delete list collection
		$('#list-collection').on('click', '.delete-row', function() {
			// set default value submit_id for delete data collection (global variable)
			var submit_id = $(this).data('submit_id');
			$('#modal-delete-collection').modal('show');
			$('#id-collection').val(submit_id);
		});

		// delete emp record
		$('#form-delete-collection').on('submit', function() {
			// declare local variable
			var submit_id = $('#id-collection').val();

			$.ajax({
				url: "<?php echo base_url('users/Collection/delete/'); ?>" + submit_id,
				type: "POST",
				dataType: 'JSON',
				data: {
					submit_id: submit_id
				},
				success: function(data) {
					// reset id-collection filed value
					$("#" + submit_id).remove();
					$('#id-collection').val("");

					$('#modal-delete-collection').modal('hide');

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
						loadDetailData();
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
							title: 'Alert! \n delete failed!'
						});
					}
				}
			});
			return false;
		});

		/*************************************************************

		              script modal delete collection data 

		************************************************************/

		// function load data on datatable plugin
		function loadData() {
			// declare variable
			var startdate = $('#startdate_query').val();
			var enddate = $('#enddate_query').val();
			var sec_no_query = $('#sec_no_query').val();

			$.ajax({
				url: "<?php echo base_url('users/Collection/getCollect'); ?>",
				method: "POST",
				data: {
					sec_no_query: sec_no_query,
					startdate: startdate,
					enddate: enddate
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {

					var htmlData = '';
					var no = 1;
					var i;
					if (data.length > 0) {
						for (i = 0; i < data.length; i++) {
							// action disabled when submit_date <> current date
							if (data[i].submit_date.substr(0, 8) != new Date().toISOString().slice(0, 10).replace(/-/g, '')) {
								action = 'disabled';
							} else {
								action = null;
							}

							htmlData += '<tr>' +
								'<td>' + no++ + '</td>' +
								'<td>' +
								'<a href="javascript:void(0);" class="btn btn-sm p-0 ' + action + ' edit-row"' +
								'data-submit_id="' + data[i].submit_id + '"' +
								'data-submit_date="' + data[i].submit_date + '"' +
								'data-submit_user="' + data[i].submit_user + '"' +
								'data-sec_no="' + data[i].sec_no + '"' +
								'data-line_type="' + data[i].line_type + '"' +
								'data-po_no="' + data[i].po_no + '"' +
								'data-vbeln="' + data[i].vbeln + '"' +
								'data-process_no="' + data[i].process_no + '"' +
								'data-check_qty="' + data[i].check_qty + '"' +
								'data-pass_qty="' + data[i].pass_qty + '"' +
								'data-defect_qty="' + data[i].defect_qty + '"' +
								'data-pass_rate="' + data[i].pass_rate + '">' +
								'<i class="fas fa-edit"></i></a>' +
								' | <a href="javascript:void(0);" class="btn btn-sm p-0 ' + action + ' delete-row" data-submit_id="' + data[i].submit_id + '"><i class="fas fa-trash"></i></a>' +
								'</td>' +
								'<td>' + data[i].sec_no + '</td>' +
								'<td>' + data[i].line_type + '</td>' +
								'<td>' + data[i].po_no + '</td>' +
								'<td>' + data[i].vbeln + '</td>' +
								'<td>' + data[i].process_no + '</td>' +
								'<td>' + data[i].check_qty + '</td>' +
								'<td>' + data[i].pass_qty + '</td>' +
								'<td>' + data[i].defect_qty + '</td>' +
								'<td>' + data[i].pass_rate + '</td>' +
								'<td>' + data[i].submit_id + '</td>' +
								'<td>' + data[i].submit_date + '</td>' +
								'<td>' + data[i].submit_user + '</td>' +
								'</tr>';
						}

						$('#example2').DataTable().destroy();
						$('#list-collection').html(htmlData);
						$('#query').text('Query');

						// $('#add').removeAttr('disabled');

						// set value object of g_table
						g_tablem = $('#example2').DataTable({
							"paging": true,
							"lengthChange": true,
							"searching": false,
							"ordering": true,
							"info": true,
							"autoWidth": true,
							"responsive": false,
							"scrollY": 150,
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

						// add button wrapper in datatable
						g_tablem.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

						// function on row data click get data row
						$('#example2 tbody').on('click', 'tr', function() {
							// get row data on the table
							var data = g_tablem.row(this).data();
							loadDetailData(data[11]);

							// set background color row selected
							// if ($(this).hasClass('selected')) {
							//   $(this).removeClass('selected');
							// } else {
							g_tablem.$('tr.selected').removeClass('selected');
							$(this).addClass('selected');
							// }
						});

					} else {
						$('#example2').DataTable().destroy();
						$('#list-collection').html(htmlData);
						$('#query').text('Query');

						// $('#add').removeAttr('disabled');

						g_tablem = $('#example2').DataTable({
							"paging": true,
							"lengthChange": true,
							"searching": false,
							"ordering": true,
							"info": true,
							"autoWidth": true,
							"responsive": false,
							"scrollY": 150,
							"scrollX": true,
							// "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
						});

						// add button wrapper in datatable
						g_tablem.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

					}
				}
			});
		}

		// function load detail data on datatable plugin
		function loadDetailData(submit_id) {
			$.ajax({
				url: "<?php echo base_url('users/Collection/getDetailCollect'); ?>",
				method: "POST",
				data: {
					submit_id: submit_id
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var htmlData = '';
					var no = 1;
					var i;
					if (data.length > 0) {
						for (i = 0; i < data.length; i++) {
							htmlData += '<tr>' +
								'<td>' + no++ + '</td>' +
								'<td>' + data[i].submit_seq + '</td>' +
								'<td>' + data[i].defect_no + '</td>' +
								'<td>' + data[i].defect_name + '</td>' +
								'<td>' + data[i].defect_qty + '</td>' +
								'<td>' + data[i].defect_rate + '</td>' +
								'</tr>';
						}

						$('#detail-example2').DataTable().destroy();
						$('#list-detail-collection').html(htmlData);

						g_tabled = $('#detail-example2').DataTable({
							"paging": true,
							"lengthChange": true,
							"searching": false,
							"ordering": true,
							"info": true,
							"autoWidth": true,
							"responsive": false,
							"scrollY": 150,
							"scrollX": true,
							// "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
						});

						// add button wrapper in datatable
						g_tabled.buttons().container().appendTo('#detail-example2_wrapper .col-md-6:eq(0)');

					} else {
						$('#detail-example2').DataTable().destroy();
						$('#list-detail-collection').html(htmlData);

						g_tabled = $('#detail-example2').DataTable({
							"paging": true,
							"lengthChange": true,
							"searching": false,
							"ordering": true,
							"info": true,
							"autoWidth": true,
							"responsive": false,
							"scrollY": 150,
							"scrollX": true,
							// "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
						});

						// add button wrapper in datatable
						g_tabled.buttons().container().appendTo('#detail-example2_wrapper .col-md-6:eq(0)');

					}
				}
			});
		}

		// function get PO/SO by sec/line (filterd)
		function loadInputPOSO() {
			var sec_no = $('#sec_no').val();

			$.ajax({
				url: "<?php echo base_url('users/Collection/getPOSO'); ?>",
				method: "POST",
				data: {
					sec_no: sec_no
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var htmlPO = '';
					var htmlSO = '';
					var i;
					var x;

					htmlPO += '<option value="" selected disabled>-- PO --</option>';
					htmlSO += '<option value="" selected disabled>-- SO --</option>';

					for (i = 0; i < data.length; i++) {
						htmlPO += '<option value=' + data[i].po_no + ' data-so=' + data[i].vbeln + '>' + data[i].po_no + '</option>';
					}
					for (x = 0; x < data.length; x++) {
						htmlSO += '<option value=' + data[x].vbeln + ' data-po=' + data[x].po_no + ' >' + data[x].vbeln + '</option>';
					}

					$('#po_no').html(htmlPO);
					$('#vbeln').html(htmlSO);
					$('#po_no').val("");
					$('#vbeln').val("");
				}
			});
		}

		// function get PO/SO by sec/line (filterd)
		function loadEditPOSO() {
			var sec_no = $('#edit_sec_no').val();

			$.ajax({
				url: "<?php echo base_url('users/Collection/getPOSO'); ?>",
				method: "POST",
				data: {
					sec_no: sec_no
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var htmlPO = '';
					var htmlSO = '';
					var i;
					var x;

					htmlPO += '<option value="" selected disabled>-- PO --</option>';
					htmlSO += '<option value="" selected disabled>-- SO --</option>';

					for (i = 0; i < data.length; i++) {
						htmlPO += '<option value=' + data[i].po_no + ' data-so=' + data[i].vbeln + '>' + data[i].po_no + '</option>';
					}
					for (x = 0; x < data.length; x++) {
						htmlSO += '<option value=' + data[x].vbeln + ' data-po=' + data[x].po_no + ' >' + data[x].vbeln + '</option>';
					}

					$('#edit_po_no').html(htmlPO);
					$('#edit_vbeln').html(htmlSO);
					$('#edit_po_no').val(g_epo);
					$('#edit_vbeln').val(g_eso);
				}
			});
		}

		// function get process by sec/line (filtered)
		function loadInputPro() {
			var sec_no = $('#sec_no').val();

			$.ajax({
				url: "<?php echo base_url('users/Collection/getPro'); ?>",
				method: "POST",
				data: {
					sec_no: sec_no
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var htmlPro = '';
					var lineType = '';
					var i;

					htmlPro += '<option value="" selected disabled>-- Option --</option>';
					if (data.length !== 0) {
						for (i = 0; i < data.length; i++) {
							htmlPro += '<option value=' + data[i].process_no + '>' + data[i].process_no + ' | ' + data[i].process_name + '</option>';
							lineType = data[i].line_type;
						}

						$('#process_no').html(htmlPro);
						$('#process_no').val("");
						$('#line_type').val(lineType);

					} else if (sec_no !== '') {
						$('#po_no').val('');
						$('#vbeln').val('');
						$('#process_no').val('');

						$('#po_no').attr('disabled', true);
						$('#vbeln').attr('disabled', true);
						$('#process_no').attr('disabled', true);

						lineStatusAlert();

					} else {
						$('#po_no').val('');
						$('#vbeln').val('');
						$('#process_no').val('');

						$('#po_no').attr('disabled', true);
						$('#vbeln').attr('disabled', true);
						$('#process_no').attr('disabled', true);
					}
				}
			});
		}

		// function get process by sec/line (filtered) for modal edit collection
		function loadEditPro() {
			var sec_no = $('#edit_sec_no').val();

			$.ajax({
				url: "<?php echo base_url('users/Collection/getPro'); ?>",
				method: "POST",
				data: {
					sec_no: sec_no
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {

					var htmlPro = '';
					var lineType = '';
					var i;

					htmlPro += '<option value="" selected disabled>-- Option --</option>';
					for (i = 0; i < data.length; i++) {
						htmlPro += '<option value=' + data[i].process_no + '>' + data[i].process_no + ' | ' + data[i].process_name + '</option>';
						lineType = data[i].line_type;
					}

					$('#edit_process_no').html(htmlPro);

					// set value of form edit collection
					$('#edit_process_no').val(g_epn).change();
					$('#edit_check_qty').val(g_ecq).change();
					$('#edit_pass_qty').val(g_epq).change();
					$('#edit_line_type').val(lineType);
				}
			});
		}

		// get data defect reason input
		function loadInputDefRes() {
			var line_type = $('#line_type').val();
			var process_no = $('#process_no').val();
			var check_qty = $('#check_qty option:selected').val();
			var pass_qty = $('#pass_qty option:selected').val();

			$.ajax({
				url: "<?php echo base_url('users/Collection/getDefRes'); ?>",
				method: "POST",
				data: {
					line_type: line_type,
					process_no: process_no
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {
					var htmlRes = '';
					var htmlLabel = '';
					var n = 1;
					var i;

					if (parseInt(pass_qty) < parseInt(check_qty)) {
						htmlLabel += '<div class="row">' +
							'<div class="col-md-4">' +
							'<label for="defect_seq" class="col-form-label"><span class="text-danger">*</span>Defect Sequence :</label>' +
							'</div>' +
							'<div class="col-md-4">' +
							'<label for="defect_seq" class="col-form-label"><span class="text-danger">*</span>Defect Reason :</label>' +
							'</div>' +
							'<div class="col-md-4">' +
							'<label for="defect_seq" class="col-form-label"><span class="text-danger">*</span>Defect QTY :</label>' +
							'</div>' +
							'</div>';

						for (i = 0; i < data.length; i++) {
							htmlRes += '<div class="row">' +
								'<div class="col-md-4">' +
								'<div class="form-group">' +
								'<input type="text" class="form-control" id="defect_seq' + data[i].defect_no + '" name="defect_seq[]" value="00' + n++ + '" readonly required>' +
								'</div>' +
								'</div>' +
								'<div class="col-md-4">' +
								'<div class="form-group">' +
								'<input type="hidden" class="form-control" id="defect_no' + data[i].defect_no + '" name="defect_no[]" value="' + data[i].defect_no + '" readonly required>' +
								'<input type="text" class="form-control" id="defect_name' + data[i].defect_no + '" name="defect_name[]" value="' + data[i].defect_name + '" readonly required>' +
								'</div>' +
								'</div>' +
								'<div class="col-md-4">' +
								'<div class="form-group">' +
								'<input type="text" class="form-control" id="defect_qty' + data[i].defect_no + '" name="defect_qty[]" maxlength="1" value="0"' +
								'oninput="this.value = this.value.replace(/[^0-9.]/g, ``).replace(/(\..*?)\..*/g, `$1`);" required>' +
								'</div>' +
								'</div>' +
								'</div>';
						}
					}
					$('#defect_field').html(htmlRes);
					$('#defect_label').html(htmlLabel);
				}
			});
		}

		/*** validation submit form ***/
		function validationInputDef() {
			var check_qty = $('#check_qty').val();
			var pass_qty = $('#pass_qty').val();
			var defect_qty = check_qty - pass_qty;
			var array_defect_qty = [];

			$('input[name="defect_qty[]"]').each(function() {
				array_defect_qty.push(parseInt($(this).val()));
			});

			if (array_defect_qty.length > 0) {
				total_defect = array_defect_qty.reduce(getSum);
			} else {
				total_defect = 0;
			}

			if (defect_qty == total_defect) {
				return true;
			} else {
				return false;
			}

		}

		function getSum(total, num) {
			return total + num;
		}
		/*** .end validation submit form ***/

		/*** validation submit form edit collection ***/
		function validationEditDef() {
			var check_qty = $('#edit_check_qty').val();
			var pass_qty = $('#edit_pass_qty').val();
			var defect_qty = check_qty - pass_qty;
			var array_defect_qty = [];

			$('input[name="edit_defect_qty[]"]').each(function() {
				array_defect_qty.push(parseInt($(this).val()));
			});

			if (array_defect_qty.length > 0) {
				total_defect = array_defect_qty.reduce(getSum);
			} else {
				total_defect = 0;
			}

			if (defect_qty == total_defect) {
				return true;
			} else {
				return false;
			}

		}

		function getSum(total, num) {
			return total + num;
		}
		/*** .end validation submit form edit collection ***/

		// *** for edit collection modal *** //
		// filter get detail defect reason data
		function filterEditDefRes(defect_qty) {

			if (defect_qty == 0 || defect_qty < 0) {
				loadNewDefRes();
			} else {
				loadEditDefRes();
			}
		}

		// get data edit defect reason input
		function loadEditDefRes() {
			var submit_id = g_esi;
			var check_qty = $('#edit_check_qty option:selected').val();
			var pass_qty = $('#edit_pass_qty option:selected').val();

			$.ajax({
				url: "<?php echo base_url('users/Collection/getDetailCollect'); ?>",
				method: "POST",
				data: {
					submit_id: submit_id
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {

					var htmlRes = '';
					var htmlLabel = '';
					var n = 1;
					var i;

					if (parseInt(pass_qty) < parseInt(check_qty)) {
						htmlLabel += '<div class="row">' +
							'<div class="col-md-4">' +
							'<label for="edit_defect_seq" class="col-form-label"><span class="text-danger">*</span>Defect Sequence :</label>' +
							'</div>' +
							'<div class="col-md-4">' +
							'<label for="edit_defect_seq" class="col-form-label"><span class="text-danger">*</span>Defect Reason :</label>' +
							'</div>' +
							'<div class="col-md-4">' +
							'<label for="edit_defect_seq" class="col-form-label"><span class="text-danger">*</span>Defect QTY :</label>' +
							'</div>' +
							'</div>';

						for (i = 0; i < data.length; i++) {
							htmlRes += '<div class="row">' +
								'<div class="col-md-4">' +
								'<div class="form-group">' +
								'<input type="text" class="form-control" id="edit_defect_seq' + data[i].defect_no + '" name="edit_defect_seq[]" value="00' + n++ + '" readonly required>' +
								'</div>' +
								'</div>' +
								'<div class="col-md-4">' +
								'<div class="form-group">' +
								'<input type="hidden" class="form-control" id="edit_defect_no' + data[i].defect_no + '" name="edit_defect_no[]" value="' + data[i].defect_no + '" readonly required>' +
								'<input type="text" class="form-control" id="edit_defect_name' + data[i].defect_no + '" name="edit_defect_name[]" value="' + data[i].defect_name + '" readonly required>' +
								'</div>' +
								'</div>' +
								'<div class="col-md-4">' +
								'<div class="form-group">' +
								'<input type="text" class="form-control" id="edit_defect_qty' + data[i].defect_no + '" name="edit_defect_qty[]" maxlength="1" value="' + data[i].defect_qty + '"' +
								'oninput="this.value = this.value.replace(/[^0-9.]/g, ``).replace(/(\..*?)\..*/g, `$1`);" required>' +
								'</div>' +
								'</div>' +
								'</div>';
						}
					}
					$('#edit_defect_field').html(htmlRes);
					$('#edit_defect_label').html(htmlLabel);
				}
			});
		}

		// get data defect reason input
		function loadNewDefRes() {
			var line_type = $('#edit_line_type').val();
			var process_no = $('#edit_process_no').val();
			var check_qty = $('#edit_check_qty option:selected').val();
			var pass_qty = $('#edit_pass_qty option:selected').val();

			$.ajax({
				url: "<?php echo base_url('users/Collection/getDefRes'); ?>",
				method: "POST",
				data: {
					line_type: line_type,
					process_no: process_no
				},
				async: true,
				dataType: 'JSON',
				success: function(data) {

					var htmlRes = '';
					var htmlLabel = '';
					var n = 1;
					var i;

					if (parseInt(pass_qty) < parseInt(check_qty)) {
						htmlLabel += '<div class="row">' +
							'<div class="col-md-4">' +
							'<label for="edit_defect_seq" class="col-form-label"><span class="text-danger">*</span>Defect Sequence :</label>' +
							'</div>' +
							'<div class="col-md-4">' +
							'<label for="edit_defect_seq" class="col-form-label"><span class="text-danger">*</span>Defect Reason :</label>' +
							'</div>' +
							'<div class="col-md-4">' +
							'<label for="edit_defect_seq" class="col-form-label"><span class="text-danger">*</span>Defect QTY :</label>' +
							'</div>' +
							'</div>';

						for (i = 0; i < data.length; i++) {
							htmlRes += '<div class="row">' +
								'<div class="col-md-4">' +
								'<div class="form-group">' +
								'<input type="text" class="form-control" id="edit_defect_seq' + data[i].defect_no + '" name="edit_defect_seq[]" value="00' + n++ + '" readonly required>' +
								'</div>' +
								'</div>' +
								'<div class="col-md-4">' +
								'<div class="form-group">' +
								'<input type="hidden" class="form-control" id="edit_defect_no' + data[i].defect_no + '" name="edit_defect_no[]" value="' + data[i].defect_no + '" readonly required>' +
								'<input type="text" class="form-control" id="edit_defect_name' + data[i].defect_no + '" name="edit_defect_name[]" value="' + data[i].defect_name + '" readonly required>' +
								'</div>' +
								'</div>' +
								'<div class="col-md-4">' +
								'<div class="form-group">' +
								'<input type="text" class="form-control" id="edit_defect_qty' + data[i].defect_no + '" name="edit_defect_qty[]" maxlength="1" value="0"' +
								'oninput="this.value = this.value.replace(/[^0-9.]/g, ``).replace(/(\..*?)\..*/g, `$1`);" required>' +
								'</div>' +
								'</div>' +
								'</div>';
						}
					}
					$('#edit_defect_field').html(htmlRes);
					$('#edit_defect_label').html(htmlLabel);
				}
			});
		}
		// *** end of edit collection modal *** //

		// SweetAlert warning message
		function lineStatusAlert() {
			var sec_no = $('#sec_no').val();
			var Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000
			});
			Toast.fire({
				icon: 'warning',
				title: 'Alert! \n Section ' + sec_no + ' not yet setting Line Type in Basic Data - Section/Line Data!'
			});
		}

		function errorAlert() {
			var Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000
			});
			Toast.fire({
				icon: 'warning',
				title: 'Alert! \n Please select Process first!'
			});
		}

		// SweetAlert submit error message
		function submitAlert() {
			var Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000
			});
			Toast.fire({
				icon: 'error',
				title: 'Alert! \n Defect QTY <> Total Defect QTY!'
			});
		}

		// note: to get value element html from ajax response use $(document).on('event', 'id element', function(){ action method }); to read response as DOM 
	</script>


</body>

</html>
