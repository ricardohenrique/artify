@props([
    'title' => '',
    'highlight' => null,
    'emphasize' => false,
])

<div class="category-heading mb-4">
    <h2 class="category-title">
        @if ($highlight)
            {!! str_replace(
                ':highlight',
                $emphasize ? '<em>' . e($highlight) . '</em>' : '<strong>' . e($highlight) . '</strong>',
                e($title)
            ) !!}
        @else
            {{ $title }}
        @endif
    </h2>
</div>

<style>
    .category-heading {
        text-align: center;
        position: relative;
        margin-bottom: 3rem;
    }

    .category-title {
        display: inline-block;
        font-size: 27px;
        font-weight: 200;
        color: #333;
        position: relative;
        padding-bottom: 10px;
    }

    .category-title::after {
        content: '';
        display: block;
        height: 5px;
        width: 60%;
        margin: 8px auto 0;
        background: linear-gradient(90deg, #ff7c5c, #ff4e9b);
        border-radius: 3px;
        transition: width 0.3s ease;
    }
</style>