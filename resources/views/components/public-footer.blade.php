<footer class="bg-white dark:bg-[#161615] border-t border-[#e3e3e0] dark:border-[#3E3E3A] mt-auto">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- About Section -->
            <div>
                <h3 class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC] tracking-wider uppercase mb-4">
                    {{ theme()->name() }}
                </h3>
                <p class="text-[#706f6c] dark:text-[#A1A09A] text-sm">
                    {{ theme()->tagline() ?: theme()->description() }}
                </p>
            </div>

            <!-- Legal Links -->
            <div>
                <h3 class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC] tracking-wider uppercase mb-4">
                    Legal
                </h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('page.privacy') }}" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] text-sm">
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('page.terms') }}" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] text-sm">
                            Terms of Service
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('page.dmca') }}" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] text-sm">
                            DMCA Takedown
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('page.disclaimer') }}" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] text-sm">
                            Affiliate Disclaimer
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Social & Contact -->
            <div>
                <h3 class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC] tracking-wider uppercase mb-4">
                    Connect
                </h3>
                <ul class="space-y-3">
                    @if(theme('social.twitter'))
                    <li>
                        <a href="{{ theme('social.twitter') }}" target="_blank" rel="noopener noreferrer" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] text-sm">
                            Twitter
                        </a>
                    </li>
                    @endif
                    @if(theme('social.facebook'))
                    <li>
                        <a href="{{ theme('social.facebook') }}" target="_blank" rel="noopener noreferrer" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] text-sm">
                            Facebook
                        </a>
                    </li>
                    @endif
                    @if(theme('social.instagram'))
                    <li>
                        <a href="{{ theme('social.instagram') }}" target="_blank" rel="noopener noreferrer" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] text-sm">
                            Instagram
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('page.contact') }}" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] text-sm">
                            Contact Us
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-8 border-t border-[#e3e3e0] dark:border-[#3E3E3A] pt-8">
            <p class="text-[#706f6c] dark:text-[#A1A09A] text-sm text-center">
                &copy; {{ date('Y') }} {{ theme()->name() }}. All rights reserved.
            </p>
        </div>
    </div>
</footer>
