<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\company;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyupdateRequest;
use App\Models\job_application;
use App\Models\job_vacancie;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
 
class CompanyController extends Controller
{   public $industries ;
    public function __construct()
    {
        $this->industries = [
            'Technology',
            'Finance',
            'Healthcare',
            'Education',
            'Retail',
            'Manufacturing',
            'Transportation',
            'Energy',
            'Entertainment',
            'Hospitality',
        ];
    }
     public function index(Request $request)
    {
        $data=company::latest();
        if($request->input('arcive')=='true'){
            $data=$data->onlyTrashed();
        }
        $data=$data->paginate(10)->onEachSide(1);
        return view('company.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = $this->industries;
      return view('company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(CompanyRequest $request)
{
    $validatedData = $request->validated();

     $owner = User::create([
        'name' => $request->input('owner_name'),
        'email' => $request->input('owner_email'),
        'password' => Hash::make($request->input('owner_password')),
        'role' => 'company-owner',
    ]);

     if (!$owner) {
        return back()->withErrors(['owner_email' => 'Failed to create owner user.'])->withInput();
    }

      Company::create([
        'name'     => $request->input('name'),
        'industry' => $request->input('industry'),
        'website'  => $request->input('website'),
        'address'  => $request->input('address'),
        'ownerid'  => $owner->id,  
    ]);

     return redirect()->route('companies.index')->with('success', 'Company and Owner created successfully!');
}
     
     

    /**
     * Display the specified resource.
     */
    
       public function show(string $id = null): View
{
    if ($id) {
        $company = company::with([
            'owner',
            'jobVacancies',
            'jobApplications.user',
            'jobApplications.jobVacancie',
        ])->findOrFail($id);
    } else {
        $company = company::with([
            'owner',
            'jobVacancies',
            'jobApplications.user',
            'jobApplications.jobVacancie',
        ])->where('ownerid', auth()->user()->id)->firstOrFail();
    }

    return view('company.show', compact('company'));
}
     
    public function edit(string $id = null): View
{
    if ($id) {
        $company = company::findOrFail($id);
    } else {
        $company = company::where('ownerid', auth()->user()->id)->first();
    }

    $industries = $this->industries;
    
    return view('company.edit', compact('company', 'industries'));
}
    /**
     * Update the specified resource in storage.
     */
     public function update(CompanyupdateRequest $request, string $id = null): RedirectResponse
{
    $validated = $request->validated();

    if ($id) {
        $company = company::findOrFail($id);
    } else {
        $company = company::where('ownerid', auth()->user()->id)->first();
    }

    $company->update([
        'name'     => $validated['name'],
        'address'  => $validated['address'],
        'industry' => $validated['industry'],
        'website'  => $validated['website'],
    ]);

    // Update owner
    $ownerdata = ['name' => $validated['owner_name']];

    if (!empty($validated['owner_password'])) {
        $ownerdata['password'] = Hash::make($validated['owner_password']);
    }

    $company->owner()->update($ownerdata);

    if ($request->query('redirectToList') == 'false') {
        return redirect()->route('companies.show', $company->id)
                         ->with('success', 'Company updated successfully!');
    }

    if (auth()->user()->role == 'company-owner') {
        return redirect()->route('my-company.show')
                         ->with('success', 'Company updated successfully!');
    }

    return redirect()->route('companies.index')
                     ->with('success', 'Company updated successfully!');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = company::findOrFail($id);
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company archived successfully.');
    }
    public function restore(string $id)
    {
        $company = company::withTrashed()->findOrFail($id);
        $company->restore();
        return back()->with('success', 'Company restored successfully!');
    }
}
