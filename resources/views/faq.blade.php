@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="mb-4 fw-bold text-center">Frequently Asked Questions</h1>
        <p class="text-center text-muted mb-5">Have questions? We’re here to help you get the answers you need.</p>

        <div class="accordion" id="faqAccordion">

            <!-- Question 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeadingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseOne" aria-expanded="true" aria-controls="faqCollapseOne">
                        How do I create an artist profile?
                    </button>
                </h2>
                <div id="faqCollapseOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Simply register an account and navigate to your profile settings to choose “Artist” as your user type. From there, you can upload your artworks and manage your page.
                    </div>
                </div>
            </div>

            <!-- Question 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeadingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
                        How can I buy artwork?
                    </button>
                </h2>
                <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Browse through the Explore section or an artist’s page, then click “Buy” on any available artwork. You can securely checkout using your preferred payment method.
                    </div>
                </div>
            </div>

            <!-- Question 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeadingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseThree" aria-expanded="false" aria-controls="faqCollapseThree">
                        Is international shipping available?
                    </button>
                </h2>
                <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes, artists can choose to offer international shipping. Shipping options and pricing are visible on each artwork’s detail page before purchase.
                    </div>
                </div>
            </div>

            <!-- Question 4 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeadingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseFour" aria-expanded="false" aria-controls="faqCollapseFour">
                        How do I follow an artist?
                    </button>
                </h2>
                <div id="faqCollapseFour" class="accordion-collapse collapse" aria-labelledby="faqHeadingFour" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Go to an artist’s profile and click the “Follow” button. You’ll get updates when they publish new artwork or special offers.
                    </div>
                </div>
            </div>

            <!-- Question 5 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeadingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseFive" aria-expanded="false" aria-controls="faqCollapseFive">
                        Can I return a purchase?
                    </button>
                </h2>
                <div id="faqCollapseFive" class="accordion-collapse collapse" aria-labelledby="faqHeadingFive" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Returns are handled on a case-by-case basis. Please check our <a href="{{ route('terms-conditions') }}">Terms & Conditions</a> or contact support for help.
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<style>

/* Artify Accordion Custom Styles */

.accordion-button {
    background-color: #fff;
    color: #333;
    font-weight: 600;
    border: none;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
}

.accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, #ff7c5c, #ff4e9b);
    color: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.accordion-button::after {
    filter: invert(0.3);
    transition: transform 0.3s ease;
}

.accordion-button:not(.collapsed)::after {
    filter: invert(1);
    transform: rotate(180deg);
}

.accordion-item {
    border: none;
    border-radius: 12px;
    margin-bottom: 1rem;
    background-color: #fff;
    overflow: hidden;
}

.accordion-body {
    padding: 1.25rem 1.5rem;
    font-size: 15px;
    color: #555;
    background-color: #fdfdfd;
    border-top: 1px solid #eee;
    border-radius: 0 0 12px 12px;
}


</style>
@endsection
