<?php /* @var $this Controller */ ?>
<?php /* @var $content string */ ?>
<!DOCTYPE html>
<html lang="ru">
<head>
 <meta charset="utf-8">
 <title><?= $this->pageTitle; ?></title>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta name="Description" content="">
 <meta name="Keywords" content="">
 <!-- Bootstrap -->
 <link href="/bootstrap/css/bootstrap.css" rel="stylesheet">
 <link href="/css/style.css" rel="stylesheet">
 <!--[if lt IE 9]>
 <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
 <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
 <![endif]-->
 <script src="/js/jquery-1.10.2.min.js"></script>
 <script src="/bootstrap/js/bootstrap.min.js"></script>
 <script>
  $(function() {
   $('[data-toggle="tooltip"]').tooltip();
  });
 </script>
</head>
<body>
<div class="container">
 <h1 class="main-h"><?= Yii::app()->name; ?></h1>
 <?= $content; ?>
</div>
</body>
</html>
