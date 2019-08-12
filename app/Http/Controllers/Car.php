<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class Car extends Controller
{
    public function create()
    {
    	$num = DB::table('car')->count();
    	$number = 400 - $num;

    	$path = "http://api.map.baidu.com/geocoder/v2/?address=北京市昌平区沙河地铁站&output=json&ak=CxF13N48UHZ12G8sIVpa2YTG";
    		
    	return view('Car/create',['number'=>$number]);
    }

     public function add()
    {
    	return view('Car/add');
    }

    public function do_add(Request $request)
    {
    	$data = $request->all();
    	// dd($data);
    	$res = DB::table('car')->insert(['car_name'=>$data['car_name'],'add_time'=>time(),'c_state'=>1]);
    	// dd($res);
    	if($res){
    		return redirect('Car/create');
    	}else{
    		return redirect('Car/add');
    	}
    }

    public function list()
    {
    	$data = DB::table('car')->get();
    	// dd($data);
    	return view('Car/list',['data'=>$data]);
    }

    public function update(Request $request)
    {
    	$id = $request->all()['c_id'];
    	$where = [];
    	$where = ['c_id'=>$id];
    	$res = DB::table('car')->where($where)->update(['c_state'=>2,'del_time'=>time()]);
    	// dd($res);
    	if($res){
    		return redirect("Car/car_list?c_id=$id");
    	}else{
    		return redirect('Car/list');
    	}

    }



public function car_list(Request $request)
{
	$c_id = $request->all()['c_id'];
	// dd($c_id);
	$where = [];
    $where = ['c_id'=>$c_id];
	$data = DB::table('car')->where($where)->get();
	// dd($data);
	return view('Car/car_list',['data'=>$data]);

}


public function address()
{
	return view('Car/address');
}


public function do_address(Request $request)
{
 $data = $request->all();
 // dd($data);

 $post =file_get_contents("http://api.map.baidu.com/geocoder/v2/?address={$data['address']}&output=json&ak=CxF13N48UHZ12G8sIVpa2YTG"); 

 $post = json_decode($post,1);
 // dd($post);
 $lng = $post['result']['location']['lng'];
 // dd($lng);
 $lat = $post['result']['location']['lat'];
 // dd($lat);
// dd($add);
return view('Car/list_address',['data'=>$data,'lat'=>$lat,'lng'=>$lng]);
}


public function list_address()
{
	return view('Car/list_address');
}







































}
