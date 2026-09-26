<x-layouts.admin :title="'Edit package | ToursHub'">
    <div class="mb-8"><a href="{{ route('admin.packages.index') }}" class="text-sm font-semibold text-[#a84e31]">← Back to packages</a><h1 class="serif mt-4 text-4xl">Edit package</h1><p class="mt-2 text-sm text-[#6d776c]">Update {{ $package->title }} and its landing-page visibility.</p></div>
    <form class="shadow-soft max-w-4xl rounded-2xl border border-[#ebe8df] bg-white p-6 sm:p-8" method="POST" action="{{ route('admin.packages.update', $package) }}">@method('PUT') @include('admin.packages._form', ['submitLabel' => 'Save changes'])</form>
</x-layouts.admin>
