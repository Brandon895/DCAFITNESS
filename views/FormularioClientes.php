<form action="index.php?controller=Cliente&action=<?= isset($cliente) ? 'update' : 'store'; ?>" method="post">
    <input type="hidden" name="cedula" value="<?= $cliente['cedula'] ?? ''; ?>">
    <input type="text" name="nombre" placeholder="Nombre" value="<?= $cliente['nombre'] ?? ''; ?>" required>
    <input type="text" name="apellidos" placeholder="Apellidos" value="<?= $cliente['apellidos'] ?? ''; ?>" required>
    <input type="email" name="correo" placeholder="Correo" value="<?= $cliente['correo_electronico'] ?? ''; ?>" required>
    <button type="submit"><?= isset($cliente) ? 'Actualizar' : 'Guardar'; ?></button>
</form>
