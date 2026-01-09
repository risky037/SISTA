<div class="flex flex-col items-center justify-center py-16 px-6 text-center">
    <div class="w-40 h-40 mb-6">
        @if ($icon === 'proposal')
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                <rect x="40" y="30" width="120" height="140" rx="16" class="fill-slate-100 stroke-slate-200"
                    stroke-width="2" />
                <rect x="60" y="60" width="80" height="10" rx="5" class="fill-slate-300" />
                <rect x="60" y="80" width="60" height="10" rx="5" class="fill-slate-200" />
                <circle cx="100" cy="130" r="18" class="fill-green-100 stroke-green-400" stroke-width="2" />
                <path d="M92 130L98 136L110 124" class="stroke-green-600" stroke-width="3" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        @else
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                <path d="M60 30H120L150 60V170H60V30Z" class="fill-slate-100 stroke-slate-200" stroke-width="2" />
                <path d="M120 30V60H150" class="fill-slate-200" />
                <rect x="75" y="80" width="70" height="10" rx="5" class="fill-slate-300" />
                <rect x="75" y="100" width="50" height="10" rx="5" class="fill-slate-200" />
                <circle cx="100" cy="140" r="16" class="fill-blue-100 stroke-blue-400" stroke-width="2" />
                <path d="M100 132V148M92 140H108" class="stroke-blue-600" stroke-width="3" stroke-linecap="round" />
            </svg>
        @endif
    </div>

    <h3 class="text-lg font-bold text-slate-700 mb-1">
        {{ $text }}
    </h3>
    <p class="text-sm text-slate-400 max-w-sm">
        Data akan muncul setelah proses penilaian dilakukan oleh dosen pembimbing atau penguji.
    </p>
</div>
