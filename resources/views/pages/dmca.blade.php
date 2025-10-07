<x-layouts.public title="DMCA Takedown - {{ theme()->name() }}">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-6">DMCA Takedown Policy</h1>

                    <div class="prose max-w-none">
                        <p class="text-gray-600 mb-4">Last updated: {{ date('F j, Y') }}</p>

                        <p class="mb-4">
                            {{ theme()->name() }} respects the intellectual property rights of others and expects its users to do the same. In accordance with the Digital Millennium Copyright Act of 1998 (DMCA), we will respond expeditiously to claims of copyright infringement committed using our website.
                        </p>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Filing a DMCA Takedown Notice</h2>
                        <p class="mb-4">
                            If you believe that content on {{ theme()->name() }} infringes your copyright, please provide us with the following information:
                        </p>

                        <ol class="list-decimal pl-6 mb-4 space-y-2">
                            <li>A physical or electronic signature of the copyright owner or a person authorized to act on their behalf</li>
                            <li>Identification of the copyrighted work claimed to have been infringed</li>
                            <li>Identification of the material that is claimed to be infringing or to be the subject of infringing activity and that is to be removed or access to which is to be disabled, including information reasonably sufficient to permit us to locate the material (such as a URL)</li>
                            <li>Your contact information, including your address, telephone number, and an email address</li>
                            <li>A statement that you have a good faith belief that use of the material in the manner complained of is not authorized by the copyright owner, its agent, or the law</li>
                            <li>A statement that the information in the notification is accurate, and, under penalty of perjury, that you are authorized to act on behalf of the copyright owner</li>
                        </ol>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">How to Submit a Notice</h2>
                        <p class="mb-4">
                            Please submit your DMCA takedown notice through our <a href="{{ route('page.contact') }}" class="text-blue-600 hover:text-blue-800">contact form</a> with the subject line "DMCA Takedown Request" or send it to our designated DMCA agent.
                        </p>

                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <p class="font-semibold mb-2">DMCA Agent Contact:</p>
                            <p class="text-gray-700">
                                [Your Company Name]<br>
                                Attn: DMCA Agent<br>
                                [Your Address]<br>
                                Email: [Your DMCA Email]
                            </p>
                        </div>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Counter-Notification</h2>
                        <p class="mb-4">
                            If you believe that your content that was removed (or to which access was disabled) is not infringing, or that you have the authorization from the copyright owner, the copyright owner's agent, or pursuant to the law, to post and use the material, you may send a counter-notice containing the following information:
                        </p>

                        <ol class="list-decimal pl-6 mb-4 space-y-2">
                            <li>Your physical or electronic signature</li>
                            <li>Identification of the content that has been removed or to which access has been disabled and the location at which the content appeared before it was removed or disabled</li>
                            <li>A statement that you have a good faith belief that the content was removed or disabled as a result of mistake or a misidentification of the content</li>
                            <li>Your name, address, telephone number, and email address</li>
                            <li>A statement that you consent to the jurisdiction of the federal court in your district and that you will accept service of process from the person who provided notification of the alleged infringement</li>
                        </ol>

                        <h2 class="text-2xl font-semibold mt-8 mb-4">Repeat Infringers</h2>
                        <p class="mb-4">
                            We reserve the right to terminate access to our site for users who are repeat infringers of copyright.
                        </p>

                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-8">
                            <p class="text-yellow-700">
                                <strong>Note:</strong> Misrepresentations in a DMCA notice or counter-notice may expose you to liability for damages, including costs and attorneys' fees.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
