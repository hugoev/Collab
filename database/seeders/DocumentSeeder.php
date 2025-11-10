<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users or create a test user if none exist
        $users = User::all();
        
        if ($users->isEmpty()) {
            $user = User::factory()->create([
                'name' => 'Demo User',
                'email' => 'demo@example.com',
                'password' => bcrypt('password'),
            ]);
            $users = collect([$user]);
        }

        // Sample document contents
        $documents = [
            [
                'title' => 'Project Proposal',
                'content' => "# Project Proposal\n\n## Executive Summary\n\nThis document outlines the key objectives and deliverables for our upcoming project. We aim to deliver a comprehensive solution that meets all stakeholder requirements.\n\n## Objectives\n\n1. Improve user experience\n2. Increase efficiency\n3. Reduce operational costs\n\n## Timeline\n\n- Phase 1: Planning (Weeks 1-2)\n- Phase 2: Development (Weeks 3-6)\n- Phase 3: Testing (Weeks 7-8)\n- Phase 4: Deployment (Week 9)\n\n## Budget\n\nThe estimated budget for this project is $50,000.",
            ],
            [
                'title' => 'Meeting Notes - Q4 Planning',
                'content' => "## Meeting Notes - Q4 Planning Session\n\n**Date:** October 15, 2024\n**Attendees:** Team Leads, Product Managers, Engineering\n\n### Key Discussion Points\n\n1. **Product Roadmap**\n   - Focus on user feedback integration\n   - Prioritize mobile experience improvements\n   - New feature rollout planned for December\n\n2. **Resource Allocation**\n   - Additional developers needed for frontend work\n   - Design team capacity is sufficient\n\n3. **Timeline Adjustments**\n   - Beta release moved to November 20th\n   - Final release scheduled for December 15th\n\n### Action Items\n\n- [ ] Review user feedback surveys\n- [ ] Schedule design review meeting\n- [ ] Update project timeline in project management tool",
            ],
            [
                'title' => 'Technical Documentation',
                'content' => "# Technical Documentation\n\n## Architecture Overview\n\nOur system follows a microservices architecture with the following components:\n\n### Frontend\n- React-based user interface\n- Real-time updates using WebSockets\n- Responsive design for mobile and desktop\n\n### Backend\n- RESTful API built with Laravel\n- Database: PostgreSQL\n- Caching layer: Redis\n\n### Infrastructure\n- Containerized deployment with Docker\n- CI/CD pipeline with GitHub Actions\n- Monitoring with Prometheus and Grafana\n\n## API Endpoints\n\n### Documents\n- `GET /api/documents` - List all documents\n- `POST /api/documents` - Create new document\n- `PUT /api/documents/{id}` - Update document\n- `DELETE /api/documents/{id}` - Delete document\n\n## Database Schema\n\n```sql\nCREATE TABLE documents (\n    id BIGSERIAL PRIMARY KEY,\n    user_id BIGINT REFERENCES users(id),\n    title VARCHAR(255) NOT NULL,\n    content TEXT,\n    created_at TIMESTAMP,\n    updated_at TIMESTAMP\n);\n```",
            ],
            [
                'title' => 'Weekly Report',
                'content' => "# Weekly Report - Week of October 8, 2024\n\n## Summary\n\nThis week we made significant progress on several key initiatives. The team completed the initial design phase and began development on core features.\n\n## Completed Tasks\n\n✅ User authentication system\n✅ Document creation and editing\n✅ Real-time collaboration features\n✅ Dashboard UI implementation\n\n## In Progress\n\n🔄 Search functionality\n🔄 Document sharing features\n🔄 Mobile responsive design\n\n## Blockers\n\n⚠️ Waiting for API documentation from third-party service\n⚠️ Need clarification on user permission requirements\n\n## Next Week's Goals\n\n1. Complete search implementation\n2. Begin work on sharing features\n3. Conduct user testing sessions\n4. Address any critical bugs found in testing",
            ],
            [
                'title' => 'Product Requirements',
                'content' => "# Product Requirements Document\n\n## Product Overview\n\nWe are building a collaborative document editing platform that allows teams to work together in real-time.\n\n## User Stories\n\n### As a user, I want to:\n\n1. Create and edit documents\n2. Share documents with team members\n3. See changes in real-time\n4. Search through my documents\n5. Organize documents in folders\n\n## Functional Requirements\n\n### Document Management\n- Users can create, edit, and delete documents\n- Documents support rich text formatting\n- Auto-save functionality\n- Version history\n\n### Collaboration\n- Real-time editing with multiple users\n- Comments and suggestions\n- User presence indicators\n- Conflict resolution\n\n### Search and Organization\n- Full-text search across documents\n- Tagging system\n- Folder organization\n- Recent documents view\n\n## Non-Functional Requirements\n\n- Response time: < 200ms for document updates\n- Support for 100+ concurrent users per document\n- 99.9% uptime SLA\n- Mobile-responsive design",
            ],
            [
                'title' => 'Marketing Strategy',
                'content' => "# Marketing Strategy 2024\n\n## Target Audience\n\nOur primary target audience consists of:\n\n- Small to medium businesses (10-500 employees)\n- Remote teams\n- Creative agencies\n- Educational institutions\n\n## Marketing Channels\n\n### Digital Marketing\n1. **Content Marketing**\n   - Blog posts about collaboration best practices\n   - Case studies from successful customers\n   - Video tutorials and webinars\n\n2. **Social Media**\n   - LinkedIn for B2B outreach\n   - Twitter for product updates\n   - YouTube for video content\n\n3. **Paid Advertising**\n   - Google Ads for search terms\n   - LinkedIn sponsored content\n   - Retargeting campaigns\n\n### Partnerships\n\n- Integration partnerships with popular tools\n- Referral program for existing customers\n- Affiliate marketing program\n\n## Key Messages\n\n1. \"Collaborate seamlessly, work efficiently\"\n2. \"Real-time editing for modern teams\"\n3. \"Your documents, your way\"\n\n## Success Metrics\n\n- Monthly active users (MAU)\n- Customer acquisition cost (CAC)\n- Lifetime value (LTV)\n- Net promoter score (NPS)",
            ],
        ];

        // Create documents for each user
        foreach ($users as $user) {
            foreach ($documents as $docData) {
                Document::create([
                    'user_id' => $user->id,
                    'title' => $docData['title'],
                    'content' => $docData['content'],
                ]);
            }
        }

        $this->command->info('Created ' . count($documents) . ' mock documents for each user.');
    }
}

