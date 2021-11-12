<div class="bg-success gradient">
	<div class="container-fluid pt-5 pb-5">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<form action="<?php echo base_url('search'); ?>" method="GET" class="--xhr-form">
					<div class="input-group input-group-lg">
						<input type="text" name="q" class="form-control" placeholder="Pencarian Data" role="autocomplete" value="<?php echo htmlspecialchars(service('request')->getGet('q')); ?>" autocomplete="off" />
						<div class="input-group-append">
							<button type="submit" class="btn btn-success">
								<i class="mdi mdi-magnify"></i>
								Cari
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="jumbotron jumbotron-fluid bg-transparent">
	<div class="container-fluid">
		<div class="row">
			<div class="col-3 col-sm-2 col-md-1 offset-md-1">
				<i class="<?php echo $meta->icon; ?> mdi-4x text-muted"></i>
			</div>
			<div class="col-9 col-sm-10 col-md-9">
				<h3 class="mb-0<?php echo (!$meta->description ? ' mt-3' : null); ?>">
					<?php echo $meta->title; ?>
				</h3>
				<p class="lead d-none d-sm-block">
					<?php echo truncate($meta->description, 256); ?>
				</p>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid pt-3 pb-3">
	<div class="row">
		<div class="col-md-8 offset-md-2">
			<?php
				if($results)
				{
					$output							= null;
					foreach($results as $key => $val)
					{
						$output						.= '
							<div class="card mb-3">
								<div class="card-body">
									<div class="card-title mb-0">
										<h5 class="mb-0">
											<a href="' . base_url('sekolah/' . $val->id) . '" class="--modal">
												' . $val->sekolah . '
											</a>
										</h5>
									</div>
									<p class="text-muted">
										' . $val->alamat . '
									</p>
									<div class="row">
										<label class="text-muted col-3">
											Status
										</label>
										<label class="col-9">
											' . (1 == $val->status ? '<span class="badge badge-success">Negeri</span>' : '<span class="badge badge-warning">Swasta</span>') . '
										</label>
									</div>
									<div class="row">
										<label class="text-muted col-3">
											Akreditasi
										</label>
										<label class="col-9">
											' . number_format($val->akreditasi, 2) . '%
										</label>
									</div>
									<p class="mb-0">
										<a href="' . base_url('sekolah/' . $val->id) . '" class="btn btn-outline-secondary btn-sm --modal">
											<i class="mdi mdi-magnify"></i>
											' . phrase('detail') . '
										</a>
									</p>
								</div>
							</div>
						';
					}
					
					echo $output;
					
					echo $this->template->pagination($pagination);
				}
			?>
		</div>
	</div>
</div>