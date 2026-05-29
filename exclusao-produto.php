<?php
require_once "conexao.php";

// Verificamos se o ID foi passado na URL (ex: excluir_produto.php?id=5)
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    // intval garante que o ID seja tratado estritamente como um número inteiro (segurança)
    $id = intval($_GET['id']); 

    try {
        //Antes de deletar o produto, precisamos descobrir o nome da imagem dele
        $sql_busca = "SELECT ds_image FROM produtos WHERE id = :id";
        $stmt_busca = $pdo->prepare($sql_busca);
        $stmt_busca->bindParam(":id", $id);
        $stmt_busca->execute();
        $produto = $stmt_busca->fetch(PDO::FETCH_ASSOC);

        if ($produto) {
            $imagemDoBanco = $produto['ds_image'];

            /*Verificamos se o produto usa uma imagem real enviada pelo usuário.
                  Se a imagem não for 'not_image.png' e o arquivo existir na pasta, nós o deletamos do servidor */
            if (!empty($imagemDoBanco) && $imagemDoBanco !== 'not_image.png') {
                $caminhoArquivo = "uploads/" . $imagemDoBanco;
                if (file_exists($caminhoArquivo)) {
                    unlink($caminhoArquivo); // unlink() apaga o arquivo físico da pasta
                }
            }

            //Agora sim, deletamos o registro do produto no Banco de Dados
            $sql_delete = "DELETE FROM produtos WHERE id = :id";
            $stmt_delete = $pdo->prepare($sql_delete);
            $stmt_delete->bindParam(":id", $id);
            $stmt_delete->execute();

            // Mensagem de sucesso e redirecionamento automático
            echo "<script>
                    alert('Produto excluído com sucesso!');
                    window.location.href = 'listagem_produtos.php';
                  </script>";
            exit;
        } else {
            echo "<script>
                    alert('Produto não encontrado!');
                    window.location.href = 'listagem_produtos.php';
                  </script>";
            exit;
        }

    } catch (PDOException $e) {
        echo "<script>
                alert('Erro ao excluir: " . addslashes($e->getMessage()) . "');
                window.location.href = 'listagem_produtos.php';
              </script>";
        exit;
    }
} else {
    // Se alguém tentar acessar o arquivo diretamente sem passar um ID na URL, mandamos de volta
    header("Location: listagem_produtos.php");
    exit;
}
?>