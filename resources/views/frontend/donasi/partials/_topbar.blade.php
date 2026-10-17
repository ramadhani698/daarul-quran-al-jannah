<div class="donasi-topbar">
    <div class="donasi-topbar__wrap">
        <div class="donasi-topbar__left">
            @if ($backUrl)
                <a href="{{ $backUrl }}" class="donasi-topbar__back">
                    &larr; {{ $backLabel }}
                </a>
            @endif
        </div>
        <div class="donasi-topbar__right">
            @if ($showCekStatus)
                <a href="{{ route('donasi.cek-form') }}" class="donasi-topbar__cek-status">
                    Cek Status Donasi &rarr;
                </a>
            @endif
        </div>
    </div>
</div>
