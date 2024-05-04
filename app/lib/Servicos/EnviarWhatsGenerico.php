<?php

/**
 * 
 */
class  EnviarWhatsGenerico

{
    
    private $key;
    private $parametros;
    private $titulos;
    private $beneficiario;
    private $pessoas;
    private $cidades;
    private $estado;
    private $payload;
    private $view;
    public function __construct($key)
    {
       
       $this->key=$key;
       
                   // Realize suas operações de banco de dados aqui
     $this->titulos = CobrancaTitulo::find($this->key);
     $this->pessoas = Cliente::find($this->titulos->cliente_id);
     $this->parametros = ParametrosBancos::find($this->titulos->parametros_bancos_id);
     $this->beneficiario = Beneficiario::find($this->parametros->beneficiario_id);
  
    }
    
    public  function send(){
        
 

                // Utiliza switch para lidar com diferentes bancos
                switch  ($this->titulos->bancos_modulos_id) {
                        case 3:
                        $Print = new SicredPrint($this->key,1);
                        // Chama o método GetPDF na instância de SicredPrint para obter o PDF
                       $file =  $Print->GetPDF();
                        break;
                        case 1:
                        $printPDF = new SicoobPrint($this->key,1);
                       $file= $printPDF->GetPDF();
                        
                        break;
                        case 4:
                       $file=  BoletoPrintStatico::pdf($this->key,1) ;      
                        
                        break;
                        
                        
                          case 5:
                       $file= PrintBoletoHibridoSantander::pdf($this->key,1) ;      
                        
                        break;
                            case 2:
                         $pdf= new BancoBrasilPrint($this->key,1) ;
                        $file= $pdf->GetPDF();   
                        
                        break;
                case 8: 
                
                
                $file=  PrintBoletoBanrisul::GetPDF($this->key,1) ;
         

                        break;
                         
                  
                        default:
 
              new TMessage('info', "Banco não reconhecido");
        }
        
    $params = new stdClass();
    $params->instanceName = $this->beneficiario->instancename;
    $params->urlExterna =  $this->beneficiario->urlexterna;
    $params->mediaType = "document";
    $params->fileName =   'Pagador: '.$this->pessoas->nome;
    $params->apiKey = $this->beneficiario->apikey;
    $params->rotaExterna =  $this->beneficiario->rotaexterna;
    
    $params->codigoPais =  $this->pessoas->paises_codigos;
    $params->number =  $this->pessoas->number;
    $params->caption = " Referente a Cobrança ". $this->titulos->seunumero.' Linha Digitavel: '.$this->titulos->linhadigitavel.
    ' Vencimento '.ClassMaster::data_BR($this->titulos->data_vencimento).' Valor R$'.number_format($this->titulos->valor ,2,',','.');;
    $params->media = "https://banco.developerapi.com.br/".$file;
    $response=SendWhatsAppFiles::sendPDF($params);
 

    //     $params->caption = " Referente Cobrança: ".$this->titulos->seunumero.' Linha Digitavel: '.$this->titulos->linhadigitavel.' Vencimento 
    // '.ClassMaster::data_BR($this->titulos->data_vencimento).' Valor R$ '.number_format($this->titulos->valor ,2,',','.');
        
        
    }
}