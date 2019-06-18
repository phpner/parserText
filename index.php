<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Парсер</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        body{
            height: 100vh;
            background: #e6e6e6;
            padding: 0;
            margin: 0;
        }
        .flex-box{
            display: flex;
            align-items: center;
            height: 85%;
            min-height: 750px;
            justify-content: center;
            flex-flow: row wrap;
        }
        #form{
            display: flex;
            flex-direction: column;
            min-width: 700px;

        }
        .red-box{
            margin-left: 22px;
            position: relative;
            height: 350px;
            width: 350px;
        }
        .textResult{
            background: white;
            height: 350px;
            width: 350px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0px 6px 2px rgba(187, 187, 187, 0.79);
            overflow-y: auto;
        }

        .red-box #resultat{
            position: absolute;
            top: -38px;
            width: 100%;
            text-align: center;
            font-size: 26px;
            background: #66b6e4;
            border-radius: 8px 8px 0 0;
            color: #fff;
            border-bottom: 5px solid #3b6680;
            padding: 8px 0;
        }
        .textResult #textResult{
            margin-top: 24px;
            padding-left: 15px;
        }
        #submit{
            width: 250px;
            margin: auto;
            height: 50px;
            border: none;
            background: #66b6e4;
            font-size: 21px;
            color: #fff;
            background-color: #66b6e4;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.73);
            border-radius: 8px;
            cursor: pointer;
            transition: all .4s;
            outline: none;
        }
        #submit:hover{
            background-color: #5298bf;
        }
        .sub-box{
            padding: 20px 0;
        }
        .found{
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }
        .found p{
            margin-left: 15px;
            color: #ffffff;
            font-weight: 900;
            background: #66b6e4;
            padding: 5px 11px;
        }
        h1{
            text-align: center;
            margin: 0;
            background: #cacaca;
            font-size: 46px;
            padding: 15px 0;
            flex: 100%;
        }
    </style>
</head>
<body>
<h1>Парсер</h1>
<div class="flex-box">

    <form id="form">
        <textarea name="text" id="textChearch" cols="30" rows="10" required="required" placeholder="Текст для поиска"></textarea>
        <div class="sub-box">
            <label for="all"><input id="all"  type="radio" name="sub" value="all" checked="checked"> все</label> <br>
            <label for="sub"> <input id="sub"  type="radio" name="sub" value="sub">Только с "Согласие на новостную подписку"</label> <br>
                <label for="nosub"> <input id="nosub" type="radio" name="sub" value="nosub">Только без "Согласие на новостную подписку"</label> <br>
        </div>
        <input id="submit" type="submit" value="Найти">
    </form>
    <div class="red-box">
        <span id="resultat">Результат</span>
        <div class="textResult">
            <div id="textResult"></div>
        </div>
        <div class="found">
            <span>Кол-во найдено</span>
            <p id="infound"></p>
        </div>
    </div>

</div>
<script>
    var form = document.getElementById('form');

    var textResult = document.getElementById('textResult');

    form.addEventListener('submit',function (event) {
        event.preventDefault();
        var textResult = document.getElementById('textResult');
        var textChearch = document.getElementById('textChearch');
        var sub = document.querySelector("input[type=radio]:checked").value;
        console.log(sub);
        var infound = document.getElementById('infound');
        sub = sub;
        textChearch = JSON.stringify(textChearch.value);

        var post = "text="+textChearch+"&sub="+sub;
        // 1. Создаём новый объект XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // 2. Конфигурируем его: GET-запрос на URL 'phones.json'
        xhr.open('POST', 'finder.php', false);

        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=utf-8');

        // 3. Отсылаем запрос
        xhr.send(post);

        // 4. Если код ответа сервера не 200, то это ошибка
        if (xhr.status != 200) {
            // обработать ошибку
            console.log( xhr.status + ': ' + xhr.statusText ); // пример вывода: 404: Not Found
        } else {
            // вывести результат
            var resData = xhr.responseText;
            console.log(resData);
            var result = JSON.parse(resData);
            if (result.status === "no"){
                textResult.innerHTML = "Ничего не найдено!!!";
                infound.innerHTML = 0;
            }else {
                //console.log(result); // responseText -- текст ответа.
                var innerHTML ="";
                for (var d in result.result){
                    console.log(result.result[d]);
                    innerHTML += result.result[d].person+"<br>";
                }
                textResult.innerHTML = innerHTML;

                infound.innerHTML = result.coll;
            }

        }
        // console.log(textResult);
    });

</script>
</body>
</html>