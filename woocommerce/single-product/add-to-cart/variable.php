<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.5
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $post;

function is_color_attr($options, $attribute_name) {
	$custom = false;

	foreach ($options as $option):
		$term = get_term_by( 'slug', $option, $attribute_name);
		if ($term) {
			if(get_field('color', $term)) {
				$custom = true;
				break;
			}
		}
	endforeach;

	return $custom;
}

function is_radio_attr($options, $attribute_name) {
	$custom = false;
	foreach ($options as $option):
		$term = get_term_by( 'slug', $option, $attribute_name);
		if ($term) {
			if(get_field('attribute_mod', $term) == 'Radio') {
				$custom = true;
				break;
			}
		}
	endforeach;

	return $custom;
}

$attribute_keys = array_keys( $attributes );
do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form id="variation_form_anchor" class="woo_c-product-details-variations variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<button type="submit" class="single_add_to_cart_button btn btn-small alt" disabled="true">
			<?php esc_html_e( 'This product is currently out of stock and unavailable.', 'stockie' ); ?>
		</button>
	<?php else : ?>


		<div class="variations">

			<div class="variation">
				<div class="label">
					<label for="php"><?php esc_html_e( 'QTY', 'stockie' ); ?>:</label>
				</div>
				<?php woocommerce_quantity_input( array(
					'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 )
				) ); ?>
			</div>

			<?php foreach ( $attributes as $attribute_name => $options ) : ?>
				<div id="variation_<?php echo esc_attr($attribute_name) ?>" class="variation">
					<div class="label"><label for="pa_color"><?php echo wc_attribute_label( $attribute_name ) ?>:</label></div>

					<?php
					if (is_color_attr($options, $attribute_name)):

						echo '<div class="custom_select" style="display: none">';
						$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) : $product->get_variation_default_attribute( $attribute_name );
						wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected, 'class'=> 'test', 'show_option_none' => wc_attribute_label( $attribute_name ) ) );
						echo "</div>";
						echo '<div class="color_attr">';
							$defalt_option = $product->get_variation_default_attribute( $attribute_name );
							foreach ($options as $option):
								$active = '';
								if ($defalt_option == $option) {
									$active = 'active';
								}
								$term = get_term_by( 'slug', $option, $attribute_name);
								if(get_field('color', $term)) {
									echo '<span class="color-item '.$active.'"  data-option='.$option.' style="background-color: '. get_field('color', $term) .'"></span>';
								} else {
									echo '<span'.$active.'  data-option='.$option.' style="margin-right: 12px;">' .$term->name .'</span>';
								}

							endforeach;
						echo '</div>';

					elseif (is_radio_attr($options, $attribute_name)) :

                        echo '<div class="custom_select" style="display: none">';
                        $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) : $product->get_variation_default_attribute( $attribute_name );

                        wc_dropdown_variation_attribute_options(
                            array(
                                'options' => $options,
                                'attribute' => $attribute_name,
                                'product' => $product,
                                'selected' => $selected,
                                'class'=> 'test',
                                'show_option_none' => wc_attribute_label( $attribute_name )
                            )
                        );
                        echo "</div>";

                        echo '<div class="size_attr">';
                        $defalt_option = $product->get_variation_default_attribute( $attribute_name );
                        foreach ($options as $option):
                            $active = '';
                            if ($defalt_option == $option) {
                                $active = 'active';
                            }
                            $term = get_term_by( 'slug', $option, $attribute_name);
                            if(get_field('color', $term)) {
                                echo '<span class="color-item '.$active.'"  data-option='.$option.' style="background-color: '. get_field('color', $term) .'"></span>';
                            } else {
                                echo '<span class="size-item'.$active.'""  data-option='.$option.'>' .$term->name .'</span>';
                            }

                        endforeach;
                        echo '</div>';

                        else :
						$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) : $product->get_variation_default_attribute( $attribute_name );
						wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected, 'class'=> 'test', 'show_option_none' => wc_attribute_label( $attribute_name ) ) );
					endif; ?>

				</div>
				<?php
					echo end( $attribute_keys ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<div class="reset variation"><a class="btn btn-link reset_variations" href="#"><span>' . esc_html__( 'Reset', 'stockie' ) . '</span><i class="ion ion-right ion-md-close-circle-outline"></i></a></div>' ) : '';
				?>
			<?php endforeach;?>

		</div>


		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap">
			<?php

				do_action( 'woocommerce_before_single_variation' );
				do_action( 'woocommerce_single_variation' );
				?>

				<div class="variations_button">

                    <?php if (StockieSettings::get('woocommerce_add_to_cart_ajax', 'global')) { ?>
                        <a class="single_add_to_cart_button btn alt btn-loading-disabled">
                            <i class="icon ion ion-left">
                                <svg version="1.1"  width="14px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 12 16" xml:space="preserve">
						<path class="st0" d="M9,4V3c0-1.7-1.3-3-3-3S3,1.3,3,3v1H0v10c0,1.1,0.9,2,2,2h8c1.1,0,2-0.9,2-2V4H9z M4,3c0-1.1,0.9-2,2-2
							s2,0.9,2,2v1H4V3z"></path>
						</svg>
                            </i>
                            <?php echo esc_html( $product->single_add_to_cart_text() ); ?>
                        </a>
                    <?php } else { ?>
                        <button type="submit" class="single_add_to_cart_button btn alt btn-loading-disabled">

                            <i class="icon ion ion-left">
                                <svg version="1.1"  xmlns="http://www.w3.org/2000/svg" width="12px" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 12 16" xml:space="preserve">
                        <path class="st0" d="M9,4V3c0-1.7-1.3-3-3-3S3,1.3,3,3v1H0v10c0,1.1,0.9,2,2,2h8c1.1,0,2-0.9,2-2V4H9z M4,3c0-1.1,0.9-2,2-2
                            s2,0.9,2,2v1H4V3z"/>
                        </svg>
                            </i>
                            <?php echo esc_html( $product->single_add_to_cart_text() ); ?>
                        </button>
                    <?php } ?>




				</div>
				<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
				<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
				<input type="hidden" name="variation_id" class="variation_id" value="" />

				<?php do_action( 'woocommerce_after_single_variation' ); ?>
				</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
