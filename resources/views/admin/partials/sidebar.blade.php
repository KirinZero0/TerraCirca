<aside id="sidebar-wrapper">
    <div class="sidebar-brand mb-5">
        <a href="{{ url('/') }}">
            <img width="100" src="{{ asset('assets/images/logo/Clinic.png') }}" alt="">
        </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ url('/') }}">
            <img width="40" src="{{ asset('assets/images/logo/Clinic.png') }}" alt="">
        </a>
    </div>
    <ul class="sidebar-menu">
            <li {{ is_nav_active('dashboard') }}>
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            @can('admin')
            <li {{ is_nav_active('admin/admin') }}>
                <a class="nav-link" href="{{ route('admin.admin.index') }}">
                    <i class="fas fa-user"></i> <span>User</span>
                </a>
            </li>
            @endcan
            <li {{ is_nav_active('patient') }}>
                <a class="nav-link" href="{{ route('admin.patient.index') }}">
                    <i class="fas fa-users"></i> <span>Patient</span>
                </a>
            </li>
        <li {{ is_nav_active('transaction') }}>
            <a class="nav-link" href="{{ route('admin.transaction.index') }}">
                <i class="fas fa-scroll"></i> <span>Transaction</span>
            </a>
        </li>
        @can('admin')
        <li {{ is_nav_active('supplier') }}>
            <a class="nav-link" href="{{ route('admin.supplier.index') }}">
                <i class="fas fa-users"></i> <span>Supplier</span>
            </a>
        </li>
        <li class="dropdown {{ is_drop_active('product') }}">
            <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-box"></i> <span>Product</span>
            </a>
            <ul class="dropdown-menu">
                        <li {{ is_nav_active('product_list') }}>
                            <a class="nav-link" href="{{ route('admin.product.product_list.index') }}">
                                <i class="far fa-circle"></i> Master Product
                            </a>
                        </li>
                        <li {{ is_nav_active('product_stock') }}>
                            <a class="nav-link" href="{{ route('admin.product.product_stock.index') }}">
                                <i class="far fa-circle"></i> Product Stock
                            </a>
                        </li>
                        {{-- <li {{ is_nav_active('masuk') }}>
                            <a class="nav-link" href="{{ route('admin.barang.masuk.index') }}">
                                <i class="far fa-circle"></i> Barang Masuk
                            </a>
                        </li> --}}
                        <li {{ is_nav_active('product_in') }}>
                            <a class="nav-link" href="{{ route('admin.product.product_in.index') }}">
                                <i class="far fa-circle"></i> Product In
                            </a>
                        </li>
                        <li {{ is_nav_active('product_out') }}>
                            <a class="nav-link" href="{{ route('admin.product.product_out.index') }}">
                                <i class="far fa-circle"></i> Product Out
                            </a>
                        </li>
                        <li {{ is_nav_active('product_category') }}>
                            <a class="nav-link" href="{{ route('admin.product.product_category.index') }}">
                                <i class="far fa-circle"></i> Categories
                            </a>
                        </li>
            </ul>
        </li>
        @endcan
        <li class="dropdown {{ is_drop_active('laporan') }}" >
            <a class="nav-link has-dropdown" href="#">
                <i class="fas fa-folder-open"></i> <span>Report</span>
            </a>
            <ul class="dropdown-menu">
                <li {{ is_nav_active('masuk') }}>
                    <a class="nav-link" href="{{ route('admin.laporan.masuk.index') }}">
                        <i class="far fa-circle"></i> Product In
                    </a>
                </li>
                <li {{ is_nav_active('keluar') }}>
                    <a class="nav-link" href="{{ route('admin.laporan.keluar.index') }}">
                        <i class="far fa-circle"></i> Product Out
                    </a>
                </li>
                <li {{ is_nav_active('transaksi') }}>
                    <a class="nav-link" href="{{ route('admin.laporan.transaksi.index') }}">
                        <i class="far fa-circle"></i> Transaction
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
