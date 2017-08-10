<!DOCTYPE html>
<html>
<head> 
  <title>Данные о пользователе VK через php</title> 
  <script src="https://vk.com/js/api/openapi.js?146" type="text/javascript">//--подключаем апи вконтакте</script> 
  <script type="text/javascript"> 
    VK.init({apiId: 6140193}); //указываем номер приложения
  </script> 

  <!-- бутстрап -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css"> 
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> 
  <script src="https://use.fontawesome.com/30212a9805.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
</head> 
<body>
  <header>
    <div class="container">
      <div class="row text-center">
        <div class="col-lg-12">
          <div class="well">
            <h2 style="margin: 0;">Получим данные о пользователе с API VK через php</h2>
          </div>
        </div>
      </div>
    </div>
  </header>
<div class="container">
    <div class="bs-callout bs-callout-info">
      <div class="row">      
      <?//-- может записать в массив? 
        $id = $_GET['uid'];
        $firstname = $_GET['first_name'];
        $lastname = $_GET['last_name'];
        $nickname = $_GET['nick_name'];
        $photo = $_GET['photo'];
        $hash = $_GET['hash'];
      ?>
   
          <div class="col-lg-4">
            <img src="<?echo $photo;?>" class="img-responsive" style="margin: 0 auto;">
          </div>
          <div class="col-lg-8">
            <table class="table table-striped">
              <tr>
                <th colspan="2" class="text-center">Общая информация</th>
              </tr>
              <tr>
                <td>ID:</td>
                <td><?echo $id?></td>
              </tr> 
              <tr>
                <td>Имя:</td>
                <td><?echo $firstname?></td>
              </tr>
              <tr>
                <td>Фамимлия:</td>
                <td><?echo $lastname?></td>
              </tr>
              <?if(!empty($nickname)){?>
              <tr>
                <td>Ник</td>
                <td><?echo $nickname?></td>
              </tr>
              <?}?>
              <tr>
                <td>Хеш:</td>
                <td><?echo $hash?></td>
              </tr>
              <tr>
                <td>Ссылка на профиль:</td>
                <td><a href="https://vk.com/id<?echo $id?>">тут</a></td>
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
  VK.Api.call('users.get', {uids: <?echo $id;?>, fields: 'education'}, function(r) { //-- отправялем запрос на данные, которые хотим получить
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


