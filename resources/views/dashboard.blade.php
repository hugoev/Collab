<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Collab</title>
    <link rel="stylesheet" href="{{ asset('css/ui.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>My Documents</h1>
            <div class="header-actions">
                <span>{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Logout</button>
                </form>
            </div>
        </div>

        <form method="POST" action="{{ route('documents.store') }}" style="margin-bottom: 2rem;">
            @csrf
            <div class="form-group">
                <label for="title">New Document Title</label>
                <input type="text" id="title" name="title" placeholder="Enter document title" required>
            </div>
            <button type="submit" class="btn">Create Document</button>
        </form>

        @if($documents->count() > 0)
            <ul class="document-list">
                @foreach($documents as $document)
                    <li class="document-item">
                        <h3>
                            <a href="{{ route('documents.show', $document) }}">{{ $document->title }}</a>
                        </h3>
                        <div class="document-meta">
                            <span>Created: {{ $document->created_at->format('M d, Y') }}</span>
                            @if($document->updated_at != $document->created_at)
                                <span>Updated: {{ $document->updated_at->format('M d, Y') }}</span>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="empty-state">
                <p>No documents yet. Create your first document above!</p>
            </div>
        @endif
    </div>
</body>
</html>

