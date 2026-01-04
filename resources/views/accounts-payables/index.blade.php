@extends('layouts.app')

@section('title', 'Accounts Payable')
@section('page-title', 'Accounts Payable')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
  <div class="p-6 border-b">
    <h2 class="text-lg font-semibold text-gray-900">Daftar Hutang Supplier</h2>
    <p class="text-sm text-gray-500">Monitoring kewajiban pembayaran</p>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-gray-50 text-gray-600">
        <tr>
          <th class="px-6 py-3 text-left">AP Number</th>
          <th class="px-6 py-3 text-left">Supplier</th>
          <th class="px-6 py-3 text-right">Total</th>
          <th class="px-6 py-3 text-right">Sisa</th>
          <th class="px-6 py-3 text-center">Status</th>
          <th class="px-6 py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @foreach($aps as $ap)
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-4 font-medium">{{ $ap->ap_number }}</td>
          <td class="px-6 py-4">{{ $ap->supplier->name }}</td>
          <td class="px-6 py-4 text-right">
            Rp {{ number_format($ap->amount, 0, ',', '.') }}
          </td>
          <td class="px-6 py-4 text-right">
            Rp {{ number_format($ap->remaining_amount, 0, ',', '.') }}
          </td>
          <td class="px-6 py-4 text-center">
            <span class="px-3 py-1 rounded-full text-xs font-medium
                            @if($ap->status === 'paid') bg-green-100 text-green-700
                            @elseif($ap->status === 'partial') bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700 @endif">
              {{ ucfirst($ap->status) }}
            </span>
          </td>
          <td class="px-6 py-4 text-center">
            <a href="{{ route('accounts-payables.show', $ap) }}" class="text-blue-600 hover:underline">
              Detail
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection