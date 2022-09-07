<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <title>Document</title>
    <style>
        *{
            box-sizing: border-box;
        }
    </style>
</head>
<body style="width:302px;">
    <div id="receipt" style="width:100%;border: 1px solid gray;padding: 12px;">
        <div style="border-bottom: 2px dashed rgb(24, 10, 10);padding-bottom: 8px;padding-top:6px; width:100%;text-align:center">
            <span style="font-family: 'Mali', cursive;width:100%;text-align:center">RECEIPT</span>
        </div>
        <div class="mt-4">
            <div style="border-bottom: 1px dashed gray;padding: 6px;font-size: 11px; font-family: 'Inconsolata', monospace;">
                <div class="" style="float: left;">
                    <div>
                        <span>Famkart Store</span>
                    </div>
                    <div>
                        <span>Address: Chaltlang</span>
                    </div>
                    <div>
                        <span>Manager: Lalngaihawma</span>
                    </div>
                </div>
                <div style="float:right;" >
                    <div>
                        <span>01:12 pm</span>
                    </div>
                    <div>
                        <span>Date : 12/4/2022</span>
                    </div>
                    <div>
                        <span>POS Terminal #1</span>
                    </div>
                </div>
                <div style="clear: both;">

                </div>
            </div>
        </div>
    
        <div style="border-bottom: 2px dashed gray;padding: 6px;margin-top: 12px;">
            <div>
                <div style="font-size: 10px;">
                    <div style="float: left;"> 
                        <span>ITEM</span>
                    </div>
                    <div style="float: right;">
                        PRICE
                    </div>
                    <div style="clear: both;">

                    </div>
                </div>
                
                @foreach($sale->products as $product)
                <div style="padding-top: 4px; padding-bottom: 4px;">
                    <div style="font-size: 9px; font-family: 'Inconsolata', monospace;">
                        <div style="float:left;">
                            <span>{{$product->inventory->item->name}}</span>
                        </div>
                        <div style="float: right;">
                        &#8377;{{$product->inventory->selling_price}}
                        </div>
                        <div style="clear: both;">

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div style="font-size: 10px;padding-top: 8px;border-top: 1px dashed gray;">
                <div style="font-family: 'Inconsolata', monospace;">
                    <div style="float: left;">
                        <span>SUBTOTAL</span>
                    </div>
                    <div style="float: right;">
                    &#8377;{{$sale->total_without_gst}}
                    </div>
                    <div style="clear: both;">
                    </div>
                </div>
                <div style="font-family: 'Inconsolata', monospace;">
                    <div style="float: left;">
                        <span>TAX</span>
                    </div>
                    <div style="float: right;">
                    &#8377;{{$sale->total_with_gst - $sale->total_without_gst}}
                    </div>
                    <div style="clear: both;">
                    </div>
                </div>
                <div style="font-family: 'Inconsolata', monospace;">
                    <div style="float: left;">
                        <span>TOTAL</span>
                    </div>
                    <div style="float:right;">
                    &#8377;{{$sale->total_with_gst}}
                    </div>
                    <div style="clear: both;">
                    </div>
                </div>
            </div>

            <div style="padding: 6px;margin-top: 12px;border-top:1px dashed gray;">
                <div style="font-size: 9px; justify-content: center;font-family: 'Inconsolata', monospace;text-align:center;">
                    <span>THANK YOU FOR CHOOSING US</span>
                </div>
                <!-- <div style="display: flex; justify-content: center;">
                    <div style="font-size: 27px;" class="font-barcode">BARCODE</div>
                </div> -->
                
                <div style="display: flex; justify-content: center;margin-top: 6px;font-size: 10px;">
                    <div style="text-align: center;">
                        <span class="font-inconsolata">www.famcart.in</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>