<div class="sidebar-section">
    @guest
        <a href="/">View All Shoe</a>
    @else
        @if (auth()->user()->role == 2)
            <a href="/shoes">View All Shoe</a>
            <a href="/cartIndex">View Cart</a>
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
