<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Customer</th>
        <th>Store</th>
        <th>Total</th>
        <th>GrandTotal</th>
        <th>Status</th>
        <th>Transaction Id</th>
    </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr >
                <td>{{ $order->id }}</td>
                <td>{{ $order->customer->phone_no }}</td>
                <td>{{ $order->store->name}} </td>
                <td>{{ $order->total_without_gst}}</td>
                <td>{{ $order->total_with_gst}}</td>
                <td>{{ $order->status}}</td>
                <td>{{ $order->transaction_id}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
