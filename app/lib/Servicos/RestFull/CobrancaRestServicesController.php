<?php
use Adianti\Control\TPage;
use Adianti\Control\TAction;
use Adianti\Widget\Wrapper\TQuickForm;
use Adianti\Widget\Container\TTable;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TPassword;
use Adianti\Widget\Form\TButton;
use Adianti\Widget\Form\TForm;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TText;
use Adianti\Wrapper\BootstrapFormBuilder;
use Adianti\Wrapper\BootstrapDatagridWrapper;

class CobrancaRestServicesController
{
    public function buscarPorId($param)
    {
        // Recebe o ID do parâmetro
        $id = $param['id'];

        // Chama a função buscarPorId da classe CobrancaRestServices para buscar o registro pelo ID
        $cobranca = CobrancaRestServices::buscarPorId($id);

        // Converte o objeto em JSON e retorna como resposta
        echo json_encode($cobranca);
    }
}
