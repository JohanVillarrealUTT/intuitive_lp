<!DOCTYPE html>
<html>
    <head>
        <title>Intuitive | Tu cita fue cancelada</title>
    </head>
    <body style="background-color: #f6f6f6;">
        <div style="width: 100%; margin: 20px auto 0px; max-width: 568px; font-family: Calibri, Roboto, sans-serif; background-color: #1F2028; text-align: left; padding: 25px 30px;">
            <img src="{{url('images/logoemail.png')}}" alt="Intuitive" border="0" style="border: 0; outline: none; text-decoration: none;">
        </div>
        <div style="width: 100%; max-width: 568px; margin: auto; font-family: Calibri, Roboto, sans-serif; color: #85868C; text-align: left; padding: 30px; background-color: #fff;">
            <p style="font-size: 20px; font-weight: 700; margin-bottom: 24px; color: #071BCE; letter-spacing: 1.6px;">CITA CANCELADA</p>
            <p style="font-size: 16px; margin-bottom: 15px;">Lo sentimos, INTUITIVE canceló la fecha {{$appointment}} para entrevistas.</p>
            <p style="font-size: 16px; margin-bottom: 24px;">Si deseas continuar el proceso de reclutamiento, te invitamos a seleccionar una nueva fecha y hora para entrevista.</p>
            <a href="{{url('citas')}}" style="color: #071BCE;">Agendar cita</a>
        </div>

        <p style="font-size: 12px; margin-bottom: 24px;">
            Favor de no responder este correo, si requieres más información puedes comunicarte a reclutamiento@intusurg.com
        </p>

        
        <div style="width: 100%; max-width: 568px; font-family: sans-serif; margin: auto;  color: #15375F; text-align: center; padding: 24px 0px;">
            <p style="font-size: 15px; color:#8592A6; margin: 24px 0px;">© 2017-{{date('Y')}} atraetalento.com</p>
        </div>
    </body>
</html>