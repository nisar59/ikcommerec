<!DOCTYPE html>
<html>
   <head>
      <title>INVOICE PDF</title>
      <style type="text/css">
         .container{
         border:1px solid purple;
         padding: 5px;
         padding-bottom: 20%;
         }
         h2{
         width: 100%;
         color:white;
         background-color: purple;
         text-align: center;
         margin: 0;
         padding: 10px;

         }
         p{
         margin: 0;
         padding: 0;
         }
         #addd{
         border-top: 1px solid silver;
         }
      </style>
   </head>
   <body>
      <div class="container">
         <h2>INVOICE</h2>
         <div style="text-align: center; width: 100%;"><b>{{config('settings.config_invoice_pre_fix')}}{{$data['user']->id}}</b></div>
         <table width="100%">
            <tr>
               <td><img src="{{ url('public/uploads/images/'.settingsValue('config_site_logo'))}}" height="75"></td>
               <td align="right">
                  <p>{{settingsValue('config_site_title')}}</p>
                  <p>{{$data['user']->shipping_from_address}}</p>
                  <p>{{$data['user']->shipping_from_mbl}}</p>
               </td>
            </tr>
         </table>
         <table id="addd" width="100%">
            <tr>
               <td>
                  <b>Bill To:</b>
                  <p>{{$data['user']->first_name.' '.$data['user']->last_name}}</p>
                  <p>{{$data['user']->billing_phone}}</p>
                  <p>{{$data['user']->billing_email}}</p>
                  <p>{{$data['user']->billing_address_1.' '.$data['user']->billing_city.' '.$data['user']->post_code.' '.$data['user']->billing_country}}</p>
               </td>
               <td align="right">
                  <b>Ship To:</b>
                  <p>{{$data['user']->first_name.' '.$data['user']->last_name}}</p>
                  <P>{{$data['user']->ship_phone}}</P>
                  <P>{{$data['user']->ship_email}}</P>
                  <P>{{$data['user']->ship_address_1.' '.$data['user']->ship_city.' '.$data['user']->ship_state.' '.$data['user']->ship_country}}</P>
               </td>
            </tr>
         </table>
         <table width="100%" border="1" align="center">
            <tr>
               <th>#</th>
               <th>DESCRIPTION</th>
               <th>UNIT PRICE</th>
               <th>QUANTITY</th>
               <th>TOTAL</th>
            </tr>
            @php
            $pro=App\Models\OrderProduct::where('order_id',$data['user']->id)->get();
            $i=0;
            foreach($pro as $val){
            $proname=Modules\Products\Entities\Products::where('id', $val->product_id)->pluck('name')->first();
            $i=$i+1;
            @endphp
            <tr>
               <td align="center">{{$i}}</td>
               <td>{{$proname}}</td>
               <td align="center">Rs.{{$val->price}}</td>
               <td align="center">{{$val->quantity}}</td>
               <td align="center">Rs.{{$val->total_price}}</td>
            </tr>
            @php
            }
            @endphp
      </table>

      <div style="float: right;">
        <table border="1">
               <tr>
                  <td colspan="4"><b>SUBTOTAL</b></td>
                  <td>Rs.{{$data['user']->sub_total}}</td>
               </tr>
               <tr>
                  <td colspan="4"><b>Delivery / Charges</b></td>
                  <td>Rs.{{$data['user']->shipping}}</td>
               </tr>
               <tr>
                  <td colspan="4"><b>Discount</b></td>
                  <td>Rs.{{$data['user']->discount}}</td>
               </tr>
               <tr>
                  <td colspan="4"><b>GRAND TOTAL</b></td>
                  <td>Rs.{{$data['user']->total}}</td>
               </tr>
            </table>
      </div>



      </div>
   </body>
</html>