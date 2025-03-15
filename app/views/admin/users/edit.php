<?php

use App\Helpers\UrlHelper;

  var_dump($user);

?>

<form action="<?= UrlHelper::route('admin/users/edit/' . $user['id']) ?>" method="post">

  <button type="submit" class="px-2 py-1.5 bg-teal-500 border-none outline-none rounded-md text-white">SAVE</button>
</form>