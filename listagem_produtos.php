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
    exit; // Para a execução se der erro
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>HeratSushi - Lista de Produtos</title>
    <link rel="stylesheet" href="./css/style.css"> 
</head>
<body>

    <nav class="navbar">
        <h1 class="logo">HeratSushi</h1>
        <div class="nav-links">
            <a href="index.html" class="btn-link">Voltar ao Formulário</a>
        </div>
    </nav>

    <main class="container">
        <div class="form-card" style="max-width: 900px;"> <h2>Produtos Cadastrados</h2>
            
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--netflix-red); text-align: left;">
                        <th style="padding: 12px;">Imagem</th>
                        <th style="padding: 12px;">Nome</th>
                        <th style="padding: 12px;">Descrição</th>
                        <th style="padding: 12px;">Preço</th>
                        <th style="padding: 12px;">Estoque</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr style="border-bottom: 1px solid #333;">
                            <td style="padding: 12px;">
                                <?php if (!empty($produto['ds_image'])): ?>
                                    <img src="uploads/<?php echo $produto['ds_image']; ?>" alt="Foto do produto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                <?php else: ?>
                                    <span style="color: var(--light-grey); font-size: 0.8rem;">Sem foto</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 12px; font-weight: 600;"><?php echo $produto['nome']; ?></td>
                            <td style="padding: 12px; color: var(--light-grey);"><?php echo $produto['descricao']; ?></td>
                            <td style="padding: 12px; color: var(--netflix-red); font-weight: 600;">
                                R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                            </td>
                            <td style="padding: 12px;"><?php echo $produto['quantidade_estoque']; ?> un</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </main>

</body>
</html>