<!DOCTYPE html>
<html>
<head>
    <title>Inventory System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Add this in your layout (layouts.app) if missing -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="{{ asset('js/item.js') }}"></script>

</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-dark text-white p-3" style="width: 220px; min-height: 100vh;">
        <h4 class="mb-4">Dashboard</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link text-white">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/items') }}" class="nav-link text-white">
                    <i class="bi bi-box"></i> Items
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/brands') }}" class="nav-link text-white">
                    <i class="bi bi-tags"></i> Brands
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/models') }}" class="nav-link text-white">
                    <i class="bi bi-puzzle"></i> Models
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="p-4" style="width: 100%;">
        <!-- Dashboard Boxes -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5><i class="bi bi-box"></i> Items</h5>
                        <a href="{{ url('/items') }}" class="btn btn-light mt-2">Manage Items</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5><i class="bi bi-tags"></i> Brands</h5>
                        <a href="{{ url('/brands') }}" class="btn btn-light mt-2">Manage Brands</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5><i class="bi bi-puzzle"></i> Models</h5>
                        <a href="{{ url('/models') }}" class="btn btn-light mt-2">Manage Models</a>
                    </div>
                </div>
                <!-- Cart Icon with Count -->
<a href="{{ route('cart') }}" style="float: right; margin-right: 20px;">
    🛒 Cart (<span id="cart-count">{{ $cartCount }}</span>)
</a>

            </div>
        </div>

        <!-- Page Specific Content -->
        @yield('content')
    </div>
</div>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 JS (for Modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
