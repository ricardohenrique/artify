@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('Artify-notification.png') }}" class="logo" alt="Artify Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
