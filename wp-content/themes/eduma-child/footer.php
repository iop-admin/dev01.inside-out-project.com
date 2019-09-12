<?php if(!isset($_REQUEST['iframe'])) { ?>

<?php do_action( 'thim_above_footer_area' ); ?>

<footer id="colophon" class="<?php thim_footer_class();?>">
	<?php if ( is_active_sidebar( 'footer' ) ) : ?>
		<div class="footer">
			<div class="container">
				<div class="row">
					<?php dynamic_sidebar( 'footer' ); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php do_action('thim_copyright_area'); ?>

</footer><!-- #colophon -->
<?php } ?>
</div><!--end main-content-->

<?php do_action( 'thim_end_content_pusher' ); ?>

</div><!-- end content-pusher-->

<?php do_action( 'thim_end_wrapper_container' ); ?>


</div><!-- end wrapper-container -->

<?php wp_footer(); ?>
</body>
</html>
<?php

//include('inc/bottom-cache.php');

?>