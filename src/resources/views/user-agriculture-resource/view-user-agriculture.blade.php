<x-filament-panels::page>
    @php
        $lahanList = \App\Models\Lahan::query()
            ->where('user_id', $record->id)
            ->latest()
            ->get();

        $plans = \App\Models\PreProductionPlan::query()
            ->with(['lahan', 'commodity', 'commodityType'])
            ->where('user_id', $record->id)
            ->latest()
            ->get();

        $taskChecks = \App\Models\ExecutionTaskCheck::query()
            ->with(['preProductionPlan.lahan', 'plantingGuideTask'])
            ->where('user_id', $record->id)
            ->latest()
            ->get()
            ->groupBy(function ($check) {
                return $check->pre_production_plan_id . '-' . $check->day_number;
            });

        $pestReports = \App\Models\ExecutionPestReport::query()
            ->with(['preProductionPlan.lahan', 'pest', 'disease'])
            ->where('user_id', $record->id)
            ->latest()
            ->get();

        $expenseReports = \App\Models\ExecutionExpense::query()
            ->with(['items', 'preProductionPlan.lahan'])
            ->where('user_id', $record->id)
            ->latest()
            ->get();

        $totalExpense = $expenseReports->sum('total_amount');
    @endphp

    <div class="space-y-6">

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5">
            <h2 class="text-2xl font-bold text-gray-900">
                Detail User
            </h2>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="font-semibold text-gray-500">Nama</p>
                    <p class="text-gray-900">{{ $record->name }}</p>
                </div>

                <div>
                    <p class="font-semibold text-gray-500">Email</p>
                    <p class="text-gray-900">{{ $record->email }}</p>
                </div>

                <div>
                    <p class="font-semibold text-gray-500">Tanggal Daftar</p>
                    <p class="text-gray-900">{{ $record->created_at?->format('d M Y H:i') }}</p>
                </div>

                <div>
                    <p class="font-semibold text-gray-500">Total Pengeluaran</p>
                    <p class="text-amber-700 font-bold">
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5">
            <div class="flex items-center justify-between gap-4 mb-4">
                <h3 class="text-xl font-bold text-gray-900">
                    Lahan yang Didaftarkan
                </h3>

                <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-bold text-emerald-700">
                    {{ $lahanList->count() }} Lahan
                </span>
            </div>

            @if($lahanList->isEmpty())
                <div class="rounded-xl bg-gray-50 p-4 text-sm text-gray-500">
                    User ini belum mendaftarkan lahan.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50 text-left text-gray-600">
                                <th class="p-3">Nama Lahan</th>
                                <th class="p-3">Luas</th>
                                <th class="p-3">Jenis Tanah</th>
                                <th class="p-3">Koordinat</th>
                                <th class="p-3">Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lahanList as $lahan)
                                <tr class="border-b">
                                    <td class="p-3 font-semibold text-gray-900">
                                        {{ $lahan->nama_lahan ?? '-' }}
                                    </td>
                                    <td class="p-3">
                                        {{ $lahan->luas_meter_persegi ?? '-' }} m²
                                    </td>
                                    <td class="p-3">
                                        {{ $lahan->soilType?->name ?? $lahan->jenis_tanah ?? '-' }}
                                    </td>
                                    <td class="p-3">
                                        @if(is_array($lahan->koordinat_lahan))
                                            {{ collect($lahan->koordinat_lahan)->filter()->implode(', ') }}
                                        @else
                                            {{ $lahan->koordinat_lahan ?? '-' }}
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        {{ $lahan->created_at?->format('d M Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5">
            <div class="flex items-center justify-between gap-4 mb-4">
                <h3 class="text-xl font-bold text-gray-900">
                    Riwayat Pra Production
                </h3>

                <span class="rounded-full bg-blue-50 px-3 py-1 text-sm font-bold text-blue-700">
                    {{ $plans->count() }} Data
                </span>
            </div>

            @if($plans->isEmpty())
                <div class="rounded-xl bg-gray-50 p-4 text-sm text-gray-500">
                    User ini belum membuat Pra Production.
                </div>
            @else
                <div class="space-y-4">
                    @foreach($plans as $plan)
                        <div class="rounded-xl border border-gray-200 p-4">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                <div>
                                    <h4 class="font-bold text-gray-900">
                                        {{ $plan->lahan?->nama_lahan ?? 'Lahan Tidak Ditemukan' }}
                                    </h4>

                                    <p class="text-sm text-gray-500">
                                        {{ $plan->commodity?->name ?? '-' }} /
                                        {{ $plan->commodityType?->name ?? '-' }}
                                    </p>
                                </div>

                                <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-bold text-emerald-700">
                                    Hari ke-{{ $plan->current_day }} dari {{ $plan->duration_days }}
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                                <div class="rounded-xl bg-gray-50 p-3">
                                    <p class="font-semibold text-gray-500">Status Tanam</p>
                                    <p class="text-gray-900">{{ $plan->planting_status ?? '-' }}</p>
                                </div>

                                <div class="rounded-xl bg-gray-50 p-3">
                                    <p class="font-semibold text-gray-500">Anggaran</p>
                                    <p class="text-gray-900">
                                        Rp {{ number_format($plan->budget ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="rounded-xl bg-gray-50 p-3">
                                    <p class="font-semibold text-gray-500">Status Aktif</p>
                                    <p class="text-gray-900">
                                        {{ $plan->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </p>
                                </div>
                            </div>

                            @if($plan->notes)
                                <p class="mt-3 text-sm text-gray-600">
                                    <strong>Catatan:</strong> {{ $plan->notes }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-xl font-bold text-gray-900">
            Riwayat Checklist Harian
        </h3>

        <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-bold text-emerald-700">
            {{ $taskChecks->flatten()->count() }} Checklist
        </span>
    </div>

    @if($taskChecks->isEmpty())
        <div class="rounded-xl bg-gray-50 p-4 text-sm text-gray-500">
            Belum ada checklist harian dari user ini.
        </div>
    @else
        <div class="space-y-4">
            @foreach($taskChecks as $group)
                @php
                    $first = $group->first();
                    $doneCount = $group->where('is_done', true)->count();
                    $totalCount = $group->count();
                @endphp

                <div class="rounded-xl border border-gray-200 p-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-4">
                        <div>
                            <h4 class="font-bold text-gray-900">
                                {{ $first->preProductionPlan?->lahan?->nama_lahan ?? 'Lahan Tidak Ditemukan' }}
                            </h4>

                            <p class="text-sm text-gray-500">
                                Hari ke-{{ $first->day_number }}
                            </p>
                        </div>

                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-bold text-emerald-700">
                            {{ $doneCount }} / {{ $totalCount }} selesai
                        </span>
                    </div>

                    <div class="space-y-2">
                        @foreach($group as $check)
                            <div class="rounded-xl bg-gray-50 p-3 flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        {{ $check->plantingGuideTask?->title ?? 'Tugas Tidak Ditemukan' }}
                                    </p>

                                    @if($check->plantingGuideTask?->description)
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $check->plantingGuideTask->description }}
                                        </p>
                                    @endif

                                    @if($check->checked_at)
                                        <p class="text-xs text-gray-400 mt-1">
                                            Diceklis pada {{ $check->checked_at->format('d M Y H:i') }}
                                        </p>
                                    @endif
                                </div>

                                @if($check->is_done)
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                        Selesai
                                    </span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-500">
                                        Belum
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5">
            <div class="flex items-center justify-between gap-4 mb-4">
                <h3 class="text-xl font-bold text-gray-900">
                    Riwayat Laporan Hama / Penyakit
                </h3>

                <span class="rounded-full bg-red-50 px-3 py-1 text-sm font-bold text-red-700">
                    {{ $pestReports->count() }} Laporan
                </span>
            </div>

            @if($pestReports->isEmpty())
                <div class="rounded-xl bg-gray-50 p-4 text-sm text-gray-500">
                    Belum ada laporan hama atau penyakit dari user ini.
                </div>
            @else
                <div class="space-y-4">
                    @foreach($pestReports as $report)
                        @php
                            $isDisease = $report->report_type === 'penyakit';
                            $item = $isDisease ? $report->disease : $report->pest;
                            $typeLabel = $isDisease ? 'Penyakit' : 'Hama';
                            $typeClass = $isDisease ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700';
                        @endphp

                        <div class="rounded-xl border border-gray-200 p-4">
                            <div class="flex flex-col md:flex-row gap-4">
                                @if($report->photo_path)
                                    <img src="{{ asset('storage/' . $report->photo_path) }}"
                                         alt="Foto {{ $typeLabel }}"
                                         class="h-40 w-full md:w-48 rounded-xl object-cover border">
                                @else
                                    <div class="h-40 w-full md:w-48 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400">
                                        Tidak ada foto
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                        <div>
                                            <span class="rounded-full px-3 py-1 text-xs font-bold {{ $typeClass }}">
                                                {{ $typeLabel }}
                                            </span>

                                            <h4 class="mt-2 font-bold text-gray-900">
                                                {{ $item?->name ?? $typeLabel . ' Tidak Ditemukan' }}
                                            </h4>

                                            <p class="text-sm text-gray-500">
                                                Lahan:
                                                {{ $report->preProductionPlan?->lahan?->nama_lahan ?? '-' }}
                                            </p>
                                        </div>

                                        <span class="rounded-full bg-gray-50 px-3 py-1 text-sm font-bold text-gray-700">
                                            Hari ke-{{ $report->day_number }}
                                        </span>
                                    </div>

                                    @if($item?->description)
                                        <div class="mt-3 rounded-xl bg-red-50 p-3 text-sm text-red-800">
                                            <strong>Deskripsi / Gejala:</strong>
                                            {{ $item->description }}
                                        </div>
                                    @endif

                                    @if($item?->solution)
                                        <div class="mt-3 rounded-xl bg-emerald-50 p-3 text-sm text-emerald-800">
                                            <strong>Rekomendasi:</strong>
                                            {{ $item->solution }}
                                        </div>
                                    @endif

                                    @if($report->notes)
                                        <p class="mt-3 text-sm text-gray-600">
                                            <strong>Catatan User:</strong> {{ $report->notes }}
                                        </p>
                                    @endif

                                    <p class="mt-3 text-xs text-gray-400">
                                        Dikirim pada {{ $report->created_at?->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5">
            <div class="flex items-center justify-between gap-4 mb-4">
                <h3 class="text-xl font-bold text-gray-900">
                    Riwayat Pengeluaran Harian
                </h3>

                <span class="rounded-full bg-amber-50 px-3 py-1 text-sm font-bold text-amber-700">
                    Total: Rp {{ number_format($totalExpense, 0, ',', '.') }}
                </span>
            </div>

            @if($expenseReports->isEmpty())
                <div class="rounded-xl bg-gray-50 p-4 text-sm text-gray-500">
                    Belum ada pengeluaran dari user ini.
                </div>
            @else
                <div class="space-y-4">
                    @foreach($expenseReports as $expense)
                        <div class="rounded-xl border border-gray-200 p-4">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-4">
                                <div>
                                    <h4 class="font-bold text-gray-900">
                                        Pengeluaran Hari ke-{{ $expense->day_number }}
                                    </h4>

                                    <p class="text-sm text-gray-500">
                                        {{ $expense->expense_date?->format('d M Y') }} |
                                        Lahan:
                                        {{ $expense->preProductionPlan?->lahan?->nama_lahan ?? '-' }}
                                    </p>
                                </div>

                                <span class="rounded-full bg-amber-50 px-3 py-1 text-sm font-bold text-amber-700">
                                    Rp {{ number_format($expense->total_amount, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="space-y-2">
                                @foreach($expense->items as $item)
                                    <div class="rounded-xl bg-gray-50 p-3 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                        <div>
                                            <p class="font-semibold text-gray-900">
                                                {{ ucwords(str_replace('_', ' ', $item->category)) }}
                                                @if($item->item_name)
                                                    - {{ $item->item_name }}
                                                @endif
                                            </p>

                                            @if($item->description)
                                                <p class="text-xs text-gray-500">
                                                    {{ $item->description }}
                                                </p>
                                            @endif
                                        </div>

                                        <p class="font-bold text-gray-900">
                                            Rp {{ number_format($item->amount, 0, ',', '.') }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>

                            @if($expense->notes)
                                <p class="mt-3 text-sm text-gray-600">
                                    <strong>Catatan:</strong> {{ $expense->notes }}
                                </p>
                            @endif

                            <p class="mt-3 text-xs text-gray-400">
                                Disimpan pada {{ $expense->created_at?->format('d M Y H:i') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-filament-panels::page>