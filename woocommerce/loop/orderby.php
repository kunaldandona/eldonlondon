<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<form class="woocommerce-ordering" method="get">
	<span class="clickSelf">
		<select name="orderby" class="orderby">
			<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
				<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
			<?php endforeach; ?>
		</select>
		<input type="hidden" name="paged" value="1" />
		<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
	</span>
</form>

<?php
	$orderby = 'name';
	$order = 'asc';
	$hide_empty = false ;
	$cat_args = array(
		'orderby'    => $orderby,
		'order'      => $order,
		'hide_empty' => $hide_empty,
	);

	$product_tags = get_terms( 'product_tag', $cat_args );

	if( !empty($product_tags) ){
		echo '
		<div class="woocommerce-ordering">
			<span class="clickSelf">
				<select>
				<option value="'.get_permalink( wc_get_page_id( 'shop' ) ).'">';
				esc_attr_e( 'Tags', 'stockie' );
				echo '</option>';
				foreach ($product_tags as $tag) {
					$selected = '';
					if (isset(get_queried_object()->term_id) && get_queried_object()->term_id == $tag->term_id ) {
						$selected = ' selected="selected"';
					}
					echo '<option value="'.get_term_link($tag).'"'.$selected.'>'.$tag->name.'</option>';
				}
			echo "</select>
			</span>
		</div>";
	}
?>

<?php
	$orderby = 'name';
	$order = 'asc';
	$hide_empty = false ;
	$cat_args = array(
		'orderby'    => $orderby,
		'order'      => $order,
		'hide_empty' => $hide_empty,
	);

	$product_categories = get_terms( 'product_cat', $cat_args );

	if( !empty($product_categories) ){
		echo '
		<div class="woocommerce-ordering">
			<span class="clickSelf">
				<select>
				<option value="'.get_permalink( wc_get_page_id( 'shop' ) ).'">';
				esc_attr_e( 'Categories', 'stockie' );
				echo '</option>';
				foreach ($product_categories as $category) {
					$selected = '';
					if (isset(get_queried_object()->term_id) && get_queried_object()->term_id == $category->term_id ) {
						$selected = ' selected="selected"';
					}
					echo '<option value="'.get_term_link($category).'"'.$selected.'>'.$category->name.'</option>';
				}
			echo "</select>
			</span>
		</div>";
	}
?>
