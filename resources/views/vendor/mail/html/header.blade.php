@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="{{ asset('assets/images/logo_presensi.png') }}" class="logo" alt="E-Presensi Logo">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
