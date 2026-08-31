@props(['entityType' => null, 'entityId' => null])

<div id="timeline-container-{{ $entityType }}-{{ $entityId }}" class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-none rounded-2xl bg-clip-border">
    <div class="flex-auto p-4">
        <!-- Spinner -->
        <div id="timeline-loading-{{ $entityType }}-{{ $entityId }}" class="text-center py-6">
            <div class="inline-block animate-spin rounded-full h-7 w-7 border-t-2 border-b-2 border-purple-500"></div>
            <p class="text-xs text-slate-400 mt-2">Loading activity history...</p>
        </div>
        
        <!-- Timeline Content -->
        <div id="timeline-content-{{ $entityType }}-{{ $entityId }}" class="relative pl-8 border-l border-slate-200/60 ml-3 space-y-6 hidden">
            <!-- Populated dynamically -->
        </div>
        
        <!-- Empty State -->
        <div id="timeline-empty-{{ $entityType }}-{{ $entityId }}" class="text-center py-6 hidden">
            <p class="text-sm text-slate-400 italic">No activity history recorded yet.</p>
        </div>
    </div>
</div>

<script>
    (function() {
        // Run immediately to load the dynamic timeline
        const cId = "{{ $entityId }}";
        const cType = "{{ $entityType }}";
        
        if (!cId || !cType) return;

        const formatDescription = (desc) => {
            if (!desc) return '';
            
            // Format "Updated fields: field1, field2"
            if (desc.startsWith('Updated fields:')) {
                const fields = desc.replace('Updated fields:', '').split(',').map(f => f.trim());
                let html = '<span class="text-slate-400 mr-2 text-xxs uppercase font-semibold">Modified Fields:</span><div class="flex flex-wrap gap-1 mt-1">';
                fields.forEach(field => {
                    html += `<span class="inline-block bg-purple-50 text-purple-600 border border-purple-100 px-2 py-0.5 rounded text-xxs font-mono font-bold">${field}</span>`;
                });
                html += '</div>';
                return html;
            }

            // Format "Status changed from 'X' to 'Y'"
            if (desc.startsWith('Status changed from')) {
                const matches = desc.match(/'([^']+)'/g);
                if (matches && matches.length === 2) {
                    const oldStatus = matches[0].replace(/'/g, '');
                    const newStatus = matches[1].replace(/'/g, '');
                    
                    let oldClass = 'bg-slate-100 text-slate-650 border-slate-200';
                    let newClass = 'bg-green-50 text-green-700 border-green-200';
                    if (newStatus === 'inactive' || newStatus === 'rejected' || newStatus === 'failed') {
                        newClass = 'bg-red-50 text-red-650 border-red-200';
                    } else if (newStatus === 'pending') {
                        newClass = 'bg-amber-50 text-amber-705 border-amber-200';
                    }

                    return `
                        <div class="flex items-center flex-wrap gap-1.5 text-xs">
                            <span class="text-slate-400 text-xxs uppercase font-semibold mr-1">Status Shift:</span>
                            <span class="inline-block border px-2 py-0.5 rounded text-xxs font-semibold ${oldClass}">${oldStatus}</span>
                            <i class="fas fa-long-arrow-alt-right text-slate-300 mx-1"></i>
                            <span class="inline-block border px-2 py-0.5 rounded text-xxs font-bold ${newClass}">${newStatus}</span>
                        </div>
                    `;
                }
            }

            return desc.replace(/\n/g, '<br>');
        };
        
        const loadTimeline = () => {
            fetch(`/activity-logs/entity-history?entity_type=${cType}&entity_id=${cId}`)
                .then(res => res.json())
                .then(data => {
                    const loading = document.getElementById(`timeline-loading-${cType}-${cId}`);
                    const content = document.getElementById(`timeline-content-${cType}-${cId}`);
                    const empty = document.getElementById(`timeline-empty-${cType}-${cId}`);
                    
                    if (loading) loading.classList.add('hidden');
                    
                    if (data.success && data.logs && data.logs.length > 0) {
                        let html = '';
                        data.logs.forEach(log => {
                            html += `
                                <div class="relative transition-all duration-300 hover:translate-x-1 group">
                                    <!-- Premium Outer Circle node centered on the line -->
                                    <span class="absolute flex h-7 w-7 items-center justify-center rounded-full bg-white border border-slate-200 shadow-sm transition-all duration-350 group-hover:scale-110 group-hover:border-purple-300 group-hover:shadow-md" style="left: -45px; top: 6px; z-index: 10;">
                                        <span class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tl ${log.color}">
                                            <i class="fas ${log.icon} text-white" style="font-size: 8px;"></i>
                                        </span>
                                    </span>
                                    
                                    <!-- Premium soft card for content -->
                                    <div class="bg-gradient-to-r from-slate-50/50 to-white border border-slate-100 rounded-xl p-4 shadow-soft-sm hover:shadow-soft-md hover:border-slate-250 transition-all duration-350">
                                        <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="text-xs font-bold text-slate-800 tracking-wide uppercase">${log.action}</span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-medium bg-white text-slate-600 border border-slate-150 shadow-none">
                                                    <i class="fas fa-user-circle mr-1 text-slate-400"></i> ${log.performed_by_name || 'System'}
                                                    <span class="text-slate-400 ml-1">(${log.performed_by_role || 'System'})</span>
                                                </span>
                                            </div>
                                            <span class="text-xxs font-semibold text-slate-400"><i class="far fa-clock mr-1"></i> ${log.created_at}</span>
                                        </div>
                                        
                                        ${log.description ? `
                                            <div class="mt-2 text-xs text-slate-650 leading-relaxed font-medium">
                                                ${formatDescription(log.description)}
                                            </div>
                                        ` : ''}
                                    </div>
                                </div>
                            `;
                        });
                        if (content) {
                            content.innerHTML = html;
                            content.classList.remove('hidden');
                        }
                    } else {
                        if (empty) empty.classList.remove('hidden');
                    }
                })
                .catch(err => {
                    console.error("Failed to load timeline logs:", err);
                    const loading = document.getElementById(`timeline-loading-${cType}-${cId}`);
                    if (loading) {
                        loading.innerHTML = '<p class="text-xs text-red-500 font-semibold"><i class="fas fa-exclamation-circle"></i> Failed to load activity history.</p>';
                    }
                });
        };

        if (document.readyState === 'loading') {
            document.addEventListener("DOMContentLoaded", loadTimeline);
        } else {
            loadTimeline();
        }
    })();
</script>
