<footer class="footer-section bg-white border-top pt-5">
    <div class="container">
        <!-- Footer link columns (centered) -->
        <div class="row justify-content-center text-center text-md-start gy-4 mb-4">
            <!-- Column 1 -->
            <div class="col-10 col-md-3">
                <h6 class="fw-bold mb-3">Artify</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('about-us') }}" class="footer-link">About Us</a></li>
                    <li><a href="#" class="footer-link">Jobs</a></li>
                    <li><a href="{{ route('paintings.explore') }}" class="footer-link">Artify galery</a></li>
                    <li><a href="{{ route('artist.index') }}" class="footer-link">Independent artists</a></li>
                </ul>
            </div>

            <!-- Column 2 -->
            <div class="col-10 col-md-3">
                <h6 class="fw-bold mb-3">Discover</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="footer-link">How It Works</a></li>
                    <li><a href="#" class="footer-link">Mobile Apps</a></li>
                    <li><a href="#" class="footer-link">Artist Directory</a></li>
                    <li><a href="#" class="footer-link">Gift Cards</a></li>
                </ul>
            </div>

            <!-- Column 3 -->
            <div class="col-10 col-md-3">
                <h6 class="fw-bold mb-3">Support</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('faq') }}" class="footer-link">Help Center</a></li>
                    <li><a href="#" class="footer-link">Selling Guide</a></li>
                    <li><a href="#" class="footer-link">Buying Tips</a></li>
                    <li><a href="#" class="footer-link">Trust & Safety</a></li>
                </ul>
            </div>
        </div>

        <!-- Social + Contact (tighter & centered) -->
        <div class="row justify-content-center text-center mb-4">
            <div class="col-12">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-3">
                    <!-- Social Icons -->
                    <div class="social-icons">
                        <a href="https://www.instagram.com/join.artify/" target="_blank" class="me-2"><i class="bi bi-facebook fs-3"></i></a>
                        <a href="https://www.instagram.com/join.artify/" target="_blank" class="me-2"><i class="bi bi-instagram fs-3"></i></a>
                        <a href="https://www.linkedin.com/company/weartify/" target="_blank"><i class="bi bi-linkedin fs-3"></i></a>
                    </div>

                    <!-- Divider or spacing (optional) -->
                    <span class="text-muted d-none d-md-inline">|</span>

                    <!-- Developer Contact -->
                    <div class="developer-credit small">
                        <span class="text-muted">Like the platform?</span>
{{--                        <a href="/contact" class="footer-link fw-semibold ms-1">Contact Us</a>--}}
                        <a href="mailto:webmaster@weartify.eu" class="footer-link fw-semibold ms-1">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="row small text-muted text-center mb-4">
            <div class="col">
                <a href="{{ route('privacy-policy') }}" class="footer-link me-3">Privacy Policy</a>
                <a href="{{ route('terms-conditions') }}" class="footer-link me-3">Terms & Conditions</a>
                <a href="#" class="footer-link me-3 cky-banner-element">Cookie Policy</a>
            </div>
            <div class="col-12 mt-2">
                <p class="mb-0">&copy; 2025 Artify. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
