<?php
include_once 'backend/RedirectHelper.php';
$link = isset($_GET["url"]);
if ($link) {
  RedirectHelper::redirect("backend/server.php?url=".$_GET["url"], 'server');
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <?php echo $link ? '<meta http-equiv="refresh" content="10; url=\''.$full.'\'">' : ''; ?>
    <title>HotShort: generator of short-links.</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <h2>HotShort.Me</h2>
    <h3>Ваш собственный генератор коротких ссылок</h3>
    <div>
      <form action="/backend/server.php" method="post" id="main">
        <label for="full">Введите полный URL в это поле: </label>
        <input type="text" id='full' name="full" placeholder="URL for resource" size="36"/> 
        <button id="sendURL" formaction="/backend/server.php">Получить краткий URL</button><br/>
        <label for="url">Краткий URL:</label> 
        <input type="text" id='url' size="15" placeholder="Short URL" />
        <button id="redirectTo" formaction="<?php $base_url.'/'.$_GET["url"] ?>">Перейти по краткому URL</button>
      </form>
    </div>
    <div class="hided">
      <h3>Идёт перенаправление...</h3>
      <p>Если в течение 10 секунд не произошо перенаправления, кликните <a href='<?php $full ?>'>сюда</a>.</p>
      <p>Для возврата к форме генерации коротких ссылок кликните <a href='index.php'>сюда</a>.</p>
      <p>Если вам не нужно ничего из предложенного, то Вам <a href="https://www.google.com/">точно сюда</a>.</p>  
    </div>
    
    <script src="js/jquery.min.js"></script>
    <script>
      var url = document.getElementById('full'); // $('#full');
      var shortcut = document.getElementById('url'); //$('#url');
      var redirector = document.querySelector('#redirectTo');
      
      window.sessionStorage.setItem('full', url.value);
      window.sessionStorage.setItem('url', shortcut);
      
      var act = "";
      
      $(redirector).click(()=>{
        act = 'redirect';
      });
      
      $('#sendURL').click(() => {
        act = 'send';
        $('#main').attr('action', $(this).val());
      });
      
      $('#main').submit( (event) => {
        if (act === 'redirect'){
          return true;
        }
        
        window.sessionStorage.setItem('full', url.value);
        $.getJSON('/backend/server.php', {full: url.value}, 
            (responce) => {
              window.sessionStorage.setItem('url', responce.shortcut);
              //document.location.reload();
              url.value = window.sessionStorage.getItem('full');
              shortcut.value = responce.shortcut;
            });
        event.preventDefault();
      });
    </script>
  </body>
</html>
