<?php

function thim_child_enqueue_styles() {
	if ( is_multisite() ) {
		wp_enqueue_style( 'thim-child-style', get_stylesheet_uri(), array(), THIM_THEME_VERSION );
	} else {
		wp_enqueue_style( 'thim-parent-style', get_template_directory_uri() . '/style.css', array(), THIM_THEME_VERSION );
	}
	/* slick */
	wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/assets/css/slick.css' );
	wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/assets/js/slick.min.js', array( 'jquery' ), THIM_THEME_VERSION );

	/* swiper */
	wp_enqueue_style( 'swiper', get_stylesheet_directory_uri() . '/assets/css/swiper.min.css' );
	wp_enqueue_script( 'swiper', get_stylesheet_directory_uri() . '/assets/js/swiper.min.js', array( 'jquery' ), THIM_THEME_VERSION );

	wp_enqueue_script( 'thim_child_script', get_stylesheet_directory_uri() . '/js/child_script.js', array( 'jquery' ), THIM_THEME_VERSION );
}
add_action( 'wp_enqueue_scripts', 'thim_child_enqueue_styles', 1 );

load_theme_textdomain( 'eduma-child', get_stylesheet_directory() . '/languages' );

add_filter( 'body_class', 'thim_udemy_custom_class' );
function thim_udemy_custom_class( $classes ) {
	$classes[] = 'thim-child-udemy';
	return $classes;
}

add_action( 'thim-udemy-course-buttons', 'learn_press_course_external_button', 5 );
add_action( 'thim-udemy-course-buttons', 'learn_press_course_purchase_button', 10 );
add_action( 'thim-udemy-course-buttons', 'learn_press_course_enroll_button', 15 );

//add_action( 'after_setup_theme', 'thim_udemy_learnpress_hooks', 15 );

/*
 * Course
 **/

remove_action( 'learn-press/content-landing-summary', 'learn_press_course_tabs', 20 );
remove_action( 'learn-press/content-learning-summary', 'learn_press_course_tabs', 35 );

if ( ! function_exists( 'thim_landing_tabs' ) ) {
	function thim_landing_tabs() {
		return;
	}
}
if ( ! function_exists( 'thim_course_thumbnail_item' ) ) {
	function thim_course_thumbnail_item() {
		return;
	}
}

add_action( 'learn-press/content-landing-summary', 'learn_press_course_overview_tab', 51 );
add_action( 'learn-press/content-landing-summary', 'learn_press_course_curriculum_tab', 60 );
add_action( 'learn-press/content-landing-summary', 'learn_press_course_instructor_tab', 65 );

if ( class_exists( 'LP_Addon_Course_Review' ) ) {
	add_action( 'learn-press/content-landing-summary', 'thim_udemy_course_review', 70 );
}

add_action( 'learn-press/content-learning-summary', 'learn_press_course_overview_tab', 51 );
add_action( 'learn-press/content-learning-summary', 'learn_press_course_curriculum_tab', 60 );
add_action( 'learn-press/content-learning-summary', 'learn_press_course_instructor_tab', 65 );

if ( class_exists( 'LP_Addon_Course_Review' ) ) {
	add_action( 'learn-press/content-learning-summary', 'thim_udemy_course_review', 70 );
}

add_action( 'learn-press/course-info-right', 'thim_udemy_course_thumbnail', 10 );
add_action( 'learn-press/course-info-right', 'thim_udemy_course_payment', 20 );
add_action( 'learn-press/course-info-right', 'thim_udemy_course_wishlist', 25 );
add_action( 'learn-press/course-info-right', 'thim_udemy_course_feature', 30 );
add_action( 'learn-press/course-info-right', 'thim_udemy_course_share', 40 );

if ( ! function_exists( 'thim_udemy_course_thumbnail' ) ) {
	function thim_udemy_course_thumbnail() {
		learn_press_get_template( 'single-course/thumbnail.php' );
	}
}

if( !function_exists( 'thim_udemy_course_share')){
	function thim_udemy_course_share(){
		?>
		<div class="social_share">
			<?php do_action( 'thim_social_share' ); ?>
		</div>
		<?php
	}
}

if( !function_exists( 'thim_udemy_course_wishlist')){
	function thim_udemy_course_wishlist(){
		thim_course_wishlist_button(get_the_ID());
	}
}

if( !function_exists( 'thim_udemy_course_payment')){
	function thim_udemy_course_payment(){
		?>
		<div class="course-payment">
			<?php do_action( 'thim_single_course_payment' );?>
		</div>
		<?php
	}
}

