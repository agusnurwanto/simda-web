<nav aria-label="breadcrumb" id="breadcrumb-wrapper">
	<ol class="breadcrumb rounded-0 mb-0">
		<?php
			if(isset($breadcrumb))
			{
				foreach($breadcrumb as $key => $val)
				{
					echo '
						<li class="breadcrumb-item">
							<a href="' . $val->url . '" class="--xhr">
								' . ($val->icon ? '<i class="' . $val->icon . '"></i>' : null) . '
								' . $val->label . '
							</a>
						</li>
					';
				}
			}
			else
			{
				echo '
					<li class="breadcrumb-item">
						<a href="' . base_url('dashboard') . '" class="--xhr">
							<i class="mdi mdi-home"></i>
							' . phrase('dashboard') . '
						</a>
					</li>
				';
			}
		?>
	</ol>
</nav>