<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <section class="col-main col-sm-9 wow">
                <div class="my-account">
                    <div class="page-title">
                        <h2>My Account</h2>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo $row['full_name']; ?></h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3 col-lg-3 " align="center">
                                    <img alt="<?php echo $row['full_name']; ?>" src="<?php echo $path_avatar . $row['photo']; ?>" class="img-circle img-responsive">
                                </div>
                                <div class=" col-md-9 col-lg-9 "> 
                                    <table class="table table-user-information">
                                        <tbody>
                                            <tr>
                                                <td>User name:</td>
                                                <td><?php echo $row['username']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Register date:</td>
                                                <td><?php echo date('d-m-Y', $row['regdate']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Date of Birth</td>
                                                <td><?php echo date('d-m-Y', $row['birthday']); ?></td>
                                            </tr>

                                            <tr>
                                            <tr>
                                                <td>Gender</td>
                                                <td><?php echo get_gender($row['gender']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Home Address</td>
                                                <td>Metro Manila,Philippines</td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td><a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a></td>
                                            </tr>
                                        <td>Phone Number</td>
                                        <td>123-4567-890(Landline)<br><br>555-4567-890(Mobile)
                                        </td>

                                        </tr>

                                        </tbody>
                                    </table>

                                    <a href="<?php echo base_url('users/editinfo'); ?>" class="btn btn-primary"><i class="fa fa-edit fa-lg"></i> Edit</a>
                                    <a href="<?php echo base_url('users/changepass'); ?>" class="btn btn-warning">Change Password</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <aside class="col-right sidebar col-sm-3 wow">
                <div class="block block-account">
                    <div class="block-title">My Account</div>
                    <div class="block-content">
                        <ul>
                            <li class="current"><a>Account Dashboard</a></li>
                            <li><a href="#customer/account/edit/">Account Information</a></li>
                            <li><a href="<?php echo base_url('users/changepass'); ?>">Change Password</a></li>
                            <li><a href="#sales/order/history/">My Orders</a></li>
                            <li><a href="#wishlist/">My Wishlist</a></li>
                            <li class="last"><a href="#newsletter/manage/tt">Newsletter Subscriptions</a></li>
                        </ul>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>