<!DOCTYPE html>
<html>
    <head>
        <title>Intuitive | Registro exitoso</title>
    </head>
    <body style="background-color: #f6f6f6;">
        <div style="width: 100%; margin: 20px auto 0px; max-width: 568px; font-family: Calibri, Roboto, sans-serif; background-color: #1F2028; text-align: left; padding: 25px 30px;">
            <img src="{{url('images/logoemail.png')}}" alt="Intuitive" border="0" style="border: 0; outline: none; text-decoration: none;">
        </div>
        <div style="width: 100%; max-width: 568px; margin: auto; font-family: Calibri, Roboto, sans-serif; color: #85868C; text-align: left; padding: 30px; background-color: #fff;">
            <p style="font-size: 20px; font-weight: 700; margin-bottom: 24px; color: #071BCE; letter-spacing: 1.6px;">¡FELICIDADES, {{$subscriber->full_name}}!</p>
            <p style="font-size: 16px; margin-bottom: 24px;">
                Has completado satisfactoriamente el formulario de evaluación, ahora <b>te invitamos a seleccionar el día y hora en el que te gustaría realizar el proceso de reclutamiento.</b>
            </p>
            <p>Tu folio de registro es: <b style="color: #1F2028; letter-spacing: 1.04px; font-size: 14px;">{{$subscriber->folio_number}}</b></p>
            <table cellspacing="0" cellpadding="0" style="width: 100%;">
                <tr>
                    <td align="left">
                        <!--[if mso]>
                        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{url('citas/crear')}}" style="height:34px;v-text-anchor:middle;width:240px;" arcsize="10%" stroke="f" fillcolor="#071BCE">
                            <w:anchorlock/>
                            <center style="color:#ffffff;font-family:sans-serif, roboto; font-size:14px;font-weight:bold; letter-spacing: 1.6px;">
                                AGENDAR CITA
                            </center>
                        </v:roundrect>
                        <![endif]-->
                        <![if !mso]>
                        <table cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" width="240" height="34" bgcolor="#071BCE"
                                    style="-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #ffffff; display: block;">
                                    <a href="{{url('citas/crear')}}" style="font-size: 14px; font-weight: bold; letter-spacing: 1.6px; font-family: Calibri, Roboto, sans-serif; text-decoration: none; line-height: 34px; width:100%; display: inline-block">
                                        <span style="color: #ffffff;">
                                            AGENDAR CITA 
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <![endif]>
                    </td>
                </tr>
            </table>
            <p style="font-size: 14px; color: #1F2028; font-weight: bold; letter-spacing: 1.04px;">SI YA AGENDASTE TU CITA, NO ES NECESARIO QUE LO HAGAS DE NUEVO</p>

            <p style="font-size: 12px; margin-bottom: 24px;">
                Favor de no responder este correo, si requieres más información puedes comunicarte a reclutamiento@intusurg.com
            </p>
        </div>
        <div style="width: 100%; max-width: 568px; font-family: Calibri, Roboto, sans-serif; margin: auto;  color: #15375F; text-align: center; padding: 24px 0px;">
            <p style="font-size: 15px; color:#8592A6; margin: 24px 0px;">© 2017 - {{date('Y')}} atraetalento.com</p>
        </div>
    </body>
</html>