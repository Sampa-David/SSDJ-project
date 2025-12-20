<!-- Dashboard Sidebar -->
<div class="col-lg-3">
    <div class="card shadow-sm border-0 mb-4" style="position: sticky; top: 20px;">
        <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <h5 class="mb-0">
                <i class="fas fa-bars"></i> Menu
            </h5>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard') ? 'active' : '' }}" style="border-left: 4px solid transparent; {{ request()->routeIs('dashboard') ? 'border-left-color: #667eea' : '' }}">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
            
            <a href="{{ route('my-tickets') }}" class="list-group-item list-group-item-action {{ request()->routeIs('my-tickets') ? 'active' : '' }}" style="border-left: 4px solid transparent; {{ request()->routeIs('my-tickets') ? 'border-left-color: #667eea' : '' }}">
                <i class="fas fa-ticket-alt me-2"></i> My Tickets
                <span class="badge bg-primary float-end">{{ Auth::user()->tickets()->count() }}</span>
            </a>

            <a href="{{ route('buy-tickets') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-shopping-cart me-2"></i> Buy Tickets
            </a>

            <!-- Event Management Section -->
            @if(Auth::user()->hasActivePublishingRights())
                <div class="list-group-item" style="background-color: #f8f9fa; border-top: 1px solid #dee2e6;">
                    <h6 class="mb-3" style="color: #667eea; font-weight: bold;">
                        <i class="fas fa-calendar me-2"></i> Event Management
                        <span class="badge bg-success">Active</span>
                    </h6>
                    <div class="ps-3 border-start" style="border-color: #667eea !important;">
                        <a href="{{ route('events.index') }}" class="d-block text-decoration-none mb-2 {{ request()->routeIs('events.index') ? 'text-primary fw-bold' : 'text-muted' }}" style="transition: all 0.3s ease;">
                            <i class="fas fa-list me-2"></i> List Events
                            <span class="badge bg-info">{{ Auth::user()->events()->count() }}</span>
                        </a>
                        <a href="{{ route('events.create') }}" class="d-block text-decoration-none mb-2 {{ request()->routeIs('events.create') ? 'text-primary fw-bold' : 'text-muted' }}" style="transition: all 0.3s ease;">
                            <i class="fas fa-plus me-2"></i> Create Event
                        </a>
                    </div>
                    <div class="mt-3 pt-2 border-top">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Expires: {{ Auth::user()->getActivePublishingRight()->expires_at->format('M d, Y') }}
                        </small>
                    </div>
                </div>
            @else
                <div class="list-group-item" style="background-color: #fff3cd; border-top: 1px solid #dee2e6;">
                    <h6 class="mb-3" style="color: #856404; font-weight: bold;">
                        <i class="fas fa-lock me-2"></i> Event Management
                    </h6>
                    <p class="text-muted small mb-2">You need publishing rights to create and manage events.</p>
                    <a href="{{ route('events.payment') }}" class="btn btn-sm btn-warning w-100">
                        <i class="fas fa-unlock me-1"></i> Get Publishing Rights
                    </a>
                </div>
            @endif

            <!-- Profile & Settings -->
            <a href="{{ route('profile.show') }}" class="list-group-item list-group-item-action {{ request()->routeIs('profile.*') ? 'active' : '' }}" style="border-left: 4px solid transparent; {{ request()->routeIs('profile.*') ? 'border-left-color: #667eea' : '' }}">
                <i class="fas fa-user me-2"></i> My Profile
            </a>

            <form action="{{ route('logout') }}" method="POST" style="display: contents;">
                @csrf
                <button type="submit" class="list-group-item list-group-item-action text-danger" style="border-left: 4px solid transparent;">
                    <i class="fas fa-sign-out-alt me-2"></i> Sign Out
                </button>
            </form>
        </div>
    </div>
</div>
