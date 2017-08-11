# vk_test
Два способа получение ID (и прочей информации) пользователя Вконтакте. Оба способа заключаются в регистрации приложении на стороне контакта, подключении api контакта в шапке нужного сайта, а после вытаскивание информации js запросом. 

>**Обратите внимание!**
>
>Нужно разрешить всплывающие окна в браузере

подключаем api
```js
<script src="https://vk.com/js/api/openapi.js?146" type="text/javascript">
```
далее там же в шапке указываем id приложения через которое собираемся работать
```js
VK.init({apiId: id приложения});
```

Есть несколько способов получить нужную информацию - либо сделать js запрос, либо через виджет вк.
___

## js
Делаем запрос 
```js
VK.Auth.login(function (response) {}); 
```
после чего вернется массив response.session.user с данными о пользователе - id, first_name, last_name, href.
Заполним ранее созданную таблицу html страницу этими данными (каждая ячейка таблицы содежит свой ID)
```js
VK.Auth.login(function (response) { 
  //console.log(response);
  document.getElementById('id').innerHTML=response.session.user.id;
  document.getElementById('firstname').innerHTML=response.session.user.first_name;
  document.getElementById('lastname').innerHTML=response.session.user.last_name;
  document.getElementById('ahref').href=response.session.user.href;
}); 
```
добавим небольшую проверку, если всплывающие окна заблокированы

```js
if($.isEmptyObject(response.session)){
	alert ("Разблокируйте всплывающие окна!")
}
```
___
## js c добавлением php
кидаем на страницу див с id="vk_auth" а так же js, который подхватывает этот див и делает из него форму авторизации, так же в js указываем конечную страницу, куда перейдем после авторизации
```html
<div id="vk_auth"></div>
```
```js
VK.Widgets.Auth('vk_auth', {authUrl: '/test/php.php'});
```
После авторизации в адресной строке содержится информация (id, first_name, last_name, photo и т.д.), вытаскиваем нужную нам информацию  и присваиваем им переменные
```php
$id = $_GET['uid'];
$firstname = $_GET['first_name'];
$lastname = $_GET['last_name'];
$nickname = $_GET['nick_name'];
$photo = $_GET['photo'];
$hash = $_GET['hash'];
```
заносим данные в html таблицу
```html
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
```
___
## Прочая информация
Больше информации о пользователе можно вытащить вызвав функцию VK.Api.call указав в ней метод, ид интересующего пользователя и параметры. Для примера запросим информацию о высшем образовании, для этого используем метод users.get, в параметрах указываем 'education' (можно указать несколько параметров через запятую). 

На странице присутсвет кнопка "Информация об институте" нажимая ее запускаем скрипт moreinfo

```js
function moreinfo() { 
	var uid = $('#id').text(); //-- получаем id пользователя вконтакте
	VK.Api.call('users.get', {uids: uid, fields: 'education'}, function(r) {
		if (r.response) {
			//console.log (r.response);
        	var mass = r.response; 
          $.ajax({
        	url: '/test/post.php', 
        	type: 'POST',
        	data: {myarray: mass},
        	dataType: 'json',
        	success: function(json){
                if(json) $('#more_info').html(json);
            }
        });
    }});
}
```
отправим аяксом полученную информацию на обработчик post.php (так делать небезопасно, но у нас информация не секретная), где переведем значения, составим красивую таблицу и вернем ее обратно на страницу.
```php
//-- т.к. параметры приходят на англ. языке, то создадим массив с переводом значений
$translate =  array( 
  "university_name" => "Университет:",
  "faculty_name" => "Факультет:",
  "graduation" => "Год выпуска:",
  "education_form" => "Форма обучения:",
  "education_status" => "Статус:",
);
if(isset($_POST['myarray'])){
    ob_start();  //-- включаем буффер 
    $arTrans = array();  //-- создадим массив, куда будем записывать переведенные фразы и значения
    foreach ($_POST['myarray'][0] as $k => $v) { //-- переберем массив с исходными данными
        foreach ($translate as $kTrans => $vTrans) { //-- переберем массив с переводом
            if($k == $kTrans) { //-- найдем схожие значения
                $arTrans[$vTrans] = $v; //-- соберем массив, куда положим перевод и исходное значение
            }
        }
    }
    <div class="col-lg-12"> <!-- генерим таблицу -->
        <table class="table table-striped">
        <tr>
            <th colspan="2" class="text-center">Информация об институте</th>
        </tr>
        <?foreach ($arTrans as $k => $v) {?>
                <tr>
                    <td><?echo $k;?></td>
                    <td><?echo $v;?></td>
                </tr>
            <?}?>
        </table>
    </div>
    <?
    $cont = ob_get_contents(); //-- сохраняем все что записали в переменную $cont
    ob_end_clean(); //-- отключаем и очищаем буффер
    echo json_encode($cont); //--возвращаем json запрос
    exit;
}
```
---
таким образом с помощью api вк, нескольких запросов и прямых рук можно получить практически всю информацию о пользователе вк, вплоть до количества лайков на его стене. 
Из минусов - api требуются всплывающие окна, которые блокируются в браузерах у большиства людей. 
