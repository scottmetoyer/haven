<footer class="bg-white border-t border-gray-200 mt-auto">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- About Section -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">
                    {{ theme()->name() }}
                </h3>
                <p class="text-gray-600 text-sm">
                    {{ theme()->tagline() ?: theme()->description() }}
                </p>
            </div>

            <!-- Legal Links -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">
                    Legal
                </h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('page.privacy') }}" class="text-gray-600 hover:text-gray-900 text-sm">
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('page.terms') }}" class="text-gray-600 hover:text-gray-900 text-sm">
                            Terms of Service
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('page.dmca') }}" class="text-gray-600 hover:text-gray-900 text-sm">
                            DMCA Takedown
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('page.disclaimer') }}" class="text-gray-600 hover:text-gray-900 text-sm">
                            Affiliate Disclaimer
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Social & Contact -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">
                    Connect
                </h3>
                <ul class="space-y-3">
                    @if(theme('social.twitter'))
                    <li>
                        <a href="{{ theme('social.twitter') }}" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-gray-900 text-sm">
                            Twitter
                        </a>
                    </li>
                    @endif
                    @if(theme('social.facebook'))
                    <li>
                        <a href="{{ theme('social.facebook') }}" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-gray-900 text-sm">
                            Facebook
                        </a>
                    </li>
                    @endif
                    @if(theme('social.instagram'))
                    <li>
                        <a href="{{ theme('social.instagram') }}" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-gray-900 text-sm">
                            Instagram
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('page.contact') }}" class="text-gray-600 hover:text-gray-900 text-sm">
                            Contact Us
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-8 border-t border-gray-200 pt-8">
            <p class="text-gray-500 text-sm text-center">
                &copy; {{ date('Y') }} {{ theme()->name() }}. All rights reserved.
            </p>
        </div>
    </div>
</footer>
