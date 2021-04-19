<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\companies;

class CompaniesView extends Component
{
    
    public $companies;
    public $company_code;
    public $company_desc;
    public $address;
    public $npwp;
    public $phone;
    public $altphone;
    public $form_title = 'Create Company';
    public $mysubmit = "createCompanies";
    public $companyid;

    protected $listeners = ['editCompaniesRow' => 'companiesEdit'];


    public function render()
    {
        // $testrender = $this->testrender;
        return view('livewire.companies-view');
    }

    public function initField(){
        $this->company_code = "";
        $this->company_desc = "";
        $this->address = "";
        $this->npwp = "";
        $this->phone = "";
        $this->altphone = "";
    }

    public function createCompanies(){
       
        $companies = new companies;
        $companies->company_code = $this->company_code;
        $companies->company_desc = $this->company_desc;
        $companies->address = $this->address;
        $companies->npwp =  $this->npwp;
        $companies->phone = $this->phone;
        $companies->altphone = $this->altphone;
        $companies->save();

        $this->initField();

        $this->emit('companiesChanged');

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

        $this->initField();

        $this->emit('companiesChanged');
    }

    public function companiesEdit($companyid){
        $editCompany = companies::find($companyid);
        $this->company_code = $editCompany->company_code;
        $this->company_desc = $editCompany->company_desc;
        $this->address = $editCompany->address;
        $this->npwp = $editCompany->npwp;
        $this->phone = $editCompany->phone;
        $this->altphone = $editCompany->altphone;
        
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
