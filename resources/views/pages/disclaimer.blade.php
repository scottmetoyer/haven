<x-layouts.public title="Affiliate Disclaimer - {{ theme()->name() }}">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-6">Affiliate Disclaimer</h1>

                    <div class="prose max-w-none">
                        <p class="text-gray-600 mb-4">Last updated: {{ date('F j, Y') }}</p>

                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                            <p class="text-blue-700 font-semibold">
                                {{ theme()->name() }} participates in various affiliate marketing programs, which means we may earn commissions on purchases made through our links to retailer sites.
                            </p>
                        </div>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Affiliate Relationships</h2>
                        <p class="mb-4">
                            We are a participant in affiliate marketing programs including, but not limited to, the Amazon Services LLC Associates Program, an affiliate advertising program designed to provide a means for sites to earn advertising fees by advertising and linking to affiliated sites.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">What This Means</h2>
                        <p class="mb-4">
                            When you click on links to various merchants on this site and make a purchase, this can result in {{ theme()->name() }} earning a commission. These affiliate partnerships help support the site and allow us to continue providing quality content to our readers.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">No Additional Cost</h2>
                        <p class="mb-4">
                            Using our affiliate links does not add any additional cost to your purchase. The price you pay is the same whether or not you use our affiliate links.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Our Commitment to Honesty</h2>
                        <p class="mb-4">
                            We are committed to providing honest and unbiased reviews, recommendations, and information. Our primary goal is to help our readers make informed decisions. We will never recommend a product solely for the purpose of earning a commission.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Product Reviews and Recommendations</h2>
                        <p class="mb-4">
                            Our reviews and recommendations are based on:
                        </p>
                        <ul class="list-disc pl-6 mb-4">
                            <li>Personal experience and testing (when applicable)</li>
                            <li>Extensive research and comparison</li>
                            <li>User reviews and feedback</li>
                            <li>Industry expertise and knowledge</li>
                        </ul>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Disclaimer of Liability</h2>
                        <p class="mb-4">
                            While we strive to provide accurate and up-to-date information, {{ theme()->name() }} makes no representations or warranties regarding the accuracy, completeness, or reliability of any information, products, or services mentioned on this site. You acknowledge that your use of this site and any purchases you make are at your own risk.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Price Changes</h2>
                        <p class="mb-4">
                            Prices and availability of products mentioned on this site are subject to change without notice. We are not responsible for any changes in pricing or availability after publication.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Contact Us</h2>
                        <p class="mb-4">
                            If you have any questions about our affiliate relationships or this disclaimer, please feel free to <a href="{{ route('page.contact') }}" class="text-blue-600 hover:text-blue-800">contact us</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
