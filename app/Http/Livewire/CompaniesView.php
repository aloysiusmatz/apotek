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
    public $city;
    public $country;
    public $postal_code;
    public $currency;
    public $currency_symbol;
    public $default_tax;
    public $decimal_display;
    public $thousands_separator;
    public $decimal_separator;
    public $qty_decimal;
    public $active=1;
    public $form_title = 'Create Company';
    public $mysubmit = "createCompanies";
    public $companyid;

    protected $listeners = ['editCompaniesRow' => 'companiesEdit'];


    public function render()
    {
        $this->formatField();

        return view('livewire.companies-view');
    }

    public function initField(){
        $this->companyid = 0;
        $this->company_code = "";
        $this->company_desc = "";
        $this->address = "";
        $this->npwp = "";
        $this->phone = "";
        $this->altphone = "";
        $this->city = "";
        $this->country = "";
        $this->postal_code = "";
        $this->currency = "";
        $this->currency_symbol = "";
        $this->default_tax = "";
        $this->decimal_display = "";
        $this->thousands_separator = "";
        $this->decimal_separator = "";
        $this->qty_decimal = "";
        $this->active = "1";
    }

    public function formatField(){
        $this->company_code = strtoupper($this->company_code);
    }

    public function createCompanies(){
        $this->formatField();

        DB::beginTransaction();
        
        $companies = new companies;
        $companies->company_code = $this->company_code;
        $companies->company_desc = $this->company_desc;
        $companies->address = $this->address;
        $companies->npwp =  $this->npwp;
        $companies->phone = $this->phone;
        $companies->altphone = $this->altphone;
        $companies->city = $this->city;
        $companies->country = $this->country;
        $companies->postal_code = $this->postal_code;
        $companies->currency = $this->currency;
        $companies->currency_symbol = $this->currency_symbol;
        $companies->default_tax = $this->default_tax;
        $companies->decimal_display = $this->decimal_display;
        $companies->thousands_separator = $this->thousands_separator;
        $companies->decimal_separator = $this->decimal_separator;
        $companies->qty_decimal = $this->qty_decimal;
        $companies->save();

        $companies_active = new companies_active;
        $companies_active->id = $companies->id;
        $companies_active->company_code = $this->company_code;
        $companies_active->active = $this->active;
        
        $companies_active->save();

        DB::commit();

        $this->initField();

        $this->emit('companiesChanged');

        session()->flash('message', 'Data successfully created.');
    }

    public function updateCompanies(){
        $this->formatField();

        if ($this->companyid == 0) {
            session()->flash('message', 'Please select a data to update');
            return;
        }

        DB::beginTransaction();

        $companies = companies::find($this->companyid);
        $companies->company_code = $this->company_code;
        $companies->company_desc = $this->company_desc;
        $companies->address = $this->address;
        $companies->npwp = $this->npwp;
        $companies->phone = $this->phone;
        $companies->altphone = $this->altphone;
        $companies->city = $this->city;
        $companies->country = $this->country;
        $companies->postal_code = $this->postal_code;
        $companies->currency = $this->currency;
        $companies->currency_symbol = $this->currency_symbol;
        $companies->default_tax = $this->default_tax;
        $companies->decimal_display = $this->decimal_display;
        $companies->thousands_separator = $this->thousands_separator;
        $companies->decimal_separator = $this->decimal_separator;
        $companies->qty_decimal = $this->qty_decimal;
        $companies->save();

        $companies_active = companies_active::find($this->companyid);
        $companies_active->active = $this->active;

        $companies_active->save();

        DB::commit();
       
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
        $this->city = $edit_company->city;
        $this->country = $edit_company->country;
        $this->postal_code = $edit_company->postal_code;
        $this->currency = $edit_company->currency;
        $this->currency_symbol = $edit_company->currency_symbol;
        $this->default_tax = $edit_company->default_tax;
        $this->decimal_display = $edit_company->decimal_display;
        $this->thousands_separator = $edit_company->thousands_separator;
        $this->decimal_separator = $edit_company->decimal_separator;
        $this->qty_decimal = $edit_company->qty_decimal;

        $edit_company_active = companies_active::find($companyid);
        $this->active = $edit_company_active->active;
        
        $this->form_title = "Update Companies";
        $this->mysubmit = "updateCompanies";
        $this->companyid = $companyid;
     
        $this->formatField();
        $this->render();
    }

    public function changeToCreate(){
        
        $this->initField();

        $this->form_title = "Create Companies";
        $this->mysubmit = "createCompanies";
    }
}
