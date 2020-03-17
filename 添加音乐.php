<?php 
//构造处理函数
function add(){

	if(empty($_POST['title'])){
		$GLOBALS['error_message'] = '请输入音乐标题';//根据name属性获得
		return;
	}
	if(empty($_POST['artist'])){
		$GLOBALS['error_message'] = '请输入创作歌手';
		return;
	}
	$data['title'] = $_POST['title'];
	$data['artist'] = $_POST['artist'];
	
	if(empty($_FILES['images'])){
		$GLOBALS['error_message'] = '请正常使用表单';
		return;
	}
	if(empty($_FILES['songs'])){
		$GLOBALS['error_message'] = '请正常使用表单';
		return;
	}



	$images = $_FILES['images'];//把上传的图片放到images变量中
	$songs = $_FILES['songs'];//把上传的歌曲放在songs变量中
	$data['images'] =array();//把images里面的东西存到一个空数组中


	for($i=0;$i < count($images['name']);$i++){
		if($images['error'][$i]!==UPLOAD_ERR_OK){
			$GLOBALS['error_message'] = '上传海报文件失败';// 使用for循环遍历images对象下的name属性，并判断其是否全部上传成功
			return;
		}
		if(strpos($images['type'][$i], 'image/')!== 0){
		$GLOBALS['error_message'] = '上传海报文件格式错误';//在for循环内部判断上传文件类型
		return;
		}
		if($images['size'][$i] > 10*1024*1024){
		$GLOBALS['error_message'] = '上传海报文件过大';//判断文件大小
		return;
		}
		$dest ='./uploads/' . uniqid() . $images['name'][$i];
		if(!move_uploaded_file($images['tmp_name'][$i], $dest)){//把临时路径中的文件转移到指定文件夹
		$GLOBALS['error_message'] = '上传海报文件失败';
		return;
		}
	}
    $data['images'][] = $dest;

    if($songs['size'] > 10 *1024 * 1024){
		$GLOBALS['error_message'] = '上传音乐文件过大';
		return;
    }
     if($songs['size'] < 1 *1024 * 1024){
		$GLOBALS['error_message'] = '上传音乐文件过小';
		return;
    }
    $allowed_type = array('audio/mp3','audio/wma');
    if(!in_array($songs['type'], $allowed_type)){
    	$GLOBALS['error_message'] = '不支持的格式';
    	return;
    }

    if($songs['error']!== UPLOAD_ERR_OK){
    	$GLOBALS['error_message'] = '上传音乐文件失败';
    	return;
    }
    $target = './uploads/' . uniqid() . '-' . $songs['name'];
    if(!move_uploaded_file($songs['tmp_name'], $target)){
    	$GLOBALS['error_message'] = '上传音乐文件失败';
    	return;
    }

    $data['songs'][] = $target;
    $data['id'][] = uniqid();
    $jsonold = file_get_contents('jsondata.json');
    $old = json_decode($jsonold,true);
    array_push($old, $data);
    $new_json = json_encode($old);
    file_put_contents('jsondata.json', $new_json);

    header('Location:音乐列表.php');


	
}


 
//首先判断上传方式
if ($_SERVER['REQUEST_METHOD'] ==='POST') {
	add();
}

 ?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加新音乐</title>
	<link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
	<div class="container">
			<h1 class="display-4">添加新音乐</h1>
		<hr>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="title">标题</label>
				<input type="text" id="title" name="title" class="form-control">
			</div>
			<div class="form-group">
				<label for="artist">歌手</label>
				<input type="text" id="artist" name="artist" class="form-control">
			</div>
			<div class="form-group">
				<label for="images">海报</label>
				<input type="file" id="images" name="images[]" multiple="multiple" class="form-control"><!-- 提交多个文件 -->
			</div>
			<div class="form-group">
				<label for="songs">歌曲</label>
				<input type="file" id="songs" name="songs" class="form-control" accept="audio/*">
			</div>
			<?php if (isset($error_message)):?>
			<p style="color:red"><?php echo $error_message; ?></p>
		<?php endif ?>
			<button class="btn btn-primary btn-block">提交</button>
		</form>
	</div>
		
	</div>
</body>
</html>