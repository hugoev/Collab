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
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <div class="search-box">
                        <button type="button" class="search-icon" aria-label="Search" onclick="document.querySelector('.search-input').focus()">
                            @include('icons.search')
                        </button>
                        <input type="search" class="search-input" placeholder="Search" aria-label="Search documents">
                    </div>
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
                            <button type="button" class="link-btn" id="scroll-to-templates">Template gallery</button>
                        </div>
                    </h2>
                    <div class="template-gallery" id="template-gallery">
                        <div class="template-card" data-template="blank">
                            <div class="template-card-preview template-card-blank">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"/>
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
                            </div>
                            <div class="template-card-info">
                                <div class="template-card-title">Blank document</div>
                                <div class="template-card-subtitle">Start from scratch</div>
                            </div>
                        </div>
                        <div class="template-card" data-template="resume">
                            <div class="template-card-preview template-card-resume">
                                @include('icons.template-resume')
                            </div>
                            <div class="template-card-info">
                                <div class="template-card-title">Resume</div>
                                <div class="template-card-subtitle">Professional template</div>
                            </div>
                        </div>
                        <div class="template-card" data-template="letter">
                            <div class="template-card-preview template-card-letter">
                                @include('icons.template-letter')
                            </div>
                            <div class="template-card-info">
                                <div class="template-card-title">Letter</div>
                                <div class="template-card-subtitle">Business letter format</div>
                            </div>
                        </div>
                        <div class="template-card" data-template="report">
                            <div class="template-card-preview template-card-report">
                                @include('icons.template-report')
                            </div>
                            <div class="template-card-info">
                                <div class="template-card-title">Report</div>
                                <div class="template-card-subtitle">Formal report layout</div>
                            </div>
                        </div>
                        <div class="template-card" data-template="meeting-notes">
                            <div class="template-card-preview template-card-notes">
                                @include('icons.template-notes')
                            </div>
                            <div class="template-card-info">
                                <div class="template-card-title">Meeting Notes</div>
                                <div class="template-card-subtitle">Structured notes</div>
                            </div>
                        </div>
                        <div class="template-card" data-template="project-plan">
                            <div class="template-card-preview template-card-plan">
                                @include('icons.template-plan')
                            </div>
                            <div class="template-card-info">
                                <div class="template-card-title">Project Plan</div>
                                <div class="template-card-subtitle">Planning template</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Create document form (hidden by default, shown when template clicked) -->
                <div class="create-document-section" id="create-document">
                    <div class="create-document-card">
                        <div class="create-document-header">
                            <h3 id="create-document-title">Create New Document</h3>
                            <button type="button" class="close-btn" id="close-create-form" aria-label="Close">
                                <span class="icon icon-sm">@include('icons.x')</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('documents.store') }}" id="create-form" class="create-document-form">
                            @csrf
                            <input type="hidden" id="template-content" name="content" value="">
                            <div class="form-group">
                                <label for="title">Document Title</label>
                                <input type="text" id="title" name="title" placeholder="Enter document title" required autofocus>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary" id="cancel-create">Cancel</button>
                                <button type="submit" class="btn btn-primary">
                                    <span class="icon icon-sm">@include('icons.add')</span>
                                    <span>Create Document</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Recent documents section -->
                <div class="dashboard-section">
                    <h2 class="dashboard-section-title">
                        <span>Recent documents</span>
                        <div class="section-header-actions">
                            <div class="document-filters">
                                <button class="filter-dropdown">
                                    <span>Owned by me</span>
                                    <span class="icon icon-sm">@include('icons.chevron-down')</span>
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
                                            <div class="document-card-preview-title">{{ $document->title }}</div>
                                            <div class="document-card-preview-content">
                                                @if($document->content)
                                                    {!! Str::limit(strip_tags($document->content), 200) ?: 'Empty document' !!}
                                                @else
                                                    <span style="color: #80868b; font-style: italic;">Empty document</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="document-card-info">
                                        <div class="document-card-title">{{ $document->title }}</div>
                                        <div class="document-card-date">{{ $document->updated_at->format('M d, Y') }}</div>
                                        <div class="document-card-menu-wrapper">
                                            <button class="document-card-menu" onclick="event.stopPropagation(); toggleDocumentMenu(this);" aria-label="More options" data-document-id="{{ $document->id }}">
                                                <span class="icon icon-sm">@include('icons.more-vertical')</span>
                                            </button>
                                            <div class="document-menu-dropdown" id="menu-{{ $document->id }}" style="display: none;">
                                                <button class="menu-item" onclick="deleteDocument({{ $document->id }}, '{{ addslashes($document->title) }}'); event.stopPropagation();">
                                                    <span class="icon icon-sm">@include('icons.trash')</span>
                                                    <span>Delete</span>
                                                </button>
                                            </div>
                                        </div>
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
                            <button class="btn btn-primary mt-6">
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
        // Template content definitions
        const templates = {
            blank: {
                title: 'Untitled Document',
                content: ''
            },
            resume: {
                title: 'My Resume',
                content: `<h1 style="text-align: center; font-size: 24pt; margin-bottom: 8px;">Your Name</h1>
<p style="text-align: center; color: #5f6368; margin-bottom: 24px;">your.email@example.com | (555) 123-4567 | City, State</p>

<h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px; border-bottom: 2px solid #000; padding-bottom: 4px;">Professional Summary</h2>
<p style="margin-bottom: 16px;">Experienced professional with a proven track record of success in [your field]. Skilled in [key skills] with expertise in [areas of expertise].</p>

<h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px; border-bottom: 2px solid #000; padding-bottom: 4px;">Experience</h2>
<p style="margin-bottom: 8px;"><strong>Job Title</strong> | Company Name | Date Range</p>
<ul style="margin-bottom: 16px; padding-left: 20px;">
    <li>Key achievement or responsibility</li>
    <li>Key achievement or responsibility</li>
    <li>Key achievement or responsibility</li>
</ul>

<h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px; border-bottom: 2px solid #000; padding-bottom: 4px;">Education</h2>
<p style="margin-bottom: 8px;"><strong>Degree</strong> | University Name | Graduation Year</p>
<p style="margin-bottom: 16px;">Relevant coursework or honors</p>

<h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px; border-bottom: 2px solid #000; padding-bottom: 4px;">Skills</h2>
<p style="margin-bottom: 16px;">Skill 1, Skill 2, Skill 3, Skill 4, Skill 5</p>`
            },
            letter: {
                title: 'Business Letter',
                content: `<p style="text-align: right; margin-bottom: 24px;">[Your Name]<br>[Your Address]<br>[City, State ZIP Code]<br>[Date]</p>

<p style="margin-bottom: 8px;">[Recipient Name]</p>
<p style="margin-bottom: 8px;">[Recipient Title]</p>
<p style="margin-bottom: 8px;">[Company Name]</p>
<p style="margin-bottom: 8px;">[Company Address]</p>
<p style="margin-bottom: 24px;">[City, State ZIP Code]</p>

<p style="margin-bottom: 8px;">Dear [Recipient Name],</p>

<p style="margin-bottom: 16px; line-height: 1.6;">I am writing to [purpose of letter]. [First paragraph explaining the main purpose and context of your letter.]</p>

<p style="margin-bottom: 16px; line-height: 1.6;">[Second paragraph providing additional details, supporting information, or specific requests.]</p>

<p style="margin-bottom: 16px; line-height: 1.6;">[Third paragraph summarizing key points and next steps, if applicable.]</p>

<p style="margin-bottom: 24px; line-height: 1.6;">Thank you for your time and consideration. I look forward to hearing from you soon.</p>

<p style="margin-bottom: 8px;">Sincerely,</p>
<p style="margin-bottom: 8px;">[Your Name]</p>`
            },
            report: {
                title: 'Project Report',
                content: `<h1 style="text-align: center; font-size: 24pt; margin-bottom: 8px;">Report Title</h1>
<p style="text-align: center; color: #5f6368; margin-bottom: 32px;">Prepared by: [Your Name]<br>Date: [Date]<br>Department: [Department]</p>

<h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Executive Summary</h2>
<p style="margin-bottom: 16px; line-height: 1.6;">This report provides an overview of [report topic]. The key findings indicate [summary of main findings]. Recommendations include [brief summary of recommendations].</p>

<h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Introduction</h2>
<p style="margin-bottom: 16px; line-height: 1.6;">[Introduction paragraph explaining the purpose, scope, and background of the report.]</p>

<h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Findings</h2>
<h3 style="font-size: 14pt; margin-top: 16px; margin-bottom: 8px;">Finding 1</h3>
<p style="margin-bottom: 12px; line-height: 1.6;">[Description of first finding with supporting data and analysis.]</p>

<h3 style="font-size: 14pt; margin-top: 16px; margin-bottom: 8px;">Finding 2</h3>
<p style="margin-bottom: 12px; line-height: 1.6;">[Description of second finding with supporting data and analysis.]</p>

<h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Analysis</h2>
<p style="margin-bottom: 16px; line-height: 1.6;">[Analysis section discussing the implications of the findings and their significance.]</p>

<h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Recommendations</h2>
<ol style="margin-bottom: 16px; padding-left: 20px; line-height: 1.6;">
    <li style="margin-bottom: 8px;">[First recommendation]</li>
    <li style="margin-bottom: 8px;">[Second recommendation]</li>
    <li style="margin-bottom: 8px;">[Third recommendation]</li>
</ol>

<h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Conclusion</h2>
<p style="margin-bottom: 16px; line-height: 1.6;">[Conclusion summarizing the key points and emphasizing the importance of the findings and recommendations.]</p>`
            },
            'meeting-notes': {
                title: 'Meeting Notes',
                content: `<h1 style="font-size: 20pt; margin-bottom: 8px;">Meeting Notes</h1>
<p style="color: #5f6368; margin-bottom: 24px;">Date: [Date] | Attendees: [List attendees] | Location: [Location]</p>

<h2 style="font-size: 16pt; margin-top: 20px; margin-bottom: 12px;">Agenda</h2>
<ul style="margin-bottom: 20px; padding-left: 20px; line-height: 1.6;">
    <li style="margin-bottom: 4px;">Agenda item 1</li>
    <li style="margin-bottom: 4px;">Agenda item 2</li>
    <li style="margin-bottom: 4px;">Agenda item 3</li>
</ul>

<h2 style="font-size: 16pt; margin-top: 20px; margin-bottom: 12px;">Discussion Points</h2>
<p style="margin-bottom: 12px; line-height: 1.6;"><strong>Topic 1:</strong> [Discussion notes and key points]</p>
<p style="margin-bottom: 12px; line-height: 1.6;"><strong>Topic 2:</strong> [Discussion notes and key points]</p>
<p style="margin-bottom: 12px; line-height: 1.6;"><strong>Topic 3:</strong> [Discussion notes and key points]</p>

<h2 style="font-size: 16pt; margin-top: 20px; margin-bottom: 12px;">Action Items</h2>
<ul style="margin-bottom: 20px; padding-left: 20px; line-height: 1.6;">
    <li style="margin-bottom: 8px;"><strong>[Person]</strong> - [Action item] (Due: [Date])</li>
    <li style="margin-bottom: 8px;"><strong>[Person]</strong> - [Action item] (Due: [Date])</li>
    <li style="margin-bottom: 8px;"><strong>[Person]</strong> - [Action item] (Due: [Date])</li>
</ul>

<h2 style="font-size: 16pt; margin-top: 20px; margin-bottom: 12px;">Next Steps</h2>
<p style="margin-bottom: 12px; line-height: 1.6;">[Summary of next steps and follow-up items]</p>

<p style="margin-top: 24px; color: #5f6368; font-style: italic;">Next meeting: [Date and time]</p>`
            },
            'project-plan': {
                title: 'Project Plan',
                content: `<h1 style="text-align: center; font-size: 24pt; margin-bottom: 8px;">Project Plan</h1>
<p style="text-align: center; color: #5f6368; margin-bottom: 32px;">Project: [Project Name]<br>Created: [Date] | Owner: [Your Name]</p>

<h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Project Overview</h2>
<p style="margin-bottom: 16px; line-height: 1.6;"><strong>Objective:</strong> [Project objective and goals]</p>
<p style="margin-bottom: 16px; line-height: 1.6;"><strong>Scope:</strong> [What is included and excluded from the project]</p>
<p style="margin-bottom: 16px; line-height: 1.6;"><strong>Success Criteria:</strong> [How success will be measured]</p>

<h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Timeline</h2>
<h3 style="font-size: 14pt; margin-top: 16px; margin-bottom: 8px;">Phase 1: [Phase Name]</h3>
<p style="margin-bottom: 8px;"><strong>Duration:</strong> [Start Date] - [End Date]</p>
<ul style="margin-bottom: 16px; padding-left: 20px; line-height: 1.6;">
    <li style="margin-bottom: 4px;">Task 1</li>
    <li style="margin-bottom: 4px;">Task 2</li>
    <li style="margin-bottom: 4px;">Task 3</li>
</ul>

<h3 style="font-size: 14pt; margin-top: 16px; margin-bottom: 8px;">Phase 2: [Phase Name]</h3>
<p style="margin-bottom: 8px;"><strong>Duration:</strong> [Start Date] - [End Date]</p>
<ul style="margin-bottom: 16px; padding-left: 20px; line-height: 1.6;">
    <li style="margin-bottom: 4px;">Task 1</li>
    <li style="margin-bottom: 4px;">Task 2</li>
    <li style="margin-bottom: 4px;">Task 3</li>
</ul>

<h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Resources</h2>
<ul style="margin-bottom: 16px; padding-left: 20px; line-height: 1.6;">
    <li style="margin-bottom: 4px;"><strong>Team Members:</strong> [List team members and roles]</li>
    <li style="margin-bottom: 4px;"><strong>Budget:</strong> [Budget allocation]</li>
    <li style="margin-bottom: 4px;"><strong>Tools & Technology:</strong> [Required tools and software]</li>
</ul>

<h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Risks & Mitigation</h2>
<p style="margin-bottom: 12px; line-height: 1.6;"><strong>Risk 1:</strong> [Description] - <em>Mitigation:</em> [How to address]</p>
<p style="margin-bottom: 12px; line-height: 1.6;"><strong>Risk 2:</strong> [Description] - <em>Mitigation:</em> [How to address]</p>

<h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Milestones</h2>
<ul style="margin-bottom: 16px; padding-left: 20px; line-height: 1.6;">
    <li style="margin-bottom: 8px;"><strong>[Date]:</strong> [Milestone description]</li>
    <li style="margin-bottom: 8px;"><strong>[Date]:</strong> [Milestone description]</li>
    <li style="margin-bottom: 8px;"><strong>[Date]:</strong> [Milestone description]</li>
</ul>`
            }
        };

        // Create document immediately when template is clicked
        document.querySelectorAll('.template-card').forEach(card => {
            card.addEventListener('click', function(e) {
                e.preventDefault();
                const templateType = this.getAttribute('data-template');
                const template = templates[templateType];
                
                if (template) {
                    // Disable the card to prevent double-clicks
                    this.style.pointerEvents = 'none';
                    this.style.opacity = '0.6';
                    
                    // Create document via AJAX
                    const formData = new FormData();
                    formData.append('title', template.title);
                    formData.append('content', template.content);
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                    
                    fetch('{{ route("documents.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (response.redirected) {
                            window.location.href = response.url;
                            return;
                        }
                        if (!response.ok) {
                            throw new Error('Failed to create document');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data && data.redirect) {
                            window.location.href = data.redirect;
                        } else if (data && data.document && data.document.id) {
                            window.location.href = `/documents/${data.document.id}`;
                        } else {
                            // Fallback: reload page to get the new document
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error creating document:', error);
                        alert('Failed to create document. Please try again.');
                        // Re-enable the card
                        this.style.pointerEvents = '';
                        this.style.opacity = '1';
                    });
                }
            });
        });
        
        // Show form when empty state button is clicked (for blank document)
        const emptyStateBtn = document.querySelector('.empty-state .btn');
        if (emptyStateBtn) {
            emptyStateBtn.addEventListener('click', function() {
                const template = templates.blank;
                
                // Create blank document immediately
                const formData = new FormData();
                formData.append('title', template.title);
                formData.append('content', template.content);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                
                fetch('{{ route("documents.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                        return;
                    }
                    if (!response.ok) {
                        throw new Error('Failed to create document');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.redirect) {
                        window.location.href = data.redirect;
                    } else if (data && data.document && data.document.id) {
                        window.location.href = `/documents/${data.document.id}`;
                    } else {
                        // Fallback: reload
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error creating document:', error);
                    alert('Failed to create document. Please try again.');
                });
            });
        }

        // Scroll to template gallery
        document.getElementById('scroll-to-templates')?.addEventListener('click', function() {
            document.getElementById('template-gallery').scrollIntoView({behavior: 'smooth', block: 'start'});
        });

        // Search Functionality - Real-time document filtering
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().trim();
                const documentCards = document.querySelectorAll('.document-card');
                let visibleCount = 0;

                documentCards.forEach(card => {
                    const title = card.querySelector('.document-card-title')?.textContent.toLowerCase() || '';
                    const content = card.querySelector('.document-card-preview-content')?.textContent.toLowerCase() || '';
                    
                    if (searchTerm === '' || title.includes(searchTerm) || content.includes(searchTerm)) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show "no results" message if needed
                const documentGrid = document.querySelector('.document-grid');
                let noResultsMsg = document.querySelector('.no-results-message');
                
                if (searchTerm !== '' && visibleCount === 0) {
                    if (!noResultsMsg && documentGrid) {
                        noResultsMsg = document.createElement('div');
                        noResultsMsg.className = 'no-results-message';
                        noResultsMsg.innerHTML = `
                            <div class="empty-state">
                                <h3>No documents found</h3>
                                <p>Try a different search term</p>
                            </div>
                        `;
                        documentGrid.parentNode.insertBefore(noResultsMsg, documentGrid.nextSibling);
                    }
                } else if (noResultsMsg) {
                    noResultsMsg.remove();
                }
            });
        }

        // Document menu toggle
        function toggleDocumentMenu(button) {
            const documentId = button.getAttribute('data-document-id');
            const menu = document.getElementById('menu-' + documentId);
            const allMenus = document.querySelectorAll('.document-menu-dropdown');
            
            // Close all other menus
            allMenus.forEach(m => {
                if (m.id !== menu.id) {
                    m.style.display = 'none';
                }
            });
            
            // Toggle current menu
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }

        // Close menus when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.document-card-menu-wrapper')) {
                document.querySelectorAll('.document-menu-dropdown').forEach(menu => {
                    menu.style.display = 'none';
                });
            }
        });

        // Delete document with confirmation
        function deleteDocument(documentId, documentTitle) {
            if (!confirm(`Are you sure you want to delete "${documentTitle}"? This action cannot be undone.`)) {
                return;
            }

            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/documents/${documentId}`;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            
            if (!csrfToken) {
                console.error('CSRF token not found');
                return;
            }
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            
            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = csrfToken;
            
            form.appendChild(methodInput);
            form.appendChild(tokenInput);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>
