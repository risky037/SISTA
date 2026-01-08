@php
    $gradeColor = match (strtoupper($grade)) {
        'A', 'A+', 'A-' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
        'B', 'B+', 'B-' => 'bg-blue-100 text-blue-700 border-blue-200',
        'C', 'C+', 'C-' => 'bg-amber-100 text-amber-700 border-amber-200',
        default => 'bg-rose-100 text-rose-700 border-rose-200',
    };
@endphp
<span
    class="inline-flex items-center justify-center min-w-[36px] px-2 py-2 rounded-xl font-black text-xs border shadow-sm {{ $gradeColor }}">
    {{ $grade }}
</span>
