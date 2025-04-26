<div id="receipt">
    <h2>Order Receipt</h2>

    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Name:</strong> {{ $order->name }}</p>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Address:</strong> {{ $order->address }}</p>

    <h4>Order Details:</h4>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Qty</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>BDT. {{ number_format($item['price'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total: BDT. {{ number_format($order->total_amount, 2) }}</h4>
</div>
<style>
    #receipt {
        font-family: Arial, sans-serif;
        margin: 20px;
        padding: 20px;
        border: 1px solid #ccc;
    }
    h2 {
        text-align: center;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    h4 {
        margin-top: 20px;
    }
    p {
        margin: 5px 0;
    }
    @media print {
        #receipt {
            margin: 0;
            padding: 0;
            border: none;
        }
        h2, h4, p {
            margin: 0;
        }
        table {
            border: none;
        }
        th, td {
            border: none;
        }
    }
</style>
<script>
    window.onload = function() {
        window.print();
    }
</script>