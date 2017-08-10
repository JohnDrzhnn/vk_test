<!DOCTYPE html>
<html> 
<head> 
	<title>Получаем данные о пользователе с API VK</title> 
	<script src="https://vk.com/js/api/openapi.js?146" type="text/javascript"></script> 
	<script type="text/javascript"> 
		VK.init({apiId: 6140193}); 
	</script> 
	
	<!-- bootstrap -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css"> 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> 
	<script src="https://use.fontawesome.com/30212a9805.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head> 
<body> 
	<header>
		<div class="container">
			<div class="row text-center">
				<div class="col-lg-12">
					<div class="well">
						<h2 style="margin:0;">Получим данные о пользователе с API VK</h2>
					</div>
				</div>
			</div>
		</div>
	</header>
<div class="container">
	<div class="row">
		<div class="thumbnails">
			<div class="col-lg-6">
				<div class="thumbnail text-center">
				    <a href="/test/js.php"><i class="fa fa-vk fa-5x" aria-hidden="true"></i></a>
				    <h3>Через JS запрос</h3>
				    <div class="alert alert-danger" style="margin-bottom: 12px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  Всплывающие окна браузера не должны блокироваться</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="thumbnail text-center">
				   	<div id="vk_auth" style="margin: 0 auto;"></div>
				    <h3>JS и немного PHP</h3>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
 VK.Widgets.Auth('vk_auth', {authUrl: '/test/php.php'});
</script>

</body> 
</html>
