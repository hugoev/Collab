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
                <div class="editor-menu-item-wrapper">
                    <button class="editor-menu-item" data-menu="file">File</button>
                    <div class="editor-menu-dropdown" id="menu-file">
                        <button class="editor-menu-dropdown-item" onclick="window.location.href='{{ route('dashboard') }}'">New</button>
                        <button class="editor-menu-dropdown-item disabled">Open...</button>
                        <button class="editor-menu-dropdown-item" onclick="saveDocument(); return false;">Save</button>
                        <div class="editor-menu-dropdown-separator"></div>
                        <button class="editor-menu-dropdown-item" onclick="window.print(); return false;">Print</button>
                        <div class="editor-menu-dropdown-separator"></div>
                        <button class="editor-menu-dropdown-item disabled">Download as...</button>
                        <div class="editor-menu-dropdown-separator"></div>
                        <button class="editor-menu-dropdown-item" onclick="window.location.href='{{ route('dashboard') }}'">Back to Dashboard</button>
                    </div>
                </div>
                <div class="editor-menu-item-wrapper">
                    <button class="editor-menu-item" data-menu="edit">Edit</button>
                    <div class="editor-menu-dropdown" id="menu-edit">
                        <button class="editor-menu-dropdown-item" onclick="document.execCommand('undo', false, null); return false;">Undo</button>
                        <button class="editor-menu-dropdown-item" onclick="document.execCommand('redo', false, null); return false;">Redo</button>
                        <div class="editor-menu-dropdown-separator"></div>
                        <button class="editor-menu-dropdown-item" onclick="document.execCommand('cut', false, null); return false;">Cut</button>
                        <button class="editor-menu-dropdown-item" onclick="document.execCommand('copy', false, null); return false;">Copy</button>
                        <button class="editor-menu-dropdown-item" onclick="document.execCommand('paste', false, null); return false;">Paste</button>
                        <div class="editor-menu-dropdown-separator"></div>
                        <button class="editor-menu-dropdown-item" onclick="document.execCommand('selectAll', false, null); return false;">Select all</button>
                        <button class="editor-menu-dropdown-item disabled">Find and replace</button>
                    </div>
                </div>
                <div class="editor-menu-item-wrapper">
                    <button class="editor-menu-item" data-menu="view">View</button>
                    <div class="editor-menu-dropdown" id="menu-view">
                        <button class="editor-menu-dropdown-item disabled">Print layout</button>
                        <button class="editor-menu-dropdown-item disabled">Mode</button>
                        <div class="editor-menu-dropdown-separator"></div>
                        <button class="editor-menu-dropdown-item disabled">Show ruler</button>
                        <button class="editor-menu-dropdown-item disabled">Show word count</button>
                    </div>
                </div>
                <div class="editor-menu-item-wrapper">
                    <button class="editor-menu-item" data-menu="insert">Insert</button>
                    <div class="editor-menu-dropdown" id="menu-insert">
                        <button class="editor-menu-dropdown-item" onclick="document.getElementById('link-btn').click(); return false;">Link</button>
                        <button class="editor-menu-dropdown-item" onclick="document.getElementById('image-btn').click(); return false;">Image</button>
                        <div class="editor-menu-dropdown-separator"></div>
                        <button class="editor-menu-dropdown-item disabled">Table</button>
                        <button class="editor-menu-dropdown-item disabled">Chart</button>
                        <button class="editor-menu-dropdown-item disabled">Drawing</button>
                    </div>
                </div>
                <div class="editor-menu-item-wrapper">
                    <button class="editor-menu-item" data-menu="format">Format</button>
                    <div class="editor-menu-dropdown" id="menu-format">
                        <button class="editor-menu-dropdown-item" onclick="document.execCommand('bold', false, null); return false;">Bold</button>
                        <button class="editor-menu-dropdown-item" onclick="document.execCommand('italic', false, null); return false;">Italic</button>
                        <button class="editor-menu-dropdown-item" onclick="document.execCommand('underline', false, null); return false;">Underline</button>
                        <div class="editor-menu-dropdown-separator"></div>
                        <button class="editor-menu-dropdown-item disabled">Paragraph styles</button>
                        <button class="editor-menu-dropdown-item disabled">Text styles</button>
                        <div class="editor-menu-dropdown-separator"></div>
                        <button class="editor-menu-dropdown-item disabled">Clear formatting</button>
                    </div>
                </div>
                <div class="editor-menu-item-wrapper">
                    <button class="editor-menu-item" data-menu="tools">Tools</button>
                    <div class="editor-menu-dropdown" id="menu-tools">
                        <button class="editor-menu-dropdown-item disabled">Spelling and grammar</button>
                        <button class="editor-menu-dropdown-item disabled">Word count</button>
                        <div class="editor-menu-dropdown-separator"></div>
                        <button class="editor-menu-dropdown-item disabled">Preferences</button>
                    </div>
                </div>
                <div class="editor-menu-item-wrapper">
                    <button class="editor-menu-item" data-menu="extensions">Extensions</button>
                    <div class="editor-menu-dropdown" id="menu-extensions">
                        <button class="editor-menu-dropdown-item disabled">Add-ons</button>
                        <button class="editor-menu-dropdown-item disabled">Get add-ons</button>
                    </div>
                </div>
                <div class="editor-menu-item-wrapper">
                    <button class="editor-menu-item" data-menu="help">Help</button>
                    <div class="editor-menu-dropdown" id="menu-help">
                        <button class="editor-menu-dropdown-item disabled">Help</button>
                        <button class="editor-menu-dropdown-item disabled">Keyboard shortcuts</button>
                        <div class="editor-menu-dropdown-separator"></div>
                        <button class="editor-menu-dropdown-item disabled">Report a problem</button>
                    </div>
                </div>
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
                    <h1 class="editor-title" contenteditable="true" id="document-title" data-original-title="{{ $document->title }}">{{ $document->title }}</h1>
                    <span class="status" id="status" role="status" aria-live="polite">
                    <span class="status-text">Ready</span>
                </span>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="editor-toolbar">
                <div class="toolbar-group">
                    <button class="toolbar-btn" title="Undo" aria-label="Undo" onclick="undo(); return false;">
                        <span class="icon icon-sm">@include('icons.undo')</span>
                    </button>
                    <button class="toolbar-btn" title="Redo" aria-label="Redo" onclick="redo(); return false;">
                        <span class="icon icon-sm">@include('icons.redo')</span>
                    </button>
                    <button class="toolbar-btn" title="Print" aria-label="Print" onclick="window.print(); return false;">
                        <span class="icon icon-sm">@include('icons.printer')</span>
                    </button>
                </div>
                <div class="toolbar-group">
                    <select class="toolbar-select toolbar-select-zoom" id="zoom-select">
                        <option value="50">50%</option>
                        <option value="75">75%</option>
                        <option value="100" selected>100%</option>
                        <option value="125">125%</option>
                        <option value="150">150%</option>
                        <option value="200">200%</option>
                    </select>
                </div>
                <div class="toolbar-group">
                    <select class="toolbar-select toolbar-select-style" id="style-select">
                        <option value="p">Normal text</option>
                        <option value="h1">Title</option>
                        <option value="h1">Heading 1</option>
                        <option value="h2">Heading 2</option>
                        <option value="h3">Heading 3</option>
                    </select>
                </div>
                <div class="toolbar-group">
                    <select class="toolbar-select toolbar-select-font" id="font-select">
                        <option value="Arial">Arial</option>
                        <option value="Times New Roman">Times New Roman</option>
                        <option value="Courier New">Courier New</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Verdana">Verdana</option>
                        <option value="Roboto">Roboto</option>
                    </select>
                </div>
                <div class="toolbar-group">
                    <input type="number" class="toolbar-input" id="font-size-input" value="11" min="8" max="72" title="Font size">
                </div>
                <div class="toolbar-group">
                    <button class="toolbar-btn" title="Bold" aria-label="Bold" onclick="document.execCommand('bold', false, null); return false;">
                        <span class="icon icon-sm">@include('icons.bold')</span>
                    </button>
                    <button class="toolbar-btn" title="Italic" aria-label="Italic" onclick="document.execCommand('italic', false, null); return false;">
                        <span class="icon icon-sm">@include('icons.italic')</span>
                    </button>
                    <button class="toolbar-btn" title="Underline" aria-label="Underline" onclick="document.execCommand('underline', false, null); return false;">
                        <span class="icon icon-sm">@include('icons.underline')</span>
                    </button>
                    <button class="toolbar-btn" title="Text color" aria-label="Text color" id="text-color-btn">
                        <span class="icon icon-sm">A</span>
                        <input type="color" id="text-color-picker" style="position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer;" value="#000000">
                    </button>
                    <button class="toolbar-btn" title="Highlight" aria-label="Highlight" id="highlight-btn">
                        <span class="icon icon-sm highlight-icon"></span>
                        <input type="color" id="highlight-color-picker" style="position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer;" value="#ffff00">
                    </button>
                </div>
                <div class="toolbar-group">
                    <button class="toolbar-btn" title="Link" aria-label="Link" id="link-btn">
                        <span class="icon icon-sm">@include('icons.link')</span>
                    </button>
                    <button class="toolbar-btn" title="Image" aria-label="Image" id="image-btn">
                        <span class="icon icon-sm">@include('icons.image')</span>
                    </button>
                </div>
                <div class="toolbar-group">
                    <button class="toolbar-btn" title="Align left" aria-label="Align left" onclick="document.execCommand('justifyLeft', false, null); return false;">
                        <span class="icon icon-sm">@include('icons.align-left')</span>
                    </button>
                    <button class="toolbar-btn" title="Align center" aria-label="Align center" onclick="document.execCommand('justifyCenter', false, null); return false;">
                        <span class="icon icon-sm">@include('icons.align-center')</span>
                    </button>
                    <button class="toolbar-btn" title="Align right" aria-label="Align right" onclick="document.execCommand('justifyRight', false, null); return false;">
                        <span class="icon icon-sm">@include('icons.align-right')</span>
                    </button>
                    <button class="toolbar-btn" title="Justify" aria-label="Justify" onclick="document.execCommand('justifyFull', false, null); return false;">
                        <span class="icon icon-sm">@include('icons.align-justify')</span>
                    </button>
                </div>
                <div class="toolbar-group">
                    <button class="toolbar-btn" title="Bullet list" aria-label="Bullet list" onclick="document.execCommand('insertUnorderedList', false, null); return false;">
                        <span class="icon icon-sm">@include('icons.list')</span>
                    </button>
                    <button class="toolbar-btn" title="Numbered list" aria-label="Numbered list" onclick="document.execCommand('insertOrderedList', false, null); return false;">
                        <span class="icon icon-sm">@include('icons.list-ordered')</span>
                    </button>
                    <button class="toolbar-btn" title="Decrease indent" aria-label="Decrease indent" onclick="document.execCommand('outdent', false, null); return false;">
                        <span class="icon icon-sm">@include('icons.indent-decrease')</span>
                    </button>
                    <button class="toolbar-btn" title="Increase indent" aria-label="Increase indent" onclick="document.execCommand('indent', false, null); return false;">
                        <span class="icon icon-sm">@include('icons.indent-increase')</span>
                    </button>
                </div>
                <div class="toolbar-group">
                    <button class="toolbar-btn" title="More options" aria-label="More options" id="more-options-btn">
                        <span class="icon icon-sm">@include('icons.more-vertical')</span>
                    </button>
                </div>
            </div>
        </header>

        <div class="editor-wrapper">
            <div class="editor-paper">
                <div class="editor-ruler"></div>
                <div class="editor-ruler-vertical"></div>
                <div 
                    id="editor" 
                    class="editor" 
                    contenteditable="true"
                    data-placeholder="Start typing your document..."
                >{!! $document->content ?: '' !!}</div>
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
        let lastSavedContent = editor.innerHTML;
        let retryCount = 0;
        const MAX_RETRIES = 3;

        const editorPaper = document.querySelector('.editor-paper');

        // Undo/Redo functionality
        let undoStack = [];
        let redoStack = [];
        let isUndoRedo = false;
        const MAX_HISTORY = 50;

        function saveState() {
            if (isUndoRedo || isRemoteUpdate) return;
            const currentContent = editor.innerHTML;
            if (currentContent !== (undoStack[undoStack.length - 1] || '')) {
                undoStack.push(currentContent);
                if (undoStack.length > MAX_HISTORY) {
                    undoStack.shift();
                }
                redoStack = [];
            }
        }

        function undo() {
            if (undoStack.length <= 1) return;
            isUndoRedo = true;
            redoStack.push(undoStack.pop());
            const previousState = undoStack[undoStack.length - 1] || '';
            editor.innerHTML = previousState;
            isUndoRedo = false;
            lastSavedContent = previousState;
            editor.focus();
        }

        function redo() {
            if (redoStack.length === 0) return;
            isUndoRedo = true;
            const nextState = redoStack.pop();
            undoStack.push(nextState);
            editor.innerHTML = nextState;
            isUndoRedo = false;
            lastSavedContent = nextState;
            editor.focus();
        }

        // Initialize undo stack
        undoStack.push(editor.innerHTML);

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
                // Move cursor to end for contentEditable
                const range = document.createRange();
                const selection = window.getSelection();
                range.selectNodeContents(editor);
                range.collapse(false);
                selection.removeAllRanges();
                selection.addRange(range);
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
            
            if ((e.ctrlKey || e.metaKey) && e.key === 'z' && !e.shiftKey) {
                e.preventDefault();
                undo();
            }
            
            if ((e.ctrlKey || e.metaKey) && (e.key === 'y' || (e.key === 'z' && e.shiftKey))) {
                e.preventDefault();
                redo();
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
                
                const remoteContent = data.document.content || '';
                if (remoteContent !== editor.innerHTML) {
                    isRemoteUpdate = true;
                    const selection = window.getSelection();
                    const range = selection.rangeCount > 0 ? selection.getRangeAt(0) : null;
                    const cursorOffset = range ? range.startOffset : 0;
                    
                    editor.innerHTML = remoteContent;
                    lastSavedContent = remoteContent;
                    
                    // Restore cursor position
                    if (range) {
                        try {
                            const textNode = editor.childNodes[0];
                            if (textNode && textNode.nodeType === Node.TEXT_NODE) {
                                const newRange = document.createRange();
                                newRange.setStart(textNode, Math.min(cursorOffset, textNode.textContent.length));
                                newRange.collapse(true);
                                selection.removeAllRanges();
                                selection.addRange(newRange);
                            }
                        } catch (e) {
                            // If cursor restoration fails, just focus
                            editor.focus();
                        }
                    }
                    
                    // Update undo stack
                    undoStack = [remoteContent];
                    redoStack = [];
                    
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

            saveState();
            clearTimeout(saveTimeout);
            
            const statusText = statusEl.querySelector('.status-text');
            statusText.textContent = 'Typing...';
            statusEl.className = 'status typing';

            saveTimeout = setTimeout(() => {
                saveDocument();
            }, 1000);
        });

        editor.addEventListener('paste', (e) => {
            // Clean paste - remove formatting
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text/plain');
            document.execCommand('insertText', false, text);
            
            setTimeout(() => {
                if (!isRemoteUpdate) {
                    saveState();
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
            
            const currentContent = editor.innerHTML || '';
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
            if (editor.innerHTML !== lastSavedContent && !isSaving) {
                navigator.sendBeacon(`/documents/${documentId}`, JSON.stringify({
                    content: editor.innerHTML,
                    _method: 'PUT'
                }));
            }
        });

        // Periodic save check
        setInterval(() => {
            const currentContent = editor.innerHTML || '';
            const normalizedCurrent = currentContent.trim();
            const normalizedLast = (lastSavedContent || '').trim();
            
            if (normalizedCurrent !== normalizedLast && !isSaving && !isRemoteUpdate) {
                saveDocument();
            }
        }, 30000);

        // Document Title Editing
        const documentTitle = document.getElementById('document-title');
        let titleSaveTimeout;
        let originalTitle = documentTitle.getAttribute('data-original-title');

        documentTitle.addEventListener('input', function() {
            clearTimeout(titleSaveTimeout);
        });

        documentTitle.addEventListener('blur', function() {
            const newTitle = this.textContent.trim();
            if (newTitle === '' || newTitle === originalTitle) {
                if (newTitle === '') {
                    this.textContent = originalTitle;
                }
                return;
            }

            // Save title
            fetch(`/documents/${documentId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    title: newTitle
                })
            })
            .then(response => response.json())
            .then(data => {
                originalTitle = newTitle;
                documentTitle.setAttribute('data-original-title', newTitle);
                // Update page title
                document.title = newTitle + ' - Collab';
            })
            .catch(error => {
                console.error('Error saving title:', error);
                // Revert on error
                documentTitle.textContent = originalTitle;
            });
        });

        documentTitle.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.blur();
            }
            if (e.key === 'Escape') {
                this.textContent = originalTitle;
                this.blur();
            }
        });

        // Zoom functionality
        const zoomSelect = document.getElementById('zoom-select');
        if (zoomSelect) {
            zoomSelect.addEventListener('change', function(e) {
                const zoom = parseInt(e.target.value) / 100;
                const editorPaper = document.querySelector('.editor-paper');
                editorPaper.style.transform = `scale(${zoom})`;
                editorPaper.style.transformOrigin = 'top center';
            });
        }

        // Font size functionality
        const fontSizeInput = document.getElementById('font-size-input');
        if (fontSizeInput) {
            fontSizeInput.addEventListener('change', function(e) {
                const size = parseInt(e.target.value);
                if (size >= 8 && size <= 72) {
                    editor.focus();
                    // Use execCommand with a size mapping (1-7 scale)
                    // Then override with inline style for precise control
                    const sizeMap = {
                        8: 1, 9: 1, 10: 2, 11: 2, 12: 3,
                        14: 3, 16: 4, 18: 4, 20: 5, 24: 6, 36: 7, 48: 7, 72: 7
                    };
                    const execSize = sizeMap[size] || 3;
                    document.execCommand('fontSize', false, execSize.toString());
                    
                    // Apply precise font size via inline style
                    const selection = window.getSelection();
                    if (selection.rangeCount > 0 && !selection.isCollapsed) {
                        const range = selection.getRangeAt(0);
                        const span = document.createElement('span');
                        span.style.fontSize = size + 'pt';
                        try {
                            range.surroundContents(span);
                        } catch (e) {
                            // If surroundContents fails, insert at cursor
                            document.execCommand('insertHTML', false, '<span style="font-size: ' + size + 'pt;">' + selection.toString() + '</span>');
                        }
                    } else {
                        // Apply to current block or selection
                        document.execCommand('fontSize', false, execSize.toString());
                        // Find and update the font tag that was just created
                        setTimeout(() => {
                            const fontTags = editor.querySelectorAll('font[size="' + execSize + '"]');
                            fontTags.forEach(tag => {
                                if (tag.style.fontSize === '' || tag === document.activeElement) {
                                    tag.style.fontSize = size + 'pt';
                                }
                            });
                        }, 10);
                    }
                }
            });
        }

        // Font family functionality
        const fontSelect = document.getElementById('font-select');
        if (fontSelect) {
            fontSelect.addEventListener('change', function(e) {
                const fontFamily = e.target.value;
                document.execCommand('fontName', false, fontFamily);
            });
        }

        // Text style functionality
        const styleSelect = document.getElementById('style-select');
        if (styleSelect) {
            styleSelect.addEventListener('change', function(e) {
                const style = e.target.value;
                if (style === 'p') {
                    document.execCommand('formatBlock', false, '<p>');
                } else if (style === 'h1') {
                    document.execCommand('formatBlock', false, '<h1>');
                } else if (style === 'h2') {
                    document.execCommand('formatBlock', false, '<h2>');
                } else if (style === 'h3') {
                    document.execCommand('formatBlock', false, '<h3>');
                }
                editor.focus();
            });
        }

        // Text color picker
        const textColorBtn = document.getElementById('text-color-btn');
        const textColorPicker = document.getElementById('text-color-picker');
        if (textColorBtn && textColorPicker) {
            textColorPicker.addEventListener('change', function(e) {
                const color = e.target.value;
                document.execCommand('foreColor', false, color);
                editor.focus();
            });
            textColorBtn.addEventListener('click', function(e) {
                if (e.target !== textColorPicker) {
                    textColorPicker.click();
                }
            });
        }

        // Highlight color picker
        const highlightBtn = document.getElementById('highlight-btn');
        const highlightColorPicker = document.getElementById('highlight-color-picker');
        if (highlightBtn && highlightColorPicker) {
            highlightColorPicker.addEventListener('change', function(e) {
                const color = e.target.value;
                document.execCommand('backColor', false, color);
                editor.focus();
            });
            highlightBtn.addEventListener('click', function(e) {
                if (e.target !== highlightColorPicker) {
                    highlightColorPicker.click();
                }
            });
        }

        // Link functionality
        const linkBtn = document.getElementById('link-btn');
        if (linkBtn) {
            linkBtn.addEventListener('click', function() {
                const selection = window.getSelection();
                const selectedText = selection.toString();
                let url = '';
                
                if (selectedText) {
                    url = prompt('Enter URL for the selected text:', 'https://');
                } else {
                    url = prompt('Enter URL:', 'https://');
                }
                
                if (url && url.trim() !== '') {
                    if (!url.startsWith('http://') && !url.startsWith('https://')) {
                        url = 'https://' + url;
                    }
                    document.execCommand('createLink', false, url);
                    editor.focus();
                }
            });
        }

        // Image functionality
        const imageBtn = document.getElementById('image-btn');
        if (imageBtn) {
            imageBtn.addEventListener('click', function() {
                const url = prompt('Enter image URL:', 'https://');
                if (url && url.trim() !== '') {
                    document.execCommand('insertImage', false, url);
                    editor.focus();
                }
            });
        }

        // Share button functionality
        const shareBtn = document.querySelector('[aria-label="Share"]');
        if (shareBtn) {
            shareBtn.addEventListener('click', function() {
                const url = window.location.href;
                if (navigator.share) {
                    navigator.share({
                        title: document.title,
                        url: url
                    }).catch(err => {
                        // Fallback to clipboard
                        navigator.clipboard.writeText(url).then(() => {
                            alert('Link copied to clipboard!');
                        });
                    });
                } else {
                    // Fallback to clipboard
                    navigator.clipboard.writeText(url).then(() => {
                        alert('Link copied to clipboard!');
                    }).catch(() => {
                        // Final fallback - show URL
                        prompt('Copy this link:', url);
                    });
                }
            });
        }

        // History button - placeholder
        const historyBtn = document.querySelector('[aria-label="History"]');
        if (historyBtn) {
            historyBtn.addEventListener('click', function() {
                alert('Version history coming soon!');
            });
        }

        // Comments button - placeholder
        const commentsBtn = document.querySelector('[aria-label="Comments"]');
        if (commentsBtn) {
            commentsBtn.addEventListener('click', function() {
                alert('Comments feature coming soon!');
            });
        }

        // Menu dropdown functionality
        const menuItems = document.querySelectorAll('.editor-menu-item[data-menu]');
        menuItems.forEach(menuItem => {
            menuItem.addEventListener('click', function(e) {
                e.stopPropagation();
                const menuName = this.getAttribute('data-menu');
                const dropdown = document.getElementById('menu-' + menuName);
                
                // Close all other dropdowns
                document.querySelectorAll('.editor-menu-dropdown').forEach(dd => {
                    if (dd.id !== dropdown.id) {
                        dd.classList.remove('show');
                    }
                });
                
                // Toggle current dropdown
                dropdown.classList.toggle('show');
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.editor-menu-item-wrapper')) {
                document.querySelectorAll('.editor-menu-dropdown').forEach(dd => {
                    dd.classList.remove('show');
                });
            }
        });

        // Close dropdowns when clicking on dropdown items
        document.querySelectorAll('.editor-menu-dropdown-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (!this.classList.contains('disabled')) {
                    // Close all dropdowns after a short delay to allow the action to execute
                    setTimeout(() => {
                        document.querySelectorAll('.editor-menu-dropdown').forEach(dd => {
                            dd.classList.remove('show');
                        });
                    }, 100);
                } else {
                    e.preventDefault();
                }
            });
        });

        // More options button - placeholder
        const moreOptionsBtn = document.getElementById('more-options-btn');
        if (moreOptionsBtn) {
            moreOptionsBtn.addEventListener('click', function() {
                alert('More formatting options coming soon!');
            });
        }
    </script>
</body>
</html>
