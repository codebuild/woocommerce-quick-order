<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

wc_print_notices();

$args = array( 'post_type' => 'product', 'orderby' => 'title' );

$products = new WP_Query( $args );

?>
<form class="clearfix" method="post">
    <h2><?php the_title(); ?></h2>
    <div class="select">
        <select name="add-to-cart" class="resizer custom-dropdown__select custom-dropdown__select--white custom-dropdown__select">
            <option value="0"><?php _e( 'Select order', 'wc-quick-order' ); ?></option>
            <?php
            while ( $products->have_posts() ) : $products->the_post();

                $title = get_the_title($products->post->ID);
                $product = new WC_Product($products->post);
                echo '<option value="'.$products->post->ID.'" >'.$title.((!$product->is_in_stock()) ? ' ('.__( 'Sold out', 'wc-quick-order' ).')' : '').'</option>';

            endwhile;

            wp_reset_query();
            ?>
        </select>
    </div>
    <input class="cart-button" type="submit" name="quick_order" value="<?php _e('Add to cart', 'wc-quick-order') ?>" >
</form>
<?php

if ( sizeof( WC()->cart->get_cart() ) == 0 )
{
    wc_get_template( 'cart/cart-empty.php' );
}
else
{
    wc_get_cart_table_template();
}
?>