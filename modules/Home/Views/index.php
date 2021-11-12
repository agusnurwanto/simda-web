<?php
	/**
	 * Latest testimonials
	 */
	$latest_testimonials							= null;

	if(isset($testimonials) && $testimonials)
	{
		$indicators									= null;
		$carousel_items								= null;

		foreach($testimonials as $key => $val)
		{
			$indicators								.= '<li data-target="#testimonials" data-slide-to="' . $key . '" class="' . ($key == 0 ? 'active bg-dark' : 'bg-dark') . '"></li>';
			$carousel_items							.= '
				<div class="carousel-item' . ($key == 0 ? ' active' : '') . '">
					<div class="row">
						<div class="col-md-5 text-center">
							<img src="' . get_image('testimonials', $val->photo, 'thumb') . '" class="img-fluid rounded-circle" />
						</div>
						<div class="col-md-7">
							<div class="text-sm-center text-md-left text-lg-left text-xl-left">
								<h4>
									' . $val->testimonial_title . '
								</h4>
								<p>
									' . truncate($val->testimonial_content, 500) . '
								</p>
								<p class="blockquote-footer">
									<b>' . $val->first_name . ' ' . $val->last_name . '</b>
								</p>
							</div>
						</div>
					</div>
				</div>
			';
		}

		$latest_testimonials						= '
			<div id="testimonials" class="carousel slide mb-3" data-ride="carousel">
				<div class="carousel-inner pb-5">
					' . $carousel_items . '
				</div>
				<ol class="carousel-indicators">
					' . $indicators . '
				</ol>
			</div>
		';
	}

    /**
    * Latest carousels
    */
    if($carousels)
    {
        foreach($carousels as $key => $val)
        {
	        $carousel_content						= json_decode($val->carousel_content);
            $navigation							    = null;
            $carousel_items						    = null;

            foreach($carousel_content as $_key => $_val)
            {
                $navigation						    .= '<li data-target="#carouselExampleIndicators" data-slide-to="' . $_key . '"' . ($_key == 0 ? ' class="active"' : '') . '></li>';
                $carousel_items					    .= '
                    <div class="carousel-item full-height bg-dark gradient d-flex align-items-center' . ($_key == 0 ? ' active' : '') . '" style="background:#333 url(\'' . get_image('carousels', (isset($_val->background) ? $_val->background : 'placeholder.png')) . '\') center center no-repeat;background-size:cover;background-attachment:fixed">
                        <div class="absolute top right bottom left" style="background:rgba(0, 0, 0, .75)"></div>
                        <div class="area">
                            <ul class="circles">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                        </div>
                        <div class="carousel-caption container-fluid" style="position:inherit">
                            <div class="row">
                                ' . ($_val->thumbnail && $_val->thumbnail != 'placeholder.png' ? '
                                <div class="col-lg-4 offset-lg-1 text-center text-lg-left d-none d-md-block">
                                    <div class="pt-5 w-100">
                                        <img src="' . get_image('carousels', $_val->thumbnail) . '" class="img-fluid rounded" />
                                    </div>
                                </div>
                                ' : null) . '
                                <div class="' . ($_val->thumbnail && $_val->thumbnail != 'placeholder.png' ? 'col-lg-6 text-center text-lg-left d-flex align-items-center justify-content-center' : 'col-md-10 offset-md-1 col-lg-8 offset-lg-2 text-center') . '">
                                    <div class="pt-5 w-100">
                                        <h1 class="font-weight-bold mb-3 text-light">
                                            ' . (isset($_val->title) ? $_val->title : phrase('title_was_not_set')) . '
                                        </h1>
                                        <p class="text-light mb-5">
                                            ' . (isset($_val->description) ? truncate($_val->description, 260) : phrase('description_was_not_set')) . '
                                        </p>
                                        ' . (isset($_val->link) && $_val->link ? '
                                        <div class="row">
                                            <div class="col-sm-6 offset-sm-3 col-md-12 offset-md-0">
                                                <a href="' . $_val->link . '" class="btn btn-outline-light btn-lg rounded-pill" data-animation="animated bounceInLeft" style="border-width:2px">
                                                    ' . (isset($_val->label) && $_val->label ? $_val->label : phrase('read_more')) . '
                                                    <i class="mdi mdi-chevron-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                        ' : null) . '
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
            echo '
                <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
                    ' . (sizeof($carousel_content) > 1 ? '
                    <ol class="carousel-indicators">
                        ' . $navigation . '
                    </ol>
                    ' : '') . '
                    <div class="carousel-inner">
                        ' . $carousel_items . '
                    </div>
                    ' . (sizeof($carousel_content) > 1 ? '
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">
                            ' . phrase('previous') . '
                        </span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">
                            ' . phrase('next') . '
                        </span>
                    </a>
                    ' : '') . '
                </div>
            ';
        }
    }
    else
    {
        $image                                      = get_image("blogs", "cover.jpg");
	    echo '
	        <div class="leading pt-5 pb-5 mb-5 bg-light relative" style="background: url('.$image.') center center no-repeat; background-size: cover; position: relative">
	            <div class="clip gradient-top"></div>
                <div class="area">
                    <ul class="circles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
                <div class="container pt-5 pb-5">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <h1 class="text-center text-light">
                                ' . phrase('welcome_to') . ' ' . get_setting('app_name') . '
                            </h1>
                            <p class="lead text-center text-light mb-5">
                                ' . get_setting('app_description') . '
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                            <form action="' .base_url('blogs/search', array('per_page' => null)) .'" method="POST" class="form-horizontal relative --xhr-form">
                                <input type="text" name="q" class="form-control form-control-lg pt-4 pr-4 pb-4 pl-4 border-0" placeholder="'.phrase('search_post').'" />
                                <button type="submit" class="btn btn-lg float-right absolute top right">
                                    <i class="mdi mdi-magnify font-weight-bold"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
	        </div>
	    ';
    }
?>

<div class="">
	<div class="container">
		<?php
			$posts									= null;

			foreach($spotlight as $key => $val)
			{
				$posts								.= '
					<div class="item">
						<div class="card border-0 shadow mr-3 mb-5 ml-3">
							<a href="' . base_url(array('blogs', $val->category_slug, $val->post_slug)) . '" class="--xhr d-block">
								<div class="relative rounded-top" style="background:url(' . get_image('blogs', $val->featured_image, 'thumb') . ') center center no-repeat; background-size: cover; height: 256px">
									<div class="clip gradient-top rounded-top"></div>
									<div class="absolute bottom p-3">
										<h5 class="text-light" data-toggle="tooltip" title="' . $val->post_title . '">
											' . truncate($val->post_title, 80) . '
										</h5>
									</div>
								</div>
							</a>
							<div class="card-body">
								<p class="card-text">
									<a href="' . base_url(array('blogs', $val->category_slug, $val->post_slug)) . '" class="--xhr d-block">
										' . truncate($val->post_excerpt, 100) . '
									</a>
								</p>
								<p class="card-text">
									<i class="mdi mdi-clock-outline"></i> ' . time_ago($val->updated_timestamp) . '
								</p>
							</div>
						</div>
					</div>
				';
			}

			echo '
				<a href="' . base_url('blogs') . '" class="--xhr">
					<h3 class="text-center text-md-left text-primary pt-3 mb-0 text-uppercase">
						' . phrase('spotlight') . '
					</h3>
				</a>
				<p class="text-center text-md-left">
					' . phrase('an_article_spotlight_you_may_want_to_know') . '
				</p>
				<div class="row">
					<div class="owl-carousel owl-theme" data-nav="1" data-md-items="3" data-lg-items="3">
						' . $posts . '
					</div>
				</div>
			';
		?>
	</div>
</div>

<div class="">
	<div class="container">
		<?php
			foreach($articles as $key => $val)
			{
				$posts								= null;

				foreach($val->posts as $_key => $_val)
				{
					$posts							.= '
						<div class="item">
							<div class="card border-0 shadow mr-3 mb-5 ml-3">
								<a href="' . base_url(array('blogs', $val->category_slug, $_val->post_slug)) . '" class="--xhr d-block">
									<div class="relative rounded-top" style="background:url(' . get_image('blogs', $_val->featured_image, 'thumb') . ') center center no-repeat; background-size: cover; height: 256px">
										<div class="clip gradient-top rounded-top"></div>
										<div class="absolute bottom p-3">
											<b class="text-light" data-toggle="tooltip" title="' . $_val->post_title . '">
												' . truncate($_val->post_title, 80) . '
											</b>
										</div>
									</div>
								</a>
								<div class="card-body">
									<p class="card-text">
										<a href="' . base_url(array('blogs', $val->category_slug, $_val->post_slug)) . '" class="--xhr d-block">
											' . truncate($_val->post_excerpt, 100) . '
										</a>
									</p>
									<p class="card-text text-sm">
										<i class="mdi mdi-clock-outline"></i> ' . time_ago($_val->updated_timestamp) . '
									</p>
								</div>
							</div>
						</div>
					';
				}

				echo '
					<a href="' . base_url(array('blogs', $val->category_slug)) . '" class="--xhr">
						<h3 class="text-center text-md-left text-primary pt-3 mb-0">
							' . $val->category_title . '
						</h3>
					</a>
					<p class="text-center text-md-left">
						' . $val->category_description . '
					</p>
					<div class="row">
						<div class="owl-carousel owl-theme" data-nav="1" data-md-items="3" data-lg-items="4">
							' . $posts . '
						</div>
					</div>
				';
			}
		?>
	</div>
</div>

<div class="">
	<div class="container">
		<?php
			if($galleries)
			{
				$albums								= null;

				foreach($galleries as $key => $val)
				{
					$image							= json_decode($val->gallery_images);

					if(!$image) continue;

					foreach($image as $src => $alt)
					{
						$albums						.= '
							<div class="item">
								<div class="card border-0 shadow mr-3 mb-5 ml-3">
									<a href="' . base_url(array('galleries', $val->gallery_slug)) . '" class="--xhr d-block">
										<div class="card-body rounded" style="background:url(' . get_image('galleries', $src, 'thumb') . ') center center no-repeat; background-size: cover; height: 256px">
											<div class="clip gradient-top rounded"></div>
											<div class="absolute bottom p-3">
												<b class="text-light">
													' . $val->gallery_title . '
												</b>
											</div>
										</div>
									</a>
								</div>
							</div>
						';

						break;
					}
				}

				echo '
					<a href="' . base_url('galleries') . '" class="--xhr">
						<h3 class="text-center text-md-left text-primary pt-3 mb-0">
							' . phrase('galleries') . '
						</h3>
					</a>
					<p class="text-center text-md-left">
						New from gallery
					</p>
					<div class="row">
						<div class="owl-carousel owl-theme" data-nav="1" data-md-items="2" data-lg-items="2">
							' . $albums . '
						</div>
					</div>
				';
			}
		?>
	</div>
</div>

<div class="container pt-5 pb-5">
	<div class="row">
		<div class="col-lg-10 offset-lg-1">
			<h1 class="text-center font-weight-bold">
				Testimonial Example
			</h1>
			<br />
			<br />
			<?php echo $latest_testimonials; ?>
		</div>
	</div>
</div>
