<div class="sidebar sidebar-main">
                <div class="sidebar-content">

                    <!-- User menu -->
                    <div class="sidebar-user">
                        <div class="category-content">
                            <div class="media">
                                <a href="#" class="media-left"><img src="<?php echo base_url() ?>images/placeholders/placeholder.jpg" class="img-circle img-sm" alt=""></a>
                                <div class="media-body">
                                    <span class="media-heading text-semibold"><?php echo ucwords($this->session->userdata('username')) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /user menu -->


                    <!-- Main navigation -->
                    <div class="sidebar-category sidebar-category-visible">
                        <div class="category-content no-padding">
                            <ul class="navigation navigation-main navigation-accordion">

                                <!-- Main -->
                                <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
                                <li class="active"><a href="<?php echo base_url() ?>Admin/dashboard"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
                                <li class="nav-item nav-item-submenu nav-item-open">
                                    <a href="#" class="nav-link "><i class="icon-price-tag3"></i> <span>Sales</span></a>
                                    <ul class="nav nav-group-sub" data-submenu-title="Form components">
                                        <li class="nav-item"><a href="<?php echo base_url()?>Order/orderList" class="nav-link">Order</a></li>
                                        <li class="nav-item"><a href="<?php echo base_url()?>Purchase/purchaseList" class="nav-link">Purchase</a></li>                                    
                                    </ul>
                                </li>
                                <li class="nav-item nav-item-submenu nav-item-open">
                                    <a href="#" class="nav-link "><i class="icon-price-tag3"></i> <span>Catalog</span></a>
                                    <ul class="nav nav-group-sub" data-submenu-title="Form components">
                                        <li class="nav-item"><a href="<?php echo base_url()?>Product/productList" class="nav-link">Products</a></li>
                                        <!-- <li class="nav-item"><a href="<?php echo base_url()?>Product/affiliateProductList" class="nav-link">Affiliate Products</a></li> -->
                                        <li class="nav-item"><a href="<?php echo base_url()?>Category/categoryList" class="nav-link">Category</a></li>
                                        <!-- <li class="nav-item"><a href="<?php echo base_url()?>AffiliateCategory/categoryList" class="nav-link">Affiliate Category</a></li> -->
                                        <li class="nav-item"><a href="<?php echo base_url()?>Stock/stockList" class="nav-link">Stock</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item nav-item-submenu nav-item-open">
                                    <a href="#" class="nav-link "><i class="icon-price-tag3"></i> <span>User</span></a>
                                    <ul class="nav nav-group-sub" data-submenu-title="Form components">
                                        <li class="nav-item"><a href="<?php echo base_url()?>Customer/customerList" class="nav-link">Customer</a></li>
                                        <li class="nav-item"><a href="<?php echo base_url()?>User/userList" class="nav-link">User</a></li>
                                        <li class="nav-item"><a href="<?php echo base_url()?>Supplier/supplierList" class="nav-link">Supplier</a></li>
                                    </ul>
                                </li>
                                <?php if($this->session->userdata("username") == 'admin'){ ?>
                                
                                <!-- <li class="nav-item nav-item-submenu nav-item-open">
                                    <a href="<?php echo base_url()?>Purchase/purchaseList" class="nav-link "><i class="icon-price-tag3"></i> <span>Purchase</span></a>
                                </li> -->
                                
                                <li class="nav-item nav-item-submenu nav-item-open">
                                    <a href="#" class="nav-link "><i class="icon-price-tag3"></i> <span>Reports</span></a>
                                    <ul class="nav nav-group-sub" data-submenu-title="Form components">
                                        <li class="nav-item"><a href="<?php echo base_url() ?>Admin/saleList" class="nav-link">Sale Reports</a></li>
                                        
                                        <li class="nav-item"><a href="<?php echo base_url() ?>Order/orderList" class="nav-link">Order Reports</a></li>
                                        
                                        <li class="nav-item"><a href="<?php echo base_url() ?>Product/productReports" class="nav-link">Product Reports</a></li>

                                        <li class="nav-item"><a href="<?php echo base_url() ?>Customer/customerReport" class="nav-link">Customer Reports</a></li>
                                        
                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><i class="icon-wrench3"></i> <span>Store</span></a>
                                    <ul>
                                       
                                        <li>
                                            <a href="#">Product</a>
                                            <ul>
                                                <li><a href="<?php echo base_url('Attribute/attributeList')?>">Attributes</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url()?>Offer/offerList"><i class="icon-stack2"></i>Offer</a>
                                        </li>
                                        <li class="nav-item nav-item-submenu nav-item-open">
                                            <a href="<?php echo base_url()?>Coupon/coupenList" class="nav-link "><i class="icon-price-tag3"></i> <span>Coupon</span></a>
                                        </li>
                                         <li class="nav-item nav-item-submenu nav-item-open">
                                            <a href="<?php echo base_url()?>Banner/bannerList" class="nav-link "><i class="icon-price-tag3"></i> <span>Banner</span></a>
                                        </li>
                                        <li class="nav-item nav-item-submenu nav-item-open">
                                            <a href="<?php echo base_url()?>Blog/blogList" class="nav-link "><i class="icon-price-tag3"></i> <span>Blog</span></a>
                                        </li>
                                        <li class="nav-item nav-item-submenu nav-item-open">
                                            <a href="<?php echo base_url()?>Enquiry/enquiryList" class="nav-link "><i class="icon-price-tag3"></i> <span>Enquiry</span></a>
                                        </li>
                                        <li class="nav-item nav-item-submenu nav-item-open">
                                            <a href="<?php echo base_url()?>Pincode/pincodeList" class="nav-link "><i class="icon-price-tag3"></i> <span>Pincode</span></a>
                                        </li>
                                        <li class="nav-item nav-item-submenu nav-item-open">
                                            <a href="<?php echo base_url()?>Advertise/advertiseList" class="nav-link "><i class="icon-price-tag3"></i> <span>Advertise</span></a>
                                        </li>
                                    </ul>
                                </li>

                            <?php } ?>
                                <!-- /main -->
                            </ul>
                        </div>
                    </div>
                    <!-- /main navigation -->

                </div>
            </div>