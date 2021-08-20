<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Apotek</title>


    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="/css/mycss.css">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body class="px-5 py-5" onload="window.print()">
    <div class="w-full ">
        
        {{-- PO HEADER --}}
        <div>
            <div class="flex justify-between">
                <div>
                    <div class="font-bold text-xl">{{ $modal3_companies['company_desc'] }}</div>
                    <div class="text-xs">
                        <div class="mt-1">{{ $modal3_companies['address'] }}</div>
                        <div>{{ $modal3_companies['city'].', '.$modal3_companies['country'] }}</div>
                        <div>{{ $modal3_companies['phone'].', '.$modal3_companies['altphone'] }}</div>
                    </div>
                </div>
                <div>
                    <div class="font-bold text-4xl">PURCHASE ORDER</div>
                    <div class="flex justify-end text-xl">PO# {{ $modal3_datas[0]['po_show_id'] }}</div>
                </div>
            </div>
            <div class="mt-4 ">
                <div>
                    <div class="flex text-xs">
                        <div class="w-28">
                            Order Date
                        </div>
                        <div>
                            : {{ $modal3_datas[0]['created_at'] }}
                        </div>
                    </div>
                    <div class="flex text-xs">
                        <div class="w-28">
                            Delivery Date
                        </div>
                        <div>
                            : {{ $modal3_datas[0]['delivery_date'] }}
                        </div>
                    </div>
                </div>                            
            </div>
            <div class="flex justify-between mt-5">
                <div class="w-60">
                    <div class="bg-gray-200 flex justify-center font-bold text-xs">
                        Vendor
                    </div>
                    <div class="text-xs">
                        {{ $modal3_datas[0]['vendor_address'] }}
                    </div>
                    <div class="text-xs">
                        {{ $modal3_datas[0]['vendor_city'].', '.$modal3_datas[0]['vendor_country'] }}
                    </div>
                    <div class="text-xs">
                        {{ $modal3_datas[0]['vendor_phone1'].', '.$modal3_datas[0]['vendor_phone2'] }}
                    </div>
                </div>
                <div class="w-60">
                    <div class="bg-gray-200 flex justify-center font-bold text-xs">
                        Ship To
                    </div>
                    <div class="text-xs">
                        {{ $modal3_datas[0]['ship_to_address'].', '.$modal3_datas[0]['ship_to_postal_code'] }}
                    </div>
                    <div class="text-xs">
                        {{ $modal3_datas[0]['ship_to_city'].', '.$modal3_datas[0]['ship_to_country']  }}
                    </div>
                    <div class="text-xs">
                        {{ $modal3_datas[0]['ship_to_phone1'].', '.$modal3_datas[0]['ship_to_phone2']  }}
                    </div>
                </div>
            </div>
        </div>
        
        {{-- PO ITEM --}}
        <div class="mt-5">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="bg-gray-200 w-8 text-left text-xs">NO</th>
                        <th class="bg-gray-200 text-left text-xs">ITEM NAME</th>
                        <th class="bg-gray-200 w-16 text-left text-xs">QTY</th>                        
                        <th class="bg-gray-200 w-28 text-left text-xs">PRICE/UNIT</th>
                        <th class="bg-gray-200 w-14 text-left text-xs">DISC</th>
                        <th class="bg-gray-200 w-14 text-left text-xs">TAX</th>
                        <th class="bg-gray-200 w-28 text-right">
                            <div class="text-xs">
                                <div>
                                    <span>SUBTOTAL</span>
                                </div>
                                <div>
                                    <span>(Tax not included)</span>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $taxtotal=0;
                        $subtotal=0;
                        $grandtotal=0;
                    @endphp
                    @foreach ($modal3_datas as $data)
                        @php
                            $total = ($data['qty']*$data['price_unit'])*((100-$data['discount'])/100);
                            $subtotal += $total;
                            $taxtotal += ($data['qty']*$data['price_unit'])*((100-$data['discount'])/100)*($data['tax']/100);
                        @endphp
                        <tr class="border-t">
                            <td class="text-xs">{{ $data['item_sequence'] }}</td>
                            <td class="pr-2 text-xs">{{ $data['item_name'] }}</td>
                            <td class="text-xs">{{ number_format($data['qty'] ,session()->get('qty_decimal'),session()->get('decimal_separator'),session()->get('thousands_separator')).' '.$data['item_unit'] }}</td>
                            <td class="text-xs">{{ session()->get('currency_symbol').' '.number_format($data['price_unit'] ,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator')) }}</td>
                            <td class="text-xs">{{ $data['discount']>0 ? $data['discount'].' %' : '-' }}</td>
                            <td class="text-xs">{{ $data['tax']>0 ? $data['tax'].' %' : '-' }}</td>
                            <td class="text-right text-xs">
                                <div class="flex justify-between">
                                    <div>
                                        {{ session()->get('currency_symbol') }}
                                    </div>
                                    <div>
                                        {{ number_format($total ,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator'))}}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    
                    
                </tbody>
            </table>
        </div>
        {{-- PO FOOTER --}}
        <div>
            <div class="flex justify-between mt-5">
                <div>
                    <div class="font-bold">Note :</div>
                    <div class="mr-20 text-xs">{{ $modal3_datas[0]['note'] }}</div>
                </div>
                <div>
                    <div class="flex">
                        <div class="w-32">SUBTOTAL</div>
                        <div>: {{ session()->get('currency_symbol') }}</div>
                        <div class="text-right w-40">{{ number_format($subtotal ,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator'))}}</div>
                    </div>
                    <div class="flex">
                        <div class="w-32">TAX</div>
                        <div>: {{ session()->get('currency_symbol') }}</div>
                        <div class="text-right w-40">{{number_format($taxtotal ,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator'))}}</div>
                    </div>
                    <div class="flex">
                        <div class="w-32">SHIPPING</div>
                        <div>: {{ session()->get('currency_symbol') }}</div>
                        <div class="text-right w-40">{{ number_format($modal3_datas[0]['shipping_value'] ,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator'))}}</div>
                    </div>
                    <div class="flex">
                        <div class="w-32">OTHERS</div>
                        <div>: {{ session()->get('currency_symbol') }}</div>
                        <div class="text-right w-40">{{ number_format($modal3_datas[0]['others_value'] ,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator'))}}</div>
                    </div>
                    <hr>
                    <hr>
                    <hr>
                    <div class="flex">
                        <div class="w-32 font-bold">GRAND TOTAL</div>
                        <div class="font-bold">: {{ session()->get('currency_symbol') }}</div>
                        @php
                            $grandtotal = $subtotal + $taxtotal + $modal3_datas[0]['shipping_value'] + $modal3_datas[0]['others_value'];
                        @endphp
                        <div class="text-right font-bold w-40">{{number_format($grandtotal ,session()->get('decimal_display'),session()->get('decimal_separator'),session()->get('thousands_separator'))}}</div>
                    </div>
                </div>
            </div>
        </div> 
                        
    </div>
</body>

</html>