@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'bg-red-100 text-red-800 p-3 rounded mb-4']) }}>
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
