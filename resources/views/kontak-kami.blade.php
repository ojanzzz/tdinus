@extends('layouts.app')

@section('content')
<section class="section section-muted">
    <div class="container">
        <h1 class="page-title">Kontak Kami</h1>
        <div class="grid-2">
            <div>
                <h3 class="section-subtitle">Hubungi Kami</h3>
                <form class="form-stack">
                    <input type="text" placeholder="Nama" class="form-input">
                    <input type="email" placeholder="Email" class="form-input">
                    <textarea placeholder="Pesan" rows="5" class="form-input"></textarea>
                    <button type="submit" class="btn-submit btn-block">Kirim Pesan</button>
                </form>
            </div>
            <div class="contact-card">
                <p>PT. Teras Digital Nusantara<br>Nggaro te, BTN Permata Hijau<br>Bima, NTB 84119</p>
                <iframe class="contact-map" src="https://www.google.com/maps/embed?..." loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>
@endsection
