<?php
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome      = trim($_POST["nome"]);
    $descricao = trim($_POST["descricao"]);
    $preco     = trim($_POST["preco"]);


    // Aqui criamos uma variável para colocar o nome das imagens de upload
    // Definimos o valor padrão caso nenhuma foto válida seja enviada
    $nomeFoto = 'not_image.png'; 

    // Se houver campos vazios, exibe o alerta e para a execução imediatamente!
    if (empty($nome) || empty($descricao) || empty($preco) ) {
        echo "<script>
                alert('Preencha todos os dados!');
                window.location.href = 'index.html';
              </script>";
        exit; // Essencial para impedir que o PHP continue a ler o código abaixo e insira no banco
    } else {
        
        // Aqui verificamos se o arquivo trazido do form é um file (imagem) e se ele veio ou não com algum erro
        if (isset($_FILES['ds_foto']) && $_FILES['ds_foto']['error'] == 0) {

            // Validação do formato: pega a extensão e converte para minúsculo
            $extensao = strtolower(pathinfo($_FILES['ds_foto']['name'], PATHINFO_EXTENSION));
            $extensoesPermitidas = array("jpg", "jpeg", "png");

            // Só faz o upload se a extensão for permitida
            if (in_array($extensao, $extensoesPermitidas)) {
                
                // Aqui criamos caso ainda não exista, uma pasta para guardar os uploads
                $pasta = "uploads/";

                if (!is_dir($pasta)) {
                   mkdir($pasta, 0777, true);
                }

                $nomeFoto = uniqid() . "_" . basename($_FILES['ds_foto']['name']);

                move_uploaded_file($_FILES['ds_foto']['tmp_name'], $pasta . $nomeFoto);
            }
        }

        try {
            $sql = "INSERT INTO produtos (nome, descricao, preco,  ds_image) 
                    VALUES (:nome, :descricao, :preco,  :ds_image)";
          
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->bindParam(":preco", $preco);
            $stmt->bindParam(":ds_image", $nomeFoto);

            $stmt->execute();

            // vai para produtos.php dentro da tag script
            echo "<script>
                    alert('Produto cadastrado com sucesso!');
                    window.location.href = 'produtos.php';
                  </script>";

        } catch (PDOException $e) {
            // adicionamos o addslashes() para que aspas na mensagem de erro do banco não quebrem o JavaScript
            echo "<script>
                    alert('Erro ao salvar no banco: " . addslashes($e->getMessage()) . "');
                    window.location.href = 'index.html';
                  </script>";
        }
    }
}
?>