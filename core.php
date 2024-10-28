<?php
include 'db.php';

function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function getWineries() {
    try {
        $db = new Database();
        $pdo = $db->getDbConnection();
        $stmt = $pdo->query("SELECT winery_id AS wineryId, winery_name AS wineryName FROM wineries");
        $bodegas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($bodegas);
    } catch (PDOException $e) {
        echo json_encode(["message" => "Error: " . $e->getMessage()]);
    } finally {
        $db->closeConnection();
    }
}

function getBranches() {
    try {
        $db = new Database();
        $pdo = $db->getDbConnection();
        $wineryId = isset($_GET['wineryId']) ? sanitizeInput($_GET['wineryId']) : null;

        if (!is_numeric($wineryId)) {
            echo json_encode(["message" => "ID de bodega inválido."]);
            return;
        }

        $stmt = $pdo->prepare("SELECT branch_id AS branchId, branch_name AS branchName FROM branches WHERE winery_id = :wineryId");
        $stmt->bindParam(':wineryId', $wineryId, PDO::PARAM_INT);
        $stmt->execute();

        $sucursales = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($sucursales);
    } catch (PDOException $e) {
        echo json_encode(["message" => "Error: " . $e->getMessage()]);
    } finally {
        $db->closeConnection();
    }
}

function getCurrencies() {
    try {
        $db = new Database();
        $pdo = $db->getDbConnection();
        $stmt = $pdo->query("SELECT currency_id AS currencyId, currency_name AS currencyName FROM currencies");
        $monedas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($monedas);
    } catch (PDOException $e) {
        echo json_encode(["message" => "Error: " . $e->getMessage()]);
    } finally {
        $db->closeConnection();
    }
}

function getMaterials() {
    try {
        $db = new Database();
        $pdo = $db->getDbConnection();
        $stmt = $pdo->query("SELECT material_id, material_name FROM materials");
        $materials = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($materials);
    } catch (PDOException $e) {
        echo json_encode(["message" => "Error: " . $e->getMessage()]);
    } finally {
        $db->closeConnection();
    }
}


function validateExistProduct() {
    try {
        $db = new Database();
        $pdo = $db->getDbConnection();
        $productId = isset($_GET['productId']) ? sanitizeInput($_GET['productId']) : null;

        $stmt = $pdo->prepare("SELECT * FROM PRODUCTS WHERE product_id = :productId");
        $stmt->bindParam(':productId', $productId, PDO::PARAM_STR);
        $stmt->execute();
        
        $monedas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($monedas);
    } catch (PDOException $e) {
        echo json_encode(["message" => "Error: " . $e->getMessage()]);
    } finally {
        $db->closeConnection();
    }
}

function saveProduct() {
    try {
        $db = new Database();
        $pdo = $db->getDbConnection();
        
        $code = isset($_POST['code']) ? sanitizeInput($_POST['code']) : null;
        $name = isset($_POST['name']) ? sanitizeInput($_POST['name']) : null;
        $price = isset($_POST['price']) ? sanitizeInput($_POST['price']) : null;
        $winery = isset($_POST['winery']) ? sanitizeInput($_POST['winery']) : null;
        $branch = isset($_POST['branch']) ? sanitizeInput($_POST['branch']) : null;
        $currency = isset($_POST['currency']) ? sanitizeInput($_POST['currency']) : null;
        $description = isset($_POST['description']) ? sanitizeInput($_POST['description']) : null;
        
        if ($code === null || $name === null || $price === null || $winery === null || $branch === null || $currency === null || $description === null) {
            echo json_encode(["message" => "Todos los campos son obligatorios."]);
            return;
        }

        $stmt = $pdo->prepare("INSERT INTO products (product_code, product_name, price, winery_id, branch_id, currency_id, description) VALUES (:code, :name, :price, :wineryId, :branchId, :currencyId, :description)");
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':wineryId', $winery, PDO::PARAM_INT);
        $stmt->bindParam(':branchId', $branch, PDO::PARAM_INT);
        $stmt->bindParam(':currencyId', $currency, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

        $stmt->execute();
        $productId = $pdo->lastInsertId();

        if (isset($_POST['materials']) && is_array($_POST['materials'])) {
            foreach ($_POST['materials'] as $materialId) {
                $stmt = $pdo->prepare("INSERT INTO product_materials (product_id, material_id) VALUES (:productId, :materialId)");
                $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':materialId', $materialId, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        echo json_encode(["message" => "Producto guardado exitosamente."]);
    } catch (PDOException $e) {
        echo json_encode(["message" => "Error al guardar el producto: " . $e->getMessage()]);
    } finally {
        $db->closeConnection();
    }
}

if (isset($_GET['action'])) {
    switch (sanitizeInput($_GET['action'])) {
        case 'getWineries':
            getWineries();
            break;
        case 'getBranches':
            getBranches();
            break;
        case 'getCurrencies':
            getCurrencies();
            break;
        case 'getMaterials':
            getMaterials();
            break;
        case 'validateExistProduct':
            validateExistProduct();
            break;
        case 'saveProduct':
            saveProduct();
            break;
        default:
            echo json_encode(["message" => "Acción no válida"]);
    }
}
?>
