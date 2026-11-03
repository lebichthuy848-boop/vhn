<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <section class="col-main col-sm-9 wow">
                <div class="page-title">
                    <h1>Checkout</h1>
                </div>
                <ol class="one-page-checkout" id="checkoutSteps">
                    <li id="opc-login" class="section<?php if ($step == 'method') echo ' allow active'; ?>">
                        <div class="step-title"> <span class="number">1</span>
                            <h3 class="one_page_heading">Checkout Method</h3>
                        </div>
                        <div id="checkout-step-login" class="step a-item"<?php if ($step != 'method') echo ' style="display: none;"'; ?>>
                            <div class="col2-set">
                                <div class="col-1">
                                    <h2>Checkout as a Guest or Register</h2>
                                    <p>Register with us for future convenience:</p>
                                    <form action="<?php echo base_url('checkout/method'); ?>" method="post">
                                        <ul class="form-list">
                                            <li class="control">
                                                <input type="radio" class="radio" value="guest" id="login:guest" name="checkout_method">
                                                <label for="login:guest">Checkout as Guest</label>
                                            </li>
                                            <li class="control">
                                                <input type="radio" class="radio" value="register" id="login:register" name="checkout_method" checked="checked">
                                                <label for="login:register">Register</label>
                                            </li>
                                        </ul>

                                        <h4>Register and save time!</h4>
                                        <p>Register with us for future convenience:</p>
                                        <ul class="ul">
                                            <li>Fast and easy check out</li>
                                            <li>Easy access to your order history and status</li>
                                        </ul>
                                        <div class="buttons-set">
                                            <p class="required">&nbsp;</p>
                                            <button class="button continue" type="submit" id="onepage-guest-register-button"><span><span>Continue</span></span></button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-2">
                                    <h2>Login</h2>
                                    <form class="form" method="post" action="<?php echo base_url('login' . $url_suffix); ?>" autocomplete="off">
                                        <fieldset>
                                            <h4>Already registered?</h4>
                                            <p>Please log in below:</p>
                                            <ul class="form-list">
                                                <li>
                                                    <label for="email">User name <span class="required">*</span></label>
                                                    <br>
                                                    <input type="text" title="Username" class="input-text required-entry" id="email" value="" name="username">
                                                </li>
                                                <li>
                                                    <label for="pass">Password <span class="required">*</span></label>
                                                    <br>
                                                    <input type="password" title="Password" id="pass" class="input-text required-entry validate-password" name="password">
                                                </li>
                                            </ul>
                                        </fieldset>

                                        <div class="buttons-set">
                                            <p class="required">* Required Fields</p>
                                            <button class="button login" type="submit"><span><span>Login</span></span></button>
                                            <a class="f-right" href="http://www.magentothemestudio.com/themes/istudio7/index.php/customer/account/forgotpassword/">Forgot your password?</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li id="opc-billing" class="section<?php if ($step == 'billing_information') echo ' active'; ?>">
                        <div class="step-title"> <span class="number">2</span>
                            <h3 class="one_page_heading">Billing Information</h3>
                        </div>
                        <div id="checkout-step-billing" class="step a-item"<?php if ($step != 'billing_information') echo ' style="display: none;"'; ?>>
                            <form action="<?php echo base_url('checkout/billing_information') ?>" method="post" id="co-billing-form">
                                <fieldset class="group-select">
                                    <ul>
                                        <li id="billing-new-address-form">
                                            <fieldset>
                                                <ul>
                                                    <li>
                                                        <div class="customer-name">
                                                            <div class="input-box name-firstname">
                                                                <label for="billing:first_name"> First Name <span class="required">*</span> </label>
                                                                <br />
                                                                <input type="text" id="billing:first_name" name="billing[first_name]" value="<?php if (isset($f_data['billing']['first_name'])) echo $f_data['billing']['first_name']; ?>" title="First Name" class="input-text required-entry" />
                                                            </div>
                                                            <div class="input-box name-lastname">
                                                                <label for="billing:last_name"> Last Name <span class="required">*</span> </label>
                                                                <br />
                                                                <input type="text" id="billing:last_name" name="billing[last_name]" value="<?php if (isset($f_data['billing']['last_name'])) echo $f_data['billing']['last_name']; ?>" title="Last Name" class="input-text required-entry" />
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="input-box">
                                                            <label for="billing:email">Email</label>
                                                            <br />
                                                            <input type="text" id="billing:email" name="billing[email]" value="<?php if (isset($f_data['billing']['email'])) echo $f_data['billing']['email']; ?>" title="Email" class="input-text" />
                                                        </div>
                                                        <div class="input-box">
                                                            <label for="billing:company">Company</label>
                                                            <br />
                                                            <input type="text" id="billing:company" name="billing[company]" value="<?php if (isset($f_data['billing']['company'])) echo $f_data['billing']['company']; ?>" title="Company" class="input-text" />
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <label for="billing:address1">Address <span class="required">*</span></label>
                                                        <br />
                                                        <input type="text" title="Street Address" name="billing[address][]" id="billing:street1" value="<?php if (isset($f_data['billing']['address'][0])) echo $f_data['billing']['address'][0]; ?>" class="input-text required-entry" />
                                                    </li>
                                                    <li>
                                                        <input type="text" title="Street Address 2" name="billing[address][]" id="billing:street2" value="<?php if (isset($f_data['billing']['address'][1])) echo $f_data['billing']['address'][1]; ?>" class="input-text" />
                                                    </li>
                                                    <li>
                                                        <div class="input-box">
                                                            <label for="billing:city">City <span class="required">*</span></label>
                                                            <br />
                                                            <input type="text" title="City" name="billing[city]" value="<?php if (isset($f_data['billing']['city'])) echo $f_data['billing']['city']; ?>" class="input-text required-entry" id="billing:city" />
                                                        </div>
                                                        <div id="div" class="input-box">
                                                            <label for="billing:region">State/Province <span class="required">*</span></label>
                                                            <br />
                                                            <select id="billing:region" name="billing[region]" title="State/Province" class="validate-select">
                                                                <option value="">Please select region, state or province</option>
                                                                <?php
                                                                $region = $this->config->item('region');
                                                                foreach ($region['data'] as $key => $value) {
                                                                    if ($key != $region['default']) {
                                                                        $selected = '';
                                                                    } else {
                                                                        $selected = ' selected="selected"';
                                                                    }
                                                                    echo "<option value=\"$key\"$selected>$value</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="input-box">
                                                            <label for="billing:postcode">Zip/Postal Code <span class="required">*</span></label>
                                                            <br />
                                                            <input type="text" title="Zip/Postal Code" name="billing[postcode]" id="billing:postcode" value="<?php if (isset($f_data['billing']['postcode'])) echo $f_data['billing']['postcode']; ?>" class="input-text validate-zip-international required-entry" onChange="billing.setSameAsBilling(false);" />
                                                        </div>
                                                        <div class="input-box">
                                                            <label for="billing:country">Country <span class="required">*</span></label>
                                                            <br />
                                                            <select name="billing[country]" id="billing:country" class="validate-select" title="Country">
                                                                <option value="" selected=""> </option>
                                                                <?php
                                                                $country = $this->config->item('country');
                                                                foreach ($country['data'] as $key => $value) {
                                                                    if ($key != $country['default']) {
                                                                        $selected = '';
                                                                    } else {
                                                                        $selected = ' selected="selected"';
                                                                    }
                                                                    echo "<option value=\"$key\"$selected>$value</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="input-box">
                                                            <label for="billing:phone">Telephone <span class="required">*</span></label>
                                                            <br />
                                                            <input type="text" name="billing[phone]" value="<?php if (isset($f_data['billing']['phone'])) echo $f_data['billing']['phone']; ?>" title="Telephone" class="input-text required-entry" id="billing:phone" />
                                                        </div>
                                                        <div class="input-box">
                                                            <label for="billing:fax">Fax</label>
                                                            <br />
                                                            <input type="text" name="billing[fax]" value="<?php if (isset($f_data['billing']['fax'])) echo $f_data['billing']['fax']; ?>" title="Fax" class="input-text" id="billing:fax" onChange="billing.setSameAsBilling(false);" />
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <input type="checkbox" name="billing[same_as_billing]" id="billing:same_as_billing" value="1" onClick="billing.setSameAsBilling(this.checked)" class="checkbox" />
                                                        <label for="billing:same_as_billing">Use Billing Address</label>
                                                    </li>
                                                </ul>
                                            </fieldset>
                                        </li>
                                    </ul>
                                    <p class="required">* Required Fields</p>
                                    <div class="buttons-set1" id="billing-buttons-container">
                                        <a href="#"><button type="button" class="button"><span>Back</span></button></a>
                                        &nbsp;
                                        <button type="submit" class="button"><span>Continue</span></button>
                                </fieldset>
                            </form>
                        </div>
                    </li>
                    <li id="opc-shipping" class="sectio <?php if ($step == 'shipping_information') echo ' allow active'; ?>">
                        <div class="step-title"> <span class="number">3</span>
                            <h3 class="one_page_heading">Shipping Information</h3>
                        </div>
                        <div id="checkout-step-shipping" class="step a-item"<?php if ($step != 'shipping_information') echo ' style="display: none;"'; ?>>
                            <form action="<?php echo base_url('checkout/shipping_information') ?>" method="post" id="co-shipping-form">
                                <fieldset class="group-select">
                                    <ul>
                                        <li id="shipping-new-address-form">
                                            <fieldset>
                                                <ul>
                                                    <li>
                                                        <div class="customer-name">
                                                            <div class="input-box name-firstname">
                                                                <label for="shipping:first_name"> First Name <span class="required">*</span> </label>
                                                                <br />
                                                                <input type="text" id="shipping:first_name" name="shipping[first_name]" value="<?php if (isset($f_data['shipping']['first_name'])) echo $f_data['shipping']['first_name']; ?>" title="First Name" class="input-text required-entry" />
                                                            </div>
                                                            <div class="input-box name-lastname">
                                                                <label for="shipping:last_name"> Last Name <span class="required">*</span> </label>
                                                                <br />
                                                                <input type="text" id="shipping:last_name" name="shipping[last_name]" value="<?php if (isset($f_data['shipping']['last_name'])) echo $f_data['shipping']['last_name']; ?>" title="Last Name" class="input-text required-entry" />
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="input-box">
                                                            <label for="shipping:email">Email</label>
                                                            <br />
                                                            <input type="text" id="shipping:email" name="shipping[email]" value="<?php if (isset($f_data['shipping']['email'])) echo $f_data['shipping']['email']; ?>" title="Email" class="input-text" />
                                                        </div>
                                                        <div class="input-box">
                                                            <label for="shipping:company">Company</label>
                                                            <br />
                                                            <input type="text" id="shipping:company" name="shipping[company]" value="<?php if (isset($f_data['shipping']['company'])) echo $f_data['shipping']['company']; ?>" title="Company" class="input-text" />
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <label for="shipping:address1">Address <span class="required">*</span></label>
                                                        <br />
                                                        <input type="text" title="Street Address" name="shipping[address][]" id="shipping:address1" value="<?php if (isset($f_data['shipping']['address'][0])) echo $f_data['shipping']['address'][0]; ?>" class="input-text required-entry" />
                                                    </li>
                                                    <li>
                                                        <input type="text" title="Street Address 2" name="shipping[address][]" id="shipping:address2" value="<?php if (isset($f_data['shipping']['address'][1])) echo $f_data['shipping']['address'][1]; ?>" class="input-text" />
                                                    </li>
                                                    <li>
                                                        <div class="input-box">
                                                            <label for="shipping:city">City <span class="required">*</span></label>
                                                            <br />
                                                            <input type="text" title="City" name="shipping[city]" value="<?php if (isset($f_data['shipping']['city'])) echo $f_data['shipping']['city']; ?>" class="input-text required-entry" id="shipping:city" />
                                                        </div>
                                                        <div id="div" class="input-box">
                                                            <label for="shipping:region">State/Province <span class="required">*</span></label>
                                                            <br />
                                                            <select id="shipping:region" name="shipping[region]" title="State/Province" class="validate-select">
                                                                <option value="">Please select region, state or province</option>
                                                                <?php
                                                                $region = $this->config->item('region');
                                                                foreach ($region['data'] as $key => $value) {
                                                                    if ($key != $region['default']) {
                                                                        $selected = '';
                                                                    } else {
                                                                        $selected = ' selected="selected"';
                                                                    }
                                                                    echo "<option value=\"$key\"$selected>$value</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="input-box">
                                                            <label for="shipping:postcode">Zip/Postal Code <span class="required">*</span></label>
                                                            <br />
                                                            <input type="text" title="Zip/Postal Code" name="shipping[postcode]" id="shipping:postcode" value="<?php if (isset($f_data['shipping']['postcode'])) echo $f_data['shipping']['postcode']; ?>" class="input-text validate-zip-international required-entry" />
                                                        </div>
                                                        <div class="input-box">
                                                            <label for="shipping:country">Country <span class="required">*</span></label>
                                                            <br />
                                                            <select name="shipping[country]" id="shipping:country" class="validate-select" title="Country">
                                                                <option value=""> </option>
                                                                <?php
                                                                $country = $this->config->item('country');
                                                                foreach ($country['data'] as $key => $value) {
                                                                    if ($key != $country['default']) {
                                                                        $selected = '';
                                                                    } else {
                                                                        $selected = ' selected="selected"';
                                                                    }
                                                                    echo "<option value=\"$key\"$selected>$value</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="input-box">
                                                            <label for="shipping:phone">Telephone <span class="required">*</span></label>
                                                            <br />
                                                            <input type="text" name="shipping[phone]" value="<?php if (isset($f_data['shipping']['phone'])) echo $f_data['shipping']['phone']; ?>" title="Telephone" class="input-text required-entry" id="shipping:phone" />
                                                        </div>
                                                        <div class="input-box">
                                                            <label for="shipping:fax">Fax</label>
                                                            <br />
                                                            <input type="text" name="shipping[fax]" value="<?php if (isset($f_data['shipping']['fax'])) echo $f_data['shipping']['fax']; ?>" title="Fax" class="input-text" id="shipping:fax" onChange="shipping.setSameAsBilling(false);" />
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <label for="shipping:note">Note <span class="required">*</span></label>
                                                        <br />
                                                        <textarea title="Note" name="shipping[note]" id="shipping:note" class="input-text required-entry"><?php if (isset($f_data['shipping']['note'])) echo $f_data['shipping']['note']; ?></textarea>
                                                    </li>
                                                    <li>
                                                        <input type="checkbox" name="shipping[same_as_billing]" id="shipping:same_as_billing" value="1" onClick="shipping.setSameAsBilling(this.checked)" class="checkbox" />
                                                        <label for="shipping:same_as_billing">Use Billing Address</label>
                                                    </li>
                                                </ul>
                                            </fieldset>
                                        </li>
                                    </ul>
                                    <p class="required">* Required Fields</p>
                                    <div class="buttons-set1" id="shipping-buttons-container">
                                        <a href="#"><button type="button" class="button"><span>Back</span></button></a>
                                        &nbsp;
                                        <button type="submit" class="button"><span>Continue</span></button>
                                </fieldset>
                            </form>
                        </div>
                    </li>
                    <li id="opc-review" class="section<?php if ($step == 'order_success') echo ' allow active'; ?>">
                        <div class="step-title"> <span class="number">4</span>
                            <h3 class="one_page_heading">Order Success</h3>
                        </div>
                        <div id="checkout-step-review" class="step a-item"<?php if ($step != 'order_success') echo ' style="display: none;"'; ?>>
                            <div class="order-review" id="checkout-review-load"> </div>
                            <div class="buttons-set13" id="review-buttons-container">
                                <p class="f-left">Forgot an Item? <a href="<?php echo base_url('shops/cart'); ?>">Edit Your Cart</a></p>
                                <form action="<?php echo base_url('checkout/order_success'); ?>" method="post">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                    <button type="submit" class="button"><span>Place Order</span></button>
                                </form>
                            </div>
                        </div>
                    </li>
                </ol>
            </section>
            <aside class="col-right sidebar col-sm-3 wow">
                <div class="block block-progress">
                    <div class="block-title ">Your Checkout</div>
                    <div class="block-content">
                        <dl>                            
                            <dt class="complete">Checkout Method <span class="separator">|</span> <a href="<?php echo base_url('checkout/method'); ?>">Change</a></dt>
                            <dd class="complete">
                                <?php
                                if ($this->session->userdata('f_method')) {
                                    $f_method = $this->session->userdata('f_method');
                                    echo $f_method['method'];
                                } else {
                                    echo "No information!";
                                }
                                ?>
                            </dd>
                            
                            <dt class="complete">Billing Address <span class="separator">|</span> <a href="<?php echo base_url('checkout/billing_information'); ?>">Change</a></dt>
                            <dd class="complete">
                                <address>
                                    <?php
                                    if ($this->session->userdata('f_billing_information')) {
                                        $f_billing_information = $this->session->userdata('f_billing_information');
                                        echo $f_billing_information['billing']['address'][0];
                                    } else {
                                        echo "No information!";
                                    }
                                    ?>
                                </address>
                            </dd>
                            
                            <dt class="complete">Shipping Address <span class="separator">|</span> <a href="<?php echo base_url('checkout/shipping_information'); ?>">Change</a></dt>
                            <dd class="complete">
                                <address>
                                    <?php
                                    if ($this->session->userdata('f_shipping_information')) {
                                        $f_shipping_information = $this->session->userdata('f_shipping_information');
                                        echo $f_shipping_information['shipping']['address'][0];
                                    } else {
                                        echo "No information!";
                                    }
                                    ?>
                                </address>
                            </dd>
                            
                        </dl>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>