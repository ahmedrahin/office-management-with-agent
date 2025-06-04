<div>
    @php
        $setting = App\Models\Settings::first();
    @endphp
    <div class="flex items-center space-x-3">
        <img src="{{ asset($setting->logo ?? '') }}" class="company-logo" alt="Company Logo">
        <div>
            <h4 class="font-bold company-name">{{ $setting->company_name ?? '' }}</h4>
            <p class="text-sm text-muted">{{ $setting->phone1 ? $setting->phone1 . ',' : '' }} {{ $setting->address ?? '' }}</p>

        </div>
    </div>
</div>