<?php
namespace public_\php;
class utilities {
    public static function generacion_fecha($valor = null)
    {
        if ($valor != null) {
            $data = substr($valor, 0, 10);
            $completion_date = explode('-', $data);
            $writtenEveryMonth = array(
                '01' => 'Enero',
                '02' => 'Febrero',
                '03' => 'Marzo',
                '04' => 'Abril',
                '05' => 'Mayo',
                '06' => 'Junio',
                '07' => 'Julio',
                '08' => 'Agosto',
                '09' => 'Septiembre',
                '10' => 'Octubre',
                '11' => 'Noviembre',
                '12' => 'Diciembre'
            );
            $monthWritten = $writtenEveryMonth[$completion_date[1]];
            return $data = $completion_date[2] . ' de ' . $monthWritten . ' de ' . $completion_date[0];
        } else {
            return 'N/A';
        }
    }
}


?>