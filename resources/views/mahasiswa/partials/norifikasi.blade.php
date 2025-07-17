

<div class="z-50 hidden max-w-sm w-full my-4 bg-white rounded-xl shadow-lg border border-slate-200" id="notification-dropdown">
    <div class="px-4 py-3 border-b border-slate-100">
        <h3 class="text-sm font-medium text-slate-900">Notifikasi</h3>
    </div>
    
    <div class="max-h-96 overflow-y-auto">
        @for ($i = 1; $i <= 5; $i++)
            <div class="px-4 py-3 hover:bg-slate-50 border-b border-slate-50 last:border-b-0">
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-slate-900 font-medium">Notifikasi Baru</p>
                        <p class="text-xs text-slate-500 mt-1">21 September 2023</p>
                    </div>
                </div>
            </div>
        @endfor
    </div>
    
    <div class="px-4 py-3 border-t border-slate-100">
        <form action="" method="POST" id="read_all_admin">
            @csrf
            <button type="submit" class="text-xs text-blue-600 hover:text-blue-700 font-medium">Tandai semua dibaca</button>
        </form>
    </div>
</div>