<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Collab</title>
    <link rel="stylesheet" href="{{ asset('css/ui.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="app-layout">
        <header class="app-header">
            <div class="app-header-content">
                <button class="header-action-btn" aria-label="Menu">
                    <span class="icon icon-md">@include('icons.menu')</span>
                </button>
                <a href="{{ route('dashboard') }}" class="app-logo">
                    <div class="app-logo-icon">
                        @include('icons.document')
                    </div>
                    <span>Collab</span>
                </a>
                <div class="search-container">
                    <span class="search-icon">
                        @include('icons.search')
                    </span>
                    <input type="search" class="search-bar" placeholder="Search" aria-label="Search documents">
                </div>
                <div class="header-actions">
                    <button class="header-action-btn" aria-label="Favorites">
                        <span class="icon icon-md">@include('icons.add')</span>
                    </button>
                    <button class="header-action-btn" aria-label="More options">
                        <span class="icon icon-md">@include('icons.more-vertical')</span>
                    </button>
                    <div class="user-menu" role="button" tabindex="0" aria-label="User menu">
                        <div class="user-avatar" aria-label="User avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    </div>
                </div>
            </div>
        </header>

        <main class="app-main">
            <div class="app-content">
                <!-- Start a new document section -->
                <div class="dashboard-section">
                    <h2 class="dashboard-section-title">
                        <span>Start a new document</span>
                        <div class="section-header-actions">
                            <a href="#template-gallery">Template gallery</a>
                        </div>
                    </h2>
                    <div class="template-gallery">
                        <div class="template-card" onclick="document.getElementById('create-form').scrollIntoView({behavior: 'smooth'});">
                            <div class="template-card-preview template-card-blank">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"/>
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
                            </div>
                            <div class="template-card-info">
                                <div class="template-card-title">Blank document</div>
                            </div>
                        </div>
                        <div class="template-card">
                            <div class="template-card-preview">
                                @include('icons.document')
                            </div>
                            <div class="template-card-info">
                                <div class="template-card-title">Resume</div>
                                <div class="template-card-subtitle">Serif</div>
                            </div>
                        </div>
                        <div class="template-card">
                            <div class="template-card-preview">
                                @include('icons.document')
                            </div>
                            <div class="template-card-info">
                                <div class="template-card-title">Letter</div>
                                <div class="template-card-subtitle">Spearmint</div>
                            </div>
                        </div>
                        <div class="template-card">
                            <div class="template-card-preview">
                                @include('icons.document')
                            </div>
                            <div class="template-card-info">
                                <div class="template-card-title">Report</div>
                                <div class="template-card-subtitle">Luxe</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Create document form (hidden by default, shown when blank template clicked) -->
                <div class="create-document-section" id="create-document" style="display: none;">
                    <form method="POST" action="{{ route('documents.store') }}" id="create-form" class="create-document-form">
                        @csrf
                        <div class="form-group">
                            <label for="title">Document Title</label>
                            <input type="text" id="title" name="title" placeholder="Enter document title" required autofocus>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <span class="icon icon-sm">@include('icons.add')</span>
                            <span>Create Document</span>
                        </button>
                    </form>
                </div>

                <!-- Recent documents section -->
                <div class="dashboard-section">
                    <h2 class="dashboard-section-title">
                        <span>Recent documents</span>
                        <div class="section-header-actions">
                            <div class="document-filters">
                                <button class="filter-dropdown">
                                    <span>Owned by me</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <polyline points="6 9 12 15 18 9"/>
                                    </svg>
                                </button>
                                <div class="view-actions">
                                    <button class="view-action-btn active" aria-label="Grid view">
                                        <span class="icon icon-sm">@include('icons.grid')</span>
                                    </button>
                                    <button class="view-action-btn" aria-label="List view">
                                        <span class="icon icon-sm">@include('icons.list')</span>
                                    </button>
                                    <button class="view-action-btn" aria-label="Sort">
                                        <span class="icon icon-sm">@include('icons.sort')</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </h2>
                    
                    @if($documents->count() > 0)
                        <div class="document-grid">
                            @foreach($documents as $document)
                                <div class="document-card" onclick="window.location.href='{{ route('documents.show', $document) }}'" role="button" tabindex="0" onkeydown="if(event.key === 'Enter' || event.key === ' ') { window.location.href='{{ route('documents.show', $document) }}'; }">
                                    <div class="document-card-thumbnail">
                                        <div class="document-card-thumbnail-content">
                                            <div style="font-weight: 500; color: var(--text-primary); margin-bottom: 4px;">{{ Str::limit($document->title, 30) }}</div>
                                            <div style="font-size: 10px; line-height: 1.3; opacity: 0.7;">
                                                {{ Str::limit(strip_tags($document->content), 100) ?: 'Empty document' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="document-card-info">
                                        <div class="document-card-title">{{ $document->title }}</div>
                                        <div class="document-card-date">{{ $document->updated_at->format('M d, Y') }}</div>
                                        <button class="document-card-menu" onclick="event.stopPropagation();" aria-label="More options">
                                            <span class="icon icon-sm">@include('icons.more-vertical')</span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <span class="icon icon-2xl">@include('icons.empty-document')</span>
                            </div>
                            <h3>No documents yet</h3>
                            <p>Create your first document to get started with collaborative editing</p>
                            <button class="btn btn-primary mt-6" onclick="document.querySelector('.create-document-section').style.display='block'; document.getElementById('create-form').scrollIntoView({behavior: 'smooth'});">
                                <span class="icon icon-sm">@include('icons.add')</span>
                                <span>Create Your First Document</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script>
        // Show create form when blank template is clicked
        document.querySelectorAll('.template-card').forEach(card => {
            card.addEventListener('click', function() {
                if (this.querySelector('.template-card-blank')) {
                    const formSection = document.querySelector('.create-document-section');
                    formSection.style.display = 'block';
                    setTimeout(() => {
                        document.getElementById('create-form').scrollIntoView({behavior: 'smooth'});
                        document.getElementById('title').focus();
                    }, 100);
                }
            });
        });
    </script>
</body>
</html>
