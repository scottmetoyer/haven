<x-layouts.public title="Privacy Policy - {{ theme()->name() }}">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-6">Privacy Policy</h1>

                    <div class="prose max-w-none">
                        <p class="text-gray-600 mb-4">Last updated: {{ date('F j, Y') }}</p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Information We Collect</h2>
                        <p class="mb-4">
                            When you visit {{ theme()->name() }}, we may collect certain information about your device, including information about your web browser, IP address, time zone, and some of the cookies that are installed on your device.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">How We Use Your Information</h2>
                        <p class="mb-4">
                            We use the information we collect to:
                        </p>
                        <ul class="list-disc pl-6 mb-4">
                            <li>Improve and optimize our site</li>
                            <li>Analyze how you use our site</li>
                            <li>Communicate with you (if you have contacted us)</li>
                        </ul>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Cookies</h2>
                        <p class="mb-4">
                            We use cookies to maintain session information and enhance your experience on our site.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Third-Party Services</h2>
                        <p class="mb-4">
                            We may use third-party services such as Google Analytics to help us understand how our users use the site.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Your Rights</h2>
                        <p class="mb-4">
                            If you are a European resident, you have the right to access personal information we hold about you and to ask that your personal information be corrected, updated, or deleted.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Contact Us</h2>
                        <p class="mb-4">
                            For more information about our privacy practices, if you have questions, or if you would like to make a complaint, please <a href="{{ route('page.contact') }}" class="text-blue-600 hover:text-blue-800">contact us</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
