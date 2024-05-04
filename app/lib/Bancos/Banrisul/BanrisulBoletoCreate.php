<?php

 class BanrisulBoletoCreate
{
    private $key;
    private $parametros;
    private $titulos;
    private $beneficiario;
    private $pessoas;
    private $cidades;
    private $estado;
    private $payload;
    private $Workspaces;
    private $GetToken;
    private $token;
    private static $database = 'conecatarbanco';
 
    /**
     * Construtor da classe GetTokenSBanrisul.
     *
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key) {
        $this->key = $key;
        // Make sure ParametrosItau class and find method are defined
                // Realize suas operações de banco de dados aqui
                $this->titulos = CobrancaTitulo::find($this->key);
                $this->pessoas = Cliente::find($this->titulos->cliente_id);
                $this->parametros = ParametrosBancos::find($this->titulos->parametros_bancos_id);
                $this->beneficiario = Beneficiario::find($this->parametros->beneficiario_id);
                $gera= new GetTokenSBanrisul($this->titulos->parametros_bancos_id);
                $this->token= $gera->create();
        
 
    }
  
    /**
     * Arquivo: GetTokenSBanrisul
     * Autor: Rubens do Santos
     * Contato: salvadorbba@gmail.com
     * Descrição: Descrição breve do propósito deste arquivo.
     *
     * @return string|false O token de acesso se a autenticação for bem-sucedida, caso contrário, uma mensagem de erro ou false em caso de falha.
     */
       public function create()
     {
         
         
         
       $ultimoNumeros = new GeraMeuNumero();
       $meunumero = $ultimoNumeros->create($this->beneficiario->id, TSession::getValue('userunitid'),8);

 

    // Verificar se ocorreu algum erro na solicitação
    // Dados do boleto em formato JSON
    
            if( $this->parametros->ambiente==2){
            $ambiente = "T";
            
            }else{
            
            $ambiente = "P";
            }
            $data = new stdClass();
            $data->ambiente = $ambiente;
        
            // Criando o objeto 'titulo' e atribuindo seus valores
            $data->titulo = new stdClass();
            $data->titulo->data_emissao = date('Y-m-d');
            $data->titulo->data_vencimento = $this->titulos->data_vencimento;
            $data->titulo->especie = "32";
            $data->titulo->seu_numero =   $meunumero->numero;
            $data->titulo->valor_nominal =  $this->titulos->valor;
            
         
    
        $juros =   $this->parametros->valorjurosmora;
        $abatimento =   $this->parametros->valorabatimento;
        $desconto =  $this->parametros->valorprimeirodesconto;
        $multa = $this->parametros->valormulta;
        
 
        // Criando o objeto 'instrucoes' e atribuindo seus valores
        $data->titulo->instrucoes = new stdClass();
        
        // Verificando e atribuindo instruções de juros
        if ($this->parametros->tipojurosmora==3) {
            $data->titulo->instrucoes->juros = new stdClass();
            $data->titulo->instrucoes->juros->codigo =3;
            $data->titulo->instrucoes->juros->data =CalculosTaxasBanrisul::addday($this->titulos->data_vencimento, $this->parametros->diasjurosmora);
            $data->titulo->instrucoes->juros->taxa = $juros;
            $data->titulo->instrucoes->juros->valor =  CalculosTaxasBanrisul::adicionarModificador($this->titulos->valor, ['tipo' => 'juros', 'valor' =>  $this->parametros->valorjurosmora]);  
        }
       
        // Verificando e atribuindo instruções de abatimento
        if ($this->parametros->valorabatimento) {
            $data->titulo->instrucoes->abatimento = new stdClass();
            $data->titulo->instrucoes->abatimento->valor =  CalculosTaxasBanrisul::adicionarModificador($this->titulos->valor, ['tipo' => 'desconto', 'valor' => $this->parametros->valorabatimento]);
        }
                      if ($this->parametros->baixa_devolver_codigo == 1) {
                    // Atribuindo instruções de baixa
                    $prazo = (int)$this->parametros->baixar_devolver_prazo; // Converte para inteiro
                    if ($prazo >= 1 && $prazo <= 99) { // Verifica se o valor está entre 1 e 99
                        $data->titulo->instrucoes->baixa = new stdClass();
                        $data->titulo->instrucoes->baixa->codigo = 1;
                        $data->titulo->instrucoes->baixa->prazo = (string)$prazo; // Converte de volta para string
                    } else {
                        // Valor do prazo não está no formato válido
                        // Faça o tratamento adequado aqui, como lançar uma exceção ou definir um valor padrão
                    }
                }

         
         

        // Verificando e atribuindo instruções de desconto
        if ($this->parametros->tipodesconto==3) {
            $data->titulo->instrucoes->desconto = new stdClass();
            $data->titulo->instrucoes->desconto->codigo = 3;
            $data->titulo->instrucoes->desconto->data = CalculosTaxasBanrisul::SUBday($this->titulos->data_vencimento, $this->parametros->diasparadesconto_primeiro);
            $data->titulo->instrucoes->desconto->taxa = number_format($this->parametros->valorprimeirodesconto,2,'.');
            $data->titulo->instrucoes->desconto->valor = CalculosTaxasBanrisul::adicionarModificador($this->titulos->valor, ['tipo' => 'desconto', 'valor' => $this->parametros->valorprimeirodesconto]);;
        }
       
        // Verificando e atribuindo instruções de multa
        if ($this->parametros->tipomulta==1) {
            $data->titulo->instrucoes->multa = new stdClass();
            $data->titulo->instrucoes->multa->codigo = 1;
            $data->titulo->instrucoes->multa->data = CalculosTaxasBanrisul::addday($this->titulos->data_vencimento, $this->parametros->diasmultas);;
            $data->titulo->instrucoes->multa->taxa = number_format($this->parametros->valormulta,1,'.');
            $data->titulo->instrucoes->multa->valor =CalculosTaxasBanrisul::adicionarModificador($this->titulos->valor, ['tipo' => 'juros', 'valor' =>  $this->parametros->valormulta]);  
        }
 
 
 
        if ($this->parametros->protesto_codigo==3) {
        $data->titulo->instrucoes->protesto = new stdClass();
        $data->titulo->instrucoes->protesto->codigo = 3;
        $data->titulo->instrucoes->protesto->prazo = (int) $this->parametros->protesto_prazo;
        }
        
            // Criando o objeto 'pag_parcial' e atribuindo seus valores
    $data->titulo->pag_parcial = new stdClass();
    $data->titulo->pag_parcial->autoriza = 1;
    $data->titulo->pag_parcial->codigo = 3;
    $data->titulo->pag_parcial->percentual_max = "100.00";
    $data->titulo->pag_parcial->percentual_min = "100.00";
    $data->titulo->pag_parcial->quantidade = 3;
    $data->titulo->pag_parcial->tipo = 1;
    $data->titulo->pag_parcial->valor_max = "100.00";
    $data->titulo->pag_parcial->valor_min = "100.00";
      

      $cidade= ClassMaster::limitarTexto($this->pessoas->cobranca_cidade,15);
 
    // Criando o objeto 'pagador' e atribuindo seus valores
    $data->titulo->pagador = new stdClass();
    $data->titulo->pagador->nome = $this->pessoas->nome;
    $data->titulo->pagador->aceite = "A";
    $data->titulo->pagador->cep = $this->pessoas->cobranca_cep;
    $data->titulo->pagador->cidade =ClassGenerica::CleanString($cidade);
    $data->titulo->pagador->cpf_cnpj =  $this->pessoas->cpf_cnpj;
    $limparendereco= ClassGenerica::CleanString($this->pessoas->cobranca_endereco);
     $endereco= ClassMaster::limitarTexto($limparendereco, 18).' '.$this->pessoas->cobranca_numero;
    
    $data->titulo->pagador->endereco = $endereco;
 
 
        
        if (strlen($this->pessoas->cpf_cnpj) === 14) {
        $data->titulo->pagador->tipo_pessoa = "J";
        
        } else {
        $data->titulo->pagador->tipo_pessoa = "F";
        }

    $data->titulo->pagador->uf = $this->pessoas->cobranca_uf;
///duvidas sobre geração de qr
    // Criando o objeto 'hibrido' e atribuindo seus valores
    $data->titulo->hibrido = new stdClass();
    $data->titulo->hibrido->autoriza = "S";
 

    $json = json_encode($data);
    // URL para criar o boleto
    $boletoUrl =$this->parametros->url2;

    // Inicializar a sessão cURL para a criação do boleto
    $curl = curl_init();

    // Configurações da solicitação cURL para a criação do boleto
    curl_setopt_array($curl, array(
        CURLOPT_URL => $boletoUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $json,
        CURLOPT_HTTPHEADER => array(
            'bergs-beneficiario: '. $this->parametros->numerocontrato,
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $this->token,
        ),
    ));

    // Executar a solicitação cURL para criar o boleto
    $response = curl_exec($curl);
 

    // Fechar a sessão cURL para a criação do boleto
    curl_close($curl);
 
    
    $resposta= json_decode($response);
  
 
   if(isset($resposta->ocorrencias)){
   $mensagem = "Foram encontradas as seguintes ocorrências:<br>";

// Loop através de cada ocorrência
foreach ($resposta->ocorrencias as $index => $ocorrencia) {
    $mensagem .= ($index + 1) . ". Código: " . $ocorrencia->codigo . "<br>";
    $mensagem .= "   Mensagem de erro: " . $ocorrencia->mensagem . "<br>";
}

 
     new TMessage('info', $mensagem);
   }else{    


        if(isset( $resposta->titulo->linha_digitavel)){
        $objeto = CobrancaTitulo::find($this->titulos->id);
        if ($objeto) {
            
            if( $this->parametros->ambiente==2){
            $objeto->linhadigitavel = '04192100180000001000900038840716786110000015050'; ///temporarios 
            
            }else{
            
            $objeto->linhadigitavel = $resposta->titulo->linha_digitavel;
            }

            
          
            $objeto->codigobarras =  $resposta->titulo->codigo_barras;
     
            
            
           $objeto->user_id= TSession::getValue('userid');
            $objeto->id_titulo_empresa =  $resposta->titulo->id_titulo_empresa;
            $objeto->seunumero = $meunumero->numero;
            $objeto->nossonumero =  $resposta->titulo->nosso_numero;
             
             $objeto->status = 5;
             $objeto->store();
        }

        $objeto_up_numero = ControleMeuNumeros::find($meunumero->id);
        if ($objeto_up_numero) {
            $objeto_up_numero->status = 'uso';
            $objeto_up_numero->store();
        }
   
 
         // Código gerado pelo snippet: "Exibir mensagem"
        $mensagem = "<b>Boleto gerado com sucesso!</b><br>";
        $mensagem .= "Nosso número: {$objeto->seunumero}<br>";
        $mensagem .= "Cliente: {$this->pessoas->nome}<br>";
        $mensagem .= "Banco: {$this->parametros->apelido}<br>";
        $mensagem .= "Valor: {$this->titulos->valor}<br>";
        $mensagem .= "Vencimento: {$this->titulos->data_vencimento}<br>";
        $mensagem .= "Linhas Digitáveis: {$objeto->linhadigitavel}<br>";
        new TMessage('info', $mensagem);
        


}

        }
 
  
}
}