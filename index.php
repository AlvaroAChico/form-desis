<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Productos</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/script.js" defer></script>
</head>
<body>
    <div class="header-container">
        <h1 class="header__title">Formulario de Producto</h1>
        <form id="productForm" class="form-container">
            <div class="form-container__group">
                <label for="code" class="form-container__label">Código:</label>
                <input type="text" id="code" name="code" class="form-container__input neutral">
            </div>

            <div class="form-container__group">
                <label for="name" class="form-container__label">Nombre:</label>
                <input type="text" id="name" name="name" class="form-container__input neutral">
            </div>

            <div class="form-container__group">
                <label for="winery" class="form-container__label">Bodega:</label>
                <select id="winery" name="winery" class="form-container__select neutral">
                    <option value="">Seleccione una Bodega</option>
                </select>
            </div>

            <div class="form-container__group">
                <label for="branch" class="form-container__label">Sucursal:</label>
                <select id="branch" name="branch" class="form-container__select neutral">
                    <option value="">Seleccione una Sucursal</option>
                </select>
            </div>

            <div class="form-container__group">
                <label for="currency" class="form-container__label">Moneda:</label>
                <select id="currency" name="currency" class="form-container__select neutral">
                    <option value="">Seleccione una Moneda</option>
                </select>
            </div>

            <div class="form-container__group">
                <label for="price" class="form-container__label">Precio:</label>
                <input type="text" id="price" name="price" class="form-container__input neutral">
            </div>

            <div class="form-container__group full-width">
                <label class="form-container__label">Material:</label>
                <div id="materials" class="form-container__checkbox-group">
                </div>
            </div>

            <div class="form-container__group full-width">
                <label for="description" class="form-container__label">Descripción del Producto:</label>
                <textarea id="description" name="description" class="form-container__textarea neutral"></textarea>
            </div>

            <div class="full-width">
                <button type="submit" class="form-container__button">Guardar Producto</button>
            </div>
        </form>
    </div>
</body>
</html>
