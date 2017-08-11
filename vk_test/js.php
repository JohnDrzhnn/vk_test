<!DOCTYPE html>
<html> 
<head> 
	<title>Данные о пользователе VK через js</title> 
	<script src="https://vk.com/js/api/openapi.js?146" type="text/javascript">//--подключаем апи вконтакте</script> 
	<script type="text/javascript"> 
		VK.init({apiId: 6140193}); //--указываем номер приложения
	</script> 

	
	<!-- бутстрап -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> 
	<script src="https://use.fontawesome.com/30212a9805.js"></script>

</head> 
<body> 
	<script type="text/javascript"> 
		VK.Auth.login(function (response) { //-- запросим информацию
			//console.log(response);
			if($.isEmptyObject(response.session)){ //--проверим заблокированы ли окна, если да, то объект придет пустой
				alert ("Разблокируйте всплывающие окна!")
			}
			document.getElementById('id').innerHTML=response.session.user.id; //отобразим данные в таблице
			document.getElementById('firstname').innerHTML=response.session.user.first_name;
			document.getElementById('lastname').innerHTML=response.session.user.last_name;
			document.getElementById('ahref').href=response.session.user.href;
		}); 
	</script> 

	<header>
		<div class="container">
			<div class="row text-center">
				<div class="col-lg-12">
					<div class="well">
						<h2 style="margin: 0;">Получим данные о пользователе с API VK через JS запрос</h2>
					</div>
				</div>
			</div>
		</div>
	</header>


	<div class="container">
		<div class="bs-callout bs-callout-info">
			<div class="row">      
				<div class="col-lg-12">
					<table class="table table-striped">
						<tr>
							<th colspan="2" class="text-center">Общая информация</th>
						</tr>
						<tr>
							<td>ID:</td>
							<td id="id"></td>
						</tr>	
						<tr>
							<td>Имя:</td>
							<td id="firstname"></td>
						</tr>
						<tr>
							<td>Фамимлия:</td>
							<td id="lastname"></td>
						</tr>
						<tr>
							<td>Ссылка на профиль:</td>
							<td><a id="ahref" href="#">тут</a></td>
						</tr>
					</table>
				</div>
				<div class="col-lg-12 text-center"><input type="submit" class="btn btn-default" value="Информация об институте" id="btn_sbmt"></div>
				<div id="more_info"></div>
				<div class="col-lg-12 text-right"><a href="#" onclick="history.back();return false;">Назад</a></div>
			</div>
		</div>
	</div>
</body>
</html>


<script>
document.getElementById('btn_sbmt').onclick = this.moreinfo; //-- ждем события клик и начинаем выполнять функцию moreinfo
function moreinfo() { 
	var uid = $('#id').text(); //-- получаем id пользователя вконтакте
	VK.Api.call('users.get', {uids: uid, fields: 'education'}, function(r) { //-- отправялем запрос на данные, которые хотим получить
		if (r.response) {
			console.log (r.response);
			document.getElementById('btn_sbmt').style.display = 'none'; //-- скроем кнопку
        	var mass = r.response; //-- полученный массив данных и запишем в переменную
        $.ajax({ //--отправим массив аяксом на обработчик
        	url: '/test/post.php', 
        	type: 'POST',
        	data: {myarray: mass},
        	dataType: 'json',
        	success: function(json){
                if(json) $('#more_info').html(json); //-- при успехе получим результат и выведем его 
            }
        });
    }});
}
</script>


<!-- доп стили -->
<style type="text/css">
	.bs-callout {
		padding: 20px;
		margin: 20px 0;
		border: 1px solid #eee;
		border-left-width: 5px;
		border-radius: 3px;
	}
	.bs-callout-danger {
		border-left-color: #d9534f;
	}
	.bs-callout-warning {
		border-left-color: #f0ad4e;
	}
	.bs-callout-info {
		border-left-color: #5bc0de;
	}
	.bs-callout h4 {
		margin-top: 0;
		margin-bottom: 5px;
	}
	.bs-callout-danger h4 {
		color: #d9534f;
	}
	.bs-callout-warning h4 {
		color: #f0ad4e;
	}
	.bs-callout-info h4 {
		color: #5bc0de;
	}
</style>
	
