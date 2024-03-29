<?php
namespace Home\Controller;
use Common\Controller\HomeBaseController;
class PublicController extends HomeBaseController {

 
    public function _initialize(){
        parent::_initialize();

    }
    
    public function findDevice(){
        $device_id = I("device_id");
        $device_res = $device = D("device")->where(array("device_id"=>$device_id))->find();
        $pest_res = $pest = D("pest_data")
                        ->where(array("device_code"=>$device_res['device_code']))
                        ->order("addtime desc")
                        ->find();
						
		$pest_res['code'] = $device_res['device_code'];
        $this->ajaxReturn($pest_res);
    }
    
    public function header(){
       
        $this->display();
    }
    public function footer(){
        $this->display();
    }
    public function device_header(){
        
        $this->display("Public/device_header");
    }
    public function device_footer(){
        $this->assign("name",111);
        $this->display("Public/device_footer");
    }
     public function _meat(){
        $this->display();
    }
    public function _footer(){
        $this->display();
    }
    public function incompatible(){
        $this->display();
    }
    public function message(){
        $waitSecond = 3;
        $jumpUrl = U('Index/index');
        $this->assign(array("waitSecond"=>$waitSecond,"jumpUrl"=>$jumpUrl));
        $this->display();
    }
    public function error(){
        $this->display();
    }
    
    /* 
    *功能：php完美实现下载远程图片保存到本地 
    *参数：文件url,保存文件目录,保存文件名称，使用的下载方式 
    *当保存文件名称为空时则使用远程文件原来的名称 
    */ 
    function getImage($url,$save_dir='',$filename='',$type=1){ 
        if(trim($url)==''){ 
            return array('file_name'=>'','save_path'=>'','error'=>1); 
        } 
        if(trim($save_dir)==''){ 
            $save_dir='./'; 
        } 
        
        if(trim($filename)==''){//保存文件名 
            $ext=strrchr($url,'.'); 
            if($ext!='.gif'&&$ext!='.jpg'){ 
                return array('file_name'=>'','save_path'=>'','error'=>3); 
            } 
            $filename=time().$ext; 
        } 
        
        if(0!==strrpos($save_dir,'/')){ 
            $save_dir.='/'; 
        } 
        
        //创建保存目录 
        if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){ 
            return array('file_name'=>'','save_path'=>'','error'=>5); 
        } 
        
        //获取远程文件所采用的方法  
        if($type){ 
            $ch=curl_init(); 
            $timeout=5; 
            curl_setopt($ch,CURLOPT_URL,$url); 
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout); 
            $img=curl_exec($ch); 
            curl_close($ch); 
        }else{ 
            ob_start();  
            readfile($url); 
            $img=ob_get_contents();  
            ob_end_clean();  
        } 
//        var_dump($img);
        //$size=strlen($img); 
        //文件大小  
        $fp2=@fopen($save_dir.$filename,'a');
        
        fwrite($fp2,$img);
        
        fclose($fp2); 
        unset($img,$url); 
        return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0); 
    } 
    
    
}
