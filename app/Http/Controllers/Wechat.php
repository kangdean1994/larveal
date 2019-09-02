<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
class Wechat extends Controller
{
      

	public function login()
	{
		$appid = 'wx87161de9b35921a7';
		$redirect_uri ='http://www.larveral.com/Wechat/code';
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
            return redirect('Liu/go_message');
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


     public function get_user_info()
    {
    	$access_token = $this->get_access_token();
        $re=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access_token}&next_openid=");
        $re = json_decode($re,1);
        // dd($re);
    	$openid = $re['data']['openid'];
    	// dd($openid);
    	$arr = [];
    	$time = time();
    	foreach ($openid as $k => $v){
    		echo "<pre>";
    		  // print_r($v);die;
    		$data=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$v&lang=zh_CN");
            $data=json_decode($data,1);
            // dd($data['nickname']);
            $arr=['openid'=>$v,'nickname'=>$data['nickname'],'add_time'=>$time,'subscribe'=>$data['subscribe']];
              // dd($arr);
             DB::table('wechat')->insert($arr);
    	}
    	  return redirect('Wechat/');
    }


    public function get_user_list(Request $request)
    {		
        $tag_id = $request->all()['tag_id'];
          // dd($tag_id);
    	$access_token = $this->get_access_token();
    	$data = DB::table('wechat')->get();
      
    	return view('Wechat/wechat_list',['data'=>$data,'tag_id'=>$tag_id]);
    	
    }

   
    public function pro(Request $request)
    {
    	$access_token = $this->get_access_token();
    	 // dd($access_token);
    	$openid = $request->all()['openid'];
    	 // dd($openid);
    	$re=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN");
         // dd($re);
        $re=json_decode($re,1);
      
        $data=['headimgurl'=>$re["headimgurl"],'sex'=>$re['sex'],'nickname'=>$re['nickname'],'city'=>$re['city'],'openid'=>$access_token,'province'=>$re['province']];
         
         // dd($date(format)a); 
        return view('Wechat/wechat_pro',['data'=>$data]);
    }


