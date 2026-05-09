<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\job_categorie;
use App\Models\company;
use App\Models\job_vacancie;
use App\Models\job_application;
use App\Models\resume;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('12345678'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $jobdata = json_decode(
            file_get_contents(database_path('data/job_data.json')),
            true
        );

        $jobapplications = json_decode(
            file_get_contents(database_path('data/job_applications.json')),
            true
        )['jobApplications'];

        foreach ($jobdata['jobCategories'] as $category) {
            job_categorie::firstOrCreate([
                'name' => $category,
            ]);
        }

        foreach ($jobdata['companies'] as $company) {
            $owner = User::firstOrCreate(
                ['email' => fake()->unique()->safeEmail()],
                [
                    'name' => fake()->name(),
                    'password' => bcrypt('12345678'),
                    'role' => 'company-owner',
                    'email_verified_at' => now(),
                ]
            );

            company::firstOrCreate(
                ['name' => $company['name']],
                [
                    'address' => $company['address'],
                    'website' => $company['website'],
                    'industry' => $company['industry'],
                    'ownerid' => $owner->id,
                ]
            );
        }

        foreach ($jobdata['jobVacancies'] as $jobvacancy) {
            job_vacancie::firstOrCreate(
                [
                    'title' => $jobvacancy['title'],
                    'company_id' => company::where('name', $jobvacancy['company'])->firstOrFail()->id,
                ],
                [
                    'description' => $jobvacancy['description'],
                    'location' => $jobvacancy['location'],
                    'salary' => $jobvacancy['salary'],
                    'type' => $jobvacancy['type'],
                    'category_id' => job_categorie::where('name', $jobvacancy['category'])->firstOrFail()->id,
                ]
            );
        }

        // ================= JOB APPLICATIONS =================
        foreach ($jobapplications as $application) {

            $jobvacancy = job_vacancie::inRandomOrder()->first();

            $applicant = User::firstOrCreate(
                ['email' => fake()->unique()->safeEmail()],
                [
                    'name' => fake()->name(),
                    'password' => bcrypt('12345678'),
                    'role' => 'job-seeker',
                    'email_verified_at' => now(),
                ]
            );

            $resume = resume::create([
                'user_id'    => $applicant->id,
                'file_name'  => $application['resume']['filename'],
                'file_url'   => $application['resume']['fileUri'],
                'skills'     => $application['resume']['skills'],
                'summary'    => $application['resume']['summary'],
                'experience' => $application['resume']['experience'],
                'education'  => $application['resume']['education'],
                'content'    => $application['resume']['contactDetails'],
            ]);

            job_application::create([
                'job_vacancy_id'        => $jobvacancy->id,
                'user_id'               => $applicant->id,
                'resume_id'             => $resume->id,
                'ai_generated_feedback' => $application['aiGeneratedFeedback'], // ✅
                'ai_generated_score'    => $application['aiGeneratedScore'],    // ✅
                'status'                => $application['status'],
            ]);
        }
    }
}