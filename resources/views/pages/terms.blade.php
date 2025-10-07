<x-layouts.public title="Terms of Service - {{ theme()->name() }}">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-6">Terms of Service</h1>

                    <div class="prose max-w-none">
                        <p class="text-gray-600 mb-4">Last updated: {{ date('F j, Y') }}</p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Agreement to Terms</h2>
                        <p class="mb-4">
                            By accessing {{ theme()->name() }}, you agree to be bound by these Terms of Service and agree that you are responsible for compliance with any applicable local laws.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Use License</h2>
                        <p class="mb-4">
                            Permission is granted to temporarily download one copy of the materials on {{ theme()->name() }} for personal, non-commercial transitory viewing only.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Disclaimer</h2>
                        <p class="mb-4">
                            The materials on {{ theme()->name() }} are provided on an 'as is' basis. {{ theme()->name() }} makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Limitations</h2>
                        <p class="mb-4">
                            In no event shall {{ theme()->name() }} or its suppliers be liable for any damages arising out of the use or inability to use the materials on {{ theme()->name() }}.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">External Links</h2>
                        <p class="mb-4">
                            {{ theme()->name() }} may contain links to external websites. We have no control over the nature, content and availability of those sites. The inclusion of any links does not necessarily imply a recommendation or endorse the views expressed within them.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Modifications</h2>
                        <p class="mb-4">
                            {{ theme()->name() }} may revise these terms of service at any time without notice. By using this website you are agreeing to be bound by the then current version of these terms of service.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Contact Us</h2>
                        <p class="mb-4">
                            If you have any questions about these Terms of Service, please <a href="{{ route('page.contact') }}" class="text-blue-600 hover:text-blue-800">contact us</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
