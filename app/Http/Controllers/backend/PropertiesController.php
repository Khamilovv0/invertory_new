<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ProperityList(Request $request)
    {
        $property_list = DB::table('in_list_characteristics')->get();
        return view('backend.invertory.properties.list_properties',compact('property_list'));
    }

    public function ProperityAdd()
    {
        $all = DB::table('in_list_characteristics')->get();
        return view('backend.invertory.properties.create_properties',compact('all'));
    }

    public function ProperityInsert(Request $request)
    {
        $data = array();
        $data['name_characteristic'] = $request->name;
        $data['input_characteristic'] = $request->input;
        $insert = DB::table('in_list_characteristics')->insert($data);

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

    public function EditProperity ($id)
    {
        $edit=DB::table('in_list_characteristics')
            ->where('id_characteristic',$id)
            ->first();
        return view('backend.invertory.properties.edit_properties', compact('edit'));
    }

    public function UpdateProperity(Request $request,$id)
    {
        DB::table('in_list_characteristics')->where('id_characteristic', $id)->first();
        $data = array();
        $data['name_characteristic'] = $request->name;
        $data['input_characteristic'] = $request->input;
        $update = DB::table('in_list_characteristics')->where('id_characteristic', $id)->update($data);

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

    public function DeleteProperity ($id)
    {
        $delete = DB::table('in_list_characteristics')->where('id_characteristic', $id)->delete();
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
