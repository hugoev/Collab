<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Collab</title>
    <link rel="stylesheet" href="{{ asset('css/ui.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="app-layout">
        <header class="app-header">
            <div class="app-header-content">
                <a href="{{ route('dashboard') }}" class="app-logo">Collab</a>
                <nav class="app-nav">
                    <div class="user-menu">
                        <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                        <span class="user-name">{{ Auth::user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-ghost">Logout</button>
                    </form>
                </nav>
            </div>
        </header>

        <main class="app-main">
            <aside class="app-sidebar">
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Navigation</h3>
                    <ul class="sidebar-nav">
                        <li class="sidebar-nav-item">
                            <a href="{{ route('dashboard') }}" class="sidebar-nav-link active">
                                <span>📄</span>
                                <span>My Documents</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Quick Actions</h3>
                    <ul class="sidebar-nav">
                        <li class="sidebar-nav-item">
                            <a href="#create-document" class="sidebar-nav-link" onclick="document.getElementById('create-form').scrollIntoView({behavior: 'smooth'}); return false;">
                                <span>➕</span>
                                <span>New Document</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>

            <div class="app-content">
                <div class="dashboard-header">
                    <h1>My Documents</h1>
                    <p>Create and manage your collaborative documents</p>
                </div>

                <div class="dashboard-section" id="create-document">
                    <h2 class="dashboard-section-title">Create New Document</h2>
                    <form method="POST" action="{{ route('documents.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="title">Document Title</label>
                            <input type="text" id="title" name="title" placeholder="Enter document title" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Document</button>
                    </form>
                </div>

                <div class="dashboard-content">
                    @if($documents->count() > 0)
                        <h2 class="dashboard-section-title" style="margin-bottom: var(--space-4);">Your Documents</h2>
                        <ul class="document-list">
                            @foreach($documents as $document)
                                <li class="document-item" onclick="window.location.href='{{ route('documents.show', $document) }}'">
                                    <div class="document-item-header">
                                        <div class="document-item-icon">📄</div>
                                        <div class="document-item-content">
                                            <h3>
                                                <a href="{{ route('documents.show', $document) }}">{{ $document->title }}</a>
                                            </h3>
                                            <div class="document-meta">
                                                <span class="document-meta-item">Created: {{ $document->created_at->format('M d, Y') }}</span>
                                                @if($document->updated_at != $document->created_at)
                                                    <span class="document-meta-item">Updated: {{ $document->updated_at->format('M d, Y') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">📝</div>
                            <h3>No documents yet</h3>
                            <p>Create your first document to get started with collaborative editing</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>
