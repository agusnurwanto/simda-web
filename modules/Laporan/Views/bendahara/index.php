<div class="container-fluid mt-3 mb-3">
	<?php
		$left_item					= null;
		$right_item					= null;
		foreach($results as $key => $val)
		{
			/* check if item is applicable for current user group id */
			if(isset($val->user_group) && is_array($val->user_group) && sizeof($val->user_group) > 0 && !in_array(get_userdata('group_id'), $val->user_group)) continue;
			
			$item					= '
				<div class="card ' . (isset($val->color) ? $val->color : 'bg-secondary') . ' mb-3">
					<a href="#collapse_' . $key . '" class="card-header text-' . (isset($val->color) && !in_array($val->color, array('bg-light', 'bg-white')) ? 'light' : 'secondary') . '" data-toggle="collapse">
						<div class="row">
							<div class="col-3 col-sm-2">
								<i class="mdi ' . (isset($val->icon) ? $val->icon : $meta->icon) . ' mdi-3x"></i>
							</div>
							<div class="col col-sm-10">
								<h5 class="mb-0 text-truncate">
									' . $val->title . '
								</h5>
								<p class="mb-0 text-truncate">
									' . $val->description . '
								</p>
							</div>
						</div>
					</a>
					<div id="collapse_' . $key . '" class="collapse" data-parent="#accordion">
						<div class="card-body bg-white">
							<form action="' . go_to($val->controller) . '" method="GET" class="--xhr-form" target="_blank" data-autosubmit="0">
								<div class="form-group alert alert-info">
									' . $val->description . '
								</div>
								
								' . (isset($val->sub_unit) ? $val->sub_unit : null)/* dependent dropdown */ . '
								' . (isset($val->perubahan) ? $val->perubahan : null)/* dependent dropdown */ . '
								
								<div class="btn-group d-flex">
									<button type="submit" name="method" class="btn btn-info btn-sm" value="preview">
										<i class="mdi mdi-magnify"></i>
										' . phrase('preview') . '
									</button>
									<button type="submit" name="method" class="btn btn-warning btn-sm"  value="embed">
										<i class="mdi mdi-printer"></i>
										' . phrase('print') . '
									</button>
									<button type="submit" name="method" class="btn btn-danger btn-sm"  value="download">
										<i class="mdi mdi-cloud-download"></i>
										' . phrase('download') . '
									</button>
									<button type="submit" name="method" class="btn btn-success btn-sm"  value="export">
										<i class="mdi mdi-file-excel"></i>
										' . phrase('export') . '
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			';
			if('right' == $val->placement)
			{
				$right_item			.= $item;
			}
			else
			{
				$left_item			.= $item;
			}
		}
	?>
	<div class="row" id="accordion">
		<div class="col-md-5 offset-md-1">
			<?php echo $left_item; ?>
		</div>
		<div class="col-md-5">
			<?php echo $right_item; ?>
		</div>
	</div>
</div>