@extends('layouts.admin')

@section('title', 'Message de ' . $contactMessage->name)

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow p-6">
        <dl class="space-y-4">
            <div class="grid grid-cols-3 gap-2 text-sm border-b pb-4">
                <dt class="text-gray-500 font-medium">Nom</dt>
                <dd class="col-span-2 text-gray-800 font-semibold">{{ $contactMessage->name }}</dd>
            </div>
            @if($contactMessage->email)
            <div class="grid grid-cols-3 gap-2 text-sm border-b pb-4">
                <dt class="text-gray-500 font-medium">Email</dt>
                <dd class="col-span-2">
                    <a href="mailto:{{ $contactMessage->email }}" class="text-indigo-600 hover:underline">{{ $contactMessage->email }}</a>
                </dd>
            </div>
            @endif
            @if($contactMessage->phone)
            <div class="grid grid-cols-3 gap-2 text-sm border-b pb-4">
                <dt class="text-gray-500 font-medium">Téléphone</dt>
                <dd class="col-span-2">
                    <a href="tel:{{ $contactMessage->phone }}" class="text-indigo-600 hover:underline">{{ $contactMessage->phone }}</a>
                </dd>
            </div>
            @endif
            @if($contactMessage->subject)
            <div class="grid grid-cols-3 gap-2 text-sm border-b pb-4">
                <dt class="text-gray-500 font-medium">Sujet</dt>
                <dd class="col-span-2 text-gray-700">{{ $contactMessage->subject }}</dd>
            </div>
            @endif
            <div class="grid grid-cols-3 gap-2 text-sm border-b pb-4">
                <dt class="text-gray-500 font-medium">Date</dt>
                <dd class="col-span-2 text-gray-500">{{ $contactMessage->created_at->format('d/m/Y à H:i') }}</dd>
            </div>
            <div class="text-sm">
                <dt class="text-gray-500 font-medium mb-2">Message</dt>
                <dd class="bg-gray-50 rounded-xl p-4 text-gray-800 leading-relaxed whitespace-pre-line">{{ $contactMessage->message }}</dd>
            </div>
        </dl>

        <div class="mt-6 flex gap-3">
            @if($contactMessage->email)
            <a href="mailto:{{ $contactMessage->email }}"
               class="bg-indigo-600 text-white font-bold px-5 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                <i class="fas fa-reply mr-1"></i> Répondre par email
            </a>
            @endif
            @if($contactMessage->phone)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactMessage->phone) }}" target="_blank"
               class="bg-green-500 text-white font-bold px-5 py-2 rounded-lg hover:bg-green-600 transition text-sm">
                <i class="fab fa-whatsapp mr-1"></i> WhatsApp
            </a>
            @endif
            <a href="{{ route('admin.contact-messages.index') }}"
               class="border border-gray-300 px-5 py-2 rounded-lg hover:bg-gray-50 text-gray-700 text-sm ml-auto">
                ← Retour
            </a>
        </div>
    </div>
</div>
@endsection
