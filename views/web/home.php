<form method="POST">
    <div class="">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" placeholder="digite nombre" name="nombre">
        <?= isset($user) && $user->hasError('nombre') ? "<div class=''>" . $user->getFirstError('nombre') . "</div> " : null ?>
    </div>

    </div>
    <div class=''>
        <label for="email">Email</label>
        <input type="text" id="email" placeholder="digite email" name="email">
        <?= isset($user) && $user->hasError('email') ? "<div class=''>" . $user->getFirstError('email') . "</div> " : null ?>

    </div>
    <div class="">
        <label for="password">Contraseña</label>
        <input type="password" id="password" placeholder="digite Contraseña" name="password">
        <?= isset($user) && $user->hasError('password') ? "<div class=''>" . $user->getFirstError('password') . "</div> " : null ?>

    </div>
    <button type="submit">Agregar</button>
</form>
<div class="">
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>nombre</th>
                <th>email</th>
                <th>passowrd</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $key => $user) : ?>
            <tr>
                <td><?= $key + 1; ?></td>
                <td><?= $user->nombre; ?></td>
                <td><?= $user->email; ?></td>
                <td><?= $user->password; ?></td>
                <td>
                    <a href="/editar?id=<?= $user->id ?>">Editar</a>
                    <a href="?eliminar=<?= $user->id; ?>" style='background-color:red;'>Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>