<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\job_vacancie;
use App\Models\job_categorie;
use App\Models\company;
use App\Http\Requests\VacancyupdateRequest;
use App\Http\Requests\VacancyRequest;
use Illuminate\View\View;

class JobVacancyController extends Controller
{
    public function index(Request $request): View
    {
        $query = job_vacancie::latest();

        if (auth()->user()->role == 'company-owner') {
            $query->where('company_id', auth()->user()->companies->id);
        }

        if ($request->input('archive') == 'true') {
            $query->onlyTrashed();
        }

        $data = $query->paginate(10)->onEachSide(1);

        return view('job-vacancy.index', compact('data'));
    }

    public function create()
    {
        $companies = company::all();
        $categories = job_categorie::all();
        return view('job-vacancy.create', compact('companies', 'categories'));
    }

    public function store(VacancyRequest $request)
    {
        job_vacancie::create($request->validated());
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy created successfully.');
    }

    public function show(string $id)
    {
        // ✅ التعديل: إضافة eager loading للـ applications والـ user
        $job = job_vacancie::with('applications.user')->findOrFail($id);
        return view('job-vacancy.show', compact('job'));
    }

    public function edit(string $id)
    {
        $job = job_vacancie::findOrFail($id);
        $companies = company::all();
        $categories = job_categorie::all();
        return view('job-vacancy.edit', compact('job', 'companies', 'categories'));
    }

    public function update(VacancyupdateRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $job = job_vacancie::findOrFail($id);
        $job->update($validatedData);

        if ($request->query('redirectToList') == 'false') {
            return redirect()->route('job-vacancies.show', $id)
                ->with('success', 'Job vacancy updated successfully!');
        }

        return redirect()->route('job-vacancies.index')
            ->with('success', 'Job vacancy updated successfully.');
    }

    public function destroy(string $id)
    {
        $job = job_vacancie::findOrFail($id);
        $job->delete();
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy deleted successfully.');
    }

    public function restore(string $id)
    {
        $job = job_vacancie::onlyTrashed()->findOrFail($id);
        $job->restore();
        return redirect()->route('job-vacancies.index', ['archive' => 'true'])
            ->with('success', 'Job vacancy restored successfully!');
    }
}