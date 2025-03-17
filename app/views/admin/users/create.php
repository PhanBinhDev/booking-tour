<?php

use App\Helpers\UrlHelper;
?>
<form action="<?= UrlHelper::route('admin/users/create') ?>" method="POST">
  <button type="submit">Create</button>
</form>