if( !function_exists('thim_udemy_course_feature')){
	function thim_udemy_course_feature(){
		$course_id = get_the_ID();
		$course = learn_press_get_course( $course_id );
		$course_duration = get_post_meta( $course_id, 'thim_course_duration', true );
		$course_skill_level = get_post_meta( $course_id, 'thim_course_skill_level', true );
		$course_language    = get_post_meta( $course_id, 'thim_course_language', true );
		?>
		<div class="thim-course-feature">
			<ul>
				<li class="lectures-feature">
					<i class="fa fa-files-o"></i>
					<span class="value"><?php echo $course->get_curriculum_items('lp_lesson') ? count( $course->get_curriculum_items('lp_lesson') ) : 0; ?></span>
					<span class="label"><?php esc_html_e( 'Lectures', 'eduma' ); ?></span>
				</li>
				<li class="quizzes-feature">
					<i class="fa fa-puzzle-piece"></i>
					<span class="value"><?php echo $course->get_curriculum_items('lp_quiz') ? count( $course->get_curriculum_items('lp_quiz') ) : 0; ?></span>
					<span class="label"><?php esc_html_e( 'Quizzes', 'eduma' ); ?></span>
				</li>
				<?php if ( ! empty( $course_duration ) ): ?>
					<li class="duration-feature">
						<i class="fa fa-clock-o"></i>
						<span class="label"><?php esc_html_e( 'Duration', 'eduma' ); ?></span>
						<span class="value"><?php echo $course_duration; ?></span>
					</li>
				<?php endif; ?>
				<?php if ( ! empty( $course_skill_level ) ): ?>
					<li class="skill-feature">
						<i class="fa fa-level-up"></i>
						<span class="label"><?php esc_html_e( 'Skill level', 'eduma' ); ?></span>
						<span class="value"><?php echo esc_html( $course_skill_level ); ?></span>
					</li>
				<?php endif; ?>
				<?php if ( ! empty( $course_language ) ): ?>
					<li class="language-feature">
						<i class="fa fa-language"></i>
						<span class="value"><?php echo esc_html( $course_language ); ?></span>
						<span class="label"><?php esc_html_e( 'Language', 'eduma' ); ?></span>
					</li>
				<?php endif; ?>
				<li class="students-feature">
					<i class="fa fa-users"></i>
					<?php $user_count = $course->get_users_enrolled() ? $course->get_users_enrolled() : 0; ?>
					<span class="value"><?php echo esc_html( $user_count ); ?></span>
					<span class="label"><?php esc_html_e( 'Students', 'eduma' ); ?></span>
				</li>
			</ul>
		</div>
		<?php
	}
}

/**
 * Display related courses
 */
