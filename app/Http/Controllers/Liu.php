<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Wechat;
use EasyWeChat\Factory;
class Liu extends Controller
{

	public function wechat_login()
	{
		$redirect_uri ='http://www.larveral.com/Liu/wechat_code';
		//微信用户授权
		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
		// dd($url);
		header('location:'.$url);
	}



	public function wechat_code(Request $request,wechat $wechat)
	{
		$access_token = $wechat->get_access_token();
		// dd($access_token);

		$req = $request->all();
		// dd($req);
		$code = $req['code'];
		// dd($code);
		//用code获取access_token
		$url = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAT_APPID').'&secret='.env('WECHAT_APPSECRET').'&code='.$code.'&grant_type=authorization_code');
		// dd($url);
		 $res = json_decode($url,1);
		  // dd($res);
		$token = $res['access_token'];
		// dd($token);
		$openid = $res['openid'];
		//获取用户基本信息
		$url = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN\ ");
		// dd($url);
		$re = json_decode($url,1);
		 // dd($re['nickname']);
		$info = DB::table('register')->insert(['register_name'=>$re['nickname'],'register_time'=>time()]);
		
		$data = DB::table('register')->where('register_name','=',$re['nickname'])->first();
		// dd($data);
		if($data){
			$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
			// dd($url);
			  $info=[
                'touser'=>$openid,
              'template_id' => 'yrRTw8yi_pAh3dZ6s66UvmKyh6pfFvZNtis6S6rmELo',
               
                'data'=>[
                    'first'=>[
                        "value"=>"",
                        "color"=>""
                    ],
                	'remark'=>[
                    'value'=>"ojbk",
                    'color'=>"blue",
                    ]
                 ]      
            ];
            // dd($info);
            $re=$this->post($url,json_encode($info));
            // dd($re);
            $request->session()->put('info',$info);
            return redirect('Liu/go_message');
		}
		
		
	}
	
	 public function go_message(Request $request)
    {
    	// echo 111;
    	return view('Liu/go_message');    	
    }

    public function do_go_message(Request $request)
    {

    }

    public function message_list(Request $request,Wechat $wechat)
    {
    	
    	return view('liu/message_list');

    }

   

  
     public function config()
    {
        $config = [
            'app_id' => 'wx9f5dbb91dcfaee8f',
            'secret' => 'b084b27bcbb10ce63e3b37913ded5d3f',
        
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
        
            //...
        ];
        return $config;
    }

    public function user(wechat $wechat)
    {
        $config=$this->config();
        // dd($config);
        $app = Factory::officialAccount($config);
        $re=$app->user->list($nextOpenId = null);  // $nextOpenId 可选
        dd($re);
     
    }

    	//油价列表
     	public function index()
    	{
    		$key="c649b4de654d678c5ad3b633f13aab83";
			$url="http://apis.juhe.cn/cnoil/oil_city?key=$key";
			$re=file_get_contents($url);
			$re=json_decode($re,1);
			$oil_price=[];
			if($re!=[]){
				//全国油价的数组 
			$oil_price=$re['result'];
			}
			 // dd($oil_price);
    	}
    


        public function post($url, $data = [])
      {
        //初使化init方法
        $ch = curl_init();
        //指定URL
        curl_setopt($ch, CURLOPT_URL, $url);
        //设定请求后返回结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //声明使用POST方式来进行发送
        curl_setopt($ch, CURLOPT_POST, 1);
        //发送什么数据
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //忽略证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //忽略header头信息
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //设置超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        //发送请求
        $output = curl_exec($ch);
        //关闭curl
        curl_close($ch);
        //返回数据
        return $output;
    }
}
