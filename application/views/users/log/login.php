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

<body class="hold-transition login-page" onload="<?php if ($this->session->flashdata('warning') != null) {
																										echo 'loadAlert()';
																									} ?>">
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="#" class="h1"><b>Traffic </b>Light</a>
			</div>
			<div class="card-body card-primary card-outline card-outline-tabs">
				<!-- navbar tabs -->
				<div class="card-header border-bottom-0">
					<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Guest</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Login</a>
						</li>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content" id="custom-tabs-four-tabContent">
						<div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
							<form action="<?php echo base_url('users/Log/directLogin'); ?>" method="POST">
								<div class="input-group mb-3">
									<select class="form-control select2bs4" id="guest_fact_no" name="guest_fact_no" required>
										<option value="" selected disabled>-- Factory --</option>
										<option value="0228">PCI adidas</option>
										<option value="B0CV">PGD adidas</option>
										<option value="B0EM">PGS adidas</option>
										<?php foreach ($hse_factory as $factory) : ?>
											<!-- <option value="<?php echo $factory->FACT_NO; ?>"><?php echo $factory->FACT_NAME; ?></option> -->
										<?php endforeach; ?>
									</select>
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-building"></span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12">
										<button type="submit" class="btn btn-primary btn-block float-right">Go To Traffic Light System</button>
									</div>
									<!-- /.col -->
								</div>
							</form>
							<!-- /.social-auth-links -->
						</div>
						<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
							<p class="login-box-msg">Sign in to start your session!</p>
							<form action="<?php echo base_url('users/Log/login'); ?>" method="POST">
								<div class="input-group mb-3">
									<select class="form-control select2bs4" id="fact_no" name="fact_no" required>
										<option value="" selected disabled>-- Factory --</option>
										<option value="0228">PCI adidas</option>
										<option value="B0CV">PGD adidas</option>
										<option value="B0EM">PGS adidas</option>
										<?php foreach ($tra_factory as $factory) : ?>
											<!-- <option value="<?php echo $factory->fact_no; ?>"><?php echo $factory->fact_name; ?></option> -->
										<?php endforeach; ?>
									</select>
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-building"></span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12">
										<button type="submit" class="btn btn-primary btn-block float-right">Login</button>
									</div>
									<!-- /.col -->
								</div>
							</form>
							<!-- /.social-auth-links -->
						</div>
						<!-- /.content B -->
					</div>
					<!-- /.end content tabs -->
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!-- /.login-box -->

		<!-- Javascript -->
		<?php $this->load->view("layouts/_js.php") ?>

		<!-- Page specific script -->
		<script>
			// SweetAlert login failed
			function loadAlert() {
				var Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000
				});
				Toast.fire({
					icon: 'error',
					title: 'Alert! \n <?php echo $this->session->flashdata("warning");
														$this->session->set_flashdata('warning', null); ?>'
				});
			}
		</script>

</body>

</html>
