<form method="POST">
    <div class="">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" value="<?= $user->nombre; ?>" placeholder="digite nombre" name="usuario[nombre]">
        <?= isset($user) && $user->hasError('nombre') ? "<div class=''>" . $user->getFirstError('nombre') . "</div> " : null ?>
    </div>

    </div>
    <div class=''>
        <label for="email">Email</label>
        <input type="text" id="email" value="<?= $user->email; ?>" placeholder="digite email" name="usuario[email]">
        <?= isset($user) && $user->hasError('email') ? "<div class=''>" . $user->getFirstError('email') . "</div> " : null ?>

    </div>
    <div class="">
        <label for="password">Contraseña</label>
        <input type="password" id="password" value="<?= $user->password; ?>" placeholder="digite Contraseña"
            name="usuario[password]">
        <?= isset($user) && $user->hasError('password') ? "<div class=''>" . $user->getFirstError('password') . "</div> " : null ?>

    </div>
    <button type="submit">Editar</button>
</form>