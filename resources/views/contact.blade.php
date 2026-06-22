@extends('layouts.app')

@section('title', __('contact.title') . ' - ' . __('app.site_name'))

@section('content')

<section class="bg-gray-900 text-white py-14 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <p class="text-yellow-400 text-sm font-bold tracking-widest uppercase mb-3">Contactez-nous</p>
        <h1 class="text-4xl font-extrabold mb-2" style="color:#fbbf24">{{ __('contact.title') }}</h1>
        <p class="text-gray-400">Nous sommes là pour vous aider — réponse sous 24h.</p>
    </div>
</section>

<div class="max-w-5xl mx-auto px-4 py-12">
    <div class="grid md:grid-cols-3 gap-10">

        {{-- Form --}}
        <div class="md:col-span-2">
            <div class="bg-white rounded-2xl shadow p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Envoyez-nous un message</h2>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-300 text-green-800 rounded-xl p-4 mb-6 flex items-center gap-3">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('contact.name') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-400 @enderror">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('contact.phone') }}</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('contact.email') }}</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('contact.subject') }}</label>
                        <input type="text" name="subject" value="{{ old('subject') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('contact.message') }} <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message" rows="5" required
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                            class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> {{ __('contact.send') }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Info sidebar --}}
        <div class="space-y-4">
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="font-bold text-gray-700 mb-5 text-lg">{{ __('contact.our_contact') }}</h3>
                <ul class="space-y-5 text-sm">
                    @if($contact_phone)
                    <li class="flex items-start gap-3">
                        <span class="w-9 h-9 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-indigo-600 text-xs"></i>
                        </span>
                        <div>
                            <p class="font-semibold text-gray-700 mb-0.5">Téléphone</p>
                            <a href="tel:{{ $contact_phone }}" class="text-indigo-600 hover:underline">{{ $contact_phone }}</a>
                        </div>
                    </li>
                    @endif

                    @if($contact_email)
                    <li class="flex items-start gap-3">
                        <span class="w-9 h-9 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-indigo-600 text-xs"></i>
                        </span>
                        <div>
                            <p class="font-semibold text-gray-700 mb-0.5">Email</p>
                            <a href="mailto:{{ $contact_email }}" class="text-indigo-600 hover:underline">{{ $contact_email }}</a>
                        </div>
                    </li>
                    @endif

                    @if($contact_address)
                    <li class="flex items-start gap-3">
                        <span class="w-9 h-9 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-indigo-600 text-xs"></i>
                        </span>
                        <div>
                            <p class="font-semibold text-gray-700 mb-0.5">{{ __('contact.address') }}</p>
                            <p class="text-gray-500 leading-relaxed">{{ $contact_address }}@if($contact_city)<br>{{ $contact_city }}@endif</p>
                        </div>
                    </li>
                    @endif

                    @if($contact_hours)
                    <li class="flex items-start gap-3">
                        <span class="w-9 h-9 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clock text-indigo-600 text-xs"></i>
                        </span>
                        <div>
                            <p class="font-semibold text-gray-700 mb-0.5">{{ __('contact.hours') }}</p>
                            <p class="text-gray-500">{{ $contact_hours }}</p>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>

            {{-- Google Map embed --}}
            @if($contact_map)
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <iframe src="{{ $contact_map }}"
                        width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" class="w-full"></iframe>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
