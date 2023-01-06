<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use Auth;

class CompanyController extends Controller
{
    public function index(Request $request){
      $companies = Company::all();
      return view('company.index', compact('companies'));
    }

    public function edit($id)
    {
    	$company = Company::findOrFail($id);
        // $this->authorize('modify', $contact);
    	return view("company.edit", compact('company'));
    }

    public function update ($id, Request $request)
    {
    	// $this->validate($request, $this-> rules);
    	$company = Company::findOrFail($id);
    	$data = $request->all();
      $company->update($data);

      $company->rights()->sync($request->rights);
    	return redirect('company')->with('message', 'Company Updated!');
    }

    public function change_company(Request $request){
      $data = $request->all();
      // $company = User::findOrFail(Aut);
      // Auth::user->update()

      Auth::user()->update([
            'company_id' => $data['company_id'],
        ]);

      return 1;
    }

    public function store (Request $request)
    {
      // return 1;
      $data = $request->all();
      // return $data['email'];
    	// $this->validate($request, $this-> rules);
      $company = Company::create([
        'name' => $data['name'],
        'email' => $data['email'],
      ]);
    	return $company;
    }
}
