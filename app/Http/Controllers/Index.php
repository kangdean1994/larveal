<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class Index extends Controller
{

	public function register(){

		return view('login/register');
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
			return redirect('login/login');
		}else{
			return redirect('login/register');
		}

	}

	public function login(){
		
	return view('login/login');
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
		 return redirect('Index/login');
	}else{
		return redirect('Index/index');
	}
	
	
}



    public function index(){
    	  $data = DB::table('goods')->paginate(2);
    	// $data = DB::table('goods')->get();
    	 // dd($data);
    	return view('index/index',['data'=>$data]);
    }

    public function list(Request $request){

    	$id = $request->all()['id'];
    	$where=[
    		['id','=',$id],
    	];
    	// dd($where);
    	$info = DB::table('goods')->where($where)->first();
    

    	return view('index/list',['info'=>$info]);
    }

    public function cart_save(Request $request){
    	$goods_id = $request->all()['id'];
    	$res = DB::table('cart')->where([['goods_id','=',$goods_id]])->first();
    	// dd($res);
    	if($res){
    		$buy = ($res->buy_num)+1;
    		$info = DB::table('cart')->where([['goods_id','=',$goods_id]])->update(['buy_num'=>$buy]);
    		if($info){
    			return redirect('Index/cart_list');
    	}else{
    		return redirect('Index/list');
    	}

    	}else{
    	$where=[
    		['id','=',$goods_id],
    	];
    	$infos = DB::table('goods')->where($where)->get()->toarray();
    	
    	$info=get_object_vars($infos[0]);

    	// if($goods_id=='goods_id+')
    	  // dd($info);
    	$count = DB::table('cart')->insert(['goods_id'=>$goods_id,'goods_name'=>$info['goods_name'],'goods_price'=>$info['goods_price'],'goods_pic'=>$info['goods_pic'],'add_time'=>time()]);
    	// dd($count);
    	if($count>0){
    		return redirect('Index/cart_list');
    	}else{
    		return redirect('Index/list');
    	}
    }

    }




    	public function cart_list(){
    		$data = DB::table('cart')->get()->toArray();
    		  // dd($data);
    		$goods_id = array_column($data,'goods_id');
    		// dd($goods_id);
    		$goods_id = implode(',',$goods_id);
    		// dd($goods_id);
    		$total = [];
    		$pricetotal = "";
    		foreach ($data as $k => $v){
    			 $v=get_object_vars($v);
    			 $total[] = $v['goods_price']*$v['buy_num'];
    			 $price = array_sum($total);
    			 // dd($price);
    			 $pricetotal = $price;

    		}
    		 // dd($pricetotal);
    		return view('index/cart_list',['data'=>$data,'pricetotal'=>$pricetotal]);
    	}



    	public function cart_buy(){

    		$data = DB::table('cart')->get()->toArray();
    		  // dd($data);
    		$goods_id = array_column($data,'goods_id');
    		// dd($goods_id);
    		$goods_id = implode(',',$goods_id);
    		// dd($goods_id);
    		$total = [];
    		$pricetotal = "";
    		foreach ($data as $k => $v){
    			 $v=get_object_vars($v);
    			 $total[] = $v['goods_price']*$v['buy_num'];
    			 $price = array_sum($total);
    			 // dd($price);
    			 $pricetotal = $price;

    		}
    		return view('index/cart_buy',['data'=>$data,'pricetotal'=>$pricetotal]);
    	}

        public function cart_delete(Request $request){
            $id = $request->all()['id'];
            $where = [['id','=',$id]];
            // dd($where);
            $res = DB::table('cart')->where($where)->delete();
            if($res){
               return  redirect('Index/cart_list');
            }else{
                return  "false";
            }
        }

        public function buy_delete(Request $request){
              $id = $request->all()['id'];
            $where = [['id','=',$id]];
            // dd($where);
            $res = DB::table('cart')->where($where)->delete();
            if($res){
               return  redirect('Index/cart_list');
            }else{
                return  "false";
            }
        }

    	public function order_create(Request $request){
    		$total = $request->all();
    		 // dd($total);
    		//产生订单号
    		$oid = time().mt_rand(1000,1111);
    		// dd($oid);
    		$arr = [
    			'add_time'=>time(),
    			'oid'=>$oid,
    			'pay_money'=>$total['total'],
    		];

    		 // dd($arr);
    		$res = DB::table('order')->insert($arr);
    		// dd($res);
    		if($res){
    			return redirect('Index/order_list');
    		}else{
    			return redirect('Index/order_create');
    		}
    	
    		
    	}


    	public function order_list(){

    		$data =DB::table('order')->get();
    		// dd($data);
    		 return view('index/order_list',['data'=>$data]);
    		
    	}




 public function ticket_list(Request $request){
   $req = $request->all()??'';
    $go_station = $req['go_station']??'';
    $end_station = $req['end_station']??'';
   // dd($req);
   //连接redis
   $redis = new \redis();
   $redis->connect('127.0.0.1','6379');
   //判断redis里面有没有ticket_key
   if(!$redis->get('ticket_info')){
    if(!empty($req['go_station'])|| !empty($req['end_station'])){
        //记录搜索次数
        $redis->incr('ticket_num');
        $list = DB::table('ticket')
        ->where('go_station','like',"%${req['go_station']}%")
        ->where('end_station','like',"%${req['end_station']}%")
        ->get();
    }else{
        //没有搜索所条件返回全部数据
        $list = DB::table('ticket')->get();
    }
    //redis获取访问次数
    $ticket_num = $redis->get('ticket_num');
    //判断访问次数
    if($ticket_num>20){
        $redis_info = json_encode($list);
        $redis->set('ticket_info',$redis_info,3*60);
    }
}else{
    $list = json_encode($redis->get('ticket_info'),true);
}
    echo "访问次数:".$redis->get('ticket_num');

        //$redis->set('key','');
    return view('index/ticket_list',['list'=>$list,'go_station'=>$go_station,'end_station'=>$end_station]);
    }

 //    $go_station = $request->all('go_station')['go_station']??'';
 //    // dd($go_station);
 //    $end_station = $request->all('end_station')['end_station']??'';
 //      $redis = new \ Redis();
 //      $redis->connect('127.0.0.1','6379');
 //        $num =$redis->incr('num');
     
 //      $where =[];
 //    if(empty($go_station)){
 //        $where = [
 //        ['end_station','like',"%{$end_station}%"]
 //        ];
 //    }
 //    if(empty($end_station)){
 //        $where = [
 //        ['go_station','like',"%{$go_station}%"]
 //        ];
 //    }
    
 //    if($go_station && $end_station){
 //        $where = [
 //            ['go_station','like',"%{$go_station}%"],
 //            ['end_station','like',"%{$end_station}%"]
 //        ];
 //    }

 //    $data = DB::table('ticket')->where($where)->paginate(2);
 //    // dd($data);
 //    return view('index/ticket_list',['data'=>$data,'go_station'=>$go_station,'end_station'=>$end_station,'num'=>$num]);
 // }



}
