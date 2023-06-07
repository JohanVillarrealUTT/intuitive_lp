<!DOCTYPE html>
<html>
    <head>
        <title>Intuitive | Cita confirmada</title>
    </head>
    <body style="background-color: #f6f6f6;">
        <div style="width: 100%; margin: 20px auto 0px; max-width: 568px; font-family: Calibri, Roboto, sans-serif; background-color: #1F2028; text-align: left; padding: 25px 30px;">
            <img src="{{url('images/logoemail.png')}}" alt="Intuitive" border="0" style="border: 0; outline: none; text-decoration: none;">
        </div>
        <div style="width: 100%; max-width: 568px; margin: auto; font-family: Calibri, Roboto, sans-serif; color: #85868C; text-align: left; padding: 30px; background-color: #fff;">
            <p style="font-size: 20px; font-weight: 700; margin-bottom: 24px; color: #071BCE; letter-spacing: 1.6px;">CITA AGENDADA</p>
            <p style="font-size: 16px; margin-bottom: 24px;">
                Hola {{$subscriber->full_name}},  has completado satisfactoriamente el formulario de evaluación. <br><br>
               <b>Recuerda presentarte a nuestra ¡GRAN FERIA DE EMPLEO!</b> 
            </p>
            <div style="background-color: #F3F3F3; border-radius: 10px; padding: 20px 30px; color: #1F2028;">
                <p><img src="{{url('images/icon-1.png')}}" style="margin-right: 10px;">Sábado 19 de Febrero 2022</p>
                <p><img src="{{url('images/icon-2.png')}}" style="margin-right: 10px;">A partir de 6:00 am a 11:00 am</p>
                <p><img src="{{url('images/icon-3.png')}}" style="margin-right: 10px;">Parque Industrial Nelson #8<br>
                    <span style="padding-left: 20px;">Col. González Ortega 21395</span> <br>
                    <span style="padding-left: 20px;">Mexicali B.C (a un lado de acccuride)</span>
            </div>
            <div style="border: 1px solid #F3F3F3; border-radius: 10px; padding: 20px 30px; color: #85868C; margin-top: 20px">
                <p style="font-size: 13px; color: #1F2028; font-weight: bold; letter-spacing: 1.04px;"> <span style="color: #071BCE;">¿QUÉ TIENES QUE TRAER?</span></p>
                <ul style="margin-left: -26px;">
                    <li style="margin-bottom: 5px;"><b> Cubre bocas</b></li>
                    <li style="margin-bottom: 5px;"><b>Documentación en copias</b></li>
                </ul>
                <p style="font-size: 13px; color: #1F2028; font-weight: bold; letter-spacing: 1.04px; margin-top: 25px;"> <span style="color: #071BCE;">DOCUMENTOS:</span></p>
                <ul style="margin-left: -26px;">
                    <li style="margin-bottom: 5px;">Copia de Acta de Nacimiento.</li>
                    <li style="margin-bottom: 5px;">Copia de Identificación Oficial  (ambos lados).</li>
                    <li style="margin-bottom: 5px;">Copia de Comprobante de Domicilio (Reciente).</li>
                    <li style="margin-bottom: 5px;">Copia del Certificado de Preparatoria o Carrera Técnica (como grado académico mínimo)</li>
                    <li style="margin-bottom: 5px;">Copia de Acta de No Antecedentes penales (no más de 3 meses). (se pide al ser seleccionado)</li>
                    <li style="margin-bottom: 5px;">Copia del Comprobante de Numero de Seguro Social.</li>
                    <li style="margin-bottom: 5px;">RFC (emitido por SAT). *Si no lo tienes, por el momento puedes entregar una copia de un recibo de nómina timbrado.</li>
                    <li style="margin-bottom: 5px;">Copia del CURP.</li>
                    <li style="margin-bottom: 5px;">Copia de Acta de Matrimonio (si aplica).</li>
                    <li style="margin-bottom: 5px;">Copia de Acta de Nacimiento de Hijos (si aplica).</li>
                </ul>
                <p><b>Ingresa a las páginas oficiales y genera el formato actualizado:</b></p>
                <a href="https://citas.ebajacalifornia.gob.mx/">Acta de No Antecedentes penales  </a> 
                <a href="http://www.imss.gob.mx/tramites/imss02008" style="color: #071BCE; margin-right: 25px;">NSS</a> 
                <a href="https://www.sat.gob.mx/tramites/28753/obten-tu-rfc-con-la-clave-unica-de-registro-de-poblacion-curp" style="color: #071BCE; margin-right: 25px;">RFC</a> 
                <a href="https://www.gob.mx/curp/" style="color: #071BCE; margin-right: 25px;">CURP</a>

                <br><br>
                <img src="{{url('images/mapaParqueNelson.jpg')}}" alt="direccion">
               
            </div>

            <p style="font-size: 12px; margin-bottom: 24px;">
                Favor de no responder este correo, si requieres más información puedes comunicarte a reclutamiento@intusurg.com
            </p>
        </div>
        <div style="width: 100%; max-width: 568px; font-family: sans-serif, roboto; margin: auto;  color: #15375F; text-align: center; padding: 24px 0px;">
            <p style="font-size: 15px; color:#8592A6; margin: 24px 0px;">© 2017-{{date('Y')}} atraetalento.com</p>
        </div>
    </body>
</html>