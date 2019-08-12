<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class Cai extends Controller
{
    public function create()
    {
    	return view('Cai/create');

    }


    public function save(Request $request)
    {
    	$data = $request->all();
    	// dd($data);
    	// dd(['c_name'=>$data['c_name'],'c_name1'=>$data['c_name1'],'c_time'=>date("H:i",time()+7200)]);
    	$res = DB::table('cai')->insert(['c_name'=>$data['c_name'],'c_name1'=>$data['c_name1'],'c_time'=>time()+7200]);
    	if($res){
    		return redirect('Cai/list');
    	}else{
    		return redirect('Cai/create');
    	}

    }


public function list()
{
	$data = DB::table('cai')->get();
	// dd($data);
	return view('Cai/list',['data'=>$data]);
}


public function delete(Request $request)
{
	$id = $request->all()['id'];
		$where = ['c_id'=>$id];
    	$res = DB::table('cai')->where($where)->delete();
	if($res){
		return redirect('Cai/list');
	}
}

public function add(Request $request)
{
	$id = $request->all()['id'];
	$where = ['c_id'=>$id];
	$data = DB::table('cai')->where($where)->get();
	// $data = get_object_vars($data);
	  // dd($data);
	return view('Cai/add',['data'=>$data]);
}



public function do_add(Request $request)
{
	$data = $request->all();
	  // dd($data);
	$res = DB::table('join_cai')->insert(['c_id'=>$data['c_id'],'join_name'=>$data['join_name'],'join_name1'=>$data['join_name1'],'join_ying'=>$data['join_ying'],'join_time'=>time()]);
	if($res){

		return redirect('Cai/order_list');
	}

}

public function order_list(Request $request)
{
	// echo (time()-120);die;
	$info= DB::table('join_cai')->first();
	  $info = get_object_vars($info);
 	$c_id= '';
 	$c_id = $info['c_id'];
 	$where = ['c_id'=>$c_id]; 
 	$time = DB::table('cai')->where($where)->first();
 	$time = get_object_vars($time);

 	$cai_time ='';
	$cai_time =  $time['c_time'];
	
 	// dd($cai_time);
	$data = DB::table('join_cai')->get()->toarray();	
	// dd($data);
	$times=time();
	
	return view('Cai/order_list',['data'=>$data,'cai_time'=>$cai_time,'times'=>$times]);
}

public function cai_result()
{
	$data = DB::table('cai')->first();

	$data = get_object_vars($data);
	$c_id = '';
	$c_id = $data['c_id'];
	$where = ['c_id'=>$c_id];
	$info = DB::table('cai')->where($where)->get();
	// $info = get_object_vars($info);
	  // dd($info);
	return view('Cai/cai_result',['info'=>$info]);
	
}

public function do_result(Request $request)
{
	$data = $request->all();
	 // dd($data);
	$end_time = $data['end_time'];
	$end_time = strtotime($end_time);
	// $result = $end_time;

	$res = DB::table('cai_result')->insert(['c_id'=>$data['c_id'],'join_name'=>$data['join_name'],'join_name1'=>$data['join_name1'],'result'=>$data['result'],'end_time'=>$end_time,'result_time'=>$end_time]);
	// dd($res);
	if($res){
		return redirect('Cai/do_look');
	}
	
}

public function do_look()
{
	$data = DB::table('cai_result')->get();
	$arr = DB::table('cai_result')->first();
	 $arr = get_object_vars($arr);
		
	$id = '';
	$id = $arr['c_id'];
	$where = ['c_id'=>$id];
	// dd($where);
	$info = DB::table('join_cai')->where($where)->get();
	// $info = get_object_vars($info);
	  // dd($info);
	return view('Cai/do_look',['data'=>$data,'info'=>$info]);
}







}
