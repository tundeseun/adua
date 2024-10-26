@extends('layout.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Payments</h2>

    <!-- Search Box -->
    <input type="text" id="searchPayments" class="form-control mb-3" placeholder="Search Payments by Status or Transaction Reference...">

    <!-- Payments Table -->
    <table class="table table-striped table-hover" id="paymentTable">
        <thead class="table-warning">
            <tr>
          
                <th>Amount (₦)</th>
                <th>Status</th>
                <th>Transaction Reference</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="paymentTableBody">
            @foreach($payments as $payment)
            <tr>
                
                <td>{{ number_format($payment->amount, 2) }}</td>
                <td>{{ $payment->status }}</td>
                <td>{{ $payment->transaction_reference }}</td>
                <td>{{ $payment->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $payments->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#searchPayments').on('keyup', function() {
            let query = $(this).val();
            $.ajax({
                url: "{{ route('reports.payments') }}",
                type: 'GET',
                data: { search: query },
                success: function(data) {
                    $('#paymentTableBody').html(data.html);
                }
            });
        });
    });
</script>
@endsection
