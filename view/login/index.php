<!DOCTYPE html>
<html>
  
  <head>
    <meta charset="utf-8">
    <title>
      Bootstrap, from Twitter
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link rel="stylesheet" href="bootstrap.css">
 <script src="jquery.js"></script>
  </head>
  
 
  <body>
    <div class="container">
      <div class="row-fluid">
      </div>
      <div class="row-fluid">
        <div class="span4">
        </div>
        <div class="span4" style="margin-top: 100px">
		
		<form action="logar.php" method="post">
		
          <div class="control-group">
            <label class="control-label">
              Login
            </label>
            <div class="controls">
              <input id="input_login" name="login" type="text">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">
              Senha
            </label>
            <div class="controls">
              <input id="input_senha" name="senha" type="password">
            </div>
          </div>
          <button id="btn_login" value="botao" name="btn" type="submit" class="btn">
            Entrar
          </button>
        
		</div>
		
		</div>
        <div class="span4">
        </div>
      </div>
    </div>
  </body>

</html>