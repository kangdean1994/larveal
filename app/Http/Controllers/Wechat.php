<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Tools\WechatController;
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
		$req = $request->all();
		  	// dd($req);
		$code = $req['code'];
		 // dd($code);
		 //获取access_token
		 $url = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."&code=".$code."&grant_type=authorization_code");
			// dd($url);
		 // $re = file_get_contents($url);
		 $result = json_decode($url ,1);
		 $access_token = $result['access_token'];
		 $openid = $result['openid'];
		  // dd($openid);
		  $data = DB::table('wechat_user')->where('openid','=',$openid)->first();
		 // dd($data);
		  if($data){
		  	 $url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->get_access_token();
            $data=[
                'touser'=>$openid,
              'template_id' => 'aSerVr6uQPlcmRpA_sCqBrvhjq3EehsK26I-3dVU7B4',
               
                'data'=>[
                    'first'=>[
                        "value"=>"欢迎",
                        "color"=>""
                    ]
                ]
            ];
            $re=$this->post($url,json_encode($data));

		  	$request->session()->put('data',$data);
		  	return redirect('wechat/upload_source');
		  }else{
		  	$res = DB::table('wechat_user')->insert(['openid'=>$openid]);
		  	// dd($res);
		  	if($res){
		  		$request->session()->put('res',$res);
		  		return redirect('wechat/upload_source');
		  	}else{
		  		echo "失败";
		  	}
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
    	  return redirect('wechat/');
    }


    public function get_user_list(Request $request)
    {		
        $tag_id = $request->all()['tag_id'];
          // dd($tag_id);
    	$access_token = $this->get_access_token();
    	$data = DB::table('wechat')->get();
      
    	return view('wechat/wechat_list',['data'=>$data,'tag_id'=>$tag_id]);
    	
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
        return view('wechat/wechat_pro',['data'=>$data]);
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
   
    

    public  function upload_source()
    {

        
    	return view('wechat/uploadSource');
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
            return view('wechat/add_tag');
        }

         public function do_add_tag(Request $request)
        {
            $url = 'https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.$this->get_access_token();
            $data = [
                        'tag' => ['name'=>$request->all()['name']]
                    ];
            $re = $this->post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
             // dd(json_decode($re,1));
              return redirect('wechat/tag_list');
        }

        //标签下粉丝列表
        public function tag_list(Request $request)
        {

            $url = 'https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$this->get_access_token();
            $data = file_get_contents($url);
            // dd($data);
            $data = json_decode($data,1)['tags'];
            // dd($data);
            return view('wechat/tag_list',['data'=>$data]);
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
                return redirect('wechat/tag_list');
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
            return redirect('wechat/tag_list');
          
           
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
          return view('wechat/user_list',['re'=>$re]);
           
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
            return view('wechat/message_list',['tagid'=>$tagid]);
        }

        public function push_message(Request $request)
        {
            $data = $request->all();
             // dd($data);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$this->get_access_token();
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
             $re = json_decode($re,1);
             dd($re);
            }

            public function seconds_user_list()
            {
                $data = DB::table('user')->get();
                // dd($data);
                return view('wechat/seconds_user_list',['data'=>$data]);
            }


            public function seconds_qr(Request $request)
            {
                $id = $request->all()['id'];
                 // dd($id);
                $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->get_access_token();
                    // dd($url);
                $info = [
                // 'id'=>$id,
                "action_name"=>"QR_LIMIT_SCENE", 
                "action_info"=> [
                        "scene"=> [
                            "scene_id"=> 123
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
                //将XML字符串转换成对象
                $xml = simplexml_load_string($data,'SimpleXMLElement',LIBXML_NOCDATA);
                //再转换成数组
                $xml = (array)$xml;
                $log_str = date('Y-m-d H:i:s').'\n'.$data."\n<<<";
                
                 file_put_contents(storage_path('logs/wx_event.log'),$log_str,FILE_APPEND);
                  
                if($xml['MsgType']=='event'){
                    if($xml['Event']=='subscribe'){
                        //关注
                        if(isset($xml['Eventkey'])){
                            //拉新操作
                            $agent_code = explode('_',$xml['Eventkey'])[1];
                            $agent_info = DB::table('user_agent')->where(['user_id'=>$agent_code,'openid'=>$xml['FormUserName']])->first();
                            if(empty($agent_info)){
                                DB::table('user_agent')->insert([
                                'user_id'=>$agent_code,
                                'openid'=>$xml['FormUserName'],
                                'add_time'=>time()
                                    ]);
                            }
                        }
                        $message = '娃哈哈';
                       
                        $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                        echo $xml_str;
                    }
                        
                }elseif($xml['MsgType']=='text'){
                    $message = '娃哈哈!';
                    $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                    echo $xml_str;
                }
                //echo $_GET['echostr'];  //第一次访问
            }

















}
