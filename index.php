<?php
    $os = strtolower(substr(PHP_OS,0,3))==='win'?'win':'*nix';
    define('OS',$os);
    $rootdir = [];
    if(OS==='win'){
        $dir_temp = range('C','Z');
        foreach($dir_temp as $rdir){
            if(is_dir($rdir.':/')){
                $rootdir[] = $rdir.':/';
            }
        }
        // print_r($rootdir);
    }else{
        $rootdir[] = '/';
    }
    if(isset($_GET['mkdir'])){
        $current = (isset($_GET['dir']) && in_array(substr($_GET['dir'],0,strpos($_GET['dir'],'/')+1),$rootdir)) ? rtrim($_GET['dir'],'/\\').'/':$rootdir[0];
    }
    $contents = scandir($current);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>服务器文件操作</title>
<style type="text/css">
.nav span{
    margin-right:10%;
}
.fl{
    float:left;
}
.fr{
    float:right;
}
div:after{
    content: "020"; 
    display: block; 
    height: 0; 
    clear: both; 
    visibility: hidden;  
}
</style>
</head>
<body>
<div class="nav">
当前系统：<span><?=PHP_OS?></span>
磁盘：
<?php if(OS=='win'){?>
<select name="rootdir" onchange="location.href='<?=basename(__FILE__).'?dir='?>'+this.value;">
    <?php foreach($rootdir as $rv){?>
    <option value="<?=$rv;?>" <?php if(substr($current,0,strpos($current,'/')+1)==$rv) echo 'selected="selected"';?>><?=$rv?></option>
    <?php }?>
</select>
<?php }?>
</div>
<div class="operate">
    <table style="margin:10px;padding:20px;">
        <tr>
            <th>文件名</th><th>操作</th>
        </tr>
        <tr colspan="20">
            <button>新增文件夹</button><button style="margin-left:5%;">新增文件</button><button style="margin-left:5%;">上传文件</button>
        </tr>
    <?php foreach($contents as $rdf){?>
        <tr>
            <td>
            <?php $nowdirs = strtr(realpath($current.$rdf.'/'),'\\','/')?>
            <?php if(is_dir($nowdirs)){?>
                <a href="<?=basename(__FILE__).'?dir='.$nowdirs?>"><?=$rdf?></a>
            <?php }else{?>
                <span><?=$rdf?></span>
            <?php }?>
            </td>
            <td>
                <button style="color:red;">删除</button>
                <button style="color:green;" >查看</button>
                <button style="color:blue;">编辑</button>
            </td>
        </tr>
    <?php }?>
    </table>
</div>
<script style="text/javascript">

</script>
</body>
</html>
