@extends('layouts.app')

@section('content')
<div class="w-full mx-auto">
    <!-- Header / Cover -->
    <div class="relative flex items-center p-0 mt-6 overflow-hidden bg-center bg-cover min-h-75 rounded-2xl"
        style="background-image: url('{{ asset('assets/img/curved-images/curved0.jpg') }}'); background-position-y: 50%;">
        <span class="absolute inset-y-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-purple-700 to-pink-500 opacity-60"></span>
    </div>

    <!-- Profile Header Card -->
    <div class="relative flex flex-col flex-auto min-w-0 p-4 mx-6 -mt-16 overflow-hidden break-words border-0 shadow-blur rounded-2xl bg-white/80 bg-clip-border backdrop-blur-2xl backdrop-saturate-200">
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-auto max-w-full px-3">
                <div class="text-base ease-soft-in-out h-18.5 w-18.5 relative inline-flex items-center justify-center rounded-xl text-white transition-all duration-200">
                    @if($customer->profile_image)
                        <img src="{{ asset('storage/' . $customer->profile_image) }}" alt="profile_image" class="w-full shadow-soft-sm rounded-xl" />
                    @else
                        <img src="{{ asset('assets/img/bruce-mars.jpg') }}" alt="profile_image" class="w-full shadow-soft-sm rounded-xl" />
                    @endif
                </div>
            </div>
            <div class="flex-none w-auto max-w-full px-3 my-auto">
                <div class="h-full">
                    <h5 class="mb-1">{{ $customer->name }}</h5>
                    <p class="mb-0 font-semibold leading-normal text-sm">
                        Customer Account (ID: {{ $customer->id }})
                    </p>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mx-auto mt-4 sm:my-auto sm:mr-0 md:w-1/2 md:flex-none lg:w-4/12">
                <div class="relative right-0 flex justify-end gap-2">
                    @if($prev)
                        <a href="{{ route('admin.customers.show', $prev->id) }}" class="inline-block px-4 py-2 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in border-fuchsia-500 hover:scale-102 active:shadow-soft-xs text-fuchsia-500 hover:bg-fuchsia-500 hover:text-white">
                            <i class="fas fa-chevron-left mr-1"></i> Prev
                        </a>
                    @endif
                    @if($next)
                        <a href="{{ route('admin.customers.show', $next->id) }}" class="inline-block px-4 py-2 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in border-fuchsia-500 hover:scale-102 active:shadow-soft-xs text-fuchsia-500 hover:bg-fuchsia-500 hover:text-white">
                            Next <i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    @endif
                    @if($customer->verification_status !== 'verified')
                        <button onclick="confirmVerify({{ $customer->id }})" class="inline-block px-4 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102">
                            <i class="fas fa-check-circle mr-1"></i> Verify Customer
                        </button>
                    @else
                        <span class="inline-block px-4 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-green-600 to-lime-400 opacity-70">
                            <i class="fas fa-check-double mr-1"></i> Verified
                        </span>
                    @endif

                    <a href="{{ route('admin.customers.index') }}" class="inline-block px-4 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabs Section -->
