@extends('layouts.app')

@section('title', 'Terms and Conditions')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <h1 class="fw-bold mb-4"><i class="bi bi-journal"></i> Terms and Conditions</h1>
            <p class="mb-5 text-muted">Effective Date: 01/10/2025</p>

            <h4 class="fw-semibold">1. Overview of Our Platform</h4>
            <p>Artify is an online marketplace that allows independent artists to create profiles, list and sell their original artworks, and interact with collectors and art enthusiasts.</p>

            <h4 class="fw-semibold mt-4">2. Eligibility</h4>
            <ul>
                <li>You must be at least 18 years old (or have legal guardian consent).</li>
                <li>You must create an account with accurate, complete information.</li>
                <li>You must comply with these Terms and all applicable laws.</li>
            </ul>
            <p>We reserve the right to suspend or terminate your account at any time for violations.</p>

            <h4 class="fw-semibold mt-4">3. User Accounts</h4>
            <p>You are responsible for maintaining the confidentiality of your login credentials and for all activity under your account. You may register as an:</p>
            <ul>
                <li>Artist</li>
                <li>Collector</li>
                <li>Buyer</li>
                <li>Other</li>
            </ul>

            <h4 class="fw-semibold mt-4">4. Artist Obligations</h4>
            <p>By listing artwork on Artify, you agree to:</p>
            <ul>
                <li>Only list original works you have created.</li>
                <li>Accurately describe your artworks and pricing.</li>
                <li>Fulfill orders promptly and securely.</li>
                <li>Ship items using the provided or recommended services.</li>
            </ul>

            <h4 class="fw-semibold mt-4">5. Purchasing Artworks</h4>
            <p>Buyers agree to:</p>
            <ul>
                <li>Pay for items using available payment methods.</li>
                <li>Provide accurate shipping information.</li>
                <li>Respect intellectual property rights of artists.</li>
            </ul>

            <h4 class="fw-semibold mt-4">6. Fees and Commissions</h4>
            <p>Artify may charge service fees or commissions for successful transactions. These will be clearly communicated before listing or purchase.</p>

            <h4 class="fw-semibold mt-4">7. Intellectual Property</h4>
            <p>All content on Artify, including branding, design, and user-submitted content (e.g., artwork images), is protected by copyright laws.</p>
            <ul>
                <li>Artists retain rights to their submitted works.</li>
                <li>By uploading content, you grant Artify a non-exclusive license to display and promote your work on the platform and in marketing materials.</li>
            </ul>

            <h4 class="fw-semibold mt-4">8. Prohibited Activities</h4>
            <p>You may not use Artify to:</p>
            <ul>
                <li>Infringe on copyright or intellectual property.</li>
                <li>Post false or misleading content.</li>
                <li>Transmit spam, malware, or harmful content.</li>
                <li>Harass or impersonate others.</li>
                <li>Circumvent our systems or fees.</li>
            </ul>

            <h4 class="fw-semibold mt-4">9. Privacy</h4>
            <p>We value your privacy. Please refer to our <a href="{{ url('/privacy-policy') }}">Privacy Policy</a> to learn how we handle your personal data.</p>

            <h4 class="fw-semibold mt-4">10. Termination</h4>
            <p>You may delete your account at any time. Artify reserves the right to terminate accounts for violating terms or misusing the platform.</p>

            <h4 class="fw-semibold mt-4">11. Limitation of Liability</h4>
            <p>Artify is not liable for:</p>
            <ul>
                <li>User content or conduct.</li>
                <li>Damaged, lost, or delayed shipments.</li>
                <li>Disputes between users.</li>
            </ul>
            <p>Use of the platform is at your own risk. We provide the site “as is” without warranties.</p>

            <h4 class="fw-semibold mt-4">12. Changes to These Terms</h4>
            <p>We may update these Terms at any time. Continued use of Artify after changes are posted constitutes your acceptance of the new terms.</p>

            <h4 class="fw-semibold mt-4">13. Contact Us</h4>
            <p>If you have questions, please contact us at <a href="mailto:webmaster@weartify.eu">webmaster@weartify.eu</a>.</p>
        </div>
    </section>
@endsection
