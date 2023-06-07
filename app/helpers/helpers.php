<?php

if (! function_exists('translateDate')) {
    function translateEsDate( $date )
    {
       $dia = collect([
           'Sat' => 'Sábado',
           'Sun' => 'domingo',
           'Mon' => 'Lunes',
           'Tue' => 'Martes',
           'Wed' => 'Miércoles',
           'Thu' => 'Jueves',
           'Fri' => 'Viernes',
       ])->get($date->format('D'));
       
       $mes = collect([
            'Jan' => 'Enero',
            'Feb' => 'Febrero',
            'Mar' => 'Marzo',
            'Apr' => 'Abril',
            'May' => 'Mayo',
            'Jun' => 'Junio',
            'Jul' => 'Julio',
            'Aug' => 'Agosto',
            'Sep' => 'Septiembre',
            'Oct' => 'Octubre',
            'Nov' => 'Noviembre',
            'Dec' => 'Diciembre',
        ])->get($date->format('M'));

        //Sábado, 07 Agosto 2021
        return $dia .', ' . $date->format('d') .' '. $mes .' '. $date->format('Y');
    }
}