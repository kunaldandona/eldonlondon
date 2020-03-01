<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
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
 * @version 3.5.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="vc_row">
	<div class="vc_col-md-12 woo-c_login myaccount-login-form reset-password-form">
		<h2 class="title text-left"><?php esc_html_e( 'Reset password', 'stockie' ); ?></h2>
		<form method="post" class="woocommerce-ResetPassword lost_reset_password">
			<p class="text-left"><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'stockie' ) ); ?></p>
			<p class="woocommerce-FormRow form-row">
				<label for="user_login" class=" left"><?php esc_html_e( 'Username or email', 'stockie' ); ?></label>
				<input type="text" name="user_login" id="user_login" />
			</p>
			<?php do_action( 'woocommerce_lostpassword_form' ); ?>
			<p class="woocommerce-FormRow form-row">
				<input type="hidden" name="wc_reset_password" value="true" />
				<button type="submit" class="btn woocommerce-Button left btn-submit" value="<?php esc_attr_e( 'Reset Password', 'stockie' ); ?>">
					<span class="text">Reset Password</span>
					<i class="ion ion-right ion-ios-arrow-forward"></i>
				</button>
			</p>
			<?php wp_nonce_field( 'lost_password' ); ?>
		</form>
	</div>
</div>