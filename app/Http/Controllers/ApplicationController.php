<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\job_vacancie;
use App\Models\job_application;
use App\Models\company;
use App\Http\Requests\UpdateApplicationRequest;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request): View
{
    $query = job_application::with(['user', 'jobVacancie.company'])->latest();

     if (auth()->user()->role == 'company-owner') {
        $query->whereHas('jobVacancie', function ($q) {
            $q->where('company_id', auth()->user()->companies->id);
        });
    }

    // Archived
    if ($request->input('archive') == 'true') {
        $query->onlyTrashed();
    }

    $data = $query->paginate(10)->onEachSide(1);

    return view('application.index', compact('data'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $application = job_application::with(['user', 'jobVacancie.company'])->findOrFail($id);
        return view('application.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
     public function edit($id)
{
    $application = job_application::with(['user', 'jobVacancie.company'])->findOrFail($id);
    return view('application.edit', compact('application'));
}

  public function update(UpdateApplicationRequest $request, $id)
{
    $application = job_application::findOrFail($id);
    $application->update(['status' => $request->status]);

    if ($request->redirect_to === 'index') {
        return redirect()->route('applications.index')
                         ->with('success', 'Status updated successfully.');
    }

    return redirect()->route('applications.show', $application->id)
                     ->with('success', 'Status updated successfully.');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $application = job_application::findOrFail($id);
    $application->delete(); // SoftDelete

    return redirect()->route('applications.index')
                     ->with('success', 'Application archived successfully.');
}

public function restore($id)
{
    $application = job_application::onlyTrashed()->findOrFail($id);
    $application->restore();

    return redirect()->route('applications.index', ['archive' => 'true'])
                     ->with('success', 'Application restored successfully.');
}

}
