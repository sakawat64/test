<?php

namespace App\Http\Controllers;

use App\Models\Payemnt;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function sale($id,$qty)
    {
        DB::beginTransaction();
        try {
            $product               = Product::find($id);
            $reduceQty['quantity'] = $product->quantity - $qty;
            $product->update($reduceQty);
            $dataSale['product_id'] = $id;
            $dataSale['qty']        = $qty;
            $saleId                 = Sale::create($dataSale);
            $dataPayment['sale_id'] = 222;//which is not exist and generate error//$saleId->id;
            $dataPayment['amount']  = 20;
            Payemnt::create($dataPayment);
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        DB::commit();
        echo "Sale Successfully";
    }
}
