<?php

namespace Hcode;

use \Hcode\PHPMailer\PHPMailer;
use \Hcode\PHPMailer\SMTP;

class EnviarEmail {

	public function enviar(){

		# Inicia a classe PHPMailer
		$mail = new PHPMailer();

		# Define os dados do servidor e tipo de conexão
		$mail->IsSMTP(); // Define que a mensagem será SMTP
		$mail->SMTPDebug = 2;
		$mail->SMTPSecure = 'tls';
		$mail->Host = 'smtp.gmail.com'; # Endereço do servidor SMTP
		$mail->Port = 587; // Porta TCP para a conexão
		$mail->SMTPAutoTLS = false; // Utiliza TLS Automaticamente se disponível
		$mail->SMTPAuth = true; # Usar autenticação SMTP - Sim
		$mail->Username = 'testesistema1314@gmail.com'; # Usuário de e-mail
		$mail->Password = '12589633'; // # Senha do usuário de e-mail

		# Define o remetente (você)
		$mail->setFrom("testesistema1314@gmail.com", 'Gustavo Chaves'); # Seu e-mail e seu nome

		# Define os destinatário(s)
		$mail->AddAddress('gustavo.chaves@bebefofuxo.com.br', 'Gustavowww'); # Os campos podem ser substituidos por variáveis
		#$mail->AddAddress('webmaster@nomedoseudominio.com'); # Caso queira receber uma copia
		#$mail->AddCC('ciclano@site.net', 'Ciclano'); # Copia
		#$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); # Cópia Oculta

		# Define os dados técnicos da Mensagem
		$mail->IsHTML(true); # Define que o e-mail será enviado como HTML
		#$mail->CharSet = 'iso-8859-1'; # Charset da mensagem (opcional)

		# Define a mensagem (Texto e Assunto)
		$mail->Subject = "Mensagem Teste"; # Assunto da mensagem
		$mail->Body = "Olá Gustavo, esse e-mail foi enviado Automaticamente do sistema de contagem :)";
		$mail->AltBody = "Este é o corpo da mensagem de teste, somente Texto! \r\n :)";

		# Define os anexos (opcional)
		#$mail->AddAttachment("c:/temp/documento.pdf", "documento.pdf"); # Insere um anexo

		# Envia o e-mail
		$enviado = $mail->Send();

		# Limpa os destinatários e os anexos
		$mail->ClearAllRecipients();
		$mail->ClearAttachments();

		# Exibe uma mensagem de resultado (opcional)
		if ($enviado) {

		 echo "E-mail enviado com sucesso!";

		} else {
		 
		 echo "Não foi possível enviar o e-mail.";
		 
		 echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;

		}
	}
}

?>