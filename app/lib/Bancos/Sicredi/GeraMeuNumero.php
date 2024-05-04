<?php

class GeraMeuNumero{

    public function create($BancosId, $systemUnitId, $banco_id)
    {
        $meunumeroSTD = new stdClass();

        // Verificar se já existe um registro com status 'livre'
        $livreRegistro = ControleMeuNumeros::where('parametros_bancos_id', '=', $BancosId)
            ->where('banco_id', '=', $banco_id)
            ->where('system_unit_id', '=', $systemUnitId)
            ->where('status', '=', 'livre')
            ->first();

        if ($livreRegistro) {
            // Se existe um registro livre, usar esse registro
            $meunumeroSTD->id = $livreRegistro->id;
            $meunumeroSTD->numero = str_pad($livreRegistro->ultimo_numero, 9, '0', STR_PAD_LEFT);
        } else {
            // Se não existe um registro livre, criar um novo registro
            $novoRegistro = new ControleMeuNumeros();
            $novoRegistro->parametros_bancos_id = $BancosId;
            $novoRegistro->system_unit_id = $systemUnitId;
           $novoRegistro->banco_id =  $banco_id;
            // Verifica se há algum registro anterior
            $ultimoRegistro = ControleMeuNumeros::where('parametros_bancos_id', '=', $BancosId)
                ->where('banco_id', '=', $banco_id)
                ->where('system_unit_id', '=', $systemUnitId)
                ->orderBy('id', 'desc')
                ->first();

            if ($ultimoRegistro) {
                $novoRegistro->ultimo_numero = $ultimoRegistro->ultimo_numero + 1;
            } else {
                $novoRegistro->ultimo_numero = 1;
            }

                    $novoRegistro->status = 'livre';
               
         
            $novoRegistro->save();

            $meunumeroSTD->id = $novoRegistro->id;
            $meunumeroSTD->numero = str_pad($novoRegistro->ultimo_numero, 9, '0', STR_PAD_LEFT);
        }

        return $meunumeroSTD;
    }
    
     public function createCEF($BancosId, $systemUnitId, $banco_id)
    {
        $meunumeroSTD = new stdClass();

        // Verificar se já existe um registro com status 'livre'
        $livreRegistro = ControleMeuNumeros::where('parametros_bancos_id', '=', $BancosId)
            ->where('banco_id', '=', $banco_id)
            ->where('system_unit_id', '=', $systemUnitId)
            ->where('status', '=', 'livre')
            ->first();

        if ($livreRegistro) {
            // Se existe um registro livre, usar esse registro
            $meunumeroSTD->id = $livreRegistro->id;
            $meunumeroSTD->numero = str_pad($livreRegistro->ultimo_numero, 17, '0', STR_PAD_LEFT);
        } else {
            // Se não existe um registro livre, criar um novo registro
            $novoRegistro = new ControleMeuNumeros();
            $novoRegistro->parametros_bancos_id = $BancosId;
            $novoRegistro->system_unit_id = $systemUnitId;
           $novoRegistro->banco_id =  $banco_id;
            // Verifica se há algum registro anterior
            $ultimoRegistro = ControleMeuNumeros::where('parametros_bancos_id', '=', $BancosId)
                ->where('banco_id', '=', $banco_id)
                ->where('system_unit_id', '=', $systemUnitId)
                ->orderBy('id', 'desc')
                ->first();

            if ($ultimoRegistro) {
                $novoRegistro->ultimo_numero = $ultimoRegistro->ultimo_numero + 1;
            } else {
                $novoRegistro->ultimo_numero = 1;
            }

                    $novoRegistro->status = 'livre';
               
         
            $novoRegistro->save();

            $meunumeroSTD->id = $novoRegistro->id;
            $meunumeroSTD->numero = str_pad($novoRegistro->ultimo_numero, 17, '0', STR_PAD_LEFT);
        }

        return $meunumeroSTD;
    }
 public function createBanrisul($BancosId, $systemUnitId, $banco_id)
{
    $meunumeroSTD = new stdClass();

    // Verificar se já existe um registro com status 'livre'
    $livreRegistro = ControleMeuNumeros::where('parametros_bancos_id', '=', $BancosId)
        ->where('banco_id', '=', $banco_id)
        ->where('system_unit_id', '=', $systemUnitId)
        ->where('status', '=', 'livre')
        ->first();

    if ($livreRegistro) {
        // Se existe um registro livre, usar esse registro
        $meunumeroSTD->id = $livreRegistro->id;
        $meunumeroSTD->numero = str_pad($livreRegistro->ultimo_numero, 8, '0', STR_PAD_LEFT);
    } else {
        // Se não existe um registro livre, criar um novo registro
        $novoRegistro = new ControleMeuNumeros();
        $novoRegistro->parametros_bancos_id = $BancosId;
        $novoRegistro->system_unit_id = $systemUnitId;
        $novoRegistro->banco_id =  $banco_id;
        
        // Adicionar o sufixo '-A' ao novo registro
        $novoRegistro->ultimo_numero = 1; // Número inicial
        $novoRegistro->status = 'livre';

        // Salvar o registro com o sufixo '-A' no banco
        $novoRegistro->ultimo_numero .= '-A'; 
        $novoRegistro->save();

        $meunumeroSTD->id = $novoRegistro->id;
        $meunumeroSTD->numero = str_pad($novoRegistro->ultimo_numero, 8, '0', STR_PAD_LEFT);
    }

    return $meunumeroSTD;
}



}
