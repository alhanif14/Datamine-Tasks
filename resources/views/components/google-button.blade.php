@props(['text' => 'Continue with Google'])

<a href="{{ route('google.redirect') }}"
    class="w-full flex items-center justify-center gap-3 py-2.5 
           border border-gray-300 rounded-lg bg-white 
           hover:bg-gray-100 transition font-medium text-gray-700">

    <!-- Google Icon -->
    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
         class="w-5 h-5" alt="Google">

    <span>{{ $text }}</span>
</a>