if ( ! function_exists( 'thim_udemy_related_courses' ) ) {
	function thim_udemy_related_courses() {
		$related_courses    = thim_get_related_courses( 5 );
		$theme_options_data = get_theme_mods();
		$style_content      = isset( $theme_options_data['thim_layout_content_page'] ) ? $theme_options_data['thim_layout_content_page'] : 'normal';

		if ( $related_courses ) {
			$layout_grid = get_theme_mod( 'thim_learnpress_cate_layout_grid', '' );
			$cls_layout  = ( $layout_grid != '' && $layout_grid != 'layout_courses_1' ) ? ' cls_courses_2' : ' ';
			?>
			<div class="thim-ralated-course <?php echo $cls_layout; ?>">

				<?php if ( $style_content == 'new-1' ) { ?>
					<div class="sc_heading clone_title  text-left">
						<h2 class="title"><?php esc_html_e( 'Related Course', 'eduma' ); ?></h2>
						<div class="clone"><?php esc_html_e( 'Related Course', 'eduma' ); ?></div>
					</div>
				<?php } else { ?>
					<h3 class="related-title">
						<?php esc_html_e( 'Related Course', 'eduma' ); ?>
					</h3>
				<?php } ?>

				<div class="thim-course-grid">
					<div class="thim-carousel-wrapper" data-visible="3" data-itemtablet="2" data-itemmobile="1"
					     data-pagination="0" data-navigation="1">
						<?php foreach ( $related_courses as $course_item ) : ?>
							<?php
							$course                     = learn_press_get_course( $course_item->ID );
							$is_required                = $course->is_required_enroll();
							$course_des                 = get_post_meta( $course_item->ID, '_lp_coming_soon_msg', true );
							$course_item_excerpt_length = get_theme_mod( 'thim_learnpress_excerpt_length', 25 );

							$course_duration = get_post_meta( $course->get_id(), 'thim_course_duration', true );
							if( thim_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) ) {
								$num_ratings = learn_press_get_course_rate_total($course->get_id()) ? learn_press_get_course_rate_total($course->get_id()) : 0;
							}

							$class_course = '';
							if($course-> has_sale_price() || $course->is_free()){
								$class_course = 'color-1';
							}else{
								$class_course = 'color-2';
							}
							?>
							<article class="lpr_course">
								<div class="course-item <?php echo $class_course; ?>">
									<div class="course-thumbnail">
										<a class="thumb" href="<?php echo get_the_permalink( $course_item->ID ); ?>">
											<?php
											echo thim_get_feature_image( get_post_thumbnail_id( $course_item->ID ), 'full', 320, 220, get_the_title( $course_item->ID ) );
											?>
										</a>

										<div class="price<?php if($course->is_free()) echo ' free';?>">
											<?php if ( $course->has_sale_price() ) { ?>
												<span class="old-price"> <?php echo esc_html($course->get_origin_price_html()); ?></span>
											<?php } ?>
											<?php echo esc_html($course->get_price_html()); ?>
										</div>
									</div>
									<div class="thim-course-content">
										<div class="course-author">
											<?php echo get_avatar( $course_item->post_author, 40 ); ?>
											<div class="author-contain">
												<div class="value">
													<a href="<?php echo esc_url( learn_press_user_profile_link( $course_item->post_author ) ); ?>">
														<?php echo get_the_author_meta( 'display_name', $course_item->post_author ); ?>
													</a>
												</div>
											</div>
										</div>
										<h2 class="course-title">
											<a rel="bookmark"
											   href="<?php echo get_the_permalink( $course_item->ID ); ?>"><?php echo esc_html( $course_item->post_title ); ?></a>
										</h2> <!-- .entry-header -->

										<?php if ( thim_plugin_active( 'learnpress-coming-soon-courses/learnpress-coming-soon-courses.php' ) && learn_press_is_coming_soon( $course_item->ID ) ): ?>
											<?php if ( intval( $course_item_excerpt_length ) && $course_des ): ?>
												<div class="course-description">
													<?php echo wp_trim_words( $course_des, $course_item_excerpt_length ); ?>
												</div>
											<?php endif; ?>

											<div class="message message-warning learn-press-message coming-soon-message">
												<?php esc_html_e( 'Coming soon', 'eduma' ) ?>
											</div>
										<?php else: ?>
											<div class="course-meta">
												<span>
					                                <i class="ion ion-android-person"></i>
													<?php echo intval($course->count_students());?>
												</span>

												<?php
												$courses_tag = get_the_terms($course->get_id(),'course_category');
												if($courses_tag) {
													?>
													<span>
														<i class="ion ion-ios-pricetags-outline"></i>
														<a href="<?php echo get_term_link($courses_tag[0]->term_id) ?>">
															<?php echo esc_html($courses_tag[0]-> name); ?>
														</a>
													</span>
												<?php }?>

												<?php if( thim_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) ) {?>
													<span class="star">
                                                        <i class="ion ion-android-star"></i>
														<?php echo intval($num_ratings); ?>
                                                    </span>
												<?php }?>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<?php
		}
	}
}

/**
 * About the author
 */