     /**
     * 模板列表
     */
    public function template_list()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token='.$this->get_access_token();
        $re = file_get_contents($url);
        dd(json_decode($re,1));
    }

    public function del_template()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token='.$this->get_access_token();
        $data = [
            'template_id' => 'aSerVr6uQPlcmRpA_sCqBrvhjq3EehsK26I-3dVU7B4'
        ];
       

        $re = $this->wechatcontroller->get($url,json_encode($data));
        dd($re);
    }

    public function push_template()
    {
    	$info = DB::table('wechat')->select('openid')->limit(2)->get()->toArray();
    	dd($info);
    }
   
    

    public  function upload_source(Request $request)
    {

        $data = $request->all();
        // dd($data);
    	return view('Wechat/uploadSource');
    }

     
     public function do_upload(Request $request)
     {

     	$client = new Client();
     	
     	 if($request->hasFile('image')){
            //图片类型
            $path = $request->file('image')->store('wechat/image');
           
            $path='./storage/'.$path;
             // dd($path);
            $url='https://api.weixin.qq.com/cgi-bin/media/upload?access_token=' . $this->get_access_token().'&type=image';
        	  // dd($url);
            $response = $client->request('POST',$url,[
                'multipart' => [
                    [
                        'name'     => 'media',  
                        'contents' => fopen(realpath($path), 'r')
                    ],
                ]
            ]);
            $data = $response->getBody();
            echo $data;
            
        } 
        if($request->hasFile('voice'))
        {
             $file = $request->file('voice');
             // dd($file);
             //获取文件扩展名
            $file_ext = $file->getClientOriginalExtension(); 
            // dd($file_ext);         
            //重命名
            $file_name = time().rand(1000,9999). '.'.$file_ext;
            // dd($file_name);
            //音频类型
            $path = $file->storeAs('wechat/voice',$file_name);
            // dd($path);
            $path='./storage/'.$path;
              // dd($path);
            // 上传到微信
             $url='https://api.weixin.qq.com/cgi-bin/media/upload?access_token=' . $this->get_access_token().'&type=voice';
              // dd($url);
            $response = $client->request('POST',$url,[
                'multipart' => [
                    [
                        'name'     => 'media',  
                        'contents' => fopen(realpath($path), 'r')
                    ],
                ]
            ]);
         $re = $response->getBody();
         unlink($path);
         echo $re;
     }

     if($request->hasFile('video')){
        $file = $request->file('video');
        //获取视频扩展名
        $file_ext = $file->getClientOriginalExtension();
        //重命名
        $file_name = time().rand(1000,9999).'.'.$file_ext;
        // dd($file_name);
        //上传到框架
        $path = $file->storeAs('wechat/video',$file_name);
        //拼接上传到微信的路径
        $path = './storage/'.$path;
        //上传单微信
        $url =   $url='https://api.weixin.qq.com/cgi-bin/media/upload?access_token=' . $this->get_access_token().'&type=video';
        $response = $client->request('POST',$url,[
                'multipart' => [
                    [
                        'name'     => 'media',  
                        'contents' => fopen(realpath($path), 'r')
                    ],
                ]
            ]);

        $data = $response->getBody();
         unlink($path);
         echo $data;
     }
  
         
     
}


        /*
        *创建用户标签
        *
        */
        public function add_tag()
        {
            return view('Wechat/add_tag');
        }

         public function do_add_tag(Request $request)
        {
            $url = 'https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.$this->get_access_token();
            $data = [
                        'tag' => ['name'=>$request->all()['name']]
                    ];
            $re = $this->post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
             // dd(json_decode($re,1));
              return redirect('Wechat/tag_list');
        }

        //标签下粉丝列表
        public function tag_list(Request $request)
        {

            $url = 'https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$this->get_access_token();
            $data = file_get_contents($url);
             // dd($data);
            $data = json_decode($data,1)['tags'];
            // dd($data);
            return view('Wechat/tag_list',['data'=>$data]);
        }


        public function del_tag(Request $request)
        {
            $id = $request->all()['id'];
            $url = 'https://api.weixin.qq.com/cgi-bin/tags/delete?access_token='.$this->get_access_token();
            $data = [
                'tag'=>['id'=>$id]
            ];
            $res = $this->post($url,json_encode($data));
            $re = json_decode($res,1);
            // dd($re);
            if($re['errcode']==0){
                return redirect('Wechat/tag_list');
            }else{
                echo "程序错误,返回码为$re[errcode]";
            }
        }

        //为用户打标签
        public function set_tag(Request $request)
        {
            $data = $request->all()['x_box'];
            // dd($data);
            $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$this->get_access_token();

            $info = [
                'tagid'=>$request->all()['tag_id'],
                'openid_list'=>$data,
            ];
             // dd($info); 
           $res = $this->post($url,json_encode($info));

           $res = json_decode($res,1);
             // dd($res);
            return redirect('Wechat/tag_list');
          
           
        }


        public function user_tag_list(Request $request)
        {
            $url = 'https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token='.$this->get_access_token();
          $data = [
            'tagid' =>$request->all()['tagid'],
            'next_openid'=>'',
          ];
          // dd($data);
          $re = $this->post($url,json_encode($data));
          // dd($re);
          $re = json_decode($re,1)['data']['openid'];
           // dd($re);
          return view('Wechat/user_list',['re'=>$re]);
           
        }


        public function message(Request $request)
        {
            $id = $request->all()['tag_id'];
          // dd($tagid);
            $tagid = [];
            $tagid = [
                'tagid'=>$id
            ];
            // dd($tagid);
            return view('Wechat/message_list',['tagid'=>$tagid]);
        }

        public function push_message(Request $request)
        {
            $data = $request->all();
              // dd($data);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$this->get_access_token();
            // dd($url);
            $info=[
             'filter' => [
              "is_to_all"=>false,
               "tag_id"=>$data['tagid'],
            
                ],
            'text' => [
                "content"=>$data['content'],
            ],
                 "msgtype"=>"text",
             ];
             // dd($info);
             $re = $this->post($url,json_encode($info,JSON_UNESCAPED_UNICODE));
             // dd($re);
             $re = json_decode($re,1);
             dd($re);
            }

            public function seconds_user_list()
            {
                $data = DB::table('user')->get();
                // dd($data);
                return view('Wechat/seconds_user_list',['data'=>$data]);
            }


            public function seconds_qr(Request $request)
            {
                $id = $request->all()['id'];
                 // dd($id);
                $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->get_access_token();
                    // dd($url);
                $info = [
                // 'id'=>$id,
                "action_name"=>"QR_LIMIT_STR_SCENE", 
                "action_info"=> [
                        "scene"=> [
                            "scene_str"=> "test"
                        ]
                    ]
                ];
               
                
                 
                     // dd($info);
                   $res = $this->post($url,json_encode($info));
                    // dd($res);
                   $res = json_decode($res,1);
                         // dd($res);
                   $ticket = $res['ticket'];
                    // dd($ticket); 
                   $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket;
                    // dd($url);
                   $where = [];
                   $where = [
                    'user_id'=>$id,
                   ];
                   // dd($where);
                    $data = DB::table('user')->where($where)->update(['qrcode_url'=>$url]);

                    return redirect('Wechat/seconds_user_list');

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
                    $message = '欢迎xx同学进入选课系统!';
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




 // public function event()
 //        {
 //            $data = file_get_contents("php://input");
 //            //解析XML
 //            $xml = simplexml_load_string($data,'SimpleXMLElement', LIBXML_NOCDATA);        //将 xml字符串 转换成对象
 //            $xml = (array)$xml; //转化成数组
 //            $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
 //            file_put_contents(storage_path('logs/wx_event.log'),$log_str,FILE_APPEND);
 //            if($xml['MsgType'] == 'event'){
 //                if($xml['Event'] == 'subscribe'){ //关注
 //                    if(isset($xml['EventKey'])){
 //                        //拉新操作
 //                        $agent_code = explode('_',$xml['EventKey'])[1];
 //                        $agent_info = DB::table('user_agent')->where(['user_id'=>$agent_code,'openid'=>$xml['FromUserName']])->first();
 //                        if(empty($agent_info)){
 //                            DB::table('user_agent')->insert([
 //                                'user_id'=>$agent_code,
 //                                'openid'=>$xml['FromUserName'],
 //                                'add_time'=>time()
 //                            ]);
 //                        }
 //                    }
 //                    $message = '欢迎使用本公司提供的油价查询功能!';
 //                    $xml_str = '<xml>
 //                                <ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName>
 //                                <FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName>
 //                                <CreateTime>'.time().'</CreateTime>
 //                                <MsgType><![CDATA[text]]></MsgType>
 //                                <Content><![CDATA['.$message.']]></Content>
 //                                </xml>';
 //                    echo $xml_str;
 //                }
 //            }else if($xml['MsgType'] == 'text'){
 //                $key = '9413322aab050216f8c0b7c2aae862cc';
 //                $url = "http://apis.juhe.cn/cnoil/oil_city?key=$key";
 //                $info =file_get_contents($url);
 //                $info = json_decode($info,1);
 //                // dd($info);die;
 //                $result = $info['result'];
 //                // dd($result);die;
 //                $city=array_column($result,'city');
 //                // dd($city);die;
 //                $data = $xml['Content'];
 //                $sub_str = substr($data,0,-6);
 //                // dd($sub_str);
 //                $arry = [];
 //                   foreach($result as $v){
 //                     if($sub_str == $v['city']){
 //                            echo "<pre>";
 //                            // print_r($v);
 //                            $array = $v;
 //                     }
 //                }
 //                       // $message = $city.'目前油价：'."\n";
 //                        $message = $array['city'].'目前油价：'."\n".'92h：'.$array['92h']."\n".'95h：'.$array['95h']."\n".'98h：'.$array['98h']."\n".'0h：'.$array['0h'];
 //                        $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
 //                        echo $xml_str;die;
           
 //                $message = '宝塔镇河妖';
 //                $xml_str = '<xml>
 //                            <ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName>
 //                            <FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName>
 //                            <CreateTime>'.time().'</CreateTime>
 //                            <MsgType><![CDATA[text]]></MsgType>
 //                            <Content><![CDATA['.$message.']]></Content>
 //                            </xml>';
 //                echo $xml_str;
 //     }
 //     //echo $_GET['echostr'];  //第一次访问
 // }



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
   
             /**
             * 添加菜单
             */
          public function do_add_menu(Request $request)
    {
        $req = $request->all();
        //echo "<pre>";print_r($req);
        $data = [];
        $result = DB::table('menu')->insert([
            'menu_name' => $req['menu_name'],
            'second_menu_name'=>empty($req['second_menu_name'])?'':$req['second_menu_name'],
            'menu_type'=>$req['menu_type'],
            'event_type'=>$req['event_type'],
            'menu_tag'=>$req['menu_tag']
        ]);
        if($req['menu_type'] == 1){ //一级菜单
            //$first_menu_count = DB::connection('mysql_cart')->table('menu')->where(['menu_type'=>1])->count();
        }
        $this->reload_menu();
        return redirect('Wechat/menu_list');
    }

            

            public function menu_del(Request $request)
            {
                $id = $request->all()['id'];
                // dd($id);
                $where = [];
                $where = [
                    'menu_type'=>$id,
                ];
                // dd($where);
                $res = DB::table('menu')->where($where)->delete();
                // dd($res);
                if($res==1){
                    return redirect('Wechat/menu_list');
                }else{
                    echo "删除失败";
                }

            }

            /**
             * 自定义菜单查询接口
             */
            public function display_menu()
            {
                $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$this->get_access_token();
                $re = file_get_contents($url);
                echo "<pre>";
                print_r(json_decode($re,1));
            }


           public function reload_menu()
    {
        $menu_info = DB::table('menu')->groupBy('menu_name')->select(['menu_name'])->orderBy('menu_name')->get()->toArray();
        foreach($menu_info as $v){
            $menu_list = DB::table('menu')->where(['menu_name'=>$v->menu_name])->get()->toArray();
            $sub_button = [];
            foreach($menu_list as $k=>$vo){
                if($vo->menu_type == 1){ 
                //一级菜单
                    if($vo->event_type == 'view'){
                        $data['button'][] = [
                            'type'=>$vo->event_type,
                            'name'=>$vo->menu_name,
                            'url'=>$vo->menu_tag
                        ];
                    }else{
                        $data['button'][] = [
                            'type'=>$vo->event_type,
                            'name'=>$vo->menu_name,
                            'key'=>$vo->menu_tag
                        ];
                    }
                }
                if($vo->menu_type == 2){ //二级菜单
                    //echo "<pre>";print_r($vo);
                    if($vo->event_type == 'view'){
                        $sub_button[] = [
                            'type'=>$vo->event_type,
                            'name'=>$vo->second_menu_name,
                            'url'=>$vo->menu_tag
                        ];
                    }elseif($vo->event_type == 'media_id'){
                    }else{
                        $sub_button[] = [
                            'type'=>$vo->event_type,
                            'name'=>$vo->second_menu_name,
                            'key'=>$vo->menu_tag
                        ];
                    }
                }
            }
            if(!empty($sub_button)){
                $data['button'][] = ['name'=>$v->menu_name,'sub_button'=>$sub_button];
            }
        }
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->get_access_token();
        // dd($url);
        $re = $this->post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        echo json_encode($data,JSON_UNESCAPED_UNICODE).'<br/>';

        echo "<pre>"; print_r(json_decode($re,1));
    }
         

            public function menu_list()
            {
                $menu_info = DB::table('menu')->groupby('menu_name')->select('menu_name')->orderby('menu_name')->get()->toarray();
                // dd($menu_info);
                $info = [];
                foreach($menu_info as $k =>$v){
                    $sub_menu = DB::table('menu')->where(['menu_name'=>$v->menu_name])->orderby('menu_name')->get()->toarray();
                    if(!empty(($sub_menu[0]->second_menu_name))){
                        $info[] = [
                            'menu_str'=>'|',
                            'menu_name'=>$v->menu_name,
                            'menu_type'=>1,
                            'second_menu_name'=>'',
                            'menu_num'=>0,
                            'event_type'=>'',
                            'menu_tag'=>''
                        ];
                        foreach($sub_menu as $vo){
                            $vo->menu_str = '|-';
                            $info[] =(array)$vo;
                        }
                    }else{
                        $sub_menu[0]->$menu_str = '|';
                        $info[] = (array)$Sub_menu[0];
                    }
                }
                // dd($info);
                    $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$this->get_access_token();
                    $re = file_get_contents($url);
                    //print_r(json_decode($re,1));
                    return view('Wechat/menu_List',['info'=>$info]);

            }






         

            public function create_love()
            {
                return view('Wechat/create_love');
            }


            public function add_love()
            {
                $data = DB::table('wechat')->get();
                // dd($data);
                return view('Wechat/add_love',['data'=>$data]);
            }

             public function love_list()
            {
                return view('Wechat/love_list');
            }


            public function push_love(Request $request)
            {
                // echo intval((0.1+0.7)*10);

                $data = $request->all();
                // dd($data);
                $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$this->get_access_token();
                // dd($url);
                $info=[
                 'filter' => [
                  "is_to_all"=>false,
                   "tag_id"=>$data['openid'],
                
                    ],
                'text' => [
                    "content"=>$data['content'],
                ],
                     "msgtype"=>"text",
                 ];
                 // dd($info);1
                 $re = $this->post($url,json_encode($info,JSON_UNESCAPED_UNICODE));
                 // dd($re);
                 $re = json_decode($re,1);
                 dd($re);
            }


            




            public function fruit_add()
            {
                return view('fruit/fruit_add');
            }

              public function fruit_do_add(Request $request)
            {
                $data = $request->all();
                // dd($data);
                $result = DB::table('fruit')->insert(['fruit_name'=>$data['fruit_name'],'fruit_price'=>$data['fruit_price'],'fruit_address'=>$data['fruit_address'],'fruit_desc'=>$data['fruit_desc'],'create_time'=>time()]);
                return redirect('Wechat/fruit_list');
            }


            public function fruit_list(Request $request)
            {
                $fruit_name = $request->all();
                // dd($fruit_name);
                if(empty($fruit_name)){
                    $data = DB::table('fruit')->paginate(2);
                }else{
                    $data = DB::table('fruit')->
                }
                return view('fruit/fruit_list',['data'=>$data]);
            }

            public function fruit_del(Request $request)
            {
                $id = $request->all()['id'];
                // dd($id);
                $where = [];
                $where = [
                        'id'=>$id,
                    ];
                    // dd($where);
                $result = DB::table('fruit')->where($where)->delete();
                // dd($result);
                return redirect('Wechat/fruit_list');
            }



            public function fruit_update(Request $request)
            {
                $id = $request->all()['id'];
                // dd($id);   
                 $where = [];
                $where = [
                        'id'=>$id,
                    ];
                $data = DB::table('fruit')->where($where)->first();
                $data = get_object_vars($data);
                // dd($data['id']);     
                return view('fruit/fruit_update',['data'=>$data]);
            }


            public function fruit_do_update(Request $request)
            {
                $data = $request->all();
                // dd($data);
                    $where = [];
                $where = [
                        'id'=>$data['id'],
                    ];
                    // dd($where);
                $result = DB::table('fruit')->where($where)->update(['fruit_name'=>$data['fruit_name'],'fruit_price'=>$data['fruit_price'],'fruit_address'=>$data['fruit_address'],'fruit_desc'=>$data['fruit_desc']]);
                return redirect('Wechat/fruit_list');            
            }






}
