<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\job_vacancie; 
use App\Models\job_application;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        if (auth()->user()->role == 'admin') {
            $analytics = $this->adminDashboard();
        } else {
            $analytics = $this->companyOwnerDashboard();
        }

        return view('dashboard.index', compact('analytics'));
    }

    private function adminDashboard(): array
    {
        return [
            'activeUsers'       => User::where('last_login_at', '>=', now()->subDays(30))->count(),
            'totalJobs'         => job_vacancie::whereNull('deleted_at')->count(),
            'totalApplications' => job_application::whereNull('deleted_at')->count(),
             'mostAppliedJobs'   => job_vacancie::withCount('applications as Totalcount')
                                    ->orderByDesc('Totalcount')
                                    ->limit(5)
                                    ->get(),
            'topConvertingJobs' => collect([]), 
        ];
    }

    private function companyOwnerDashboard(): array
    {
         $companyId = auth()->user()->companies->id;

        $activeUsers = job_application::whereNull('deleted_at')
            ->whereHas('jobVacancie', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
            ->whereHas('user', function ($q) {
                $q->where('last_login_at', '>=', now()->subDays(30));
            })
            ->distinct('user_id')
            ->count('user_id');

        $totalJobs = job_vacancie::whereNull('deleted_at')
            ->where('company_id', $companyId)
            ->count();

        $totalApplications = job_application::whereNull('deleted_at')
            ->whereHas('jobVacancie', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
            ->count();

         $mostAppliedJobs = job_vacancie::withCount('applications as Totalcount')
            ->whereNull('deleted_at')
            ->where('company_id', $companyId)
            ->orderByDesc('Totalcount')
            ->limit(5)
            ->get();

         $topConvertingJobs = job_vacancie::withCount('applications as Totalcount')
            ->whereNull('deleted_at')
            ->where('company_id', $companyId)
            ->having('Totalcount', '>', 0)
            ->orderByDesc('Totalcount')
            ->limit(5)
            ->get()
            ->map(function ($job) {
                $job->conversion_rate = $job->view_count > 0
                    ? round(($job->Totalcount / $job->view_count) * 100, 2)
                    : 0;
                return $job;
            });

        return [
            'activeUsers'       => $activeUsers,
            'totalJobs'         => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs'   => $mostAppliedJobs,
            'topConvertingJobs' => $topConvertingJobs,
        ];
    }
}