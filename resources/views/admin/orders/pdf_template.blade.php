<!DOCTYPE html>
<html>
<head>
    <title>My Website Title</title>
    <style>
        /* Basic Bootstrap table styling */
        table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
            border: 1px solid #dee2e6;
            table-layout: fixed;
        }
    
        th, td {
            padding: 0.75rem;
            vertical-align: top;
            border: 1px solid #dee2e6;
            word-wrap: break-word;
            font-size:11px;
        }
    
        th {
            text-align: left;
            background-color: #f8f9fa;
            font-weight: bold;
        }
    
        tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }
    
        tbody tr:hover {
            background-color: #e9ecef;
        }
    
        /* Borderless table option */
        .table-borderless th, .table-borderless td {
            border: 0;
        }
    
        /* Striped table rows */
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.05);
        }
    
        /* Hoverable table rows */
        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,.075);
        }
        .badge {
        display: inline-block;
        padding: 0.25em 0.4em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }

    .badge-primary {
        color: #fff;
        background-color: #007bff;
    }

    .badge-secondary {
        color: #fff;
        background-color: #6c757d;
    }

    .badge-success {
        color: #fff;
        background-color: #28a745;
    }

    .badge-danger {
        color: #fff;
        background-color: #dc3545;
    }

    .badge-warning {
        color: #212529;
        background-color: #ffc107;
    }

    .badge-info {
        color: #fff;
        background-color: #17a2b8;
    }

    .badge-light {
        color: #212529;
        background-color: #f8f9fa;
    }

    .badge-dark {
        color: #fff;
        background-color: #343a40;
    }
    </style>
    
</head>
<body class="c-app">
    <div class="c-wrapper">
        <div class="c-body">
            <main class="c-main pt-0">
                <div class="container-fluid">
                    <table class="table table-borderless table-striped" style="width:100%;">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Code</th>
                                <th scope="col">User</th>
                                <th scope="col">Member</th>
                                <th scope="col">Membership No</th>
                                <th scope="col">Cell No</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Total</th>
                                <th scope="col">Grand Total</th>
                                <th scope="col">Payment Type</th>
                                <th scope="col">Items</th>
                              </tr>
                        </thead>
                        <tbody>
                                @foreach ($allOrders as $key=>$order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->tableTop->code }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->member->name }}</td>
                                    <td>{{ $order->member->membership_no }}</td>
                                    <td>{{ $order->member->cell_no }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->total }}</td>
                                    <td>{{ $order->grand_total }}</td>
                                    <td>{{ ucfirst($order->payment_type) }}</td>
                                    <td>
                                        @foreach ($order->items as $item) 
                                                <span class="badge badge-info">{{ $item->pivot->quantity }} - x - {{ $item->title }}</span>
                                        @endforeach     
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    
</body>
</html>