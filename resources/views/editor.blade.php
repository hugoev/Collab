<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document->title }} - Collab</title>
    <link rel="stylesheet" href="{{ asset('css/ui.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <div class="editor-header">
            <div>
                <h1 class="editor-title">{{ $document->title }}</h1>
                <span class="status" id="status">Ready</span>
            </div>
            <div class="header-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>

        <textarea 
            id="editor" 
            class="editor" 
            placeholder="Start typing..."
        >{{ $document->content }}</textarea>
    </div>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        const documentId = {{ $document->id }};
        const editor = document.getElementById('editor');
        const statusEl = document.getElementById('status');
        let saveTimeout;
        let isSaving = false;
        let isRemoteUpdate = false;

        // Pusher configuration
        const pusherKey = '{{ env('PUSHER_APP_KEY', '') }}';
        const pusherCluster = '{{ env('PUSHER_APP_CLUSTER', 'mt1') }}';
        
        if (!pusherKey) {
            console.warn('Pusher is not configured. Real-time updates will not work.');
        }
        
        const pusher = pusherKey ? new Pusher(pusherKey, {
            cluster: pusherCluster,
            encrypted: true,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }
        }) : null;

        // Subscribe to document channel
        if (pusher) {
            const channel = pusher.subscribe('private-document.' + documentId);

            // Listen for document updates from other users
            channel.bind('document.updated', function(data) {
            if (!isRemoteUpdate) {
                isRemoteUpdate = true;
                editor.value = data.document.content;
                statusEl.textContent = 'Updated';
                statusEl.className = 'status saved';
                setTimeout(() => {
                    statusEl.textContent = 'Ready';
                    statusEl.className = 'status';
                }, 2000);
                isRemoteUpdate = false;
            }
            });
        }

        // Handle local edits
        editor.addEventListener('input', function() {
            if (isRemoteUpdate) return;

            clearTimeout(saveTimeout);
            
            statusEl.textContent = 'Typing...';
            statusEl.className = 'status';

            // Debounce save
            saveTimeout = setTimeout(() => {
                saveDocument();
            }, 1000);
        });

        // Save document to server
        function saveDocument() {
            if (isSaving || isRemoteUpdate) return;

            isSaving = true;
            statusEl.textContent = 'Saving...';
            statusEl.className = 'status saving';

            fetch(`/documents/${documentId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    content: editor.value
                })
            })
            .then(response => response.json())
            .then(data => {
                statusEl.textContent = 'Saved';
                statusEl.className = 'status saved';
                isSaving = false;
            })
            .catch(error => {
                console.error('Error saving document:', error);
                statusEl.textContent = 'Error saving';
                statusEl.className = 'status';
                isSaving = false;
            });
        }
    </script>
</body>
</html>

