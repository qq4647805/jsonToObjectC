<?php 
error_reporting(0);
$url='http://123.57.233.174/api/ucarshow/getBrandList';
$str=file_get_contents($url);

$data=json_decode($str,true);
// exit;
createDocReturn($data);
function fiterData($data,$key){
// 	if($key && in_array($key, array('constellation','name','consultingTime','ios_ver','android_ver','account','rule','explain_app','group_id','context'))){
// 		$data=(string)$data;
// 		return;
// 	}
// 	if($key && in_array($key, array('lat','lng'))){
// 		$data=(float)$data;
// 		return;
// 	}
// 	// 	if($key && in_array($key, array('time','number','status','leftSeat'))){
// 	// 		$data=(int)$data;
// 	// 		return;
// 	// 	}
	if(is_numeric($data) && is_int($data+0)){
		echo 'num '.$key.'<br>';
		return;
	}
	if(is_string($data)){
		echo 'str '.$key.'<br>';
		return;
	}
// 	if(is_null($data) && $data!==0){
// 		if(in_array($key, array('infoList','lists','commentList','take_place','back_place','comments','classify','tradeArea'))){
// 			$data=array();
// 		}else{
// 			$data='';
// 		}
// 		return;
// 	}
	if(is_array($data)){
		if(is_string($data)){
			echo 'obj '.$key.'<br>';
		}else{
			echo 'arr '.$key.'<br>';
		}
		foreach ($data as $key=>$value) {
			fiterData($value,$key);
		}
		return;
	}
}
function createDocReturn($data,$key=null,$level=0){

	if(!$level){
		echo '<pre>'.PHP_EOL;
		echo '&emsp;&nbsp;* @return ';
	}else{
		echo '&emsp;&emsp;&emsp;';
		for ($i = 0; $i < $level; $i++) {
			echo '&emsp;&emsp;';
		}
	}
	$level++;
// 	if($key && is_string($key)){
// 		$key='"'.$key.'"';
// 	}else{
// 		$key='';
// 	}
	$ptype=gettype($data);

	switch($ptype)
	{
		case 'integer':
// 			echo $key.'  {int}'.PHP_EOL;
			echo "@property (nonatomic, strong) NSNumber *{$key};".PHP_EOL;
			break;
		case 'array':
		case 'object':
			foreach ($data as $k => $value) {
				if(is_string($k)){
// 					echo $key.'  {object}'.PHP_EOL;
					echo "@property (nonatomic, strong) NSDictionary *{$key};".PHP_EOL;
					$obj=true;
					break;
				}
			}
			if(!$obj){
// 				echo $key.'  {array}'.PHP_EOL;
				echo "@property (nonatomic, strong) NSArray *{$key};".PHP_EOL;
			}
			foreach ($data as $k => $value) {
				createDocReturn($value,$k,$level);
			}
			break;
		default:
// 			echo $key.'  {'.$ptype.'}'.PHP_EOL;
			echo "@property (nonatomic, strong) NSString *{$key};".PHP_EOL;
	}
	if(!$level){
		echo '</pre>';
	}
}
?>