if ( !function_exists( 'thim_udemy_about_author' ) ) {
	function thim_udemy_about_author() {
		$lp_info = get_the_author_meta( 'lp_info' );
		$link    = '#';
		if ( get_post_type() == 'lpr_course' ) {
			$link = apply_filters( 'learn_press_instructor_profile_link', '#', $user_id = null, get_the_ID() );
		} elseif ( get_post_type() == 'lp_course' ) {
			$link = learn_press_user_profile_link( get_the_author_meta( 'ID' ) );
		} elseif ( is_single() ) {
			$link = get_author_posts_url( get_the_author_meta( 'ID' ) );
		}
		?>
		<div class="thim-about-author">
			<h3><?php echo esc_html__('ABOUT INSTRUCTOR','eduma');?></h3>
			<div class="author-wrapper">
				<div class="thim-author-item thim-instructor">
					<div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 147 ); ?>

						<ul class="thim-author-social">
							<?php if ( isset( $lp_info['facebook'] ) && $lp_info['facebook'] ) : ?>
								<li>
									<a href="<?php echo esc_url( $lp_info['facebook'] ); ?>" class="facebook"><i class="fa fa-facebook"></i></a>
								</li>
							<?php endif; ?>

							<?php if ( isset( $lp_info['twitter'] ) && $lp_info['twitter'] ) : ?>
								<li>
									<a href="<?php echo esc_url( $lp_info['twitter'] ); ?>" class="twitter"><i class="fa fa-twitter"></i></a>
								</li>
							<?php endif; ?>

							<?php if ( isset( $lp_info['google'] ) && $lp_info['google'] ) : ?>
								<li>
									<a href="<?php echo esc_url( $lp_info['google'] ); ?>" class="google-plus"><i class="fa fa-google-plus"></i></a>
								</li>
							<?php endif; ?>

							<?php if ( isset( $lp_info['instagram'] ) && $lp_info['instagram'] ) : ?>
								<li>
									<a href="<?php echo esc_url( $lp_info['instagram'] ); ?>" class="instagram"><i
											class="fa fa-instagram"></i></a>
								</li>
							<?php endif; ?>

							<?php if ( isset( $lp_info['linkedin'] ) && $lp_info['linkedin'] ) : ?>
								<li>
									<a href="<?php echo esc_url( $lp_info['linkedin'] ); ?>" class="linkedin"><i class="fa fa-linkedin"></i></a>
								</li>
							<?php endif; ?>

							<?php if ( isset( $lp_info['youtube'] ) && $lp_info['youtube'] ) : ?>
								<li>
									<a href="<?php echo esc_url( $lp_info['youtube'] ); ?>" class="youtube"><i class="fa fa-youtube"></i></a>
								</li>
							<?php endif; ?>
						</ul>
					</div>
					<div class="author-bio">
						<div class="author-top">
							<a class="name" href="<?php echo esc_url( $link ); ?>">
								<?php echo get_the_author(); ?>
							</a>
							<?php if ( isset( $lp_info['major'] ) && $lp_info['major'] ) : ?>
								<p class="job"><?php echo esc_html( $lp_info['major'] ); ?></p>
							<?php endif; ?>
						</div>

						<div class="author-description">
							<?php echo get_the_author_meta( 'description' ); ?>
						</div>
					</div>
				</div>

				<?php
				if ( thim_plugin_active( 'learnpress-co-instructor/learnpress-co-instructor.php' ) && thim_is_version_addons_instructor( '3' ) ) {
					thim_udemy_co_instructors( get_the_ID(), get_the_author_meta( 'ID' ) );
				}
				?>
			</div>
		</div>
		<?php
	}
}

/**
 * Display co instructors
 *
 * @param $course_id
 */