<div class="w-full mt-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0">
                    <div class="flex flex-wrap -mx-3">
                        <div class="w-full max-w-full px-3">
                            <ul class="flex flex-wrap p-1 mb-0 list-none bg-gray-50 rounded-xl" role="tablist">
                                <li class="flex-auto text-center">
                                    <a class="flex items-center justify-center w-full px-0 py-1 mb-0 transition-all border-0 rounded-lg ease-soft-in-out bg-inherit text-slate-700 active-tab cursor-pointer" 
                                       onclick="switchTab(event, 'personal')" id="defaultOpen">
                                        <i class="fas fa-user text-sm mr-2"></i>
                                        <span class="ml-1">Personal</span>
                                    </a>
                                </li>
                                <li class="flex-auto text-center">
                                    <a class="flex items-center justify-center w-full px-0 py-1 mb-0 transition-all border-0 rounded-lg ease-soft-in-out bg-inherit text-slate-700 cursor-pointer"
                                       onclick="switchTab(event, 'contact')">
                                        <i class="fas fa-map-marker-alt text-sm mr-2"></i>
                                        <span class="ml-1">Contact</span>
                                    </a>
                                </li>
                                <li class="flex-auto text-center">
                                    <a class="flex items-center justify-center w-full px-0 py-1 mb-0 transition-all border-0 rounded-lg ease-soft-in-out bg-inherit text-slate-700 cursor-pointer"
                                       onclick="switchTab(event, 'employment')">
                                        <i class="fas fa-briefcase text-sm mr-2"></i>
                                        <span class="ml-1">Employment</span>
                                    </a>
                                </li>
                                <li class="flex-auto text-center">
                                    <a class="flex items-center justify-center w-full px-0 py-1 mb-0 transition-all border-0 rounded-lg ease-soft-in-out bg-inherit text-slate-700 cursor-pointer"
                                       onclick="switchTab(event, 'bank')">
                                        <i class="fas fa-university text-sm mr-2"></i>
                                        <span class="ml-1">Bank</span>
                                    </a>
                                </li>
                                <li class="flex-auto text-center">
                                    <a class="flex items-center justify-center w-full px-0 py-1 mb-0 transition-all border-0 rounded-lg ease-soft-in-out bg-inherit text-slate-700 cursor-pointer"
                                       onclick="switchTab(event, 'documents')">
                                        <i class="fas fa-file-alt text-sm mr-2"></i>
                                        <span class="ml-1">Documents</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex-auto p-6">
                    <!-- Tab Content -->
                    <div id="personal" class="tabcontent">
                        <div class="flex items-center mb-6">
                            <h6 class="font-bold leading-tight uppercase text-xs text-slate-500 mb-0">Personal Information</h6>
                            <div class="flex-1 h-px bg-gray-100 ml-4"></div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Full Name</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->name }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Email Address</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->email }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">WhatsApp Number</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->whatsapp_number ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Phone Number</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Father's Name</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->father_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Date of Birth</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->dob ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Gender</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->gender ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Marital Status</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->marital_status ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Referral Staff</label>
                                <span class="text-sm font-bold text-slate-700">
                                    @if($customer->referredBy)
                                        {{ $customer->referredBy->name }} ({{ $customer->referredBy->staffDetail->emp_code ?? 'N/A' }})
                                    @else
                                        Direct (No Referral)
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div id="contact" class="tabcontent hidden">
                        <div class="flex items-center mb-6">
                            <h6 class="font-bold leading-tight uppercase text-xs text-slate-500 mb-0">Contact Information</h6>
                            <div class="flex-1 h-px bg-gray-100 ml-4"></div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            <div class="flex flex-col md:col-span-2">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Full Address</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->address ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">City</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->city ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">State</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->state ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Pincode</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->pincode ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div id="employment" class="tabcontent hidden">
                        <div class="flex items-center mb-6">
                            <h6 class="font-bold leading-tight uppercase text-xs text-slate-500 mb-0">Employment Details</h6>
                            <div class="flex-1 h-px bg-gray-100 ml-4"></div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Company Name</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->company_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Designation</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->designation ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Salary / Income</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->annual_income ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Occupation</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->occupation ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div id="bank" class="tabcontent hidden">
                        <div class="flex items-center mb-6">
                            <h6 class="font-bold leading-tight uppercase text-xs text-slate-500 mb-0">Bank & Financials</h6>
                            <div class="flex-1 h-px bg-gray-100 ml-4"></div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Bank Name</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->bank_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Account Number</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->account_number ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">IFSC Code</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->ifsc_code ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">PAN Number</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->pan_number ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1">Aadhar Number</label>
                                <span class="text-sm font-bold text-slate-700">{{ $customer->customerDetail->aadhar_number ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div id="documents" class="tabcontent hidden">
                        <div class="flex items-center mb-6">
                            <h6 class="font-bold leading-tight uppercase text-xs text-slate-500 mb-0">Uploaded Documents</h6>
                            <div class="flex-1 h-px bg-gray-100 ml-4"></div>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            @forelse($customer->customerDocuments as $doc)
                                <div class="relative group border border-gray-100 rounded-xl p-3 bg-white shadow-soft-sm hover:shadow-soft-md transition-all">
                                    <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden flex items-center justify-center mb-3">
                                        @php $ext = pathinfo($doc->file_path, PATHINFO_EXTENSION); @endphp
                                        @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('storage/' . $doc->file_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-file-pdf text-3xl text-red-500"></i>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <p class="text-xxs font-bold text-slate-400 uppercase truncate mb-2">{{ $doc->document_name }}</p>
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                           class="w-full px-2 py-1.5 text-xxs font-bold text-center text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg hover:scale-102 transition-all">
                                            <i class="fas fa-eye mr-1"></i> View
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full py-12 text-center bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                    <i class="fas fa-folder-open text-slate-300 text-4xl mb-3"></i>
                                    <p class="text-sm font-bold text-slate-500">No documents found for this customer.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .active-tab {
        background-color: white !important;
        box-shadow: 0 4px 7px -1px rgba(0, 0, 0, 0.11), 0 2px 4px -1px rgba(0, 0, 0, 0.07) !important;
        font-weight: 700 !important;
    }
</style>

<script>
    function switchTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].classList.add("hidden");
        }
        tablinks = evt.currentTarget.parentNode.parentNode.getElementsByTagName("a");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active-tab");
        }
        document.getElementById(tabName).classList.remove("hidden");
        evt.currentTarget.classList.add("active-tab");
        
        // Scroll to top of tab section for better UX
        const element = document.getElementById(tabName);
        const offset = 120;
        const bodyRect = document.body.getBoundingClientRect().top;
        const elementRect = element.getBoundingClientRect().top;
        const elementPosition = elementRect - bodyRect;
        const offsetPosition = elementPosition - offset;

        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
    }

    function confirmVerify(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to verify this customer?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2dce89',
            cancelButtonColor: '#344767',
            confirmButtonText: 'Yes, Verify!',
            customClass: {
                confirmButton: 'bg-gradient-to-tl from-green-600 to-lime-400 text-white px-4 py-2 rounded-lg font-bold',
                cancelButton: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg font-bold ml-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('/admin/customers') }}/" + id + "/verify",
                    type: 'POST',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Verified!',
                                text: 'Customer verified successfully',
                                customClass: {
                                    confirmButton: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg font-bold'
                                },
                                buttonsStyling: false
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    }
                });
            }
        });
    }
</script>
@endsection
