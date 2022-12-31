@extends('layouts.front')

@section('title', 'Checkout')

@section('breadcrumb')
    @parent
    <li>Checkout</li>
@endsection

@section('content')
<!--====== Checkout Form Steps Part Start ======-->

<form action="{{ route('checkout') }}" method="post">
    @csrf
    <section class="checkout-wrapper section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="checkout-steps-form-style-1">
                        <ul id="accordionExample">
                            <li>
                                <h6 class="title" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                    aria-expanded="true" aria-controls="collapseThree">Your Personal Details </h6>
                                <section class="checkout-steps-form-content collapse show" id="collapseThree"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <label>User Name</label>
                                                <div class="row">
                                                    <div class="col-md-6 form-input form">
                                                        <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name">
                                                    </div>
                                                    <div class="col-md-6 form-input form">
                                                        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Email Address</label>
                                                <div class="form-input form">
                                                    <input type="text" name="email" value="{{ old('email') }}" placeholder="Email Address">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Phone Number</label>
                                                <div class="form-input form">
                                                    <input type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="Phone Number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <label>Mailing Address</label>
                                                <div class="form-input form">
                                                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Mailing Address">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>City</label>
                                                <div class="form-input form">
                                                    <input type="text" name="city" value="{{ old('city') }}" placeholder="City">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Post Code</label>
                                                <div class="form-input form">
                                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" placeholder="Post Code">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Country</label>
                                                <div class="select-items">
                                                    <select name="country" class="form-control">
                                                        <option value="0">select</option>
                                                        @foreach($countries as $code => $name)
                                                        <option value="{{ $code }}" @selected($code == old('country'))>{{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-checkbox checkbox-style-3">
                                                <input type="checkbox" id="checkbox-3">
                                                <label for="checkbox-3"><span></span></label>
                                                <p>My delivery and mailing addresses are the same.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-form button">
                                                <button type="submit" class="btn">Submit Order</button>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="checkout-sidebar">
                        <div class="checkout-sidebar-coupon">
                            <p>Appy Coupon to get discount!</p>
                            <form action="#">
                                <div class="single-form form-default">
                                    <div class="form-input form">
                                        <input type="text" placeholder="Coupon Code">
                                    </div>
                                    <div class="button">
                                        <button class="btn">apply</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="checkout-sidebar-price-table mt-30">
                            <h5 class="title">Pricing Table</h5>

                            <div class="sub-total-price">
                                <div class="total-price">
                                    <p class="value">Subotal Price:</p>
                                    <p class="price">$144.00</p>
                                </div>
                                <div class="total-price shipping">
                                    <p class="value">Subotal Price:</p>
                                    <p class="price">$10.50</p>
                                </div>
                                <div class="total-price discount">
                                    <p class="value">Subotal Price:</p>
                                    <p class="price">$10.00</p>
                                </div>
                            </div>

                            <div class="total-payable">
                                <div class="payable-price">
                                    <p class="value">Subotal Price:</p>
                                    <p class="price">{{ Money::format($cart->total()) }}</p>
                                </div>
                            </div>
                            <div class="price-table-btn button">
                                <button type="submit" class="btn btn-alt">Checkout</button>
                            </div>
                        </div>
                        <div class="checkout-sidebar-banner mt-30">
                            <a href="product-grids.html">
                                <img src="https://via.placeholder.com/400x330" alt="#">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--====== Checkout Form Steps Part Ends ======-->
</form>

@endsection