<?php
header("Content-type: text/html; charset=utf-8"); 
session_start();
error_reporting(E_ALL || ~E_NOTICE);
require_once('./conn.php');
$max=10;
$name=$_POST['name'];
$class=$_POST['class'];
$yzm=$_POST['yanz'];
$yanztrue=$_SESSION['ycode'];
//echo $yzm;
//echo $yanztrue;
//exit;
$url="../index.html";
//$err="验证码错误";
Header("HTTP/1.1 303 See Other");
if($name==""||$class==""){
   echo "<script> alert('是不是忘记填写姓名或者分数了，真粗心！！'); </script>";
	echo "<meta http-equiv='Refresh' content='0;URL=$url'>";
	exit;
} 
if(!preg_match("/^[A-Za-z]{1,10}$/",$name)){
   echo "<script> alert('请输入1到10个字符的英文名'); </script>";
	echo "<meta http-equiv='Refresh' content='0;URL=$url'>";
	exit;
} 
else
if(!preg_match("/^\d{1,4}$/",$class)){
   echo "<script> alert('请输入4位以内的数字'); </script>";
	echo "<meta http-equiv='Refresh' content='0;URL=$url'>";
	exit;
} 
if($_SESSION['ycode']!==trim(strtolower($yzm)))
{  
	echo "<script> alert('验证码错误！！'); </script>";
	echo "<meta http-equiv='Refresh' content='0;URL=$url'>";  
	//echo "<script>confirm('{$err}') {";
    exit;

    //header(string)der("Location: $url"); 
    //exit;    
//echo "} </script>";
}

else
	
	conn();
$arr=array();
	mysql_select_db('count');
    //$sql_s="select * from goldpoint order by time desc limit 1";
	$sql_i="insert into goldpoint(name,score)values('$name','$class')";
	$sql_d="DELETE FROM `goldpoint`";
	$sql="select * from goldpoint";

	$result = mysql_query($sql) or  die (mysql_error());
	//print_r($result);
	//exit;
	while($row = mysql_fetch_array($result,MYSQL_ASSOC))
	
	{
		$arr[]=$row;
}
	$array_name=array_column($arr,'name');
	$array_score=array_column($arr,'score');
	$exists_name=in_array($name,$array_name);
	$exists_score=in_array($class,$array_score);
	$count=count($array_name);
	//echo "$count";
	//exit;
	if ($exists_name||$exists_score) {
	   	  echo "<script> alert('用户名或者预估数已存在，请重新输入！'); </script>";
		  echo "<meta http-equiv='Refresh' content='0;URL=$url'>";
		  exit;
	   } 
	   	else if($count>=$max){
	   		 mysql_query($sql_d) or  die (mysql_error());
	   		 echo "<script> alert('本轮游戏已经结束！请重新玩'); </script>";
		  	 echo "<meta http-equiv='Refresh' content='0;URL=$url'>";
		  	 exit;
	   }
	   else
	      
 	//print_r($row);
 	mysql_query($sql_i) or  die (mysql_error());
	//$sql_i="insert into goldpoint(name,score)values('$name','$class')";
   
    $sum=array_sum($array_score);
    $ave=$sum/$count;
    $last_point=$ave*0.618;
		for ($i=0; $i <$count ; $i++) { 
	$arr2[]=abs($last_point-$array_score[$i]);
}

	$min= min($arr2);
		for ($i=0; $i <$count ; $i++) { 
			if ($min==$arr2[$i]) {
		echo "你的之前选手最接近答案是".$array_score[$i];
		echo "他的名字是".$array_name[$i]."<br>";
	}
}
    echo"最新黄金点的值：";//array_name[0],array_score[0]
    echo($last_point);


    //mysql_select_db('count');
	//$sql_s="select * from counting order by time desc limit 1";
	//$result = mysql_query($sql) or  die (mysql_error());
	//$rows = mysql_fetch_array($result);

	//$names_cn=$row["name"];
	//$classs_cn=$row["class"];
?>
