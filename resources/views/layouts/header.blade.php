<div class="container-fluid py-2">
    <div class="app-header-content">
        <div class="user_name text-center">
            @if (Auth::check())
                {{ Auth::user()->name }}
            @else
                Chưa đăng nhập
            @endif
        </div>
    </div><!--//app-header-content-->
</div>