if ( ! function_exists( 'thim_udemy_co_instructors' ) ) {
	function thim_udemy_co_instructors( $course_id, $author_id ) {
		if ( ! $course_id ) {
			return;
		}

		if ( thim_plugin_active( 'learnpress-co-instructor/learnpress-co-instructor.php' ) && thim_is_version_addons_instructor( '3' ) ) {
			$instructors = get_post_meta( $course_id, '_lp_co_teacher' );
			$instructors = array_diff( $instructors, array( $author_id ) );
			if ( $instructors ) {
				foreach ( $instructors as $instructor ) {
					//Check if instructor not exist
					$user = get_userdata( $instructor );
					if ( $user === false ) {
						break;
					}
					$lp_info = get_the_author_meta( 'lp_info', $instructor );
					$link    = learn_press_user_profile_link( $instructor );
					?>
					<div class="thim-author-item thim-co-instructor">
						<div class="author-avatar">
							<?php echo get_avatar( $instructor, 147 ); ?>

							<ul class="thim-author-social">
								<?php if ( isset( $lp_info['facebook'] ) && $lp_info['facebook'] ) : ?>
									<li>
										<a href="<?php echo esc_url( $lp_info['facebook'] ); ?>" class="facebook"><i
												class="fa fa-facebook"></i></a>
									</li>
								<?php endif; ?>

								<?php if ( isset( $lp_info['twitter'] ) && $lp_info['twitter'] ) : ?>
									<li>
										<a href="<?php echo esc_url( $lp_info['twitter'] ); ?>" class="twitter"><i
												class="fa fa-twitter"></i></a>
									</li>
								<?php endif; ?>

								<?php if ( isset( $lp_info['google'] ) && $lp_info['google'] ) : ?>
									<li>
										<a href="<?php echo esc_url( $lp_info['google'] ); ?>"
										   class="google-plus"><i class="fa fa-google-plus"></i></a>
									</li>
								<?php endif; ?>

								<?php if ( isset( $lp_info['instagram'] ) && $lp_info['instagram'] ) : ?>
									<li>
										<a href="<?php echo esc_url( $lp_info['instagram'] ); ?>" class="instagram"><i
												class="fa fa-instagram"></i></a>
									</li>
								<?php endif; ?>

								<?php if ( isset( $lp_info['linkedin'] ) && $lp_info['linkedin'] ) : ?>
									<li>
										<a href="<?php echo esc_url( $lp_info['linkedin'] ); ?>" class="linkedin"><i
												class="fa fa-linkedin"></i></a>
									</li>
								<?php endif; ?>

								<?php if ( isset( $lp_info['youtube'] ) && $lp_info['youtube'] ) : ?>
									<li>
										<a href="<?php echo esc_url( $lp_info['youtube'] ); ?>" class="youtube"><i
												class="fa fa-youtube"></i></a>
									</li>
								<?php endif; ?>
							</ul>
						</div>
						<div class="author-bio">
							<div class="author-top">
								<a itemprop="url" class="name" href="<?php echo esc_url( $link ); ?>">
									<span itemprop="name"><?php echo get_the_author_meta( 'display_name', $instructor ); ?></span>
								</a>
								<?php if ( isset( $lp_info['major'] ) && $lp_info['major'] ) : ?>
									<p class="job"
									   itemprop="jobTitle"><?php echo esc_html( $lp_info['major'] ); ?></p>
								<?php endif; ?>
							</div>
							<div class="author-description" itemprop="description">
								<?php echo get_the_author_meta( 'description', $instructor ); ?>
							</div>
						</div>
					</div>
					<?php
				}
			}
		}
	}
}

/**
 * Display course review
 */
if ( ! function_exists( 'thim_udemy_course_review' ) ) {
	function thim_udemy_course_review() {
		if ( ! thim_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) || ! thim_is_version_addons_review( '3' ) ) {
			return;
		}

		$course_id     = get_the_ID();
		$course_review = learn_press_get_course_review( $course_id, isset( $_REQUEST['paged'] ) ? $_REQUEST['paged'] : 1, 5, true );
		$course_rate   = learn_press_get_course_rate( $course_id );
		$total         = learn_press_get_course_rate_total( $course_id );
		$reviews       = $course_review['reviews'];

		?>
		<div class="course-review-box">
			<div class="course-rating">
				<h3><?php esc_html_e( 'Reviews', 'eduma' ); ?></h3>
				<div class="course-rating-box">
					<div class="average-rating" itemprop="aggregateRating" itemscope=""
					     itemtype="http://schema.org/AggregateRating">
						<p class="rating-title"><?php esc_html_e( 'Average Rating', 'eduma' ); ?></p>

						<div class="rating-box">
							<div class="average-value"
							     itemprop="ratingValue"><?php echo ( $course_rate ) ? esc_html( round( $course_rate, 1 ) ) : 0; ?></div>
							<div class="review-star">
								<?php thim_print_rating( $course_rate ); ?>
							</div>
							<div class="review-amount" itemprop="ratingCount">
								<?php $total ? printf( _n( '%1$s rating', '%1$s ratings', $total, 'eduma' ), number_format_i18n( $total ) ) : esc_html_e( '0 rating', 'eduma' ); ?>
							</div>
						</div>
					</div>
					<div class="detailed-rating">
						<p class="rating-title"><?php esc_html_e( 'Detailed Rating', 'eduma' ); ?></p>

						<div class="rating-box">
							<?php thim_udemy_detailed_rating( $course_id, $total ); ?>
						</div>
					</div>
				</div>
			</div>

			<div class="course-review">
				<div id="course-reviews" class="content-review">
					<ul class="course-reviews-list">
						<?php foreach ( $reviews as $review ) : ?>
							<li>
								<div class="review-container" itemprop="review" itemscope
								     itemtype="http://schema.org/Review">
									<div class="review-author">
										<?php echo get_avatar( $review->ID, 84 ); ?>
										<h4 class="author-name" itemprop="author"><?php echo esc_html( $review->display_name ); ?></h4>
									</div>
									<div class="review-text">
										<h4 class="review-title"><?php echo esc_html( $review->title ); ?></h4>

										<div class="review-star">
											<?php thim_print_rating( $review->rate ); ?>
										</div>

										<div class="description" itemprop="reviewBody">
											<p><?php echo esc_html( $review->content ); ?></p>
										</div>
									</div>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<?php if ( empty( $course_review['finish'] ) && $total ) : ?>
				<div class="review-load-more">
	                <span id="course-review-load-more" data-paged="<?php echo esc_attr( $course_review['paged'] ); ?>"><i
			                class="fa fa-angle-double-down"></i></span>
				</div>
			<?php endif; ?>
			<?php thim_review_button( $course_id ); ?>
		</div>
		<?php
	}
}

