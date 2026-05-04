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
                    <div class="flex items-center justify-center w-full h-full bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-sm rounded-xl">
                        <i class="fas fa-file-medical text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="flex-none w-auto max-w-full px-3 my-auto">
                <div class="h-full">
                    <h5 class="mb-1">Claim Application</h5>
                    <p class="mb-0 font-semibold leading-normal text-sm">
                        {{ $purchasedPlan->plan_name }} ({{ $purchasedPlan->plan_unique_id }})
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="w-full mt-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0 font-bold">Submit Your Claim</h6>
                    <p class="text-sm">Please upload the required documents to process your claim.</p>
                </div>
                <div class="flex-auto p-6">
                    <form action="{{ route('customer.claim.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="plan_unique_id" value="{{ $purchasedPlan->plan_unique_id }}">
                        
                        <div class="flex flex-wrap -mx-3">
                            <!-- Termination Letter -->
                            <div class="w-full max-w-full px-3 mb-6 md:w-6/12">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700 uppercase">Termination Letter (PDF/JPG/PNG)</label>
                                <div class="mb-4">
                                    <input type="file" name="termination_letter" required
                                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" />
                                    @error('termination_letter')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Salary Slips -->
                            <div class="w-full max-w-full px-3 mb-6 md:w-6/12">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700 uppercase">Last 3 Months Salary Slips (Multiple)</label>
                                <div class="mb-4">
                                    <input type="file" name="salary_slips[]" multiple required
                                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" />
                                    @error('salary_slips')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Other Documents -->
                            <div class="w-full max-w-full px-3 mb-6">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700 uppercase">Other Supporting Documents (Optional, Multiple)</label>
                                <div class="mb-4">
                                    <input type="file" name="other_documents[]" multiple
                                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" />
                                    @error('other_documents')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Remarks -->
                            <div class="w-full max-w-full px-3 mb-6">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700 uppercase">Remarks / Notes</label>
                                <div class="mb-4">
                                    <textarea name="remarks" rows="4" placeholder="Any additional information..."
                                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85">
                                Submit Claim Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
