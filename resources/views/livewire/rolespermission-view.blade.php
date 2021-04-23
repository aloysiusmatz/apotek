
{{-- PAGES --}}
        
<div class="bg-gray-100  w-screen">
            
    {{-- NAVIGATION BAR --}}
    <div class="bg-white p-3 dark:border-gray-600 flex">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Roles & Permissions
        </h2>

        @include("developer.rolespermission.rolespermission-nav")

    </div>
    {{-- END NAVIGATION BAR --}}

    {{-- CONTENT --}}
    <x-content>
        <div class='flex grid grid-cols-12'>
            <div class="w-full col-span-9">
                <div class="flex">
                    <div class="">
                        @livewire('role-table')
                    </div>
                    <div class="ml-2">
                        @livewire('permission-table')
                    </div>
                </div>

                <div class="mt-3 flex">
                    <div>
                        @livewire('rolehaspermissions-table')
                    </div>
                    
                </div>
            </div>

            <div class="col-span-3 ml-2">
                
                {{-- ROLES --}}
                <div>
                    @if ($mysubmit1=="updateData1")
                    <div>
                        <x-button-topcreate wire:click="changeToCreate1">Create Role</x-button-topcreate>
                    </div>
                    @endif

                    
                    @if (session()->has('message'))
                        <div class="mb-2 alert alert-success bg-green-500 px-2 py-3 text-white rounded-md">
                            {{ session('message') }}
                        </div>
                    @endif
                    

                    <x-form action="" mysubmit="{{ $mysubmit1 }}" bttype="submit" title="{{ $form_title1 }}" >
                        
                        <x-input myclass="" type="text" name="name" wireprop="wire:model.lazy=rolename">
                            Role Name
                        </x-input>
                    
                    </x-form>

                </div>
                {{-- END ROLES --}}

                {{-- PERMISSIONS --}}
                <div class="mt-2">
                    @if ($mysubmit2=="updateData2")
                    <div>
                        <x-button-topcreate wire:click="changeToCreate2">Create Permission</x-button-topcreate>
                    </div>
                    @endif

                    <x-form action="" mysubmit="{{ $mysubmit2 }}" bttype="submit" title="{{ $form_title2 }}" >
                        
                        <x-input myclass="" type="text" name="name" wireprop="wire:model.lazy=permissionname">
                            Permission Name
                        </x-input>
                                            
                    </x-form>

                </div>
                {{-- END PERMISSIONS --}}

                {{-- ASSIGN PERMISSION TO ROLE --}}
                <div class="mt-2">
                    
                    <x-form action="" mysubmit="{{ $mysubmit3 }}" bttype="submit" title="{{ $form_title3 }}" >
                        
                        <div class="col-span-6 ">
                            <x-select wireprop="wire:model.defer=selection_permission">
                                @foreach ($permissiondatas as $permissiondata )
                                    <option value="{{ $permissiondata->id }}">{{ $permissiondata->name }}</option>
                                @endforeach
                            </x-select>
                       
                            <div class="col-span-6 flex justify-center">
                                <div class="mt-1 w-5 text-sm">
                                    To
                                </div>
                            </div>
                            
                            <x-select wireprop="wire:model.defer=selection_role">
                                @foreach ($rolesdatas as $rolesdata )
                                    <option value="{{ $rolesdata->id }}">{{ $rolesdata->name }}</option>
                                @endforeach
                            </x-select>
                           
                        </div>
                        
                        
                    </x-form>
                </div>
                {{-- END ASSIGN PERMISSION TO ROLE --}}
                
            </div>
        
        </div>          
    </x-content>
    {{-- END CONTENT --}}

    
</div>


{{-- END PAGES --}}






