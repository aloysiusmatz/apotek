<div class="flex flex-col w-64 h-screen px-3 py-4 bg-white border-r dark:bg-gray-800 dark:border-gray-600">

    <h2 class="text-3xl font-semibold text-gray-800 dark:text-white">APOTEK</h2>
    <p>version 1.0</p>

    
    <div class="flex flex-col justify-between flex-1 mt-6">
        <nav>
            <div class="text-gray-600 text-sm">Master Data</div>
            <div class="">
                <a class="{{ request()->is('items') ? "flex items-center px-2 py-1 text-gray-700 bg-gray-200 rounded-md dark:bg-gray-700 dark:text-gray-200" : "flex items-center px-2 py-1  text-gray-600 transition-colors duration-200 transform rounded-md dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700" }}"  href="{{route('items')}}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 11H5M19 11C20.1046 11 21 11.8954 21 13V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V13C3 11.8954 3.89543 11 5 11M19 11V9C19 7.89543 18.1046 7 17 7M5 11V9C5 7.89543 5.89543 7 7 7M7 7V5C7 3.89543 7.89543 3 9 3H15C16.1046 3 17 3.89543 17 5V7M7 7H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
    
                    <span class="mx-4 font-medium text-sm">Items</span>
                </a>

                <a class="{{ request()->is('categories') ? "flex items-center px-2 py-1 mt-1 text-gray-700 bg-gray-200 rounded-md dark:bg-gray-700 dark:text-gray-200" : "flex items-center px-2 py-1 mt-1 text-gray-600 transition-colors duration-200 transform rounded-md dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700" }}" href="{{route('categories')}}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
    
                    <span class="mx-4 font-medium text-sm">Categories</span>
                </a>

                <a class="{{ request()->is('locations') ? "flex items-center px-2 py-1 mt-1 text-gray-700 bg-gray-200 rounded-md dark:bg-gray-700 dark:text-gray-200" : "flex items-center px-2 py-1 mt-1 text-gray-600 transition-colors duration-200 transform rounded-md dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700" }}" href="{{route('locations')}}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
    
                    <span class="mx-4 font-medium text-sm">Locations</span>
                </a>

                <a class="{{ request()->is('vendors') ? "flex items-center px-2 py-1 mt-1 text-gray-700 bg-gray-200 rounded-md dark:bg-gray-700 dark:text-gray-200" : "flex items-center px-2 py-1 mt-1 text-gray-600 transition-colors duration-200 transform rounded-md dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700" }}" href="{{route('vendors')}}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
    
                    <span class="mx-4 font-medium text-sm">Vendors</span>
                </a>
            </div>
            

            
            <div class="text-gray-600 text-sm mt-3">Purchase Order</div>
                <div class="">
                <a class="{{ request()->is('purchaseorder') ? "flex items-center px-2 py-1 text-gray-700 bg-gray-200 rounded-md dark:bg-gray-700 dark:text-gray-200" : "flex items-center px-2 py-1 text-gray-600 transition-colors duration-200 transform rounded-md dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700" }}" href="{{route('purchaseorder')}}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
    
                    <span class="mx-4 font-medium text-sm">Create PO</span>
                </a>
                <a class="{{ request()->is('purchaseorder_list') ? "flex items-center px-2 py-1 mt-1 text-gray-700 bg-gray-200 rounded-md dark:bg-gray-700 dark:text-gray-200" : "flex items-center px-2 py-1 mt-1 text-gray-600 transition-colors duration-200 transform rounded-md dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700" }}" href="{{route('po_list')}}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
    
                    <span class="mx-4 font-medium text-sm">PO List</span>
                </a>
            </div>

            <div class="text-gray-600 text-sm mt-3">Sales Order</div>
                <div class="">
                <a class="{{ request()->is('salesorder') ? "flex items-center px-2 py-1 text-gray-700 bg-gray-200 rounded-md dark:bg-gray-700 dark:text-gray-200" : "flex items-center px-2 py-1 text-gray-600 transition-colors duration-200 transform rounded-md dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700" }}" href="{{route('purchaseorder')}}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
    
                    <span class="mx-4 font-medium text-sm">Create SO</span>
                </a>
                <a class="{{ request()->is('salesorder_list') ? "flex items-center px-2 py-1 mt-1 text-gray-700 bg-gray-200 rounded-md dark:bg-gray-700 dark:text-gray-200" : "flex items-center px-2 py-1 mt-1 text-gray-600 transition-colors duration-200 transform rounded-md dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700" }}" href="{{route('po_list')}}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
    
                    <span class="mx-4 font-medium text-sm">SO List</span>
                </a>
            </div>

            <div class="text-gray-600 text-sm mt-3">Other Transactions</div>
            <div class="">
                <a class="{{ request()->is('itemsmovement') ? "flex items-center px-2 py-1  text-gray-700 bg-gray-200 rounded-md dark:bg-gray-700 dark:text-gray-200" : "flex items-center px-2 py-1 text-gray-600 transition-colors duration-200 transform rounded-md dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700" }}" href="{{route('itemsmovement')}}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
    
                    <span class="mx-4 font-medium text-sm">Other Movement</span>
                </a>
    
            </div>
            
            <div class="text-gray-600 text-sm mt-3">Reports</div>
            <div class="">
                <a class="{{ request()->is('report/itemsmovement') ? "flex items-center px-2 py-1 text-gray-700 bg-gray-200 rounded-md dark:bg-gray-700 dark:text-gray-200" : "flex items-center px-2 py-1 text-gray-600 transition-colors duration-200 transform rounded-md dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700" }}" href="{{route('report.itemsmovement')}}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
    
                    <span class="mx-4 font-medium text-sm">Item Movements</span>
                </a>
                <a class="{{ request()->is('report/itemssummary') ? "flex items-center px-2 py-1 mt-1 text-gray-700 bg-gray-200 rounded-md dark:bg-gray-700 dark:text-gray-200" : "flex items-center px-2 py-1 mt-1 text-gray-600 transition-colors duration-200 transform rounded-md dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700" }}" href="{{route('report.itemssummary')}}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
    
                    <span class="mx-4 font-medium text-sm">Item Summary</span>
                </a>
            </div>

            <hr class="my-6 dark:border-gray-600" />

            
        </nav>
        
        <div>
            <div class="flex items-center px-4 -mx-2">
                <img class="object-cover mx-2 rounded-full h-9 w-9" src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="avatar">
                <h4 class="mx-2 font-medium text-gray-800 dark:text-gray-200 hover:underline">{{ Auth::user()->name }}</h4>
                
            </div>

            <div class="mt-3 mx-4">
                <span class="text-sm block">Company Code: {{ session('company_code') }}</span>
                @role('Developer')
                <a class="text-sm block" href="{{ route('developer') }}">Developer Menu</a>
                @endrole
                
                <a class="text-sm" href="{{ route('profile.show') }}">Manage Account</a>
            
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a class="text-sm" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        Log Out
                    </a>
                </form>

            </div>

        </div>
        

    </div>
</div>