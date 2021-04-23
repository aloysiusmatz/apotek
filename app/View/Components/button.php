<?php

namespace App\View\Components;

use Illuminate\View\Component;

class button extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $myclass;
     public $title;
    

    public function __construct($type)
    {
        
        $myclass = "px-3 py-2 rounded-md text-white font-semibold text-xs font-bold";
        
        if ($type == "create"){
            $title = "Create";
            $myclass = $myclass." bg-green-600 hover:bg-green-500";
        }
        elseif ($type == "save"){
            $title = "Save";
            $myclass = $myclass. " bg-yellow-600 hover:bg-yellow-500";
        }
        elseif ($type == "delete"){
            $title = "Delete";
            $myclass = $myclass. " bg-red-600 hover:bg-red-500";
        }
        elseif ($type == "submit"){
            $title = "Submit";
            $myclass = $myclass. " bg-green-600 hover:bg-green-500";
        }

        
        $this->myclass = $myclass;
        $this->title = $title;

        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
