<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document->title }} - Collab</title>
    <link rel="stylesheet" href="{{ asset('css/ui.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="editor-container">
        <header class="editor-header">
            <!-- Menu Bar -->
            <div class="editor-menu-bar">
                <button class="header-action-btn" aria-label="Menu">
                    <span class="icon icon-md">@include('icons.menu')</span>
                </button>
                <button class="editor-menu-item">File</button>
                <button class="editor-menu-item">Edit</button>
                <button class="editor-menu-item">View</button>
                <button class="editor-menu-item">Insert</button>
                <button class="editor-menu-item">Format</button>
                <button class="editor-menu-item">Tools</button>
                <button class="editor-menu-item">Extensions</button>
                <button class="editor-menu-item">Help</button>
                <div class="editor-menu-actions">
                    <button class="header-action-btn" aria-label="History">
                        <span class="icon icon-md">@include('icons.history')</span>
                    </button>
                    <button class="header-action-btn" aria-label="Comments">
                        <span class="icon icon-md">@include('icons.comment')</span>
                    </button>
                    <button class="header-action-btn" aria-label="Share">
                        <span class="icon icon-md">@include('icons.share')</span>
                    </button>
                    <div class="user-menu" role="button" tabindex="0" aria-label="User menu">
                        <div class="user-avatar" aria-label="User avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    </div>
                </div>
            </div>

            <!-- Title Bar -->
            <div class="editor-title-bar">
                <div class="editor-title-bar-left">
                    <a href="{{ route('dashboard') }}" class="header-action-btn" title="Back to Dashboard" aria-label="Back to Dashboard">
                        <span class="icon icon-md">@include('icons.arrow-left')</span>
                    </a>
                    <h1 class="editor-title">{{ $document->title }}</h1>
                    <span class="status" id="status" role="status" aria-live="polite">
                        <span class="status-text">Ready</span>
                    </span>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="editor-toolbar">
                <div class="toolbar-group">
                    <button class="toolbar-btn" title="Undo" aria-label="Undo">
                        <span class="icon icon-sm">@include('icons.undo')</span>
                    </button>
                    <button class="toolbar-btn" title="Redo" aria-label="Redo">
                        <span class="icon icon-sm">@include('icons.redo')</span>
                    </button>
                    <button class="toolbar-btn" title="Print" aria-label="Print">
                        <span class="icon icon-sm">@include('icons.printer')</span>
                    </button>
                </div>
                <div class="toolbar-group">
                    <select class="toolbar-select toolbar-select-zoom">
                        <option>100%</option>
                        <option>50%</option>
                        <option>75%</option>
                        <option>125%</option>
                        <option>150%</option>
                        <option>200%</option>
                    </select>
                </div>
                <div class="toolbar-group">
                    <select class="toolbar-select toolbar-select-style">
                        <option>Normal text</option>
                        <option>Title</option>
                        <option>Heading 1</option>
                        <option>Heading 2</option>
                        <option>Heading 3</option>
                    </select>
                </div>
                <div class="toolbar-group">
                    <select class="toolbar-select toolbar-select-font">
                        <option>Arial</option>
                        <option>Times New Roman</option>
                        <option>Courier New</option>
                        <option>Georgia</option>
                        <option>Verdana</option>
                    </select>
                </div>
                <div class="toolbar-group">
                    <input type="text" class="toolbar-input" value="11" title="Font size">
                </div>
                <div class="toolbar-group">
                    <button class="toolbar-btn" title="Bold" aria-label="Bold">
                        <span class="icon icon-sm">@include('icons.bold')</span>
                    </button>
                    <button class="toolbar-btn" title="Italic" aria-label="Italic">
                        <span class="icon icon-sm">@include('icons.italic')</span>
                    </button>
                    <button class="toolbar-btn" title="Underline" aria-label="Underline">
                        <span class="icon icon-sm">@include('icons.underline')</span>
                    </button>
                    <button class="toolbar-btn" title="Text color" aria-label="Text color">
                        <span class="icon icon-sm">A</span>
                    </button>
                    <button class="toolbar-btn" title="Highlight" aria-label="Highlight">
                        <span class="icon icon-sm highlight-icon"></span>
                    </button>
                </div>
                <div class="toolbar-group">
                    <button class="toolbar-btn" title="Link" aria-label="Link">
                        <span class="icon icon-sm">@include('icons.link')</span>
                    </button>
                    <button class="toolbar-btn" title="Image" aria-label="Image">
                        <span class="icon icon-sm">@include('icons.image')</span>
                    </button>
                </div>
                <div class="toolbar-group">
                    <button class="toolbar-btn" title="Align left" aria-label="Align left">
                        <span class="icon icon-sm">@include('icons.align-left')</span>
                    </button>
                    <button class="toolbar-btn" title="Align center" aria-label="Align center">
                        <span class="icon icon-sm">@include('icons.align-center')</span>
                    </button>
                    <button class="toolbar-btn" title="Align right" aria-label="Align right">
                        <span class="icon icon-sm">@include('icons.align-right')</span>
                    </button>
                    <button class="toolbar-btn" title="Justify" aria-label="Justify">
                        <span class="icon icon-sm">@include('icons.align-justify')</span>
                    </button>
                </div>
                <div class="toolbar-group">
                    <button class="toolbar-btn" title="Bullet list" aria-label="Bullet list">
                        <span class="icon icon-sm">@include('icons.list')</span>
                    </button>
                    <button class="toolbar-btn" title="Numbered list" aria-label="Numbered list">
                        <span class="icon icon-sm">@include('icons.list-ordered')</span>
                    </button>
                    <button class="toolbar-btn" title="Decrease indent" aria-label="Decrease indent">
                        <span class="icon icon-sm">@include('icons.indent-decrease')</span>
                    </button>
                    <button class="toolbar-btn" title="Increase indent" aria-label="Increase indent">
                        <span class="icon icon-sm">@include('icons.indent-increase')</span>
                    </button>
                </div>
                <div class="toolbar-group">
                    <button class="toolbar-btn" title="More options" aria-label="More options">
                        <span class="icon icon-sm">@include('icons.more-vertical')</span>
                    </button>
                </div>
            </div>
        </header>

        <div class="editor-wrapper">
            <div class="editor-paper">
                <div class="editor-ruler"></div>
                <div class="editor-ruler-vertical"></div>
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
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                if (!isSaving && !isRemoteUpdate) {
                    clearTimeout(saveTimeout);
                    saveDocument();
                }
            }
            
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

            channel.bind('document.updated', function(data) {
                if (isRemoteUpdate) return;
                
                if (data.document.content !== editor.value) {
                    isRemoteUpdate = true;
                    const cursorPos = editor.selectionStart;
                    editor.value = data.document.content;
                    lastSavedContent = data.document.content;
                    
                    if (cursorPos <= editor.value.length) {
                        editor.setSelectionRange(cursorPos, cursorPos);
                    }
                    
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

        // Handle local edits
        editor.addEventListener('input', function() {
            if (isRemoteUpdate) return;

            clearTimeout(saveTimeout);
            
            const statusText = statusEl.querySelector('.status-text');
            statusText.textContent = 'Typing...';
            statusEl.className = 'status typing';

            saveTimeout = setTimeout(() => {
                saveDocument();
            }, 1000);
        });

        editor.addEventListener('paste', (e) => {
            setTimeout(() => {
                if (!isRemoteUpdate) {
                    clearTimeout(saveTimeout);
                    saveTimeout = setTimeout(() => {
                        saveDocument();
                    }, 500);
                }
            }, 10);
        });

        // Save document
        function saveDocument() {
            if (isSaving || isRemoteUpdate) return;
            
            const currentContent = editor.value || '';
            const normalizedCurrent = currentContent.trim();
            const normalizedLast = (lastSavedContent || '').trim();
            
            if (normalizedCurrent === normalizedLast) {
                // Update lastSavedContent to match current (handles whitespace differences)
                lastSavedContent = currentContent;
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
                lastSavedContent = currentContent || '';
                retryCount = 0;
                const statusText = statusEl.querySelector('.status-text');
                statusText.textContent = 'Saved';
                statusEl.className = 'status saved';
                updateStatusIcon(statusEl, 'saved');
                isSaving = false;
                
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
                navigator.sendBeacon(`/documents/${documentId}`, JSON.stringify({
                    content: editor.value,
                    _method: 'PUT'
                }));
            }
        });

        // Periodic save check
        setInterval(() => {
            const currentContent = editor.value || '';
            const normalizedCurrent = currentContent.trim();
            const normalizedLast = (lastSavedContent || '').trim();
            
            if (normalizedCurrent !== normalizedLast && !isSaving && !isRemoteUpdate) {
                saveDocument();
            }
        }, 30000);
    </script>
</body>
</html>
