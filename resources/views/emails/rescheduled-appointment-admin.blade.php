<!DOCTYPE html>
<html>
    <head>
        <title>Intuitive | Tu cita fue reagendada</title>
    </head>
    <body style="background-color: #f6f6f6;">
        <div style="width: 100%; margin: 20px auto 0px; max-width: 568px; font-family: Calibri, Roboto, sans-serif; background-color: #1F2028; text-align: left; padding: 25px 30px;">
            <img src="{{url('images/logoemail.png')}}" alt="Intuitive" border="0" style="border: 0; outline: none; text-decoration: none;">
        </div>
        <div style="width: 100%; max-width: 568px; margin: auto; font-family: Calibri, Roboto, sans-serif; color: #85868C; text-align: left; padding: 30px; background-color: #fff;">
            <p style="font-size: 20px; font-weight: 700; margin-bottom: 24px; color: #071BCE; letter-spacing: 1.6px;">CITA REAGENDADA</p>
            <p style="font-size: 16px; margin-bottom: 15px;">Hola {{$subscriber->full_name}}, INTUITIVE reagendó tu entrevista del día {{$oldAppointment}}, para el día <b>{{ translateEsDate(Carbon\Carbon::createFromFormat('Y-m-d', $appointment->date->date)) }}</b></p>
            <p>Estos son los detalles de tu nueva cita:</p>
            <div style="background-color: #F3F3F3; border-radius: 10px; padding: 20px 30px; color: #1F2028;">
                <p><img src="{{url('images/icon-1.png')}}" style="margin-right: 10px;">{{  translateEsDate(Carbon\Carbon::createFromFormat('Y-m-d', $appointment->date->date)) }}</p>
                <p><img src="{{url('images/icon-2.png')}}" style="margin-right: 10px;">{{$appointment->hour}}</p>
                <p><img src="{{url('images/icon-3.png')}}" style="margin-right: 10px;">Calzada Venustiano Carranza 1745<br>
                <span style="padding-left: 20px;">Colonia sin asignación</span> <br>
                <span style="padding-left: 20px;">entre calles Blvd. lázaro cárdenas y Calle palmar de santa anita  CP 21226</span>
                <span style="padding-left: 20px;">Mexicali, B.C.</span></p>
                <a href="https://www.google.com/maps/place/Intuitive+Surgical+Blvd.+Venustiano+Carranza/@32.6225935,-115.3996659,15z/data=!4m9!1m2!2m1!1sintuitive+surgical!3m5!1s0x0:0x46ca82a75a2a02ec!8m2!3d32.625534!4d-115.3979492!15sChJpbnR1aXRpdmUgc3VyZ2ljYWySAQxtYW51ZmFjdHVyZXI" style="color: #071BCE; padding-left: 20px;">Ver mapa</a>
            </div>
            <div style="border: 1px solid #F3F3F3; border-radius: 10px; padding: 20px 30px; color: #85868C; margin-top: 20px">
                <p style="font-size: 13px; color: #1F2028; font-weight: bold; letter-spacing: 1.04px;">ALGUNAS <span style="color: #071BCE;">RECOMENDACIONES</span> PARA EL DÍA DE TU CITA:</p>
                <ul style="margin-left: -26px;">
                    <li style="margin-bottom: 5px;"><b>Tomé en cuenta que la duración del proceso es de 3 a 4 horas.</b></li>
                    <li style="margin-bottom: 5px;"><b>Te invitamos a desayunar con nosotros.</b></li>
                    <li style="margin-bottom: 5px;">Al llegar a caseta presenta tu Identificación oficial para tu registro </li>
                    <li style="margin-bottom: 5px;">Estacionamiento: donde el guardia de caseta te indique.</li>
                    <li style="margin-bottom: 5px;">Es necesario que portes cubrebocas (obligatorio). </li>
                    <li style="margin-bottom: 5px;">Lleva una pluma (negra o azul) para llenar tu solicitud. </li>
                    <li style="margin-bottom: 5px;">Si utilizas gafas para leer, ver de lejos, etc. los necesitas para prueba de ensamble y examen médico. </li>
                    <li style="margin-bottom: 5px;">No traer mochila o bolsa grande </li>
                </ul>
                <p style="font-size: 13px; color: #1F2028; font-weight: bold; letter-spacing: 1.04px; margin-top: 25px;">PARA AGILIZAR TU PROCESO, FAVOR DE TRAER LOS SIGUIENTES <span style="color: #071BCE;">DOCUMENTOS:</span></p>
                <ul style="margin-left: -26px;">
                    <li style="margin-bottom: 5px;">Copia de Acta de Nacimiento.</li>
                    <li style="margin-bottom: 5px;">Copia de Identificación Oficial (ambos lados).</li>
                    <li style="margin-bottom: 5px;">Copia de Comprobante de Domicilio.</li>
                    <li style="margin-bottom: 5px;">Copia del Certificado de Preparatoria o Carrera Técnica</li>
                    <li style="margin-bottom: 5px;">Copia de Acta de No Antecedentes penales (no mayor a 3 meses).</li>
                    <li style="margin-bottom: 5px;">Copia del Comprobante de Numero de Seguro Social.</li>
                    <li style="margin-bottom: 5px;">Copia de Constancia de Situación Fiscal (RFC). *De no tener acceso, preséntate directamente a las oficinas del SAT, ubicada en Calzada Cetys, con tu INE y sin cita, te lo entregan inmediatamente.</li>
                    <li style="margin-bottom: 5px;">Copia del CURP.</li>
                    <li style="margin-bottom: 5px;">Copia de Acta de Matrimonio (si aplica).</li>
                    <li style="margin-bottom: 5px;">Copia de Acta de Nacimiento de Hijos (si aplica).</li>
                </ul>
                <p><b>Ingresa a las páginas oficiales y genera el formato actualizado:</b></p>
                <a href="https://serviciosdigitales.imss.gob.mx/gestionAsegurados-web-externo/asignacionNSS;JSESSIONIDASEGEXTERNO=dDpGBR25zBYgORc00i8Pgwkfm5Zq4UK2pxwYgTiE9pp3e0rTk08X!-1779875599" style="color: #071BCE; margin-right: 25px;">NSS</a> 
                <a href="https://www.sat.gob.mx/aplicacion/53027/genera-tu-constancia-de-situacion-fiscal" style="color: #071BCE; margin-right: 25px;">RFC</a> 
                <a href="https://www.gob.mx/curp/" style="color: #071BCE; margin-right: 25px;">CURP</a>
                    <p style="font-size: 13px; color: #1F2028; font-weight: bold; letter-spacing: 1.04px; margin-top: 25px;">CÓDIGO DE VESTIMENTA:</p>
                    <ul style="margin-left: -26px;">
                        <li style="margin-bottom: 5px;">Cualquier tipo de zapato cerrado, sin tacón.</li>
                        <li style="margin-bottom: 5px;">No shorts, no falda.</li>
                        <li style="margin-bottom: 5px;">No ropa sin manga.</li>
                        <li style="margin-bottom: 5px;">No pantalones rotos y/o rasgados.</li>
                    </ul>
            </div>

            <p style="font-size: 12px; margin-bottom: 24px;">
                Favor de no responder este correo, si requieres más información puedes comunicarte a reclutamiento@intusurg.com
            </p>
            
        </div>
        <div style="width: 100%; max-width: 568px; font-family: sans-serif; margin: auto;  color: #15375F; text-align: center; padding: 24px 0px;">
            <p style="font-size: 15px; color:#8592A6; margin: 24px 0px;">© 2017-{{date('Y')}} atraetalento.com</p>
        </div>
    </body>
</html>