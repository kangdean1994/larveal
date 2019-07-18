<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pay;
use DB;
class PayController extends Controller
{
    public $app_id;
    public $gate_way;
    public $notify_url;
    public $return_url;
    public $rsaPrivateKeyFilePath = '';  //路径
    public $aliPubKey = '';  //路径
    public $privateKey ='MIIEpQIBAAKCAQEA3IRSPvipT43yh47lxn7JfggUNPjBYoBioQgk/SvuTQC0/UOQrXLGrwkUMyjjRSq4dkIgsPuusknXZFcvYj3MfpNfQUf2R77M9p8t/ZyqXgmIhoXD0T41U4iDbKeWeKR7DWiF9/tfnoHgz/nlUAhH3REpA2u2MiZZdmw8trbN2Sa4RUAabcoSdXXmoyw93szsUIq/isF/7Ynj/7XwESDjyX0esOjiq//kqzf/HXDvaLV475jcBoQ+njQJUGnGPWeIRPtHuSKdqRNk+MvyZqkkJ4QXQrQEy9idAzfQ+iS+FU8tu+BvTU/PGvS43IqqC9o/4fFTcf/pMQfJ0A8NKHl+sQIDAQABAoIBAQCAz2Jjmkj8SYRkHtqliiYU0o9LKgt8iFYUjndc066NmF4gmrkGOEdKs1jzUW0AWCYMHjCOcVXomy2QVUU+c67iOR+pOGnqGtALN4xb2onCCHuRaM2rilUICHQMohBJRHsEqAupgVKnemJh2i1TBKNFxOJaNy7kOHaFsE/+wuWXc+rCgrGZavzemvA0A0+r9YhLchiVIRmS6vkC5oG9fVy9FsHoUvXZgiXTUSTaXgXWglYB84m5mNHrICCY3UhYxgmEN5fasVA2OEf5JpWqsZCpH35HRe+MWty+sXGGjIMwFUW4JN4Z7veZwAUwhJgUUTOFDExD6TM+hVfJ5+KGRkthAoGBAPmEWZVsmlWLvPTcXqxBv7nn6ZABXOZxeLzgSxmr4DV7NWX7jSoRNkQ0ZAkIraC4cSkpwzPQUfC+WzeT3jkUdo0w5azFGV9CgfgXsvJlOfg6wFhUiFEIvSI80SpYnQY+3bTRQYBJLMvKu1Ze0QFlh0YyUAi07AjSDRJyWQf3v60dAoGBAOI/FBlQHlKP7YOQnPEEp7ydEXNS0GSMa5dZMrbOHTyzSYilmO9KIF1NJZImjvVe2wLhmltlDo69ooVco0vaKdH2uFhLDkQ4vnSqwOyGHR+uwn4c3AMHy7GZirhkbA/B1/LUDeLkwNIrwS6zo5ZEY1HqXyxgkf1Xhp/HUVWtNaelAoGBAKCJjPHc3DeqHrsUhj0iWG8OTXH/znveCibL0MYFlc4TJbol7R9hz552bt55HO1JflVTr2pI4E+ayimqE9J53gTdrwhIEBkAO4saBGJ8yp1xf4vVZ5drnfTHWHR8axs3m4HZGOGnMxEzsPDTNHpHjo+Vk3Tmou7R5uM1ex7rQgHpAoGBAIUV4+XL+jpIzcdhjuA8A8twfW5gHZO4AiYiYzGjZxFoyW2nM6I28XjQw7QIGHn/1UcJnHn8pSaUKIDYcHpTF9yZi/DsHbVFx8rrEtdPQNx9OY1jvovNzyVmk3JKKELQnQ4LbSu1sjMvZ9Dn/OeMzPvHqTp6iAYFsXxVi+OhIvm9AoGABOSGVADlIb18LWGTC7OvHfOMEEOwEqagK0xpIYKs6vdb+qHieqYlUZ1gTxJ/6CwH4/si3TxF+MoE6tX42lSiIDC9Z4PL1sQ1C7SPJ7VFRODIKnZmxO8ma13Tm77wWzXwHs1V/3P5MQf3R6sniJXGJoDgIUQXkXHQFR0XIXVZGD8=';
    public $publicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA3IRSPvipT43yh47lxn7JfggUNPjBYoBioQgk/SvuTQC0/UOQrXLGrwkUMyjjRSq4dkIgsPuusknXZFcvYj3MfpNfQUf2R77M9p8t/ZyqXgmIhoXD0T41U4iDbKeWeKR7DWiF9/tfnoHgz/nlUAhH3REpA2u2MiZZdmw8trbN2Sa4RUAabcoSdXXmoyw93szsUIq/isF/7Ynj/7XwESDjyX0esOjiq//kqzf/HXDvaLV475jcBoQ+njQJUGnGPWeIRPtHuSKdqRNk+MvyZqkkJ4QXQrQEy9idAzfQ+iS+FU8tu+BvTU/PGvS43IqqC9o/4fFTcf/pMQfJ0A8NKHl+sQIDAQAB';
    public function __construct()
    {					
						 
        $this->app_id = '2016101100657599';
        $this->gate_way = 'https://openapi.alipaydev.com/gateway.do';
        $this->notify_url = env('APP_URL').'/notify_url';
        $this->return_url = env('APP_URL').'/return_url';
    }

