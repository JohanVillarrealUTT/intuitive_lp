<?php echo 'atraetalento.com

¡HOLA, ' . $subscriber->full_name .'!

' . $textMessage . '

Estos son los detalles de tu cita:

dia:  '.translateEsDate(Carbon\Carbon::createFromFormat('Y-m-d', $appointment->date->date)).' a las '.$appointment->hour.'
dirección: Calzada Venustiano Carranza 1745 Colonia sin asignación, entre calles Blvd. lázaro cárdenas y Calle palmar de santa anita  CP 21226


Favor de no responder este correo, si requieres más información puedes comunicarte a reclutamiento@intusurg.com


© 2000-'.date('Y').' atraetalento.com';

