<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
		</div>
	</main>

	<footer class="wrapper footer">
		<div class="container table">
			<div class="table-cell half credits">
				&copy; Copyright <?php echo date('Y'); ?>
			</div>
			<div class="table-cell half align-right social-media">
				<nav>
					<ul>
						<li><a href="#"><i class="fa fa-fw fa-facebook"></i></a></li>
						<li><a href="#"><i class="fa fa-fw fa-twitter"></i></a></li>
						<li><a href="#"><i class="fa fa-fw fa-instagram"></i></a></li>
					</ul>
				</nav>
			</div>
		</div>
	</footer>
</div>

<div data-overlay>
	<div><i class="fa fa-spin fa-spinner fa-pulse fa-fw"></i></div>
</div>

<div data-popup="testPopup" class="table">
	<a data-destroy><i class="fa fa-fw fa-times-circle"></i></a>
	<div class="table-cell">
		<div class="popup-body">
			<header class="popup-header">
				<h3>Hello World</h3>
			</header>
			<div class="popup-content">
				<p>content goes here</p>
			</div>
		</div>
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>