    public function do_pay(Request $request){
        $id = $request->all('id');
        // dd($id);
        $where = [['id','=',$id]];
        // dd($where);
        $data =DB::table('order')->where($where)->first();
        // dd($data);
       // $this->ali_pay($oid);
	   $order = [
            'out_trade_no' => "$data->oid",
            'total_amount' => "$data->pay_money",
            'subject' => 'test subject - 测试',
        ];
		return Pay::alipay()->web($order);
    }
    
	
    public function rsaSign($params) {
        return $this->sign($this->getSignContent($params));
    }
    protected function sign($data) {
    	if($this->checkEmpty($this->rsaPrivateKeyFilePath)){
    		$priKey=$this->privateKey;
			$res = "-----BEGIN RSA PRIVATE KEY-----\n" .
				wordwrap($priKey, 64, "\n", true) .
				"\n-----END RSA PRIVATE KEY-----";
    	}else{
    		$priKey = file_get_contents($this->rsaPrivateKeyFilePath);
            $res = openssl_get_privatekey($priKey);
    	}
        
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        if(!$this->checkEmpty($this->rsaPrivateKeyFilePath)){
            openssl_free_key($res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }
    public function getSignContent($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                // 转换成目标字符集
                $v = $this->characet($v, 'UTF-8');
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset ($k, $v);
        return $stringToBeSigned;
    }

    

    /**
     * 根据订单号支付
     * [ali_pay description]
     * @param  [type] $oid [description]
     * @return [type]      [description]
     */
    public function ali_pay($oid){
        $order = [];
        $order_info = $order;
        //业务参数
        $bizcont = [
            'subject'           => 'Lening-Order: ' .$oid,
            'out_trade_no'      => $oid,
            'total_amount'      => 10,
            'product_code'      => 'FAST_INSTANT_TRADE_PAY',
        ];
        //公共参数
        $data = [
            'app_id'   => $this->app_id,
            'method'   => 'alipay.trade.page.pay',
            'format'   => 'JSON',
            'charset'   => 'utf-8',
            'sign_type'   => 'RSA2',
            'timestamp'   => date('Y-m-d H:i:s'),
            'version'   => '1.0',
            'notify_url'   => $this->notify_url,        //异步通知地址
            'return_url'   => $this->return_url,        // 同步通知地址
            'biz_content'   => json_encode($bizcont),
        ];
        //签名
        $sign = $this->rsaSign($data);
        $data['sign'] = $sign;
        $param_str = '?';
        foreach($data as $k=>$v){
            $param_str .= $k.'='.urlencode($v) . '&';
        }
        $url = rtrim($param_str,'&');
        $url = $this->gate_way . $url;
        dd($url);
        header("Location:".$url);
    }
    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;
        return false;
    }
    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    function characet($data, $targetCharset) {
        if (!empty($data)) {
            $fileType = 'UTF-8';
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
            }
        }
        return $data;
    }
    /**
     * 支付宝同步通知回调
     */
    public function aliReturn()
    {
        header('Refresh:2;url=/order_list');
        echo "<h2>订单： ".$_GET['out_trade_no'] . ' 支付成功，正在跳转</h2>';
    }
    /**
     * 支付宝异步通知
     */
    public function aliNotify()
    {
        $data = json_encode($_POST);
        $log_str = '>>>> '.date('Y-m-d H:i:s') . $data . "<<<<\n\n";
        //记录日志
        file_put_contents(storage_path('logs/alipay.log'),$log_str,FILE_APPEND);
        //验签
        $res = $this->verify($_POST);
        $log_str = '>>>> ' . date('Y-m-d H:i:s');
        if($res){
            //记录日志 验签失败
            $log_str .= " Sign Failed!<<<<< \n\n";
            file_put_contents(storage_path('logs/alipay.log'),$log_str,FILE_APPEND);
        }else{
            $log_str .= " Sign OK!<<<<< \n\n";
            file_put_contents(storage_path('logs/alipay.log'),$log_str,FILE_APPEND);
            //验证订单交易状态
            if($_POST['trade_status']=='TRADE_SUCCESS'){
                
            }
        }
        
        echo 'success';
    }
    //验签
    function verify($params) {
        $sign = $params['sign'];
        if($this->checkEmpty($this->aliPubKey)){
            $pubKey= $this->publicKey;
            $res = "-----BEGIN PUBLIC KEY-----\n" .
                wordwrap($pubKey, 64, "\n", true) .
                "\n-----END PUBLIC KEY-----";
        }else {
            //读取公钥文件
            $pubKey = file_get_contents($this->aliPubKey);
            //转换为openssl格式密钥
            $res = openssl_get_publickey($pubKey);
        }
        
        
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');
        //调用openssl内置方法验签，返回bool值
        $result = (bool)openssl_verify($this->getSignContent($params), base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        
        if(!$this->checkEmpty($this->aliPubKey)){
            openssl_free_key($res);
        }
        return $result;
    }
}
