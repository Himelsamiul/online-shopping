@extends('backend.master')

@section('content')
<style>
    /* Container styling */
    .container {
        max-width: 1000px;
        margin: 50px auto;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h1 {
        color: #2c3e50;
        text-align: center;
        margin-bottom: 25px;
        letter-spacing: 1.3px;
        font-weight: 700;
        user-select: none;
    }

    /* Alert styling */
    .alert {
        border-radius: 12px;
        font-weight: 600;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Search box */
    #searchInput {
        width: 100%;
        padding: 12px 20px;
        margin-bottom: 25px;
        border-radius: 25px;
        border: 2px solid #3498db;
        font-size: 16px;
        outline: none;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        box-sizing: border-box;
    }
    #searchInput:focus {
        border-color: #2980b9;
        box-shadow: 0 0 12px rgba(41, 128, 185, 0.5);
    }

    /* Table Styling */
    table {
        width: 100%;
        border-collapse: collapse;
        box-shadow: 0 8px 25px rgba(52, 152, 219, 0.15);
        border-radius: 12px;
        overflow: hidden;
        background: white;
    }

    thead {
        background: linear-gradient(90deg, #2980b9, #3498db);
        color: white;
        position: sticky;
        top: 0;
        z-index: 10;
        box-shadow: 0 5px 10px rgba(0,0,0,0.15);
    }

    thead tr {
        user-select: none;
    }

    th, td {
        padding: 15px 18px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
        transition: background-color 0.3s ease;
    }

    tbody tr:hover {
        background-color: #d6eaff;
        cursor: pointer;
        transform: translateX(5px);
        box-shadow: 3px 3px 10px rgba(52, 152, 219, 0.2);
        transition: all 0.3s ease;
    }

    /* Delete button */
    .btn-danger {
        background: linear-gradient(45deg, #e74c3c, #c0392b);
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 600;
        color: white;
        transition: background 0.3s ease, box-shadow 0.3s ease;
        user-select: none;
        box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
    }
    .btn-danger:hover {
        background: linear-gradient(45deg, #c0392b, #992d22);
        box-shadow: 0 8px 25px rgba(192, 57, 43, 0.7);
        transform: scale(1.05);
    }

    /* Responsive */
    @media(max-width: 720px) {
        table, thead, tbody, th, td, tr {
            display: block;
        }
        thead tr {
            position: relative;
        }
        tbody tr {
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 12px;
            padding: 20px;
            background: #fff;
            transform: none !important;
        }
        tbody tr:hover {
            background-color: #fff;
            box-shadow: 0 5px 20px rgba(52, 152, 219, 0.3);
        }
        tbody td {
            text-align: right;
            padding-left: 50%;
            position: relative;
            border: none;
            border-bottom: 1px solid #ddd;
        }
        tbody td::before {
            content: attr(data-label);
            position: absolute;
            left: 20px;
            width: calc(50% - 40px);
            padding-left: 15px;
            font-weight: 700;
            text-align: left;
            color: #3498db;
        }
        tbody td:last-child {
            border-bottom: 0;
        }
    }
</style>

<div class="container">
    <h1>Customer List</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <input type="text" id="searchInput" placeholder="Search customers by name, email or phone...">

    @if($customers->isEmpty())
        <div class="alert alert-info">No customers found.</div>
    @else
        <table id="customerTable" aria-label="Customer List Table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td data-label="SL">{{ $loop->iteration }}</td>
                        <td data-label="Name">{{ $customer->name }}</td>
                        <td data-label="Email">{{ $customer->email }}</td>
                        <td data-label="Phone Number">{{ $customer->phoneno }}</td>
                        <td data-label="Address">{{ $customer->address }}</td>
                        <td data-label="Action">
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
    // Filter table rows dynamically based on search input
    document.getElementById('searchInput').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#customerTable tbody tr');

        rows.forEach(row => {
            const name = row.querySelector('td[data-label="Name"]').textContent.toLowerCase();
            const email = row.querySelector('td[data-label="Email"]').textContent.toLowerCase();
            const phone = row.querySelector('td[data-label="Phone Number"]').textContent.toLowerCase();

            if (name.includes(filter) || email.includes(filter) || phone.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Optional: Floating effect on delete buttons on hover
    document.querySelectorAll('.btn-danger').forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            btn.style.transform = 'translateY(-3px)';
            btn.style.boxShadow = '0 10px 20px rgba(231, 76, 60, 0.6)';
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.transform = 'translateY(0)';
            btn.style.boxShadow = '0 5px 15px rgba(231, 76, 60, 0.4)';
        });
    });
</script>
@endsection
