
{{-- PAGES --}}
        
<div class="bg-gray-100 w-screen">
            
    {{-- NAVIGATION BAR --}}
    <div class="bg-white p-3 dark:border-gray-600 flex">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users
        </h2>

        @include("developer.users.users-nav")

    </div>
    {{-- END NAVIGATION BAR --}}

    {{-- CONTENT --}}
    <x-content>
        <div class='flex grid grid-cols-6'>
            <div class="w-full col-span-4 ">
                
                <div>
                    @livewire('users-table')
                </div>

                <div class="mt-2 flex">
                    <div class="">
                        @livewire('user-role-table')
                    </div>

                    <div class="ml-2">
                        @livewire('user-permission-table')
                    </div>
                </div>
                
            </div>

            <div class="col-span-2 ml-2">
    
                @if ($mysubmit=="updateData")
                <div>
                    <x-button-topcreate wire:click="changeToCreate">Create</x-button-topcreate>
                </div>
                @endif

                
                @if (session()->has('message'))
                    <div class="mb-2 alert alert-success bg-green-500 px-2 py-3 text-white rounded-md   ">
                        {{ session('message') }}
                    </div>
                @endif
                

                <x-form action="" mysubmit="{{ $mysubmit }}" bttype="submit" title="{{ $form_title }}" >
                    
                    <x-input myclass="" type="text" name="email" wireprop="wire:model.lazy=email">
                        Email
                    </x-input>
            
                    <x-input myclass="mt-1" type="text" name="name" wireprop="wire:model.lazy=name">
                        Name
                    </x-input>
                    
                    @if ($mysubmit=="createData")
                        <x-input myclass="mt-1" type="password" name="password" wireprop="wire:model.lazy=password">
                            Password
                        </x-input>
                    @endif
                
                    <x-checkbox-active wireprop="wire:model=active">Active</x-checkbox-active>
                </x-form>

                <div class="mt-2">
                    <x-form action="" mysubmit="{{ $mysubmit2 }}" bttype="submit" title="{{ $form_title2 }}" >
                        <div class="col-span-6">
                            <x-select wireprop="wire:model.defer=selection_role">
                                @foreach ($rolesdatas as $rolesdata )
                                    <option value="{{ $rolesdata->id }}">{{ $rolesdata->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                       
                    </x-form>
                </div>
                <div class="mt-2">
                    <x-form action="" mysubmit="{{ $mysubmit3 }}" bttype="submit" title="{{ $form_title3 }}" >
                        <div class="col-span-6">
                            <x-select wireprop="wire:model.defer=selection_permission">
                                @foreach ($permissiondatas as $permissiondata )
                                    <option value="{{ $permissiondata->id }}">{{ $permissiondata->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        
                    </x-form>
                </div>

            </div>
        
        </div>          
    </x-content>
    {{-- END CONTENT --}}

    
</div>


{{-- END PAGES --}}






