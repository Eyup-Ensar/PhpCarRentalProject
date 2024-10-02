<?php if(!Session::get("adminAd") || !Session::get("adminId")): ?>
<!DOCTYPE html>
<html>
<head>
<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo URL; ?>/views/design/js/sweetalert.js"></script>
<script src="<?php echo URL; ?>/views/design/js/jquery.min.js"></script>
<script src="<?php echo URL; ?>/views/design/js/bizim.js"></script>
<script src="<?php echo URL; ?>/views/design/js/menu.js"></script>
<link href="<?php echo URL; ?>/views/design/css/menu.css" rel="stylesheet"/>
</head>
<body>

<div class="container mt-3" style="padding:50px">
<?php echo isset($veri["bilgi"]) ? $veri["bilgi"] : null; ?>

  <h2>Giriş Yap</h2>
  <form method="post" action="<?php echo URL; ?>/admin/giriskontrol">
    <div class="mb-3 mt-3">
      <label for="username">Kullanıcı Adı:</label>
      <input type="text" class="form-control" id="username" name="adminAd" required="required">
    </div>
    <div class="mb-3">
      <label for="password">Parola:</label>
      <input type="password" class="form-control" id="password" name="adminSifre" required="required">
    </div>
    <div class="d-grid">
  <button type="submit" name="buton" value="Giriş Yap" class="btn btn-primary btn-light">Giriş Yap</button>
</div>
  </form>
</div>
</body>
</html>
<?php else: header('Location: '.URL.'/kiralar/kiraListele'); endif; ?>
