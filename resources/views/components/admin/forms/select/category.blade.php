@props(['category', 'selectedCategory' => null, 'level' => 0])

@php
    // Define the space for indentation
    $space = str_repeat('&nbsp;', $level * 3);
@endphp

<option @selected(in_array($category->id, [$selectedCategory?->parent_id, old('parent_id')]) ) value="{{ $category->id }}">
    {!! $space !!}{{ app()->getLocale() === 'en' ? $category->title_en : $category->title }}
</option>

@if ($category->children->isNotEmpty())
    @foreach ($category->children as $child)
        <x-admin.forms.select.category :category="$child" :selectedCategory="$selectedCategory" :level="$level + 1" />
    @endforeach
@endif
