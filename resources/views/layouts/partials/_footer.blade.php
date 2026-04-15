<footer id="colophon">
    <div class="site-middle-footer-wrap">
        <div class="site-footer-row-container-inner site-container">
            <div class="site-middle-footer-inner-wrap footer-widgets">
                <div class="footer-widget">
                    <h3>Tentang Kami</h3>
                    <p>Teras Digital Nusantara adalah perusahaan yang bergerak di bidang pengembangan teknologi informasi dan transformasi digital. Kami fokus pada publikasi ilmiah, jurnal, dan pelatihan.</p>
                </div>
                <div class="footer-widget">
                    <h3>Layanan Kami</h3>
                    <ul>
                        @php
                            $services = $services ?? \App\Models\Service::take(4)->get();
                        @endphp
                        @forelse($services as $service)
                            <li><a href="/layanan-kami">{{ $service->name }}</a></li>
                        @empty
                            <li>Publikasi Hasil Penelitian</li>
                            <li>Publikasi Hasil PKM</li>
                            <li>Program Pelatihan</li>
                            <li>Publikasi Buku</li>
                        @endforelse
                    </ul>
                </div>
                <div class="footer-widget">
                    <h3>Alamat Perusahaan</h3>
                    <p>PT. Teras Digital Nusantara<br>Nggaro te, lingkungan BTN permata Hijau<br>Bima, NTB</p>
                    <div class="footer-map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.570226735!2d118.721!3d-8.466!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNMKwMjcnNTcuNiJTIDEyMCDGsMcmw0OS4zIkU!5e0!3m2!1sen!2sus!4v173!5m2!1sen!2sus" 
                                width="100%" height="120" style="border:0; border-radius: 0.5rem;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="footer-social">
                    <h3>Follow Us</h3>
                    <div class="footer-social-list">
                        <a href="https://facebook.com/tdinus" target="_blank" class="footer-social-link facebook" aria-label="Facebook" rel="noopener">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="social-icon" width="22" height="22">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://instagram.com/tdinus" target="_blank" class="footer-social-link instagram" aria-label="Instagram" rel="noopener">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="social-icon" width="22" height="22">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                                <circle cx="12" cy="12" r="4"/>
                                <circle cx="18.016" cy="5.984" r="1.016"/>
                            </svg>
                        </a>
                        <a href="https://x.com/tdinus" target="_blank" class="footer-social-link x" aria-label="X" rel="noopener">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="social-icon" width="22" height="22">
                                <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="site-bottom-footer-wrap site-bottom-footer">
        <p>&copy; {{ date('Y') }} Teras Digital Nusantara. All rights reserved. | <a href="#" class="footer-link">Privacy Policy</a></p>
    </div>
</footer>

<style>
.footer-social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: white;
    font-size: 20px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    text-decoration: none;
}

.footer-social-link:hover {
    transform: translateY(-3px) scale(1.1);
    background: rgba(255, 255, 255, 0.2);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
}

.footer-social-link.facebook:hover { background: linear-gradient(45deg, #1877f2, #4267B2); }
.footer-social-link.instagram:hover { background: linear-gradient(45deg, #e4405f, #f77737); }
.footer-social-link.x:hover { background: linear-gradient(45deg, #000, #1d9bf0); }

.social-icon {
    width: 22px;
    height: 22px;
    flex-shrink: 0;
}
</style>
