<table>
    <thead>
        <tr>                                
            <th>Item Number</th>
            <th>Name</th>
            <th>Total Qty</th>
            <th>Unit</th>
            <th>Total COGS</th>
            <th>COGS/Qty</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $result )
        <tr>
            <td>
                {{ $result['show_id'] }}
            </td>
            <td>
                {{ $result['name'] }}
            </td>
            <td>
                @php
                    if($result['total_qty']==''){
                        $result['total_qty'] = 0;
                    }
                @endphp
                {{ $result['total_qty'] }}
            </td>
            <td>
                {{ $result['unit'] }}
            </td>
            <td>
                @php
                    if($result['total_amount']==''){
                        $result['total_amount'] = 0;
                    }
                @endphp
                {{ $result['total_amount'] }}
            </td>
            <td>
                {{ $result['cogs_unit'] }}
            </td>                                 
        </tr>
        @endforeach
        
    </tbody>
</table>