<?php
    global $product;
    $available = StockieSettings::show_sticky_product();
?>
<?php if ($available): ?>
    <div class="sticky-product">
        <?php if ( has_post_thumbnail() ) {
            $url = wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' ) ?>
            <div class="sticky-product-img" style="background-image: url(<?php echo esc_url($url) ?>)"></div>
        <?php } else { ?>
            <div class="sticky-product-img" style="background-image: url(<?php echo wc_placeholder_img_src() ?>)"></div>
        <?php } ?>
        <div class="sticky-product-desc">
            <a href="<?php the_permalink() ?>" class="title"><?php the_title(); ?></a>
            <div class="categories">
                <?php
                $cats = get_the_terms( $post->ID, 'product_cat' );
                $cat_count = sizeof( $cats );
                if ($cat_count) {
                    $i = 0;
                    foreach ($cats as $cat) {
                        if ($i > 0) {
                            echo ", ";
                        }
                        ?>
                        <a href="<?php echo get_term_link($cat->term_id) ?>" class="category"><?php echo esc_html($cat->name) ?></a>
                        <?php
                        $i++;
                    }
                }
                ?> 
            </div>
            <span class="price"><?php echo get_woocommerce_currency_symbol() . $product->get_price() ?></span>
        </div>
        <?php if( $product->is_type( 'variable' ) ):?>
            <div class="variations_button sticky-product-btn">
                <a href="#variation_form_anchor" class="variation_anchor_link btn alt sticky-product-cart">
                    <span class="icon">
                        <svg version="1.1"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 12 16" xml:space="preserve">
                            <path class="st0" d="M9,4V3c0-1.7-1.3-3-3-3S3,1.3,3,3v1H0v10c0,1.1,0.9,2,2,2h8c1.1,0,2-0.9,2-2V4H9z M4,3c0-1.1,0.9-2,2-2
                            s2,0.9,2,2v1H4V3z"></path>
                        </svg>
                    </span>
                </a>
            </div>
        <?php else: ?>
            <form class="cart woocommerce-add-to-cart" method="post" enctype='multipart/form-data'>
                <?php if ( $product->is_in_stock() ) : ?>
                    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
                    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
                    <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
                    <input type="hidden" name="variation_id" class="variation_id" value="0" />
                    <div class="variations_button sticky-product-btn">
                        <a class="single_add_to_cart_button btn alt sticky-product-cart btn">
                            <span class="icon">
                                <svg version="1.1"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 12 16" xml:space="preserve">
                                    <path class="st0" d="M9,4V3c0-1.7-1.3-3-3-3S3,1.3,3,3v1H0v10c0,1.1,0.9,2,2,2h8c1.1,0,2-0.9,2-2V4H9z M4,3c0-1.1,0.9-2,2-2
                                    s2,0.9,2,2v1H4V3z"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="sticky-product-btn">
                        <a class="btn alt sticky-product-out-of-stock">
                            <i class="ion ion-md-close-circle-outline"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </form>
        <?php endif; ?>
    </div>
<?php endif; ?>
