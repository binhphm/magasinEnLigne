function templateProduit() {
    return `
        <div class="product-item accessories">
            <div class="product discount product_filter">
                <div class="product_image">
                    <img src="images/product_6.png" alt="">
                </div>
                <div class="favorite favorite_left"></div>
                <div class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center"><span>-$20</span></div>
                <div class="product_info">
                    <h6 class="product_name"><a href="#single.html">Fujifilm X100T 16 MP Digital Camera (Silver)</a></h6>
                    <div class="product_price">$520.00<span>$590.00</span></div>
                </div>
            </div>
            <div class="red_button add_to_cart_button"><a href="#">add to cart</a></div>
        </div>
    `;
}