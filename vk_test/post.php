<? //-- т.к. параметры приходят на англ. языке, то создадим массив с переводом значений
    $translate =  array( 
            "university_name" => "Университет:",
            "faculty_name" => "Факультет:",
            "graduation" => "Год выпуска:",
            "education_form" => "Форма обучения:",
            "education_status" => "Статус:",
    );
?>

<?if(isset($_POST['myarray'])){
    ob_start();  //-- включаем буффер 
    $arTrans = array();  //-- создадим массив, куда будем записывать переведенные фразы и значения
    foreach ($_POST['myarray'][0] as $k => $v) { //-- переберем массив с исходными данными
        foreach ($translate as $kTrans => $vTrans) { //-- переберем массив с переводом
            if($k == $kTrans) { //-- найдем схожие значения
                $arTrans[$vTrans] = $v; //-- соберем массив, куда положим перевод и исходное значение
            }
        }
    }
    ?>
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
}?>