/**
 * Display table detailed rating
 *
 * @param $course_id
 * @param $total
 */
if ( ! function_exists( 'thim_udemy_detailed_rating' ) ) {
	function thim_udemy_detailed_rating( $course_id, $total ) {
		global $wpdb;
		$query = $wpdb->get_results( $wpdb->prepare(
			"
		SELECT cm2.meta_value AS rating, COUNT(*) AS quantity FROM $wpdb->posts AS p
		INNER JOIN $wpdb->comments AS c ON p.ID = c.comment_post_ID
		INNER JOIN $wpdb->users AS u ON u.ID = c.user_id
		INNER JOIN $wpdb->commentmeta AS cm1 ON cm1.comment_id = c.comment_ID AND cm1.meta_key=%s
		INNER JOIN $wpdb->commentmeta AS cm2 ON cm2.comment_id = c.comment_ID AND cm2.meta_key=%s
		WHERE p.ID=%d AND c.comment_type=%s AND c.comment_approved=%s
		GROUP BY cm2.meta_value",
			'_lpr_review_title',
			'_lpr_rating',
			$course_id,
			'review',
			'1'
		), OBJECT_K
		);
		?>
			<?php for ( $i = 5; $i >= 1; $i -- ) : ?>
				<div class="stars">
					<div class="key"><?php ( $i === 1 ) ? printf( esc_html__( '%s star', 'eduma' ), $i ) : printf( esc_html__( '%s stars', 'eduma' ), $i ); ?></div>
					<div class="bar">
						<div class="full_bar">
							<div style="<?php echo ( $total && ! empty( $query[ $i ]->quantity ) ) ? esc_attr( 'width: ' . ( $query[ $i ]->quantity / $total * 100 ) . '%' ) : 'width: 0%'; ?>"></div>
						</div>
					</div>
					<div class="value"><?php echo empty( $query[ $i ]->quantity ) ? '0' : esc_html( $query[ $i ]->quantity ); ?></div>
				</div>
			<?php endfor; ?>
		<?php
	}
}

if ( ! function_exists( 'thim_duration_time_calculator' ) ) {
	function thim_duration_time_calculator( $id, $post_type = 'lp_course' ) {
		if ( $post_type == 'lp_course' ) {
			$course_duration_meta = get_post_meta( $id, '_lp_duration', true );
			$course_duration_arr  = array_pad( explode( ' ', $course_duration_meta, 2 ), 2, 'minute' );

			list( $number, $time ) = $course_duration_arr;

			switch ( $time ) {
				case 'week':
					$course_duration_text = sprintf( _n( "%s week", "%s weeks", $number, 'stocklab' ), $number );
					break;
				case 'day':
					$course_duration_text = sprintf( _n( "%s day", "%s days", $number, 'stocklab' ), $number );
					break;
				case 'hour':
					$course_duration_text = sprintf( _n( "%s hour", "%s hours", $number, 'stocklab' ), $number );
					break;
				default:
					$course_duration_text = sprintf( _n( "%s minute", "%s minutes", $number, 'stocklab' ), $number );
			}

			return $course_duration_text;
		} else { // lesson, quiz duration
			$duration = get_post_meta( $id, '_lp_duration', true );

			if ( ! $duration ) {
				return '';
			}
			$duration = ( strtotime( $duration ) - time() ) / 60;
			$hour     = floor( $duration / 60 );
			$minute   = $duration % 60;

			if ( $hour && $minute ) {
				$time = $hour . esc_html__( 'h', 'stocklab' ) . ' ' . $minute . esc_html__( 'm', 'stocklab' );
			} elseif ( ! $hour && $minute ) {
				$time = $minute . esc_html__( 'm', 'stocklab' );
			} elseif ( ! $minute && $hour ) {
				$time = $hour . esc_html__( 'h', 'stocklab' );
			} else {
				$time = '';
			}
			return $time;
		}
	}
}