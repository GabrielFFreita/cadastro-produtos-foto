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
        <div class="form-card" style="max-width: 1000px;"> 
            <h2>Produtos Cadastrados</h2>
            
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--netflix-red); text-align: left;">
                        <th style="padding: 12px;">Imagem</th>
                        <th style="padding: 12px;">Nome</th>
                        <th style="padding: 12px;">Descrição</th>
                        <th style="padding: 12px;">Preço</th>
                       
                        <th style="padding: 12px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr style="border-bottom: 1px solid #333;">
                            <td style="padding: 12px;">
                                <?php 
                                if (!empty($produto['ds_image']) && $produto['ds_image'] !== 'not_image.png') {
                                    $caminhoImagem = "uploads/" . $produto['ds_image'];
                                } else {
                                    $caminhoImagem = "not_image.png"; 
                                }
                                ?>
                                <img src="<?php echo $caminhoImagem; ?>" alt="Foto do produto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            </td>
                            <td style="padding: 12px; font-weight: 600;"><?php echo $produto['nome']; ?></td>
                            <td style="padding: 12px; color: var(--light-grey);"><?php echo $produto['descricao']; ?></td>
                            <td style="padding: 12px; color: var(--netflix-red); font-weight: 600;">
                                R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                            </td>
                        
                            
                            <td style="padding: 12px; text-align: center;">
                                <a href="exclusao-produto.php?id=<?php echo $produto['id']; ?>" 
                                   style="color: var(--netflix-red); text-decoration: none; font-weight: bold; background-color: rgba(229, 9, 20, 0.1); padding: 6px 12px; border-radius: 4px; border: 1px solid var(--netflix-red); transition: all 0.3s;"
                                   onclick="return confirm('Tem certeza que deseja excluir o produto: <?php echo addslashes($produto['nome']); ?>?');">
                                   Excluir
                                </a>
                                <td style="padding: 12px; text-align: center;">
                            <a href="editar_produto.php?id=<?php echo $produto['id']; ?>" 
                            style="color: #22c55e; text-decoration: none; font-weight: bold; background-color: rgba(34, 197, 94, 0.1); padding: 6px 12px; border-radius: 4px; border: 1px solid #22c55e; margin-right: 5px;">
                            Editar
                            </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </main>

</body>
</html>