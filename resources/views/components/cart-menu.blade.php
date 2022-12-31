<div class="cart-items">
    <a href="javascript:void(0)" class="main-btn">
        <i class="lni lni-cart"></i>
        <span class="total-items">{{ $cart->count() }}</span>
    </a>
    <!-- Shopping Item -->
    <div class="shopping-item">
        <div class="dropdown-cart-header">
            <span>{{ $cart->count() }} Items</span>
            <a href="cart.html">View Cart</a>
        </div>
        <ul class="shopping-list">
            @foreach ($cart->get() as $item)
            <li>
                <a href="javascript:void(0)" class="remove" title="Remove this item"><i class="lni lni-close"></i></a>
                <div class="cart-img-head">
                    <a class="cart-img" href="{{ $item->product->url }}">
                        <img src="{{ $item->product->image_url }}" alt="#"></a>
                </div>

                <div class="content">
                    <h4><a href="{{ $item->product->url }}">
                            {{ $item->product->name }}</a></h4>
                    <p class="quantity">{{ $item->quantity }}x - <span class="amount">{{ Money::format($item->quantity * $item->product->price) }}</span></p>
                </div>
            </li>
            @endforeach
        </ul>
        <div class="bottom">
            <div class="total">
                <span>Total</span>
                <span class="total-amount">{{ Money::format($cart->total()) }}</span>
            </div>
            <div class="button">
                <a href="{{ route('checkout') }}" class="btn animate">Checkout</a>
            </div>
        </div>
    </div>
    <!--/ End Shopping Item -->
</div>