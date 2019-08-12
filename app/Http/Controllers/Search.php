<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class Search extends Controller
{
    public function search_add()
    {
    	return view('Search/search_add');
    }

    public function do_add(Request $request)
    {
    	$data = $request->all();
    	$search_one=$data['search_one'];
    	if($search_one=='单选'){
    	$res = DB::table('search_type')->insert(['type'=>$data['search_one']]);
    	if($res){
    		return redirect('Search/search_dan');
    	}
    }else if($search_one=='复选'){
    	$res = DB::table('search_type')->insert(['type'=>$data['search_one']]);
    	if($res){
    		return redirect('Search/search_fu');
    	}
    	
    }
    }

    public function search_question()
	{
		return view('Search/search_question');

	}

	 public function question_add(Request $request)
	{
		$data = $request->all();
		$res = DB::table('search_question')->insert(['search_name'=>$data['search_name']]);
		if($res){
			return redirect('Search/search_add');
		}
	}

	public function search_dan()
	{
		return view('Search/search_dan');

	}

	public function search_fu()
	{
		return view('Search/search_fu');
		
	}



    public function dan_add(Request $request)
    {
    	
    	$data = $request->all();
    	$res = DB::table('search_dan')->insert(['dan'=>$data['dan'],'a'=>$data['a'],'b'=>$data['b'],'c'=>$data['c'],'d'=>$data['d']]);
    	
    	if($res){
    		return redirect('Search/search_list');
    	}
    	return view('search/search_dan');
    }

     public function fu_add(Request $request)
    {

    	$data = $request->all();
    	$res = DB::table('search_fu')->insert(['fu'=>$data['fu'],'a'=>$data['a'],'b'=>$data['b'],'c'=>$data['c'],'d'=>$data['d']]);
    	if($res){
    		return redirect('Search/search_list');
    	}
    	return view('search/search_fu');
    }



    public function search_list()
    {
    	$data = DB::table('search_question')->get();
    	// dd($data);
    	return view('Search/search_list',['data'=>$data]);
    }



    public function question_delete(Request $request)
    {
    	$id = $request->all()['id'];
    	// dd($id);
    	$where = ['id'=>$id];
    	$res = DB::table('search_question')->where($where)->delete();
    	if($res){
    		return redirect('Search/search_list');
    	}
    }


    public function search_order()
    {
    	$d_id = Db::table('search_dan')->first();
    	 $d_id = get_object_vars($d_id);
    	dd($d_id);
    	$id = '';
    	$id = $d_id('d_id');
    	 dd($id);
    	return view('Search/search_order');
    	
    }






















}
