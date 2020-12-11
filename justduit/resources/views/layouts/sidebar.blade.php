<div class="sidebar-section">
    @guest
        <a href="/">View All Shoe</a>
    @else
        @if (auth()->user()->role == 2)
            <a href="/shoes">View All Shoe</a>
            <button type="button" class="btn btn-primary position-relative test" style="margin-top: 20px">
                <a href="/cartIndex" style="color: white">View Cart</a>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{$count ?? '0'}}<span class="visually-hidden"></span></span>
            </button>
            <a href="/transaction">View Transaction</a>
        @else
            @if (auth()->user()->role == 1)
                <a href="/shoes">View All Shoe</a>
                <a href="/shoes/create">Add Shoe</a>
                <a href="">View All Transaction</a>
            @endif
        @endif
    @endguest
</div>
