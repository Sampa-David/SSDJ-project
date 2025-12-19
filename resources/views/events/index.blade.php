@extends('layouts.app')

@section('title', 'My Events - Eventix')

@section('content')

<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>My Events</h2>
                    <a href="{{ route('events.payment') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Event
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($events->count() > 0)
            <div class="row">
                @foreach ($events as $event)
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="mb-1">{{ $event->name }}</h5>
                                        <small class="d-block">
                                            <i class="fas fa-calendar"></i> {{ $event->date_event->format('M d, Y') }} | 
                                            <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                                        </small>
                                    </div>
                                    <div>
                                        @if($event->status === 'published')
                                            <span class="badge bg-success">Published</span>
                                        @elseif($event->status === 'expired')
                                            <span class="badge bg-danger">Expired</span>
                                        @else
                                            <span class="badge bg-warning">{{ ucfirst($event->status) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text text-muted mb-3">{{ Str::limit($event->description, 100) }}</p>
                                <div class="row mb-3 pb-3 border-bottom">
                                    <div class="col-6">
                                        <small class="text-muted">Package</small>
                                        <p class="mb-0"><strong>{{ ucfirst($event->package_type) }}</strong></p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Price</small>
                                        <p class="mb-0"><strong>${{ number_format($event->price, 2) }}</strong></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">Visibility</small>
                                        <p class="mb-0">
                                            @if($event->visibility === 'public')
                                                <span class="badge bg-info">Public</span>
                                            @elseif($event->visibility === 'friends')
                                                <span class="badge bg-warning">Friends</span>
                                            @else
                                                <span class="badge bg-secondary">Private</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Promotion Until</small>
                                        <p class="mb-0">{{ $event->expires_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @if($event->status === 'published')
                                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    @endif
                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $events->links() }}
            </div>
        @else
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div style="font-size: 3rem; margin-bottom: 20px;">📅</div>
                    <h5 class="card-title">No Events Yet</h5>
                    <p class="card-text text-muted mb-4">You haven't created any events yet. Create your first event and get it published!</p>
                    <a href="{{ route('events.payment') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i> Create Your First Event
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
