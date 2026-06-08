<x-app-layout
    title="Contact Us - AdMandi Support"
    meta-description="Get in touch with the AdMandi customer support team. Send your inquiries, feedback, or report technical issues."
>
    {{-- Breadcrumbs --}}
    <div class="pt-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Contact Us') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold mb-3 gradient-text">{{ __('Contact Us') }}</h1>
                <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">
                    {{ __('Have questions, feedback, or need assistance? We are here to help you 24/7.') }}
                </p>
            </div>

            <div class="row g-5">
                {{-- Contact Details --}}
                <div class="col-lg-5">
                    <h3 class="fw-bold mb-4 text-primary">{{ __('Get in Touch') }}</h3>
                    
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-primary-subtle text-primary rounded-3 p-3 me-3">
                            <i class="bi bi-geo-alt-fill fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">{{ __('Our Location') }}</h5>
                            <p class="text-muted mb-0">{{ __('AdMandi Headquarters, Phase 8, Industrial Area, Sector 73, Mohali, Punjab, India') }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-primary-subtle text-primary rounded-3 p-3 me-3">
                            <i class="bi bi-envelope-fill fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">{{ __('Email Support') }}</h5>
                            <p class="text-muted mb-1"><a href="mailto:support@admandi.com" class="text-decoration-none text-muted">support@admandi.com</a></p>
                            <p class="text-muted mb-0"><a href="mailto:info@admandi.com" class="text-decoration-none text-muted">info@admandi.com</a></p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="bg-primary-subtle text-primary rounded-3 p-3 me-3">
                            <i class="bi bi-telephone-fill fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">{{ __('Call Support') }}</h5>
                            <p class="text-muted mb-1">+91 (172) 555-0199</p>
                            <p class="text-muted mb-0">+91 98765-43210</p>
                        </div>
                    </div>
                </div>

                {{-- Contact Form --}}
                <div class="col-lg-7">
                    <div class="p-4 rounded-4 bg-light border">
                        <h3 class="fw-bold mb-4 text-dark">{{ __('Send a Message') }}</h3>
                        
                        <div id="contactSuccessMessage" class="alert alert-success border-0 rounded-3 p-3 mb-4 d-none">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ __('Thank you for contacting us! Your message has been sent successfully. We will get back to you shortly.') }}
                        </div>

                        <form id="contactForm" onsubmit="event.preventDefault(); submitContactForm();">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-dark small fw-bold">{{ __('Full Name') }}</label>
                                    <input type="text" class="form-control bg-white" placeholder="{{ __('Enter your name') }}" required id="contactName">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark small fw-bold">{{ __('Email Address') }}</label>
                                    <input type="email" class="form-control bg-white" placeholder="{{ __('Enter your email') }}" required id="contactEmail">
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-dark small fw-bold">{{ __('Subject') }}</label>
                                    <input type="text" class="form-control bg-white" placeholder="{{ __('Enter subject') }}" required id="contactSubject">
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-dark small fw-bold">{{ __('Message') }}</label>
                                    <textarea class="form-control bg-white" rows="5" placeholder="{{ __('Describe your inquiry in detail...') }}" required id="contactMessage"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="theme-btn w-100 py-2.5 fw-semibold">
                                        <i class="bi bi-send-fill me-2"></i> {{ __('Send Message') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function submitContactForm() {
            const submitBtn = document.querySelector('#contactForm button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Sending...';

            fetch('/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    name: document.getElementById('contactName').value,
                    email: document.getElementById('contactEmail').value,
                    subject: document.getElementById('contactSubject').value,
                    message: document.getElementById('contactMessage').value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('contactForm').classList.add('d-none');
                    document.getElementById('contactSuccessMessage').classList.remove('d-none');
                } else {
                    alert('Something went wrong. Please try again.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-send-fill me-2"></i> Send Message';
                }
            })
            .catch(error => {
                console.error('Error submitting contact form:', error);
                alert('Something went wrong. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-send-fill me-2"></i> Send Message';
            });
        }
    </script>
</x-app-layout>
