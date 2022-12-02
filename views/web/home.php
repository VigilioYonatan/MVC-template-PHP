<?php require_once __DIR__ . "/../layouts/webLayout.php"; ?>
<?php /* isset($user) && $user->hasError('nombre') ? "<div class=''>" . $user->getFirstError('nombre') . "</div> " : null */ ?>
<a href="/admin">Admin</a>
<form id="formulario">
    <div class="">
        <div class="">
            <label for="nombre">Nombre</label>
            <input type="file" multiple id="nombre" placeholder="digite nombre" name="nombre">

        </div>
    </div>
    <div class=''>
        <label for="email">Email</label>
        <select name="email" id="">
            <option value="">Seleccione una opcion</option>
            <option value="0">Laptop</option>
            <option value="1">Pc</option>
        </select>
    </div>
    <div class="">
        <label for="password">Contraseña</label>
        <input type="password" id="password" placeholder="digite Contraseña" name="password">
    </div>
    <div class="">
        <label for="repeatPassword">Repetir Contraseña</label>
        <input type="password" id="repeatPassword" placeholder="digite Contraseña" name="repeatPassword">
    </div>
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
<div id="cart"></div>
<div style="margin:2rem">
    <span>Carrito</span>
    <span style="background-color:red;padding:.1rem .35rem;border-radius:100%" id="carritoQTY"></span>
</div>
<div style="display:flex; gap:1rem" id="productos">
    <!-- <?php debuguear($productos); ?> -->
    <?php foreach ($productos as $producto) : ?>
    <div data-producto="<?= $producto["id"] ?>" style="display:flex;flex-direction:column;align-items:center">
        <img src="https://cdn.monstercat.com/share.png" width="120" alt="">
        <div style="display:flex;flex-direction:column;gap:.5rem;justify-content:center;align-items:center">
            <span style="font-weight:bold;color:white"><?= $producto["title"]; ?></span>
            <span style="font-weight:bold;color:red;font-size:1.5rem"
                class="btnPrecio"><?= $producto["precio"]; ?></span>
            <button
                style="font-weight:bold;color:white;font-size:1rem;background-color:#232B99;padding:.5rem 2rem;cursor:pointer">Add</button>

        </div>
    </div>
    <?php endforeach; ?>
</div>
</div>
<div id="pokemons"></div>
<?php require_once __DIR__ . "/../layouts/webFooter.php"; ?>