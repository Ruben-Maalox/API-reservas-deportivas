<?php

namespace App\Service;

use App\Entity\Reserva;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;


class EmailService {
  public function sendEmail(string $sendTo, string $subject, string $body) {
    try {
      $transport = Transport::fromDsn($_ENV['MAILER_DSN']); // Tenemos que poner en .env esta variable: MAILER_DSN=smtp://letsmove.murcia@gmail.com:PASSWORD@smtp.gmail.com:587 (Password está en el drive)
      $mailer = new Mailer($transport);

      // Crear el correo electrónico
      $email = (new Email())
        ->from('letsmove.murcia@gmail.com')
        ->to($sendTo)
        ->subject($subject)
        ->html($body);

      $mailer->send($email);
    } catch (\Exception $e) {

    }
  }

  public function sendRegistrationEmail(string $sendTo, string $urlVerification) {
    $body = "
                <h1>¡Bienvenido a LetsMove!</h1>
                <p>¡Gracias por registrarte en nuestro sitio!</p>
                <p>Estamos emocionados de tenerte con nosotros. Aquí podrás encontrar las mejores actividades deportivas en tu área.</p>
                <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
                <p>¡Disfruta de LetsMove!</p>
                <p>Verifica tu cuenta en: {$urlVerification}</p>
            ";
    $subject = '¡Bienvenido a LetsMove!';
    $this->sendEmail($sendTo, $subject, $body);
  }

  public function sendUpdateReservationEmail(string $sendTo, Reserva $reserva) {
    $body = "
                <h1>¡Su reserva del día <b>{$reserva->getFechaYHora()->format('Y-m-d H:i')}</b> ha sufrido cambios!</h1>
                <p>Para más información vaya a nuestra web</p>
                <p>Lamentamos las molestias.</p>

            ";
    $subject = '¡Reserva modificada!';
    $this->sendEmail($sendTo, $subject, $body);
  }
}