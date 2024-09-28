<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - {{ config('app.name', $settings->site_name) }}</title>
    <!-- meta -->
    <meta name="robots" content="index,follow">
    <meta name="googlebot" content="index,follow">
    <meta name="author" content="Rabin Mia, Md. Shakib Hossain Rijon" />
    <meta name="Developed By" content="Arobil Ltd" />
    <meta name="Developer" content="Arobil Team" />
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $settings->seo_meta_description }}">
    <meta property="og:image" content="{{getPhoto($settings->site_logo)}}" />
    <meta property="og:site_name" content="{{ config('app.name', $settings->site_name) }}">
    <meta property="og:title" content="Home - {{ config('app.name', $settings->site_name) }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="article">
    <meta property="og:description" content="{{ $settings->seo_meta_description }}">
    <!-- favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{getPhoto($settings->favicon)}}" />
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css?v=3.6') }}">
</head>

<body>

    {{-- Header --}}
    <div class="header_sec">
        <div class="container">
            <nav class="navbar navbar-expand-lg p-0">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('home2') }}">
                        <img src="{{ asset('/images/logo.png') }}"  alt="MVCGROUP">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav ms-auto pb-4 pt-4 pt-lg-0 pb-lg-0">
                            <a class="nav-link" href="{{ route('home2') }}">Home</a>
                            <a class="nav-link" href="#about">About</a>
                            <a class="nav-link" href="#pricing">Pricing</a>
                            <div class="dropdown">
                                <button class="nav-link bg-transparent border-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Resources
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Recources 1</a></li>
                                    <li><a class="dropdown-item" href="#">Recources 2</a></li>
                                    <li><a class="dropdown-item" href="#">Recources 3</a></li>
                                    <li><a class="dropdown-item" href="#">Recources 4</a></li>
                                    <li><a class="dropdown-item" href="#">Recources 5</a></li>
                                </ul>
                            </div>
                            <a class="btn btn-dark rounded-pill px-4 py-2 d-inline ms-3" href="{{ route('login') }}">Login</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    {{-- Header --}}

    {{-- banner --}}
    <div class="banner_section pt-5 pb-5">
        <div class="container">
            <div class="row gy-4 gy-lg-0 d-flex align-items-center">
                <div class="col-lg-6">
                    <div class="banner_content">
                        <h4 class="mb-3">Cyber Incident <br> Response Portal</h4>
                        <p class="mb-4">Inspired by the military?s DEFCON system, defcon-app.com lets you create custom alert levels and instantly notify your team via SMS during a cyber crisis.
                        </p>
                        <div class="">
                            <a href="#" class="btn btn-dark px-4 py-2 me-2 rounded-pill">Free Trial</a>
                            <a href="#" class="btn btn-light px-4 py-2 rounded-pill">Sign Up</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="banner_img">
                        <img src="{{ asset('images/banner.png') }}" class="img-fluid rounded" alt="Cyber Incident Response Portal">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- banner --}}

    {{-- freatures --}}
    <div class="features_section pt-5 pb-5">
        <div class="container">
            <div class="row gy-4 gy-lg-0 text-center">
                <div class="col-md-6 col-lg-4">
                    <div class="features_card h-100 card p-4 rounded">
                        <div class="feature_img">
                            <img src="{{ asset('images/lock.png') }}" class="img-fluid" alt="A cloud with a secure lock">
                        </div>
                        <div class="content">
                            <h4>A cloud with a secure lock</h4>
                            <p>
                                Externally hosted platform ensures access even if your
                                network is compromised
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features_card h-100 card p-4 rounded">
                        <div class="feature_img">
                            <img src="{{ asset('images/notification.png') }}" class="img-fluid" alt="A notification bubble or message icon">
                        </div>
                        <div class="content">
                            <h4>A notification bubble or message icon</h4>
                            <p>
                                Secure portal with configurable alerts and notifications
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features_card h-100 card p-4 rounded">
                        <div class="feature_img">
                            <img src="{{ asset('images/large-screen.png') }}" class="img-fluid" alt="A large screen display">
                        </div>
                        <div class="content">
                            <h4>A large screen display</h4>
                            <p>
                                <strong>War Room Ready:</strong> Centralized dashboard for large
                                diaplays
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- freatures --}}

    {{-- sms section --}}
    <div class="sms_section py-5">
        <div class="container">
            <div class="row gy-4 gy-lg-0 d-flex align-items-center">
                <div class="col-lg-6">
                    <div class="">
                        <img src="{{ asset('images/sms.png') }}" class="img-fluid" alt="Stay Ready, Take Action">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="sms_content">
                        <h4>Stay Ready, Take Action</h4>
                        <p>
                            When facing a cyber attack, having a clear method to escalate or de-escalate alarm levels and alert teams is essential. Our portal provides a secure, independent platform to quickly notify key personnel, ensuring everyone knows what actions to take as the situation evolves.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- sms section --}}

    {{-- pricing --}}
    <div class="pricing_section mb-5 bg-light py-5 border-top border-bottom border-light border-light-subtle" id="pricing">
        <div class="container">
            <div class="section_heading text-center mb-5">
                <h4>Choose Your Best Fit</h4>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-lg-9 col-xl-6">
                    <div class="row gy-4 gy-md-0">
                        <div class="col-md-6">
                            <div class="pricing card h-100">
                                <div class="pricing_header">
                                    <h4>Standard</h4>
                                </div>
                                <div class="features mb-4">
                                    <ul>
                                        <li>
                                            <img src="{{ asset('images/check.svg') }}" alt="check">
                                            Setup: <strong>€450</strong> (one-time fee)
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/check.svg') }}" alt="check">
                                            Annual Subscription: <strong>€1,275</strong>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/check.svg') }}" alt="check">
                                            SMS Package: <strong>€75</strong> per <strong>500</strong> SMSs
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/check.svg') }}" alt="check">
                                            Up to 10 users
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/check.svg') }}" alt="check">
                                            Onboarding
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/check.svg') }}" alt="check">
                                            Email support
                                        </li>
                                    </ul>
                                </div>
                                <div class="buy_btn mt-auto">
                                    <a href="#" class="py-2 btn btn-primary d-block">Buy Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pricing card h-100">
                                <div class="pricing_header">
                                    <h4>Premium</h4>
                                </div>
                                <div class="features mb-4">
                                    <ul> 
                                        <li>
                                            <img src="{{ asset('images/check.svg') }}" alt="check">
                                             Setup: <strong>€450</strong> (one-time fee)
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/check.svg') }}" alt="check">
                                            Annual Subscription: <strong>€2,475</strong>
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/check.svg') }}" alt="check">
                                            SMS Package: <strong>€50</strong> per 500 SMSs
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/check.svg') }}" alt="check">
                                            Unlimited users
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/check.svg') }}" alt="check">
                                            Onboarding
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/check.svg') }}" alt="check">
                                            Priority support
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/check.svg') }}" alt="check">
                                            Incident response training
                                        </li>
                                        <li>
                                            <img src="{{ asset('images/check.svg') }}" alt="check">
                                            Annual Health Check
                                        </li>
                                    </ul>
                                </div>
                                <div class="buy_btn mt-auto">
                                    <a href="#" class="py-2 btn btn-primary d-block">Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- pricing --}}

    {{-- about --}}
    <div class="about_section pb-5" id="about">
        <div class="container">
            <div class="section_heading text-center mb-5">
                <h4>About Us</h4>
            </div>
            <div class="about_content text-center">
                <h5>
                    We help small and medium-sized companies with their cybersecurity incident response
                    processes.
                </h5>
                <p>
                    Our goal is to save you critical time when under attack by creating a common understanding of your
                    alarm levels and notifying your response teams with just a few clicks. Whether you're escalating or
                    de-escalating an incident, our platform ensures everyone knows what actions to take, minimizing
                    confusion and maximizing efficiency.
                </p>
                <h5>We are much more than just a platform.</h5>
                <p>
                    We focus on providing ongoing support to help you structure, test, and optimize your incident response
                    teams. Our aim is to equip your organization with the tools and strategies needed to respond effectively
                    during any cybersecurity crisis.
                </p>
                <p>
                    We are proudly based in Denmark and committed to serving businesses locally and beyond. To learn
                    more about how we can support your business, contact us today. We?re here to help you stay prepared.
                </p>
            </div>
        </div>
    </div>
    {{-- about --}}


    {{-- contact --}}
    <div class="contact_section mb-5">
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="col-xl-9">
                    <div class="contact_form">
                        <div class="section_heading text-center mb-4">
                            <h4>Get in Touch</h4>
                        </div>
                        <form action="#" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" required placeholder="Enter your name">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required placeholder="Enter your email">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Message</label>
                                <textarea name="" id="" cols="30" class="form-control" rows="5" style="height: 115px;" required placeholder="Write your message"></textarea>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- contact --}}

    {{-- footer --}}
    <footer class="footer_sec py-3">
        <div class="container">
            <div class="d-lg-flex align-items-center justify-content-between">
                <div class="order-lg-2 mb-4 mb-lg-0 text-center footer_logo">
                    <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="">
                </div>
                <div class="copyright order-lg-1 mb-4 mb-lg-0 text-center text-lg-end">
                    <p class="m-0">
                        Copyright 2024 defcon-app.com All Rights Reserved
                    </p>
                </div>

                <div class="order-lg-3 mb-4 mb-lg-0 text-lg-end">
                    <div class="footer_menu">
                        <ul class="m-0 d-flex align-items-center justify-content-center justify-content-lg-end">
                            <li class="me-3">
                                <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Your privacy is important to us. We only collect the contact information submitted by visitors, which is used solely for the purposes for which it was provided. We are committed to maintaining the confidentiality and security of this data and take appropriate measures to protect it from unauthorized access, alteration, or disclosure.">Privacy Policy</a>
                            </li>
                            <li><a href="#">Support</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    {{-- footer --}}

    {{-- scroll to top --}}
    <div class="scroll_top">
        <i class="fa fa-angle-up"></i>
    </div>




    <!-- js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    </script>
    <script>
        $(document).ready(function() {
            // Show or hide the scroll button
            $(window).scroll(function() {
                if ($(this).scrollTop() > 500) {
                    $('.scroll_top').fadeIn();
                } else {
                    $('.scroll_top').fadeOut();
                }
            });
            // Scroll to top when the button is clicked
            $('.scroll_top').click(function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 1);
                return false;
            });
        });

    </script>

</body>

</html>
