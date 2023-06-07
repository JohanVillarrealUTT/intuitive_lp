<!DOCTYPE html>
<html>
    <head>
        <title>Intuitive | recordatorio para tu entrevista</title>
    </head>
    <body style="background-color: #f6f6f6;">
        <div style="width: 100%; margin: 20px auto 0px; max-width: 568px; font-family: Calibri, Roboto, sans-serif; background-color: #1F2028; text-align: left; padding: 25px 30px;">
            <img src="{{url('images/logoemail.png')}}" alt="Intuitive" border="0" style="border: 0; outline: none; text-decoration: none;">
        </div>
        <div style="width: 100%; max-width: 568px; margin: auto; font-family: Calibri, Roboto, sans-serif; color: #85868C; text-align: left; padding: 30px; background-color: #fff;">
            <p style="font-size: 20px; font-weight: 700; margin-bottom: 24px; color: #071BCE; letter-spacing: 1.6px;">¡HOLA, {{$subscriber->full_name}}!</p>
            <p style="font-size: 16px; margin-bottom: 24px;">
                {{$textMessage}}
            </p>
            <p>Estos son los detalles de tu cita:</p>
            <div style="background-color: #F3F3F3; border-radius: 10px; padding: 20px 30px; color: #1F2028;">
                <p><img src="{{url('images/icon-1.png')}}" style="margin-right: 10px;">{{  translateEsDate(Carbon\Carbon::createFromFormat('Y-m-d', $appointment->date->date)) }}</p>
                <p><img src="{{url('images/icon-2.png')}}" style="margin-right: 10px;">{{$appointment->hour}}</p>
                <p><img src="{{url('images/icon-3.png')}}" style="margin-right: 10px;">Calzada Venustiano Carranza 1745<br>
                    <span style="padding-left: 20px;">Colonia sin asignación</span> <br>
                    <span style="padding-left: 20px;">entre calles Blvd. lázaro cárdenas y Calle palmar de santa anita  CP 21226</span>
                    <span style="padding-left: 20px;">Mexicali, B.C.</span></p>
                <a href="https://www.google.com/maps/place/Intuitive+Surgical+Blvd.+Venustiano+Carranza/@32.6225935,-115.3996659,15z/data=!4m9!1m2!2m1!1sintuitive+surgical!3m5!1s0x0:0x46ca82a75a2a02ec!8m2!3d32.625534!4d-115.3979492!15sChJpbnR1aXRpdmUgc3VyZ2ljYWySAQxtYW51ZmFjdHVyZXI" style="color: #071BCE; padding-left: 20px;">Ver mapa</a>
            </div>
        </div>
        
        <p style="font-size: 12px; margin-bottom: 24px;">
            Favor de no responder este correo, si requieres más información puedes comunicarte a reclutamiento@intusurg.com
        </p>

        <div style="width: 100%; max-width: 568px; font-family: Calibri, Roboto, sans-serif; margin: auto;  color: #15375F; text-align: center; padding: 24px 0px;">
            <p style="font-size: 15px; color:#8592A6; margin: 24px 0px;">© 2021 atraetalento.com</p>
        </div>
    </body>
</html>