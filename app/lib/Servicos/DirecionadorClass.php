<?php

/**
 * Classe responsável por direcionar a criação de boletos com base no banco escolhido.
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 */
class DirecionadorClass
{
    /**
     * Cria um boleto com base no banco escolhido.
     *
     * @param string $key - Chave para a criação do boleto.
     */
    public static function createBoleto($key)
    {
// Obtém o objeto de cobrança com base na chave
           $objeto = CobrancaTitulo::find($key);

            // Utiliza switch para lidar com diferentes bancos
            switch ($objeto->bancos_modulos_id) {
                       case 1:
                        
                        $boletoData = new SicoobBoletoCreate($key);
                        return   $boletoData->Getcreate();
                        break;
                          case 2:
                        $boletoData= new BancoBrasilBoletoCreate($key);
                        $boletoData->Getcreate();
                        break;
                         case 3:
                        // Cria uma instância da classe SicrediBoletoCreate, passando a chave para o construtor
                        $TituloCreate = new SicrediBoletoCreate($key);
                        // Chama o método Getcreate() na instância de SicrediBoletoCreate para realizar a criação do boleto
                        $TituloCreate->Getcreate();
                        break;

                        case 4:
                        $boletoCreate = new ItauBoletoCreate($key);
                        return   $boletoCreate->Getcreate();
                        break;
                        
                        case 5:
                        $boletoData= new SantanderBoletoCreate($key);
                        return $boletoData->Getcreate();
                        break;
            
                        case 7:
                 
                        $boletoData = new MultClassCEF($key);
                        $response =$boletoData->IncluirBoleto();
                        break;
                
                      
                        case 8:
                        $boletoData=new BanrisulBoletoCreate($key);
                       $response= $boletoData->create(); 
                  
                        break;

                                 
                                
                        
                        
                        
     
 
            default:
                // Exibe mensagem de informação se o banco não for reconhecido
                new TMessage('info', "Banco não reconhecido");
        }
    }

    /**
     * Consulta um boleto com base no banco escolhido.
     *
     * @param string $key - Chave para a consulta do boleto.
     * @return mixed - Resultado da consulta.
     */
    public static function ConsultaseBoleto($key)
    {
        // Obtém o objeto de cobrança com base na chave
        $objeto = CobrancaTitulo::find($key);

        // Utiliza switch para lidar com diferentes bancos
         switch ($objeto->bancos_modulos_id) {
            case 3:
                // Criando uma instância de ConsultarCobrancaSicredi
                $TituloCreate = new ConsultarCobrancaSicredi($key, 1);
                    // Realizando a consulta e obtendo a resposta
                  return  $TituloCreate->search();
                break;
            case 1:
    
             

$ConsultaSicoob= new ConsultaSicoobOne($key);
// Realizando a consulta e obtendo a resposta
return $ConsultaSicoob->search();
             
       
                // ...
                break;
                  case 4:
    
             

            
            $itauCosultaFull= new CosultaItauBoletoFull($key);
          return  $itauCosultaFull->GetBusca();
             
       
                // ...
                break;
                
                
                   case 2:
             

            
            $Cosulta= new ConsultaBoletoBB($key) ;
            return  $Cosulta->search();
 
                break;
                     
         

       case 8:
             

            
                $Cosulta=new ConsultaCobrancaBanrisul($key);
                $Cosulta->search();

                break;

  case 7:
             
 
            
        $boleto = new MultClassCEF($key);
        $boleto->ConsultarBoletos();
       
       
        
 
                break;

        
   
            default:
                // Exibe mensagem de informação se o banco não for reconhecido
                new TMessage('info', "Banco não reconhecido");
        }
    }

    /**
     * Imprime um boleto com base no banco escolhido.
     *
     * @param string $key - Chave para a impressão do boleto.
     */
    public static function PrintBoleto($key)
    {
        // Obtém o objeto de cobrança com base na chave
        $objeto = CobrancaTitulo::find($key);

                // Utiliza switch para lidar com diferentes bancos
                switch ($objeto->bancos_modulos_id) {
                        case 3:
                        $Print = new SicredPrint($key,2);
                        // Chama o método GetPDF na instância de SicredPrint para obter o PDF
                        $Print->GetPDF();
                        break;
                        case 1:
                        $printPDF = new SicoobPrint($key,2);
                        $printPDF->GetPDF();
                        
                        break;
                        case 4:
                        BoletoPrintStatico::pdf($key,2) ;      
                        
                        break;
                        
                        
                          case 5:
                        PrintBoletoHibridoSantander::pdf($key,2) ;      
                        
                        break;
                            case 2:
                         $pdf= new BancoBrasilPrint($key,2) ;
                         $pdf->GetPDF();   
                        
                        break;
                         
                         
                             case 8:
                        PrintBoletoBanrisul::GetPDF($key,2) ;
                      
                        
                        break;
                    
                    case 7:
              PrintBoletoCaixa::GetPDF($key,2) ;
                    
                    
                    break;

      
                  
                        default:
 
              new TMessage('info', "Banco não reconhecido");
        }
    }

    /**
     * Envia um email com o boleto anexado, com base no banco escolhido.
     *
     * @param string $key - Chave para o envio do email.
     */
    public static function SendEmailBoleto($key)
    {
        // Obtém o objeto de cobrança com base na chave
        $objeto = CobrancaTitulo::find($key);

        // Utiliza switch para lidar com diferentes bancos
        switch ($objeto->bancos_modulos_id) {
            case 3:
                $email = new EnviarEmailSicredi($key);
                $response = $email->sendEmail();
                break;
            case 4:
                // Lógica de envio de email para o banco Itaú
                // ...
                break;
            default:
                // Exibe mensagem de informação se o banco não for reconhecido
                new TMessage('info', "Banco não reconhecido");
        }
    }
    
       /**
     * Solicitação e baxa do boleto anexado, com base no banco escolhido.
     *
     * @param string $key -  
     */
    public static function BaixarBoleto($key)
    {
        // Obtém o objeto de cobrança com base na chave
        $objeto = CobrancaTitulo::find($key);

        // Utiliza switch para lidar com diferentes bancos
        switch ($objeto->bancos_modulos_id) {
            case 3:
                $TituloCreate = new BaixaBoletoSicredi($key);
                
             return  $TituloCreate->baixar();
                break;
            case 4:
                    $baixaItau= new BaixaBoletoItau($key);
                    return $baixaItau->baixar();
 
                break;
                
                     case 2:
                    $baixabb= new BaixaBoletoBB($key);
                    return $baixabb->dow();
 
                break; 
                
                 case 7:
                    $baixabb= new MultClassCEF($key);
                     $baixabb->BaixarBoleto();
 
                break; 
                
           
           
           
           
       
            default:
                // Exibe mensagem de informação se o banco não for reconhecido
                new TMessage('info', "Banco não reconhecido");
        }
    }
    
    
       public static function UpdateBoleto($key)
    {
 
           $objeto = CobrancaTitulo::find($key);
           
           
             // Utiliza switch para lidar com diferentes bancos
            switch ($objeto->bancos_modulos_id) {
    
                 case 7:
            $boleto = new MultClassCEF($key);
            return $boleto->AlterarBoleto();
 
                break; 
        
            default:
                // Exibe mensagem de informação se o banco não for reconhecido
                new TMessage('info', "Banco não reconhecido");
        }
           
}
    
}
