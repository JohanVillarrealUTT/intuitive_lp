<template>
	<modal :show-modal="show_modal" :max-width="'880px'">
		<modal-wrap>
			<div class="close-button-wrap" >
                <grey-link @click="emitCloseModal">Cerrar</grey-link>
            </div>
			<h2>Términos y condiciones</h2>

			<p>
				El presente aviso se entrega en cumplimiento a las disposiciones aplicables de la Ley Federal de Protección de Datos Personales en posesión de Particulares ("Ley de Datos Personales"), basado en el principio de buena fe entre las partes.
			</p>
			
		
			<p>
				<b>Identidad del Responsable</b> <br>
				Morzan Corporation, S.A. de C.V. ("MORZAN") es una sociedad Mercantil constituida de conformidad con las leyes de los Estados Unidos Mexicanos. Tiene su domicilio en Calle Anáhuac  No. 62 Segundo Piso., Col. Fortín de las Flores, Tijuana Baja California ,22114  México.
			</p>
			<p>
				<b>Datos Personales</b> <br>
				La Sociedad recabará del Titular los Datos Personales, toda la información necesaria para la prestación de los servicios acorde a la Finalidad según término se define más adelante, entendiéndose por Datos Personales lo siguiente:
				Datos Personales: Cualquier información concerniente a una persona física identificada o identificable, incluyendo de manera enunciativa más no limitativa: (i) nombre completo, (ii) edad o fecha de nacimiento, (iii) lugar de nacimiento, (iv) actividad, profesión, ocupación u oficio (v) domicilio particular, (vi) número telefónico, (vii) correo electrónico, entre otros. Se presume que aquella persona que proporciona Datos Personales a MORZAN, es la titular de los mismos                    
			</p>
			<p>
				<b>Finalidad del Tratamiento de Datos</b> <br>
				La finalidad del tratamiento de los Datos Personales será, según el caso: 
				<ul type="a">
					<li>Brindarle un mejor servicio al atenderlo;</li>
					<li>Conocer sus necesidades de productos o servicios y estar en posibilidad de ofrecerle los que más se adecuen a sus preferencias;</li>
					<li>Comunicarle promociones, y/o descuentos especiales;</li>
					<li>Obtener datos de contacto en general;</li>
					<li>Atender quejas, aclaraciones y sugerencias, en caso de formalizar con Usted la aceptación de algún producto o servicio ofrecido por MORZAN, sus Datos serán utilizados para el cumplimiento de las obligaciones derivadas de esa relación jurídica. Así como para otros fines compatibles con los mencionados en este Aviso de Privacidad y que se consideren análogos para efectos legales.</li>
				</ul> 
			</p>
			<p>
				<b>Derechos para limitar el uso o divulgación de los Datos Personales</b> <br>
				MORZAN manifiesta que cuenta con las medidas de seguridad suficientes para la protección, confidencialidad y aseguramiento de los Datos Personales del Titular, a efectos de restringir el acceso a los mismos a personas no autorizadas así como el tratamiento de los Datos Personales en contravención a lo estipulado en el presente Aviso de Privacidad. MORZAN conviene en informar a sus empleados, representantes, subcontratistas o consultores que puedan tener acceso o recibir de MORZAN los Datos Personales del Titular para su tratamiento, de todas las obligaciones que tienen respecto de la protección de los Datos Personales del Titular, de conformidad con lo previsto en este Aviso de Privacidad y la legislación aplicable vigente.
				MORZAN, sus empleados, representantes, subcontratistas, consultores y/o los terceros que intervengan en cualquier fase del tratamiento de los Datos Personales del Titular deberán guardar confidencialidad respecto de éstos, obligación que subsistirá aún después de finalizar la relación entre MORZAN y el Titular.
				Teniendo en consideración que MORZAN la información que el Titular pueda suministrar, podrá ser transmitida, utilizada, guardada o procesada en un país diferente de donde suministró dicha información.
				Los Datos Personales serán tratados de conformidad con la Ley Federal de Protección de Datos Personales en Posesión de los Particulares y su Reglamento (cuando este sea expedido). La confidencialidad de los Datos está garantizada y los mismos están protegidos por medidas de seguridad administrativas, técnicas y físicas, para evitar su daño, pérdida, alteración, destrucción, uso, acceso o divulgación indebida. Únicamente las personas autorizadas tendrán acceso a sus Datos.
			</p>
			<p>
				<b>Almacenamiento de Datos Personales</b> <br>
				Los Datos Personales se almacenan en una o más bases de datos temporales o definitivas por el tiempo necesarias para el cumplimiento de los contratos que se tengan celebrados y de las responsabilidades nacidas de los mismos en tanto no exista disposición legal o mandato judicial en otro sentido, o el Titular no solicite expresamente la cancelación de los Datos Personales siempre que ésta proceda en términos de la LEY DE DATOS PERSONALES. La información contenida en esas bases de datos también podrá ser consultada por otras compañías del grupo Premium para diferentes propósitos, relacionados con los especificados en el capítulo de la “Finalidad".
			</p>
			<p>
				<b>Medios para ejercer los Derechos ARCO</b> <br>
				De conformidad con la LEY DE DATOS PERSONALES, en cualquier momento a partir el 6 de enero de 2012, el Titular tendrá derecho a ejercer sus derechos de acceso, rectificación, cancelación y oposición (Derechos ARCO) respecto de sus Datos Personales directamente ante MORZAN, mediante solicitud enviada al siguiente correo electrónico: <i><u>protecciondatospersonales@morzan.com</u></i>, indicando lo siguiente:
					<ul type="i">
						<li>Nombre del titular y domicilio u otro medio para comunicarle la respuesta a su solicitud;</li>
						<li>Documentos que acrediten la identidad o en su caso la representación legal del Titular;</li>
						<li>Descripción clara y precisa de los Datos Personales respecto de los que se busca ejercer cualquiera de los derechos ARCO;</li>
						<li>y Cualquier otro elemento o documento que facilite la localización de los Datos Personales del Titular.</li>
					</ul>
					En caso de que alguno de los Datos Personales del Titular sea inexacto o incompleto, el Titular además de indicar lo señalado anteriormente deberá señalar las modificaciones a realizarse y aportar la documentación necesaria que sustente su petición. El Titular puede solicitar que se cancelen o supriman los Datos Personales que MORZAN conserve en su expediente una vez concluidos los servicios prestados, mediante el acceso vínculo web y link previamente señalados. De ejercer el Titular el derecho a la oposición en el tratamiento de los Datos Personales por parte de MORZAN a través del procedimiento en este apartado previsto y de resultar procedente la misma, MORZAN no podrá tratar dichos datos, hasta en tanto el Titular no autorice de nueva cuenta su tratamiento.
			</p>
			<p>
				<b>Transferencia de Datos</b> <br>
				MORZAN podrá transmitir los Datos Personales para la prestación de los Servicios objeto de este Contrato dentro e incluso fuera de la República Mexicana y los podrá transferir a las siguientes entidades:
				<ul type="a">
					<li>Compañías Afiliadas MORZAN podrá transmitir sus Datos Personales a aquellas sociedades que forman parte de su grupo corporativo (incluyendo en forma enunciativa, más no limitativa, empresas subsidiarias y filiales que presten servicios en nombre de MORZAN).</li>
					<li>Terceros no Afiliados MORZAN podrá transmitir sus Datos Personales a aquellos terceros no afiliados prestadores de servicios con el propósito de que éstos asistan en la prestación de servicios establecidos en el contrato que celebren MORZAN y usted.</li>
					<li>Socios Comerciales MORZAN podrá transmitir sus Datos Personales a sus Socios Comerciales con el propósito de que dichos Socios lo contacten para ofrecerle productos y servicios.</li>
				</ul>
				MORZAN manifiesta que ha tomado medidas razonables, necesarias y a su alcance para proteger los datos personales contra daño, pérdida, alteración, destrucción o el uso, acceso o tratamiento no autorizado. El acceso a esta información se limita a las personas que deben de conocerla para cumplir con el objeto de su trabajo.
			</p>
			<p>
				<b>Consentimiento</b> <br>
				El Titular consiente, en proporcionar sus Datos Personales en la forma y para los fines señalados en este aviso y que los mismos sean transmitidos a clientes y/o cualquier otro proveedor, única y exclusivamente para la prestación de los servicios que ofrece MORZAN. En términos de la legislación vigente, se entenderá que el titular consiente tácitamente el tratamiento de sus datos, cuando puesto a su disposición el presente aviso de publicidad no manifieste su oposición.
			</p>
			<p>
				<b>Cambios al Aviso de Privacidad</b> <br>
				MORZAN se reserva el derecho de modificar y/o cambiar el presente Aviso de Privacidad en cualquier momento, por lo que cualquier cambio o modificación que se realice al Aviso de Privacidad se hará del conocimiento del Titular a través de ésta misma página web, o al correo electrónico a la dirección que para tales efectos proporcione y mantenga registrado.
				
			</p>

			<p>
				<small><i>(Última fecha de actualización: 30 de junio de 2012).</i></small>
			</p>

			<p-button @click="emitAccept($event)">Cerrar y aceptar</p-button>


		</modal-wrap>
	</modal>
</template>

<script>
	import modal from '@/components/website/LandingModalWindow.vue'
	import variables from '@/config/website/WebsiteVariables.js'
	import {ModalContentWrap as wrap, GreyLink, ButtonPrimary} from '@/config/website/BaseConstants.vue'
	import styled from 'vue-emotion'
	// import pButton from '@/components/website/ButtonPrimary.vue'
	import {EventBus} from '@/event-bus.js' 

	const ModalWrap = styled(wrap)`
		font-size: 1rem;
        line-height: 1.5rem;

		.close-button-wrap {
            text-align: right;
        }


		> h, p, ul, li {
			margin-bottom: 2rem;
		}
	`

	const PButton = styled(ButtonPrimary)`
		width: 100%;
	`

	export default {
		props: ['show_modal'], 

		name: 'TermsAndConditionsModal',

		components: {
			modal,
			ModalWrap,
			GreyLink,
			PButton,
		},

		methods: {
			emitAccept(event) {
				event.preventDefault()
				EventBus.$emit('closeAndAcceptTerms')
			},
			
            emitCloseModal() {
                EventBus.$emit('closeTerms')
            }

		}

	}
</script>