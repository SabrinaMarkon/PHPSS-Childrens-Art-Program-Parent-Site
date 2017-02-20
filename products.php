<?php
$showcontent = new PageContent();
echo $showcontent->showPage('Members Area Products Page');
$allproducts = new Product();
$products = $allproducts->getAllProducts();
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <h1 class="ja-bottompadding2">Our Services</h1>

            <div class="panel-group panel-products" id="accordion">

                <?php
                foreach ($products as $product) {
                    ?>
                    <div class="panel panel-default text-left">
                        <div class="panel-heading">
                            <h4 class="panel-title panel-toppadding">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $product['id'] ?>" class="productname"><?php echo $product['name'] ?></a>
                                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                    <input type="hidden" name="amount" value="<?php echo $product['price'] ?>">
                                    <input type="hidden" name="cmd" value="_xclick">
                                    <input type="hidden" name="business" value="<?php echo $adminpaypal ?>">
                                    <input type="hidden" name="item_name" value="<?php echo $sitename . ' - ' . $product['name'] ?>">
                                    <input type="hidden" name="page_style" value="PayPal">
                                    <input type="hidden" name="no_shipping" value="1">
                                    <input type="hidden" name="return" value="<?php echo $domain . '/thankyou' ?>">
                                    <input type="hidden" name="cancel" value="<?php echo $domain . '/products' ?>">
                                    <input type="hidden" name="currency_code" value="USD">

                                    <input type="hidden" name="lc" value="US">
                                    <input type="hidden" name="bn" value="PP-BuyNowBF">
                                    <input type="hidden" name="on0" value="User ID">
                                    <input type="hidden" name="os0" value="<?php echo $username ?>">
                                    <input type="hidden" name="on1" value="Product ID">
                                    <input type="hidden" name="os1" value="<?php echo $product['id'] ?>">
                                    <input type="hidden" name="notify_url" value="<?php echo $domain . '/ipn' ?>">
                                    <button class="btn btn-md btn-primary" type="submit" name="orderbutton">Order for $<?php echo $product['price'] ?></button>
                                </form>

                                <div class="clearfix"></div>
                            </h4>
                        </div>

                        <?php
                        if($product['id'] == 1) {
                            ?>
                            <div class="panel-collapse collapse in" id="collapse<?php echo $product['id']; ?>">
                            <?php
                        } else {
                            ?>
                            <div class="panel-collapse collapse" id="collapse<?php echo $product['id']; ?>">
                            <?php
                        }
                        ?>
                                <div class="panel-body">
                                    <p><?php echo $product['description'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>

            <div class="ja-bottompadding"></div>

        </div>
    </div>
</div>
