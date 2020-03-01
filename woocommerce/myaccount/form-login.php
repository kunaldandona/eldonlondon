<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="u-columns col2-set" id="customer_login">
	<div class="u-column1 col-1">

	<?php endif; ?>
		<div class="vc_row">
			<div class="vc_col-md-12 woo-c_login">
				<div class="stockie-tabs-sc tab" data-stockie-tab-box="true">
					<div class="tabNav_wrapper">
						<ul class="tabNav <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'no' ){ echo single;}?>" role="tablist">
							<li class="tabNav_line brand-bg-color"></li>

							<li class="tabNav_link active second-title text-left font-titles">
								<?php esc_html_e( 'Sign in', 'stockie' ); ?>
							</li>
							<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) { ?>
								<li class="tabNav_link title text-left font-titles">
									<?php esc_html_e( 'Registration', 'stockie' ); ?>
								</li>
							<?php } ?>
						</ul>
					</div>

					<div class="tabItems" role="tabpanel">
						<div class="tabItems_item active" data-title="<?php esc_html_e( 'Sign In', 'stockie' ); ?>">
							<form method="post" class="login">
								<fieldset>
									<?php do_action( 'woocommerce_login_form_start' ); ?>
										<div class="woocommerce-FormRow woocommerce-FormRow--wide form-row">
											<label for="username" class="field-label"><?php esc_attr_e( 'Username or email address', 'stockie' ); ?></label>
											<input type="text" placeholder="<?php esc_attr_e( 'Username or email address', 'stockie' ); ?>"  name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
										</div>
										<div class="woocommerce-FormRow woocommerce-FormRow--wide form-row">
											<label for="password" class="field-label"><?php esc_attr_e( 'Password', 'stockie' ); ?></label>
											<input placeholder="<?php esc_attr_e( 'Password', 'stockie' ); ?>" type="password" name="password" id="password" />
										</div>
									<?php do_action( 'woocommerce_login_form' ); ?>
									<div class="form-row form-row_btn">
										<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
										<button type="submit" class="btn" name="login" value="<?php esc_attr_e( 'Login', 'stockie' ); ?>">
											<?php esc_attr_e( 'Login', 'stockie' ); ?> <i class="ion ion-right ion-ios-arrow-forward"></i>
										</button>
										<label for="rememberme" class="inline left">
											<input class="woocommerce-Input woocommerce-Input--checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember me', 'stockie' ); ?>
										</label>
										<a class="lost-link right" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'stockie' ); ?></a>
									</div>
									<?php do_action( 'woocommerce_login_form_end' ); ?>
								</fieldset>
							</form>
						</div>

						<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
						<div class="tabItems_item" data-title="<?php esc_html_e( 'Registration', 'stockie' ); ?>">
							<form method="post" class="register">
								<fieldset>

									<?php do_action( 'woocommerce_register_form_start' ); ?>

									<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

									<div class="woocommerce-FormRow woocommerce-FormRow--wide form-row">
										<label for="username" class="field-label"><?php esc_attr_e( 'Username', 'stockie' ); ?></label>
										<input type="text" placeholder="<?php esc_attr_e( 'Username', 'stockie' ); ?>" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
									</div>

									<?php endif; ?>

									<div class="woocommerce-FormRow woocommerce-FormRow--wide form-row">
										<label for="reg_email" class="field-label"><?php esc_attr_e( 'Email address', 'stockie' ); ?></label>
										<input type="email" placeholder="<?php esc_attr_e( 'Email address', 'stockie' ); ?>" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
									</div>

									<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

									<div class="woocommerce-FormRow woocommerce-FormRow--wide form-row">
										<label for="password" class="field-label"><?php esc_attr_e( 'Password', 'stockie' ); ?></label>
										<input type="password" placeholder="<?php esc_attr_e( 'Password', 'stockie' ); ?>" name="password" id="reg_password" />
									</div>

									<?php endif; ?>

									<!-- Spam Trap -->
									<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php esc_html_e( 'Anti-spam', 'stockie' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

									<?php do_action( 'register_form' ); ?>

									<div class="woocomerce-FormRow form-row">
										<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
										<button type="submit" class="btn" name="register" value="<?php esc_attr_e( 'Register', 'stockie' ); ?>">
										<?php esc_attr_e( 'Register', 'stockie' ); ?> <i class="ion ion-right ion-ios-arrow-forward"></i>
										</button>
									</div>

									<?php do_action( 'woocommerce_register_form_end' ); ?>
								</fieldset>
							</form>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>