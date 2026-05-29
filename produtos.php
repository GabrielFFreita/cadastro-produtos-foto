<?php
require_once "conexao.php";

try{
    $sql = "SELECT * FROM produtos";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

catch (PDOException $e) {
    echo "Erro ao buscar produtos: " . $e->getMessage();
    exit; 
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>HeratSushi - Catálogo</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Spectral:wght@400;700&family=Urbanist:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <h1 class="logo">HeartSushi</h1>
        <div class="nav-links">
            <a href="index.html" class="btn-link">Adicionar Produto</a>
            <a href="listagem_produtos.php" class="btn-link">Listar Produtos</a>
        </div>
    </nav>

    <main class="container-catalogo">
        <h2 class="titulo-pagina">Nosso Cardápio</h2>
        
        <div class="cards-grid">
            <?php foreach ($produtos as $produto): ?>
                <div class="product-card">
                    
                    <div class="card-image-box">
                        <?php if (!empty($produto['ds_image'])): ?>
                            <img src="uploads/<?php echo $produto['ds_image']; ?>" alt="<?php echo $produto['nome']; ?>">
                        <?php else: ?>
                            <div class="no-image-placeholder">
                                <span>Sem imagem</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-info">
                        <h3 class="product-title"><?php echo $produto['nome']; ?></h3>
                        <p class="product-description"><?php echo $produto['descricao']; ?></p>
                        
                        <div class="card-footer">
                            <span class="product-price">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span>
                          
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </main>

</body>
</html>