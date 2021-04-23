<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\companies;
use App\Models\companies_active;

class CompaniesView extends Component
{
    
    public $companies;
    public $company_code;
    public $company_desc;
    public $address;
    public $npwp;
    public $phone;
    public $altphone;
    public $active=1;
    public $form_title = 'Create Company';
    public $mysubmit = "createCompanies";
    public $companyid;

    protected $listeners = ['editCompaniesRow' => 'companiesEdit'];


    public function render()
    {

        $this->company_code = strtoupper($this->company_code);

        return view('livewire.companies-view');
    }

    public function initField(){
        $this->company_code = "";
        $this->company_desc = "";
        $this->address = "";
        $this->npwp = "";
        $this->phone = "";
        $this->altphone = "";
        $this->active = "1";
    }

    public function createCompanies(){
        
        $this->company_code = strtoupper($this->company_code);
        
        $companies = new companies;
        $companies->company_code = $this->company_code;
        $companies->company_desc = $this->company_desc;
        $companies->address = $this->address;
        $companies->npwp =  $this->npwp;
        $companies->phone = $this->phone;
        $companies->altphone = $this->altphone;
        $companies->save();

        $companies_active = new companies_active;
        $companies_active->id = $companies->id;
        $companies_active->company_code = $this->company_code;
        $companies_active->active = $this->active;
        
        $companies_active->save();

        $this->initField();

        $this->emit('companiesChanged');

        session()->flash('message', 'Data successfully created.');
    }

    public function updateCompanies(){
        $companies = companies::find($this->companyid);
        $companies->company_code = $this->company_code;
        $companies->company_desc = $this->company_desc;
        $companies->address = $this->address;
        $companies->npwp = $this->npwp;
        $companies->phone = $this->phone;
        $companies->altphone = $this->altphone;
        $companies->save();

        $companies_active = companies_active::find($this->companyid);
        $companies_active->active = $this->active;

        $companies_active->save();
       
        $this->initField();

        $this->emit('companiesChanged');

        session()->flash('message', 'Data successfully updated.');
    }

    public function companiesEdit($companyid){
        $edit_company = companies::find($companyid);
        $this->company_code = $edit_company->company_code;
        $this->company_desc = $edit_company->company_desc;
        $this->address = $edit_company->address;
        $this->npwp = $edit_company->npwp;
        $this->phone = $edit_company->phone;
        $this->altphone = $edit_company->altphone;

        $edit_company_active = companies_active::find($companyid);
        $this->active = $edit_company_active->active;
        
        $this->form_title = "Update Companies";
        $this->mysubmit = "updateCompanies";
        $this->companyid = $companyid;
     
        $this->render();
    }

    public function changeToCreate(){
        
        $this->initField();

        $this->form_title = "Create Companies";
        $this->mysubmit = "createCompanies";
    }
}
