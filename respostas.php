<?php
$titulo = "Correção Questionário";
$subtitulo = "Respostas:";
$migalhaPao = "Página Inicial > Respostas";
include "conexao.php" ;
include "cabecalho.php" ;
?>

<h2>Respostas</h2>

<?php
$pontuacao = 0;
if(isset($_POST) && !empty($_POST)){
    $valoresArray = array_keys($_POST);
    for($i=0; $i<count($valoresArray);$i++){

        $alternativaSelecionada = lcfirst($_POST[$valoresArray[$i]]); //alternativa que o usuário selecionou
        quebraLinha();

        $query = "select * from questoes where id =".$valoresArray[$i];
        $resultado = mysqli_query($conexao, $query);
        
        while($linha = mysqli_fetch_array($resultado)){
            $alternativaCorreta = lcfirst($linha["correta"]);
            ?>
            <div class="offset-3 col-7">
                <div class="card m-3">
                    <div class="card-header text-center">
                        <strong>
                            <?php echo $linha["pergunta"] ?>
                        </strong>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <?php
                                if(
                                $alternativaCorreta == $alternativaSelecionada){
                            ?>
                            <div class="alert alert-success">
                                <p>Você Acertou!!!</p>
                                <p>Sua Resposta: <?php echo $_POST[$valoresArray[$i]].") ". $linha[$alternativaSelecionada]?></p>
                                <p>Resposta Certa: <?php echo $linha["correta"].") ". $linha[$alternativaCorreta]?></p>
                            </div>
                            <?php
                                $pontuacao++;
                                }else{
                                ?>
                                    <div class="alert alert-danger">
                                        <p>Você Errou!</p>
                                        <p>Sua Resposta: <?php echo $_POST[$valoresArray[$i]].") ". $linha[$alternativaSelecionada]?></p>
                                        <p>Resposta Certa: <?php echo $linha["correta"].") ". $linha[$alternativaCorreta]?></p>
                                    </div>
                                    <?php
                                    }
                                    ?>
                        </blockquote>
                    </div>
                </div> 
            </div>
        <?php
        }
    }  
    
    if($pontuacao==1){
        ?>
        <div class="alert alert-danger" role="alert">
            Sua pontuação foi abaixo da média: <?php echo $pontuacao ?> pontos
        </div>
        <br>
        <?php
    }else if($pontuacao<5){
        ?>
        <div class="alert alert-danger" role="alert">
            Sua pontuação foi abaixo da média: <?php echo $pontuacao ?> pontos
        </div>
        <br>
        <?php
    }else{
        ?>
        <div class="alert alert-success" role="alert">
            Sua pontuação foi acima da média: <?php echo $pontuacao ?> pontos
        </div>
        <br>
        <?php
    }

}else{
    header("Location: ./index.php?mensagem=Você Precisa Responder pelo menos uma pergunta para ver o resultado!");
    exit();
}

include "rodape.php" ;

function quebraLinha(){
    ?>
    <br/>
    <?php
}
?>