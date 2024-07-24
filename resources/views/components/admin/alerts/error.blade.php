<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition:leave="transition ease-out duration-1000"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    @if ($errors->any())
        <div role="alert" class="alert alert-error shadow-lg w-fit ml-auto absolute top-14 right-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
