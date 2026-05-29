<?php
require_once "conexao.php";

//Aqui verificamos se o ID veio na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: listagem_produtos.php");
    exit;
}

$id = intval($_GET['id']);

// Aqui fazemos a procura no banco de dados

try {
    $sql = "SELECT * FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se o produto não for encontrado, redireciona de volta
    if (!$produto) {
        header("Location: listagem_produtos.php");
        exit;
    }
    
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>HeratSushi - Editar Produto</title>
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Spectral:wght@400;700&family=Urbanist:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <h1 class="logo">HeartSushi</h1>
        <div class="nav-links">
            <a href="listagem_produtos.php" class="btn-link">Cancelar e Voltar</a>
        </div>
    </nav>

    <main class="container">
        <div class="form-card">
            <h2>Editar Produto</h2>
            
            <form action="atualizar_produto.php" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">

                <div class="input-group">
                    <label>Nome do Produto</label>
                    <input type="text" name="nome" required value="<?php echo htmlspecialchars($produto['nome']); ?>">
                </div>

                <div class="input-group">
                    <label>Descrição</label>
                    <textarea name="descricao" rows="3"><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
                </div>

                <div class="row">
                    <div class="input-group">
                    <label>Preço (R$)</label>
                    <input type="number" name="preco" step="0.01" required value="<?php echo $produto['preco']; ?>">
                </div>
                </div>

                <div class="input-group" style="margin-top: 15px;">
                    <label>Foto do Produto (Deixe em branco para manter a atual)</label>
                    <input type="file" name="ds_foto" accept="image/*">
                    <p style="font-size: 0.8rem; color: var(--light-grey); margin-top: 5px;">
                        Imagem atual: <?php echo $produto['ds_image']; ?>
                    </p>
                </div>

                <button type="submit" class="btn-submit">SALVAR ALTERAÇÕES</button>
            </form>
        </div>
    </main>

</body>
</html>