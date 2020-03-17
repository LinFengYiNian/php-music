<?php 
$data = json_decode(file_get_contents('jsondata.json'),true);
foreach ($data as $item) {
	$id=$item['id'];
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
		<div class="mb-3"><a href="添加音乐.php" class="btn btn-danger btn-sm" target="_self">添加</a></div>
		<table class="table  table-striped table-hover  " >
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
					<td style="vertical-align: middle;"><?php echo $item['title'] ?></td>
				<?php endif ?>
				<?php if(isset($item['artist'])): ?>
					<td style="vertical-align: middle;"><?php echo $item['artist'] ?></td>
				<?php endif ?>
				<?php if(isset($item['images'])): ?>
					<td ><img src="<?php echo implode($item['images']) ?>" alt="" style="width: 80px;height: 60px;"></td>
				<?php endif ?>
				<?php if(isset($item['songs'])): ?>
					<td ><audio src="<?php echo implode($item['songs']) ?>" controls></audio></td>
				<?php endif ?>
					<td style="vertical-align: middle;"><a class="btn btn-danger btn-sm" href="删除页.php?id=<?php echo implode($item['id']); ?>">删除</a></td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
	</div>
</body>
</html>