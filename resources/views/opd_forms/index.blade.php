{{-- resources/views/opd_forms/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<style>
    /* ===== Enhanced OPD Forms Index Styles ===== */
    :root {
        --primary-green: #00b467;
        --secondary-teal: #0e4749;
        --accent-blue: #1e90ff;
        --success-green: #28a745;
        --danger-red: #dc3545;
        --light-gray: #f8f9fa;
        --border-color: #e9ecef;
        --text-muted: #6c757d;
        --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        --border-radius: 0.75rem;
        --transition: all 0.3s ease;
    }

    .page-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 1.5rem 0;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, #008a52 100%);
        color: white;
        padding: 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transform: skewX(-15deg);
        transform-origin: top;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .header-title {
        margin: 0;
        font-size: 2.25rem;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header-subtitle {
        margin: 0.5rem 0 0 0;
        font-size: 1.1rem;
        opacity: 0.9;
        font-weight: 400;
    }

    .header-logo {
        background: white;
        padding: 0.75rem;
        border-radius: 50%;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .header-logo:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    /* Enhanced Dropdown Styles */
    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .dropdown-enhanced {
        position: relative;
    }

    .btn-primary-enhanced {
        background: linear-gradient(135deg, var(--accent-blue) 0%, #0d6efd 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        font-size: 1rem;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary-enhanced:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        background: linear-gradient(135deg, #1c7ed6 0%, #0b5ed7 100%);
    }

    .btn-primary-enhanced i {
        font-size: 1.1rem;
    }

    .dropdown-menu-enhanced {
        border: none;
        box-shadow: var(--shadow-md);
        border-radius: var(--border-radius);
        padding: 0.5rem;
        margin-top: 0.5rem;
        min-width: 280px;
    }

    .dropdown-header-custom {
        background: var(--light-gray);
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.75rem 1rem;
        margin: 0.25rem 0;
        border-radius: 0.5rem;
    }

    .dropdown-item-enhanced {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        margin: 0.125rem 0;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #495057;
        text-decoration: none;
    }

    .dropdown-item-enhanced:hover {
        background: var(--primary-green);
        color: white;
        transform: translateX(5px);
    }

    .dropdown-item-icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        font-size: 0.875rem;
    }

    .icon-list { background: #e3f2fd; color: #1976d2; }
    .icon-add { background: #e8f5e8; color: #2e7d32; }

    /* Enhanced Table Styles */
    .forms-table-container {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        margin-top: 1rem;
    }

    .table-header {
        background: linear-gradient(135deg, var(--secondary-teal) 0%, #0a3d3f 100%);
        color: white;
        padding: 1.25rem 1.5rem;
        display: grid;
        grid-template-columns: 3fr 1fr 2fr 1fr;
        gap: 1rem;
        align-items: center;
        font-weight: 600;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-row {
        display: grid;
        grid-template-columns: 3fr 1fr 2fr 1fr;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        align-items: center;
        border-bottom: 1px solid var(--border-color);
        transition: var(--transition);
        position: relative;
    }

    .table-row:hover {
        background: #f8f9fa;
        transform: translateX(5px);
        box-shadow: inset 4px 0 0 var(--primary-green);
    }

    .table-row:last-child {
        border-bottom: none;
    }

    .form-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 1.05rem;
    }

    .form-number {
        background: var(--primary-green);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-align: center;
        display: inline-block;
    }

    .department-badge {
        background: #e9ecef;
        color: #495057;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .table-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .btn-action {
        padding: 0.4rem 0.8rem;
        border: none;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .btn-view {
        background: var(--success-green);
        color: white;
    }

    .btn-edit {
        background: var(--accent-blue);
        color: white;
    }

    .btn-delete {
        background: var(--danger-red);
        color: white;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-muted);
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        margin-bottom: 0.5rem;
        color: #6c757d;
    }

    /* Stats Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        text-align: center;
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--text-muted);
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .header-title {
            font-size: 1.75rem;
        }

        .table-header,
        .table-row {
            grid-template-columns: 1fr;
            gap: 0.5rem;
            text-align: center;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-container">
    <div class="container-fluid">
        <!-- Enhanced Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div>
                    <h1 class="header-title">OPD Forms Management</h1>
                    <p class="header-subtitle">Comprehensive medical form tracking system</p>
                </div>
                <div class="header-logo">
                    <img src="{{ asset('images/fabella-logo.png') }}" width="60" alt="Fabella Logo">
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-number">{{ $forms->count() }}</div>
                <div class="stat-label">Total Forms</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">3</div>
                <div class="stat-label">Form Types</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $forms->unique('department')->count() }}</div>
                <div class="stat-label">Departments</div>
            </div>
        </div>

        <!-- Enhanced Action Bar -->
        <div class="action-bar">
            <div class="dropdown dropdown-enhanced">
                <button class="btn btn-primary-enhanced dropdown-toggle" 
                        type="button" 
                        id="addFormBtn" 
                        data-bs-toggle="dropdown" 
                        aria-expanded="false">
                    <i class="fas fa-plus"></i>
                    Create New Form
                </button>
                <ul class="dropdown-menu dropdown-menu-enhanced" aria-labelledby="addFormBtn">
                    <!-- OPD-OB Section -->
                    <li><h6 class="dropdown-header-custom">OPD-OB Forms</h6></li>
                    <li>
                        <a class="dropdown-item dropdown-item-enhanced" href="{{ route('ob-opd-forms.index') }}">
                            <span class="dropdown-item-icon icon-list">
                                <i class="fas fa-list"></i>
                            </span>
                            View OPD-OB Records
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item dropdown-item-enhanced" href="{{ route('ob-opd-forms.create') }}">
                            <span class="dropdown-item-icon icon-add">
                                <i class="fas fa-plus"></i>
                            </span>
                            New OPD-OB Record
                        </a>
                    </li>
                    
                    <li><hr class="dropdown-divider"></li>
                    
                    <!-- High Risk Section -->
                    <li><h6 class="dropdown-header-custom">High-Risk Forms</h6></li>
                    <li>
                        <a class="dropdown-item dropdown-item-enhanced" href="{{ route('high-risk-opd-forms.index') }}">
                            <span class="dropdown-item-icon icon-list">
                                <i class="fas fa-list"></i>
                            </span>
                            View High-Risk Records
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item dropdown-item-enhanced" href="{{ route('high-risk-opd-forms.create') }}">
                            <span class="dropdown-item-icon icon-add">
                                <i class="fas fa-plus"></i>
                            </span>
                            New High-Risk Record
                        </a>
                    </li>
                    
                    <li><hr class="dropdown-divider"></li>
                    
                    <!-- Follow-Up Section -->
                    <li><h6 class="dropdown-header-custom">Follow-Up Forms</h6></li>
                    <li>
                        <a class="dropdown-item dropdown-item-enhanced" href="{{ route('follow-up-opd-forms.index') }}">
                            <span class="dropdown-item-icon icon-list">
                                <i class="fas fa-list"></i>
                            </span>
                            View Follow-Up Records
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item dropdown-item-enhanced" href="{{ route('follow-up-opd-forms.create') }}">
                            <span class="dropdown-item-icon icon-add">
                                <i class="fas fa-plus"></i>
                            </span>
                            New Follow-Up Record
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Enhanced Forms Table -->
        <div class="forms-table-container">
            <div class="table-header">
                <div><i class="fas fa-file-medical-alt me-2"></i>Form Name</div>
                <div><i class="fas fa-hashtag me-2"></i>Form No.</div>
                <div><i class="fas fa-building me-2"></i>Department</div>
          
            </div>
            
            @forelse($forms as $form)
                <div class="table-row">
                    <div class="form-name">{{ $form->name }}</div>
                    <div>
                        <span class="form-number">{{ $form->form_no }}</span>
                    </div>
                    <div>
                        <span class="department-badge">{{ $form->department }}</span>
                    </div>
                
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-file-medical"></i>
                    <h3>No Forms Available</h3>
                    <p>Start by creating your first OPD form using the button above.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Initialize Bootstrap dropdown
    const dropdownButton = document.getElementById('addFormBtn');
    if (dropdownButton) {
        try {
            new bootstrap.Dropdown(dropdownButton);
            console.log('Enhanced dropdown initialized successfully');
        } catch (error) {
            console.error('Bootstrap initialization error:', error);
        }
    }

    // Add smooth animations to table rows
    const tableRows = document.querySelectorAll('.table-row');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            row.style.transition = 'all 0.5s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

function confirmDelete() {
    if (confirm('Are you sure you want to delete this form? This action cannot be undone.')) {
        // Add delete logic here
        console.log('Form deletion confirmed');
    }
}

// Add loading states for buttons
document.querySelectorAll('.btn-action').forEach(button => {
    button.addEventListener('click', function(e) {
        if (!this.classList.contains('btn-delete')) {
            this.style.opacity = '0.7';
            this.style.pointerEvents = 'none';
            
            setTimeout(() => {
                this.style.opacity = '1';
                this.style.pointerEvents = 'auto';
            }, 1000);
        }
    });
});
</script>
@endpush