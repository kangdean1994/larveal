<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class Admin extends Controller
{

	public function register(){

		return view('admin/admin_register');
	}

	public function do_register(Request $request){
		$validatedData = $request->validate([
        'register_name' => 'required|unique:register|max:255',
	    'register_email' => 'required|email',
	    'register_pwd'=>'required',
	    ],
	 ['register_name.required'=>'请填写用户名',
	  'register_name.unique'=>'用户名已存在',
	  'register_email.required'=>'请填写邮箱',
	  'register_email.email'=>'请填写正确的邮箱',
	  'register_pwd.required'=>'请填写您的密码',
	  ]);
		$data = $request->all();
		$res = DB::table('register')->insert(['register_name'=>$data['register_name'],'register_email'=>$data['register_email'],'register_pwd'=>$data['register_pwd'],'register_time'=>time()]);
		if($res){
			return redirect('Admin/login');
		}else{
			return redirect('Admin/register');
		}

	}

	public function login(){
		
	return view('admin/admin_login');
}

	public function do_login(Request $request){

	$data=$request->all();
	  // dd($data);
	$where = [
			['register_name','=',$data['register_name']],
			['register_pwd','=',$data['register_pwd']],
		];
	 // dd($where);
	$count = DB::table('register')->where($where)->first();
	   // dd($count);
	if($count){
		// dd($register_name);
		$request->session()->put('register_name',$count);
		
		return redirect('Admin/index');
	}else{

	 return redirect('Admin/login');
		

	}
	
	
}

    public function index(Request $request)
    {	
    	$redis = new \ Redis();
		$redis->connect('127.0.0.1','6379');
		$num =$redis->incr('num');

		$search = $request->all()['search']??'';
    	
		$where = [
			['goods_name','like',"%{$search}%"],
		];    	
    	 $data = DB::table('goods')->where($where)->paginate(2);
    	 // $users = DB::table('users')->paginate(15);
    	 // dd($data);
    	 			    
    	return view('admin/index',['data'=>$data,'search'=>$search,'num'=>$num]);

    }

    public function create()
    {
    	return view('admin/create');
    }

      public function save(Request $request)
    {
    	$data = $request->all();
	   	// dd($data);
	   	$path = $request->file('goods_pic')->store('goods');
	   	// dd($path);
	   	$goods_pic=('/storage/'.$path);
		 

	   $res = DB::table('goods')->insert( [
	   	'goods_name'=>$data['goods_name'],
	   	'goods_price'=>$data['goods_price'],
	   	'is_top'=>$data['is_top'],
	   	'goods_stock'=>$data['goods_stock'],
	   	'goods_pic'=>$goods_pic,
	   	'add_time'=>time(),
	   ]);
	   if($res){
			return redirect('Admin/index');
		}else{
			return redirect('Admin/create');
		}
	}


	public function delete(Request $request)
	{
		$id = $request->all()['id'];
		$res = DB::table('goods')->delete($id);
		if($res){
			return redirect('Admin/index');
		}else{
			return "fail";
		}

	}


public function update(Request $request)
{
	$id = $request->all();
	$data = DB::table('goods')->where(['id'=>$id['id']])->first();
	// dd($data);
	return view('admin/update',['data'=>$data]);
}


public function do_update(Request $request)
{
	$files = $request->file('goods_pic');

	$id= $request->all()['id'];
	$where = [
		['id','=',$id]
	];
	if(empty($files)){
		echo "false";
	}else{
		$path = $request->file('goods_pic')->store('good');
		// dd($path);
		$goods_pic = ('/storage/'.$path);
		// dd($goods_pic);
		$arr = ['goods_pic'=>$goods_pic];
		// dd($arr);
		$res = DB::table('goods')->where($where)->update($arr);
	}
	$data = $request->all();
	// dd($data);
	$res = DB::table('goods')->where(['id'=>$data['id']])->update(['goods_name'=>$data['goods_name'],'goods_price'=>$data['goods_price'],'is_top'=>$data['is_top']]);
		if($res){
			return redirect('Admin/index');
		}else{
			return "fail";
		}
 }


 public function user_create(){
 	return view('admin/admin_user');
 }


 public function user_save(Request $request){
 	$validatedData = $request->validate([
        'user_name' => 'required|unique:user|max:255',  
	    ],
	 ['user_name.required'=>'请填写用户名',
	  'user_name.unique'=>'该管理员已存在',
	  ]);

 	$data = $request->all();
 	 // dd($data);
 	$count = DB::table('user')->insert(['user_name'=>$data['user_name'],'user_pwd'=>$data['user_pwd'],'user_state'=>$data['user_state'],'reg_time'=>time()]);
 	// dd($res);
 	if($count>0){
 		return redirect('Admin/user_index');
 	}else{
 		return redirect('Admin/user_create');
 	}

 }


 public function user_index(Request $request){
 	$data = DB::table('user')->paginate(2);
 	// dd($data);
 	return view('admin/user_index',['data'=>$data]);

 }

 public function exit(Request $request){
 	$data = $request->session()->forget(['register_name', 'register_pwd']);
 	if($data==""){
 		return redirect('Admin/login');
 	}

 }
}
