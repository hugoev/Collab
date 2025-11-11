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

        // Sample document contents with HTML formatting for better UI display
        $documents = [
            [
                'title' => 'My Resume',
                'content' => '<h1 style="text-align: center; font-size: 24pt; margin-bottom: 8px;">Sarah Johnson</h1><p style="text-align: center; color: #5f6368; margin-bottom: 24px;">sarah.johnson@email.com | (555) 234-5678 | San Francisco, CA</p><h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px; border-bottom: 2px solid #000; padding-bottom: 4px;">Professional Summary</h2><p style="margin-bottom: 16px;">Experienced software engineer with 8+ years in full-stack development. Specialized in building scalable web applications and leading cross-functional teams to deliver high-quality products.</p><h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px; border-bottom: 2px solid #000; padding-bottom: 4px;">Experience</h2><p style="margin-bottom: 8px;"><strong>Senior Software Engineer</strong> | TechCorp Inc. | 2020 - Present</p><ul style="margin-bottom: 16px; padding-left: 20px;"><li>Led development of real-time collaboration platform serving 100K+ users</li><li>Architected microservices infrastructure reducing latency by 40%</li><li>Mentored team of 5 junior developers</li></ul>',
            ],
            [
                'title' => 'Q4 Planning Meeting Notes',
                'content' => '<h1 style="font-size: 20pt; margin-bottom: 8px;">Meeting Notes</h1><p style="color: #5f6368; margin-bottom: 24px;">Date: November 10, 2024 | Attendees: Product Team, Engineering Leads | Location: Conference Room A</p><h2 style="font-size: 16pt; margin-top: 20px; margin-bottom: 12px;">Agenda</h2><ul style="margin-bottom: 20px; padding-left: 20px; line-height: 1.6;"><li style="margin-bottom: 4px;">Q4 roadmap review</li><li style="margin-bottom: 4px;">Resource allocation discussion</li><li style="margin-bottom: 4px;">Timeline adjustments</li></ul><h2 style="font-size: 16pt; margin-top: 20px; margin-bottom: 12px;">Discussion Points</h2><p style="margin-bottom: 12px; line-height: 1.6;"><strong>Product Roadmap:</strong> Focus on user feedback integration and mobile experience improvements. New feature rollout planned for December.</p><p style="margin-bottom: 12px; line-height: 1.6;"><strong>Resource Allocation:</strong> Additional developers needed for frontend work. Design team capacity is sufficient.</p><h2 style="font-size: 16pt; margin-top: 20px; margin-bottom: 12px;">Action Items</h2><ul style="margin-bottom: 20px; padding-left: 20px; line-height: 1.6;"><li style="margin-bottom: 8px;"><strong>Sarah</strong> - Review user feedback surveys (Due: Nov 15)</li><li style="margin-bottom: 8px;"><strong>Mike</strong> - Schedule design review meeting (Due: Nov 12)</li></ul>',
            ],
            [
                'title' => 'Project Report - Q3 Results',
                'content' => '<h1 style="text-align: center; font-size: 24pt; margin-bottom: 8px;">Q3 Project Results Report</h1><p style="text-align: center; color: #5f6368; margin-bottom: 32px;">Prepared by: Marketing Team<br>Date: October 15, 2024<br>Department: Product Marketing</p><h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Executive Summary</h2><p style="margin-bottom: 16px; line-height: 1.6;">Q3 showed strong growth across all key metrics. User acquisition increased by 35%, engagement improved by 28%, and customer satisfaction reached an all-time high of 4.8/5.0.</p><h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Key Findings</h2><h3 style="font-size: 14pt; margin-top: 16px; margin-bottom: 8px;">User Growth</h3><p style="margin-bottom: 12px; line-height: 1.6;">Monthly active users grew from 50K to 67.5K, representing a 35% increase quarter-over-quarter.</p><h3 style="font-size: 14pt; margin-top: 16px; margin-bottom: 8px;">Feature Adoption</h3><p style="margin-bottom: 12px; line-height: 1.6;">New collaboration features saw 78% adoption rate within first month of release.</p><h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Recommendations</h2><ol style="margin-bottom: 16px; padding-left: 20px; line-height: 1.6;"><li style="margin-bottom: 8px;">Continue investment in mobile experience</li><li style="margin-bottom: 8px;">Expand integration partnerships</li><li style="margin-bottom: 8px;">Launch referral program in Q4</li></ol>',
            ],
            [
                'title' => 'Business Letter - Partnership Inquiry',
                'content' => '<p style="text-align: right; margin-bottom: 24px;">John Smith<br>123 Business St<br>New York, NY 10001<br>November 10, 2024</p><p style="margin-bottom: 8px;">Jane Doe</p><p style="margin-bottom: 8px;">Director of Partnerships</p><p style="margin-bottom: 8px;">Innovation Labs</p><p style="margin-bottom: 8px;">456 Tech Avenue</p><p style="margin-bottom: 24px;">San Francisco, CA 94102</p><p style="margin-bottom: 8px;">Dear Ms. Doe,</p><p style="margin-bottom: 16px; line-height: 1.6;">I am writing to explore potential partnership opportunities between our organizations. We have been impressed by Innovation Labs\' recent work in collaborative technology and believe there is significant synergy between our products.</p><p style="margin-bottom: 16px; line-height: 1.6;">Our platform serves over 100,000 active users and we are looking to expand our integration ecosystem. A partnership could provide mutual benefits through co-marketing opportunities and technical integration.</p><p style="margin-bottom: 24px; line-height: 1.6;">Thank you for your time and consideration. I look forward to discussing this opportunity further and would be happy to schedule a call at your convenience.</p><p style="margin-bottom: 8px;">Sincerely,</p><p style="margin-bottom: 8px;">John Smith<br>Business Development Manager</p>',
            ],
            [
                'title' => 'Product Launch Plan',
                'content' => '<h1 style="text-align: center; font-size: 24pt; margin-bottom: 8px;">Product Launch Plan</h1><p style="text-align: center; color: #5f6368; margin-bottom: 32px;">Project: New Feature Rollout<br>Created: November 1, 2024 | Owner: Product Team</p><h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Project Overview</h2><p style="margin-bottom: 16px; line-height: 1.6;"><strong>Objective:</strong> Successfully launch new collaboration features to 100% of user base by December 15, 2024.</p><p style="margin-bottom: 16px; line-height: 1.6;"><strong>Scope:</strong> Feature development, testing, documentation, marketing campaign, and user onboarding.</p><h2 style="font-size: 18pt; margin-top: 24px; margin-bottom: 12px;">Timeline</h2><h3 style="font-size: 14pt; margin-top: 16px; margin-bottom: 8px;">Phase 1: Development</h3><p style="margin-bottom: 8px;"><strong>Duration:</strong> Nov 1 - Nov 20</p><ul style="margin-bottom: 16px; padding-left: 20px; line-height: 1.6;"><li style="margin-bottom: 4px;">Core feature implementation</li><li style="margin-bottom: 4px;">API development</li><li style="margin-bottom: 4px;">UI/UX implementation</li></ul><h3 style="font-size: 14pt; margin-top: 16px; margin-bottom: 8px;">Phase 2: Testing & Launch</h3><p style="margin-bottom: 8px;"><strong>Duration:</strong> Nov 21 - Dec 15</p><ul style="margin-bottom: 16px; padding-left: 20px; line-height: 1.6;"><li style="margin-bottom: 4px;">QA testing and bug fixes</li><li style="margin-bottom: 4px;">Beta user testing</li><li style="margin-bottom: 4px;">Gradual rollout</li></ul>',
            ],
            [
                'title' => 'Weekly Team Update',
                'content' => '<h1 style="font-size: 20pt; margin-bottom: 8px;">Weekly Team Update</h1><p style="color: #5f6368; margin-bottom: 24px;">Week of November 4, 2024 | Team: Engineering</p><h2 style="font-size: 16pt; margin-top: 20px; margin-bottom: 12px;">Completed This Week</h2><ul style="margin-bottom: 20px; padding-left: 20px; line-height: 1.6;"><li style="margin-bottom: 4px;">✅ Completed search functionality implementation</li><li style="margin-bottom: 4px;">✅ Fixed critical bug in document saving</li><li style="margin-bottom: 4px;">✅ Deployed new template system</li><li style="margin-bottom: 4px;">✅ Improved editor toolbar features</li></ul><h2 style="font-size: 16pt; margin-top: 20px; margin-bottom: 12px;">In Progress</h2><ul style="margin-bottom: 20px; padding-left: 20px; line-height: 1.6;"><li style="margin-bottom: 4px;">🔄 Mobile responsive design improvements</li><li style="margin-bottom: 4px;">🔄 Performance optimization</li><li style="margin-bottom: 4px;">🔄 User testing sessions</li></ul><h2 style="font-size: 16pt; margin-top: 20px; margin-bottom: 12px;">Next Week Goals</h2><ul style="margin-bottom: 20px; padding-left: 20px; line-height: 1.6;"><li style="margin-bottom: 4px;">Complete mobile design updates</li><li style="margin-bottom: 4px;">Begin work on sharing features</li><li style="margin-bottom: 4px;">Address feedback from user testing</li></ul>',
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

