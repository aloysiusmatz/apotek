
<table class="w-full table-auto mt-1">
    <thead>
        <tr class="text-gray-600 uppercase text-xs leading-normal">
            <th class="sticky top-0 bg-gray-200 border border-gray-400 px-1 py-2 text-left cursor-pointer w-28" >Posting Date</th>
            <th class="sticky top-0 bg-gray-200 border border-gray-400 px-1 py-2 text-left cursor-pointer w-28" >Item Number</th>
            <th class="sticky top-0 bg-gray-200 border border-gray-400 px-1 py-2 text-left cursor-pointer">Name</th>
            <th class="sticky top-0 bg-gray-200 border border-gray-400 px-1 py-2 text-left cursor-pointer w-28" >Movement Key</th>
            <th class="sticky top-0 bg-gray-200 border border-gray-400 px-1 py-2 text-left cursor-pointer w-24" >Qty</th>
            <th class="sticky top-0 bg-gray-200 border border-gray-400 px-1 py-2 text-left cursor-pointer w-28" >Loc</th>
            <th class="sticky top-0 bg-gray-200 border border-gray-400 px-1 py-2 text-left cursor-pointer w-28" >Batch</th>
            <th class="sticky top-0 bg-gray-200 border border-gray-400 px-1 py-2 text-left cursor-pointer w-28" >Create Date</th>
        </tr>
    </thead>
    <tbody class="text-gray-600 text-sm font-light">
        
        @foreach ($results as $result)
        
        <tr class="">
        
            <td class="border border-gray-300 px-1">
                {{ $result['posting_date'] }}
            </td>
            <td class="border border-gray-300 px-1">
                {{ $result['show_id'] }}
            </td>
            <td class="border border-gray-300 px-1">
                {{ $result['item_name'] }}
            </td>
            <td class="border border-gray-300 px-1">
                {{ $result['movement_key'] }}
            </td>
            <td class="text-right border border-gray-300 px-1">
                {{ number_format($result['qty'],0,',','.')}}
            </td>
            <td class="border border-gray-300 px-1">
                {{ $result['loc'] }}
            </td>
            <td class="border border-gray-300 px-1">
                {{ $result['batch'] }}
            </td>
            <td class="border border-gray-300 px-1">
                {{ $result['created_at'] }}
            </td>
        </tr>
        
        @endforeach
        
    </tbody>
</table>
