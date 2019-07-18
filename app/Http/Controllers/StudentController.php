<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class StudentController extends Controller
{

	public function register(){

		return view('StudentRegister');
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
			return redirect('StudentController/login');
		}else{
			return redirect('StudentController/register');
		}

	}

	public function login(){
		
	return view('StudentLogin');
}

	public function do_login(Request $request){

	$data=$request->all();
	 // dd($data);
	$register_name=$data['register_name'];
	// dd($register_name);
	$request->session()->put('register_name',"$register_name");
	// dd($request->session());
	$register_name1=session('register_name');
	// dd($register_name1);
	$where = [
		['register_name','=',$register_name1],
	];
	$count = DB::table('register')->where($where)->count();
	// dd($count);
	if($count<=0){
		 return redirect('StudentController/login');
	}else{
		return redirect('StudentController/index');
	}
	
	
}




   public function index(Request $request)
  {
  	$info = DB::connection('mysql_bbs')->table('student')->get()->toArray();
  	// dd($info);
  	$redis = new \ Redis();
  	$redis->connect('127.0.0.1','6379');
  	$redis->incr('num');
  	$num = $redis->get('num');
  	echo '访问次数:'.$num;

  	$search = $request->all()['search']??'';
  
  	$where=[
  		['name','like',"%{$search}%"],
  	];

  	$info = DB::table('student')->where($where)->paginate(2);
  	// dd($info);
  	return view('StudentList',['student'=>$info],['search'=>$search]);
  }


   public function add(){

   	 return view('StudentAdd',[]);
   }

   public function do_add(Request $request){
 	$validatedData = $request->validate([
        'name' => 'required',
	    'age' => 'required',],
	 ['name.required'=>'姓名必填',
	'age.required'=>'年龄必填']);

   	$req=$request->all();
   	$res = DB::table('student')->insert(['name'=>$request['name'],'age'=>$request['age'],'create_time'=>time()]);
   if($res){
   			return redirect('StudentController/index');
   		}else{
   			return "fail";
   		}
   }

	public function update(Request $request){
		$id = $request->all();
		
		$data = DB::table('student')->where(['id'=>$id['id']])->first();
		
		return view('StudentUpdate',['stident_info'=>$data]);
	}

	public function do_update(Request $request){
		$data = $request->all();
		// dd($data);
		$res = DB::table('student')->where(['id'=>$data['id']])->update(['name'=>$data['name'],'age'=>$data['age']]);
		// dd($res);
		if($res){
			return redirect('StudentController/index');
		}else{
			return "fail";
		}
	}
	
	public function delete(Request $request){
		$id = $request->all();
		$res = DB::table('student')->where(['id'=>$id['id']])->delete(['id'=>$id['id']]);
		if($res){
			return redirect('StudentController/index');
		}else{
			return "fail";
		}
   }


   public function goodsadd(){
   	// dd(storage_path('app\public'));
   	return view('goods');
   }

   public function do_goodsadd(Request $request){
   	$data = $request->all();
   	// dd($data);
   	$files = $request->file('goods_pic');
   	if(empty($files)){
   		
   		//未传图片
   		echo "fail";die();
   	}else{
   		$path = $files->store('goods');
   	}
   	dd($path);
   	echo asset('storage').'/'.$path;
   	
   }

    

}
