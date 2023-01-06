<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use Auth;

class CompanyProfileController extends Controller
{
  public function edit($id)
  {
    $company = Company::findOrFail($id);
      // $this->authorize('modify', $contact);
    return view("company_profile.edit", compact('company'));
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
}
