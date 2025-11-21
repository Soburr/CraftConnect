@extends('layouts.admin')

@section('title', 'Testimonials')

@section('content')

<table class="w-full border mt-6">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-2">User</th>
            <th class="p-2">Message</th>
            <th class="p-2">Status</th>
            <th class="p-2">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($testimonials as $testimonial)
           <tr class="border-b">
              <td class="p-2">
                 {{ $testimonial->name ?? 'Guest User'}}
              </td>
              <td class="p-2">{{ $testimonial->message }}</td>
              <td class="p-2 capitalize">{{ $testimonial->status}}</td>
              <td class="p-2 flex gap-2">
                @if ($testimonial->status === 'pending')
                    <form method="POST" action="{{ route('admin.testimonials.approve', $testimonial->id) }}">
                       @csrf
                       <button class="px-3 py-1 bg-green-600 text-white rounded">Approve</button>
                    </form>

                    <form action="POST" action="{{ route('admin.testimonials.reject', $testimonial->id) }}">
                        @csrf
                        <button class="px-3 py-1 bg-red-600 text-white rounded">Reject</button>
                     </form>
                @endif
              </td>
           </tr>
            
        @endforeach
    </tbody>

</table>


@endsection