<x-layouts.public title="Contact Us - {{ theme()->name() }}">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-6">Contact Us</h1>

                    <div class="prose max-w-none mb-8">
                        <p class="text-gray-600">
                            Have questions, feedback, or need to submit a DMCA takedown request? We'd love to hear from you.
                        </p>
                    </div>

                    <form class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Your Name *
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="John Doe"
                            >
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address *
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="john@example.com"
                            >
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                Subject *
                            </label>
                            <select
                                id="subject"
                                name="subject"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Select a subject...</option>
                                <option value="general">General Inquiry</option>
                                <option value="feedback">Feedback</option>
                                <option value="dmca">DMCA Takedown Request</option>
                                <option value="partnership">Partnership Opportunity</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Message *
                            </label>
                            <textarea
                                id="message"
                                name="message"
                                rows="6"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Your message here..."
                            ></textarea>
                        </div>

                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <p class="text-sm text-yellow-700">
                                <strong>Note:</strong> This is a placeholder form. Form submission functionality needs to be implemented. For now, please reach out via email at: <strong>[your-email@example.com]</strong>
                            </p>
                        </div>

                        <div>
                            <button
                                type="submit"
                                class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                                disabled
                            >
                                Send Message (Coming Soon)
                            </button>
                        </div>
                    </form>

                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Other Ways to Reach Us</h2>
                        <div class="space-y-3 text-gray-600">
                            <p>
                                <strong>Email:</strong> [your-email@example.com]
                            </p>
                            @if(theme('social.twitter'))
                            <p>
                                <strong>Twitter:</strong> <a href="{{ theme('social.twitter') }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800">{{ theme('social.twitter') }}</a>
                            </p>
                            @endif
                            @if(theme('social.facebook'))
                            <p>
                                <strong>Facebook:</strong> <a href="{{ theme('social.facebook') }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800">{{ theme('social.facebook') }}</a>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
