<!-- Flashdata - Default box -->
<div class="alert alert-success alert-dismissible" id="flashAlert">
    <button type="button" class="close" id="btn-close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Alert!</h5>
    <!-- Success alert preview. This alert is dismissable. -->
    <?php echo $this->session->flashdata('success'); $this->session->sess_destroy(); ?>
</div>

