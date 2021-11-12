<div class="container-fluid pt-3 pb-3" id="accordion">
	<div class="row">
		<div class="col-md-5">
			<div class="card bg-success">
				<a href="#collapse_sync_permintaan" class="card-header text-light" data-toggle="collapse">
					<div class="row">
						<div class="col-3 col-sm-2">
							<i class="mdi mdi-hand mdi-3x"></i>
						</div>
						<div class="col col-sm-10">
							<h5 class="mb-0 text-truncate">
								Sinkronisasi Penerimaan
							</h5>
							<p class="mb-0 text-truncate">
								Blah blah blah
							</p>
						</div>
					</div>
				</a>
				<div id="collapse_sync_permintaan" class="collapse" data-parent="#accordion">
					<div class="card-body bg-white">
						<div class="alert alert-success">
							Anda yakin akan melalukan sinkronisasi data penerimaan? Tindakan ini akan menimpa data sebelumnya
						</div>
						<a href="<?php echo base_url('master/sinkronisasi/penerimaan'); ?>" class="btn btn-success btn-block --xhr show-progress">
							<i class="mdi mdi-check"></i>
							Lanjutkan
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>