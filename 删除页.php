<?php 
if(empty($_GET['id'])){
	exit('<h1>必须指定参数</h1>');
}

$id=$_GET['id'];


$data = json_decode(file_get_contents('jsondata.json'),true);

foreach ($data as $item) {
	if(implode($item['id'])!==$id){
		continue;
	} 
	$index = array_search($item, $data);//搜索相同的id数据位置
	array_splice($data, $index,1);
    $json = json_encode($data);//把删除后剩下的数据进行编译
    file_put_contents('jsondata.json', $json);//更新源文件
    header('Location:音乐列表.php');

}

 ?>





<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>音乐列表</title>
	<link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
	<div class="container py-5">
		<h1 class="display-4">音乐列表</h1>
		<hr>
		<div class="mb-3"><a href="添加音乐.php" class="btn btn-danger btn-sm" target="_blank">添加</a></div>
		<table class="table  table-striped table-hover " >
			<thead style="background-color: #8896d8">
				<tr>
					<th class="text-center">标题</th>
					<th class="text-center">歌手</th>
					<th class="text-center">海报</th>
					<th class="text-center">音乐</th>
					<th class="text-center">操作</th>
				</tr>
			</thead>
			<tbody class="text-center">
				<?php foreach ($data as $item): ?>
				<tr>
					<?php if(isset($item['title'])): ?>
					<td class="text-center"><?php echo $item['title'] ?></td>
				<?php endif ?>
				<?php if(isset($item['artist'])): ?>
					<td class="text-center"><?php echo $item['artist'] ?></td>
				<?php endif ?>
				<?php if(isset($item['images'])): ?>
					<td class="text-center"><img src="<?php echo implode($item['images']) ?>" alt="" style="width: 60px;height: 30px;"></td>
				<?php endif ?>
				<?php if(isset($item['songs'])): ?>
					<td class="text-center"><audio src="<?php echo implode($item['songs']) ?>" controls></audio></td>
				<?php endif ?>
					<td><a class="btn btn-danger btn-sm" href="删除页.php?id=<?php echo implode($item['id']); ?>">删除</a></td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
	</div>
</body>
</html>