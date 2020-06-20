<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        $categories = Category::selection()->get();
        //return response()->json($categories);

        return $this -> returnData('categories',$categories);
    }

    public function getCategoryById(Request $request)
    {

        $category = Category::selection()->find($request->id);
        if (!$category)
            return $this->returnError('001', 'هذا القسم غير موجد');

        return $this->returnData('categroy', $category);
    }

    public function changeStatus(Request $request)
    {
       //validation
        Category::where('id',$request -> id) -> update(['active' =>$request ->  active]);

        return $this -> returnSuccessMessage('تم تغيير الحاله بنجاح');

    }




}
