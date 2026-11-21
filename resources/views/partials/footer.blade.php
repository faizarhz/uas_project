<footer>
    <div>
        <div class="logo"><b style="font-size:24px;letter-spacing:.14em">BEVERLY</b></div>
        <p style="margin-top:12px;max-width:340px">Toko karpet dan ambal premium untuk menghadirkan kehangatan dan keindahan di setiap ruang rumah Anda.</p>
        <div class="soc"><span>&#128172;</span><span>&#9711;</span><span>&#9993;</span></div>
    </div>
    <div>
        <h5>Navigasi</h5>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('products') }}">Produk</a>
        <a href="{{ route('about') }}">About Us</a>
        <a href="{{ route('contact') }}">Kontak</a>
        <a href="{{ route('login') }}">Login</a>
    </div>
    <div>
        <h5>Kategori</h5>
        @foreach (\App\Support\Catalog::categories()->take(5) as $c)
            <a href="{{ route('products', ['cat' => $c['name']]) }}">{{ $c['name'] }}</a>
        @endforeach
    </div>
    <div>
        <h5>Hubungi Kami</h5>
        <a>&#9742; +62 812-3456-7890</a>
        <a>&#9993; halo@beverly-karpet.id</a>
        <a>&#9906; Jl. Karpet Indah No. 18, Jakarta</a>
    </div>
</footer>
