@php
    $categories = \App\Models\Category::all();
@endphp
<aside class="sidebar flex flex-col justify-between">
    <div class="flex flex-col">
        <div class="brand text-4xl font-bold text-primary">Todo App</div>
        <div class="card">
            <div style="font-weight:600" class="text-light">Categories</div>
            <ul id="category-list" class="category-list"></ul>
                <div class="flex flex-col gap-2  font-medium">
                    @if($categories->isNotEmpty())
                        @if($categories->count() > 1)
                        <button onclick="filterTasks('all', this)" class="px-3 text-white py-2 bg-primary shadow-sm text-left filter-btn rounded-sm">All</button>
                        @endif
                            @foreach ($categories as $category )
                                <button onclick="filterTasks('{{ $category->id }}', this)" class="px-3 py-2 text-dark bg-white shadow-sm text-left filter-btn rounded-sm">{{ $category->name }}</button>
                            @endforeach
                    @endif
                </div>

                <form id="add-category-form" class="form-row" action="addCategory" method="post">
                    @csrf
                    <input id="category-input" name="category-title" placeholder="New category" autocomplete="off" class="form-input w-full" />
                    <button id="add-category-btn" class="btn btn-primary" type="submit">Add</button>
                </form>
                 @error('category-title')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
        </div>
    </div>
    <div class="flex gap-8 items-center">
        <a href="/login" class="flex gap-1 btn btn-primary"><img src={{ asset('../images/Signin.svg') }} style="filter: brightness(0) saturate(100%) invert(100%) sepia(1%) saturate(321%) hue-rotate(339deg) brightness(115%) contrast(100%);"/>Login</a>
    </div>
</aside>
