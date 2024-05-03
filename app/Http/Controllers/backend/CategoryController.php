<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function CategoryList(Request $request)
    {
        $list = DB::table('in_product_name')->get();
        return view('backend.invertory.category.list_category',compact('list'));
    }


    public function CategoryAdd()
    {
        $all = DB::table('in_product_name')->get();
        return view('backend.invertory.category.create_category',compact('all'));
    }
    public function CategoryInsert(Request $request)
    {
        $data = array();
        $data['name_product'] = $request->name;
        $insert = DB::table('in_product_name')->insert($data);

        if ($insert)
        {
            return redirect()->back()->with('success','Наименование успешно создано!');
        }
        else
        {
            $notification=array
            (
                'messege'=>'error ',
                'alert-type'=>'error'
            );
            return Redirect()->route('invertory.index')->with($notification);
        }

    }

      public function EditCategory ($id)
    {
        $edit=DB::table('in_product_name')
             ->where('id_name',$id)
             ->first();
        return view('backend.invertory.category.edit_category', compact('edit'));
    }

    public function UpdateCategory(Request $request,$id)
    {
        DB::table('in_product_name')->where('id_name', $id)->first();
        $data = array();
        $data['name_product'] = $request->name;
        $update = DB::table('in_product_name')->where('id_name', $id)->update($data);

        if ($update)
        {
            return Redirect()->back()->with('success','Наименование успешно обновлено!');
        }
        else
        {
            $notification=array
            (
            'messege'=>'error ',
            'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }

    }

    public function DeleteCategory ($id)
    {
        $delete = DB::table('in_product_name')->where('id_name', $id)->delete();
        if ($delete)
        {
           $notification=array(
           'messege'=>'Наименование успешно удалено    !',
           'alert-type'=>'success'
           );
           return Redirect()->back()->with($notification);
        }
        else
        {
           $notification=array(
           'messege'=>'error ',
           'alert-type'=>'error'
           );
           return Redirect()->back()->with($notification);

        }

    }
}
