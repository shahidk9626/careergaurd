@extends('layouts.app')

@section('content')
<div class="w-full mx-auto">
    <div class="relative flex items-center p-0 mt-6 overflow-hidden bg-center bg-cover min-h-75 rounded-2xl"
        style="background-image: url('{{ asset('assets/img/curved-images/curved0.jpg') }}'); background-position-y: 50%;">
        <span class="absolute inset-y-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-purple-700 to-pink-500 opacity-60"></span>
    </div>
    <div class="relative flex flex-col flex-auto min-w-0 p-4 mx-6 -mt-16 overflow-hidden break-words border-0 shadow-blur rounded-2xl bg-white/80 bg-clip-border backdrop-blur-2xl backdrop-saturate-200">
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-auto max-w-full px-3">
                <div class="text-base ease-soft-in-out h-18.5 w-18.5 relative inline-flex items-center justify-center rounded-xl text-white transition-all duration-200">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="profile_image" class="w-full shadow-soft-sm rounded-xl" />
                    @else
                        <img src="{{ asset('assets/img/bruce-mars.jpg') }}" alt="profile_image" class="w-full shadow-soft-sm rounded-xl" />
                    @endif
                </div>
            </div>
            <div class="flex-none w-auto max-w-full px-3 my-auto">
                <div class="h-full">
                    <h5 class="mb-1">Edit Profile</h5>
                    <p class="mb-0 font-semibold leading-normal text-sm">
                        Update your personal information
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="w-full mt-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 mx-auto lg:w-8/12">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0">Edit Profile Information</h6>
                </div>
                <div class="flex-auto p-4">
                    <form id="profileEditForm" action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full max-w-full px-3 mb-4 md:w-6/12">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Full Name</label>
                                <div class="mb-4">
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-border px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Full Name" required />
                                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-6/12">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Email (Read-only)</label>
                                <div class="mb-4">
                                    <input type="email" value="{{ $user->email }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-100 bg-clip-border px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Email" readonly />
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-6/12">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Phone</label>
                                <div class="mb-4">
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-border px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Phone" required />
                                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-6/12">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">WhatsApp Number</label>
                                <div class="mb-4">
                                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $user->whatsapp_number) }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-border px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="WhatsApp" required />
                                    @error('whatsapp_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Address</label>
                                <div class="mb-4">
                                    <textarea name="address" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-border px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Address" rows="3" required>{{ old('address', $user->customerDetail->address) }}</textarea>
                                    @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-4/12">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">City</label>
                                <div class="mb-4">
                                    <input type="text" name="city" value="{{ old('city', $user->customerDetail->city) }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-border px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="City" required />
                                    @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-4/12">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">State</label>
                                <div class="mb-4">
                                    <input type="text" name="state" value="{{ old('state', $user->customerDetail->state) }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-border px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="State" required />
                                    @error('state') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-4/12">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Pincode</label>
                                <div class="mb-4">
                                    <input type="text" name="pincode" value="{{ old('pincode', $user->customerDetail->pincode) }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-border px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Pincode" required />
                                    @error('pincode') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Profile Image (Optional)</label>
                                <div class="mb-4">
                                    <input type="file" name="profile_image" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-border px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" />
                                    @error('profile_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="inline-block w-full px-6 py-3 mt-6 mb-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer active:opacity-85 hover:scale-102 hover:shadow-soft-xs leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-purple-700 to-pink-500 hover:border-fuchsia-300">Save Changes</button>
                            <a href="{{ route('customer.profile') }}" class="inline-block w-full px-6 py-3 mb-2 font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer active:opacity-85 hover:scale-102 leading-pro text-xs ease-soft-in tracking-tight-soft text-slate-700">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#profileEditForm").validate({
                rules: {
                    name: { required: true, lettersnspaces: true, minlength: 3 },
                    phone: { required: true, indianmobile: true },
                    whatsapp_number: { required: true, indianmobile: true },
                    address: { required: true },
                    city: { required: true, lettersnspaces: true },
                    state: { required: true, lettersnspaces: true },
                    pincode: { required: true, pincode_custom: true },
                    profile_image: {
                        filesize: 2 * 1024 * 1024,
                        extension_custom: "jpg|jpeg|png|pdf"
                    }
                },
                messages: {
                    name: { required: "Full Name is required" },
                    phone: { required: "Phone number is required" },
                    whatsapp_number: { required: "WhatsApp number is required" },
                    address: { required: "Address is required" },
                    city: { required: "City is required" },
                    state: { required: "State is required" },
                    pincode: { required: "Pincode is required" }
                }
            });
        });
    </script>
@endpush
@endsection
