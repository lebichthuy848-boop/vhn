<!-- breadcrumbs -->

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <ul>
                <li class="home"> <a title="Go to Home Page" href="http://www.magikcommerce.com/">Home</a><span>&mdash;›</span></li>
                <li class="category13"><strong>About Us</strong></li>
            </ul>
        </div>
    </div>
</div>
<!-- main-container -->
<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <section class="col-main col-sm-9 wow">
                <?php $this->load->view('layout/notify'); ?>
                <div class="page-title">
                    <h2>Contact Us</h2>
                </div>                
                <div class="static-contain">
                    <fieldset class="group-select">
                        <form id="f_contact" class="form-horizontal" action="<?php echo base_url('lien-he' . $url_suffix); ?>" method="post" role="form" autocomplete="off">
                            <ul>
                                <li>
                                    <div class="customer-name">
                                        <div class="input-box name-firstname">
                                            <label for="full_name"> Full Name<span class="required">*</span></label>
                                            <br>
                                            <?php $full_name = (set_value('f_data[full_name]') != '' ? set_value('f_data[full_name]') : ''); ?>
                                            <input type="text" id="full_name" name="f_data[full_name]" value="<?php echo $full_name; ?>" title="full_name" class="input-text ">
                                            <?php echo form_error('f_data[full_name]'); ?>
                                        </div>
                                        <div class="input-box name-lastname">
                                            <label for="lastname">Email<span class="required">*</span> </label>
                                            <br>
                                            <?php $email = (set_value('f_data[email]') != '' ? set_value('f_data[email]') : ''); ?>
                                            <input type="text" id="lastname" name="f_data[email]" value="<?php echo $email; ?>" title="email" class="input-text">
                                            <?php echo form_error('f_data[email]'); ?>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="input-box">
                                        <label for="company">Company</label>
                                        <br>
                                        <input type="text" id="company" name="f_data[company]" value="" title="Company" class="input-text">
                                    </div>
                                    <div class="input-box">
                                        <label for="email">Telephone <span class="required">*</span></label>
                                        <br>
                                        <?php $phone = (set_value('f_data[phone]') != '' ? set_value('f_data[phone]') : ''); ?>
                                        <input type="text" name="f_data[phone]" id="phone" value="<?php echo $phone; ?>" title="phone" class="input-text">
                                        <?php echo form_error('f_data[phone]'); ?>
                                    </div>
                                </li>
                                <li>
                                    <label for="street1">Address <span class="required">*</span></label>
                                    <br>
                                    <?php $address = (set_value('f_data[address]') != '' ? set_value('f_data[address]') : ''); ?>
                                    <input type="text" title="Address" name="f_data[address]" id="address" value="<?php echo $address; ?>" class="input-text required-entry">
                                    <?php echo form_error('f_data[address]'); ?>
                                </li>                                            
                                <li>
                                    <label for="subject">Subject <span class="required">*</span></label>
                                    <br>
                                    <?php $subject = (set_value('f_data[subject]') != '' ? set_value('f_data[subject]') : ''); ?>
                                    <input type="text" title="Subject" name="f_data[subject]" id="subject" value="<?php echo $subject; ?>" class="input-text required-entry">
                                    <?php echo form_error('f_data[subject]'); ?>
                                </li>
                                <li>
                                    <label for="message">Message<em class="required">*</em></label>
                                    <br>
                                    <?php $message = (set_value('f_data[message]') != '' ? set_value('f_data[message]') : ''); ?>
                                    <div class="clearfix">
                                        <textarea name="f_data[message]" id="message" title="message" class="required-entry input-text" cols="5" rows="3"><?php echo $message; ?></textarea>
                                        <?php echo form_error('f_data[message]'); ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="input-box">
                                        <label for="email">Mã xác nhận <span class="required">*</span></label>
                                        <br>
                                        <span id="captcha">
                                            <?php if (isset($captcha)) echo $captcha; ?>
                                        </span>
                                        <br>
                                        <input type="text" id="id_captcha" name="captcha" value="" title="Mã xác nhận" class="input-text">
                                        <?php echo form_error('captcha'); ?>
                                    </div>
                                </li>
                            </ul>
                            <p class="require"><em class="required">* </em>Required Fields</p>
                            <div class="buttons-set">
                                <button type="submit" title="Submit" class="button submit"> <span> Submit </span> </button>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </section>
            <aside class="col-right sidebar col-sm-3 wow">
                <div class="block block-company">
                    <div class="block-title">Company </div>
                    <div class="block-content">
                        <ol id="recently-viewed-items">
                            <li class="item odd"><a href="#">About Us</a></li>
                            <li class="item even"><a href="#">Sitemap</a></li>
                            <li class="item  odd"><a href="#">Terms of Service</a></li>
                            <li class="item even"><a href="#">Search Terms</a></li>
                            <li class="item last"><strong>Contact Us</strong></li>
                        </ol>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
<!--End main-container -->