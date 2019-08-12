<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class Message extends Controller
{

	public function message_info(Request $request)
	{
		$data = $request->all()['access_token'];
		// dd($data);
		$access_token = 888;
		if($data!=$access_token ){
			echo "您的令牌有误";die;
		}elseif(empty($data)){
			echo "您的令牌为空";die;
		}

		$info = DB::table('student')->get();
		dd($info);
	}


	public function login()
	{
		return view('Message/login');
	}
	public function do_login(Request $request)
	{
		$data = $request->all();
		// dd($data);
		$data = DB::table('message_user')->where(['message_name'=>$data['message_name'],'message_pwd'=>$data['message_pwd']])->first();
		if($data){
			$request = session()->forget('add');
			$requset = session()->put('add',$data);

			return redirect('Message/add');
		}
	}


    public function add(Request $request)
    {

    	$data = DB::table('message')->get();
    	// dd($data);
    	$redis = new \ Redis();
		$redis->connect('127.0.0.1','6379');
		$num =$redis->incr('num');

		$search = $request->all()['search']??'';
    	
		$where = [
			['name','like',"%{$search}%"],
		];    	
    	 $data = DB::table('message')->where($where)->paginate(2);
    	 // dd($data);			   
    	return view('Message/add',['data'=>$data,'search'=>$search,'num'=>$num]);
    }

    public function save(Request $request)
    {
    	
 		
    	$data = $request->all();
    	$value = $request->session()->get('add');
    	$value = get_object_vars($value);
    	 // dd($value);
    	$res = DB::table('message')->insert(['name'=>$value['message_name'],'content'=>$data['content'],'add_time'=>time()]);
    	// dd($res);
    	if($res){
    		return redirect('Message/add');
    	}

    }

    public function delete(Request $request)
    {
	    	$value = $request->session()->get('add');
	    	$value = get_object_vars($value);
	    	// dd($value);
	    	$name = $value['message_name'];
	    	$id = $request->all()['id'];
	    	$where = [['id','=',$id]];
	    	$data = DB::table('message')->where($where)->first();
	    	$data = get_object_vars($data);
	    	// dd($data);
	    	$time = $data['add_time'];
	    	$now_time = time()-1800;
	    	if($time>$now_time){
	    		$res = DB::table('message')->where($where)->delete();
	    	if($res){
	    		return redirect('Message/add');}
	    	
	    	
	    	}elseif($name!=$data['name']){
	    		
	    		echo "你无权删除其他用户的评论";
	    	}else{
	    		echo "对不起,时间超过半小时不能删除";
	    	}
	   




	    }
    	

    	
















    



















}
