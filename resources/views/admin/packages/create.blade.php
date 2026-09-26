<x-layouts.admin :title="'Add package | ToursHub'">
    <div class="mb-8"><a href="{{ route('admin.packages.index') }}" class="text-sm font-semibold text-[#a84e31]">← Back to packages</a><h1 class="serif mt-4 text-4xl">Add a package</h1><p class="mt-2 text-sm text-[#6d776c]">Create an experience guests can request from the landing page.</p></div>
    <form class="shadow-soft max-w-4xl rounded-2xl border border-[#ebe8df] bg-white p-6 sm:p-8" method="POST" action="{{ route('admin.packages.store') }}">@include('admin.packages._form', ['submitLabel' => 'Create package'])</form>
</x-layouts.admin>
