<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class Kao extends Controller
{
    public function login()
    {
    	$appid = 'wx87161de9b35921a7';
		$redirect_uri ='http://www.larveral.com/Kao/code';
		// dd($redirect_uri);
		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';
		 // dd($url);
		header('Location:'.$url);
    }



    public function code(Request $request)
    {
        $access_token = $this->get_access_token();
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
            return redirect('Kao/create_class');
        }
        
        
    }



     public function event()
        {
            $data = file_get_contents("php://input");
            //解析XML
            $xml = simplexml_load_string($data,'SimpleXMLElement', LIBXML_NOCDATA);        //将 xml字符串 转换成对象
            $xml = (array)$xml; //转化成数组
            $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
            file_put_contents(storage_path('logs/wx_event.log'),$log_str,FILE_APPEND);
            if($xml['MsgType'] == 'event'){
                if($xml['Event'] == 'subscribe'){ //关注
                    if(isset($xml['EventKey'])){
                        //拉新操作
                        $agent_code = explode('_',$xml['EventKey'])[1];
                        $agent_info = DB::table('user_agent')->where(['user_id'=>$agent_code,'openid'=>$xml['FromUserName']])->first();
                        if(empty($agent_info)){
                            DB::table('user_agent')->insert([
                                'user_id'=>$agent_code,
                                'openid'=>$xml['FromUserName'],
                                'add_time'=>time()
                            ]);
                        }
                    }
                    $message = '欢迎xx同学进入选课系统';
                    $xml_str = '<xml>
                                <ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName>
                                <FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName>
                                <CreateTime>'.time().'</CreateTime>
                                <MsgType><![CDATA[text]]></MsgType>
                                <Content><![CDATA['.$message.']]></Content>
                                </xml>';
                    echo $xml_str;
                }
            }else if($xml['MsgType'] == 'text'){
                $key = '9413322aab050216f8c0b7c2aae862cc';
                $url = "http://apis.juhe.cn/cnoil/oil_city?key=$key";
                $info =file_get_contents($url);
                $info = json_decode($info,1);
                // dd($info);die;
                $result = $info['result'];
                // dd($result);die;
                $city=array_column($result,'city');
                // dd($city);die;
                $data = $xml['Content'];
                $sub_str = substr($data,0,-6);
                // dd($sub_str);
                $arry = [];
                   foreach($result as $v){
                     if($sub_str == $v['city']){
                            echo "<pre>";
                            // print_r($v);
                            $array = $v;
                     }
                }
                       // $message = $city.'目前油价：'."\n";
                        $message = $array['city'].'目前油价：'."\n".'92h：'.$array['92h']."\n".'95h：'.$array['95h']."\n".'98h：'.$array['98h']."\n".'0h：'.$array['0h'];
                        $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                        echo $xml_str;die;
           
                $message = '宝塔镇河妖';
                $xml_str = '<xml>
                            <ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName>
                            <FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName>
                            <CreateTime>'.time().'</CreateTime>
                            <MsgType><![CDATA[text]]></MsgType>
                            <Content><![CDATA['.$message.']]></Content>
                            </xml>';
                echo $xml_str;
     }
     //echo $_GET['echostr'];  //第一次访问
 }



 	public function create_class()
 	{
 		return view('Kao/create_class');
 	}


 	public function do_class(Request $request)
 	{
 		$data = $request->all();
 		// dd($data);
 		$res = DB::table('myclass')->insert(['first_class'=>$data['first_class'],'second_class'=>$data['second_class'],'three_class'=>$data['three_class'],'four_class'=>$data['four_class'],'add_time'=>time()]);
 		if($res){
 			return redirect('Kao/class_list');
 		}
 	}


 	public function class_list()
 	{
 		$id = DB::table('myclass')->first();
 		if($id == null){
 			echo "请先选择课程";
 			header('Location:'.'create_class');
 		}else{
 			$info = DB::table('register')->orderBy('register_id','desc')->first();
 			$info = get_object_vars($info);
 			$name = $info['register_name'];
 			// dd($info['register_name']);
 			$data = DB::table('myclass')->get();
 			return view('Kao/class_list',['data'=>$data,'name'=>$name]);
 		}
 		
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



    public function get_access_token()
    {
    	//获取sccess_token
    	$access_token = '';
    	$appid = "wx87161de9b35921a7";
    	$appsecret = "aed38289a6720a42a9047da963b66c68";
    	// dd($appsecret);
    	$redis = new \Redis();
    	$redis->connect('127.0.0.1','6379');
    	// $access_token_key = 'wechat_access_token';
    	if(($redis->get('access_token'))===false){
    		//区微信接口拿
            $access_re=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}");
	    	$access_result = json_decode($access_re,1);
	    	$access_token = $access_result['access_token'];
	    	$expire_time = $access_result['expires_in'];
	    	//加入缓存
	    	$redis->set('access_token',$access_token,$expire_time);
    	}else{
    		//区缓存拿
    		$access_token = $redis->get('access_token');
    		// dd($access_token);
    	}
    	return $access_token;
    }


}
