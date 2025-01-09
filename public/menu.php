<?php
include("./includes/head.php");
?>

<div id="main-wrapper">
    <?php include("./includes/sidebar.php") ?>
    <!-- header here -->
    <?php include("./header.php") ?>
    <!-- chatbox here -->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0 d-sm-flex flex-wrap d-block">
                            <div class="mb-3">
                                <h4 class="card-title mb-1">
                                    <!-- <button class=" btn btn-outline-primary">Create Menu</button> -->
                                    <button class=" btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#basicModal">Create Menu</button>
                                </h4>
                                    
                                <!-- <small class="mb-0"></small> -->
                            </div>
                            <div class="card-action card-tabs mb-3">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#monthly" role="tab">
                                            ALL
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#weekly" role="tab">
                                            STARTERS
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#weekly" role="tab">
                                            BREAKFASTER
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#weekly" role="tab">
                                            LUNCH
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#weekly" role="tab">
                                            DINNER
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#today" role="tab">
                                            DESSERTS
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid lozad" data-src="../images/product/1.jpg" alt="">
                                </div>
                                <div class="new-arrival-content text-center mt-3 d-flex  justify-content-between">
                                    <h4><a href="ecom-product-detail.html">Chicken</a></h4>
                                    <span class="price">$71.00</span>
                                </div>
                                <div class="row">
                                    <div class=" col-12 mt-3"><a class="btn  btn-outline-warning btn-block p-1" href="product"><i class="fa fa-eye me-2"></i> View </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid lozad" data-src="../images/product/2.jpg" alt="">
                                </div>
                                <div class="new-arrival-content text-center mt-3 d-flex  justify-content-between">
                                    <h4><a href="ecom-product-detail.html">Chicken</a></h4>
                                    <span class="price">$71.00</span>
                                </div>
                                <div class="row">
                                    <div class=" col-12 mt-3"><a class="btn  btn-outline-warning btn-block p-1" href="product"><i class="fa fa-eye me-2"></i> View </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid lozad" data-src="../images/product/3.jpg" alt="">
                                </div>
                                <div class="new-arrival-content text-center mt-3 d-flex  justify-content-between">
                                    <h4><a href="ecom-product-detail.html">Chicken</a></h4>
                                    <span class="price">$71.00</span>
                                </div>
                                <div class="row">
                                    <div class=" col-12 mt-3"><a class="btn  btn-outline-warning btn-block p-1" href="product"><i class="fa fa-eye me-2"></i> View </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid lozad" data-src="../images/product/4.jpg" alt="">
                                </div>
                                <div class="new-arrival-content text-center mt-3 d-flex  justify-content-between">
                                    <h4><a href="ecom-product-detail.html">Chicken</a></h4>
                                    <span class="price">$71.00</span>
                                </div>
                                <div class="row">
                                    <div class=" col-12 mt-3"><a class="btn  btn-outline-warning btn-block p-1" href="product"><i class="fa fa-eye me-2"></i> View </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid lozad" data-src="../images/product/5.jpg" alt="">
                                </div>
                                <div class="new-arrival-content text-center mt-3 d-flex  justify-content-between">
                                    <h4><a href="ecom-product-detail.html">Chicken</a></h4>
                                    <span class="price">$71.00</span>
                                </div>
                                <div class="row">
                                    <div class=" col-12 mt-3"><a class="btn  btn-outline-warning btn-block p-1" href="product"><i class="fa fa-eye me-2"></i> View </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid lozad" data-src="../images/product/6.jpg" alt="">
                                </div>
                                <div class="new-arrival-content text-center mt-3 d-flex  justify-content-between">
                                    <h4><a href="ecom-product-detail.html">Chicken</a></h4>
                                    <span class="price">$71.00</span>
                                </div>
                                <div class="row">
                                    <div class=" col-12 mt-3"><a class="btn  btn-outline-warning btn-block p-1" href="product"><i class="fa fa-eye me-2"></i> View </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid lozad" data-src="../images/product/7.jpg" alt="">
                                </div>
                                <div class="new-arrival-content text-center mt-3 d-flex  justify-content-between">
                                    <h4><a href="ecom-product-detail.html">Back Bag</a></h4>
                                    <span class="price">$71.00</span>
                                </div>
                                <div class="row">
                                    <div class=" col-12 mt-3"><a class="btn  btn-outline-warning btn-block p-1" href="product"><i class="fa fa-eye me-2"></i> View </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid lozad" data-src="../images/product/1.jpg" alt="">
                                </div>
                                <div class="new-arrival-content text-center mt-3 d-flex  justify-content-between">
                                    <h4><a href="ecom-product-detail.html">FLARE DRESS</a></h4>
                                    <span class="price">$780.00</span>
                                </div>
                                <div class="row">
                                    <div class=" col-12 mt-3"><a class="btn  btn-outline-warning btn-block p-1" href="product"><i class="fa fa-eye me-2"></i> View </a></div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="text-center bg-white pt-3">
                        <a href="javascript:void(0);" class="btn-link dz-load-more" rel="ajax/selling-items.html" id="sellingItems">View more <i class="fa fa-angle-down ms-2 scale-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- modal -->
        <div class="modal fade bd-example-modal-lg" id="basicModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Menu</h5>
                   <span class=" badge badge-circle badge-outline-danger"> <span class=" fa fa-times " data-bs-dismiss="modal"></span></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <div class=" d-flex justify-content-between align-items-center ">
                                <label for="menu_type" class="text-black form-label">Type of menu <span class="required text-danger">*</span></label>
                                <span class="badge badge-circle badge-outline-info" onclick="addOption('#menu_type','Menu type ')"><span class=" fa fa-plus ml-3"></span></span>
                                </div>
                                <select type="text" class="form-control" value="" name="menu_type" id="menu_type">
                                    <option value="" selected disabled>__select_</option>
                                    <option value="Hors-d oeuvre / Appetizer">Hors-d oeuvre / Appetizer </option>
                                    <option value="Potage / Soup">Potage / Soup </option>
                                    <option value="Oeuf / Egg">Oeuf / Egg </option>
                                    <option value=" Farinaceous / Farineaux / Pasta or Rice"> Farinaceous / Farineaux / Pasta or Rice </option>
                                    <option value="Poisson / Fish">Poisson / Fish </option>
                                    <option value="Entrée / Entree">Entrée / Entree </option>
                                    <option value="Sorbet / Sorbet">Sorbet / Sorbet </option>
                                    <option value="Releve  / Joints"> Releve  / Joints </option>
                                    <option value="Roti / Roast">Roti / Roast </option>
                                    <option value="Legumes / Vegetables">Legumes / Vegetables</option>
                                    <option value="Salades / Salad">Salades / Salad</option>
                                    <option value="Buffet Froid / Cold Buffet">Buffet Froid / Cold Buffet </option>
                                    <option value="Entremets / Sweets">Entremets / Sweets</option>
                                    <option value="Savoureux / Savory">Savoureux / Savory </option>
                                    <option value="Fromage / Cheese">Fromage / Cheese</option>
                                    <option value="Dessert / Cut Fruits & Nuts">Dessert / Cut Fruits & Nuts</option>
                                    <option value="Boissons / Beverage">Boissons / Beverage</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                            <div class=" d-flex justify-content-between align-items-center ">
                                <label for="menu_dish" class="text-black font-w400 form-label"><span class=""></span> dish name<span class="required text-danger">*</span></label>
                                <span class="badge badge-circle badge-outline-info"  onclick="addOption('#dish_name','Dish name ')"><span class=" fa fa-plus ml-3"></span></span>
                            </div>
                                <select type="text" class="form-control" value="" name="menu_dish" id="dish_name">
                                    <option value="" selected disabled>__select_</option>
                                    <option value="Salads">Salads</option>
                                    <option value="Caviar">Caviar </option>
                                    <option value="Saumon Fume">Saumon Fume </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                            <div class=" d-flex justify-content-end mb-1 ">
                                <span class="badge badge-circle badge-outline-info" data-bs-toggle="modal" data-bs-target="#includeModal" ><span class=" fa fa-plus ml-3"></span></span>
                            </div>
                                <div class="multiselect border border-2">
                                        <div class="selectBox" onclick="toggleMyClass()" >
                                            <select class=" form-control">
                                                <option>Includes</option>
                                            </select>
                                            <div class="overSelect"></div>
                                        </div>
                                        <div id="checkboxes" class="checkboxes form-group d-block border border-0">
                                            <div class=" d-flex justify-content-between align-items-center">
                                                <span>Image</span> <span>description here</span><span> price</span><span class=" fa fa-times-circle"></span>
                                            </div>
                                            <div class=" d-flex justify-content-between align-items-center">
                                                <span>Image</span> <span>description here</span><span> price</span><span class=" fa fa-times-circle"></span>
                                            </div>
                                            <div class=" d-flex justify-content-between align-items-center">
                                                <span>Image</span> <span>description here</span><span> price</span><span class=" fa fa-times-circle"></span>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->
    <!-- modal for adding new dish ingrideint -->
    <div class="modal fade bd-example-modal-sm" id="includeModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" backdrop="false">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">includes</h5>
                   <span class=" badge badge-circle badge-outline-danger"> <span class=" fa fa-times " data-bs-toggle="modal" data-bs-target="#basicModal"></span></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-lg-12">
                            <div class="mb-3">
                                <label  class="text-black form-label" for="drink_image">Details <span class="required text-danger">*</span></label>
                                <input type="text" name="include_name" class=" form-control" placeholder="eg:Beet root"/>
                            </div>
                        </div>
                    <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="include_price" class="text-black form-label">Price <span class="required text-danger">*</span></label>
                                <div class="d-flex flex-row">
                                    <select name="include_currency" class=" form-control w-50">
                                        <option value="FRW">FRW</option>
                                        <option value="USD">USD</option>
                                    </select>
                                    <input type="number" class="form-control" value="" name="include_price" placeholder="Price here" id="include_price">
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label  class="text-black form-label" for="drink_image">Image <span class="required text-danger"></span></label>
                                <input type="file" name="drink_image" class=" form-control" accept="image/*" id="drink_image" />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3 text-center">
                                <button class="btn btn-outline-primary" type="button">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end -->
    <!-- include footer -->
    <?php include_once("./footer.php") ?>