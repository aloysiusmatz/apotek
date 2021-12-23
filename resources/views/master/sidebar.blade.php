<div class="sidebar-normal bg-white fixed left-0 z-20 border-r transititon duration-200">
    {{-- LOGO --}}
    <div class="sidebar-menu-header px-3 py-3 ">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-semibold text-gray-700 dark:text-white">APOTEK</h2>
            </div>
            
            <div>
                <svg class="hide-menu-button w-7 h-7 cursor-pointer text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
            </div>
        </div>
        
        <p>version 1.0</p>
    </div>

    {{-- MENU CONTENT --}}
    <div class="sidebar-menu-content overflow-scroll px-2">
        <div class="">
        
            {{-- DASHBOARD --}}
            <a class="" href="{{route('dashboard')}}">
                <div class="{{ request()->is('dashboard') ? "flex text-gray-600 text-sm cursor-pointer rounded-md px-2 py-2 bg-gray-200 hover:text-gray-900 hover:font-extrabold transition duration-200" : "flex text-gray-600 text-sm cursor-pointer rounded-md px-2 py-2 hover:bg-gray-200 hover:text-gray-900 hover:font-extrabold transition duration-200" }}">
                    
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                              </svg>
                        </div>
                        <div class="px-3">
                            Dashboard
                        </div>

                </div>
            </a>

            {{-- MASTER DATA --}}
            <div class="px-2 py-2">
                <div class="menu-group flex justify-between text-gray-600 text-sm cursor-pointer flex hover:text-gray-900 hover:font-extrabold transition duration-200">
                    <div class="flex">
                        <div>
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 20 20" fill="currentColor">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                            </svg>
                        </div>
                        <div class="px-2">
                            Master Data
                        </div>
                        
                    </div>
                    
                    <div class="items-center ">
                        <svg class="arrow-menu w-5 h-5 transform transition durantion-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                    </div>
                    
                </div>
                <div class="menu-detail bg-gray-100 rounded-md transition-all hidden">
                    <a class="{{ request()->is('items') ? "flex items-center px-2 py-1 text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-200 rounded-t-md hover:font-extrabold" : "flex items-center px-2 py-1 text-gray-600 transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700 rounded-t-md hover:font-extrabold" }}"  href="{{route('items')}}">
                        
                        <span class="mx-4 text-sm">Items</span>
                    </a>
    
                    <a class="{{ request()->is('categories') ? "flex items-center px-2 py-1 text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-200 hover:font-extrabold" : "flex items-center px-2 py-1 text-gray-600 transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700 hover:font-extrabold" }}" href="{{route('categories')}}">
                    
                        <span class="mx-4 text-sm">Categories</span>
                    </a>
                    
                    <a class="{{ request()->is('locations') ? "flex items-center px-2 py-1 text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-200 hover:font-extrabold" : "flex items-center px-2 py-1 text-gray-600 transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700 hover:font-extrabold" }}" href="{{route('locations')}}">
        
                        <span class="mx-4 text-sm">Locations</span>
                    </a>
    
                    <a class="{{ request()->is('vendors') ? "flex items-center px-2 py-1 text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-200 rounded-b-md hover:font-extrabold" : "flex items-center px-2 py-1 text-gray-600 transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700 rounded-b-md hover:font-extrabold" }}" href="{{route('vendors')}}">
        
                        <span class="mx-4 text-sm">Vendors</span>
                    </a>
                </div>
            </div>
            
            {{-- PURCHASE ORDER --}}
            <div class="px-2 py-2">
                <div class="menu-group flex justify-between text-gray-600 text-sm cursor-pointer flex hover:text-gray-900 hover:font-extrabold transition duration-200">
                    <div class="flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                </svg>
                        </div>
                        <div class="px-2">
                            Purchase Order
                        </div>
                        
                    </div>
                    
                    <div class="items-center ">
                        <svg class="arrow-menu w-5 h-5 transform transition durantion-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                    </div>
                    
                </div>
                <div class="menu-detail bg-gray-100 rounded-md transition-all hidden">
                    <a class="{{ request()->is('purchaseorder') ? "flex items-center px-2 py-1 text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-200 rounded-t-md hover:font-extrabold" : "flex items-center px-2 py-1 text-gray-600 transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700 rounded-t-md hover:font-extrabold" }}"  href="{{route('purchaseorder')}}">
                        
                        <span class="mx-4 text-sm">Create Order</span>
                    </a>
    
                    <a class="{{ request()->is('purchaseorder_list') ? "flex items-center px-2 py-1 text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-200 rounded-b-md hover:font-extrabold" : "flex items-center px-2 py-1 text-gray-600 transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700 rounded-b-md hover:font-extrabold" }}" href="{{route('po_list')}}">
                    
                        <span class="mx-4 text-sm">PO List</span>
                    </a>
                    
                </div>
            </div>
            
            {{-- SALES ORDER --}}
            <div class="px-2 py-2">
                <div class="menu-group flex justify-between text-gray-600 text-sm cursor-pointer flex hover:text-gray-900 hover:font-extrabold transition duration-200">
                    <div class="flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                                </svg>
                        </div>
                        <div class="px-2">
                            Sales Order
                        </div>
                        
                    </div>
                    
                    <div class="items-center ">
                        <svg class="arrow-menu w-5 h-5 transform transition durantion-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                    </div>
                    
                </div>
                <div class="menu-detail bg-gray-100 rounded-md transition-all hidden">
                    <a class="{{ request()->is('salesorder') ? "flex items-center px-2 py-1 text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-200 rounded-t-md hover:font-extrabold" : "flex items-center px-2 py-1 text-gray-600 transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700 rounded-t-md hover:font-extrabold" }}"  href="{{route('salesorder')}}">
                        
                        <span class="mx-4 text-sm">Create Order</span>
                    </a>
    
                    <a class="{{ request()->is('salesorder_list') ? "flex items-center px-2 py-1 text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-200 rounded-b-md hover:font-extrabold" : "flex items-center px-2 py-1 text-gray-600 transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700 rounded-b-md hover:font-extrabold" }}" href="{{route('so_list')}}">
                    
                        <span class="mx-4 text-sm">SO List</span>
                    </a>
                    
                </div>
            </div>

            {{-- OTHER MOVEMENT --}}
            <a class="" href="{{route('itemsmovement')}}">
                <div class="{{ request()->is('itemsmovement') ? "flex text-gray-600 text-sm cursor-pointer rounded-md px-2 py-2 bg-gray-200 hover:text-gray-900 hover:font-extrabold transition duration-200" : "flex text-gray-600 text-sm cursor-pointer rounded-md px-2 py-2 hover:bg-gray-200 hover:text-gray-900 hover:font-extrabold transition duration-200" }}">
                    
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z" />
                                </svg>
                        </div>
                        <div class="px-2">
                            Other Movement
                        </div>

                </div>
            </a>
                
            {{-- REPORTS --}}
            <div class="px-2 py-2">
                <div class="menu-group flex justify-between text-gray-600 text-sm cursor-pointer flex hover:text-gray-900 hover:font-extrabold transition duration-200">
                    <div class="flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                                </svg>
                        </div>
                        <div class="px-2">
                            Reports
                        </div>
                        
                    </div>
                    
                    <div class="items-center ">
                        <svg class="arrow-menu w-5 h-5 transform transition durantion-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                    </div>
                    
                </div>
                <div class="menu-detail bg-gray-100 rounded-md transition-all hidden">
                    <a class="{{ request()->is('report/itemsmovement') ? "flex items-center px-2 py-1 text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-200 rounded-t-md hover:font-extrabold" : "flex items-center px-2 py-1 text-gray-600 transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700 rounded-t-md hover:font-extrabold" }}"  href="{{route('report.itemsmovement')}}">
                        
                        <span class="mx-4 text-sm">Item Movement</span>
                    </a>
    
                    <a class="{{ request()->is('eport/itemssummary') ? "flex items-center px-2 py-1 text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-200 hover:font-extrabold" : "flex items-center px-2 py-1 text-gray-600 transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700 hover:font-extrabold" }}" href="{{route('report.itemssummary')}}">
                    
                        <span class="mx-4 text-sm">Item Summary</span>
                    </a>
                    
                </div>
            </div>
            
        </div>
    </div>

    {{-- BOTTOM --}}
    <div class="sidebar-menu-profile fixed bottom-0 px-2 py-2 bg-white border-r">
        <div class="bg-gray-200 p-2 rounded-lg shadow-md border border-gray-300">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <img class="object-cover rounded-lg h-9 w-9 shadow-md border border-4 border-gray-500" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}
                    " alt="avatar">
                    <h4 class="mx-2 font-medium text-gray-700 dark:text-gray-200 hover:underline">
                        {{ Auth::user()->name }}
                    </h4>
                </div>
                
                <div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="text-sm block" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                              </svg>
                        </a>
                    </form>
                    
                </div>
                
            </div>

            <div class="mt-2 space-y-1">
                <span class="text-sm block">Company Code: {{ session('company_code') }}</span>

                @role('Developer')
                <a class="text-sm block" href="{{ route('developer') }}">Developer Menu</a>
                @endrole
                
                <a class="text-sm block" href="{{ route('profile.show') }}">Manage Account</a>
            
            </div>

        </div>
    </div>
</div>

