<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document->title }} - Collab</title>
    <link rel="stylesheet" href="{{ asset('css/ui.css') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="editor-container">
        <header class="editor-header">
            <div class="editor-header-left">
                <a href="{{ route('dashboard') }}" class="header-action-btn" title="Back to Dashboard" aria-label="Back to Dashboard">
                    <span class="icon icon-md">@include('icons.arrow-left')</span>
                </a>
                <h1 class="editor-title">{{ $document->title }}</h1>
                <span class="status" id="status" role="status" aria-live="polite">
                    <span class="status-text">Ready</span>
                </span>
            </div>
            <div class="header-actions">
                <button class="header-action-btn" aria-label="Share">
                    <span class="icon icon-md">@include('icons.add')</span>
                </button>
                <div class="user-menu" role="button" tabindex="0" aria-label="User menu">
                    <div class="user-avatar" aria-label="User avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                </div>
            </div>
        </header>

        <div class="editor-wrapper">
            <div class="editor-paper">
                <textarea 
                    id="editor" 
                    class="editor" 
                    placeholder="Start typing your document..."
                >{{ $document->content }}</textarea>
            </div>
        </div>
    </div>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        const documentId = {{ $document->id }};
        const editor = document.getElementById('editor');
        const statusEl = document.getElementById('status');
        const editorWrapper = document.querySelector('.editor-wrapper');
        const editorHeader = document.querySelector('.editor-header');
        let saveTimeout;
        let isSaving = false;
        let isRemoteUpdate = false;
        let lastSavedContent = editor.value;
        let retryCount = 0;
        const MAX_RETRIES = 3;

        const editorPaper = document.querySelector('.editor-paper');

        // Function to update status icon
        function updateStatusIcon(statusEl, type) {
            const statusText = statusEl.querySelector('.status-text');
            const text = statusText ? statusText.textContent : statusEl.textContent;
            let iconSvg = '';
            if (type === 'saving') {
                iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 12px; height: 12px; flex-shrink: 0;"><circle cx="12" cy="12" r="10" opacity="0.3"/><path d="M12 2 A10 10 0 0 1 22 12" stroke-dasharray="15.7 15.7"/></svg>';
            } else if (type === 'saved') {
                iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 12px; height: 12px; flex-shrink: 0;"><polyline points="20 6 9 17 4 12"/></svg>';
            }
            if (iconSvg) {
                statusEl.innerHTML = iconSvg + '<span class="status-text">' + text + '</span>';
            }
        }

        // Auto-focus editor on load
        window.addEventListener('load', () => {
            setTimeout(() => {
                editor.focus();
                // Move cursor to end if there's content
                if (editor.value.length > 0) {
                    editor.setSelectionRange(editor.value.length, editor.value.length);
                }
            }, 100);
        });

        // Track focus for paper styling
        editor.addEventListener('focus', () => {
            editorPaper.classList.add('focused');
        });

        editor.addEventListener('blur', () => {
            editorPaper.classList.remove('focused');
        });

        // Track scroll position for header shadow
        editorWrapper.addEventListener('scroll', () => {
            if (editorWrapper.scrollTop > 10) {
                editorHeader.classList.add('scrolled');
            } else {
                editorHeader.classList.remove('scrolled');
            }
        });

        // Keyboard shortcuts
        editor.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                if (!isSaving && !isRemoteUpdate) {
                    clearTimeout(saveTimeout);
                    saveDocument();
                }
            }
            
            // Escape to blur (optional)
            if (e.key === 'Escape' && document.activeElement === editor) {
                editor.blur();
            }
        });

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

            channel.bind('pusher:subscription_succeeded', () => {
                console.log('Connected to real-time updates');
            });

            channel.bind('pusher:subscription_error', (error) => {
                console.error('Subscription error:', error);
            });

            // Listen for document updates from other users
            channel.bind('document.updated', function(data) {
                if (isRemoteUpdate) return;
                
                // Only update if content actually changed
                if (data.document.content !== editor.value) {
                    isRemoteUpdate = true;
                    const cursorPos = editor.selectionStart;
                    editor.value = data.document.content;
                    lastSavedContent = data.document.content;
                    
                    // Try to restore cursor position
                    if (cursorPos <= editor.value.length) {
                        editor.setSelectionRange(cursorPos, cursorPos);
                    }
                    
                    // Smooth status update
                    const statusText = statusEl.querySelector('.status-text');
                    statusText.textContent = 'Updated';
                    statusEl.className = 'status saved';
                    updateStatusIcon(statusEl, 'saved');
                    
                    setTimeout(() => {
                        statusText.textContent = 'Ready';
                        statusEl.className = 'status';
                        statusEl.innerHTML = '<span class="status-text">Ready</span>';
                        isRemoteUpdate = false;
                    }, 2000);
                }
            });
        }

        // Handle local edits with smooth feedback
        editor.addEventListener('input', function() {
            if (isRemoteUpdate) return;

            clearTimeout(saveTimeout);
            
            // Update status immediately
            const statusText = statusEl.querySelector('.status-text');
            statusText.textContent = 'Typing...';
            statusEl.className = 'status typing';

            // Debounce save (1 second)
            saveTimeout = setTimeout(() => {
                saveDocument();
            }, 1000);
        });

        // Handle paste events
        editor.addEventListener('paste', (e) => {
            // Allow default paste, then trigger save
            setTimeout(() => {
                if (!isRemoteUpdate) {
                    clearTimeout(saveTimeout);
                    saveTimeout = setTimeout(() => {
                        saveDocument();
                    }, 500);
                }
            }, 10);
        });

        // Save document to server with retry logic
        function saveDocument() {
            if (isSaving || isRemoteUpdate) return;
            
            const currentContent = editor.value;
            
            // Don't save if content hasn't changed
            if (currentContent === lastSavedContent) {
                const statusText = statusEl.querySelector('.status-text');
                statusText.textContent = 'Ready';
                statusEl.className = 'status';
                statusEl.innerHTML = '<span class="status-text">Ready</span>';
                return;
            }

            isSaving = true;
            const statusText = statusEl.querySelector('.status-text');
            statusText.textContent = 'Saving...';
            statusEl.className = 'status saving';
            updateStatusIcon(statusEl, 'saving');

            fetch(`/documents/${documentId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    content: currentContent
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
                .then(data => {
                    lastSavedContent = currentContent;
                    retryCount = 0;
                    const statusText = statusEl.querySelector('.status-text');
                    statusText.textContent = 'Saved';
                    statusEl.className = 'status saved';
                    updateStatusIcon(statusEl, 'saved');
                    isSaving = false;
                    
                    // Auto-hide saved status after 2 seconds
                    setTimeout(() => {
                        if (statusEl.className === 'status saved') {
                            statusText.textContent = 'Ready';
                            statusEl.className = 'status';
                            statusEl.innerHTML = '<span class="status-text">Ready</span>';
                        }
                    }, 2000);
                })
            .catch(error => {
                console.error('Error saving document:', error);
                retryCount++;
                
                    const statusText = statusEl.querySelector('.status-text');
                    if (retryCount < MAX_RETRIES) {
                        // Retry after a delay
                        statusText.textContent = `Retrying... (${retryCount}/${MAX_RETRIES})`;
                        statusEl.className = 'status saving';
                        updateStatusIcon(statusEl, 'saving');
                        setTimeout(() => {
                            isSaving = false;
                            saveDocument();
                        }, 1000 * retryCount);
                    } else {
                        statusText.textContent = 'Error saving';
                        statusEl.className = 'status error';
                        isSaving = false;
                        retryCount = 0;
                        
                        // Show error for 3 seconds, then allow retry
                        setTimeout(() => {
                            if (statusEl.className === 'status error') {
                                statusText.textContent = 'Ready';
                                statusEl.className = 'status';
                                statusEl.innerHTML = '<span class="status-text">Ready</span>';
                            }
                        }, 3000);
                    }
            });
        }

        // Save before page unload
        window.addEventListener('beforeunload', (e) => {
            if (editor.value !== lastSavedContent && !isSaving) {
                // Try to save synchronously (may not work in all browsers)
                navigator.sendBeacon(`/documents/${documentId}`, JSON.stringify({
                    content: editor.value,
                    _method: 'PUT'
                }));
            }
        });

        // Periodic save check (every 30 seconds if there are unsaved changes)
        setInterval(() => {
            if (editor.value !== lastSavedContent && !isSaving && !isRemoteUpdate) {
                saveDocument();
            }
        }, 30000);
    </script>
</body>
</html>

