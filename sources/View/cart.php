<?php include('./header.php') ?>
<section class="main-content">
    <section class="content-container">
        <section class="content-box">
            <section class="cart-container">
                <section class="cart-wrapper">
                        <div class="cart-wrapper__head">
                            Giỏ hàng
                        </div>
                        <div class="cart-wrapper__body" >
                            <div class="row">
                                <div class="col" id="cart-wrapper__quantity">
                                    {{ 0 }} Sản phẩm
                                </div>
                                <div class="col">
                                    Đơn giá
                                </div>
                                <div class="col">
                                    Số lượng
                                </div>
                                <div class="col">
                                    Thành tiền
                                </div>
                                <div class="col">
                                    <i class="fal fa-trash"></i>
                                </div>
                            </div>
                            <div class="cart-detail" id="cart-detail"> 
                            
                            </div>
                        </div>
                    </article>
                </section>
                <section class="cart-desc" id="cart-desc">     
                <div class="cart-desc__head">
                    Thông tin thanh toán
                </div>
                <div class="cart-desc__body">
                    <div class="cart-desc--money" style="border-bottom: 1px solid #5680e9; padding-bottom: .25em;">
                        <p>Tổng cộng</p>
                        <p id='cart-desc--fullprice'></p>
                    </div>
                    <?php 
                        if(isset($_SESSION['user'])) {
                            $discounts = $discountDAO->getAllUserDiscounts($user->getID());
                            if(count($discounts) > 0) {
                                $discountCounter = 0;
                                foreach ($discounts as $discount) {
                                    ?> 
                                    <div class="cart-desc__body__coupons">
                                        <div class="coupon">
                                            <div class="coupon-thumnail">
                                                <img src="./assets/images/logo.png" alt="coupon">
                                            </div>
                                            <div class="coupon-detail">
                                                <p class="coupon-title">
                                                    Giảm <?php echo $utils->formatMoney($discount->getPrice()); ?>
                                                </p>
                                            </div>
                                            <input name="coupon" class="coupon-method" type="radio" value="<?php echo $discount->getType(); ?>">
                                        </div>
                                    </div>
                                <?php $discountCounter++; } ?>
                    <?php }
                } else { ?> 
                        <h3 style="padding: .5em 0; border: 1px solid #5680e9; border-left: none; border-right: none;">Bạn không có mã giảm giá</h3>
                    <?php } ?>
                </div>
                <div class="cart-desc__foot" style="border-top: 1px solid #5680e9; padding-top: .25em;">
                    <div class="money">
                        <div class="cart-desc--money">
                            <p>Số tiền trong tài khoản</p>
                            <p id="cart-desc--userMoney">${moneyFormat(currency.userMoney)}</p>
                        </div>
                        <div class="cart-desc--money">
                            <p>Số tiền còn thiếu</p>
                            <p id="cart-desc--left">${moneyFormat(currency.left)}</p>
                        </div>
                        <div class="cart-desc--money">
                            <p>Tổng giảm</p>
                            <p id="cart-desc--discount">${moneyFormat(currency.discount)}</p>
                        </div>
                        </div>
                        <div class="cart-desc--money">
                            <p>Tổng cộng</p>
                            <p id="cart-desc--total">${moneyFormat(currency.total)}</p>
                        </div>
                    </div>
                    <button class="checkout" onclick="checkout(<?php echo isset($_SESSION['user']) ? $_SESSION['user'] : 'false'; ?>);">
                        Thanh toán
                    </button>
                </div>   
                </section>
            </section>
        </section>
    </section>
</section>
<?php include('./footer.php') ?>
<script>
    
    loadCart();
</script>