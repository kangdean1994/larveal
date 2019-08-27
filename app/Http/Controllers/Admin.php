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
		
		return redirect('Message/add');
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

 public function ticket_create(){
 	return view('admin/ticket_create');
 }

public function ticket_save(Request $request){
 	$data = $request->all();
 	// dd($data);
 	$res = DB::table('ticket')->insert(['ticket_name'=>$data['ticket_name'],'go_station'=>$data['go_station'],'end_station'=>$data['end_station'],'ticket_price'=>$data['ticket_price'],'ticket_num'=>$data['ticket_num'],'add_time'=>time()]);
 	if($res){
 		return redirect('Index/ticket_list');
 	}else{
 		return redirect('Admin/ticket_create');
 	}
 }


 	public function question_add()
 {
 	return view('admin/question_add');
 }


    public function test_list(Request $request)
    {
        $info = DB::connection("mysql_cart")->table('question_test')->get()->toArray();
        return view('Question.testList',['info'=>$info]);
    }
    public function test_detail(Request $request)
    {
        $req = $request->all();
        dd($req);
    }
    public function insert_papers(Request $request)
    {
        $req = $request->all();
        $result = DB::connection("mysql_cart")->table('question_test')->insert([
            'title'=>$req['title'],
            'question_list'=>implode(',',$req['problem']),
            'add_time'=>time()
        ]);
        if($result){
            echo "ok";
        }else{
            echo 'false';
        }
    }
    public function question_index()
    {
        return view('admin/question_index');
    }
    public function add_papers()
    {
        return view('admin/papers');
    }
    public function do_add_papers(Request $request)
    {
        $info = DB::connection('mysql_cart')->table("question_problem")->get()->toArray();
        return view('admin/addPapers',['info'=>$info,'title'=>$request->all()['title']]);
    }
    public function add()
    {
        return view('Question.add');
    }
    public function do_add(Request $request)
    {
        $req = $request->all();
        echo "<pre>";print_r($req);
        DB::connection('mysql_cart')->beginTransaction();
        $result = true;
        if($req['type'] == 1){
            //单选
            $result1 = DB::connection("mysql_cart")->table('question_problem')->insertGetId([
                'type_id'=>$req['type'],
                'problem'=>$req['single'],
                'add_time'=>time()
            ]);
            $result2 = DB::connection("mysql_cart")->table('question_answer')->insert([
                'question_id'=>$result1,
                'desc'=>$req['single_a'],
                'is_answer'=>($req['single_answer'] == 1)?1:0,
                'add_time'=>time()
            ]);
            $result3= DB::connection("mysql_cart")->table('question_answer')->insert([
                'question_id'=>$result1,
                'desc'=>$req['single_b'],
                'is_answer'=>($req['single_answer'] == 2)?1:0,
                'add_time'=>time()
            ]);
            $result4 = DB::connection("mysql_cart")->table('question_answer')->insert([
                'question_id'=>$result1,
                'desc'=>$req['single_c'],
                'is_answer'=>($req['single_answer'] == 3)?1:0,
                'add_time'=>time()
            ]);
            $result5 = DB::connection("mysql_cart")->table('question_answer')->insert([
                'question_id'=>$result1,
                'desc'=>$req['single_d'],
                'is_answer'=>($req['single_answer'] == 4)?1:0,
                'add_time'=>time()
            ]);
            $result = $result1 && $result2 && $result3 && $result4 && $result5;
        }elseif($req['type'] == 2){
            //多选
            $result1 = DB::connection("mysql_cart")->table('question_problem')->insertGetId([
                'type_id'=>$req['type'],
                'problem'=>$req['box'],
                'add_time'=>time()
            ]);
            $result2 = DB::connection("mysql_cart")->table('question_answer')->insert([
                'question_id'=>$result1,
                'desc'=>$req['box_a'],
                'is_answer'=>in_array(1,$req['box_answer'])?1:0,
                'add_time'=>time()
            ]);
            $result3 = DB::connection("mysql_cart")->table('question_answer')->insert([
                'question_id'=>$result1,
                'desc'=>$req['box_b'],
                'is_answer'=>in_array(2,$req['box_answer'])?1:0,
                'add_time'=>time()
            ]);
            $result4 = DB::connection("mysql_cart")->table('question_answer')->insert([
                'question_id'=>$result1,
                'desc'=>$req['box_c'],
                'is_answer'=>in_array(3,$req['box_answer'])?1:0,
                'add_time'=>time()
            ]);
            $result5 = DB::connection("mysql_cart")->table('question_answer')->insert([
                'question_id'=>$result1,
                'desc'=>$req['box_d'],
                'is_answer'=>in_array(4,$req['box_answer'])?1:0,
                'add_time'=>time()
            ]);
            $result = $result1 && $result2 && $result3 && $result4 && $result5;
        }elseif ($req['type'] == 3){
            //判断
            $result = DB::connection("mysql_cart")->table('question_problem')->insertGetId([
                'type_id'=>$req['type'],
                'problem'=>$req['judge'],
                'judge_answer'=>$req['judge_answer'],
                'add_time'=>time()
            ]);
        }
        if($result){
            DB::connection('mysql_cart')->commit();
            echo "成功";
        }else{
            DB::connection('mysql_cart')->rollback();
            echo "失败";
        }
    }































}
