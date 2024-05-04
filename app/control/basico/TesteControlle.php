<?php
 
class TesteControlle extends TPage
{
    private static $database = 'conecatarbanco';

    public function __construct($param)
    {
        parent::__construct();
    }

    // Função executada ao clicar no item de menu
    public function onShow($param = null)
    {
 
 
 
// Configurações de conexão com o banco de dados
$host = 'developerapi.com.br';
$usuario = 'develope_inova';
$senha = 'r-yKG2N-3!lT';
$banco_de_dados = 'develope_inova';

// Palavra a ser buscada
$palavra = '17758';

// Conexão com o banco de dados
$mysqli = new mysqli($host, $usuario, $senha, $banco_de_dados);

// Verifica se houve algum erro na conexão
if ($mysqli->connect_error) {
    die('Erro na conexão: ' . $mysqli->connect_error);
}

// Obtém todas as tabelas do banco de dados
$resultado = $mysqli->query("SHOW TABLES");

// Percorre todas as tabelas
while ($tabela = $resultado->fetch_array()) {
    $nome_tabela = $tabela[0];

    // Obtém todas as colunas da tabela
    $resultado_colunas = $mysqli->query("DESCRIBE `$nome_tabela`");

    // Percorre todas as colunas
    while ($coluna = $resultado_colunas->fetch_array()) {
        $nome_coluna = $coluna['Field'];

        // Monta a query para buscar a palavra na coluna
        $query = "SELECT * FROM `$nome_tabela` WHERE `$nome_coluna` LIKE '%$palavra%'";
        $resultado_busca = $mysqli->query($query);

        // Exibe os resultados, se houver
        if ($resultado_busca->num_rows > 0) {
            echo "Palavra '$palavra' encontrada na tabela '$nome_tabela', coluna '$nome_coluna':<br>";
            while ($registro = $resultado_busca->fetch_assoc()) {
            
            $return[]=$registro;
            
            }
        }
    }
}
dd($return);
// Fecha a conexão com o banco de dados
$mysqli->close();

 

 
    
}}
 
 