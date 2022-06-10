<!DOCTYPE html>
<html lang="ru" dir="ltr">

<head>
	<title><?php  wp_title(''); ?></title>

	<meta charset="UTF-8">
	<meta name="robots" content="index, follow" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<?php wp_head(); ?>
</head>

<body <?php body_class( $class ); ?>>
	<header class="d-flex align-items-center">
		<div class="container">
			<div class="row">
				<div class="col-md-2 d-flex align-items-center">
					<div class="logo">
						<a href="/">
							<img src="<?php echo THEME_URL; ?>/assets/img/logo.png" alt="Logo">
						</a>
					</div>
				</div>
				<div class="col-md-8 d-flex align-items-center justify-content-center">
					<?php
					wp_nav_menu( [
						'theme_location'  => 'mainmenu',
						'menu'            => '',
						'container'       => 'div',
						'container_class' => '',
						'container_id'    => '',
						'menu_class'      => 'menu',
						'menu_id'         => '',
						'echo'            => true,
						'fallback_cb'     => 'wp_page_menu',
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 0,
						'walker'          => '',
					] );
					?>
				</div>
				<div class="col-md-2">
					<div class="social">
						<ul>
							<li>
								<a href="https://t.me/omelson">
									<svg width="32" height="32" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
										<path fill="#000" d="M25.515 6.896L6.027 14.41c-1.33.534-1.322 1.276-.243 1.606l5 1.56 1.72 5.66c.226.625.115.873.77.873.506 0 .73-.235 1.012-.51l2.43-2.363 5.056 3.734c.93.514 1.602.25 1.834-.863l3.32-15.638c.338-1.363-.52-1.98-1.41-1.577z"></path>
									</svg>
								</a>
							</li>
							<li>
								<a href="mailto:omelyanchenko.semen@gmail.com">
									<svg width="22" height="32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
										<path fill="#000" d="M464 64C490.5 64 512 85.49 512 112C512 127.1 504.9 141.3 492.8 150.4L275.2 313.6C263.8 322.1 248.2 322.1 236.8 313.6L19.2 150.4C7.113 141.3 0 127.1 0 112C0 85.49 21.49 64 48 64H464zM217.6 339.2C240.4 356.3 271.6 356.3 294.4 339.2L512 176V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V176L217.6 339.2z"/>
									</svg>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>