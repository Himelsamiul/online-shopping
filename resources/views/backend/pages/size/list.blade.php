@extends('backend.master')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<style>
    .lock-btn-wrapper {
        position: relative;
        display: inline-block;
    }

    .lock-tooltip {
        position: absolute;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%) scale(0.8);
        background-color: rgb(56, 58, 184);
        color: white;
        padding: 4px 8px;
        border-radius: 6px;
        white-space: nowrap;
        font-size: 12px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease, transform 0.3s ease;
        z-index: 1000;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .lock-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: rgb(56, 58, 184) transparent transparent transparent;
    }

    .lock-tooltip.show {
        opacity: 1;
        pointer-events: auto;
        transform: translateX(-50%) scale(1);
    }

    @keyframes popIn {
        0% { opacity: 0; transform: translateX(-50%) scale(0.7); }
        60% { opacity: 1; transform: translateX(-50%) scale(1.1); }
        100% { opacity: 1; transform: translateX(-50%) scale(1); }
    }

    /* Enhanced Table Styles */
    .table-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .table {
        font-size: 0.85rem;
        margin-bottom: 0;
    }
    
    .table th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 500;
        border: none;
        padding: 10px 15px;
        position: relative;
    }
    
    .table th:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 2px;
        background: rgba(255,255,255,0.3);
    }
    
    .table td {
        padding: 8px 15px;
        vertical-align: middle;
        border-top: 1px solid rgba(0,0,0,0.05);
    }
    
    .table tr:hover td {
        background-color: rgba(102, 126, 234, 0.1);
    }
    
    .table tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    
    .btn-primary:hover {
        background-color: #2e59d9;
        transform: translateY(-1px);
    }
    
    .btn-danger {
        background-color: #e74a3b;
        border-color: #e74a3b;
    }
    
    .btn-danger:hover {
        background-color: #d52a1a;
        transform: translateY(-1px);
    }
    
    .btn-secondary {
        background-color: #858796;
        border-color: #858796;
    }
    
    .btn-secondary:hover {
        background-color: #717384;
        transform: translateY(-1px);
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }
    
    h4 {
        color: #4e73df;
        margin-bottom: 20px;
        font-weight: 600;
    }
</style>

<div class="container mt-4">
    <h4>Size List</h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center">SL</th>
                    <th style="width: 100px;">Size Name</th>
                    <th style="width: 100px;">Created At</th>
                    <th style="width: 90px;">Time</th>
                    <th style="width: 50px; text-align: center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sizes as $key => $size)
                    <tr class="table-row">
                        <td style="text-align: center">{{ $key + 1 }}</td>
                        <td>{{ $size->name }}</td>
                        <td>{{ $size->created_at->format('d M Y') }}</td>
                        <td>{{ $size->created_at->format('h:i A') }}</td>
                        <td style="text-align: center">
                            <a href="{{ route('sizes.edit', $size->id) }}" 
                               class="btn btn-sm btn-primary action-btn" 
                               title="Edit Size">
                                <i class="fas fa-edit"></i>
                            </a>

                            @if($size->products->count() == 0)
                                <form action="{{ route('sizes.delete', $size->id) }}" method="POST" 
                                      style="display:inline-block" 
                                      onsubmit="return confirm('Are you sure you want to delete this size?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger action-btn" title="Delete Size" type="submit">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @else
                                <div class="lock-btn-wrapper">
                                    <button 
                                        class="btn btn-sm btn-secondary lock-btn action-btn" 
                                        title="Size in use and cannot be deleted"
                                        type="button"
                                        aria-describedby="lock-tooltip-{{ $size->id }}"
                                    >
                                        <i class="fas fa-lock"></i>
                                    </button>
                                    <div id="lock-tooltip-{{ $size->id }}" class="lock-tooltip" role="tooltip">
                                        You cannot delete this size because it is already in use.
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Enhanced tooltip functionality
        const lockButtons = document.querySelectorAll('.lock-btn');
        
        lockButtons.forEach(button => {
            const tooltip = button.nextElementSibling;
            
            button.addEventListener('mouseenter', function() {
                document.querySelectorAll('.lock-tooltip.show').forEach(t => t.classList.remove('show'));
                tooltip.classList.add('show', 'animate-pop');
            });
            
            button.addEventListener('mouseleave', function() {
                setTimeout(() => {
                    if (!tooltip.matches(':hover')) {
                        tooltip.classList.remove('show');
                    }
                }, 100);
            });
            
            tooltip.addEventListener('mouseenter', function() {
                tooltip.classList.add('show');
            });
            
            tooltip.addEventListener('mouseleave', function() {
                tooltip.classList.remove('show');
            });
        });

        // Row hover effect
        const tableRows = document.querySelectorAll('.table-row');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.005)';
                this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.boxShadow = '';
            });
        });

        // Button animation
        const actionButtons = document.querySelectorAll('.action-btn');
        actionButtons.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px) scale(1.05)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
            
            btn.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        });

        // Alert dismissal
        const alert = document.querySelector('.alert');
        if (alert) {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove();
                }, 500);
            }, 3000);
        }
    });
</script>
@endsection