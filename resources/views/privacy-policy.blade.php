@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <h1 class="mb-4">Artify Privacy Policy</h1>
            <p class="text-muted">Last updated: <strong>29.10.2025</strong></p>

            <h4 class="mt-5">1. Who We Are</h4>
            <p>
                Artify is a peer-to-peer marketplace based in Berlin, Germany, designed for independent artists and art buyers.
                Our mission is to empower artists to showcase, sell, and grow their work, while enabling buyers to discover and support creators.
                <br>
                Company legal form: <em>Artify GmbH</em>.
            </p>
            <p>
                We are the data controller responsible for your personal data under the General Data Protection Regulation (GDPR).
            </p>

            <h4 class="mt-4">2. What Data We Collect</h4>
            <ul>
                <li><strong>Account Information:</strong> Name, email, password, role (artist or buyer), address (for delivery).</li>
                <li><strong>Artist Profiles:</strong> Bio, profile picture, social links, artworks uploaded.</li>
                <li><strong>Transactions:</strong> Payment details (processed by providers like PayPal, Stripe), order history, shipping address.</li>
                <li><strong>Shipping Data:</strong> Delivery address, courier tracking numbers, shipping labels.</li>
                <li><strong>Usage Data:</strong> Browsing activity, favorites/wishlist, messages, notifications.</li>
                <li><strong>Device & Technical Data:</strong> IP address, browser type, cookies, analytics data.</li>
                <li><strong>Support Communication:</strong> Emails, contact form submissions, feedback.</li>
            </ul>

            <h4 class="mt-4">3. How We Use Your Data</h4>
            <p>We process your personal data for the following purposes:</p>
            <ul>
                <li>To provide and improve our services.</li>
                <li>To enable transactions, payments, and shipping.</li>
                <li>To protect buyers with escrow and buyer protection fees.</li>
                <li>To create and manage your account.</li>
                <li>To prevent fraud, misuse, or illegal activities.</li>
                <li>To provide customer support.</li>
                <li>To communicate updates, service changes, or promotional offers (if you consent).</li>
                <li>To comply with legal and regulatory obligations.</li>
            </ul>

            <h4 class="mt-4">4. Legal Basis for Processing</h4>
            <p>We rely on the following legal grounds under GDPR:</p>
            <ul>
                <li><strong>Contract performance (Art. 6(1)(b)):</strong> To provide our marketplace services.</li>
                <li><strong>Legitimate interest (Art. 6(1)(f)):</strong> To improve services, prevent fraud, ensure safety.</li>
                <li><strong>Consent (Art. 6(1)(a)):</strong> For marketing communications and cookies.</li>
                <li><strong>Legal obligation (Art. 6(1)(c)):</strong> To comply with tax, anti-money laundering, and consumer protection laws.</li>
            </ul>

            <h4 class="mt-4">5. How We Share Your Data</h4>
            <p>We may share your data with:</p>
            <ul>
                <li>Payment providers: PayPal, Stripe, or other secure processors.</li>
                <li>Shipping providers: To generate prepaid labels and deliver artworks.</li>
                <li>Service providers: IT hosting, analytics, and communication tools.</li>
                <li>Legal authorities: When required by law or to prevent fraud and abuse.</li>
                <li>Other Artify users: Limited data (e.g., your name, shipping address) to complete a transaction.</li>
            </ul>
            <p><strong>We never sell your personal data.</strong></p>

            <h4 class="mt-4">6. International Data Transfers</h4>
            <p>
                Your data may be transferred outside the European Economic Area (EEA).
                In such cases, we ensure adequate safeguards, such as EU Standard Contractual Clauses, are in place.
            </p>

            <h4 class="mt-4">7. How Long We Keep Your Data</h4>
            <ul>
                <li><strong>Account data:</strong> As long as you maintain an account.</li>
                <li><strong>Transaction data:</strong> Up to 10 years (as required by German tax law).</li>
                <li><strong>Communications:</strong> Typically 3 years.</li>
                <li><strong>Cookies:</strong> According to their lifespan or until you delete them.</li>
            </ul>

            <h4 class="mt-4">8. Your Rights</h4>
            <p>Under GDPR, you have the right to:</p>
            <ul>
                <li>Access your personal data.</li>
                <li>Correct inaccurate data.</li>
                <li>Delete your data (“right to be forgotten”).</li>
                <li>Restrict or object to processing.</li>
                <li>Port your data to another service.</li>
                <li>Withdraw consent at any time.</li>
                <li>Lodge a complaint with your local Data Protection Authority.</li>
            </ul>

            <h4 class="mt-4">9. Cookies and Tracking</h4>
            <p>We use cookies and similar technologies to:</p>
            <ul>
                <li>Keep you logged in.</li>
                <li>Improve user experience.</li>
                <li>Analyze platform usage.</li>
                <li>Offer personalized recommendations.</li>
            </ul>
            <p>You can manage or disable cookies in your browser settings.</p>

            <h4 class="mt-4">10. Security</h4>
            <p>
                We use industry-standard measures (encryption, secure payments, access control) to protect your personal data.
                However, no system is 100% secure, and you share data at your own risk.
            </p>

            <h4 class="mt-4">11. Children’s Privacy</h4>
            <p>
                Artify is not intended for children under 16. We do not knowingly collect personal data from minors.
            </p>

            <h4 class="mt-4">12. Changes to this Policy</h4>
            <p>
                We may update this Privacy Policy from time to time.
                The latest version will always be available on our website.
                Significant changes will be communicated to registered users.
            </p>

            <h4 class="mt-4">13. Contact Us</h4>
            <p>If you have any questions or concerns about this Privacy Policy, please contact us at:</p>
            <p>
                <strong>Artify</strong><br>
                Email: <em>infoartifyber@gmail.com</em><br>
                Address: <em>Herrfuthplatz, 03 - 12049, Berlin, Germany</em>
            </p>
        </div>
    </section>
@endsection
