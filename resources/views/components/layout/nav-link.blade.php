@props([
    'href',
    'active' => request()->url() === $href,
])


<a href="{{ $href }}"
   {{ $attributes->merge([
       'class' => 'block px-2 py-1 rounded transition duration-150 ease-in-out ' .
                  ($active ? 'bg-blue-600 text-white' : 'hover:bg-[#0a1a2f]')
   ]) }}>
   {{ $slot }}
</a>
