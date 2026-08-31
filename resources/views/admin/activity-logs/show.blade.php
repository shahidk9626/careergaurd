@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                
                <!-- Header -->
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl flex justify-between items-center">
                    <div>
                        <h6 class="mb-0 font-bold text-slate-700">Audit Log Details #{{ $log->id }}</h6>
                        <p class="text-xs text-slate-400">Detailed tracing of background audit and state transitions.</p>
                    </div>
                    <a href="{{ route('admin.activity-logs.index') }}" 
                       class="inline-block px-4 py-2 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-gray-100 border-0 rounded-lg cursor-pointer text-xxs leading-normal hover:scale-102 hover:bg-gray-200 shadow-none">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Logs
                    </a>
                </div>

                <div class="flex-auto p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        
                        <!-- Col 1: Overview Summary -->
                        <div class="lg:col-span-1 p-4 bg-gray-50/70 border border-gray-150 rounded-2xl">
                            <h6 class="text-xs font-bold uppercase text-slate-500 mb-4">Summary</h6>
                            <ul class="space-y-3.5 text-xs text-slate-650">
                                <li>
                                    <strong class="text-slate-500 uppercase text-xxs block">Module</strong>
                                    <span class="font-semibold text-sm">{{ $log->module_name }}</span>
                                </li>
                                <li>
                                    <strong class="text-slate-500 uppercase text-xxs block">Action Performed</strong>
                                    @php
                                        $badgeClass = 'bg-gradient-to-tl from-slate-600 to-slate-300';
                                        switch($log->action) {
                                            case 'CREATE':
                                            case 'REGISTER':
                                            case 'CLAIM_CREATED':
                                            case 'SERVICE_CREATED':
                                            case 'PAYMENT_SUCCESS':
                                            case 'COMMISSION_PAID':
                                                $badgeClass = 'bg-gradient-to-tl from-green-600 to-lime-400';
                                                break;
                                            case 'UPDATE':
                                            case 'PROFILE_UPDATE':
                                            case 'STATUS_CHANGE':
                                                $badgeClass = 'bg-gradient-to-tl from-blue-600 to-cyan-400';
                                                break;
                                            case 'DELETE':
                                            case 'PAYMENT_FAILED':
                                            case 'FAILED_LOGIN':
                                                $badgeClass = 'bg-gradient-to-tl from-red-600 to-rose-400';
                                                break;
                                            case 'LOGIN':
                                                $badgeClass = 'bg-gradient-to-tl from-purple-700 to-pink-500';
                                                break;
                                            case 'LOGOUT':
                                                $badgeClass = 'bg-gradient-to-tl from-slate-650 to-slate-400';
                                                break;
                                        }
                                    @endphp
                                    <span class="text-xxs px-2.5 py-1 inline-block font-bold uppercase text-white rounded-1.8 {{ $badgeClass }} mt-1">{{ $log->action }}</span>
                                </li>
                                <li>
                                    <strong class="text-slate-500 uppercase text-xxs block">Performed By</strong>
                                    <span class="font-semibold">{{ $log->performed_by_name }}</span>
                                    <span class="text-xxs text-slate-400">({{ $log->performed_by_role }} / {{ $log->performed_by_type }})</span>
                                </li>
                                <li>
                                    <strong class="text-slate-500 uppercase text-xxs block">Entity Reference ID / Code</strong>
                                    <span class="font-mono bg-white border border-gray-200 px-2 py-0.5 rounded text-xxs">{{ $log->reference_no ?? 'N/A' }}</span>
                                </li>
                                <li>
                                    <strong class="text-slate-500 uppercase text-xxs block">Timestamp</strong>
                                    <span>{{ $log->created_at->timezone('Asia/Kolkata')->format('d M Y, h:i:s A') }} (IST)</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Col 2: HTTP / Request Metadata -->
                        <div class="lg:col-span-2 p-4 bg-gray-50/70 border border-gray-150 rounded-2xl">
                            <h6 class="text-xs font-bold uppercase text-slate-500 mb-4">Request Trace Context</h6>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-650">
                                <div>
                                    <strong class="text-slate-500 uppercase text-xxs block">IP Address</strong>
                                    <span>{{ $log->ip_address ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <strong class="text-slate-500 uppercase text-xxs block">HTTP Method & URL</strong>
                                    <span class="font-bold text-purple-650 font-mono text-xxs bg-white border border-gray-200 px-1.5 py-0.5 rounded">{{ $log->http_method }}</span>
                                    <span class="break-all font-mono text-xxs">{{ $log->url }}</span>
                                </div>
                                <div>
                                    <strong class="text-slate-500 uppercase text-xxs block">User Agent (Browser & OS)</strong>
                                    <span><i class="fas fa-desktop text-slate-400 mr-1"></i> {{ $log->browser }} on {{ $log->operating_system }} ({{ $log->device }})</span>
                                </div>
                                <div>
                                    <strong class="text-slate-500 uppercase text-xxs block">Request Session ID</strong>
                                    <span class="font-mono text-xxs bg-white border border-gray-200 px-2 py-0.5 rounded">{{ $log->request_id }}</span>
                                </div>
                            </div>
                            
                            @if($log->description)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <strong class="text-slate-500 uppercase text-xxs block mb-1">Audit Log Description</strong>
                                    <p class="text-xs text-slate-700 bg-white border border-gray-200 p-3 rounded-lg leading-relaxed font-medium">
                                        {{ $log->description }}
                                    </p>
                                </div>
                            @endif
                        </div>

                    </div>

                    <!-- Row 2: Value Changes / JSON Payloads -->
                    <div class="mt-6 border border-gray-100 p-4 rounded-2xl bg-white shadow-soft-sm">
                        <h6 class="text-xs font-bold uppercase text-slate-500 mb-4">Database Value Logs</h6>

                        @if($log->changed_fields && count($log->changed_fields) > 0)
                            <!-- Update Fields Side-by-Side Table -->
                            <div class="overflow-x-auto border border-gray-200 rounded-xl">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50 border-b border-gray-200 text-xxs text-slate-500 font-bold uppercase">
                                            <th class="p-3">Field Name</th>
                                            <th class="p-3">Previous Value (Old)</th>
                                            <th class="p-3">New Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($log->changed_fields as $field)
                                            <tr class="border-b border-gray-150 text-xs">
                                                <td class="p-3 font-semibold text-slate-700 font-mono">{{ $field }}</td>
                                                <td class="p-3 text-red-600 font-mono bg-red-50/20 break-all leading-normal">
                                                    @if(is_array($log->old_values[$field] ?? ''))
                                                        <pre class="m-0 text-xxs font-mono">{{ json_encode($log->old_values[$field], JSON_PRETTY_PRINT) }}</pre>
                                                    @elseif(($log->old_values[$field] ?? '') === true || ($log->old_values[$field] ?? '') === 1)
                                                        <span class="px-2 py-0.5 rounded bg-green-100 text-green-700 font-bold text-xxs">TRUE</span>
                                                    @elseif(($log->old_values[$field] ?? '') === false || ($log->old_values[$field] ?? '') === 0)
                                                        <span class="px-2 py-0.5 rounded bg-red-100 text-red-700 font-bold text-xxs">FALSE</span>
                                                    @elseif(is_null($log->old_values[$field] ?? null))
                                                        <span class="text-slate-400 italic">null</span>
                                                    @else
                                                        {{ $log->old_values[$field] }}
                                                    @endif
                                                </td>
                                                <td class="p-3 text-green-600 font-mono bg-green-50/20 break-all leading-normal font-semibold">
                                                    @if(is_array($log->new_values[$field] ?? ''))
                                                        <pre class="m-0 text-xxs font-mono">{{ json_encode($log->new_values[$field], JSON_PRETTY_PRINT) }}</pre>
                                                    @elseif(($log->new_values[$field] ?? '') === true || ($log->new_values[$field] ?? '') === 1)
                                                        <span class="px-2 py-0.5 rounded bg-green-100 text-green-700 font-bold text-xxs">TRUE</span>
                                                    @elseif(($log->new_values[$field] ?? '') === false || ($log->new_values[$field] ?? '') === 0)
                                                        <span class="px-2 py-0.5 rounded bg-red-100 text-red-700 font-bold text-xxs">FALSE</span>
                                                    @elseif(is_null($log->new_values[$field] ?? null))
                                                        <span class="text-slate-400 italic">null</span>
                                                    @else
                                                        {{ $log->new_values[$field] }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif($log->new_values && count($log->new_values) > 0)
                            <!-- Simple Dump (CREATE / RESTORE) -->
                            <div class="p-4 bg-gray-50 border border-gray-150 rounded-xl">
                                <span class="text-xxs font-bold uppercase text-slate-500 block mb-2">Record Attributes Dump (New Values)</span>
                                <pre class="p-3 bg-white border border-gray-250 rounded-lg text-xxs font-mono text-slate-700 overflow-x-auto leading-normal m-0">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        @elseif($log->old_values && count($log->old_values) > 0)
                            <!-- Simple Dump (DELETE) -->
                            <div class="p-4 bg-gray-50 border border-gray-150 rounded-xl">
                                <span class="text-xxs font-bold uppercase text-slate-500 block mb-2">Record Attributes Dump (Old Values)</span>
                                <pre class="p-3 bg-white border border-gray-250 rounded-lg text-xxs font-mono text-slate-700 overflow-x-auto leading-normal m-0">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        @else
                            <div class="text-center py-6 text-slate-400 italic text-xs">
                                No database columns were altered or saved during this operation.
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
