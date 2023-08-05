<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="" target="_blank">
            <img src="../assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo" />
            <span class="ms-1 font-weight-bold text-white">Management Barang</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2" />
    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ ($title === 'Barang') ? 'active bg-gradient-success' : '' }}" href="../barang">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-box"></i>
                    </div>
                    <span class="nav-link-text ms-1">Barang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ ($title === 'Pembelian') ? 'active bg-gradient-success' : '' }}" href="../pembelian">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pembelian</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ ($title === 'Penjualan') ? 'active bg-gradient-success' : '' }}" href="../penjualan">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-cash-register"></i>
                    </div>
                    <span class="nav-link-text ms-1">Penjualan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ ($title === 'Supplier') ? 'active bg-gradient-success' : '' }}" href="../supplier">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <span class="nav-link-text ms-1">Supplier</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ ($title === 'Kategori Barang') ? 'active bg-gradient-success' : '' }}" href="../kategoribarang">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-list"></i>
                    </div>
                    <span class="nav-link-text ms-1">Kategori Barang</span>
                </a>
            </li>
        </ul>
    </div>
</aside>