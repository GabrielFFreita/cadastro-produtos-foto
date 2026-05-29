<?php
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id        = intval($_POST["id"]);
    $nome      = trim($_POST["nome"]);
    $descricao = trim($_POST["descricao"]);
    $preco     = trim($_POST["preco"]);

    // Esta linha substitui a vírgula por ponto caso você tenha digitado com vírgula
    $preco     = str_replace(',', '.', $preco);

    if (empty($nome) || empty($preco) ) {
        echo "<script>alert('Preencha os dados obrigatórios!'); window.history.back();</script>";
        exit;
    }

    try {
        //Aqui buscamos a imagem atual do banco para caso não seja enviada uma nova
        $sql_atual = "SELECT ds_image FROM produtos WHERE id = :id";
        $stmt_atual = $pdo->prepare($sql_atual);
        $stmt_atual->bindParam(":id", $id);
        $stmt_atual->execute();
        $produto_atual = $stmt_atual->fetch(PDO::FETCH_ASSOC);
        
        $nomeFoto = $produto_atual['ds_image']; // Valor padrão é a foto que já estava

        //Assim verificamos se o usuário enviou uma NOVA imagem
        if (isset($_FILES['ds_foto']) && $_FILES['ds_foto']['error'] == 0) {
            $extensao = strtolower(pathinfo($_FILES['ds_foto']['name'], PATHINFO_EXTENSION));
            $extensoesPermitidas = array("jpg", "jpeg", "png");

            if (in_array($extensao, $extensoesPermitidas)) {
                $pasta = "uploads/";

                // Deleta a imagem antiga da pasta (se ela existir e não for a padrão)
                if (!empty($nomeFoto) && $nomeFoto !== 'not_image.png' && file_exists($pasta . $nomeFoto)) {
                    unlink($pasta . $nomeFoto);
                }

                // Salva a nova imagem
                $nomeFoto = uniqid() . "_" . basename($_FILES['ds_foto']['name']);
                move_uploaded_file($_FILES['ds_foto']['tmp_name'], $pasta . $nomeFoto);
            }
        }

        //Aqui atualizar os dados usando o comando UPDATE do SQL
        $sql_update = "UPDATE produtos 
                       SET nome = :nome, descricao = :descricao, preco = :preco,  ds_image = :ds_image \r
                       WHERE id = :id";
        
        $stmt = $pdo->prepare($sql_update);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":ds_image", $nomeFoto);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        echo "<script>\r
                alert('Produto atualizado com sucesso!');\r
                window.location.href = 'listagem_produtos.php';\r
              </script>";
        exit;

    } catch (PDOException $e) {
        echo "<script>alert('Erro ao atualizar: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
        exit;
    }
}
?>