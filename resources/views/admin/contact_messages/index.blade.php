@extends('layouts.admin')

@section('title', 'Messages de contact')

@section('content')
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-3 text-left text-gray-500 font-medium w-4"></th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Nom</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Email / Tél</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Sujet</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Date</th>
                <th class="px-4 py-3 text-right text-gray-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($messages as $msg)
            <tr class="hover:bg-gray-50 {{ !$msg->read ? 'font-semibold bg-indigo-50' : '' }}">
                <td class="px-4 py-3">
                    @if(!$msg->read)
                        <span class="w-2.5 h-2.5 bg-indigo-500 rounded-full block"></span>
                    @endif
                </td>
                <td class="px-4 py-3 text-gray-800">{{ $msg->name }}</td>
                <td class="px-4 py-3 text-gray-500 text-xs">
                    @if($msg->email) <div>{{ $msg->email }}</div> @endif
                    @if($msg->phone) <div>{{ $msg->phone }}</div> @endif
                </td>
                <td class="px-4 py-3 text-gray-600">{{ $msg->subject ?: '-' }}</td>
                <td class="px-4 py-3 text-gray-400 text-xs">{{ $msg->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-4 py-3 text-right flex justify-end gap-3">
                    <a href="{{ route('admin.contact-messages.show', $msg) }}" class="text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-eye"></i>
                    </a>
                    <form action="{{ route('admin.contact-messages.destroy', $msg) }}" method="POST"
                          onsubmit="return confirm('Supprimer ce message ?')" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                    <i class="fas fa-inbox text-3xl mb-2 block"></i>
                    Aucun message reçu pour l'instant.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">
        {{ $messages->links() }}
    </div>
</div>
@endsection
