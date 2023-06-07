<?php echo 'atraetalento.com

¡FELICIDADES,'. $subscriber->full_name .'
Has completado satisfactoriamente el formulario de evaluación, 
ahora te invitamos a seleccionar el día y hora en el que te gustaría realizar el proceso de reclutamiento.
Tu folio de registro es: '. $subscriber->folio_number .'

AGENDAR CITA '.url('citas?action=create') .'

SI YA AGENDASTE TU CITA, NO ES NECESARIO QUE LO HAGAS DE NUEVO


Favor de no responder este correo, si requieres más información puedes comunicarte a reclutamiento@intusurg.com


© 2017 - '.date('Y').' atraetalento.com';
